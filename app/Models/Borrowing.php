<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;
    protected $table = 'borrowings';

    protected $fillable = [
        'user_id',
        'item_id',
        'quantity',
        'borrowed_at',
        'returned_at',
        'condition',
        'status',
        'catatan',
    ];

    public function items()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
