<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingItem extends Model
{
    use HasFactory;
    protected $table = 'incoming_items';

    protected $fillable = [
        'item_id',
        'supplier_id',
        'entry_date',
        'quantity',
    ];

    public function items(){
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function suppliers(){
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
