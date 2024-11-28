<?php

use App\Models\MonthlyAuto;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FundController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MonthlyAutoController;
use App\Http\Controllers\TransactionController;

Route::get('', function () {
    return view('welcome');
});

Route::get('dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::resource('test', TestController::class)->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('fund', FundController::class)->middleware(['auth', 'verified']);

Route::prefix('transaction')->name('transaction.')->middleware(['auth', 'verified'])->group(function () {
    // Create
    Route::get('create/expense', [TransactionController::class, 'expenseCreate'])->name('create.expense');
    Route::get('create/income', [TransactionController::class, 'incomeCreate'])->name('create.income');
    Route::get('create/allocate', [TransactionController::class, 'allocateCreate'])->name('create.allocate');
    // Store
    Route::post('store/expense', [TransactionController::class, 'expenseStore'])->name('store.expense');
    Route::post('store/income', [TransactionController::class, 'incomeStore'])->name('store.income');
    Route::post('store/allocate', [TransactionController::class, 'allocateStore'])->name('store.allocate');
});

Route::resource('transaction', TransactionController::class)->middleware(['auth', 'verified']);

Route::resource('category', CategoryController::class)->middleware(['auth', 'verified']);

Route::resource('monthlyAuto', MonthlyAutoController::class)->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
