<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
