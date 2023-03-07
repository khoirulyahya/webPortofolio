<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;

    public function transaction_sale()
    {
        return $this->hasOne('App\Models\TransactionSale','officer_id');
    }

    public function transaction_supplier()
    {
        return $this->hasOne('App\Models\TransactionSupplier','officer_id');
    }
}
