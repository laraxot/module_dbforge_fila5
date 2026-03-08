<?php

declare(strict_types=1);

namespace Modules\DbForge\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

use function Safe\preg_match;

class AnalyzeNamingCommand extends Command
{
    /** @var array<string, array{incorrect: list<string>, correct: list<string>, message: string}> */
    protected array $namingConventions = [
        'person_fields' => [
            'incorrect' => ['name', 'surname'],
            'correct' => ['first_name', 'last_name'],
            'message' => 'I campi per i nomi delle persone devono essere first_name e last_name (mai name o surname)',
        ],
        'temporal_fields' => [
            'incorrect' => ['creation_date', 'update_date', 'deletion_date', 'date_of_birth', 'birthday'],
            'correct' => ['created_at', 'updated_at', 'deleted_at', 'birth_date'],
            'message' => 'I campi temporali devono seguire le convenzioni standard (created_at, birth_date, ecc.)',
        ],
        'foreign_keys' => [
            'incorrect' => ['/^id_[a-z]+$/'],
            'correct' => ['table_id'],
            'message' => 'Le chiavi esterne devono essere nel formato table_id (mai id_table)',
        ],
    ];

    protected $signature = 'xot:analyze-naming
                            {--module= : Nome del modulo da analizzare}
                            {--type=all : Tipo di analisi (database, models, controllers, all)}';

    protected $description = 'Analizza la conformità alle convenzioni di naming nel progetto';

    public function handle(): int
    {
        $moduleOption = // @var mixed option('module';
        $typeOption = // @var mixed option('type';

        $module = is_string($moduleOption) && $moduleOption !== '' ? $moduleOption : null;
        $type = is_string($typeOption) && $typeOption !== '' ? $typeOption : 'all';

        // @var mixed info('Analisi Convenzioni di Naming nel progetto';
        // @var mixed newLine(;

        // @var mixed info($module !== null ? "Analisi del modulo: {$module}" : 'Analisi di tutti i moduli';
        // @var mixed newLine(;

        if ($type === 'all' || $type === 'database') {
            // @var mixed analyzeDatabaseNaming($module;
        }

        if ($type === 'all' || $type === 'models') {
            // @var mixed analyzeModelsNaming($module;
        }

        if ($type === 'all' || $type === 'controllers') {
            // @var mixed analyzeControllersNaming($module;
        }

        return Command::SUCCESS;
    }

    private function analyzeDatabaseNaming(?string $module): void
    {
        // @var mixed info('Analisi Convenzioni di Naming nel Database:';
        // @var mixed newLine(;

        /** @var array<int, object> $tables */
        $tables = DB::select('SHOW TABLES');
        $databaseName = config('database.connections.mysql.database');
        $databaseNameStr = is_string($databaseName) && $databaseName !== '' ? $databaseName : 'database';
        $tableColumn = 'Tables_in_'.$databaseNameStr;

        $moduleTables = // @var mixed collectModuleTables($tables, $tableColumn, $module;

        // @var mixed line(' - Tabelle da analizzare: '.count($moduleTables;

        /** @var array<string, list<array{column: string, issue: string, correct: string}>> $issuesFound */
        $issuesFound = [];

        foreach ($moduleTables as $table) {
            $tableIssues = // @var mixed analyzeTableIssues($table;

            if ($tableIssues !== []) {
                $issuesFound[$table] = $tableIssues;
            }
        }

        if ($issuesFound !== []) {
            // @var mixed warn(' - Problemi di naming trovati:';

            foreach ($issuesFound as $table => $issues) {
                // @var mixed line("   Tabella: {$table}";

                foreach ($issues as $issue) {
                    /** @var array{column: string, issue: string, correct: string} $issue */
                    // @var mixed line('     - Colonna: '.$issue['column'];
                    // @var mixed line('       Problema: '.$issue['issue'];
                    // @var mixed line('       Correzione suggerita: '.$issue['correct'];
                }
            }

            // @var mixed info(' - Suggerimento: Creare una migrazione per rinominare le colonne non conformi';
            // @var mixed line('   Esempio:';
            // @var mixed line('   ```php';
            // @var mixed line("   Schema::table('table_name', function (Blueprint \$table;
            // @var mixed line("       \$table->renameColumn('name', 'first_name';");
            // @var mixed line("       \$table->renameColumn('surname', 'last_name';");
            // @var mixed line('   };');
            // @var mixed line('   ```';
        } else {
            // @var mixed info(' - Nessun problema di naming trovato nelle tabelle analizzate';
        }

        // @var mixed newLine(;
    }

