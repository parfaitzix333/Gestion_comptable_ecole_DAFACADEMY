<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'matricule','anne_scolaire_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'string'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relations
    public function enseignant()
    {
        return $this->hasOne(Enseignant::class);
    }

    public function historiques()
    {
        return $this->hasMany(Historique::class);
    }
    public function anneeScolaire()
    {
        return $this->belongsTo(Annee_scolaire::class, 'anne_scolaire_id');
    }

    // Scopes
    public function scopePromoteur($query)
    {
        return $query->where('role', 'promoteur');
    }

    public function scopeComptable($query)
    {
        return $query->where('role', 'comptable');
    }

    public function scopeEnseignant($query)
    {
        return $query->where('role', 'enseignant');
    }
}
