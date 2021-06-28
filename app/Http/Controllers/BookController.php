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

class BookController extends Controller {

   // Страница книги
	public function book_page(Request $request) {
		// Получение книги
		$id_book = $request->route("id_book");
		$book = BooksModel::find($id_book);

		// Если книга не найдена
		if(empty($book)) {
			$message = "Такой книги не существует";
			$data = (object)["message" => $message];
			return view("books.errors.error", ["data" => $data]);
		}

		// Если маркер удаления на 1
		if ($book->delete_marker == 1) {
			$message = "Книга удалена";
			$data = (object)["message" => $message];
			return view("books.errors.error", ["data" => $data]);
		}
		
		// Получение глав книги
		$chapters = BooksModel::find($id_book)->chapters->groupBy("volume");

		// Составление объекта
		$data = (object)[
			"book" => $book,
			"chapters" => $chapters
		];

		// Отправка объекта представлению
		return view("books.books.book", ["data" => $data]);
	}

	// Форма добавления книги
	public function book_add_form() {
		return view("books.books.book_add");
	}

	// Форма обновления книги
	public function book_update_form(Request $request) {
		$id_book = $request->route("id_book");
		$book = BooksModel::find($id_book);
		$data = (object)[
			"book" => $book,
		];
		return view("books.books.book_update", ["data" => $data]);
	}

	// Добавление книги
	public function book_add(Request $request) {
	   // Валидация
		$validator = Validator::make($request->all(), [
			"book_title" => "required|string|max:100",
			"russian_title" => "required|string|max:100",
			"cover" => "required|image|mimes:jpeg,png,jpg|max:2048",
			"annotation" => "required|string|max:1215",
			"release_year" => "required|digits:4",
			"isbn" => "required|string|max:30",
			"release_status" => "required|string|max:30",
			"translate_status" => "required|string|max:30",
			"overall_volume" => "required|string|max:30",
			"translation_volume" => "required|string|max:30",
			"genres" => "required|string|max:500",
			"tags" => "required|string|max:500",
			"author" => "required|string|max:50",
			"translator" => "required|string|max:50",
			"type" => "required|string|max:30",
		]);

		// Проверка валидации
		if($validator->fails()) {
			$error = $validator->errors();
			$data = (object)["message" => $error];
			return response()->json($data, 422);
		}

		// Проверка на наличие схожести имён произведений
		$books = BooksModel::all();
		for ($i=0; $i < count($books); $i++) {
			if($books[$i]->book_title == $request->input("book_title")) {
				$message = "Такая ". $request->input("type") ." уже есть в нашей базе";
				$data = (object)["message" => $message, "not_obj" => true];
				return response()->json($data, 422);
			}
		}

		// Имя для файла на диске
		$cover_name = "1_". str_replace(" ", "_", mb_strtolower($request->input("book_title"))) .'_'. time() ."_orig.". $request->file('cover')->extension();

		// Путь к файлу
		$path = '/books/images/covers'. $cover_name;

		// Сам файл
		$cover = $request->file('cover');

		// Запись файла на диск
		// По этому методу изображения будут храниться в public
		$request->cover->move(public_path('/books/images/covers/'), $cover_name);

		// По этому методу изображения будут храниться в storage
		// $path = $request->file('cover')->store($cover_name);
		// $path = Storage::disk('local')->put($cover_name, $cover);
		// Или проще
		// $path = Storage::put($cover_name, $cover);

		// Запись данных в базу
		$book = new BooksModel;
		$book->id_user = Auth::id();
		$book->book_title = $request->input("book_title");
		$book->russian_title = $request->input("russian_title");
		$book->cover = $path;
		$book->annotation = $request->input("annotation");
		$book->release_year = $request->input("release_year");
		$book->isbn = $request->input("isbn");
		$book->release_status = $request->input("release_status");
		$book->translate_status = $request->input("translate_status");
		$book->overall_volume = $request->input("overall_volume");
		$book->translation_volume = $request->input("translation_volume");
		$book->genres = $request->input("genres");
		$book->tags = $request->input("tags");
		$book->author = $request->input("author");
		$book->translator = $request->input("translator");
		$book->type = $request->input("type");
		$book->save();

		// Составление объетка
		$message = $request->input("type") ." отправлена на модерацию";
		$data = (object)["message" => $message];

		// Отправка объекта
		return response()->json($data, 200);
	}

	// Обновление книги
	public function book_update(Request $request) {

	}

	// Удаление книги
	public function book_delete(Request $request) {
		// Получение книги
		$id_book = $request->route("id_book");
		$user = Auth::user();
		$book = BooksModel::find($id_book);

		// Если книга не найдена
		if(empty($book)) {
			$message = "Такой книги не существует";
			$data = (object)["message" => $message];
			return view("books.errors.error", ["data" => $data]);
		}

		// Если пользователь администратор или модератор
		if ($user->access == "1" || $user->access == "2") {
			$book->delete_marker = 1;
			$book->save();
			$message = "Книга была удалена";
			$data = (object)["message" => $message];
			return view("books.errors.message", ["data" => $data]);
		}

		// Если пользователь не является автором перевода
		if($book->id_user != $user->id) {
			$message = "Вы не являетесь автором перевода";
			$data = (object)["message" => $message];
			return view("books.errors.error", ["data" => $data]);
		} else {
			$book->delete_marker = 1;
			$book->save();
			$message = "Книга была удалена";
			$data = (object)["message" => $message];
			return view("books.errors.message", ["data" => $data]);
		}




	}

}
