<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExitItem extends Model
{
    use HasFactory;
    protected $table = 'exit_items';

    protected $fillable = [
        'item_id',
        'date_out',
        'quantity',
        'location',
        'recipient',
        'notes',
    ];

    public function items()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
