<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'regex:/^(\+256|0)7\d{8}$/'],
            'zone' => ['required', Rule::in(config('site.zones'))],
            'address' => ['nullable', 'string', 'max:200'],
        ], ['phone.regex' => 'Enter a Ugandan mobile number such as 0772123456.']);

        $user->update($data);

        return back()->with('success', 'Your profile was updated.');
    }

    public function password(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        $request->user()->update(['password' => $request->input('password')]);

        return back()->with('success', 'Your password was changed.');
    }
}
