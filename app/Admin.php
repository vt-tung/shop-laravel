<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'admin_email','admin_name','admin_password','admin_phone','admin_role','created_at'
    ];
    protected $primaryKey = 'admin_id';
    protected $table = 'tbl_admin';
}
