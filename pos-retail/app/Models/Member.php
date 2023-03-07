<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public function transaction_sale()
    {
        return $this->hasOne('App\Models\TransactionSale','member_id');
    }
}
