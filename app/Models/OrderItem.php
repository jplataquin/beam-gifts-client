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
        return $this->belongsTo('App\Models\Order','uid','uid');
    }

    public function model(){
        return $this->belongsTo('App\Model\Item','id','item_id');
    }
}
