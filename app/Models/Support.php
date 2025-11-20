<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $table = 'supports';

    protected $fillable = [
        'boutique_id',
        'objet',
        'message',
        'status',
        'is_oppen',
    ];  

    protected $casts = [
        'status' => 'boolean',
        'is_oppen' => 'boolean',
    ];

    public function boutique()
    {
        return $this->belongsTo(Boutique::class,'boutique_id','id');
    }
    
    public function messages()
    {
        return $this->hasMany(Message::class,'support_id','id');
    }
}
