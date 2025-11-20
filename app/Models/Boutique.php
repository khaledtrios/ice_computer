<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Boutique extends Model
{
    protected $fillable = [
        'user_id',
        'hosts',
        'slug',
        'config_type',
        'nom_boutique',
        'telephone',
        'adresse',
        'city',
        'company',
        'code_postal',
        'siret',
        'libalise',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday',
        'is_blocked',

        'reparation_magazin',
        'reparation_magazin_price',
        'reparation_magazin_description',

        'reparation_domicile',
        'reparation_domicile_price',
        'reparation_domicile_description',



        'primary_color',
        'secondary_color',
        'types_par_panne',
        'remise_online'
    ];

    protected $casts = [
        'adresse' => 'array',
        'Monday' => 'array',
        'Tuesday' => 'array',
        'Wednesday' => 'array',
        'Thursday' => 'array',
        'Friday' => 'array',
        'Saturday' => 'array',
        'Sunday' => 'array',
        'hosts' => 'array',
        'types_par_panne' => 'array',
        'reparation_magazin'=>'boolean',
        'reparation_domicile'=>'boolean'
    ];


    /*   protected $attributes = [
           'reparation_domicile_description' => "Intervention en moins d'une heure dans toute l'Île-de-France !",
           'hosts' => [],
           'types_par_panne' => [],
           'adresse' => [],
       ];
    */


    protected static function booted()
    {
        static::creating(function ($boutique) {
            if (empty($boutique->slug)) {
                $boutique->slug = self::generateUniqueSlug($boutique->nom_boutique);
            }
        });
    }

    public static function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = \Str::slug($name);
        $original = $slug;
        $count = 1;

        while (
            self::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $original . '-' . $count;
            $count++;
        }

        return $slug;
    }


    public function configurations()
    {
        return $this->hasMany(ConfigurationBoutique::class, 'boutique_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->hasMany(Client::class, 'boutique_id', 'id');
    }

    public function demande()
    {
        return $this->hasMany(Demande::class, 'boutique_id', 'id');
    }

    public function domains()
    {
        return $this->hasOne(Domains::class, 'boutique_id', 'id');
    }

    public function dayoff()
    {

        return $this->hasMany(Dayoff::class, 'boutique_id', 'id');
    }

    public function types_piece()
    {

        return $this->hasMany(TypePiece::class, 'boutique_id', 'id');
    }

    /*   'raparation_correspondance',
      'raparation_correspondance_price',
      'raparation_correspondance_description', */
}
