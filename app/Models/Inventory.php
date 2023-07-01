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
        'in_quantity',
        'in_unit_price',
        'in_amount',
        'out_quantity',
        'out_unit_price',
        'out_amount',
    ];
}
