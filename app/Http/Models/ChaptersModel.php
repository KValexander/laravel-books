<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ChaptersModel extends Model
{    

	protected $table = 'chapters';
	protected $primaryKey = 'id_chapter';

	// protected $fillable = [];
	
	public $timestamps = true;

	public function book() {
		return $this->belongsTo('App\Http\Models\BooksModel', 'id_book');
	}


}
