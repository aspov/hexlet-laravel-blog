@extends('layouts.app')

@section('content')
	@if (session('status'))
	    <div class="alert alert-success">
		{{ session('status') }}
	    </div>
	@endif
	<a href="{{ route('articles.create') }}">Создать категорию</a>
	{{Form::open(['url' => route('articles.index'), 'method' => 'get'])}}
        	{{Form::text('q', $q)}}
        	{{Form::submit('Search')}}
    	{{Form::close()}}

    <h1>Список статей</h1>
    @foreach($articles as $article)
        <a href=" {{route('articles.show', $article->id )}}">{{$article->name}}</a>
        {{-- Str::limit – функция-хелпер, которая обрезает текст до указанной длины --}}
        {{-- Используется для очень длинных текстов, которые нужно сократить --}}
	
        <div>{{Str::limit($article->body, 200)}}</div>
    @endforeach
@endsection



