<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('search', '');

        $transactions = Transaction::where('user_id', auth()->id())->orderBy('created_at', 'desc')->when($search, function($query, $search) {
            return $query
                ->where('id', 'like', "%$search%")
                ->orWhere('type', 'like', "%$search%")
                ->orWhere('amount', 'like', "%$search%");
        })->paginate(20);

        // Bởi source và destination của transaction chỉ là các id, cần truy vấn tên source và destination
        foreach ($transactions as $transaction) {
            $transaction->source_name = Fund::where('id', $transaction->source)->first()->name ?? '';
            $transaction->destination_name = Fund::where('id', $transaction->destination)->first()->name ?? '';
        }

        return view('transaction.index', compact('transactions', 'search'));
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        $transaction = Transaction::find($id);
        if ($transaction->type == 'expense') {
            Fund::where('id', $transaction->source)->increment('balance', $transaction->amount);
            $transaction->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'success',
            ]);
        } else if ($transaction->type == 'income') {
            $freemoneyBalance = Fund::where('user_id', auth()->id())->where('is_freemoney', 1)->first()->balance;
            if ($transaction->amount > $freemoneyBalance) {
                return response()->json([
                    'status' => 'error',
                    'message' => "freemoney don't have enough money to restore",
                ]);
            } else {
                Fund::where('user_id', auth()->id())->where('is_freemoney', 1)->decrement('balance', $transaction->amount);
                $transaction->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'success',
                ]);
            }
        } else if ($transaction->type == 'allocate') {
            $destinationFundBalance = Fund::where('id', $transaction->destination)->first()->balance;
            if ($transaction->amount > $destinationFundBalance) {
                return response()->json([
                    'status' => 'error',
                    'message' => "source fund don't have enough money to restore",
                ]);
            } else {
                Fund::where('id', $transaction->destination)->decrement('balance', $transaction->amount);
                Fund::where('user_id', auth()->id())->where('is_freemoney', 1)->increment('balance', $transaction->amount);
                $transaction->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'success',
                ]);
            }
        }
    }

    public function expenseCreate() {
        $sourceFunds = Fund::where('user_id', auth()->id())->where('is_freemoney', 0)->get();
        return view('transaction.create.expense', compact('sourceFunds'));
    }
    public function expenseStore(Request $request) {
        $expense = new Transaction();
        $expense->user_id = auth()->id();
        $validatedData = $request->validate([
            'source' => 'required|string',
            'amount' => 'required|integer',
        ]);
        $expense->amount = $validatedData['amount'];
        $expense->type = 'expense';
        $expense->source = $validatedData['source'];

        if ($validatedData['amount'] > Fund::where('id', $validatedData['source'])->first()->balance) {
            return response()->json([
                'status' => 'error',
                'message' => 'not enough money',
            ]);
        } else {
            $expense->save();
            Fund::where('id', $validatedData['source'])->decrement('balance', $validatedData['amount']);
            return response()->json([
                'status' => 'success',
                'message' => 'success',
            ]);
        }    
        $expense->save();
        Fund::where('id', $validatedData['source'])->decrement('balance', $validatedData['amount']);
    }
    public function incomeCreate() {
        return view('transaction.create.income');
    }
    public function incomeStore(Request $request) {
        $income = new Transaction();
        $income->user_id = auth()->id();
        $validatedData = $request->validate([
            'amount' => 'required|integer',
        ]);
        $income->amount = $validatedData['amount'];
        $income->type = 'income';
        $income->save();
        Fund::where('user_id', auth()->id())->where('is_freemoney', 1)->increment('balance', $validatedData['amount']);
    }
    public function allocateCreate() {
        $destinationFunds = Fund::where('user_id', auth()->id())->where('is_freemoney', 0)->get();
        return view('transaction.create.allocate', compact('destinationFunds'));
    }
    public function allocateStore(Request $request) {
        $allocate = new Transaction();
        $allocate->user_id = auth()->id();
        $validatedData = $request->validate([
            'destination' => 'required|string',
            'amount' => 'required|integer',
        ]);
        $allocate->amount = $validatedData['amount'];
        $allocate->type = 'allocate';
        $allocate->destination = $validatedData['destination'];
    
        if ($validatedData['amount'] > Fund::where('user_id', auth()->id())->where('is_freemoney', 1)->first()->balance) {
            return response()->json([
                'status' => 'error',
                'message' => 'not enough money',
            ]);
        } else {
            $allocate->save();
            Fund::where('user_id', auth()->id())->where('is_freemoney', 1)->decrement('balance', $validatedData['amount']);
            Fund::where('id', $validatedData['destination'])->increment('balance', $validatedData['amount']);
            return response()->json([
                'status' => 'success',
                'message' => 'success',
            ]);
        }
    }
}
