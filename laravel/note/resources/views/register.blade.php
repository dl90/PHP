@extends('layouts.base')

@section('pageTitle')
    Note: Register
@endsection

@section('bodyContent')
    <div class="container col-lg-5 mt-5 border p-4">
        <h1 class="py-4">Register</h1>
        <form method="POST" action="{{ route('auth.register') }}">
            @csrf

            <div class="form-group row mt-2">
                <label for="_email" class="col-lg-5">Email address:</label>
                <div class="col-lg-7">
                    <input
                            id="_email"
                            name="email"
                            type="email"
                            vaule="{{ old('email') }}"
                            placeholder="Enter email"
                            required
                            maxlength="50"
                            autocomplete="email"
                            class="form-control @error('email') border-danger @enderror">
                </div>
            </div>
            <div class="form-group row mt-2">
                <label for="_password" class="col-lg-5">Password:</label>
                <div class="col-lg-7">
                    <input
                            id="_password"
                            name="password"
                            type="password"
                            placeholder="Password"
                            required
                            minlength="6"
                            maxlength="70"
                            class="form-control @error('password') border-danger @enderror">
                </div>
            </div>
            <div class="form-group row mt-2">
                <label for="_password_confirmation" class="col-lg-5">Confirm Password:</label>
                <div class="col-lg-7">
                    <input
                            id="_password_confirmation"
                            name="password_confirmation"
                            type="password"
                            placeholder="Password"
                            required
                            minlength="6"
                            maxlength="70"
                            class="form-control @error('password') border-danger @enderror">
                </div>
            </div>
            <br>
            <div class="mt-2 d-inline-flex col-12 justify-content-end">
                <button type="submit" class="btn btn-primary ml-auto">Signup</button>
            </div>
        </form>

        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="text-warning">{{ $error }}</div>
            @endforeach
        @endif

        <div class="row mt-3">
            <a href="{{ route('auth.login') }}" class="col-2">Login</a>
            <a href="{{ route('password.reset.email') }}" class="col-4">Forgot Password</a>
        </div>
    </div>
@endsection
