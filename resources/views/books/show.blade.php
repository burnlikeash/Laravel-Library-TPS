@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>{{ $book->title }}</h2>
    <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to Books</a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Book Details</div>
            <div class="card-body">
                <p><strong>Title:</strong> {{ $book->title }}</p>
                <p><strong>Author:</strong> {{ $book->author }}</p>
                <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                <p><strong>Total Quantity:</strong> {{ $book->quantity }}</p>
                <p><strong>Available:</strong> {{ $book->available_quantity }}</p>
                <p><strong>Currently Borrowed:</strong> {{ $book->quantity - $book->available_quantity }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Transaction History</div>
            <div class="card-body">
                @if($book->transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Borrower</th>
                                    <th>Status</th>
                                    <th>Borrow Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($book->transactions->take(10) as $transaction)
                                <tr>
                                    <td>{{ $transaction->borrower->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $transaction->status === 'borrowed' ? 'warning' : 'success' }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction->borrow_date->format('Y-m-d') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No transactions yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection