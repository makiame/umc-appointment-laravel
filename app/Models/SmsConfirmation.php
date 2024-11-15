<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsConfirmation extends Model
{
    protected $fillable = [
        'phone',
        'code'
    ];
}
