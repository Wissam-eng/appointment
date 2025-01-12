<?php

namespace App\Http\Controllers;
use Illuminate\Support\Arr;
use App\Models\cart;
use App\Models\User;
use App\Models\stock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function __construct()
    {

        // Middleware for Web routes
        $this->middleware('auth');
        $this->middleware('log', ['only' => ['fooAction', 'barAction']]);
        $this->middleware('subscribed', ['except' => ['fooAction', 'barAction']]);
    }


    public function index()
    {

        $id = session('facility_id');




        $orders = Cart::with('user', 'stock', 'facility')->where('facility_id', $id)->get();

        return view('cart.index', compact('orders'));
    }






    public function store(Request $request)
    {

        cart::create($request->all());

        return redirect('cart')->with('flash_message', 'Doctor_added');
    }


    public function show($id)
    {


        $cart = cart::find($id);

        return view('cart.show', compact('cart'));
    }






    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {


        $cart = cart::where('id', $id)->with(['Facility', 'stock'])->first();


        return view('cart.edit', compact('cart'));
    }


    public function trash()
    {
        $cart_deleted = cart::with(['Facility', 'stock'])->onlyTrashed()->get();

        return view('cart.trash')->with('cart_deleted', $cart_deleted);
    }







    public function restore($id)
    {
        $cart = cart::withTrashed()->findOrFail($id);
        $cart->restore();

        return redirect()->route('cart.index')->with('success', 'Doctor restored successfully.');
    }





    public function delete($id)
    {


        $cart = cart::withTrashed()->find($id);
        if ($cart) {
            $cart->forceDelete();
        }
        return redirect()->back()->with('success', 'Doctor deleted permanently.');
    }




    public function destroy($id)
    {

        $cart = cart::find($id);
        if ($cart) {
            $cart->delete();
        }
        return redirect()->back();
    }









    // API Method to store a new doctor

    public function index_api($id)
    {


        $orders = [];
        // جلب الطلبات الخاصة بكل مستخدم
        $user_orders = Cart::where('user_id', $id)
            ->get()
            ->map(function ($order) {
                $product_ids = is_array(json_decode($order->product_id, true)) ? json_decode($order->product_id, true) : [];
                $quantities = is_array(json_decode($order->quantity, true)) ? json_decode($order->quantity, true) : [];
                $prices = is_array(json_decode($order->price, true)) ? json_decode($order->price, true) : [];

                $products = [];
                foreach ($product_ids as $index => $product_id) {
                    $product = stock::find($product_id);
                    if ($product) {
                        $products[] = [
                            'product_id' => $product_id,
                            'name' => $product->product_name,
                            'quantity' => $quantities[$index] ?? 0,
                            'price' => $prices[$index] ?? 0,
                            'total_price' => ($quantities[$index] ?? 0) * ($prices[$index] ?? 0),
                        ];
                    }
                }

                return [
                    'order_id' => $order->id,
                    'facility_id' => $order->facility_id,
                    'user' => [
                        'id' => $order->user->id,
                        'name' => $order->user->first_name . ' ' . $order->user->last_name,
                        'mobile' => $order->user->mobile,
                    ],
                    'facility' => [
                        'id' => $order->facility->id?? 'N/A',
                        'name' => $order->facility->name?? 'N/A',
                        'mobile' => $order->facility->mobile?? 'N/A',
                    ],
                    'products' => $products,
                    'latitude' => $order->latitude,
                    'longitude' => $order->longitude,
                    'note' => $order->note,
                    'status' => $order->status,
                    'date_order' => $order->created_at,
                    'total' => $order->total,
                ];
            });



        $orders = array_merge($orders, $user_orders->toArray());

        // دمج الطلبات في المصفوفة الرئيسية
        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }



    public function index_api_facility(Request $request)
    {
        $id = $request->facility_id;

        $orders = Cart::where('facility_id', $id)
            ->get()
            ->groupBy('order_number') // تجميع الطلبات حسب order_number
            ->map(function ($groupedOrders, $orderNumber) {
                // استرجاع معلومات المستخدم من أول طلب في المجموعة
                $firstOrder = $groupedOrders->first();

                // استرجاع قائمة المنتجات في هذا الطلب
                $products = $groupedOrders->map(function ($order) {


                    return [
                        'product_id' => $order->product_id,
                        'product_name' => $order->stock->product_name ?? null,
                        'quantity' => $order->quantity,
                        'price' => $order->price,
                        'status' => $order->status,
                        'img' => $order->img,
                    ];
                });

                return [
                    'order_number' => $orderNumber,
                    'order_id' => $firstOrder->id,
                    'user' => [
                        'id' => $firstOrder->user->id,
                        'name' => $firstOrder->user->first_name . ' ' . $firstOrder->user->last_name,
                        'mobile' => $firstOrder->user->mobile,
                    ],
                    'latitude' => $firstOrder->latitude,
                    'longitude' => $firstOrder->longitude,
                    'note' => $firstOrder->note,
                    'status' => $firstOrder->status,
                    'date_order' => $firstOrder->created_at,
                    'total' => $groupedOrders->sum('total'), // إجمالي المبلغ لجميع الطلبات في المجموعة
                    'products' => $products, // قائمة المنتجات
                ];
            })
            ->values(); // إعادة ضبط الفهارس

        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }







    public function get_my_orders(Request $request)
    {



        $facility_id = $request->facility_id;

        // جلب جميع المستخدمين المرتبطين بالمنشأة
        $users = User::where('facility_id', $facility_id)->pluck('id');

        // جلب جميع الطلبات بناءً على المستخدمين
        $orders = Cart::whereIn('user_id', $users)
            ->with(['user', 'stock', 'facility']) // تحميل العلاقات المطلوبة
            ->get()
            ->groupBy('order_number') // تجميع الطلبات حسب order_number
            ->map(function ($groupedOrders, $orderNumber) {
                $firstOrder = $groupedOrders->first(); // الحصول على أول طلب

                // تجميع المنتجات لكل منشأة
                $facilities = $groupedOrders->groupBy('facility_id')->map(function ($facilityOrders, $facilityId) {
                    $facility = $facilityOrders->first()->facility; // الحصول على بيانات المنشأة

                    // قائمة المنتجات الخاصة بالمنشأة
                    $products = $facilityOrders->map(function ($order) {
                        return [
                            'product_id' => $order->product_id,
                            'product_name' => $order->stock->product_name ?? 'N/A',
                            'quantity' => $order->quantity,
                            'price' => $order->price,
                            'status' => $order->status,
                            'img' => $order->img,
                        ];
                    });

                    return [
                        'facility_id' => $facilityId,
                        'facility_name' => $facility->name ?? 'Unknown Facility',
                        'products' => $products,
                    ];
                })->values(); // إعادة ضبط الفهارس

                return [
                    'order_number' => $orderNumber,
                    'order_id' => $firstOrder->id,
                    'user' => [
                        'id' => $firstOrder->user->id,
                        'name' => $firstOrder->user->first_name . ' ' . $firstOrder->user->last_name,
                        'mobile' => $firstOrder->user->mobile,
                    ],
                    'latitude' => $firstOrder->latitude,
                    'longitude' => $firstOrder->longitude,
                    'note' => $firstOrder->note,
                    // 'status' => $firstOrder->status,
                    'date_order' => $firstOrder->created_at,
                    'total' => $groupedOrders->sum('total'),
                    'facilities' => $facilities, // مصفوفة المنشآت والمنتجات
                ];
            })
            ->values(); // إعادة ضبط الفهارس

        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }


    public function get_my_orders_user(Request $request)
    {
        $user_id = $request->user_id;



        // جلب جميع الطلبات بناءً على المستخدمين
        $orders = Cart::where('user_id', $user_id)
            ->with(['user', 'stock', 'facility']) // تحميل العلاقات المطلوبة
            ->get()
            ->groupBy('order_number') // تجميع الطلبات حسب order_number
            ->map(function ($groupedOrders, $orderNumber) {
                $firstOrder = $groupedOrders->first(); // الحصول على أول طلب

                // تجميع المنتجات لكل منشأة
                $facilities = $groupedOrders->groupBy('facility_id')->map(function ($facilityOrders, $facilityId) {
                    $facility = $facilityOrders->first()->facility; // الحصول على بيانات المنشأة
                    $img = json_decode($facilityOrders->first()->img) ; // الحصول على بيانات المنشأة

                    // قائمة المنتجات الخاصة بالمنشأة
                    $products = $facilityOrders->map(function ($order) {
                        $img = $order->img;
                        return [
                            'product_id' => $order->product_id,
                            'product_name' => $order->stock->product_name ?? 'N/A',
                            'quantity' => $order->quantity,
                            'price' => $order->price,
                            'status' => $order->status,



                        ];
                    });

                    return [
                        'facility_id' => $facilityId ?? 'N/A',
                        'facility_name' => $facility->name ?? 'Unknown Facility',
                        'img' => $img,
                        'products' => $products,


                    ];
                })->values(); // إعادة ضبط الفهارس

                return [
                    'order_number' => $orderNumber,
                    'order_id' => $firstOrder->id,
                    // 'user' => [
                    //     'id' => $firstOrder->user->id,
                    //     'name' => $firstOrder->user->first_name . ' ' . $firstOrder->user->last_name,
                    //     'mobile' => $firstOrder->user->mobile,
                    // ],
                    'latitude' => $firstOrder->latitude,
                    'longitude' => $firstOrder->longitude,
                    'note' => $firstOrder->note,
                    // 'status' => $firstOrder->status,
                    'date_order' => $firstOrder->created_at,
                    'total' => $groupedOrders->sum('total'),
                    'facilities' => $facilities, // مصفوفة المنشآت والمنتجات
                ];
            })
            ->values(); // إعادة ضبط الفهارس


        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }











    public function store_api(Request $request)
    {




        // dd($request->all());
        $product_ids = Arr::wrap($request->input('product_id'));
        $quantities = Arr::wrap($request->input('quantity'));
        $facility_ids = Arr::wrap($request->input('facility_id'));
        $prices = Arr::wrap($request->input('price'));

        if ($product_ids) {
            // Validate that all arrays have the same length
            if (count($product_ids) !== count($quantities) || count($product_ids) !== count($prices) || count($product_ids) !== count($facility_ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'The arrays product_id, quantity, facility_id, and price must have the same length.',
                ], 422);
            }
        }

        $inputs = $request->except('img');
        $uploaded_images = [];

        // Handle multiple files upload
        if ($request->hasFile('img')) {
            foreach ($request->file('img') as $file) {
                $path_file = $file->store('images/orders', 'public');
                $uploaded_images[] = '/storage/' . $path_file;
            }
        }

        $total = 0;
        $order_number = strtoupper(Str::random(10));

        if ($product_ids) {
            foreach ($product_ids as $index => $product_id) {
                $quantity = $quantities[$index];
                $price = $prices[$index];
                $facility_id = $facility_ids[$index];

                $total += floatval($quantity) * floatval($price);

                cart::create([
                    'user_id' => $request->input('user_id'),
                    'facility_id' => $facility_id,
                    'product_id' => $product_id ?? null,
                    'quantity' => $quantity ?? null,
                    'price' => $price ?? null,
                    'img' => json_encode($uploaded_images), // Save images as JSON array
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'note' => $request->input('note'),
                    'order_number' => $order_number,
                    'total' => floatval($quantity) * floatval($price) ?? null,
                ]);
            }
        } else {
            cart::create([
                'user_id' => $request->input('user_id'),
                'facility_id' => $request->input('facility_id'),
                'product_id' => $request->input('product_id') ?? null,
                'quantity' => $request->input('quantity') ?? null,
                'price' => $request->input('price') ?? null,
                'img' => json_encode($uploaded_images), // Save images as JSON array
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'note' => $request->input('note'),
                'order_number' => $order_number,
                'total' => $request->input('total') ?? null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart items added successfully',
            'order_number' => $order_number,
        ]);
    }






    // API Method to show a specific doctor
    public function show_api($id)
    {

        $cart = cart::find($id);

        if ($cart) {
            return response()->json([
                'success' => true,
                'cart' => $cart,
            ]);
        }

        return response()->json(['success' => false, 'message' => 'cart not found'], 404);
    }




    public function update(Request $request, cart $doctor)
    {


        if ($request['status'] == 'completed') {

            $qty = $request['qty'];
            $product_stock = stock::find($request['product_id']);


            $product_stock->update(['qty' => $product_stock->qty - $qty]);
        }
        $updated = $doctor->update($request->all());


        if ($updated) {
            return redirect()->route('cart.index')->with('flash_message', 'Doctor updated successfully!');
        } else {
            return redirect()->back()->with('flash_message', 'Doctor update failed, no rows affected.');
        }
    }

    // API Method to update a specific doctor
    public function update_api(Request $request, $id)
    {



        $order = Cart::find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Cart not found'], 404);
        }

        $product_stock = Stock::find($order->product_id);

        if ($request->has('status') && $request->status == 'completed') {
            if ($product_stock) {

                if ($order->status != 'completed') {
                    if ($product_stock->qty < $order->quantity) {
                        return response()->json([
                            'success' => false,
                            'message' => "Insufficient stock for product ID {$order->product_id}.",
                        ], 422);
                    }

                    $product_stock->update(['qty' => $product_stock->qty - $order->quantity]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => "oreder ID {$id} is already completed.",
                    ], 422);
                }
            }
        }

        // Calculate the new total
        $new_total = $request->has('quantity') && $request->has('price')
            ? $request->quantity * $request->price
            : $order->total;

        // Update only the provided fields, preserving existing values for others
        $order->update([
            'product_id' => $request->input('product_id', $order->product_id),
            'quantity' => $request->input('quantity', $order->quantity),
            'price' => $request->input('price', $order->price),
            'latitude' => $request->input('latitude', $order->latitude),
            'longitude' => $request->input('longitude', $order->longitude),
            'note' => $request->input('note', $order->note),
            'status' => $request->input('status', $order->status),
            'total' => $new_total,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'order' => $order
        ]);
    }






    public function trash_api()
    {
        $cart_deleted = cart::onlyTrashed()->get();
        return response()->json(['success' => true, 'cart_deleted' => $cart_deleted]);
    }



    // API Method to delete a specific doctor
    public function destroy_api($id)
    {
        $cart = cart::find($id);
        if ($cart) {
            $cart->delete();
            return response()->json(['success' => true, 'message' => 'cart deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'cart not found'], 404);
    }



    // API Method to restore a deleted doctor
    public function restore_api($id)
    {
        $cart = cart::withTrashed()->find($id);
        if ($cart) {
            $cart->restore();
            return response()->json(['success' => true, 'message' => 'cart restored successfully']);
        }

        return response()->json(['success' => false, 'message' => 'cart not found'], 404);
    }
}
