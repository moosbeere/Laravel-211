@extends('layouts.layout')
@section('content')
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">SHortDesc</th>
    </tr>
  </thead>
  <tbody>
    @foreach($articles as $article)
    <tr>
      <th scope="row">{{$article->id}}</th>
      <td>{{$article->name}}</td>
      <td>{{$article->shortDesc}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection