<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $role = $request->query('role');
        $search = trim((string) $request->query('q'));

        $users = User::query()
            ->when(in_array($role, User::ROLES, true), fn ($q) => $q->where('role', $role))
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")))
            ->withCount(['pickups', 'assignedPickups'])
            ->orderBy('role')->orderBy('name')
            ->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users', 'role', 'search'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['required', 'string', 'regex:/^(\+256|0)7\d{8}$/'],
            'role' => ['required', Rule::in(User::ROLES)],
            'zone' => ['required', Rule::in(config('site.zones'))],
            'address' => ['nullable', 'string', 'max:200'],
            'password' => ['required', Password::min(8)->letters()->numbers()],
        ], ['phone.regex' => 'Enter a Ugandan mobile number such as 0772123456.']);

        $user = User::create($data);

        return redirect()->route('admin.users.index')->with('success', ucfirst($user->role).' account for '.$user->name.' was created.');
    }

    public function toggle(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->with('error', 'You cannot suspend your own account.');
        }

        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('success', $user->name.' is now '.($user->is_active ? 'active' : 'suspended').'.');
    }
}
