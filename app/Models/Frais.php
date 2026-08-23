<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frais extends Model
{
    protected $fillable = [
        'designation',
        'montant',
        'classe_id',
        'annee_scolaire_id',
        'statut',
        'devise',
        'date_limite',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_limite' => 'date',
    ];

    // Relations
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function anneeScolaire()
    {
        return $this->belongsTo(Annee_scolaire::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    // Scopes - CORRECTION : utiliser 'actif' au lieu de 'active'
    public function scopeActif($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeCurrentYear($query)
    {
        $activeYear = Annee_scolaire::where('statut', 'actif')->first();
        if ($activeYear) {
            return $query->where('annee_scolaire_id', $activeYear->id);
        }
        return $query;
    }
}
