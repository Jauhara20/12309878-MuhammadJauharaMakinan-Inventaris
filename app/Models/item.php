<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'stock',
        'damaged_items',
        'repaired_items'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function lendings()
    {
        return $this->hasMany(Lending::class);
    }

    public function getAvailableAttribute()
    {
        $lending = $this->lendings()
            ->whereNull('returned_at') // ⬅️ penting
            ->sum('total');

        $repair = $this->damaged_items;

        return max(0, $this->stock - $lending - $repair);
    }

    public function getLendingTotalAttribute()
    {
        return $this->lendings()
            ->whereNull('returned_at') // ⬅️ penting
            ->sum('total');
    }
}