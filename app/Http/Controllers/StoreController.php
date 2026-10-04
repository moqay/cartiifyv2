<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function __invoke(Site $site): View
    {
        return view('store', ['site' => $site->load('products')]);
    }
}
