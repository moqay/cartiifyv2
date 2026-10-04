<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'subdomain', 'template', 'currency', 'color', 'headline', 'hidden', 'gateways', 'shipping', 'plugins'])]
class Site extends Model
{
    protected function casts(): array
    {
        return ['hidden' => 'array', 'gateways' => 'array', 'shipping' => 'array', 'plugins' => 'array'];
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->latest('id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)->latest('id');
    }

    public static function provision(User $user, array $data): self
    {
        $tpl = config("cartiify.templates.{$data['template']}");

        $site = $user->site()->create([
            'name' => $data['sname'],
            'subdomain' => $data['sub'],
            'template' => $data['template'],
            'currency' => $data['currency'],
            'color' => $tpl['color'],
            'headline' => $tpl['headline'],
            'hidden' => [],
            'gateways' => array_map(fn ($i) => $i < 2, array_keys(config('cartiify.gateways'))),
            'shipping' => [true, false, false],
            'plugins' => array_fill(0, count(config('cartiify.plugins')), false),
        ]);

        foreach ($tpl['products'] as $i => [$name, $price, $cat, $emoji]) {
            $site->products()->create(['name' => $name, 'price' => $price, 'category' => $cat, 'emoji' => $emoji, 'stock' => 10 + ($i * 17) % 90]);
        }

        $customers = ['أحمد محمود', 'سارة علي', 'محمد خالد', 'منى حسن', 'يوسف إبراهيم'];
        $status = ['delivered', 'delivered', 'shipped', 'paid', 'new'];
        $age = [2, 1, 1, 0, 0];
        foreach ($customers as $i => $customer) {
            $order = $site->orders()->make(['number' => 1001 + $i, 'customer' => $customer, 'total' => $tpl['products'][$i][1] + 45, 'status' => $status[$i]]);
            $order->created_at = now()->subDays($age[$i]);
            $order->save();
        }

        return $site;
    }

    public function toState(): array
    {
        return [
            'name' => $this->name, 'sub' => $this->subdomain, 'template' => $this->template, 'currency' => $this->currency,
            'color' => $this->color, 'headline' => $this->headline, 'hidden' => $this->hidden, 'gateways' => $this->gateways,
            'shipping' => $this->shipping, 'plugins' => $this->plugins,
            'products' => $this->products->map(fn ($p) => ['id' => $p->id, 'name' => $p->name, 'cat' => $p->category, 'price' => $p->price, 'stock' => $p->stock, 'emoji' => $p->emoji])->all(),
            'orders' => $this->orders->map(fn ($o) => ['id' => $o->id, 'number' => '#'.$o->number, 'customer' => $o->customer, 'total' => $o->total, 'status' => $o->status, 'date' => $o->dateLabel()])->all(),
        ];
    }
}
