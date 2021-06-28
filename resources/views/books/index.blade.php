@extends("books.shablon")

@section("title")
	Книги / Ранобэ / Новеллы
@endsection

@section("script")
@endsection

@section("menu")
	<a href="/">Книги</a>
	<a href="/">Новеллы</a>
	<a href="/">Серии</a>
	<a href="/">Блоги</a>
	<a href="/">Жанры</a>
	<a href="/">Теги</a>
	@if($access == 1 || $access == 2) | <a href="/books/add">Добавить книгу</a>@endif
	@if($access == 1 || $access == 2) | <a href="/moderation">Модерация</a>@endif
@endsection

@section("content")
	<div class="head">
		<h1>Добро пожаловать</h1>
	</div>
	<div class="content">
		<h2 class = "head">Все произведения</h2>
		@foreach($data->books as $key => $val)
			<a href="/book/{{ $val->id_book }}"><div class="record">
				<div class="overlay">
					<p>{{ $val->title }}</p>
				</div>
				<img src="{{ asset($val->cover) }}" alt="">
			</div></a>
		@endforeach
	</div>
@endsection