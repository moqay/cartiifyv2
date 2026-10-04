<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function signup(Request $request): JsonResponse
    {
        $data = $request->validate([
            'plan' => ['required', Rule::in(array_keys(config('cartiify.plans')))],
            'name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'email', 'max:120', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'sname' => ['required', 'string', 'max:60'],
            'sub' => ['required', 'regex:/^[a-z0-9][a-z0-9-]{1,28}[a-z0-9]$/', Rule::notIn(config('cartiify.reserved')), 'unique:sites,subdomain'],
            'currency' => ['required', Rule::in(array_keys(config('cartiify.currencies')))],
            'template' => ['required', Rule::in(array_keys(config('cartiify.templates')))],
        ], [
            'email.unique' => 'هذا البريد مسجّل بالفعل، سجّل الدخول بدلاً من ذلك.',
            'email.email' => 'البريد الإلكتروني غير صحيح.',
            'password.min' => 'كلمة المرور 6 أحرف على الأقل.',
            'sub.unique' => 'هذا الرابط محجوز، اختر غيره.',
            'sub.not_in' => 'هذا الرابط غير متاح، اختر غيره.',
            'sub.regex' => 'الرابط 3 أحرف إنجليزية/أرقام على الأقل.',
            'required' => 'هذا الحقل مطلوب.',
        ]);

        $user = DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'], 'email' => $data['email'], 'password' => $data['password'],
                'plan' => $data['plan'], 'trial_ends_at' => now()->addDays(config('cartiify.trial_days')), 'welcome' => true,
            ]);
            Site::provision($user, $data);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json(['redirect' => route('dashboard')]);
    }

    public function demo(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $templates = array_keys(config('cartiify.templates'));
        $tpl = $request->input('template');
        $tpl = in_array($tpl, $templates, true) ? $tpl : $templates[array_rand($templates)];
        $id = Str::lower(Str::random(6));

        $user = DB::transaction(function () use ($id, $tpl) {
            $user = User::create([
                'name' => 'زائر تجريبي', 'email' => "demo-{$id}@demo.cartiify.com", 'password' => Str::random(24),
                'plan' => 'growth', 'trial_ends_at' => now()->addDays(config('cartiify.trial_days')), 'welcome' => true, 'is_demo' => true,
            ]);
            Site::provision($user, ['sname' => 'متجري التجريبي', 'sub' => "demo-{$id}", 'template' => $tpl, 'currency' => 'EGP'], true);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return $request->expectsJson() ? response()->json(['redirect' => route('dashboard')]) : redirect()->route('dashboard');
    }

    public function login(Request $request): JsonResponse
    {
        $cred = $request->validate(['email' => ['required', 'email'], 'password' => ['required']]);

        if (! Auth::attempt($cred, true)) {
            return response()->json(['message' => 'البريد أو كلمة المرور غير صحيحة.'], 422);
        }
        $request->session()->regenerate();

        return response()->json(['redirect' => route('dashboard')]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['redirect' => route('login')]);
    }

    public function checkSubdomain(Request $request): JsonResponse
    {
        $sub = strtolower((string) $request->query('sub'));
        $ok = preg_match('/^[a-z0-9][a-z0-9-]{1,28}[a-z0-9]$/', $sub)
            && ! in_array($sub, config('cartiify.reserved'), true)
            && ! Site::where('subdomain', $sub)->exists();

        return response()->json(['available' => (bool) $ok]);
    }
}
