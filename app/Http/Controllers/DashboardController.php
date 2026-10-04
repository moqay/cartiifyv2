<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user()->load('site.products', 'site.orders');

        return view('dashboard', ['state' => [
            'user' => ['name' => $user->name, 'email' => $user->email],
            'plan' => $user->plan,
            'trialEnds' => $user->trial_ends_at?->getTimestampMs(),
            'welcome' => $user->welcome,
            'site' => $user->site->toState(),
        ]]);
    }
}
