<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { margin: 0; overflow-x: hidden; }

        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: #2f4aa0;
            color: white;
        }

        .sidebar .nav-link { color: #cfd8ff; font-weight: 500; }
        .sidebar .nav-link:hover { background: rgba(255,255,255,0.1); color: #fff; }

        .sidebar .section-title { font-size: 14px; color: #aab4ff; margin: 15px 0 5px; }

        .content { margin-left: 260px; }

        .topbar {
            background: url('https://images.unsplash.com/photo-1501785888041-af3ef285b470') center/cover;
            height: 180px;
            color: white;
        }

        .topbar-overlay {
            background: rgba(0,0,0,0.4);
            height: 100%;
            padding: 20px;
        }

        .card-welcome {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-top: -40px;
        }

        .sidebar .nav-link.active {
            background-color: #4a67ff;
            color: white;
        }
    </style>
</head>
<body>

<div class="sidebar p-3">
    <h5 class="text-center mb-4">Menu</h5>

    <ul class="nav flex-column">

        <!-- DASHBOARD -->
        <li class="nav-item mb-2">
            @if(auth()->user()->role == 'admin')
                <a href="/admin" class="nav-link">
            @else
                <a href="/operator" class="nav-link">
            @endif
                <i class="bi bi-grid me-2"></i> Dashboard
            </a>
        </li>

        <!-- ================= ITEMS ================= -->
        <div class="section-title">Items Data</div>

        <!-- Categories hanya admin -->
        @if(auth()->user()->role == 'admin')
        <li class="nav-item mb-2">
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}">
                <i class="bi bi-list me-2"></i> Categories
            </a>
        </li>
        @endif

        <!-- Items (admin & operator bisa lihat) -->
        <li class="nav-item mb-2">
            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.items.index') }}" class="nav-link {{ request()->routeIs('admin.items.index') ? 'active' : '' }}">
            @else
                <a href="{{ route('operator.items.index') }}" class="nav-link {{ request()->routeIs('operator.items.index') ? 'active' : '' }}">
            @endif
                <i class="bi bi-pie-chart me-2"></i> Items
            </a>
        </li>

        <!-- Lending hanya operator -->
        @if(auth()->user()->role == 'operator')
        <li class="nav-item mb-2">
            <a href="{{ route('operator.lendings.index') }}" class="nav-link {{ request()->routeIs('operator.lendings.index') ? 'active' : '' }}">
                <i class="bi bi-arrow-left-right me-2"></i> Lending
            </a>
        </li>
         <div class="section-title">Accounts</div>

        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse" href="#usersMenu">
                <span><i class="bi bi-person me-2"></i> Users</span>
                <i class="bi bi-chevron-down"></i>
            </a>

            <div class="collapse ps-3" id="usersMenu">
                <ul class="nav flex-column">
                    <li>
                        <a href="{{ route('admin.users_admin') }}" class="nav-link">• Admin</a>
                    </li>
                      </div>


        @endif

        <!-- ================= USERS ================= -->
        @if(auth()->user()->role == 'admin')
        <div class="section-title">Accounts</div>

        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse" href="#usersMenu">
                <span><i class="bi bi-person me-2"></i> Users</span>
                <i class="bi bi-chevron-down"></i>
            </a>

            <div class="collapse ps-3" id="usersMenu">
                <ul class="nav flex-column">
                    <li>
                        <a href="{{ route('admin.users_admin') }}" class="nav-link">• Admin</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users_operator') }}" class="nav-link">• Operator</a>
                    </li>
                </ul>
            </div>
        </li>
        @endif

    </ul>
</div>

<!-- CONTENT -->
<div class="content">
    <div class="topbar">
        <div class="topbar-overlay d-flex justify-content-between align-items-start">
            <span class="ms-2 fw-bold">Welcome Back, {{ Auth::user()->name }}</span>

            <div class="dropdown mt-2">
                <a class="text-white dropdown-toggle text-decoration-none" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">    
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <div class="card-welcome"></div>

        <div class="mt-4">
            @yield('content')
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>