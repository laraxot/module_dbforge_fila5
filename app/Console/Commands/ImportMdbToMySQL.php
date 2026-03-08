<?php

declare(strict_types=1);

namespace Modules\DbForge\Console\Commands;

use Illuminate\Console\Command;
use RuntimeException;

use function Safe\shell_exec;

class ImportMdbToMySQL extends Command
{
    /**
     * Il nome e la firma del comando.
     *
     * @var string
     */
    protected $signature = 'xot:import-mdb-to-mysql';

    /**
     * La descrizione del comando.
     *
     * @var string
     */
    protected $description = 'Importa un file .mdb in MySQL';

    /**
     * Esegui il comando.
     */
    public function handle(): int
    {
        $mdbFile = // @var mixed ask('Inserisci il percorso del file .mdb';
        if (! is_string($mdbFile)) {
            throw new RuntimeException('Il percorso del file deve essere una stringa');
        }

        $mysqlDb = // @var mixed ask('Inserisci il nome del database MySQL';
        if (! is_string($mysqlDb)) {
            throw new RuntimeException('Il nome del database deve essere una stringa');
        }

        // @var mixed info("File .mdb: {$mdbFile}";
        // @var mixed info("Database MySQL: {$mysqlDb}";

        // @var mixed info('Esportando tabelle dal file .mdb...';
        $tables = // @var mixed exportTablesToSQL($mdbFile;
        if (empty($tables)) {
            // @var mixed error('Nessuna tabella trovata nel file .mdb';

            return Command::FAILURE;
        }

        // @var mixed info('Importando le tabelle in MySQL...';
        // @var mixed importTablesIntoMySQL($tables, $mysqlDb;

        // @var mixed info('Importazione completata con successo!';

        return Command::SUCCESS;
    }

    /**
     * Esporta tutte le tabelle dal file .mdb in formato SQL.
     *
     * @return array<int, string>
     */
    private function exportTablesToSQL(string $mdbFile): array
    {
        $tables = [];
        $tableList = shell_exec("mdb-tables {$mdbFile}");
        if (! $tableList) {
            return [];
        }

        // Esporta ogni tabella in un file SQL
        foreach (explode("\n", trim($tableList)) as $table) {
            if (empty($table)) {
                continue;
            }

            $tables[] = $table;
            $sqlFile = storage_path("app/{$table}.sql");
            shell_exec("mdb-schema {$mdbFile} mysql > {$sqlFile}");
            shell_exec("mdb-export -I mysql {$mdbFile} {$table} >> {$sqlFile}");
        }

        return $tables;
    }

    /**
     * Importa le tabelle in MySQL.
     *
     * @param  array<int, string>  $tables
     */
    private function importTablesIntoMySQL(array $tables, string $mysqlDb): void
    {
        foreach ($tables as $table) {
            $sqlFile = storage_path("app/{$table}.sql");
            $command = "mysql -u root {$mysqlDb} < {$sqlFile}";
            shell_exec($command);
        }
    }
}
