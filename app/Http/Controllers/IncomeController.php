<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Display a listing of the user's income transactions.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $transactions = Transaction::where('type', 'income')->where('user_id', $request->session()->get('user_id'))->get();
        return view('income.index', compact('transactions'));
    }

    /**
     * Display the income creation view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('income.create');
    }

    /**
     * Store a newly created income transaction in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|integer',
            'type' => 'required|string',
        ]);
        $validated['user_id'] = $request->session()->get('user_id');

        Transaction::create($validated);

        // Response
    }

    /**
     * Remove the specified income transaction from the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $transaction = Transaction::find($request->input('id'));
        $transaction->delete();

        // Response
    }

    /**
     * Display the income edit view.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('income.edit');
    }

    /**
     * Update the specified income transaction in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|integer',
            'type' => 'required|string',
        ]);

        $transaction = Transaction::find($request->input('id'));
        $transaction->update($validated);

        // Response
    }

    /**
     * Display the income show view.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('income.show');
    }
}
