<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'p_transaction_id', 'customer_id', 'p_transection_code', 'p_money', 'p_note', 'p_vnp_response_code', 'p_code_vnpay', 'p_code_bank', 'time'
    ];
    protected $primaryKey = 'id';
    protected $table = 'payments';
}
