<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'items';

    use HasFactory;

}
