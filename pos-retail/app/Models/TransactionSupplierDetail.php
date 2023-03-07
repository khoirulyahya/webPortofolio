<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionSupplierDetail extends Model
{
    use HasFactory;

    public function transaction_supplier()
    {
        return $this->belongsTo('App\Models\TransactionSupplier','transaction_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\TransactionSale','product_id');
    }
}
