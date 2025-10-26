<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Library TPS')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --dark-color: #34495e;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-color) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar-brand i {
            color: var(--secondary-color);
            margin-right: 0.5rem;
        }

        .nav-link {
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 5px;
            margin: 0 0.2rem;
        }

        .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            transform: translateY(-1px);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .card-header {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #2980b9 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            font-weight: 600;
            padding: 1rem 1.5rem;
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1.2rem;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #2980b9 100%);
            border: none;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #219a52 100%);
            border: none;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #c0392b 100%);
            border: none;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, #e67e22 100%);
            border: none;
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        }

        .table thead {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-color) 100%);
            color: white;
        }

        .table tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.1);
            transform: scale(1.02);
            transition: all 0.2s ease;
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
        }

        .dashboard-stats {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #2980b9 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            display: block;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .page-title {
            color: var(--primary-color);
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .action-buttons .btn {
            margin: 0 0.2rem;
        }

        .status-borrowed {
            background: linear-gradient(135deg, var(--warning-color) 0%, #e67e22 100%);
        }

        .status-returned {
            background: linear-gradient(135deg, var(--success-color) 0%, #219a52 100%);
        }

        .overdue-alert {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(231, 76, 60, 0); }
            100% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0); }
        }

        .sidebar {
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--dark-color) 100%);
            min-height: calc(100vh - 76px);
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 1rem 1.5rem;
            border-radius: 0;
            margin: 0.2rem 1rem;
        }

        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('books.index') }}">
                <i class="fas fa-book"></i>
                Library TPS
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}" href="{{ route('books.index') }}">
                            <i class="fas fa-book me-1"></i> Books
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('borrowers.*') ? 'active' : '' }}" href="{{ route('borrowers.index') }}">
                            <i class="fas fa-users me-1"></i> Borrowers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                            <i class="fas fa-exchange-alt me-1"></i> Transactions
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transactions.create') }}">
                            <i class="fas fa-plus me-1"></i> Quick Borrow
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            <i class="fas fa-calendar me-1"></i> {{ date('M d, Y') }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Confirmation dialogs
        function confirmDelete(itemName) {
            return confirm(`Are you sure you want to delete "${itemName}"? This action cannot be undone.`);
        }
        
        function confirmReturn(bookTitle) {
            return confirm(`Mark "${bookTitle}" as returned?`);
        }
    </script>
    @yield('scripts')
</body>
</html>