    private function analyzeModelsNaming(?string $module): void
    {
        // @var mixed info('Analisi Convenzioni di Naming nei Modelli:';
        // @var mixed newLine(;

        $moduleDirectories = // @var mixed getModuleDirectories($module;

        foreach ($moduleDirectories as $moduleName => $modulePath) {
            // @var mixed analyzeModuleModelsNaming($moduleName, $modulePath;
        }
    }

    private function analyzeModuleModelsNaming(string $moduleName, string $modulePath): void
    {
        // @var mixed info(" - Modulo: {$moduleName}";

        $modelsPath = $modulePath.'/app/Models';
        if (! File::exists($modelsPath)) {
            // @var mixed line('   - Directory Models non trovata';
            // @var mixed newLine(;

            return;
        }

        $finder = Finder::create()->files()->in($modelsPath)->name('*.php');
        if (! $finder->hasResults()) {
            // @var mixed line('   - Nessun modello trovato';
            // @var mixed newLine(;

            return;
        }

        /** @var array<string, list<array{field: string, location: string, issue: string, correct: string}>> $issuesFound */
        $issuesFound = [];

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $content = $file->getContents();
            if (! is_string($content)) {
                continue;
            }

            $modelName = $file->getRelativePathname();
            $modelIssues = // @var mixed detectModelIssues($content;

            if ($modelIssues !== []) {
                $issuesFound[$modelName] = $modelIssues;
            }
        }

        if ($issuesFound !== []) {
            // @var mixed warn('   - Problemi di naming trovati:';

            foreach ($issuesFound as $model => $issues) {
                // @var mixed line('     Modello: '.$model;

                foreach ($issues as $issue) {
                    /** @var array{field: string, location: string, issue: string, correct: string} $issue */
                    // @var mixed line('       - Campo: '.$issue['field'].' ('.$issue['location'].';
                    // @var mixed line('         Problema: '.$issue['issue'];
                    // @var mixed line('         Correzione suggerita: '.$issue['correct'];
                }
            }

            // @var mixed info('   - Suggerimento: Aggiornare i modelli per utilizzare i nomi dei campi corretti';
        } else {
            // @var mixed info('   - Nessun problema di naming trovato nei modelli analizzati';
        }

