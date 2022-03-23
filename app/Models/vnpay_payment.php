<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vnpay_payment extends Model
{
    use HasFactory;
    protected $fillable = [
       "order_id",
        "vnp_TransactionNo",
        "vnp_Amount",
        "vnp_BankCode",
        "vnp_CardType",
        "vnp_OrderInfo",
    ];
}
