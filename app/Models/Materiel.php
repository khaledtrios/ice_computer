<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materiel extends Model
{

    protected $table = 'materiels';

    protected $fillable = [
        'nom_materiel',
        'image',
        'priorite',
        'is_deleted'

    ];


    protected $casts = [
        'is_deleted' => 'boolean',
    ];

    // Relations
    public function marques()
    {
        return $this->hasMany(Marque::class, 'materiel_id', 'id');
    }

}
