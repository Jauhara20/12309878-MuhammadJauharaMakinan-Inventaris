<?php

namespace App\Http\Controllers;

use App\Exports\LendingsExport;
use App\Models\Lending;
use Illuminate\Http\Request;
use App\Models\Item;
use Maatwebsite\Excel\Facades\Excel;

class LendingController extends Controller
{
     public function index()
    {
        $lendings = Lending::with(['item', 'returnedBy'])->get();
        $items = Item::all();

        return view('operator.lendings', compact('lendings', 'items'));
    }

    public function detail($itemId)
    {
            $item = Item::with('lendings')->findOrFail($itemId);

        return view('admin.detail', compact('item'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'items' => 'required|array',
            'totals' => 'required|array',
        ]);

        $totalsByItem = [];
        foreach ($request->items as $index => $itemId) {
            $itemId = intval($itemId);
            $quantity = intval($request->totals[$index]);

            if ($itemId <= 0 || $quantity <= 0) {
                continue;
            }

            $totalsByItem[$itemId] = ($totalsByItem[$itemId] ?? 0) + $quantity;
        }

        foreach ($totalsByItem as $itemId => $totalQuantity) {
            $item = Item::find($itemId);
            if (! $item) {
                return redirect()->back()->with('error', 'Item tidak ditemukan.');
            }

            $available = $item->available;
            if ($totalQuantity > $available) {
                return redirect()->back()->with('error', 'Jumlah peminjaman melebihi stok tersedia. Tersedia: ' . $available);
            }
        }

        foreach ($request->items as $index => $itemId) {
            $itemId = intval($itemId);
            $quantity = intval($request->totals[$index]);

            if ($itemId <= 0 || $quantity <= 0) {
                continue;
            }

            Lending::create([
                'name' => $request->name,
                'item_id' => $itemId,
                'total' => $quantity,
                'keterangan' => $request->keterangan,
            ]);
        }

        return redirect()->back()->with('success', 'Lending berhasil ditambahkan');
    }

    public function returned($id)
    {
        $lending = Lending::findOrFail($id);

        if ($lending->returned_at) {
            return redirect()->back()->with('success', 'Item sudah dikembalikan.');
        }

        $lending->returned_at = now();
        $lending->returned_by = auth()->id();
        $lending->save();

        return redirect()->back()->with('success', 'Item dikembalikan oleh ' . auth()->user()->name);
    }


    public function export()
    {
        return Excel::download(new LendingsExport, 'lendings.xlsx');
    }

    public function destroy($id)
    {
        $lending = Lending::findOrFail($id);

        if (! $lending->returned_at) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus peminjaman yang masih dalam peminjaman.');
        }

        $lending->delete();
        return redirect()->back()->with('success', 'Lending deleted');
    }

}
