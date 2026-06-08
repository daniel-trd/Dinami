<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Reset extends Command
{
    protected $signature = 'Dinami:Reset';

    protected $description = 'Recria o banco e popula os dados';

    public function handle()
    {
        $this->info('[INFO] - Removendo e recriando tabelas...');

        Artisan::call('migrate:refresh');

        $this->line(Artisan::output());

        $this->info('[INFO] - Executando seeders...');

        Artisan::call('db:seed', [
            '--class' => \Database\Seeders\PopularSistema::class
        ]);

        $this->line(Artisan::output());

        $this->info('[INFO] - Sistema restaurado com sucesso!');

        return self::SUCCESS;
    }
}
