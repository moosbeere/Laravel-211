@extends('layouts.layout')
@section('content')

@if($errors->any())
<div class="alert-danger">
    @foreach($errors->all() as $error)
        <ul>
            <li>{{$error}}</li>
        </ul>
    @endforeach
</div>
@endif


<form action="/article" method="POST">
    @csrf
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Date</label>
    <input type="date" class="form-control" id="exampleInputPassword1" name="date">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Title</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="title">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Annotation</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="annot">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Text</label>
    <textarea name="text" id="" cols="30" class="form-control" rows="10"></textarea>
  </div>

  <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
@endsection