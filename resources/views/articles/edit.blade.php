@extends('layout.layout')
@section('content')

@if($errors->any())
    <div class="alert-danger">
        <ul>
        @foreach($errors->all() as $error)
            <li>
                {{$error}}
            </li>
        @endforeach
        </ul>
    </div>
@endif

<form action="/articles/{{$article->id}}" method="POST">
    @method('PUT')
    @csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Date</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="date" aria-describedby="emailHelp" value="{{$article->date}}">
 </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Name</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="name" value="{{$article->name}}">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Annotation</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="annotation" value="{{$article->shortDesc}}">
  </div>
  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{$article->desc}}</textarea>
  </div>
  <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection