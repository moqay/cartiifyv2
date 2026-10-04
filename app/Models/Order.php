<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['number', 'customer', 'total', 'status'])]
class Order extends Model
{
    public const FLOW = ['new' => 'paid', 'paid' => 'shipped', 'shipped' => 'delivered', 'delivered' => 'new'];

    protected function casts(): array
    {
        return ['total' => 'float'];
    }

    public function dateLabel(): string
    {
        $days = (int) $this->created_at->startOfDay()->diffInDays(now()->startOfDay(), true);

        return match (true) {
            $days === 0 => 'اليوم',
            $days === 1 => 'أمس',
            default => "قبل {$days} أيام",
        };
    }
}
