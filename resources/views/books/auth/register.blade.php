@extends("books.shablon")

@section("title")
	Книги / Ранобэ / Новеллы
@endsection

@section("script")
	<script>
		// AJAX запрос на регистрацию пользователя
		// ========================
		function ajax_register() {
			if($("#password").val() != $("#password_confirmation").val() || $("#password").val() == "" || $("#password_confirmation").val() == "") {
				call_message("Пароли не совпадают");
				return;
			}

			var data = JSON.stringify({
				"first_name": $("#first_name").val(),
				"last_name": $("#last_name").val(),
				"email": $("#email").val(),
				"login": $("#login").val(),
				"password": $("#password").val(),
				@if($access == 1 || $access == 2)
				"access": $("#access").val()
				@endif
			});

			$.ajax({
				url: "/register",
				type: "POST",
				headers: {
					"Content-Type": "application/json",
					"X-CSRF-TOKEN": $("meta[name='_token']").attr('content'),
				},
				data: data,
				success: function(data) {
					document.location.href = "/login";
				},
				error: function(jqXHR) {
					var messages = JSON.parse(jqXHR.responseText);
					var out = "";
					for(var key in messages) { out += ` <p style = "text-align: justify;">${key} : <span  style = "color: red">${messages[key]}</span></p> `; }
					call_message(out);
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
		<h1>Регистрация</h1>
	</div>
	<div class="content">
		<div class="form">
			<div class="left">
				<input type="text" id = "first_name" placeholder = "Имя">
				<input type="text" id = "last_name" placeholder = "Фамилия">
				<input type="text" id = "email" placeholder = "Email">
				<input type="text" id = "login" placeholder = "Логин">
				<input type="password" id = "password" placeholder = "Пароль">
				<input type="password" id = "password_confirmation" placeholder = "Подтверждение пароля">
				@if($access == 1 || $access == 2)
					<select name="access" id = "access">
						@if($access == 1)
							<option value="1">Администратор</option>
							<option value="2">Модератор</option>
						@endif
						@if($access == 1 || access == 2)
							<option value="3">Редактор</option>
							<option value="4">Пользователь</option>
						@endif
					</select>
				@endif
				<input type="button" value = "Зарегистрироваться" onclick = "ajax_register();">
				<p><a class = "link" href="/login">Авторизация</a></p>
			</div>
		</div>
	</div>
@endsection