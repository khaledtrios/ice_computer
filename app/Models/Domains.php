<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domains extends Model
{
    protected $table = 'domains';

    protected $fillable = [
        'boutique_id',
        'domain_name',
        'height',
        'width',
        'iframe_code'
    ];

    /**
     * Relation avec la boutique.
     */
    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
}
