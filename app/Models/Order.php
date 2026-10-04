<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['number', 'customer', 'total', 'status', 'items', 'phone', 'address', 'payment'])]
class Order extends Model
{
    public const FLOW = ['new' => 'paid', 'paid' => 'shipped', 'shipped' => 'delivered', 'delivered' => 'new'];

    protected function casts(): array
    {
        return ['total' => 'float', 'items' => 'array'];
    }

    public function dateLabel(): string
    {
        $days = (int) $this->created_at->copy()->startOfDay()->diffInDays(now()->startOfDay(), true);

        return match (true) {
            $days === 0 => 'اليوم',
            $days === 1 => 'أمس',
            default => "قبل {$days} أيام",
        };
    }

    public function toRow(): array
    {
        return [
            'id' => $this->id, 'number' => '#'.$this->number, 'customer' => $this->customer, 'total' => $this->total, 'status' => $this->status,
            'date' => $this->dateLabel(), 'time' => $this->created_at->format('H:i'), 'items' => $this->items ?? [],
            'phone' => $this->phone, 'address' => $this->address, 'payment' => $this->payment,
        ];
    }
}
