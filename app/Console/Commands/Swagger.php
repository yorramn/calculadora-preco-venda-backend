<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Swagger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swagger';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando gera a documentação swagger';

    /**
     * @return int
     */
    public function handle(): int
    {
        $openApi = \OpenApi\Generator::scan([config('swagger.sources')]);
        $pathToPut = base_path().'\public\api-documentation\swagger.json';
        file_put_contents($pathToPut, $openApi->toJson());
        $this->info('Documentação da API gerada com sucesso!');
        return Command::SUCCESS;
    }
}
