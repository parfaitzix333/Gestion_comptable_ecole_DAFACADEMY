<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'designation',
    ];

    // Relations
    public function classes()
    {
        return $this->hasMany(Classe::class);
    }
}
