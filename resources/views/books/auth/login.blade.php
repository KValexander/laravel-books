@extends("books.shablon")

@section("title")
	Книги / Ранобэ / Новеллы
@endsection

@section("script")
	<script>
		// AJAX запрос на авторизацю
		// =====================
		function ajax_login() {
			var data = JSON.stringify({
				"login": $("#login").val(),
				"password": $("#password").val(),
			});
			$.ajax({
				url: "/login",
				type: "POST",
				headers: {
					"Content-Type": "application/json",
					"X-CSRF-TOKEN": $("meta[name='_token']").attr('content'),
				},
				data: data,
				success: function(data) {
					document.location.href = "/";
				},
				error: function(jqXHR) {
					var message = JSON.parse(jqXHR.responseText);
					call_message(message.message);
				}
			});
		}
	</script>
@endsection


@section("menu")
	<a href="/">Книги</a>
	<a href="/">Новеллы</a>
	<a href="/">Серии</a>
	<a href="/">Блоги</a>
	<a href="/">Жанры</a>
	<a href="/">Теги</a>
	@if($access == 1 || $access == 2) | <a href="/books/add">Добавить книгу</a>@endif
@endsection

@section("content")
	<div class="head">
		<h1>Авторизация</h1>
	</div>
	<div class="content">
		<div class="form">
			<div class="left">
				<input type="text" id = "login" placeholder = "Логин">
				<input type="password" id = "password" placeholder = "Пароль">
				<input type="button" value = "Войти" onclick = "ajax_login()">
				<p><a class = "link" href="/register">Регистрация</a></p>
			</div>
		</div>
	</div>
@endsection