<?php

namespace Star\Icenter;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
       'content', 'type'
    ];
    protected $hidden = ['user_id', 'updated_at'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
