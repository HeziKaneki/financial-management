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
        if ($request->query('get') == 'comp') {
            $html = view('fund.index')->render();
            return response($html);
        } else {
            return view('fund.fund');
        }
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
        if ($user_id == null) {
            throw new CustomException(session()->get('user_id'), 400);
        } else {
            $fund->user_id = $user_id;
        }
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return view('fund.destroy');
    }
}