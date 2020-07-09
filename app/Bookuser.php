<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookuser extends Model
{
    public function getBook()
    {
      return $this->belongsTo('App\Book','book_id','id');
    }
    public function getBorrower()
    {
      return $this->belongsTo('App\Borrower','borrow_id','id');
    }
    public function getUser()
    {
        return $this->belongsTo('App\User','created_by','id');
    }
}
