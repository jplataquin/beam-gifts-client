<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OrderItem;

class Order extends Model
{
    protected $table = 'orders';
    use HasFactory;

    public function items()
    {
        return $this->hasMany(OrderItem::class,'uid','uid');
    }
}
