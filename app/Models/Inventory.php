<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'in-quantity',
        'in-unit-price',
        'in-amount',
        'out-quantity',
        'out-unit-price',
        'out-amount',
    ];
}
