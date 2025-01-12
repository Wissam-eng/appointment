<?php

namespace App\Http\Controllers;

use App\Models\categorys;
use Illuminate\Support\Facades\DB;
use App\Models\stock;

use Illuminate\Support\Facades\Auth;
use App\Models\Facility;
use Illuminate\Http\Request;

class StockController extends Controller
{
    // Other methods remain unchanged...

    public function index()
    {
        $stocks = stock::where('facility_id', session('facility_id'))->get();
        return view('stock.index', compact('stocks'));
    }



    public function create()
    {
        if (Auth::user()->user_type == 2) {
            $categories = Categorys::where('facility_id', session('facility_id'))->get();
        } else {
            $categories = Categorys::all();
        }


        return view('stock.create')->with('categories', $categories);
    }


    public function store(Request $request)
    {
        try {
            $requestData = $request->except('product_img');

            if ($request->hasFile('product_img')) {
                $file = $request->file('product_img');
                $path_file = $file->store('images/products', 'public');
                $requestData['product_img'] = '/storage/' . $path_file;
            }

            Stock::create($requestData);

            return redirect()->route('stock.index')->with('success', 'Product added to stock successfully.');
        } catch (\Exception $e) {
            return redirect()->route('stock.index')->with('error', 'An error occurred while adding the product: ' . $e->getMessage());
        }
    }


    public function show(Stock $stock)
    {
        $categories = Categorys::all();
        return view('stock.show', compact('stock', 'categories'));
    }

    public function edit(Stock $stock)
    {
        $categories = categorys::all();
        return view('stock.edit', compact('stock', 'categories'));
    }







    public function update(Request $request, $id)
    {


        $stock = Stock::find($id);
        if (!$stock) {
            return response()->json(['success' => false, 'message' => 'Stock not found'], 404);
        }

        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'note' => 'nullable|string|max:1000',
            'qty' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'exp_date' => 'required|date|after:today',
            'product_type' => 'nullable|integer',
            'facility_id' => 'required|integer|exists:facilities,id',
            'category_id' => 'required|integer|exists:categorys,id',
        ]);

        $inputs = $request->except('product_img');

        if ($request->hasFile('product_img')) {
            if ($stock->product_img) {
                $oldImagePath = public_path($stock->product_img);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $file = $request->file('product_img');
            $filePath = $file->store('images/products', 'public');
            $inputs['product_img'] = '/storage/' . $filePath;
        }

        $updated = $stock->update($inputs);

        if ($updated) {
            return redirect()->route('stock.index')->with('flash_message', 'stock updated successfully!');
        } else {
            return redirect()->back()->with('flash_message', 'stock update failed, no rows affected.');
        }
    }








    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stock.index')->with('success', 'Product removed from stock successfully.');
    }


    public function delete($id)
    {


        $Stock = Stock::withTrashed()->find($id);
        if ($Stock) {
            $Stock->forceDelete();
        }
        return redirect()->back()->with('success', 'product deleted permanently.');
    }


    public function trash()
    {
        $stock_deleted = stock::onlyTrashed()->get();
        // $doctor_deleted = Doctors::onlyTrashed()->with('specialization')->get();

        return view('stock.trash')->with('stock_deleted', $stock_deleted);
    }

    public function restore($id)
    {
        $stock = Stock::withTrashed()->findOrFail($id);
        $stock->restore();

        return redirect()->route('stock.index')->with('success', 'stock restored successfully.');
    }





    //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


    // API Methods
    public function index_api($id)
    {

        $stock = stock::where('facility_id', $id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Stocks retrieved successfully',
            'stock' => $stock
        ]);
    }



    public function prodcut_facility(Request $request)
    {
        $facility_type = $request->facility_type;
        if ($facility_type) {
          
            $facilities = Facility::with('categories.products')->where('facility_type', $facility_type)->get(); // Eager load products under categories
         
        }else{
            $facilities = Facility::with('categories.products')->whereIn('facility_type', [4, 5])->get();
        }
        
        $result = [];
        foreach ($facilities as $facility) {
            $categories = [];
    
            foreach ($facility->categories as $category) {
                $products = [];
    
                // Check if $category->products is not null
                if (!empty($category->products)) {
                    foreach ($category->products as $product) {
                        $products[] = [
                            'product_id' => $product->id,
                            'product_name' => $product->product_name,
                            'product_img' => $product->product_img,
                            'price' => $product->price,
                            'quantity' => $product->qty ?? 0,
                        ];
                    }
                }
    
                $categories[] = [
                    'category_id' => $category->id,
                    'img' => $category->img,
                    'category_name' => $category->category_name,
                    'products' => $products,
                ];
            }
    
            $result[] = [
                'facility_id' => $facility->id,
                'views' => $facility->views,
                'Arrival_time' => $facility->Arrival_time,
                'facility_name' => $facility->name,
                'address' => $facility->address,
                'profile_pic' => $facility->profile_pic,
                'categories' => $categories,
            ];
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Facilities and their products retrieved successfully',
            'data' => $result,
        ]);
    }
    





    public function store_api(Request $request)
    {
        $requestData = $request->except('product_img');

        if ($request->hasFile('product_img')) {
            $file = $request->file('product_img');
            $path_file = $file->store('images', 'public');
            $requestData['product_img'] = '/storage/' . $path_file;
        }

        $stock = Stock::create($requestData);
        return response()->json([
            'success' => true,
            'message' => 'Product added to stock successfully',
            'stock' => $stock
        ]);
    }

    public function show_api($id)
    {
        $stock = stock::find($id);
        if (!$stock) {
            return response()->json(['success' => false, 'message' => 'Stock not found'], 404);
        }
        return response()->json(['success' => true, 'stock' => $stock]);
    }

    public function update_api(Request $request, $id)
    {
        $stock = stock::find($id);
        if (!$stock) {
            return response()->json(['success' => false, 'message' => 'Stock not found'], 404);
        }

        $requestData = $request->except('product_img');

        if ($request->hasFile('product_img')) {
            $file = $request->file('product_img');
            $path_file = $file->store('images', 'public');
            $requestData['product_img'] = '/storage/' . $path_file;
        }

        $stock->update($requestData);
        return response()->json(['success' => true, 'message' => 'Product updated successfully', 'stock' => $stock]);
    }

    public function destroy_api($id)
    {
        $stock = stock::find($id);
        if (!$stock) {
            return response()->json(['success' => false, 'message' => 'Stock not found'], 404);
        }
        $stock->delete();
        return response()->json(['success' => true, 'message' => 'Product removed from stock successfully']);
    }



    // Restore a soft-deleted stock item
    public function restore_api($id)
    {
        $stock = stock::withTrashed()->find($id);
        if (!$stock) {
            return response()->json(['success' => false, 'message' => 'Stock not found'], 404);
        }
        $stock->restore();
        return response()->json(['success' => true, 'message' => 'Product restored successfully', 'stock' => $stock]);
    }




    public function trash_api()
    {
        $products_deleted = stock::onlyTrashed()->get();
        return response()->json(['success' => true, 'products_deleted' => $products_deleted]);
    }



    // Force delete a stock item (permanent deletion)
    public function delete_api($id)
    {
        $stock = stock::withTrashed()->find($id);
        if (!$stock) {
            return response()->json(['success' => false, 'message' => 'Stock not found'], 404);
        }
        $stock->forceDelete();
        return response()->json(['success' => true, 'message' => 'Product permanently deleted from stock']);
    }
}
