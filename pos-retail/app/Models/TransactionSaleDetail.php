<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionSaleDetail extends Model
{
    use HasFactory;

    public function transaction_sale()
    {
        return $this->belongsTo('App\Models\TransactionSale','transaction_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
