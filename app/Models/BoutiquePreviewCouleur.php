<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoutiquePreviewCouleur extends Model
{
    protected $table = 'boutique_preview_couleurs';

    protected $fillable = [
        'boutique_id',
        'primary_color',
        'secondary_color',
    ];

    public function boutique()
    {
        return $this->belongsTo(Boutique::class, 'boutique_id');
    }
}
