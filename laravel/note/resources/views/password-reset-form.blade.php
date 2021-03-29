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

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group row my-2">
                <label for="email" class="col-lg-5 col-form-label">{{ __('E-Mail Address') }}</label>

                <div class="col-lg-7">
                    <input id="email"
                           name="email"
                           type="email"
                           value="{{ $email ?? old('email') }}"
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

            <div class="form-group row my-2">
                <label for="password" class="col-lg-5 col-form-label">{{ __('Password') }}</label>

                <div class="col-lg-7">
                    <input id="password"
                           name="password"
                           type="password"
                           required
                           minlength="6"
                           maxlength="70"
                           autocomplete="new-password"
                           class="form-control @error('password') border-danger @enderror">

                    @error('password')
                    <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row my-2">
                <label for="password-confirm" class="col-lg-5 col-form-label">{{ __('Confirm Password') }}</label>

                <div class="col-lg-7">
                    <input id="password-confirm"
                           name="password_confirmation"
                           type="password"
                           required
                           minlength="6"
                           maxlength="70"
                           autocomplete="new-password"
                           class="form-control @error('password') border-danger @enderror">
                </div>
            </div>

            <div class="mt-2 d-inline-flex col-12 justify-content-end">
                <button type="submit" class="btn btn-primary ml-auto">Reset Password</button>
            </div>
        </form>

        <div class="row mt-3">
            <a href="{{ route('auth.login') }}" class="col-2">Login</a>
            <a href="{{ route('auth.register') }}" class="col-2">Register</a>
        </div>
    </div>
@endsection