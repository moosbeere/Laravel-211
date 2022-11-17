@extends('layouts.layout')
@section('content')
<div class="card" style="margin-top">
  <div class="card-body">
    <h5 class="card-title">{{$article->name}}  ({{$article->date}})</h5>
    <h6 class="card-subtitle mb-2 text-muted">{{$article->shortDesc}}</h6>
    <p class="card-text">{{$article->desc}}</p>
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
  </div>
</div>
@endsection