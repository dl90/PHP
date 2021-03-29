@extends('layouts.base')

@section('pageTitle')
    Note: Password Reset
@endsection

@section('bodyContent')
    <div class="container col-lg-5 mt-5 border p-4">
        <h1 class="py-4">Password Reset</h1>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset.email') }}">
            @csrf

            <div class="form-group row my-2">
                <label for="email" class="col-lg-5 col-form-label">Email Address:</label>

                <div class="col-md-7">
                    <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            placeholder="Enter email"
                            required
                            maxlength="50"
                            autocomplete="email"
                            autofocus
                            class="form-control @error('email') border-danger @enderror">

                    @error('email')
                    <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-2 d-inline-flex col-12 justify-content-end">
                <button type="submit" class="btn btn-primary ml-auto">Send Password Reset Link</button>
            </div>
        </form>

        <div class="row mt-3">
            <a href="{{ route('auth.login') }}" class="col-2">Login</a>
            <a href="{{ route('auth.register') }}" class="col-2">Register</a>
        </div>
    </div>
@endsection