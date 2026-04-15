<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    protected $fillable = [
        'name',
        'item_id',
        'total',
        'keterangan',
        'returned_at',
        'returned_by',
    ];

    protected $casts = [
        'returned_at' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function returnedBy()
    {
        return $this->belongsTo(User::class, 'returned_by');
    }
}
