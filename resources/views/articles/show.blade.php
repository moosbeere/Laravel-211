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

    <h3 class=text-center>Комментарии</h3>
    <div class="card" style="margin-top">
    @foreach($comments as $comment)
        <div class="card-body">
            <h5 class="card-title">{{$comment->title}}  ({{$comment->created_at}})</h5>
            <p class="card-text">{{$comment->text}}</p>
            <a href="/comment/{{$comment->id}}/edit" class="btn btn-secondary">Редактировать</a>
            <a href="/comment/{{$comment->id}}/delete" class="btn btn-secondary">Удалить</a>
        </div>
    @endforeach
    </div>
    </form>

    <h6 class=text-center>Новый комментарий</h6>
    <div class="card" style="margin-top">
    @if($errors->any())
<div class="alert-danger">
    @foreach($errors->all() as $error)
        <ul>
            <li>{{$error}}</li>
        </ul>
    @endforeach
</div>
@endif


<form action="/comment/{{$article->id}}" method="POST">
    @csrf
  <div class="mb-3">
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Title</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="title">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Text</label>
    <textarea name="text" id="" cols="30" class="form-control" rows="10"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Добавить</button>
  </form>
  </div>

@endsection