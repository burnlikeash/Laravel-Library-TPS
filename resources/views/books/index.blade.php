<!-- resources/views/books/index.blade.php -->
@extends('layouts.app')

@section('title', 'Books - Library TPS')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title">
                <i class="fas fa-book me-2"></i>
                Books Management
            </h1>
            <a href="{{ route('books.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New Book
            </a>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="bookSearch" class="form-control" placeholder="Search books by title, author, or ISBN...">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-auto">
                        <span class="badge bg-primary">Total: {{ $books->count() }} books</span>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-success">Available: {{ $books->sum('available_quantity') }}</span>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-warning">Borrowed: {{ $books->sum('quantity') - $books->sum('available_quantity') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Books Table -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-list me-2"></i>
        All Books
    </div>
    <div class="card-body">
        @if($books->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover" id="booksTable">
                    <thead>
                        <tr>
                            <th><i class="fas fa-book me-1"></i>Title</th>
                            <th><i class="fas fa-user-edit me-1"></i>Author</th>
                            <th><i class="fas fa-barcode me-1"></i>ISBN</th>
                            <th><i class="fas fa-layer-group me-1"></i>Total</th>
                            <th><i class="fas fa-check me-1"></i>Available</th>
                            <th><i class="fas fa-hand-holding me-1"></i>Borrowed</th>
                            <th><i class="fas fa-cogs me-1"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ $book->title }}</strong>
                                    @if($book->available_quantity == 0)
                                        <span class="badge bg-danger ms-2">Out of Stock</span>
                                    @elseif($book->available_quantity <= 2)
                                        <span class="badge bg-warning ms-2">Low Stock</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $book->author }}</td>
                            <td>
                                <code>{{ $book->isbn }}</code>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $book->quantity }}</span>
                            </td>
                            <td>
                                <span class="badge bg-success">{{ $book->available_quantity }}</span>
                            </td>
                            <td>
                                <span class="badge bg-warning">{{ $book->active_borrows_count }}</span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('books.show', $book) }}" 
                                       class="btn btn-sm btn-outline-info" 
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('books.edit', $book) }}" 
                                       class="btn btn-sm btn-outline-warning" 
                                       title="Edit Book">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('books.destroy', $book) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="Delete Book"
                                                onclick="return confirmDelete('{{ $book->title }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-book fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No Books Available</h4>
                <p class="text-muted">Start building your library by adding your first book!</p>
                <a href="{{ route('books.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Your First Book
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Live search functionality
    document.getElementById('bookSearch').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#booksTable tbody tr');
        
        tableRows.forEach(row => {
            const title = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            const author = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const isbn = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            
            if (title.includes(searchValue) || author.includes(searchValue) || isbn.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection