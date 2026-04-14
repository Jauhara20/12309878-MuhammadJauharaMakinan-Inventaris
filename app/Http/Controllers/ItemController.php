<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Exports\ItemsExport;
use Maatwebsite\Excel\Facades\Excel;


class ItemController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $items = Item::with(['category', 'lendings'])->get();

        if (auth()->user()->role === 'operator') {
            return view('operator.items', compact('items'));
        }

        return view('admin.items', compact('items', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'total' => 'required|integer'
        ]);

        Item::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'stock' => $request->total,
            'damaged_items' => 0,
            'repaired_items' => 0
        ]);

        return redirect()->back()->with('success', 'Item berhasil ditambahkan');
    }

    public function showItemStaff()
    {
        $items = Item::with(['category', 'lendings'])->get();
        return view('staff.items', compact('items'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'total' => 'required|integer|min:0',
            'new_broken' => 'nullable|integer|min:0'
        ]);

        $item = Item::findOrFail($id);
        $currentBroken = $item->damaged_items;
        $newBroken = $request->new_broken ?? 0;
        $currentLent = $item->lendings()->whereNull('returned_at')->sum('total');

        if ($request->total < $currentBroken + $currentLent) {
            return redirect()->back()
                ->withErrors(['total' => 'Total stok tidak boleh kurang dari jumlah item rusak dan item yang sedang dipinjam.'])
                ->withInput();
        }

        $availableForDamage = $request->total - $currentBroken - $currentLent;

        if ($newBroken > $availableForDamage) {
            return redirect()->back()
                ->withErrors(['new_broken' => 'Jumlah barang rusak tidak boleh melebihi stok tersedia.'])
                ->withInput();
        }

        $item->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'stock' => $request->total,
            'damaged_items' => $currentBroken + $newBroken,
        ]);

        return redirect()->back()->with('success', 'Item berhasil diupdate');

        
    }
    public function export()
    {
    return Excel::download(new ItemsExport, 'items.xlsx');
    }
}