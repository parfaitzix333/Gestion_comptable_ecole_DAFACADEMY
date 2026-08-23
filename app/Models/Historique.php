<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    protected $fillable = [
        'user_id',
        'action',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Méthodes
    public static function log($userId, $action)
    {
        return self::create([
            'user_id' => $userId,
            'action' => $action,
        ]);
    }
}
