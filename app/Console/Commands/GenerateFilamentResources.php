<?php

declare(strict_types=1);

namespace Modules\DbForge\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\Facades\Module;

class GenerateFilamentResources extends Command
{
    protected $signature = 'filament:generate-resources {module : Il nome del modulo per cui generare le risorse}';

    protected $description = 'Generate Filament resources for all models';

    public function handle(): int
    {
        $moduleName = // @var mixed argument('module';

        // Assicuriamoci che $moduleName sia una stringa
        if (! is_string($moduleName)) {
            // @var mixed error('Il nome del modulo deve essere una stringa.';

            return Command::FAILURE;
        }

        $module = Module::find($moduleName);

        if (! $module) {
            // @var mixed error("Il modulo '{$moduleName}' non esiste.";

            return Command::FAILURE;
        }

        // @var mixed info("Generazione delle Filament Resources per il modulo: {$moduleName}";

        $modelsPath = $module->getPath().'/app/Models';
        if (! File::isDirectory($modelsPath)) {
            // @var mixed error("Nessuna cartella 'Models' trovata nel modulo {$moduleName}.";

            return Command::FAILURE;
        }

        $models = File::files($modelsPath);
        foreach ($models as $model) {
            $modelName = $model->getFilenameWithoutExtension();

            // Assicuriamoci che $moduleName sia una stringa per strtolower
            $panelName = strtolower($moduleName);
            $panel = $panelName.'::admin';
            $params = [
                'name' => $modelName,
                '--panel' => $panel,
                '--model-namespace' => "Modules\\{$moduleName}\\Models",
                '--generate' => true,
                '--factory' => true,
                '--force' => true,
            ];
            try {
                Artisan::call('make:filament-resource', $params);
            } catch (Exception $e) {
                // @var mixed error($e->getMessage(;
            }
            // @var mixed info("Resource generata per il modello: {$modelName}";
        }

        // @var mixed info('Tutte le resources sono state generate con successo!';

        return Command::SUCCESS;
    }
}
