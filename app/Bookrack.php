<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookrack extends Model
{
	protected $fillable = [
	    'title', 'sort_id',
	];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucwords($value);
    }
}
