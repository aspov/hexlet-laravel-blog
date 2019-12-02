@extends('layouts.app')

@section('content')    
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{ Form::model($article, ['url' => route('articles.update', $article), 'method' => 'PATCH']) }}
         @include('article.form')
        {{ Form::submit('Обновить') }}
    {{ Form::close() }}
@endsection

