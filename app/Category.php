<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucwords($value);
    }
}
