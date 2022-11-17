@extends('layouts.layout')
@section('content')
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


<form action="/comment/{{$comment->id}}" method="POST">
    @csrf
    @method('PUT')
  <div class="mb-3">
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Title</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="title" value="{{$comment->title}}">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Text</label>
    <textarea name="text" id="" cols="30" class="form-control" rows="10">{{$comment->title}}</textarea>
  </div>
  <button type="submit" class="btn btn-primary">Изменить</button>
  </form>
  </div>
  @endsection