<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProduitAdditionnel extends Model
{
    
    protected $table = 'produit_additionnels';

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'boutique_id',
        'materiel_id', 
    ]; 

    protected $casts = [
        'created_at' => 'datetime', 
    ];
    public function materiel()
    {
        return $this->belongsTo(Materiel::class, 'materiel_id', 'id');
    }
}
