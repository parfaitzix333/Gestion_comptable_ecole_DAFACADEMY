<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Throwable;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = [
        'couriel',
        'tel',
        'adresse',
        'latitude',
        'longitude',
    ];

}
