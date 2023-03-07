<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionSupplier extends Model
{
    use HasFactory;

        public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier','supplier_id');
    }

    public function officer()
    {
        return $this->belongsTo('App\Models\Officer','officer_id');
    }

    public function transaction_supplier_details()
    {
        return $this->hasMany('App\Models\TransactionSupplierDetail','transaction_id');
    }
}
