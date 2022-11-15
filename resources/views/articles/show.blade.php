@extends('layout.layout')
@section('content')
<div class="card" style="margin-top">
<form action="/articles/{{$article->id}}" method="post">
    @method('DELETE')
    @csrf
    <div class="card-body">
        <h5 class="card-title">{{$article->name}} ({{$article->date}})</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{$article->shortDesc}}</h6>
        <p class="card-text">{{$article->desc}}</p>
        <a href="/articles/{{$article->id}}/edit" class="btn btn-info">Редактировать</a>
        <button type="submit" class="btn btn-warning">Удалить</button>
    </div>
</form>
 
</div>
@endsection