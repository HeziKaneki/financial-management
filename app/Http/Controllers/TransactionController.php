<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('search', '');
        $from_date = $request->input('from_date', null);
        $to_date = $request->input('to_date', null);
        $type = $request->input('type', null);
        $category_id = $request->input('category_id', null);

        $transactions = Transaction::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->when($search, function ($query, $search) {
                return $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('id', 'like', "%$search%")
                            ->orWhere('type', 'like', "%$search%")
                            ->orWhere('amount', 'like', "%$search%")
                            ->orWhere('description', 'like', "%$search%");
                });
            })
            ->when($from_date, function ($query, $from_date) {
                return $query->whereDate('created_at', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('created_at', '<=', $to_date);
            })
            ->when($type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($category_id, function ($query, $category_id) {
                return $query->whereHas('categories', function ($categoryQuery) use ($category_id) {
                    $categoryQuery->where('categories.id', $category_id);
                });
            })
            ->paginate(20);

        // Lấy tên source và destination
        foreach ($transactions as $transaction) {
            $transaction->source_name = Fund::find($transaction->source)?->name ?? '';
            $transaction->destination_name = Fund::find($transaction->destination)?->name ?? '';
        }

        // Lấy danh sách categories
        $categories = Category::where('user_id', auth()->id())->get();

        return view('transaction.index', compact('transactions', 'search', 'categories', 'from_date', 'to_date', 'type', 'category_id'));
    }

    // public function index(Request $request) {
    //     $search = $request->input('search', '');

    //     $transactions = Transaction::where('user_id', auth()->id())->orderBy('created_at', 'desc')->when($search, function($query, $search) {
    //         return $query
    //             ->where('id', 'like', "%$search%")
    //             ->orWhere('type', 'like', "%$search%")
    //             ->orWhere('amount', 'like', "%$search%");
    //     })->paginate(20);

    //     // Bởi source và destination của transaction chỉ là các id, cần truy vấn tên source và destination
    //     foreach ($transactions as $transaction) {
    //         $transaction->source_name = Fund::where('id', $transaction->source)->first()->name ?? '';
    //         $transaction->destination_name = Fund::where('id', $transaction->destination)->first()->name ?? '';
    //     }

    //     return view('transaction.index', compact('transactions', 'search'));
    // }

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
        $categories = Category::where('user_id', auth()->id())->get();
        return view('transaction.create.expense', compact('sourceFunds', 'categories'));
    }
    public function expenseStore(Request $request) {
        $validatedData = $request->validate([
            'source' => 'required|string',
            'amount' => 'required|integer',
        ]);
        if ($validatedData['amount'] > Fund::where('id', $validatedData['source'])->first()->balance) {
            return response()->json([
                'status' => 'error',
                'message' => 'not enough money',
            ]);
        }

        $expense = new Transaction();
        $expense->user_id = auth()->id();
        $expense->amount = $validatedData['amount'];
        $expense->type = 'expense';
        $expense->source = $validatedData['source'];
        if ($request->description != null) {
            $expense->description = $request->description;
        }
        $expense->save();

        Fund::where('id', $validatedData['source'])->decrement('balance', $validatedData['amount']);

        if ($request->categories != null) {
            $expense->categories()->attach($request->categories);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'success',
        ]);             
    }
    public function incomeCreate() {
        $categories = Category::where('user_id', auth()->id())->get();
        return view('transaction.create.income', compact('categories'));
    }
    public function incomeStore(Request $request) {
        $validatedData = $request->validate([
            'amount' => 'required|integer',
        ]);
        $income = new Transaction();
        $income->user_id = auth()->id();
        $income->amount = $validatedData['amount'];
        $income->type = 'income';
        if ($request->description != null) {
            $income->description = $request->description;
        }
        $income->save();
        if ($request->categories != null) {
            $income->categories()->attach($request->categories);
        }
        Fund::where('user_id', auth()->id())->where('is_freemoney', 1)->increment('balance', $validatedData['amount']);
    }
    public function allocateCreate() {
        $destinationFunds = Fund::where('user_id', auth()->id())->where('is_freemoney', 0)->get();
        $categories = Category::where('user_id', auth()->id())->get();
        return view('transaction.create.allocate', compact('destinationFunds', 'categories'));
    }
    public function allocateStore(Request $request) {
        $validatedData = $request->validate([
            'destination' => 'required|string',
            'amount' => 'required|integer',
        ]);
        $allocate = new Transaction();
        $allocate->user_id = auth()->id();
        $allocate->amount = $validatedData['amount'];
        $allocate->type = 'allocate';
        $allocate->destination = $validatedData['destination'];
        if ($validatedData['amount'] > Fund::where('user_id', auth()->id())->where('is_freemoney', 1)->first()->balance) {
            return response()->json([
                'status' => 'error',
                'message' => 'not enough money',
            ]);
        }
        if ($request->description != null) {
            $allocate->description = $request->description;
        }
        $allocate->save();
        if ($request->categories != null) {
            $allocate->categories()->attach($request->categories);
        }
        Fund::where('user_id', auth()->id())->where('is_freemoney', 1)->decrement('balance', $validatedData['amount']);
        Fund::where('id', $validatedData['destination'])->increment('balance', $validatedData['amount']);
        return response()->json([
            'status' => 'success',
            'message' => 'success',
        ]);
    }
}
