<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::resource('books', BookController::class);
Route::resource('borrowers', BorrowerController::class);
Route::resource('transactions', TransactionController::class)->except(['edit', 'update', 'destroy']);
Route::patch('transactions/{transaction}/return', [TransactionController::class, 'returnBook'])->name('transactions.return');
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);
