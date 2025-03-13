<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    protected $fillable = [
        'nom', 'capitale', 'population', 'region', 'url_drapeau', 'devise', 'langue'
    ];
}
