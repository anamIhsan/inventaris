<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;
    protected $table = 'borrowings';

    protected $fillable = [
        'name',
        'item_id',
        'quantity',
        'borrowed_at',
        'returned_at',
        'condition',
        'status',
    ];

    public function items()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
