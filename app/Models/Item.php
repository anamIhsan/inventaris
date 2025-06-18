<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';

    protected $fillable = [
        'category_id',
        'name',
        'image',
        'condition',
        'price',
        'funding_source',
        'description',
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

    public function categories(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
