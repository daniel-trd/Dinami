<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class LimparCache extends Command
{
    protected $signature = 'Dinami:ClearCache';

    protected $description = 'Limpa o cache da aplicação';

    public function handle()
    {
        Artisan::call('optimize:clear');

        $this->info('[INFO] - Todos os caches foram limpos com sucesso!');

        return self::SUCCESS;
    }
}
