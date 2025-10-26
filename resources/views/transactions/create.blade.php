<!-- resources/views/transactions/create.blade.php -->
@extends('layouts.app')

@section('content')
<h2>New Book Borrowing</h2>

<form action="{{ route('transactions.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="book_id" class="form-label">Book</label>
        <select class="form-select @error('book_id') is-invalid @enderror" id="book_id" name="book_id">
            <option value="">Select a book</option>
            @foreach($books as $book)
                <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                    {{ $book->title }} - {{ $book->author }} (Available: {{ $book->available_quantity }})
                </option>
            @endforeach
        </select>
        @error('book_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="borrower_id" class="form-label">Borrower</label>
        <select class="form-select @error('borrower_id') is-invalid @enderror" id="borrower_id" name="borrower_id">
            <option value="">Select a borrower</option>
            @foreach($borrowers as $borrower)
                <option value="{{ $borrower->id }}" {{ old('borrower_id') == $borrower->id ? 'selected' : '' }}>
                    {{ $borrower->name }} - {{ $borrower->email }}
                </option>
            @endforeach
        </select>
        @error('borrower_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="borrow_date" class="form-label">Borrow Date</label>
        <input type="date" class="form-control @error('borrow_date') is-invalid @enderror" id="borrow_date" name="borrow_date" value="{{ old('borrow_date', date('Y-m-d')) }}">
        @error('borrow_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="due_date" class="form-label">Due Date</label>
        <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date', date('Y-m-d', strtotime('+14 days'))) }}">
        @error('due_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Create Transaction</button>
    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection