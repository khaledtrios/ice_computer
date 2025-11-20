<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypePiece extends Model
{
    
    protected $table = 'type_piece';

    protected $fillable = [
        'boutique_id',
        'name',
        'is_qualirepar', 
        'montant', 
    ];  
 

    public function boutique()
    {
        return $this->belongsTo(Boutique::class,'boutique_id ','id');
    }
     
}
