<!-- resources/views/transactions/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Transaction Details</h2>
    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Back to Transactions</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Transaction Information</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Book Details</h5>
                        <p><strong>Title:</strong> {{ $transaction->book->title }}</p>
                        <p><strong>Author:</strong> {{ $transaction->book->author }}</p>
                        <p><strong>ISBN:</strong> {{ $transaction->book->isbn }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Borrower Details</h5>
                        <p><strong>Name:</strong> {{ $transaction->borrower->name }}</p>
                        <p><strong>Email:</strong> {{ $transaction->borrower->email }}</p>
                        <p><strong>Phone:</strong> {{ $transaction->borrower->phone }}</p>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-6">
                        <h5>Transaction Dates</h5>
                        <p><strong>Borrow Date:</strong> {{ $transaction->borrow_date->format('F j, Y') }}</p>
                        <p><strong>Due Date:</strong> 
                            <span class="text-{{ $transaction->due_date->isPast() && $transaction->status === 'borrowed' ? 'danger' : 'dark' }}">
                                {{ $transaction->due_date->format('F j, Y') }}
                                @if($transaction->due_date->isPast() && $transaction->status === 'borrowed')
                                    (OVERDUE)
                                @endif
                            </span>
                        </p>
                        <p><strong>Return Date:</strong> 
                            {{ $transaction->return_date ? $transaction->return_date->format('F j, Y') : 'Not returned yet' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h5>Status</h5>
                        <p>
                            <span class="badge bg-{{ $transaction->status === 'borrowed' ? 'warning' : 'success' }} fs-6">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </p>
                        
                        @if($transaction->status === 'borrowed')
                            <form action="{{ route('transactions.return', $transaction) }}" method="POST" class="mt-3">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success" onclick="return confirm('Mark this book as returned?')">
                                    Return Book
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Quick Actions</div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('books.show', $transaction->book) }}" class="btn btn-outline-primary">
                        View Book Details
                    </a>
                    <a href="{{ route('borrowers.show', $transaction->borrower) }}" class="btn btn-outline-info">
                        View Borrower Profile
                    </a>
                    <a href="{{ route('transactions.create') }}" class="btn btn-outline-success">
                        New Transaction
                    </a>
                </div>
            </div>
        </div>
        
        @if($transaction->status === 'borrowed' && $transaction->due_date->isPast())
        <div class="card mt-3 border-danger">
            <div class="card-header text-danger">
                <i class="fas fa-exclamation-triangle"></i> Overdue Alert
            </div>
            <div class="card-body">
                <p class="text-danger mb-0">
                    This book is {{ $transaction->due_date->diffForHumans() }}! 
                    Please follow up with the borrower.
                </p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection