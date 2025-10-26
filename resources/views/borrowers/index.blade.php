<!-- resources/views/borrowers/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Borrowers</h2>
    <a href="{{ route('borrowers.create') }}" class="btn btn-primary">Add Borrower</a>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Active Borrows</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($borrowers as $borrower)
            <tr>
                <td>{{ $borrower->name }}</td>
                <td>{{ $borrower->email }}</td>
                <td>{{ $borrower->phone }}</td>
                <td>{{ $borrower->active_borrows_count }}</td>
                <td>
                    <a href="{{ route('borrowers.show', $borrower) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('borrowers.edit', $borrower) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('borrowers.destroy', $borrower) }}" method="POST" class="d-inline">
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