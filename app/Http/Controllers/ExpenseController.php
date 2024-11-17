<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->query('get') == 'comp') {
            $html = view('expense.index')->render();
            return response($html);
        } else {
            return view('expense.expense');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sourceFunds = Fund::where('user_id', auth()->id())->where('is_freemoney', 0)->get();
        return view('expense.create', compact('sourceFunds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $expense = new Transaction();
        $expense->user_id = auth()->id();
        $validatedData = $request->validate([
            'source' => 'required|string',
            'amount' => 'required|integer',
        ]);
        $expense->amount = $validatedData['amount'];
        $expense->type = 'expense';
        $expense->source = $validatedData['source'];
        $expense->save();
    
        Fund::where('id', $validatedData['source'])->decrement('balance', $validatedData['amount']);
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
        //
    }
}
