<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Http\Models\BooksModel;

class MainPageController extends Controller {

	public function main_page() {
		$pre_books = BooksModel::where("delete_marker", "0")->orderBy("id_book", "DESC")->get();

		for ($i=0; $i < count($pre_books); $i++) {
			$books[] = (object)[
				"id_book" => $pre_books[$i]->id_book,
				"title" => $pre_books[$i]->book_title,
				"cover" => $pre_books[$i]->cover,
			];
		}

		$data = (object)[
			"books" => $books
		];

		return view("books.index", ["data" => $data]);
	}

}