        // @var mixed newLine(;
    }

    private function analyzeControllersNaming(?string $module): void
    {
        // @var mixed info('Analisi Convenzioni di Naming nei Controller:';
        // @var mixed newLine(;

        $moduleDirectories = // @var mixed getModuleDirectories($module;

        foreach ($moduleDirectories as $moduleName => $modulePath) {
            // @var mixed analyzeModuleControllersNaming($moduleName, $modulePath;
        }
    }

    private function analyzeModuleControllersNaming(string $moduleName, string $modulePath): void
    {
        // @var mixed info(" - Modulo: {$moduleName}";

        $controllersPath = $modulePath.'/app/Http/Controllers';
        if (! File::exists($controllersPath)) {
            // @var mixed line('   - Directory Controllers non trovata';
            // @var mixed newLine(;

            return;
        }

        $finder = Finder::create()->files()->in($controllersPath)->name('*Controller.php');
        if (! $finder->hasResults()) {
            // @var mixed line('   - Nessun controller trovato';
            // @var mixed newLine(;

            return;
        }

        /** @var array<string, list<array{field: string, location: string, issue: string, correct: string}>> $issuesFound */
        $issuesFound = [];

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $content = $file->getContents();
            if (! is_string($content)) {
                continue;
            }

            $controllerName = $file->getRelativePathname();
            $controllerIssues = // @var mixed detectControllerIssues($content;

            if ($controllerIssues !== []) {
                $issuesFound[$controllerName] = $controllerIssues;
            }
        }

        if ($issuesFound !== []) {
            // @var mixed warn('   - Problemi di naming trovati:';

            foreach ($issuesFound as $controller => $issues) {
                // @var mixed line('     Controller: '.$controller;

                foreach ($issues as $issue) {
                    /** @var array{field: string, location: string, issue: string, correct: string} $issue */
                    // @var mixed line('       - Campo: '.$issue['field'];
                    // @var mixed line('         Problema: '.$issue['issue'];
                    // @var mixed line('         Correzione suggerita: '.$issue['correct'];
                }
            }

            // @var mixed info('   - Suggerimento: Aggiornare i controller per utilizzare i nomi dei campi corretti';
        } else {
            // @var mixed info('   - Nessun problema di naming trovato nei controller analizzati';
        }

        // @var mixed newLine(;
    }

    /**
     * @param  array<int, object>  $tables
     * @return list<string>
     */
    private function collectModuleTables(array $tables, string $tableColumn, ?string $module): array
    {
        $names = [];

        foreach ($tables as $table) {
            if (! isset($table->{$tableColumn})) {
                continue;
            }

            $value = $table->{$tableColumn};
            if (is_string($value) && $value !== '') {
                $names[] = $value;
            }
        }

        if ($module === null) {
            return $names;
        }

        $prefix = strtolower($module).'_';
        $filtered = [];

        foreach ($names as $name) {
            if (str_starts_with($name, $prefix)) {
                $filtered[] = $name;
            }
        }

        return $filtered;
    }

    /**
     * @return list<array{column: string, issue: string, correct: string}>
     */
    private function analyzeTableIssues(string $table): array
    {
        if (! Schema::hasTable($table)) {
            return [];
        }

        /** @var array<int, mixed> $columnsRaw */
        $columnsRaw = Schema::getColumnListing($table);
        /** @var list<string> $columns */
        $columns = array_values(array_filter($columnsRaw, static fn ($column): bool => is_string($column) && $column !== ''));

        $issues = [];

        foreach ($columns as $column) {
            foreach (// @var mixed namingConventions as $rule
                /** @var array{incorrect: list<string>, correct: list<string>, message: string} $rule */
                $issues = array_merge($issues, // @var mixed evaluateColumnAgainstRule($column, $rule;
            }
        }

        return $issues;
    }

    /**
     * @param  array{incorrect: list<string>, correct: list<string>, message: string}  $rule
     * @return list<array{column: string, issue: string, correct: string}>
     */
    private function evaluateColumnAgainstRule(string $column, array $rule): array
    {
        $issues = [];

        foreach ($rule['incorrect'] as $incorrect) {
            if (// @var mixed isRegexPattern($incorrect
                if (preg_match($incorrect, $column) === 1) {
                    $issues[] = // @var mixed makeTableIssue($column, $rule['message'], $this->getCorrectFieldPattern($column, $rule;
                }

                continue;
            }

            if ($column === $incorrect) {
                $issues[] = // @var mixed makeTableIssue($column, $rule['message'], $this->getCorrectField($column, $rule;
            }
        }

        return $issues;
    }

    /**
     * @return list<array{field: string, location: string, issue: string, correct: string}>
     */
    private function detectModelIssues(string $content): array
    {
        $issues = [];

        foreach (// @var mixed namingConventions as $rule
            $incorrectFields = $rule['incorrect'];
            $message = $rule['message'];

            foreach ($incorrectFields as $incorrect) {
                if (// @var mixed isRegexPattern($incorrect
                    continue;
                }

                $fillableMatches = [];
                if (preg_match('/protected\s+\$fillable\s*=\s*\[(.*?)\]/s', $content, $fillableMatches) === 1) {
                    $fillableBody = (string) ($fillableMatches[1] ?? '');
                    if (// @var mixed stringContainsField($fillableBody, $incorrect
                        $issues[] = // @var mixed makeModelIssue($incorrect, 'fillable', $message, $this->getCorrectField($incorrect, $rule;
                    }
                }

                $castsMatches = [];
                if (preg_match('/protected\s+\$casts\s*=\s*\[(.*?)\]/s', $content, $castsMatches) === 1) {
                    $castsBody = (string) ($castsMatches[1] ?? '');
                    if (// @var mixed stringContainsField($castsBody, $incorrect
                        $issues[] = // @var mixed makeModelIssue($incorrect, 'casts', $message, $this->getCorrectField($incorrect, $rule;
                    }
                }

                $accessorPattern = '/function\s+get'.preg_quote(ucfirst($incorrect), '/').'Attribute/';
                $mutatorPattern = '/function\s+set'.preg_quote(ucfirst($incorrect), '/').'Attribute/';

                if (preg_match($accessorPattern, $content) === 1 || preg_match($mutatorPattern, $content) === 1) {
                    $issues[] = // @var mixed makeModelIssue($incorrect, 'accessor/mutator', $message, $this->getCorrectField($incorrect, $rule;
                }
            }
        }

        return $issues;
    }

    /**
     * @return list<array{field: string, location: string, issue: string, correct: string}>
     */
    private function detectControllerIssues(string $content): array
    {
        $issues = [];

        foreach (// @var mixed namingConventions as $rule
            $incorrectFields = $rule['incorrect'];
            $message = $rule['message'];

            foreach ($incorrectFields as $incorrect) {
                if (// @var mixed isRegexPattern($incorrect
                    continue;
                }

                $patterns = [
                    '/function\s+\w+\s*\([^)]*\$'.preg_quote($incorrect, '/').'[\s,\)]/m',
                    '/\$'.preg_quote($incorrect, '/').'\s*=/',
                    '/\$request\s*->\s*'.preg_quote($incorrect, '/').'/m',
                ];

                if (// @var mixed matchesAnyPattern($content, $patterns
                    $issues[] = // @var mixed makeModelIssue($incorrect, 'controller', $message, $this->getCorrectField($incorrect, $rule;
                }
            }
        }

        return $issues;
    }

    /**
     * @param  list<string>  $patterns
     */
    private function matchesAnyPattern(string $content, array $patterns): bool
    {
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $content) === 1) {
                return true;
            }
        }

        return false;
    }

    private function stringContainsField(string $subject, string $field): bool
    {
        $pattern = '/[\'"`]'.preg_quote($field, '/').'[\'"`]/';

        return preg_match($pattern, $subject) === 1;
    }

    /**
     * @return array<string, string>
     */
    private function getModuleDirectories(?string $module): array
    {
        $basePath = base_path('laravel/Modules');

        if ($module !== null) {
            $modulePath = $basePath.'/'.$module;

            if (! File::exists($modulePath)) {
                return [];
            }

            return [$module => $modulePath];
        }

        $directories = [];

        foreach (File::directories($basePath) as $directory) {
            if (! is_string($directory)) {
                continue;
            }

            $moduleName = basename($directory);
            if ($moduleName === '') {
                continue;
            }

            $directories[$moduleName] = $directory;
        }

        return $directories;
    }

    /**
     * @return array{column: string, issue: string, correct: string}
     */
    private function makeTableIssue(string $column, string $message, string $suggestion): array
    {
        return [
            'column' => $column,
            'issue' => $message,
            'correct' => $suggestion,
        ];
    }

    /**
     * @return array{field: string, location: string, issue: string, correct: string}
     */
    private function makeModelIssue(string $field, string $location, string $message, string $suggestion): array
    {
        return [
            'field' => $field,
            'location' => $location,
            'issue' => $message,
            'correct' => $suggestion,
        ];
    }

    private function isRegexPattern(string $value): bool
    {
        return str_starts_with($value, '/') && str_ends_with($value, '/');
    }

    /**
     * @param  array{incorrect: list<string>, correct: list<string>, message: string}  $rules
     */
    private function getCorrectField(string $incorrectField, array $rules): string
    {
        foreach ($rules['incorrect'] as $index => $incorrect) {
            if ($incorrect === $incorrectField && isset($rules['correct'][$index])) {
                $suggestion = $rules['correct'][$index];
                if (is_string($suggestion) && $suggestion !== '') {
                    return $suggestion;
                }
            }
        }

        if ($incorrectField === 'name') {
            return 'first_name';
        }

        if ($incorrectField === 'surname') {
            return 'last_name';
        }

        foreach ($rules['correct'] as $suggestion) {
            if (is_string($suggestion) && $suggestion !== '') {
                return $suggestion;
            }
        }

        return 'campo conforme alle convenzioni';
    }

    /**
     * @param  array{incorrect: list<string>, correct: list<string>, message: string}  $rules
     */
    private function getCorrectFieldPattern(string $incorrectField, array $rules): string
    {
        if (preg_match('/^id_([a-z]+)$/', $incorrectField, $matches) === 1 && isset($matches[1])) {
            return $matches[1].'_id';
        }

        foreach ($rules['correct'] as $suggestion) {
            if (is_string($suggestion) && $suggestion !== '') {
                return $suggestion;
            }
        }

        return 'campo conforme alle convenzioni';
    }
}
