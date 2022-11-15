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
      <td><a href="/main/galery/{{$result['full_image']}}">{{$result['name']}}</a></td>
      <td>{{$result['desc']}}</td>
      <td><img src="{{URL::asset($result['preview_image'])}}" alt="" height=100px width=100px></td>
    </tr>
   @endforeach
  </tbody>
</table>
@endsection