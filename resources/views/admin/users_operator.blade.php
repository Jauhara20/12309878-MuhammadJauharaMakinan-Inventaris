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
        @if (session('success'))
            <div class="alert alert-success d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ session('success') }}</strong>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="main-content mt-2">
            <div class="card border-0 shadow-sm p-4 mb-5" style="border-radius: 12px;">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h4 class="fw-bold text-dark mb-1">operator Accounts Table</h4>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="" class="btn btn-primary">Export Excel</a>
                        <a href="#" class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal"
                            data-bs-target="#addStaffModal">
                            <i class="bi bi-file-earmark-plus-fill"></i> Add
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered border-light align-middle text-center">
                        <thead class="table-light text-secondary small">
                            <tr>
                                <th class="py-3" style="width: 70px;">No</th>
                                <th class="py-3 text-start ps-4">Name</th>
                                <th class="py-3 text-start ps-4">Email</th>
                                <th class="py-3" style="width: 250px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-start ps-4">{{ $user->name }}</td>
                                    <td class="text-start ps-4 text-secondary">{{ $user->email }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">

                                            <form action="{{ route('operator.user.resetPassword', $user->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-warning px-2">Reset Password</button>
                                            </form>

                                            <<form action="{{ route('operator.user.delete', $user->id) }}" method="POST">
    @csrf
    @method('DELETE')

    <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">
        Delete
    </button>
</form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- Modal Add Admin -->
        <div class="modal fade" id="addStaffModal" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('admin.user.store') }}" method="POST" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Staff Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label>Role</label>
                            <select name="role" class="form-control" required>
                                <option value="">-- Select Role --</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
@endsection