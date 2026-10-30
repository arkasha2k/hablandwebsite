<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:32'],
            'password' => ['required', 'string'],
        ]);

        // username ищем без учёта регистра, как в Habbo
        $user = User::whereRaw('LOWER(username) = ?', [mb_strtolower($credentials['username'])])->first();

        if (! $user || ! \Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['username' => 'Неверный никнейм или пароль.'])->onlyInput('username');
        }

        Auth::login($user, $request->boolean('remember'));
        $user->forceFill(['last_login' => now()->timestamp])->save();
        $request->session()->regenerate();

        return redirect()->intended(route('me'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:16', 'regex:/^[A-Za-z0-9_\-]+$/',
                'unique:users,username'],
            'mail'     => ['required', 'email', 'max:64', 'unique:users,mail'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'gender'   => ['required', 'in:M,F'],
        ], [
            'username.regex' => 'Ник может содержать только латиницу, цифры, _ и -',
        ]);

        $looks = [
            'M' => 'hr-115-42.hd-190-1.ch-215-62.lg-285-91.sh-290-62',
            'F' => 'hr-540-42.hd-605-1.ch-645-62.lg-715-91.sh-735-62',
        ];

        $user = User::create([
            'username'        => $data['username'],
            'password'        => $data['password'], // хешируется кастомным драйвером (casts)
            'mail'            => $data['mail'],
            'gender'          => $data['gender'],
            'motto'           => 'Новичок в Habland Hotel!',
            'look'            => $looks[$data['gender']],
            'rank'            => 1,
            'credits'         => 100,
            'account_created' => time(),
            'last_login'      => time(),
            'last_online'     => time(),
            'ip_register'     => $request->ip(),
            'ip_current'      => $request->ip(),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('me')->with('success', 'Добро пожаловать в Habland Hotel!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
