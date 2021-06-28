@extends("books.shablon")

@section("title")
	Книги / Ранобэ / Новеллы
@endsection

@section("script")
	<script>
		$(function() {

			// Предварительная работа с адресной строкой
			// ========================================
			var params = document.location.search;
			var search = new URLSearchParams(params);

			if(search.has("tab")) switching_tabs(search.get("tab"));
			else switching_tabs(1);
			// ========================================

			// Вызов функции
			book_preview();

			// Код для переключения табов
			// =============================
			$("div.tab").click(function(e) {
				switching_tabs(e.target.id);
			});

			// $("div.tab:first").click();
		});

		// Код для переключения табов
		// ===========================
		function switching_tabs(id) {
			let count = $("div.tab").length;
			pushState(id);

			for (let i = 1; i <= count; i++) {
				$("div#"+i).css("border-bottom","none");
				$("div#tab"+i).css("display", "none");
			}

			$("div#" + id).css("border-bottom","solid 3px #124258");
			$("div#tab" + id).css("display", "block");
		}

		// Код для обработки текста аннотации в соответстующий вид
		// =======================
		function book_preview() {
			var content = `{{ $data->book->annotation }}`;
			var regexp = /[\r\n]+/;

			var arr = content.split(regexp);
			for(var i = 0; i < arr.length; i++) {
				var content = content.replace(regexp, "<p>");
			}

			$("#annotation").html(content);
		}

		// Функция для работы с адресной строкой с помощью History Api для переключения табуляций
		// =======================
		function pushState(num) {
			if(window.history.state == null) {
				window.history.pushState({tab: num}, '', '?tab=' + num);
			} else {
				window.history.replaceState({tab: num}, '', '?tab=' + num);
			}
			return window.history.state.tab;
		}
	</script>
@endsection

@section("menu")
	@if($access != 0)
		@if($access == 1 || $access == 2 || $data->book->id_user == $id_auth)<a href="/book/{{ $data->book->id_book }}/add/chapter">Добавить главу</a>@endif
		@if($access == 1 || $access == 2 || $data->book->id_user == $id_auth)<a href="/book/{{ $data->book->id_book }}/update">Обновить книгу</a>@endif
		@if($access == 1 || $access == 2 || $data->book->id_user == $id_auth)<a href="/book/{{ $data->book->id_book }}/delete">Удалить</a>@endif
	@endif
@endsection

@section("content")
	<div class="characteristic">
		<div class="cover">
			<img src="{{ asset($data->book->cover) }}" alt="">
		</div>
		<div class="desc">
			<h2>{{ $data->book->book_title }} / {{ $data->book->russian_title }}</h2>
			<p class = "margin"><span>Выпуск {{ $data->book->release_status }} / Перевод {{ $data->book->translate_status }}</span></p>

			<div class="p"> <p class = "name"><b>Автор:</b></p> <p class = "content">{{ $data->book->author }}</p> </div>
			<div class="p"> <p class = "name"><b>Жанры:</b></p> <p class = "content">{{ $data->book->genres }}</p> </div>
			<div class="p"> <p class = "name"><b>Теги:</b></p> <p class = "content">{{ $data->book->tags }}</p> </div>
			<div class="p"> <p class = "name"><b>Общий объём:</b></p> <p class = "content">{{ $data->book->overall_volume }}</p> </div>
			<div class="p"> <p class = "name"><b>Объём перевода:</b></p> <p class = "content">{{ $data->book->translation_volume }}</p> </div>
			<p>
				<input type="button" value = "Читать" onclick = "document.location.href = '/book/{{ $data->book->id_book }}/chapter/1/1'">
				<input type="button" value = "В закладки">
				<input type="button" value = "Скачать">
			</p>

		</div>
	</div>

	<div class="characteristic">
		<div class="tabs">
			<div class="tab" id = "1">Информация</div>
			<div class="tab" id = "2">Содержание</div>
			<div class="tab" id = "3">Комментарии</div>
			<div class="tab" id = "4">Статистика</div>
		</div>
		<div class="tabs_content">

			<!-- Таб информация -->
			<div class="tab_content" id = "tab1">
				<h3>Аннотация</h3>
				<div id = "annotation"></div>
				<h3 class = "margin">Подробная информация</h3>
				@php $date = explode(" ", $data->book->created_at);  @endphp
				<p><b>Год релиза:</b> {{ $data->book->release_year }}</p>
				<p><b>Объем:</b> {{ $data->book->overall_volume }}</p>
				<p><b>ISBN:</b> {{ $data->book->isbn }}</p>
				<p><b>Переводчик:</b> {{ $data->book->translator }} </p>
				<p><b>Дата появления на сайте:</b> {{ $date[0] }}</p>
			</div>

			<!-- Таб содержание -->
			<div class="tab_content" id = "tab2">
				<h3>Содержание</h3>
				@if(count($data->chapters) == 0)
					<p>Главы отсутствуют</p>
				@else
					<!-- Цикл тома -->
					@for($i = 1; $i <= count($data->chapters); $i++)
						<div class="book_volume">
							<h4>Том {{ $i }} - {{ $data->chapters[$i][0]->volume_title }}</h4>
							<!-- Цикл глав -->
							@foreach($data->chapters[$i] as $key => $val)
								@php
									$type = $val->type;
									if($val->type == "illustrations") $type = "Иллюстрации";
									if($val->type == "prologue") $type = "Пролог";
									if($val->type == "chapter") $type = "Глава";
									if($val->type == "epilogue") $type = "Эпилог";
									if($val->type == "afterwords") $type = "Послесловие";
									if($val->type == "wholly") $type = "Целиком";
								@endphp
								<a href="/book/{{ $data->book->id_book }}/chapter/{{ $val->volume }}/{{ $val->chapter }}">
									<div class="book_chapters">
										@if($val->type == "wholly")
											<p>{{ $type }} - {{ $val->volume_title }}</p>
										@elseif($val->type == "chapter")
											<p>{{ $type }} {{ $val->chapter }} - {{ $val->chapter_title }}</p>
										@else
											<p>{{ $type }}</p>
										@endif
									</div>
								</a>
							@endforeach
						</div>
					@endfor
				@endif
			</div>

			<!-- Таб комментарии -->
			<div class="tab_content" id = "tab3">Комментарии</div>
			
			<!-- Таб статистика -->
			<div class="tab_content" id = "tab4">Статистика</div>
		</div>
	</div>
@endsection