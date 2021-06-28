<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller {

	// Сообщение об ошибке в случае отсутствия авторизации
	public function error_auth() {
		$message = "Вы не авторизованы";
		$data = (object)["message" => $message];
		return view("books.errors.error", ["data" => $data]);
	}

	// Сообщение об ошибке в случае отказа доступа
	public function error_access() {
		$message = "Ошибка доступа";
		$data = (object) ["message" => $message];
		return view("books.errors.error", ["data" => $data]);
	}

}
