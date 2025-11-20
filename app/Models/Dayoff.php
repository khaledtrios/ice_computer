<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Dayoff extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dayoffs';

    protected $fillable = [
        'boutique_id',
        'jour_conge',
    ];

    protected $dates = ['jour_conge', 'deleted_at'];

    protected $casts = [
        'jour_conge' => 'date',
    ];
     
    /**
     * Relation avec la boutique.
     */
    public function boutique()
    {
        return $this->belongsTo(Boutique::class, 'boutique_id', 'id');
    }
}