<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') — Byward Logistics</title>
    
    <link rel="icon" href="{{ asset('images/logo1.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    @vite(['resources/scss/app.scss'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f6f8fb;
            color: #46536b;
            min-height: 100vh;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: #0b1f3f;
        }
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background-color: #071528;
            color: #fff;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            padding: 1.5rem 1rem;
            position: sticky;
            top: 0;
            height: 100vh;
        }
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 1.5rem;
            text-decoration: none;
            color: #fff;
        }
        .sidebar-brand img {
            height: 38px;
            width: auto;
        }
        .sidebar-brand span {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 1.2rem;
            letter-spacing: -0.5px;
        }
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            flex-grow: 1;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.8rem 1rem;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.08);
            color: #fff;
        }
        .sidebar-link.active {
            border-left: 3px solid #c8202c;
            background-color: rgba(255, 255, 255, 0.05);
        }
        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 1rem;
        }
        .content-area {
            flex-grow: 1;
            padding: 2.5rem;
            overflow-y: auto;
        }
        .card-stat {
            background-color: #fff;
            border: 1px solid rgba(16, 42, 85, 0.08);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(11, 31, 63, 0.03);
            transition: transform 0.2s ease;
        }
        .card-stat:hover {
            transform: translateY(-2px);
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .bg-red-light { background-color: rgba(200, 32, 44, 0.1); color: #c8202c; }
        .bg-navy-light { background-color: rgba(29, 66, 136, 0.1); color: #1d4288; }
        .bg-green-light { background-color: rgba(25, 135, 84, 0.1); color: #198754; }
        .bg-orange-light { background-color: rgba(253, 126, 20, 0.1); color: #fd7e14; }
        
        .badge-handled {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
            padding: 0.35rem 0.65rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-pending {
            background-color: rgba(253, 126, 20, 0.1);
            color: #fd7e14;
            padding: 0.35rem 0.65rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('images/logo-light1.png') }}" alt="Logo">
            <span>Byward Admin</span>
        </a>
        
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <x-icon name="layers" size="18" />
                Dashboard
            </a>
            <a href="{{ route('admin.leads.index') }}" class="sidebar-link {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">
                <x-icon name="mail" size="18" />
                Leads & Requests
            </a>
            <a href="{{ route('admin.shipments.index') }}" class="sidebar-link {{ request()->routeIs('admin.shipments.*') ? 'active' : '' }}">
                <x-icon name="truck" size="18" />
                Track Shipments
            </a>
            <a href="{{ route('admin.jobs.index') }}" class="sidebar-link {{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}">
                <x-icon name="users" size="18" />
                Job Openings
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <div class="d-flex align-items-center justify-content-between">
                <div class="small text-white-50">
                    Logged in as:<br>
                    <strong class="text-white">{{ auth()->user()->name }}</strong>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm px-2 py-1" title="Log out">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="content-area">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @yield('content')
    </main>
</div>

</body>
</html>
