@extends('layouts.layout')
@section('content')
<table class="table">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Name</th>
      <th scope="col">Annotation</th>
      <th scope="col">Description</th>
    </tr>
  </thead>
  <tbody>
    @foreach($articles as $article)
    <tr>
      <th scope="row">{{$article->date}}</th>
      <td><a href="/article/{{$article->id}}">{{$article->name}}</a></td>
      <td>{{$article->shortDesc}}</td>
      <td>{{$article->desc}}</td>
    </tr>
   @endforeach
  </tbody>
</table>
{{$articles->links()}}
@endsection