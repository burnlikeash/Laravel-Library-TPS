<!-- resources/views/transactions/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Transactions</h2>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary">New Borrow</a>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Book</th>
                <th>Borrower</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Return Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->book->title }}</td>
                <td>{{ $transaction->borrower->name }}</td>
                <td>{{ $transaction->borrow_date->format('Y-m-d') }}</td>
                <td>{{ $transaction->due_date->format('Y-m-d') }}</td>
                <td>{{ $transaction->return_date ? $transaction->return_date->format('Y-m-d') : '-' }}</td>
                <td>
                    <span class="badge bg-{{ $transaction->status === 'borrowed' ? 'warning' : 'success' }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-info">View</a>
                    @if($transaction->status === 'borrowed')
                        <form action="{{ route('transactions.return', $transaction) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success">Return</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection