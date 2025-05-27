<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'image',
        'address',
        'phone',
    ];

    public function incomingItems(){
        return $this->hasMany(IncomingItem::class, 'supplier_id');
    }
}
