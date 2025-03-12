<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pays extends Model
{
    protected $fillable = [
        'name', 'capital', 'population', 'region', 'flag_url', 'currency', 'language'
    ];
}
