@extends('layouts.layout')
@section('content')

    <div class="card" style="width: 58rem;">
    <form action="{{$article->id}}" method="post">
        @method('delete')
        @csrf
        <div class="card-body">
            <h5 class="card-title">{{$article->name}}, ({{$article->date}})</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{$article->shortDesc}}</h6>
            <p class="card-text">{{$article->desc}}</p>
            <a href="/article/{{$article->id}}/edit" class="btn btn-info">Редактировать</a>
            <!-- <a href="/article/{{$article->id}}" class="btn btn-warning">Удалить</a> -->
            <button class="btn btn-warning" type="submit">Удалить</button>
        </div>
    </form>
  <h2 class="text-center">Комментарии</h2>
  @foreach($comments as $comment)
  <div class="card-body">
    <h5 class="card-title">{{$comment->title}}, ({{$comment->created_at}})</h5>
    <p class="card-text">{{$comment->text}}</p>
    @can('update-comment', $comment)
    <a href="/comment/{{$comment->id}}" class="btn btn-secondary">Редактировать</a>
    <a href="/comment/{{$comment->id}}/delete" class="btn btn-secondary">Удалить</a>
    @endcan
  </div>
  @endforeach
  {{$comments->links()}}
  <h2 class="text-center">Новый комментарий</h2>
  <form action="/comment/{{$article->id}}" method="post">
  @csrf
   <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Заголовок</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="title" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Текст</label>
    <textarea class="form-control" id="exampleInputPassword1" name="text"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Добавить</button>
  </form>
</div>


@endsection