<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the "forgot password" view. The user enters their email and
     * a new password directly here — no reset link email is sent.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Reset the user's password immediately, without an email link or token.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::where('email', $request->email)->first();

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => \Illuminate\Support\Str::random(60),
        ])->save();

        return redirect()->route('login')->with('status', __('Your password has been reset.'));
    }
}
