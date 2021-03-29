<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

  public function showLogin()
  {
    return Auth::check()
      ? redirect('/note')
      : view('/login');
  }

  public function authenticate()
  {
    request()->validate([
      'email' => ['required', 'string', 'email', 'max:50'],
      'password' => ['required', 'string', 'min:6', 'max:70']
    ]);

    $credentials = request()->only('email', 'password');
    $remember = request('remember') !== null;

    if (Auth::attempt($credentials, $remember)) {
      request()->session()->regenerate();
      return redirect('/note');
    }

    return back()
      ->withErrors(['auth' => 'The provided credentials do not match our records.'])
      ->withInput(request()->except('password'));
  }


  public function showLogout()
  {
    Auth::logout();
    return redirect('/');
  }

  public function logout()
  {
    $user = auth()->user();
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return view('confirmation-message', [
      'title' => 'Logout Confirmation',
      'message' => "$user->email has logged out."
    ]);
  }


  public function showRegister()
  {
    return view('register');
  }

  public function register(Request $request)
  {
    $request->validate([
      'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
      'password' => ['required', 'string', 'min:6', 'max:70', 'confirmed']
    ]);

    $user = User::create([
      'email' => request('email'),
      'password' => Hash::make(request('password'))
    ]);

    return view('confirmation-message', [
      'title' => 'Register Confirmation',
      'message' => $user
        ? "Registered with $user->email."
        : 'Oops something went wrong, registration failed.'
    ]);
  }


  /* ----- pw reset ---- */

  public function showPwReset()
  {
    return view('password-reset-email');
  }

  public function postPwResetEmail(Request $request)
  {
    $request->validate(['email' => ['required', 'email', 'max:50']]);
    $response = Password::broker()->sendResetLink(request()->only('email'));
    return $response == Password::RESET_LINK_SENT
      ? $this->sendResetLinkResponse($request, $response)
      : $this->sendResetLinkFailedResponse($request, $response);
  }

  protected function sendResetLinkResponse(Request $request, $response)
  {
    return $request->wantsJson()
      ? new JsonResponse(['message' => trans($response)], 200)
      : back()->with('status', trans($response));
  }

  protected function sendResetLinkFailedResponse(Request $request, $response)
  {
    if ($request->wantsJson())
      throw ValidationException::withMessages(['email' => [trans($response)]]);

    return back()
      ->withInput($request->only('email'))
      ->withErrors(['email' => trans($response)]);
  }


  public function showPwResetForm(Request $request)
  {
    return view('password-reset-form')->with([
        'token' => $request->token,
        'email' => $request->email]
    );
  }

  public function updatePassword(Request $request)
  {
    $request->validate([
      'token' => 'required',
      'email' => ['required', 'email', 'max:50'],
      'password' => ['required', 'confirmed', 'min:6', 'max:70']
    ]);

    // Here we will attempt to reset the user's password. If it is successful we
    // will update the password on an actual user model and persist it to the
    // database. Otherwise we will parse the error and return the response.
    $response = Password::broker()->reset(
      $request->only('email', 'password', 'password_confirmation', 'token'),
      function ($user, $password) {
        $this->resetPassword($user, $password);
      }
    );

    // If the password was successfully reset, we will redirect the user back to
    // the application's home authenticated view. If there is an error we can
    // redirect them back to where they came from with their error message.
    return $response == Password::PASSWORD_RESET
      ? $this->sendResetResponse($request, $response)
      : $this->sendResetFailedResponse($request, $response);
  }

  protected function resetPassword($user, $password)
  {
    $user->password = Hash::make($password);
    $user->setRememberToken(Str::random(60));
    $user->save();
    event(new PasswordReset($user));
    Auth::guard()->login($user);
  }

  protected function sendResetResponse(Request $request, $response)
  {
    if ($request->wantsJson())
      return new JsonResponse(['message' => trans($response)], 200);
    return redirect(route('auth.login'))->with('status', trans($response));
  }

  protected function sendResetFailedResponse(Request $request, $response)
  {
    if ($request->wantsJson())
      throw ValidationException::withMessages(['email' => [trans($response)]]);

    return redirect()->back()
      ->withInput($request->only('email'))
      ->withErrors(['email' => trans($response)]);
  }
}