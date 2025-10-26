<?php
// app/Http/Controllers/TransactionController.php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Book;
use App\Models\Borrower;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['book', 'borrower'])->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $books = Book::where('available_quantity', '>', 0)->get();
        $borrowers = Borrower::all();
        return view('transactions.create', compact('books', 'borrowers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrower_id' => 'required|exists:borrowers,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after:borrow_date',
        ]);

        $book = Book::find($request->book_id);
        
        if ($book->available_quantity <= 0) {
            return back()->with('error', 'Book is not available for borrowing!');
        }

        Transaction::create($request->all());
        
        // Update available quantity
        $book->decrement('available_quantity');

        return redirect()->route('transactions.index')->with('success', 'Book borrowed successfully!');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['book', 'borrower']);
        return view('transactions.show', compact('transaction'));
    }

    public function returnBook(Transaction $transaction)
    {
        if ($transaction->status === 'returned') {
            return back()->with('error', 'Book is already returned!');
        }

        $transaction->update([
            'return_date' => Carbon::now(),
            'status' => 'returned'
        ]);

        // Update available quantity
        $transaction->book->increment('available_quantity');

        return redirect()->route('transactions.index')->with('success', 'Book returned successfully!');
    }
}