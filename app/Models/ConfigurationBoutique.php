<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigurationBoutique extends Model
{
    protected $table = 'configuration_boutiques';

    protected $fillable = [
        'boutique_id',
        'marque_id',
        'modele_id',
        'materiel_id',
        'pannes',
        'rachat',
        'rachat_affiche',
    ];

    protected $casts = [
        'pannes' => 'array',
        'rachat' => 'array',
    ];

    // Relations
    public function boutique()
    {
        return $this->belongsTo(Boutique::class,'boutique_id','id');
    }

    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }

    public function modele()
    {
        return $this->belongsTo(Modele::class);
    }

    public function materiel()
    {
        return $this->belongsTo(Materiel::class);
    }
}
