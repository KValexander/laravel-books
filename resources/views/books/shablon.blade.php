<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="_token" content="{{ csrf_token() }}" />

	<title>@yield("title")</title>
	<!-- Подключение логотипа для сайта -->
	<link rel="icon" href="{{ asset('books/logo_on.png') }}">
	<!-- Подключение файла стилей -->
	<link rel="stylesheet" href="{{ asset('books/css/style.css') }}">

	<!-- Подключение библиотек -->
	<!-- ================================== -->
	<!-- Подключение jquery -->
	<script src = "{{ asset('books/script/jquery-3.5.1.min.js') }}"></script>
	<!-- Подключение jquery cookie -->
	<script src = "{{ asset('books/script/jquery.cookie.js') }}"></script>

	<!-- Подключение jquery ui -->
	<script src = "{{ asset('books/script/jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>
	<!-- Подключение стилей для jquery ui -->
	<link rel="stylesheet" href="{{ asset('books/script/jquery-ui-1.12.1/jquery-ui.min.css') }}">

	<!-- Подключение JSZip -->
	<script src = "{{ asset('books/script/jszip-master/dist/jszip.min.js') }}"></script>
	<!-- ================================== -->

	<!-- Подключение файла скрипта -->
	<script src = "{{ asset('books/script/main.js') }}"></script>


	@yield("script")

</head>
<body>

	<header>
		<div class="edge">
			<a href="/">
				<div class="icon">
					<h1>BookRoom</h1>
				</div>
			</a>
			<div class="search">
				<input type="text" placeholder = "Введите название книги/новеллы">
				<input type="button" value = "Найти">
			</div>
			<div class="session">
				@if($access == 0)<a href="/login">Авторизация</a>/<a href="/register">Регистрация</a>@endif
				@if($access != 0)<a href="/personal_area">{{ $username }}</a> <a href="/logout">Выйти</a>@endif
			</div>
		</div>
	</header>

	<nav>
		<div class="edge">
			@yield("menu")
		</div>
	</nav>

	<main>
		<div class="edge">
			@yield("content")
		</div>
	</main>

	<footer>
		<div class="edge"></div>
	</footer>

	<div id="message"></div>

</body>
</html>