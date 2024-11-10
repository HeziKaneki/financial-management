<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display the expenses list view.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('expense.index');
    }
    
    /**
     * Display the expense creation view.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View {
        return view('expense.create');
    }

    /**
     * Store a newly created expense in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'amount' => 'required|integer',
            'type' => 'required|string',
            'source' => 'required|string'
        ]);
        $validated['user_id'] = $request->session()->get('user_id');

        Transaction::create($validated);

        // Response
    }

    /**
     * Remove the specified expense from the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy(Request $request) {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $transaction = Transaction::find($request->input('id'));
        $transaction->delete();

        // Response
    }

    /**
     * Display the expense edit view.
     *
     * @return \Illuminate\View\View
     */
    public function edit() {
        return view('expense.edit');
    }

    /**
     * Update the specified expense in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request) {
        $validated = $request->validate([
            'amount' => 'required|integer',
            'type' => 'required|string',
            'source' => 'required|string'
        ]);

        $transaction = Transaction::find($request->input('id'));
        $transaction->update($validated);

        // Response
    }

    /**
     * Display the expense show view.
     *
     * @return \Illuminate\View\View
     */
    public function show() {
        return view('expense.show');
    }
}