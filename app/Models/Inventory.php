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

    // itemの情報を取得する
    public function item()
    {
        return $this->belongsTo(Item::class);
    }


}
