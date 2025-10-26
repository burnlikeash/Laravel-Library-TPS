<!-- resources/views/books/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Books</h2>
    <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Total Qty</th>
                <th>Available</th>
                <th>Borrowed</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->isbn }}</td>
                <td>{{ $book->quantity }}</td>
                <td>{{ $book->available_quantity }}</td>
                <td>{{ $book->active_borrows_count }}</td>
                <td>
                    <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection