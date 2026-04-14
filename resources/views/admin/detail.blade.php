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

        <div class="container mt-4">
            <div class="card border-0 shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.items') }}" class="btn btn-success d-flex align-items-center gap-2">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Item</th>
                                <th>Total</th>
                                <th>Name</th>
                                <th>Ket.</th>
                                <th>Date</th>
                                <th>Returned</th>
                                <th>Edited By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($item->lendings as $lending)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $lending->item->name }}</td>
                                    <td>{{ $lending->total }}</td>
                                    <td>{{ $lending->name }}</td>
                                    <td>{{ $lending->keterangan }}</td>
                                    <td>{{ $lending->created_at->format('d M, Y') }}</td>
                                    <td>
                                        @if ($lending->returned_at)
                                            <span class="badge bg-success">
                                                {{ $lending->returned_at->format('d M, Y') }}
                                            </span>
                                        @else
                                            <span class="badge-not-returned">not returned</span>
                                        @endif
                                    </td>
                                    <td>operator</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection