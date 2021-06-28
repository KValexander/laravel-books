<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Intervention\Image\Facades\Image;

use App\Http\Models\UsersModel;
use App\Http\Models\BooksModel;
use App\Http\Models\ChaptersModel;

class ModerationController extends Controller {
	public function moderation_page(Request $request) {
		dump("1");
	}
}
