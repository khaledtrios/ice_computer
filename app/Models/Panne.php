<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panne extends Model
{
    protected $table = 'pannes';

    protected $fillable = [
        'nom_panne',
        'image',
        'description',
        'priorite',
        'colors',
        'materiel_id',
        'is_qualirepar',
        'is_deleted'
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
        'colors' => 'boolean',
    ];

    public function materiel()
    {
        return $this->belongsTo(Materiel::class, 'materiel_id', 'id');
    }
}
