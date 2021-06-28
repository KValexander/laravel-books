<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{    

	protected $table = 'users';
	protected $primaryKey = 'id';

	// protected $fillable = [];
	
	public $timestamps = true;


}
