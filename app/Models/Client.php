<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
        'boutique_id',
        'nom',
        'prenom',
        'telephone',
        'email',
        'adresse',
    ];

    protected $hidden = [
        'password',
    ];

    // Exemple relation : un client a plusieurs devis
    public function demande()
    {
        return $this->hasMany(Demande::class, 'client_id', 'id');
    }

    public function boutique()
    {
        return $this->belongsTo(Boutique::class, 'boutique_id', 'id');
    }
}
