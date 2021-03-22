@extends('layouts.master')

@section('pageTitle')
    Profile
@endsection

@section('bodyContent')
    <h1>Profile page</h1>
    <p>Profile Page</p>

    @foreach($names as $name)
        <li>{{$name}}</li>
    @endforeach

    <div>born on {{$birthday}}</div>
    <div>{{$gender}}</div>
    <div>{{$city}}</div>
@endsection
