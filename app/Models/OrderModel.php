<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'order_models';

    protected $fillable = [
        'boutique_id',
        'modele_id',
        'position',
    ];

    /**
     * Boutique liée (relation Many-to-One)
     */
    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }

    /**
     * Modèle lié (relation Many-to-One)
     */
    public function modele()
    {
        return $this->belongsTo(Modele::class);
    }
}
