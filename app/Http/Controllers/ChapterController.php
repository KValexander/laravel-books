<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Http\Models\UsersModel;
use App\Http\Models\BooksModel;
use App\Http\Models\ChaptersModel;

class ChapterController extends Controller {

	// Страница главы
	public function chapter_page(Request $request) {
		$id_book = $request->route("id_book");
		$volume = $request->route("volume");
		$chapter = $request->route("chapter");

		$book = BooksModel::find($id_book);
		$chapter = ChaptersModel::where("id_book", $id_book)->where("chapter", $chapter)->where("volume", $volume)->first();
		if (empty($chapter)) {
			$message = "Такой главы нет";
			$data = (object)["message" => $message];
			return view("books.errors.message", ["data" => $data]);
		}

		$data = (object)[
			"book" => $book,
			"chapter" => $chapter,
		];

		return view("books.chapters.chapter", ["data" => $data]);
	}

	// Форма добавления главы
	public function chapter_add_form(Request $request) {
		$id_book = $request->route("id_book");
		$book = BooksModel::find($id_book);
		
		$ch_count = ChaptersModel::where("id_book", $id_book)->groupBy("volume")->count();
		
		$volume_title = array();
		
		for ($i=1; $i <= $ch_count; $i++) {
			$chapters = ChaptersModel::where("id_book", $id_book)->where("volume", $i)->first();
			if(empty($chapters)) $volume_title[$i] = null;
			else $volume_title[$i] = $chapters->volume_title;
		}

		$data = (object)[
			"book" => $book,
			"volume_title" => $volume_title,
		];

		return view("books.chapters.chapter_add", ["data" => $data]);
	}

	// Добавление главы
	public function chapter_add(Request $request) {
		$id_book = $request->route("id_book");
		$id_user = Auth::id();

		$type = $request->input("type");

		$ch = ChaptersModel::where("volume", $request->input("volume"))->where("chapter", $request->input("chapter"))->first();
		if(!empty($ch)) {
			$message = "Такая глава уже есть";
			$data = (object)["message" => $message];
			return response()->json($data, 200);
		}

		if($type == "wholly") {
			$chptr = "0";
			$chptr_title = $request->input("chapter_title");
			$validator = Validator::make($request->all(), [
				"volume" => "required|numeric|min:1|max:11",
				"volume_title" => "required|string|max:50",
				"type" => "required|string|max:30",
				"chapter_title" => "required|string|max:50",
				"file" => "required|file|max:6000"
			]);
		} else {
			$chptr = $request->input("chapter");
			$chptr_title = $request->input("chapter_title");
			$validator = Validator::make($request->all(), [
				"volume" => "required|numeric|min:1|max:11",
				"volume_title" => "required|string|max:50",
				"chapter" => "required|numeric|min:1|max:11",
				"type" => "required|string|max:30",
				"chapter_title" => "required|string|max:50",
				"file" => "required|file|max:6000"
			]);
		};

		// Проверка на валидацию
		if($validator->fails()) {
			$errors = $validator->errors();
			$data = (object)["message" => $errors];
			return response()->json($data, 422);
		}

		// Запись файла на диск
		// ==================================
		// Получение книги
		$book = BooksModel::find($id_book);
		// Получение файла
		$file = $request->file("file");
		// Получение отформатированного названия книги
		$book_name = str_replace(" ", "_", mb_strtolower($book->book_title));
		// Составление имени для файла
		$file_name = $book_name ."_vol". $request->input("volume") ."_". $request->input("type") . $request->input("chapter") ."_-_". $request->input("chapter_title")."_". time() .".". $request->input("extension");
		// Запись файла на диск в папку проекта public/files/chapters и дальше профильно
		$request->file("file")->move(public_path('/books/files/chapters/'. $book_name .'/'), $file_name);
		// Отдельно прописываю путь к файлу, потому что делаю не по людски, а как понравилось
		$path = '/books/files/chapters/'. $book_name .'/'. $file_name;
		// ==================================

		// Запись в базу данных
		$chapter = new ChaptersModel;
		$chapter->id_book = $id_book;
		$chapter->id_user = $id_user;
		$chapter->volume = $request->input("volume");
		$chapter->volume_title = $request->input("volume_title");
		$chapter->chapter = $chptr;
		$chapter->chapter_title = $chptr_title;
		$chapter->chapter_content = "0";
		$chapter->path = $path;
		$chapter->type = $type;
		$chapter->save();

		// Составление объекта
		if($type == "wholly") $message = "Произведение было добавлно";
		else $message = "Глава была добавлена";
		$data = (object)["message" => $message];
		// Отправка объекта
		return response()->json($data, 200);
	}

}
