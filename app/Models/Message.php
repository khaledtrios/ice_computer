<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Support;
use App\Models\Marque;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'message',
        'image',
        'is_admin',
        'support_id',
        'is_read',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'is_read' => 'boolean',
    ];

    // Relation : un message appartient à un support
    public function support()
    {
        return $this->belongsTo(Support::class,'support_id','id');
    }

        public function firstMessage()
        {
            return $this->hasOne(Message::class, 'support_id', 'id')->orderBy('created_at');
        }


}
