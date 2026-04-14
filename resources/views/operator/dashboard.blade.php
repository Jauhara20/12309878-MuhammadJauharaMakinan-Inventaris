@extends('layouts.app')

@section('content')
    <div class="main-content">
        <div class="info-card mb-4 info-card shadow ">
            <div class="text-secondary">Check menu in sidebar</div>

            <div class="dropdown">
                <div class="user-profile-dropdown dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-2 text-dark"></i>
                    <span class="text-dark fw-bold">{{ Auth::user()->name }}</span>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection