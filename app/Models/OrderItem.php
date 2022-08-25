<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Order;

class OrderItem extends Model
{
    protected $table = 'order_items';
    use HasFactory;

    public function order()
    {
        return $this->belongsTo(Order::class,'uid','uid');
    }
}
