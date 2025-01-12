<?php

namespace App\Http\Controllers;

use App\Models\FQA;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FQAController extends Controller
{
    // Web Methods
    public function index()
    {
        if (Auth::user()->user_type == 2) {
            $FQAs = FQA::where('facility_id', session('facility_id'))->get();
        }else{
            
            $FQAs = FQA::all();
        }
        return view('FQA.index', compact('FQAs'));
    }

    public function create()
    {
        return view('FQA.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'facility_id' => 'required|string',
        ]);

        FQA::create($request->all());

        return redirect()->route('FQA.index')->with('success', 'تم إضافة السؤال بنجاح.');
    }

    public function show(FQA $fQA)
    {
        return view('FQA.show', compact('fQA'));
    }

    public function edit($id)
    {
        $fQA = FQA::findOrFail($id);
        
        return view('FQA.edit', compact('fQA'));
    }

    public function update(Request $request, $id)
    {
        $FQA = FQA::findOrFail($id);
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $FQA->update($request->only(['question', 'answer']));

        return redirect()->route('FQA.index')->with('success', 'تم تحديث السؤال بنجاح.');
    }

    public function destroy($id)
    {
        $fQA = FQA::findOrFail($id);
        $fQA->delete();

        return redirect()->route('FQA.index')->with('success', 'تم حذف السؤال بنجاح.');
    }


    public function restore($id)
    {
        $fQA = FQA::withTrashed()->findOrFail($id);
        $fQA->restore();

        return redirect()->route('FQA.index')->with('success', 'FQA restored successfully.');
    }


    public function trash()
    {
        $FQA_deleted = FQA::onlyTrashed()->get();
        // $doctor_deleted = Doctors::onlyTrashed()->with('specialization')->get();

        return view('FQA.trash')->with('FQA_deleted', $FQA_deleted);
    }


    public function delete($id)
    {


        $FQA = FQA::withTrashed()->find($id);
        if ($FQA) {
            $FQA->forceDelete();
        }
        return redirect()->back()->with('success', 'FQA deleted permanently.');
    }


    //---------------------------------------------------- API Methods
    public function index_api()
    {
        $FQA = FQA::all();
    
        if ($FQA->isEmpty()) {
            return response()->json([
                'message' => 'لا توجد أسئلة متاحة.',
                'FQA' => []
            ], 200);
        }
    
        return response()->json([
            'message' => 'تم جلب الأسئلة بنجاح.',
            'FQA' => $FQA
        ], 200);
    }
    

    public function store_api(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $fqa = FQA::create($request->only(['question', 'answer']));

        return response()->json(['message' => 'تم إضافة السؤال بنجاح.', 'data' => $fqa], 201);
    }

    public function show_api(FQA $fQA)
    {
        return response()->json($fQA);
    }

    public function update_api(Request $request, $id)
    {
        $FQA = FQA::findOrFail($id);
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $FQA->update($request->only(['question', 'answer']));

        return response()->json(['message' => 'تم تحديث السؤال بنجاح.', 'data' => $FQA]);
    }

    public function destroy_api(FQA $fQA)
    {
        $fQA->delete();

        return response()->json(['message' => 'تم حذف السؤال بنجاح.']);
    }
}
