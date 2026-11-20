<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'The email or password is incorrect.'])->onlyInput('email');
        }

        if (! Auth::user()->is_active) {
            Auth::logout();

            return back()->withErrors(['email' => 'Your account has been suspended. Contact the WasteBack office.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route(Auth::user()->homeRoute()));
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    /** Public sign up is for households only; agents are created by an administrator. */
    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['required', 'string', 'regex:/^(\+256|0)7\d{8}$/'],
            'zone' => ['required', Rule::in(config('site.zones'))],
            'address' => ['required', 'string', 'max:200'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], ['phone.regex' => 'Enter a Ugandan mobile number such as 0772123456 or +256772123456.']);

        $user = User::create($data + ['role' => 'household']);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('household.dashboard')->with('success', 'Welcome to WasteBack. Book your first pickup to start earning.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
