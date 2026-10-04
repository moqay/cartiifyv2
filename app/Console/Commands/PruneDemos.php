<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('demo:prune')]
#[Description('Delete demo accounts older than 24 hours')]
class PruneDemos extends Command
{
    public function handle(): void
    {
        $n = User::where('is_demo', true)->where('created_at', '<', now()->subDay())->delete();
        $this->info("Pruned {$n} demo accounts.");
    }
}
