@extends('layouts.layout')
@section('content')
<table class="table">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Name</th>
      <th scope="col">Desc</th>
      <th scope="col">Image</th>
    </tr>
  </thead>
  <tbody>
    @foreach($results as $result)
    <tr>
      <th scope="row">{{$result['date']}}</th>
      <td>{{$result['name']}}</td>
      <td>{{$result['desc']}}</td>
      <td>{{$result['preview_image']}}</td>
    </tr>
   @endforeach
  </tbody>
</table>
@endsection