<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
  protected $fillable = [
    'title', 'bookcode','edition','place','publisher_id', 'year_of_publication','physical_description','broad_subject_heading','keywords','geographical_descriptors','language_of_text','type_of_material','accession_no','information','sort_id'
  ];

  public function getPublisher()
  {
    return $this->belongsTo('App\Publisher','publisher_id','id');
  }

  public function getBookrack()
  {
    return $this->belongsTo('App\Bookrack','bookrack_id','id');
  }

  public function getAuthor()
  {
    return $this->belongsTo('App\Author','author_id','id');
  }

  public function getBookHasAuthor()
  {
    return $this->hasMany('App\Book_has_author','book_id','id');
  }

  public function setTitleAttribute($value)
  {
      $this->attributes['title'] = ucwords($value);
  }
    
}
