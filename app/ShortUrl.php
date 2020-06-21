<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    protected $table = 'short_urls';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'code',
        'url',
        'password',
        'count',
        'status',
    ];

}
