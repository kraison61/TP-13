<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneClickLog extends Model
{
    protected $fillable = [
        'phone',
        'page_url',
        'placement',
        'ip_address',
        'user_agent',
    ];
}
