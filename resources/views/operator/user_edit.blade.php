@extends('layouts.app')

@section('content')
    <div class="main-content">
        <div class="info-card">
            <div class="text-secondary">Check menu in sidebar</div>

            <div class="dropdown">
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

        <div class="card border-0 shadow-sm rounded-3 p-4">
            <div class="d-flex justify-content-between align-items-start mb-1">
                <div>
                    <h4 class="fw-bold mb-1">Edit Account Forms</h4>
                </div>
            </div>

            <form action="{{ route('staff.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark mb-2">Name</label>
                    <input type="text" name="name" class="form-control form-control-lg border-light bg-light fs-6 py-3"
                        style="background-color: #f8f9fa !important;" value="{{ old('name', $user->name) }}" required>
                </div>


                <div class="mb-4">
                    <label class="form-label fw-bold text-dark mb-2">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg border-light bg-light fs-6 py-3"
                        style="background-color: #f8f9fa !important;" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark mb-2">
                        New Password <span class="text-warning fw-normal">optional</span>
                    </label>
                    <input type="password" name="password"
                        class="form-control form-control-lg border-light bg-light fs-6 py-3"
                        style="background-color: #f8f9fa !important;" placeholder="Kosongkan jika tidak diubah">
                </div>

                <div class="d-flex justify-content-end gap-2 mt-5">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary px-4 py-2 fw-bold border-0">Cancel</a>
                    <button type="submit" class="btn btn-success px-4 py-2 fw-bold border-0">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection