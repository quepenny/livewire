<?php

namespace Quepenny\Livewire\Http\Controllers;

use Quepenny\Livewire\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SocialLoginController extends Controller
{
    public function redirectToProvider(Request $request): RedirectResponse
    {
        return Socialite::driver($request->route('driver'))->redirect();
    }

    public function handleProviderCallback(Request $request): RedirectResponse
    {
        if ($request->has('error_message')) {
            return redirect()->route('login')->withErrors([
                'login-error' => $request->get('error_message')
            ]);
        }

        $socialite = Socialite::driver($request->route('driver'))->user();

        $user = User::firstOrCreate([
            'email' => $socialite->email
        ], [
            'name' => $socialite->name,
            'password' => $socialite->id,
        ]);

        Auth::login($user);

        return redirect('/');
    }
}
