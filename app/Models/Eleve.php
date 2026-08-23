<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    protected $fillable = [
        'matricule',
        'nom',
        'date_n',
        'lieu_n',
        'responsable',
        'tel_responsable',
        'adresse',
        'classe_id',
        'annee_scolaire_id',
        'ecole_provenance',
        'photo',
        'sexe',
    ];

    protected $casts = [
        'date_n' => 'date',
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

    // Accesseurs
    public function getSexeLabelAttribute()
    {
        return $this->sexe === 'M' ? 'Masculin' : 'Féminin';
    }

    public function getAgeAttribute()
    {
        return $this->date_n ? $this->date_n->age : null;
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

    public function scopeByClasse($query, $classeId)
    {
        return $query->where('classe_id', $classeId);
    }
}
