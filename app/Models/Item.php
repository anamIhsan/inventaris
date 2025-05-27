<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';

    protected $fillable = [
        'name',
        'image',
        'specification',
        'location',
        'condition',
        'quantity',
        'funding_source',
        'description',
        'item_type',
    ];

    public function incomingItems()
    {
        return $this->hasMany(IncomingItem::class, 'item_id');
    }

    public function exitItems()
    {
        return $this->hasMany(ExitItem::class, 'item_id');
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class, 'item_id');
    }
}
