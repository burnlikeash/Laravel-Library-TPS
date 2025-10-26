<?php
// Create a new DashboardController
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrower;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_borrowers' => Borrower::count(),
            'active_transactions' => Transaction::where('status', 'borrowed')->count(),
            'overdue_books' => Transaction::where('status', 'borrowed')
                ->where('due_date', '<', Carbon::now())
                ->count(),
            'available_books' => Book::sum('available_quantity'),
        ];

        $recent_transactions = Transaction::with(['book', 'borrower'])
            ->latest()
            ->take(5)
            ->get();

        $overdue_transactions = Transaction::with(['book', 'borrower'])
            ->where('status', 'borrowed')
            ->where('due_date', '<', Carbon::now())
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_transactions', 'overdue_transactions'));
    }
}
