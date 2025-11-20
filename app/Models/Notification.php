<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
     protected $table = 'notifications';

    protected $fillable = [
        'boutique_id',
        'message',
        'is_oppen',
        'type'
    ];

    protected $casts = [
        'is_oppen' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    public function boutique()
    {
        return $this->belongsTo(Boutique::class, 'boutique_id', 'id');
    }

}
