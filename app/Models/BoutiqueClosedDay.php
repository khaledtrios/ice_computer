<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoutiqueClosedDay extends Model
{
    protected $table = 'boutique_closed_days';

    protected $fillable = [
        'boutique_id',
        'closed_date',
    ];
    /**
     * Relation avec la boutique.
     */
    public function boutique()
    {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
        return $this->belongsTo(Boutique::class, 'boutique_id');
    }
}
