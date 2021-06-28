@extends("books.shablon")

@section("title")
	Книги / Ранобэ / Новеллы
@endsection

@section("script")
	<script>
		$(function() {

			// Подсчёт и вывод количества томов
			// ===================================
			let count_volume = '{{ $data->book->overall_volume }}';
			count_volume = count_volume.split(" ");
			count_volume = count_volume[0];
			out = "";
			for(let i = 1; i <= count_volume; i++) { out += `<option value = "${i}">${i}</option>`; }
			$("#volume").html(out);
			// ===================================

			// Работа с названими томов
			// ===================================
			// Разбор данных
			let vl_title = "{{ json_encode($data->volume_title) }}";
			let arr_vl = vl_title.split("&quot;");
			arr_vl.shift(); arr_vl.pop();

			// Некоторая работа с разобранными данными;
			vl_title = arr_vl.join(" ");
			let vl_count = vl_title.split(" ");
			for(let i = 0; i < vl_count.length; i++) { vl_title = vl_title.replace(" : ", " "); }
			arr_vl = vl_title.split(" , ");
			for(let i = 0; i < arr_vl.length; i++) { arr_vl[i] = arr_vl[i].replace(" ", "_"); }
			let arr_one = [], arr_two = [];
			for(let i = 0; i < arr_vl.length; i++) {
				arr_one = arr_vl[i].split("_");
				arr_two[arr_one[0]] = arr_one[1];
			}

			// В случае наличия названий томов
			if (arr_two.length != 0) {
				$("#volume_title").attr("disabled", "true");
				$("#volume_title").val(arr_two[1]);
			}

			// Сама работа с названиями томов
			document.querySelector("#volume").addEventListener('change', function (e) {
				if(arr_two[e.target.value] != undefined) {
					$("#volume_title").attr("disabled", "true");
					$("#volume_title").val(arr_two[e.target.value]);
				} else {
					$("#volume_title").removeAttr("disabled");
					$("#volume_title").val("");
				}
			});
			// ===================================


			// Для выбора файла главы
			// ===================================
			$("#chapter_button").click(function() {
				$("#load_chapter").click();
			});
			$("#load_chapter").on("change", function(e) {

				// Проверка на наличие файла
				if ($(this).val() == "") {

					// В случае отсутствия файла
					$("#chapter_upload").html("Файл не выбран");
					$("#chapter_upload").css("color", "red");
					$("#state").css("color", "red").html("(Недоступно)");
					$("#unloading_content").attr("disabled", "true");

				} else {
					
					// Получение файла
					let file = $(this)[0].files[0];

					// Проверка на размер файла
					if(parseInt(file.size / 1024 / 1024) > 5) { call_message("Файл превышает предел в 5мб"); return; }

					// Проверка на расширение
					let exp = file.name.split(".");
					if (exp[1] != "fb2" && exp[1] != "docx" && exp[1] != "epub" && exp[1] != "mobi" && exp[1] != "txt") {
						call_message("Файл должен быть одного из следующих форматов: fb2, docx, epub, mobi, txt");
						$("#chapter_upload").html("Файл не выбран");
						$("#chapter_upload").css("color", "red");
						$("#state").css("color", "red").html("(Недоступно)");
						$("#unloading_content").attr("disabled", "true");
						return;
					}
					console.log($("#load_chapter").prop("files")[0]);

					// Проверка на расширение fb2
					if (exp[1] != "fb2") {
						$("#chapter_upload").html("Файл загружен");
						$("#chapter_upload").css("color", "green");
						return;
					}

					// Создание экземпляра для чтения файла
					// ===================================
					let reader = new FileReader();
					// Добавление файла к экземпляру
					reader.readAsText(file);

					// В случае успеха загрузки файла
					reader.onload = function() {

						// Работа с форматированием текста
						let regimg = /^<binary.*<\/binary>$/;
						let arr_content = reader.result.split("<section>");
						arr_content.splice(0, 3);
						arr_content.pop();

						let join_content = arr_content.join("<title>");

						arr_content = join_content.split("</section>");
						let pre_content = [];
						for (let i = 0; i < arr_content.length; i++) {
							// pre_content[i] = arr_content[i].replace(regimg, "");
							pre_content[i] = arr_content[i].replace("<title>", "<h2>");
							pre_content[i] = pre_content[i].replace("<title>", "");
							pre_content[i] = pre_content[i].replace("</title>", "</h2>");
						}

						let content = pre_content.join("<h2>");
						
						// Активация кнопки
						$("#state").css("color", "green").html("(Доступно)");
						$("#unloading_content").removeAttr("disabled");
						// Вывод файла в див по нажатию кнопки
						$("#unloading_content").click(function() {
							document.querySelector("#text_content").innerHTML = content;
						});
					};

					// Сообщение об ошибке в случае провала
					reader.onerror = function() {
						console.log(reader.error);
					}

					// ===================================

					$("#chapter_upload").html("Файл загружен");
					$("#chapter_upload").css("color", "green");
				}
			});
			// ===================================

			// При выборе типа добавления
			// ===================================
			document.querySelector("#type").addEventListener('change', function (e) {
				let value = e.target.value;
				if(value == "wholly") {
					document.querySelector("#chapter").disabled = true;
				} else {
					document.querySelector("#chapter").disabled = false;
				}
			});
			// ===================================
		});

		// AJAX запрос на добавление главы
		// ===========================
		function ajax_add_chapter() {
			// Получение файла главы (2 метода)
			let chapter = $("#load_chapter").prop("files")[0];
			if(chapter == undefined) {
				call_message("Загрузите файл");
				return;
			}
			// chapter = $("#load_chapter")[0].files[0];
			let exp = chapter.name.split(".");
			if (exp[1] != "fb2" && exp[1] != "docx" && exp[1] != "epub" && exp[1] != "mobi" && exp[1] != "txt") {
				call_message("Файл должен быть одного из следующих форматов: fb2, docx, epub, mobi, txt");
				return;
			}

			// Создание экземпляра FormData
			let fd = new FormData();

			// Добавление объектов в экземпляр
			fd.append("volume", $("#volume").val());
			fd.append("volume_title", $("#volume_title").val());
			fd.append("chapter", $("#chapter").val());
			fd.append("chapter_title", $("#chapter_title").val());
			fd.append("file", chapter);
			fd.append("type", $("#type").val());
			fd.append("extension", exp[1]);

			// AJAX запрос
			$.ajax({
				url: "/book/{{ $data->book->id_book }}/add/chapter",
				type: "POST",
				cache: false,
				contentType: false,
				processData: false,
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
	<a href="/">{{ $data->book->type }}</a> / <a href="/book/{{ $data->book->id_book }}">{{ $data->book->book_title }}</a> / <a href="">Добавление главы</a>
@endsection

@section("content")
	<div class="head">
		<h1>Добавление главы</h1>
	</div>
	<div class="content">
		<h2 class = "head">Форма добавления</h2>

		<!-- Обёртка формы -->
		<div class="form">

			<!-- Левая часть формы -->
			<div class="left">

				<!-- Том главы -->
				<p>Том</p>
				<select id="volume"></select>

				<!-- Название тома -->
				<p>Название тома</p>
				<input type="text" id = "volume_title">

				<!-- Загрузка файла -->
				<p><span id = "chapter_upload" style = "color: red">Файл не выбран</span></p>
				<input type="file" class = "load" id = "load_chapter">
				<input type="button" value = "Загрузить" id = "chapter_button">

			</div>

			<!-- Правая часть формы -->
			<div class="right">

				<!-- Номер главы -->
				<p>Номер главы</p>
				<input type="number" id = "chapter">

				<!-- Название главы -->
				<p>Название главы</p>
				<input type="text" id = "chapter_title">


				<!-- Выгрузка содержания для просмотра материала -->
				<p>Выгрузка содержания для просмотра <span id="state" style = "color: red">(Недоступно)</span></p>
				<input type="button" value = "Выгрузить" id = "unloading_content" disabled />

				<!-- Тип главы -->
				<p>Тип добавления</p>
				<select id="type">
					<option value="illustrations">Иллюстрации</option>
					<option value="prologue">Пролог</option>
					<option value="chapter" selected>Глава</option>
					<option value="epilogue">Эпилог</option>
					<option value="afterwords">Послесловие</option>
					<option value="side_story">Побочная История</option>
					<option value="wholly">Произведение целиком</option>
				</select>

			</div>

			<!-- Содержание главы -->
			<!-- <textarea id="chapter_content"></textarea> -->
			<div id="text_content">
				<span>Тут будет находится содержание</span>
			</div>

			<!-- Кнопка добавления -->
			<input type="button" value = "Добавить" onclick = "ajax_add_chapter()">

		</div>
	</div>
@endsection