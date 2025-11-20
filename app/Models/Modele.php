<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modele extends Model
{
    protected $table = 'modeles';

    protected $fillable = [
        'nom_modele',
        'image',
        'marque_id',
        'priorite',
        'boutique_id',
        'is_validate',
        'is_deleted',
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
        'is_validate' => 'boolean',
    ];

    // Relations
    public function marque()
    {
        return $this->belongsTo(Marque::class, 'marque_id', 'id');
    }

    public function boutique()
    {
        return $this->belongsTo(Boutique::class, 'boutique_id', 'id');
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'modele_id', 'id');
    }
}
