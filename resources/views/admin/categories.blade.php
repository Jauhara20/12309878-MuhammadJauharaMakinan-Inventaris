@extends('layouts.app')

@section('content')
    <div class="main-content">
        <div class="info-card mb-4 info-card shadow ">
            <div class="dropdown">
                <div class="text">
                </div>
                </ul>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card border-0 shadow-sm p-4" style="border-radius: 12px;">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Categories Table</h4>
                </div>
                <a href="" class="btn btn-success px-3 py-2 fw-bold d-flex align-items-center gap-2"
                    style="border: none; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="bi bi-plus-lg"></i> Add
                </a>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered border-light align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 text-secondary">No</th>
                            <th class="py-3 text-secondary">Name</th>
                            <th class="py-3 text-secondary">Division PJ</th>
                            <th class="py-3 text-secondary">Total Items</th>
                            <th class="py-3 text-secondary">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="py-3">{{ $loop->iteration }}</td>
                                <td class="py-3 text-start ps-4">{{ $category->name }}</td>
                                <td class="py-3">{{ $category->division }}</td>
                                <td class="py-3">{{ $category->items_count }}</td>
                                <td class="py-3">
                                    <button class="btn btn-primary px-4 edit-btn" data-id="{{ $category->id }}"
                                        data-name="{{ $category->name }}" data-division="{{ $category->division }}"
                                        data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                                        style="border: none; border-radius: 6px;">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-3">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Add Category -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCategoryLabel">Add Category Forms</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Category Name"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="division" class="form-label">Division PJ</label>
                                <select name="division" id="division" class="form-select" required>
                                    <option value="">-- Select Division --</option>
                                    <option value="Sarpras">Sarpras</option>
                                    <option value="Tata Usaha">Tata Usaha</option>
                                    <option value="Tefa">Tefa</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Edit Category --}}
        <div class="modal fade" id="editCategoryModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title">Edit Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" id="editName" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Division</label>
                                <select name="division" id="editDivision" class="form-select" required>
                                    <option value="Sarpras">Sarpras</option>
                                    <option value="Tata Usaha">Tata Usaha</option>
                                    <option value="Tefa">Tefa</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <script>
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function () {
                    let id = this.getAttribute('data-id');
                    let name = this.getAttribute('data-name');
                    let division = this.getAttribute('data-division');

                    // isi input
                    document.getElementById('editName').value = name;
                    document.getElementById('editDivision').value = division;

                    // set action form
                    document.getElementById('editForm').action = `/admin/categories/${id}`;
                });
            });
        </script>
@endsection