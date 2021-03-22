@extends('layouts.master')

@section('pageTitle')
    Welcome {{$name}}
@endsection

@section('bodyContent')
    <h1>
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </h1>
@endsection
