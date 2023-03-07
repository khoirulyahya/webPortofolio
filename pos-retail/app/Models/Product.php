<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
         return $this->belongsTo('App\Models\Category','category_id');
    }

    public function transaction_sale_details()
    {
        return $this->hasMany('App\Models\Product','product_id');
    }

    public function transaction_supplier_details()
    {
        return $this->hasMany('App\Models\Product','product_id');
    }
}
