<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statut extends Model
{
    protected $table = 'statuts';

    protected $fillable = [
        'nom_statut',
        'is_statut',
    ];

    protected $casts = [
        'is_statut' => 'boolean',
    ];

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}
