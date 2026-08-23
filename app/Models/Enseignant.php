<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    protected $fillable = [
        'nom',
        'matricule',
        'classe_id',
        'user_id',
        'sexe',
    ];

    // Relations
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accesseurs
    public function getSexeLabelAttribute()
    {
        return $this->sexe === 'M' ? 'Masculin' : 'Féminin';
    }
}
