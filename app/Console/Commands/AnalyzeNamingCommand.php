<?php

declare(strict_types=1);

namespace Modules\DbForge\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Finder\Finder;

use function Safe\preg_match;

/**
 * @phpstan-type NamingRule array{incorrect: list<string>, correct: list<string>, message: string}
 * @phpstan-type TableIssue array{column: string, issue: string, correct: string}
 * @phpstan-type FileIssue array{field: string, location: string, issue: string, correct: string}
 * @phpstan-type FileIssueReport list<FileIssue>
 */
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
        $moduleOption = $this->option('module');
        $typeOption = $this->option('type');

        $module = is_string($moduleOption) && $moduleOption !== '' ? $moduleOption : null;
        $type = is_string($typeOption) && $typeOption !== '' ? $typeOption : 'all';

        $this->info('Analisi Convenzioni di Naming nel progetto');
        $this->newLine();

        $this->info($module !== null ? "Analisi del modulo: {$module}" : 'Analisi di tutti i moduli');
        $this->newLine();

        if ($type === 'all' || $type === 'database') {
            $this->analyzeDatabaseNaming($module);
        }

        if ($type === 'all' || $type === 'models') {
            $this->analyzeModelsNaming($module);
        }

        if ($type === 'all' || $type === 'controllers') {
            $this->analyzeControllersNaming($module);
        }

        return Command::SUCCESS;
    }

    private function analyzeDatabaseNaming(?string $module): void
    {
        $this->info('Analisi Convenzioni di Naming nel Database:');
        $this->newLine();

        /** @var array<int, object> $tables */
        $tables = DB::select('SHOW TABLES');
        $databaseName = config('database.connections.mysql.database');
        $databaseNameStr = is_string($databaseName) && $databaseName !== '' ? $databaseName : 'database';
        $tableColumn = 'Tables_in_'.$databaseNameStr;

        $moduleTables = $this->collectModuleTables($tables, $tableColumn, $module);

        $this->line(' - Tabelle da analizzare: '.count($moduleTables));

        /** @var array<string, list<array{column: string, issue: string, correct: string}>> $issuesFound */
        $issuesFound = [];

        foreach ($moduleTables as $table) {
            $tableIssues = $this->analyzeTableIssues($table);

            if ($tableIssues !== []) {
                $issuesFound[$table] = $tableIssues;
            }
        }

        if ($issuesFound !== []) {
            $this->warn(' - Problemi di naming trovati:');

            foreach ($issuesFound as $table => $issues) {
                $this->line("   Tabella: {$table}");

                foreach ($issues as $issue) {
                    /** @var array{column: string, issue: string, correct: string} $issue */
                    $this->line('     - Colonna: '.$issue['column']);
                    $this->line('       Problema: '.$issue['issue']);
                    $this->line('       Correzione suggerita: '.$issue['correct']);
                }
            }

            $this->info(' - Suggerimento: Creare una migrazione per rinominare le colonne non conformi');
            $this->line('   Esempio:');
            $this->line('   ```php');
            $this->line("   Schema::table('table_name', function (Blueprint \$table) {");
            $this->line("       \$table->renameColumn('name', 'first_name');");
            $this->line("       \$table->renameColumn('surname', 'last_name');");
            $this->line('   });');
            $this->line('   ```');
        } else {
            $this->info(' - Nessun problema di naming trovato nelle tabelle analizzate');
        }

        $this->newLine();
    }

    private function analyzeModelsNaming(?string $module): void
    {
        $this->info('Analisi Convenzioni di Naming nei Modelli:');
        $this->newLine();

        $moduleDirectories = $this->getModuleDirectories($module);

        foreach ($moduleDirectories as $moduleName => $modulePath) {
            $this->analyzeModuleModelsNaming($moduleName, $modulePath);
        }
    }

    /**
     * @param  \Closure(string): FileIssueReport  $detector
     */
    private function analyzeModuleFileNaming(string $moduleName, string $modulePath, string $subPath, string $pattern, string $label, \Closure $detector): void
    {
        $this->info(" - Modulo: {$moduleName}");
        $targetPath = $modulePath.'/app/'.$subPath;
        if (! File::exists($targetPath)) {
            $this->line('   - Directory '.basename($subPath).' non trovata');
            $this->newLine();

            return;
        }

        $finder = Finder::create()->files()->in($targetPath)->name($pattern);
        if (! $finder->hasResults()) {
            $this->line('   - Nessun '.strtolower($label).' trovato');
            $this->newLine();

            return;
        }

        /** @var array<string, FileIssueReport> $issuesFound */
        $issuesFound = [];
        foreach ($finder as $file) {
            $content = $file->getContents();
            $name = $file->getRelativePathname();
            $issues = $detector($content);
            if ($issues !== []) {
                $issuesFound[$name] = $issues;
            }
        }

        if ($issuesFound !== []) {
            $this->warn('   - Problemi di naming trovati:');
            foreach ($issuesFound as $name => $issues) {
                $this->line('     '.ucfirst($label).': '.$name);
                foreach ($issues as $issue) {
                    $linePrefix = '       - Campo: '.$issue['field'].' ('.$issue['location'].')';
                    $this->line($linePrefix);
                    $this->line('         Problema: '.$issue['issue']);
                    $this->line('         Correzione suggerita: '.$issue['correct']);
                }
            }
            $this->info('   - Suggerimento: Aggiornare i '.strtolower($label).' per utilizzare i nomi dei campi corretti');
        } else {
            $this->info('   - Nessun problema di naming trovato nei '.strtolower($label).' analizzati');
        }
        $this->newLine();
    }

    private function analyzeModuleModelsNaming(string $moduleName, string $modulePath): void
    {
        $this->analyzeModuleFileNaming($moduleName, $modulePath, 'Models', '*.php', 'modello', fn (string $content): array => $this->detectModelIssues($content));
    }

    private function analyzeModuleControllersNaming(string $moduleName, string $modulePath): void
    {
        $this->analyzeModuleFileNaming($moduleName, $modulePath, 'Http/Controllers', '*Controller.php', 'controller', fn (string $content): array => $this->detectControllerIssues($content));
    }

    private function analyzeControllersNaming(?string $module): void
    {
        $this->info('Analisi Convenzioni di Naming nei Controller:');
        $this->newLine();

        $moduleDirectories = $this->getModuleDirectories($module);

        foreach ($moduleDirectories as $moduleName => $modulePath) {
            $this->analyzeModuleControllersNaming($moduleName, $modulePath);
        }
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

    /** @return list<TableIssue> */
    private function analyzeTableIssues(string $table): array
    {
        if (! Schema::hasTable($table)) {
            return [];
        }

        /** @var list<string> $columnsRaw */
        $columnsRaw = Schema::getColumnListing($table);
        $columns = array_values(array_filter($columnsRaw, static fn (string $column): bool => $column !== ''));

        $issues = [];

        foreach ($columns as $column) {
            foreach ($this->namingConventions as $rule) {
                /** @var NamingRule $rule */
                $issues = array_merge($issues, $this->evaluateColumnAgainstRule($column, $rule));
            }
        }

        return $issues;
    }

    /**
     * @param  NamingRule  $rule
     * @return list<TableIssue>
     */
    private function evaluateColumnAgainstRule(string $column, array $rule): array
    {
        $issues = [];

        foreach ($rule['incorrect'] as $incorrect) {
            if ($this->isRegexPattern($incorrect)) {
                if (preg_match($incorrect, $column) === 1) {
                    $issues[] = ['column' => $column, 'issue' => $rule['message'], 'correct' => $this->getCorrectFieldPattern($column, $rule)];
                }

                continue;
            }

            if ($column === $incorrect) {
                $issues[] = ['column' => $column, 'issue' => $rule['message'], 'correct' => $this->getCorrectField($column, $rule)];
            }
        }

        return $issues;
    }

    /**
     * @return FileIssueReport
     */
    private function detectModelIssues(string $content): array
    {
        $issues = [];

        foreach ($this->namingConventions as $rule) {
            $incorrectFields = $rule['incorrect'];
            $message = $rule['message'];

            foreach ($incorrectFields as $incorrect) {
                if ($this->isRegexPattern($incorrect)) {
                    continue;
                }

                $fillableMatches = [];
                if (preg_match('/protected\s+\$fillable\s*=\s*\[(.*?)\]/s', $content, $fillableMatches) === 1) {
                    $fillableBody = (string) ($fillableMatches[1] ?? '');
                    if ($this->stringContainsField($fillableBody, $incorrect)) {
                        $issues[] = ['field' => $incorrect, 'location' => 'fillable', 'issue' => $message, 'correct' => $this->getCorrectField($incorrect, $rule)];
                    }
                }

                $castsMatches = [];
                if (preg_match('/protected\s+\$casts\s*=\s*\[(.*?)\]/s', $content, $castsMatches) === 1) {
                    $castsBody = (string) ($castsMatches[1] ?? '');
                    if ($this->stringContainsField($castsBody, $incorrect)) {
                        $issues[] = ['field' => $incorrect, 'location' => 'casts', 'issue' => $message, 'correct' => $this->getCorrectField($incorrect, $rule)];
                    }
                }

                $accessorPattern = '/function\s+get'.preg_quote(ucfirst($incorrect), '/').'Attribute/';
                $mutatorPattern = '/function\s+set'.preg_quote(ucfirst($incorrect), '/').'Attribute/';

                if (preg_match($accessorPattern, $content) === 1 || preg_match($mutatorPattern, $content) === 1) {
                    $issues[] = ['field' => $incorrect, 'location' => 'accessor/mutator', 'issue' => $message, 'correct' => $this->getCorrectField($incorrect, $rule)];
                }
            }
        }

        return $issues;
    }

    /**
     * @return FileIssueReport
     */
    private function detectControllerIssues(string $content): array
    {
        $issues = [];

        foreach ($this->namingConventions as $rule) {
            $incorrectFields = $rule['incorrect'];
            $message = $rule['message'];

            foreach ($incorrectFields as $incorrect) {
                if ($this->isRegexPattern($incorrect)) {
                    continue;
                }

                $patterns = [
                    '/function\s+\w+\s*\([^)]*\$'.preg_quote($incorrect, '/').'[\s,\)]/m',
                    '/\$'.preg_quote($incorrect, '/').'\s*=/',
                    '/\$request\s*->\s*'.preg_quote($incorrect, '/').'/m',
                ];

                if ($this->matchesAnyPattern($content, $patterns)) {
                    $issues[] = ['field' => $incorrect, 'location' => 'controller', 'issue' => $message, 'correct' => $this->getCorrectField($incorrect, $rule)];
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

    private function isRegexPattern(string $value): bool
    {
        return str_starts_with($value, '/') && str_ends_with($value, '/');
    }

    /**
     * @param  NamingRule  $rules
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
     * @param  NamingRule  $rules
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
