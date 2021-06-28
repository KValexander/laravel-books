<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Http\Models\UsersModel;

class AuthController extends Controller {

	// Форма авторизации
	public function login_form(Request $request) {
		return view('books.auth.login');
	}

	// Форма регистрации
	public function register_form(Request $request) {
		return view('books.auth.register');
	}

	// Авторизация
	public function login(Request $request) {

		// Получение переменных
		$login = $request->input("login");
		$password = $request->input("password");

		// Проверка авторизации
		if(Auth::attempt(["login" => $login, "password" => $password], true)) {
			// Получение id авторизованного пользователя
			$id_auth = Auth::id();

			// Объявление пользователя онлайн
			$user = UsersModel::find($id_auth);
			$user->online = 1;
			$user->save();

			// Отправка положительного кода
			return response()->json()->setStatusCode(204);
		} else {
			// Не повезло не фортануло
			$message = "Ошибка авторизации";
			$data = (object)["message"=>$message];
			// Отправка отрицательного ответа
			return response()->json($data, 400);
		}

	}

	// Регистрация
	public function register(Request $request) {

		// Собственные сообщения для валидации
		$messages = [
			"required" => "Поле :attribute является обязательным",
			"string" => "Поле :attribute должно быть строковым",
			"min" => "Пренижен предел сивмолов для поля :attribute",
			"max" => "Превышен предел символов для поля :attribute",
			"unique" => "Поле :attribute должно быть уникальным",
			"regex" => "Поле :attribute не соответствует регулярному выражение :regex",
		];

		// Валидация
		$validator = Validator::make($request->all(), [
			"first_name" => "required|string|min:4|max:15",
			"last_name" => "required|string|min:1|max:15",
			"email" =>"required|regex:/@/|min:3|max:50",
			"login" => "required|unique:users,login|string|min:4|max:30",
			"password" => "required|string|min:6|max:30",
		], $messages);

		// Проверка на валидацию
		if($validator->fails()) {
			$errors = $validator->errors();
			return response()->json($errors, 422);
		}

		// Добавление нового пользователя
		$user = new UsersModel;
		$user->username = $request->input("first_name") ." ". $request->input("last_name");
		$user->first_name = $request->input("first_name");
		$user->last_name = $request->input("last_name");
		$user->email = $request->input("email");
		$user->login = $request->input("login");
		$user->password = bcrypt($request->input("password"));
		if($request->has("access")) $user->access = $request->input("access");
		$user->save();

		// Составление объекта
		$message = "Вы зарегистрировались";
		$data = (object)["message" => $message];

		// Отправка объекта
		return response()->json($data, 200);
	}

	// Выход из сессии
	public function logout() {

		// Обновление онлайн статуса на оффлайн
		$user = UsersModel::find(Auth::id());
		$user->online = 0;
		$user->save();
		
		Auth::logout();

		// Составление объекта
		$message = "Вы вышли";
		$data = (object)["message" => $message];

		// Вывод объекта в представлении
		return view("books.errors.message", ["data" => $data]);
	}

}
