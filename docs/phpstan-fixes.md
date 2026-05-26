# phpstan — modulo dbforge

## stato

| data | livello | errori | esito |
|------|---------|--------|-------|
| 2025-01-22 | 10 | 3 → 0 | fix `GenerateModelsFromSchemaCommand` (offset, var_export) |
| 2026-05-21 | max | 12 → 0 | scan completo comandi console + bootstrap notify |

**comando verifica:** `cd laravel && ./vendor/bin/phpstan analyse Modules/DbForge --no-progress`

## prerequisito bootstrap (2026-05-21)

PHPStan non partiva per marker merge `<<<<<<<` in `Modules/Notify/.../*Table.php`. Risolti prima dello scan DbForge (stesso pattern Activity: `getTableColumns()` istanza + `@return array<string, Column>`).

## errori risolti (2026-05-21)

### `DatabaseSchemaExporterCommand.php`

- **problema:** `$output` indefinito; `OutputInterface` senza `createProgressBar()`.
- **fix:** `$this->withProgressBar($tables, …)` (API Laravel tipizzata).

### `ExecuteSqlFileCommand.php`

- **problema:** `unprepared()` richiede `literal-string`; contenuto file `.sql` è `string` dinamica.
- **fix:** `PDO::exec($sql)` su connessione temporanea (no `@phpstan-ignore`).

### `GenerateDbDocumentationCommand.php`

- **problema:** `implode()` su `list` da `array_column()` non garantito `array<string>`.
- **fix:** loop con filtro `is_string` su `column['name']`.

### `GenerateModelClassCommand.php`

- **problema:** `str_replace($getNamespace($name))` — variabile/callable errati, stub corrotto.
- **fix:** `parent::replaceClass()` + placeholder `{{service_name}}` con namespace da `$this->getNamespace()`.

### `GenerateModelsFromSchemaCommand.php`

- **problema:** offset `1` dopo `preg_match` non garantito.
- **fix:** `isset($matches[1])` oltre a `=== 1`.

## pattern da riusare

1. **progress bar CLI:** preferire `$this->withProgressBar()` invece di cast su `getOutput()`.
2. **SQL da file:** `PDO::exec()` per stringhe dinamiche; evitare `unprepared()` senza literal-string.
3. **implode su colonne schema:** costruire `list<string>` esplicita, non `array_column` + `strval`.
4. **generator stub:** allinearsi a `GeneratorCommand::replaceClass()` del framework.

## collegamenti

- [second-brain.md](second-brain.md)
- [phpstan modules inventory](../../../../docs/wiki/memories/phpstan-modules-inventory.md)
- [phpstan usage](../../Xot/docs/phpstan-usage.md)

*ultimo aggiornamento: 2026-05-21*
