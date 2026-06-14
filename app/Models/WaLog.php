<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaLog extends Model
{
    protected $fillable = [
        'recipient_phone', 'message', 'type', 'status',
        'reference_id', 'reference_type', 'response',
    ];
}
