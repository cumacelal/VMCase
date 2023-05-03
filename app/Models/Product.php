<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "product";
    protected $fillable = [
        'name',
        'visible',
        'price',
        'stock',
        'category_id'
    ];

    public static function getStock($product_id,$quantity)
    {
          
       $stock =  Product::where('id',$product_id)->get()->first()->stock ?? 0;
       if( $stock < $quantity)
       return false;
       else 
       return true;
    }
    public static function setStock($product_id,$quantity)
    {
        $product =  Product::find($product_id);
        if( $product->stock > $quantity )
        {
            $product->stock = $product->stock - $quantity ; 
            $product->save();
        }
        else
        {
            //bu duruma gelmeyecek çünkü ilk fonk.bunu kontrol ediyor.
            dd("Stok hatası");
        }

    }

}
