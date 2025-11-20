<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marque extends Model
{
    protected $table = 'marques';

    protected $fillable = [
        'nom_marques',
        'image',
        'priorite',
        'materiel_id',
        'is_deleted'
    ];

    // Relation avec le modèle Materiel
    public function materiel()
    {
        return $this->belongsTo(Materiel::class, 'materiel_id', 'id');
    }

    public function modele()
    {
        return $this->hasMany(Modele::class, 'marque_id', 'id');
    }
}
