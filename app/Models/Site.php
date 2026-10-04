<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

#[Fillable(['name', 'subdomain', 'template', 'currency', 'color', 'headline', 'hidden', 'gateways', 'shipping', 'plugins', 'visits'])]
class Site extends Model
{
    public const CUSTOMERS = ['أحمد محمود', 'سارة علي', 'محمد خالد', 'منى حسن', 'يوسف إبراهيم', 'نور الدين', 'ليلى سمير', 'عمر فاروق', 'هدى عادل', 'كريم عصام', 'دينا طارق', 'مصطفى رضا', 'ياسمين وليد', 'خالد منصور', 'رنا أشرف', 'طارق سعيد', 'آية جمال', 'إسلام حسن', 'مريم يحيى', 'بسمة نبيل'];

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

    public static function provision(User $user, array $data, bool $rich = false): self
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
            'visits' => $rich ? random_int(2400, 4200) : 0,
        ]);

        foreach ($tpl['products'] as $i => [$name, $price, $cat, $emoji]) {
            $site->products()->create(['name' => $name, 'price' => $price, 'category' => $cat, 'emoji' => $emoji, 'stock' => 25 + ($i * 17) % 90]);
        }

        $site->seedOrders($rich ? 64 : 5, $rich ? 30 : 3);

        return $site;
    }

    public function seedOrders(int $count, int $spanDays): void
    {
        $products = $this->products()->get();
        for ($i = 0; $i < $count; $i++) {
            $age = $count <= 5 ? [2, 1, 1, 0, 0][$i] : (int) floor(($spanDays) * (random_int(0, 100) / 100) ** 1.4);
            $at = now()->subDays($age)->subMinutes(random_int(0, 600));
            $status = $age >= 4 ? 'delivered' : ['delivered', 'shipped', 'paid', 'new'][min(3, random_int(0, 3))];
            $this->createOrder($products, null, $status, $at);
        }
    }

    public function createOrder($products, ?array $customer = null, string $status = 'new', ?Carbon $at = null, ?array $lines = null): Order
    {
        if ($lines === null) {
            $lines = [];
            foreach ($products->shuffle()->take(random_int(1, 3)) as $p) {
                $lines[] = ['id' => $p->id, 'name' => $p->name, 'emoji' => $p->emoji, 'qty' => random_int(1, 2), 'price' => $p->price];
            }
        }
        $total = collect($lines)->sum(fn ($l) => $l['qty'] * $l['price']);

        $order = $this->orders()->make([
            'number' => ($this->orders()->max('number') ?: 1000) + 1,
            'customer' => $customer['name'] ?? self::CUSTOMERS[array_rand(self::CUSTOMERS)],
            'total' => $total, 'status' => $status, 'items' => $lines,
            'phone' => $customer['phone'] ?? '01'.random_int(0, 2).random_int(10000000, 99999999),
            'address' => $customer['address'] ?? ['القاهرة', 'الإسكندرية', 'الجيزة', 'المنصورة', 'طنطا'][random_int(0, 4)],
            'payment' => $customer['payment'] ?? (random_int(0, 2) ? 'cod' : 'card'),
        ]);
        $order->created_at = $at ?? now();
        $order->save();

        return $order;
    }

    public function toState(): array
    {
        return [
            'name' => $this->name, 'sub' => $this->subdomain, 'template' => $this->template, 'currency' => $this->currency,
            'color' => $this->color, 'headline' => $this->headline, 'hidden' => $this->hidden, 'gateways' => $this->gateways,
            'shipping' => $this->shipping, 'plugins' => $this->plugins, 'visits' => $this->visits,
            'products' => $this->products->map(fn ($p) => ['id' => $p->id, 'name' => $p->name, 'cat' => $p->category, 'price' => $p->price, 'stock' => $p->stock, 'emoji' => $p->emoji])->all(),
            'orders' => $this->orders()->limit(60)->get()->map(fn ($o) => $o->toRow())->all(),
        ];
    }
}
