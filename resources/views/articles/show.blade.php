@extends('layouts.layout')
@section('content')
<form action="/article/{{$article->id}}" method="POST">
    @method('DELETE')
    @csrf
    <div class="card" style="margin-top">
        <div class="card-body">
            <h5 class="card-title">{{$article->name}}  ({{$article->date}})</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{$article->shortDesc}}</h6>
            <p class="card-text">{{$article->desc}}</p>
            <a href="/article/{{$article->id}}/edit" class="btn btn-info">Редактировать</a>
            <button type="submit" class="btn btn-warning">Удалить</button>
        </div>
    </div>
</form>
@endsection