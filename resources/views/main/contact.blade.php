@extends('layout.layout')
@section('content')
    <p class="text-uppercase">{{$contact['name']}}</p>
    <p class="text-capitalize">{{$contact['adres']}}</p>
    <p class="text-lowercase">{{$contact['phone']}}</p>
    <p class="text-lowercase">{{$contact['email']}}</p>

@endsection