<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Маршруты общего доступа
// передаётся уровень доступа и в случае авторизации имя пользователя и его ID
// ===================================================================
Route::group(["middleware" => "session"], function() {

	// Главная страница
	Route::get('/', 'MainPageController@main_page')->name("main_page");

	// Страница регистрации
	Route::get('/register', 'AuthController@register_form');
	// Регистрация
	Route::post('/register', 'AuthController@register');

	// Страница авторизации
	Route::get('/login', 'AuthController@login_form');
	// Авторизация
	Route::post('/login', 'AuthController@login');

	// Страница книги
	Route::get('/book/{id_book}', 'BookController@book_page');

	// Страница главы
	Route::get('/book/{id_book}/chapter/{volume}/{chapter}', 'ChapterController@chapter_page');

	// Маршруты только для авторизованных пользователей
	// ===============================================================
	Route::group(["middleware" => "auth_middl"], function() {

		// Выход из сессии
		Route::get('/logout', 'AuthController@logout');

		// Маршруты для редакторов и выше
		// ===========================================================
		Route::group(["middleware" => "access"], function() {

			// Страница добавления книги
			Route::get('/books/add', 'BookController@book_add_form');
			// Добавление книги
			Route::post('/books/add', 'BookController@book_add');

			// Страница обновления книги
			Route::get('/book/{id_book}/update', 'BookController@book_update_form');
			// Обновление книги
			Route::post('/book/{id_book}/update', 'BookController@book_update');

			// Удаление книги
			Route::get('/book/{id_book}/delete', 'BookController@book_delete');

			// Страница добавление главы
			Route::get('/book/{id_book}/add/chapter', 'ChapterController@chapter_add_form');
			// Добавление главы
			Route::post('/book/{id_book}/add/chapter', 'ChapterController@chapter_add');

			// Страница обновления главы
			Route::get('/book/{id_book}/update/chapter', 'ChapterController@chapter_update_form');
			// Обновление главы
			Route::post('/book/{id_book}/update/chapter', 'ChapterController@chapter_update');

			// Маршруты для модераторов и администратора
			// =======================================================
			Route::group(["middleware" => "moderation"], function() {

				// Страница модерирования
				Route::get('/moderation', 'ModerationController@moderation_page');

			});
			// =======================================================

		});
		// ===========================================================

		// Сообщение об ошибке в случае отказа доступа
		Route::get('/error_access', 'ErrorController@error_access')->name("error_access");

	});
	// ===============================================================

	// Сообщение об ошибке в случае отсутствия авторизации
	Route::get('/error_auth', 'ErrorController@error_auth')->name("error_auth");

});
// ===================================================================