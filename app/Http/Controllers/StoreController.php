<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function __invoke(Site $site): View
    {
        $site->increment('visits');

        return view('store', ['site' => $site->load('products')]);
    }

    public function checkout(Request $request, Site $site): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:200'],
            'payment' => ['required', Rule::in(['cod', 'card'])],
            'items' => ['required', 'array', 'min:1', 'max:30'],
            'items.*.id' => ['required', 'integer'],
            'items.*.qty' => ['required', 'integer', 'min:1', 'max:20'],
        ], ['required' => 'هذا الحقل مطلوب.']);

        $order = DB::transaction(function () use ($site, $data) {
            $lines = [];
            foreach ($data['items'] as $row) {
                $p = $site->products()->lockForUpdate()->find($row['id']);
                abort_unless($p, 422, 'منتج غير موجود.');
                abort_if($p->stock < $row['qty'], 422, "الكمية المطلوبة من «{$p->name}» غير متوفرة.");
                $p->decrement('stock', $row['qty']);
                $lines[] = ['id' => $p->id, 'name' => $p->name, 'emoji' => $p->emoji, 'qty' => (int) $row['qty'], 'price' => $p->price];
            }

            return $site->createOrder(collect(), ['name' => $data['name'], 'phone' => $data['phone'], 'address' => $data['address'], 'payment' => $data['payment']], $data['payment'] === 'card' ? 'paid' : 'new', null, $lines);
        });

        return response()->json(['number' => '#'.$order->number]);
    }
}
