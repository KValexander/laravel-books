@extends("books.shablon")

@section("title")
	Книги / Ранобэ / Новеллы
@endsection

@section("script")

	<!-- ====================== -->
	<!-- ======== ??? ========= -->
	<!-- ====================== -->
	<!-- == XMLHttpRequest() == -->
	<!-- ====================== -->
	<!-- ======== Или ========= -->
	<!-- ====================== -->
	<!-- ====== $.get() ======= -->
	<!-- ====================== -->
	<!-- ======== ??? ========= -->
	<!-- ====================== -->

	<script>
		$(function() {
			getDataXMLHttpRequest("{{ asset($data->chapter->path) }}");
			// getDataGET("{{ asset($data->chapter->path) }}");
		});

		// Функция получения данных файла методом XMLHttpRequest
		// ===================================
		function getDataXMLHttpRequest(url) {
			// Создание нового объекта XMLHttpRequest
			var xhr = new XMLHttpRequest();
			// Открытие документа
			xhr.open("GET", url, true);
			xhr.send();
			// В случае всего хорошего
			xhr.onreadystatechange = function() {
				// Передача извлечённых данных функции
				DataFileProccesing(this.responseText);
			}
		}
		// ===================================

		// Функция получения данных файла методом $.get
		// ===============================
		function getDataGET(url) {
			$.get(url, function(data) {
				DataFileProccesing(data);
			});
		}
		// ===================================

		// Функция обработки полученных данных
		// =================================
		function DataFileProccesing(data) {
			let book = data;
			book = book.split("</body>");
			book = book[0];
			let arr_content = book.split("<section>");
			arr_content.shift();
			arr_content = arr_content.join("<title>");
			arr_content = arr_content.split("</section>");
			let pre_content = [];
			for (let i = 0; i < arr_content.length; i++) {
				pre_content[i] = arr_content[i].replace("<title>", "<h2>");
				pre_content[i] = pre_content[i].replace("<title>", "");
				pre_content[i] = pre_content[i].replace("</title>", "</h2>");
			}
			book = pre_content.join("<h2>");
			$("#text_content").html(book);
		}
		// =================================

	</script>
@endsection

@section("menu")
	<a href="/">{{ $data->book->type }}</a> / <a href="/book/{{ $data->book->id_book }}">{{ $data->book->book_title }}</a> / <a href=""></a>
@endsection

@section("content")
	<div class="content">
		<div class="chapter_content">
			<div id="text_content">
			</div>
		</div>
	</div>
@endsection