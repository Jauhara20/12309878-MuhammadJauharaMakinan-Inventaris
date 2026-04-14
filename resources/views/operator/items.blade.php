@extends('layouts.app')

@section('content')
    <div class="main-content">
        <div class="info-card mb-4 info-card shadow ">
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

        <div class="card border-0 shadow-sm p-4 mb-5 mt-4" style="border-radius: 12px;">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Items Table</h4>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th scope="col">Category</th>
                        <th scope="col">Name</th    >
                        <th scope="col">Total</th>
                        <th scope="col">Rusak</th>
                        <th scope="col">Lending Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>{{ $item->damaged_items }}</td>
                            <td>{{ $item->lending_total }}</td>
                        </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection