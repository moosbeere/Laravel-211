@extends ('layouts.layout')
@section('content')
    <p>{{$contact['name']}}</p>
    <p>{{$contact['adres']}}</p>
    <p>{{$contact['phone']}}</p>
    <p>{{$contact['email']}}</p>
@endsection