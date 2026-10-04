<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class SiteApiController extends Controller
{
    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:60'],
            'currency' => ['sometimes', Rule::in(array_keys(config('cartiify.currencies')))],
            'color' => ['sometimes', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'headline' => ['sometimes', 'string', 'max:120'],
            'hidden' => ['sometimes', 'array'],
            'hidden.*' => ['integer', 'between:0,4'],
        ]);
        $request->user()->site->update($data);

        return response()->json(['ok' => true]);
    }

    public function toggle(Request $request): JsonResponse
    {
        $data = $request->validate([
            'key' => ['required', Rule::in(['gateways', 'shipping', 'plugins'])],
            'index' => ['required', 'integer', 'min:0'],
            'value' => ['required', 'boolean'],
        ]);
        $site = $request->user()->site;
        $list = $site->{$data['key']};
        abort_unless(array_key_exists($data['index'], $list), 422);
        $list[$data['index']] = (bool) $data['value'];
        $site->update([$data['key'] => $list]);

        return response()->json(['ok' => true]);
    }

    public function storeProduct(Request $request): JsonResponse
    {
        $product = $request->user()->site->products()->create($this->productData($request) + ['emoji' => '📦']);

        return response()->json(['id' => $product->id]);
    }

    public function updateProduct(Request $request, int $id): JsonResponse
    {
        $request->user()->site->products()->findOrFail($id)->update($this->productData($request));

        return response()->json(['ok' => true]);
    }

    public function destroyProduct(Request $request, int $id): JsonResponse
    {
        $request->user()->site->products()->findOrFail($id)->delete();

        return response()->json(['ok' => true]);
    }

    public function advanceOrder(Request $request, int $id): JsonResponse
    {
        $order = $request->user()->site->orders()->findOrFail($id);
        $order->update(['status' => Order::FLOW[$order->status]]);

        return response()->json(['status' => $order->status]);
    }

    public function stats(Request $request): JsonResponse
    {
        $site = $request->user()->site;
        $days = $request->integer('days') === 30 ? 30 : 7;
        $from = now()->subDays($days - 1)->startOfDay();
        $prevFrom = $from->copy()->subDays($days);

        $orders = $site->orders()->where('created_at', '>=', $prevFrom)->get();
        $cur = $orders->filter(fn ($o) => $o->created_at >= $from);
        $prev = $orders->filter(fn ($o) => $o->created_at < $from);

        $series = [];
        for ($i = 0; $i < $days; $i++) {
            $d = $from->copy()->addDays($i);
            $day = $cur->filter(fn ($o) => $o->created_at->isSameDay($d));
            $series[] = ['label' => $d->format('m/d'), 'sales' => (float) $day->sum('total'), 'orders' => $day->count()];
        }

        $top = [];
        foreach ($cur as $o) {
            foreach ($o->items ?? [] as $l) {
                $top[$l['name']] ??= ['name' => $l['name'], 'emoji' => $l['emoji'] ?? '📦', 'qty' => 0, 'revenue' => 0];
                $top[$l['name']]['qty'] += $l['qty'];
                $top[$l['name']]['revenue'] += $l['qty'] * $l['price'];
            }
        }
        usort($top, fn ($a, $b) => $b['revenue'] <=> $a['revenue']);

        $delta = fn ($a, $b) => $b > 0 ? round(($a - $b) / $b * 100) : null;
        $sales = (float) $cur->sum('total');
        $totalOrders = $site->orders()->count();

        return response()->json([
            'sales' => $sales, 'salesDelta' => $delta($sales, (float) $prev->sum('total')),
            'orders' => $cur->count(), 'ordersDelta' => $delta($cur->count(), $prev->count()),
            'aov' => $cur->count() ? round($sales / $cur->count()) : 0,
            'visits' => $site->visits, 'conversion' => $site->visits ? round($totalOrders / $site->visits * 100, 1) : 0,
            'series' => $series, 'top' => array_slice($top, 0, 5),
        ]);
    }

    public function feed(Request $request): JsonResponse
    {
        $user = $request->user();
        $site = $user->site;
        $after = $request->integer('after');

        if ($user->is_demo && random_int(1, 100) <= 55 && ! $site->orders()->where('created_at', '>', now()->subSeconds(10))->exists()) {
            $site->createOrder($site->products()->get(), null, 'new', now());
        }

        $new = $site->orders()->where('id', '>', $after)->reorder('id')->get()->map(fn ($o) => $o->toRow())->values();

        return response()->json(['orders' => $new]);
    }

    public function changePlan(Request $request): JsonResponse
    {
        $data = $request->validate(['plan' => ['required', Rule::in(array_keys(config('cartiify.plans')))]]);
        $request->user()->update($data);

        return response()->json(['ok' => true]);
    }

    public function dismissWelcome(Request $request): JsonResponse
    {
        $request->user()->update(['welcome' => false]);

        return response()->json(['ok' => true]);
    }

    public function destroyAccount(Request $request): JsonResponse
    {
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['redirect' => '/']);
    }

    private function productData(Request $request): array
    {
        $d = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'cat' => ['nullable', 'string', 'max:60'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
        ]);

        return ['name' => $d['name'], 'category' => $d['cat'] ?: 'عام', 'price' => $d['price'], 'stock' => $d['stock'] ?? 0];
    }
}
