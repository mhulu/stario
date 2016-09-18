<?php

namespace Star\Health;

use Illuminate\Database\Eloquent\Model;

class PopHealthRecord extends Model
{
    protected $fillable = [
   	'result', 'pop_id'
    ];

    public function pop()
    {
    	return $this->belongsTo(Pop::class);
    }
}
