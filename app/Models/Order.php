<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "order";
    protected $fillable = [
        'total',
        'discount',
        'subtotal',
        'status',
        'text',
        'customer_id',
    ];
}