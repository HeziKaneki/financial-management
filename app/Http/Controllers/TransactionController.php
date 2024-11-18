<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function transaction() {
        return view('transaction.transaction');
    }

    public function index(Request $request) {
        // Lấy từ input tìm kiếm
        $search = $request->input('search', '');

        // Truy vấn các giao dịch và phân trang
        $transactions = Transaction::when($search, function($query, $search) {
            return $query->where('id', 'like', "%$search%")
                        ->orWhere('type', 'like', "%$search%")
                        ->orWhere('amount', 'like', "%$search%");
        })->paginate(20); // Phân trang 20 giao dịch mỗi trang

        // Thêm thông tin source_name và destination_name cho từng giao dịch
        foreach ($transactions as $transaction) {
            $transaction->source_name = Fund::where('id', $transaction->source)->first()->name ?? '';
            $transaction->destination_name = Fund::where('id', $transaction->destination)->first()->name ?? '';
        }

        // Trả về view với các giao dịch đã được thêm thông tin
        return view('transaction.index', compact('transactions', 'search'));
    }

    public function show($id) {
        return view('transaction.show');
    }

    public function edit($id) {
        $transaction = Transaction::find($id);
        return view('transaction.edit', compact($transaction));
    }

    public function update() {
        //
    }

    public function destroy() {
        //
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
