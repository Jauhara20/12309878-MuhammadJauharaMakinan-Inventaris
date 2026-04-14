<?php

namespace App\Http\Controllers;

use App\Models\lending;
use Illuminate\Http\Request;
use App\Models\Item;

class LendingController extends Controller
{
     public function index()
    {
        $lendings = Lending::with('item')->get();
        $items = Item::all();

        return view('operator.lendings', compact('lendings', 'items'));
    }

    public function detail($itemId)
    {
        $item = Item::with('lendings')->findOrFail($itemId);

        return view('admin.lending_detail', compact('item'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'items' => 'required|array',
            'totals' => 'required|array',
        ]);

        foreach ($request->items as $index => $itemId) {

            $item = Item::find($itemId);

            $available = $item->stock - $item->lending_total;

            if ($request->totals[$index] > $available) {
                return redirect()->back()->with('error', 'total item more than available');
            }

            Lending::create([
                'name' => $request->name,
                'item_id' => $itemId,
                'total' => $request->totals[$index],
                'keterangan' => $request->keterangan,
            ]);
        }

        return redirect()->back()->with('success', 'Lending berhasil ditambahkan');
    }

    public function returned($id)
    {
        $lending = Lending::findOrFail($id);

        $lending->returned_at = now();
        $lending->save();


        $item = $lending->item;
        $item->stock += $lending->total;
        $item->save();

        return redirect()->back()->with('success', 'Item returned');
    }


    public function destroy($id)
    {
        $lending = Lending::findOrFail($id);

        if (is_null($lending->return_date)) {
            $item = $lending->item;
            $item->stock += $lending->total;
            $item->save();
        }

        $lending->delete();

        return redirect()->back()->with('success', 'Lending deleted');
    }

    
}
