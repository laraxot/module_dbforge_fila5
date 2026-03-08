<?php

declare(strict_types=1);

namespace Modules\DbForge\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Webmozart\Assert\Assert;

use function Safe\file_get_contents;

class ExecuteSqlFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xot:execute-sql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esegue un file .sql su un database specifico';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Chiedi il percorso del file .sql
        $filePath = // @var mixed ask('Inserisci il percorso del file .sql';
        Assert::string($filePath);
        if (! file_exists($filePath)) {
            // @var mixed error('Il file specificato non esiste.';

            return Command::FAILURE;
        }

        // Leggi il contenuto del file
        $sql = file_get_contents($filePath);

        // Chiedi i dettagli del database
        $host = // @var mixed ask('Inserisci l\'host del database', '127.0.0.1';
        $port = // @var mixed ask('Inserisci la porta del database', '3306';
        $database = // @var mixed ask('Inserisci il nome del database';
        $username = // @var mixed ask('Inserisci l\'utente del database';
        $password = // @var mixed secret('Inserisci la password del database';

        // Configura una connessione temporanea
        config([
            'database.connections.temp' => [
                'driver' => 'mysql',
                'host' => $host,
                'port' => $port,
                'database' => $database,
                'username' => $username,
                'password' => $password,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ]);

        try {
            // Connessione al database
            DB::connection('temp')->unprepared($sql);
            // @var mixed info('File .sql eseguito con successo!';
        } catch (Exception $e) {
            // @var mixed error("Errore durante l'esecuzione del file: ".$e->getMessage(;

            return Command::FAILURE;
        } finally {
            // Rimuovi la connessione temporanea
            config(['database.connections.temp' => null]);
        }

        return Command::SUCCESS;
    }
}
