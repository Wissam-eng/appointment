<?php

namespace App\Http\Controllers;

use App\Models\ClientAdvertisement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientAdvertisementController extends Controller
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
        $ads = ClientAdvertisement::with('client')->get();
        return view('clientAdvertisements.index', compact('ads'));
    }


    public function index_api()
    {

        $ads = ClientAdvertisement::all();
        return response()->json([
            'success' => true,
            'ads' => $ads
        ]);
    }

    public function create()
    {
        $clients = Facility::whereNull('deleted_at')->get();
        return view('clientAdvertisements.create')->with('clients', $clients);
    }



    public function store(Request $request)
    {
        $requestData = $request->except('image_url');

        if ($request->hasFile('image_url')) {
            $file =  $request->file('image_url');
            $path_file = $file->store('images/adds', 'public');
            $requestData['image_url'] = '/storage/' . $path_file;
        }

        // $requestData['created_by'] = session('user_id');
        $requestData['created_by'] = 1;
        ClientAdvertisement::create($requestData);

        return redirect()->route('clientAdvertisements.index')
            ->with('success', 'Advertisement created successfully.');
    }

    public function store_api(Request $request)
    {
        $requestData = $request->except('image_url');

        if ($request->hasFile('image_url')) {
            $file =  $request->file('image_url');
            $path_file = $file->store('images/adds', 'public');
            $requestData['image_url'] = '/storage/' . $path_file;
        }

        $ad = ClientAdvertisement::create($requestData);

        return response()->json([
            'success' => true,
            'message' => 'Advertisement created successfully via API!',
            'ad' => $ad
        ]);
    }

    public function show(ClientAdvertisement $clientAdvertisement)
    {
        return view('clientAdvertisements.show', compact('clientAdvertisement'));
    }

    public function show_api(ClientAdvertisement $clientAdvertisement)
    {
        return response()->json([
            'success' => true,
            'ad' => $clientAdvertisement
        ]);
    }

    public function edit(ClientAdvertisement $clientAdvertisement)
    {
        $clients = Facility::whereNull('deleted_at')->get();
        return view('clientAdvertisements.edit', compact('clientAdvertisement', 'clients'));
    }

    public function edit_api(ClientAdvertisement $clientAdvertisement)
    {
        return response()->json([
            'success' => true,
            'ad' => $clientAdvertisement
        ]);
    }

    public function update(Request $request, $id)
    {

        $clientAdvertisement = ClientAdvertisement::find($id);

        $requestData = $request->except('image_url');

        if ($request->hasFile('image_url')) {
            if ($clientAdvertisement->image_url) {
                Storage::disk('public')->delete($clientAdvertisement->image_url);
            }
            $file =  $request->file('image_url');
            $path_file = $file->store('images/adds', 'public');
            $requestData['image_url'] = '/storage/' . $path_file;
        }

        $clientAdvertisement->update($requestData);

        return redirect()->route('clientAdvertisements.index')->with('success', 'Advertisement updated successfully.');
    }



    // public function update_api(Request $request, ClientAdvertisement $clientAdvertisement)
    // {
    //     $requestData = $request->except('image_url');

    //     if ($request->hasFile('image_url')) {
    //         if ($clientAdvertisement->image_url) {
    //             Storage::disk('public')->delete($clientAdvertisement->image_url);
    //         }
    //         $file =  $request->file('image_url');
    //         $path_file = $file->store('images/adds', 'public');
    //         $requestData['image_url'] = '/storage/' . $path_file;
    //     }

    //     $clientAdvertisement->update($requestData);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Advertisement updated successfully via API!',
    //         'ad' => $clientAdvertisement
    //     ]);
    // }
    
    public function update_api(Request $request, $id)
    {
        $ads = ClientAdvertisement::find($id);
        if (!$ads) {
            return response()->json(['success' => false, 'message' => 'Ads not found'], 404);
        }

        $status = $request->input('status');

        if ($status !== null) {
            $ads->update(['status' => $status]);
            return response()->json(['success' => true, 'message' => 'Ads updated successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Status field is required','$ads' => $ads], 400);
    }
    
    
    public function destroy(ClientAdvertisement $clientAdvertisement)
    {
        if ($clientAdvertisement->image_url) {
            Storage::disk('public')->delete($clientAdvertisement->image_url);
        }

        $clientAdvertisement->delete();

        return redirect()->route('clientAdvertisements.index')->with('success', 'Advertisement deleted successfully.');
    }

    public function destroy_api(ClientAdvertisement $clientAdvertisement)
    {
        if ($clientAdvertisement->image_url) {
            Storage::disk('public')->delete($clientAdvertisement->image_url);
        }

        $clientAdvertisement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Advertisement deleted successfully via API!'
        ]);
    }



    public function trash()
    {

        $ads_deleted = ClientAdvertisement::onlyTrashed()->get();
        return view('clientAdvertisements.trash', compact('ads_deleted'));
    }



    public function trash_api()
    {
        $ads_deleted = ClientAdvertisement::onlyTrashed()->get();
        return response()->json([
            'success' => true,
            'ads_deleted' => $ads_deleted
        ]);
    }

    /**
     * Restore the specified resource from trash.
     */
    public function restore($id)
    {
        $ad = ClientAdvertisement::withTrashed()->findOrFail($id);
        $ad->restore();

        return redirect()->route('clientAdvertisements.index')
            ->with('success', 'Advertisement restored successfully.');
    }

    public function restore_api($id)
    {
        $ad = ClientAdvertisement::withTrashed()->findOrFail($id);
        $ad->restore();

        return response()->json([
            'success' => true,
            'message' => 'Advertisement restored successfully via API!'
        ]);
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $ad = ClientAdvertisement::withTrashed()->findOrFail($id);
        if ($ad->image_url) {
            Storage::disk('public')->delete($ad->image_url);
        }
        $ad->forceDelete();

        return redirect()->route('clientAdvertisements.trash')
            ->with('success', 'Advertisement permanently deleted successfully.');
    }

    public function forceDelete_api($id)
    {
        $ad = ClientAdvertisement::withTrashed()->findOrFail($id);
        if ($ad->image_url) {
            Storage::disk('public')->delete($ad->image_url);
        }
        $ad->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Advertisement permanently deleted successfully via API!'
        ]);
    }
}
