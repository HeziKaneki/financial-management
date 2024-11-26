<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Monthly;
use Illuminate\Http\Request;

class FundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $funds = Fund::where('user_id', auth()->id())->get();
        return view('fund.index', compact('funds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fund.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'monthly' => 'required|integer',
        ]);
    
        $fund = new Fund();
        $fund->name = $validatedData['name'];
        $user_id = auth()->id();
        $fund->user_id = $user_id;
        $fund->save();
    
        $monthly = new Monthly();
        $monthly->amount = $validatedData['monthly'];
        $monthly->fund_id = $fund->id;
        $monthly->save();
    
        // Response
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $monthly = Monthly::where('fund_id', $id)->first()->amount;
        $name = Fund::find($id)->name;
        $fund = [
            'id' => $id,
            'name' => $name,
            'monthly' => $monthly
        ];
        return view('fund.edit', compact('fund'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'monthly' => 'required|integer',
        ]);

        $fund = Fund::find($id);
        $fund->update([
            'name' => $validated['name'],
        ]);

        $monthly = Monthly::where('fund_id', $id)->first();
        $monthly->update([
            'amount' => $validated['monthly'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deleteFund = Fund::find($id);
        $freemoney = Fund::where('user_id', auth()->id())->where('is_freemoney', 1)->first();
        $freemoney->increment('balance', $deleteFund->balance);
        $deleteFund->delete();
        return response()->json([
            'status' => 'success',
            'message' => "success, fund's balance restored to freemoney",
        ]);
    }
}

////// Note: chưa cập nhận freemoney sau khi xử lý xong ở view