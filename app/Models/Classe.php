<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $fillable = [
        'designation',
        'section_id',
        'annee_scolaire_id',
    ];

    // Relations
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function anneeScolaire()
    {
        return $this->belongsTo(Annee_scolaire::class);
    }

    public function enseignants()
    {
        return $this->hasOne(Enseignant::class);
    }

    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }

    public function frais()
    {
        return $this->hasMany(Frais::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    // Scopes
    public function scopeCurrentYear($query)
    {
        $activeYear = Annee_scolaire::getActiveYear();
        if ($activeYear) {
            return $query->where('annee_scolaire_id', $activeYear->id);
        }
        return $query;
    }
}
