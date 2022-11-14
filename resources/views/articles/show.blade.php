@extends('layouts.layout')
@section('content')
<div class="card" style="width: 30rem;">
  <div class="card-body">
    <h5 class="card-title">{{$article->name}}, ({{$article->date}})</h5>
    <h6 class="card-subtitle mb-2 text-muted">{{$article->shortDesc}}</h6>
    <p class="card-text">{{$article->desc}}</p>
    <a href="/article/edit/{{$article->id}}" class="card-link">Редактировать</a>
    <a href="/article/destroy/{{$article->id}}" class="card-link">Удалить</a>
  </div>
</div>
@endsection