<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
	
	protected $fillable = [
		'name', 'address','date_issued','date_return','borrower_code', 'sort_id',
	];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = ucwords($value);
    }
}
