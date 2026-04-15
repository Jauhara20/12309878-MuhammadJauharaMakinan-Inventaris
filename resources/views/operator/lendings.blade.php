@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <div class="card border-0 shadow-sm p-4">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold">Lending Table</h4>

            <div class="d-flex gap-2">
                <a href="{{ route('operator.lendings.export') }}" class="btn btn-primary">Export Excel</a>
                <button class="btn btn-success d-flex align-items-center gap-2"
                        data-bs-toggle="modal"
                        data-bs-target="#addLendingModal">
                    <i class="bi bi-file-earmark-plus-fill"></i> Add
                </button>
            </div>
        </div>

        <!-- ALERT -->
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Item</th>
                        <th>Total</th>
                        <th>Name</th>
                        <th>Ket.</th>
                        <th>Date</th>
                        <th>Returned</th>
                        <th>Returned By</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lendings as $lending)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $lending->item->name ?? '-' }}</td>
                            <td>{{ $lending->total }}</td>
                            <td>{{ $lending->name }}</td>
                            <td>{{ $lending->keterangan }}</td>
                            <td>{{ $lending->created_at->format('d M Y') }}</td>

                            <td>
                                @if ($lending->returned_at)
                                    <span class="badge bg-success">
                                        {{ $lending->returned_at->format('d M Y') }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Not Returned</span>
                                @endif
                            </td>

                            <td>{{ $lending->returnedBy->name ?? '-' }}</td>

                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">

                                    @if (!$lending->returned_at)
                                        <form action="{{ route('operator.lendings.returned', $lending->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-warning btn-sm">Returned</button>
                                        </form>

                                        <button class="btn btn-danger btn-sm" disabled title="Tidak bisa dihapus sebelum returned">Delete</button>
                                    @else
                                        <span class="badge bg-secondary">Already returned</span>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="addLendingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="{{ route('operator.lendings.store') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add Lending</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div id="items-container">
                        <div class="item-group border p-3 mb-2 rounded">
                            <label>Item</label>
                            <select name="items[]" class="form-control mb-2" required>
                                <option value="">-- Select Item --</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>

                            <label>Total</label>
                            <input type="number" name="totals[]" class="form-control mb-2" required>

                            <button type="button" class="btn btn-danger btn-sm remove-item d-none">Remove</button>
                        </div>
                    </div>

                    <button type="button" id="add-item" class="btn btn-secondary btn-sm mt-2">
                        + More
                    </button>

                    <div class="mt-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
document.getElementById('add-item').addEventListener('click', function () {
    let container = document.getElementById('items-container');

    let newItem = `
        <div class="item-group border p-3 mb-2 rounded">
            <label>Item</label>
            <select name="items[]" class="form-control mb-2" required>
                <option value="">-- Select Item --</option>
                @foreach ($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>

            <label>Total</label>
            <input type="number" name="totals[]" class="form-control mb-2" required>

            <button type="button" class="btn btn-danger btn-sm remove-item">Remove</button>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', newItem);
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-item')) {
        e.target.closest('.item-group').remove();
    }
});
</script>

@endsection
