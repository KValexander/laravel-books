<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class BooksModel extends Model
{    

	protected $table = 'books';
	protected $primaryKey = 'id_book';

	// protected $fillable = [];
	
	public $timestamps = true;

	public function chapters() {
		return $this->hasMany('App\Http\Models\ChaptersModel', 'id_book');
	}

}
