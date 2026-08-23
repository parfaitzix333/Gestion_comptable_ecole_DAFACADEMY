<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propriete extends Model
{
    protected $table = 'proprietes';

    protected $fillable = [
        'titre',
        'information',
    ];
}