<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annee_scolaire extends Model
{
    protected $fillable = [
        'annee',
        'statut',
    ];

    // Relations
    public function classes()
    {
        return $this->hasMany(Classe::class);
    }

    public function frais()
    {
        return $this->hasMany(Frais::class);
    }

    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    // Scopes - CORRECTION : utiliser 'actif' et 'inactif'
    public function scopeActive($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeInactive($query)
    {
        return $query->where('statut', 'inactif');
    }

    // Méthodes - CORRECTION : utiliser 'actif'
    public static function getActiveYear()
    {
        return self::where('statut', 'actif')->first();
    }

    public function isActive()
    {
        return $this->statut === 'actif';
    }
}
