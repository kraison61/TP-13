<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function show(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'login' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $login = trim($data['login']);
        $user = $this->findUserByLogin($login);

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return back()
                ->withErrors(['login' => 'อีเมล/เบอร์โทร หรือรหัสผ่านไม่ถูกต้อง'])
                ->onlyInput('login');
        }

        if ($user->role !== 'admin') {
            return back()
                ->withErrors(['login' => 'ไม่มีสิทธิ์เข้าใช้งานระบบ'])
                ->onlyInput('login');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('admin.index'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function findUserByLogin(string $login): ?User
    {
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return User::query()->where('email', $login)->first();
        }

        $normalizedTel = preg_replace('/[\s\-]/', '', $login) ?? $login;

        return User::query()
            ->whereNotNull('tel')
            ->whereRaw(
                "REPLACE(REPLACE(tel, ' ', ''), '-', '') = ?",
                [$normalizedTel]
            )
            ->first();
    }
}
