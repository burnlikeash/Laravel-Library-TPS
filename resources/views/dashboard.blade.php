<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard - Library TPS')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="page-title">
            <i class="fas fa-tachometer-alt me-2"></i>
            Dashboard
        </h1>
    </div>
</div>

<!-- Statistics Cards -->
<div class="dashboard-stats">
    <div class="row">
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card">
                <i class="fas fa-book fa-2x mb-2"></i>
                <span class="stat-number">{{ $stats['total_books'] }}</span>
                <span class="stat-label">Total Books</span>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card">
                <i class="fas fa-users fa-2x mb-2"></i>
                <span class="stat-number">{{ $stats['total_borrowers'] }}</span>
                <span class="stat-label">Borrowers</span>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card">
                <i class="fas fa-hand-holding fa-2x mb-2"></i>
                <span class="stat-number">{{ $stats['active_transactions'] }}</span>
                <span class="stat-label">Active Borrows</span>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card">
                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                <span class="stat-number text-warning">{{ $stats['overdue_books'] }}</span>
                <span class="stat-label">Overdue Books</span>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <span class="stat-number">{{ $stats['available_books'] }}</span>
                <span class="stat-label">Available Books</span>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="stat-card">
                <a href="{{ route('transactions.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus"></i> Quick Borrow
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Transactions -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-clock me-2"></i>
                Recent Transactions
            </div>
            <div class="card-body">
                @if($recent_transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Book</th>
                                    <th>Borrower</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_transactions as $transaction)
                                <tr>
                                    <td>
                                        <strong>{{ $transaction->book->title }}</strong><br>
                                        <small class="text-muted">{{ $transaction->book->author }}</small>
                                    </td>
                                    <td>{{ $transaction->borrower->name }}</td>
                                    <td>
                                        <span class="badge status-{{ $transaction->status }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction->borrow_date->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('transactions.index') }}" class="btn btn-outline-primary">
                            View All Transactions <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No transactions yet</p>
                        <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                            Create First Transaction
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Overdue Books Alert -->
    <div class="col-lg-4 mb-4">
        <div class="card {{ $stats['overdue_books'] > 0 ? 'overdue-alert border-danger' : '' }}">
            <div class="card-header {{ $stats['overdue_books'] > 0 ? 'bg-danger' : '' }}">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Overdue Books
            </div>
            <div class="card-body">
                @if($overdue_transactions->count() > 0)
                    @foreach($overdue_transactions as $transaction)
                    <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                        <div>
                            <strong>{{ $transaction->book->title }}</strong><br>
                            <small class="text-muted">{{ $transaction->borrower->name }}</small><br>
                            <small class="text-danger">Due: {{ $transaction->due_date->format('M d, Y') }}</small>
                        </div>
                        <form action="{{ route('transactions.return', $transaction) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success" 
                                    onclick="return confirmReturn('{{ $transaction->book->title }}')">
                                Return
                            </button>
                        </form>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <p class="text-muted mb-0">No overdue books!</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i>
                Quick Actions
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('books.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i>Add New Book
                    </a>
                    <a href="{{ route('borrowers.create') }}" class="btn btn-outline-info">
                        <i class="fas fa-user-plus me-2"></i>Add New Borrower
                    </a>
                    <a href="{{ route('transactions.create') }}" class="btn btn-outline-success">
                        <i class="fas fa-hand-holding me-2"></i>New Borrow Transaction
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection