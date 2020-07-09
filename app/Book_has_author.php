<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book_has_author extends Model
{
    public function getBook()
    {
      return $this->belongsTo('App\Book','book_id','id');
    }

    public function getAuthor()
    {
      return $this->belongsTo('App\Author','author_id','id');
    }
    
    protected $fillable = ['author_id', 'book_id', 'updated_at', 'created_at', 'created_by'];
}
