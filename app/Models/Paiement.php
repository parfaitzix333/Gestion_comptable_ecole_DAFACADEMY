<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Eleve;
use App\Models\Frais;
use App\Models\Classe;
use App\Models\Annee_scolaire;

class Paiement extends Model
{
    protected $fillable = [
        'montant',
        'eleve_id',
        'frais_id',
        'classe_id',
        'annee_scolaire_id',
        'date_limite',
        'mode_paiement',
        'devise',
        'statut',
        'montant_en_lettre',
        'date_paiement', // Ajouté si nécessaire
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_limite' => 'date',
        'date_paiement' => 'date',
    ];

    // Relations
    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    public function frais()
    {
        return $this->belongsTo(Frais::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function anneeScolaire()
    {
        return $this->belongsTo(Annee_scolaire::class, 'annee_scolaire_id');
    }

    // Scopes - CORRECTION : utiliser 'actif' au lieu de 'active'
    public function scopeCurrentYear($query)
    {
        $activeYear = Annee_scolaire::where('statut', 'actif')->first();
        if ($activeYear) {
            return $query->where('annee_scolaire_id', $activeYear->id);
        }
        return $query;
    }

    public function scopePaye($query)
    {
        return $query->where('statut', 'payé');
    }

    public function scopeAcompte($query)
    {
        return $query->where('statut', 'acompte');
    }

    /**
     * Boot method pour la règle métier
     */
    protected static function booted()
    {
        static::creating(function ($paiement) {
            // Récupérer le montant du frais
            $frais = Frais::find($paiement->frais_id);
            if ($frais) {
                // Appliquer la règle métier
                $paiement->statut = $paiement->montant < $frais->montant ? 'acompte' : 'payé';
            }
        });

        static::updating(function ($paiement) {
            // Même règle lors de la mise à jour
            $frais = Frais::find($paiement->frais_id);
            if ($frais) {
                $paiement->statut = $paiement->montant < $frais->montant ? 'acompte' : 'payé';
            }
        });
    }
}
