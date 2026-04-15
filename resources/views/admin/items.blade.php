@extends('layouts.app')

@section('content')
    <div class="main-content">
        <div class="info-card mb-4 info-card shadow ">
                </ul>
            </div>
        </div>

        <!-- Items Table -->
        <div class="card border-0 shadow-sm p-4 mb-5" style="border-radius: 12px;">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Items Table</h4>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.items.export') }}" class="btn btn-primary">
                         Export Excel
                            </a>
                    <a href="#" class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal"
                        data-bs-target="#addItemModal">
                        <i class="bi bi-plus-lg"></i> Add
                    </a>
                </div>
            </div>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered border-light align-middle text-center">
                    <thead class="table-light text-secondary small text-uppercase">
                        <tr>
                            <th class="py-3">No</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Name</th>
                            <th class="py-3">Total</th>
                            <th class="py-3">Repair</th>
                            <th class="py-3">Lending</th>
                            <th class="py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start ps-4">
                                    {{ $item->category->name ?? '-' }}
                                </td>
                                <td class="text-start ps-4">{{ $item->name }}</td>
                                <td>{{ $item->stock }}</td>
                                <td>{{ $item->damaged_items }}</td>
                                <td>
                                    @if ($item->lending_total > 0)
                                        <a href="{{ route('admin.items.detail', $item->id) }}"
                                            class="text-primary fw-bold text-decoration-underline">
                                            {{ $item->lending_total }}
                                        </a>
                                    @else
                                        <span class="text-muted">0</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="#" class="btn btn-primary btn-sm px-4" data-bs-toggle="modal"
                                            data-bs-target="#editItemModal" data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}" data-category="{{ $item->category_id }}"
                                            data-stock="{{ $item->stock }}" data-damaged="{{ $item->damaged_items }}">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus item ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm px-3">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Data belum ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Add Item -->
    <div class="modal fade" id="addItemModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 12px;">
                <div class="modal-header">
                    <h5 class="modal-title">Add Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.items.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Choose Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total</label>
                            <input type="number" name="total" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Item -->
    <div class="modal fade" id="editItemModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 12px;">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" id="edit_category" class="form-select" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total</label>
                            <input type="number" name="total" id="edit_total" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                New Broken Item <span class="text-warning small">(Currently: <span
                                        id="currentBroken">0</span>)</span>
                            </label>
                            <input type="number" name="new_broken" class="form-control" value="0" min="0">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- buat isi data ke modal --}}
    <script>
        const editModal = document.getElementById('editItemModal');

        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const category = button.getAttribute('data-category');
            const stock = button.getAttribute('data-stock');
            const damaged = button.getAttribute('data-damaged');

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_category').value = category;
            document.getElementById('edit_total').value = stock;

            document.getElementById('currentBroken').innerText = damaged;
            document.getElementById('editForm').action = `/admin/items/${id}`;
        });
    </script>
@endsection
