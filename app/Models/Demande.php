<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $fillable = [
        'numero_devis',
        'boutique_id',
        'modele_id',
        'client_id',
        'statut_id',
        'pannes',
        'type',
        'date_rendez_vous',
        'is_deleted',
        'global_remise',
        'magazin',
        'is_qualirepair',
        'repair_options',
        'produit_additionnel',
        'commentaire'
    ];

    protected $casts = [
        'pannes' => 'array',
        'produit_additionnel' => 'array',
        'repair_options' => 'array',
        'type' => 'boolean',
        'is_deleted' => 'boolean',
        
    ];

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
    public function modele()
    {
        return $this->belongsTo(Modele::class,'modele_id','id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function statut()
    {
        return $this->belongsTo(Statut::class);
    }
}
