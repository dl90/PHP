@extends('layouts.base')

@section('pageTitle')
    Note: {{$title ?? 'Message'}}
@endsection

@section('bodyContent')
    <div class="container mt-5">
        <p>{{$message ?? ''}}</p>
        <a href="/">Home</a>
    </div>
@endsection