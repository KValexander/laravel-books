@extends("books.shablon")

@section("title")
	Книги / Ранобэ / Новеллы
@endsection

@section("script")
	<script>
		$(function() {
			// Для выбора файла обложки
			// ===================================
			$("#cover_button").click(function() {
				$("#load_cover").click();
			});
			$("#load_cover").on("change", function() {
				if ($(this).val() == "") {
					$("#cover_upload").html("Файл не выбран");
					$("#cover_upload").css("color", "red");
				} else {
					$("#cover_upload").html("Файл загружен");
					$("#cover_upload").css("color", "green");
				}
			});
			// ===================================
		});

		// AJAX запрос на добавление книги
		// ========================
		function ajax_book_add() {

			// Получение файла обложки (2 метода)
			var cover = $("#load_cover").prop("files")[0];
			cover = $("#load_cover")[0].files[0];

			// Создание FormData
			var fd = new FormData();

			// Добавление в FormData объектов
			fd.append("book_title", $("#book_title").val());
			fd.append("russian_title", $("#russian_title").val());
			fd.append("cover", cover);
			fd.append("annotation", $("#annotation").val());
			fd.append("release_year", $("#release_year").val());
			fd.append("isbn", $("#isbn").val());
			fd.append("release_status", $("#release_status").val());
			fd.append("translate_status", $("#translate_status").val());
			fd.append("overall_volume", $("#overall_volume").val());
			fd.append("translation_volume", $("#translation_volume").val());
			fd.append("genres", $("#genres").val());
			fd.append("tags", $("#tags").val());
			fd.append("author", $("#author").val());
			fd.append("translator", $("#translator").val());
			fd.append("type", $("#type").val());

			// сам ajax запрос
			$.ajax({
				url: "/books/add",
				type: "POST",
				cache: false, // по выбору
				contentType: false, // обязательно отключить
				processData: false, // обязательно отключить
				headers: {
					"X-CSRF-TOKEN": $("meta[name='_token']").attr('content'),
				},
				data: fd,
				success: function(data) {
					call_message(data.message);
				},
				error: function(jqXHR) {
					var message = JSON.parse(jqXHR.responseText);
					var obj = message.message;
					if(message.not_obj) { call_message(obj); return; }
					var out = "";
					for(var key in obj) { out += ` <p style = "text-align: justify;">${key} : <span  style = "color: red">${obj[key]}</span></p> `; }
					call_message(out);
				}
			});

		}
	</script>
@endsection

@section("menu")
	<a href="">Книги</a> / <a href="">Добавление книги</a>
@endsection

@section("content")
	<div class="head">
		<h1>Добавление книги</h1>
	</div>
	<div class="content">
		<h2 class = "head">Форма добавления</h2>
		<!-- Форма добавления -->
		<form method = "POST" enctype="multipart/form-data">

			<!-- {{ csrf_token() }} -->
		<div class="form">
			<!-- Левая часть формы -->
			<div class="left">

				<!-- Название книги -->
				<p>Название книги</p>
				<input type="text" id = "book_title" name = "book_title">

				<!-- Название книги на русском -->
				<p>Название книги на русском</p>
				<input type="text" id = "russian_title" name = "russian_title">
				
				<!-- Обложка для книги -->
				<p><span id = "cover_upload" style = "color: red">Файл не выбран</span></p>
				<input type="file" class = "load_cover" name = "cover" id = "load_cover">
				<input type="button" value = "Загрузить обложку" id = "cover_button">

				<!-- Год релиза -->
				<p>Год релиза</p>
				<input type="text" id = "release_year" name = "release_year">

				<!-- ISBN -->
				<p>ISBN</p>
				<input type="text" id = "isbn" name = "isbn" />

				<!-- Состояние выпуска -->
				<p>Состояние выпуска</p>
				<select id="release_status" name = "release_status">
					<option value="Продолжается">Продолжается</option>
					<option value="Завершён">Завершён</option>
					<option value="Приостановлен">Приостановлен</option>
				</select>

				<!-- Состояние перевода -->
				<p>Состояние перевода</p>
				<select id="translate_status" name = "translate_status">
					<option value="Продолжается">Продолжается</option>
					<option value="Завершён">Завершён</option>
					<option value="Приостановлен">Приостановлен</option>
				</select>

				<!-- Общий объём -->
				<p>Общий объём</p>
				<input type="text" id = "overall_volume" name = "overall_volume">

				<!-- Объём перевода -->
				<p>Объём перевода</p>
				<input type="text" id = "translation_volume" name = "translation_volume">

			</div>

			<!-- Правая часть формы -->
			<div class="right">

				<!-- Автор -->
				<p>Автор</p>
				<input type="text" id = "author" name = "author">

				<!-- Переводчик -->
				<p>Переводчик</p>
				<input type="text" id = "translator" name = "translator">

				<!-- Жанры -->
				<p>Жанры</p>
				<input type="text" id = "genres" name = "genres">
				<select class = "min">
					<option value=""></option>
				</select>
				<input type="button" class = "min" value = "Добавить">

				<!-- Теги -->
				<p>Теги</p>
				<input type="text" id = "tags" name = "tags">
				<select class = "min" name="" id=""></select>
				<input type="button" class = "min" value = "Добавить">

				<!-- Тип -->
				<p>Тип</p>
				<select id = "type" name = "type">
					<option value="Книга">Книга</option>
					<option value="Новелла">Новелла</option>
				</select>

				<!-- Аннотация к книге -->
				<p>Аннотация к книге</p>
				<textarea id="annotation" name = "annotation"></textarea>

			</div>

			<!-- Кнопка добавления -->
			<input type="button" value = "Добавить" onclick = "ajax_book_add()">

		</div>
		</form>
	</div>
@endsection