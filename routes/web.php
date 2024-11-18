<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FundController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;

Route::get('', function () {
    return view('welcome');
});

Route::get('dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('test', function () {
    return view('test.test');
})->middleware(['auth', 'verified'])->name('test');

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

// Resource for index, edit, update, show, destroy
Route::resource('transaction', TransactionController::class)->middleware(['auth', 'verified']);

// Route::get('/transaction/index', [TransactionController::class, 'index'])->name('transaction.index');
// Route::get('/transaction/{id}/show', [TransactionController::class, 'show'])->name('transaction.show');
// Route::get('/transaction/{id}/edit', [TransactionController::class, 'edit'])->name('transaction.edit');
// Route::put('/transaction/{id}/update', [TransactionController::class, 'update'])->name('transaction.update');
// Route::delete('/transaction/{id}/delete', [TransactionController::class, 'destroy'])->name('transaction.destroy');

require __DIR__.'/auth.php';
