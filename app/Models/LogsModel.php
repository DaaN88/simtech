<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogsModel extends Model
{
    protected $table = 'logs';

    protected $fillable = [
        'api_url',
        'request',
        'response',
        'created_at',
    ];
}
