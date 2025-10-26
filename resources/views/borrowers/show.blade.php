<!-- resources/views/borrowers/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>{{ $borrower->name }}</h2>
    <a href="{{ route('borrowers.index') }}" class="btn btn-secondary">Back to Borrowers</a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Borrower Details</div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $borrower->name }}</p>
                <p><strong>Email:</strong> {{ $borrower->email }}</p>
                <p><strong>Phone:</strong> {{ $borrower->phone }}</p>
                <p><strong>Member Since:</strong> {{ $borrower->created_at->format('F j, Y') }}</p>
                <p><strong>Active Borrows:</strong> {{ $borrower->activeBorrows->count() }}</p>
                <p><strong>Total Transactions:</strong> {{ $borrower->transactions->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Borrowing History</div>
            <div class="card-body">
                @if($borrower->transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Book</th>
                                    <th>Status</th>
                                    <th>Borrow Date</th>
                                    <th>Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($borrower->transactions->sortByDesc('created_at')->take(10) as $transaction)
                                <tr>
                                    <td>{{ $transaction->book->title }}</td>
                                    <td>
                                        <span class="badge bg-{{ $transaction->status === 'borrowed' ? 'warning' : 'success' }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction->borrow_date->format('Y-m-d') }}</td>
                                    <td>
                                        <span class="text-{{ $transaction->due_date->isPast() && $transaction->status === 'borrowed' ? 'danger' : 'dark' }}">
                                            {{ $transaction->due_date->format('Y-m-d') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No borrowing history yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection