<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionSale extends Model
{
    use HasFactory;

    public function member()
    {
        return $this->belongsTo('App\Models\Member','member_id');
    }

    public function officer()
    {
        return $this->belongsTo('App\Models\Officer','officer_id');
    }

    public function transaction_sale_details()
    {
        return $this->hasMany('App\Models\TransactionSaleDetail','transaction_id');
    }
}
