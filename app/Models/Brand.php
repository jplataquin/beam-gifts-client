<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Item;
class Brand extends Model
{   
    protected $connection = 'mysql2';
    protected $table = 'brands';
    use HasFactory;

    public function items(){
        return $this->hasMany(Item::class,'brand_id','id');
    }
    
}
