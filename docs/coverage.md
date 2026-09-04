---
title: "DbForge Module Test Coverage"
module: "DbForge"
type: concept
tags: [coverage, phpstan, mixed-type]
created: 2026-09-04
updated: 2026-09-04
qmd: "coverage"
---

# DbForge Module Test Coverage

## 2026-09-04 — `mixed` type reduction audit (BMAD: refactor/quality)

**Task**: reduce use of the PHP `mixed` type where a more specific type is actually
knowable, per project convention ("cerchiamo di non usare mixed, quando lo troviamo
cerchiamo di sostituirlo con qualcosa di adeguato").

**Scope**: `grep -rnE '\bmixed\b' Modules/DbForge --include="*.php"` found the module's
17 files using `mixed` (native type-hints and docblocks combined).

**Outcome**: **2 files changed, 15 reviewed and left as-is** (one of the two changed
files, `AnalyzeNamingCommand.php`, now has zero `mixed` occurrences left at all).

### Changed

| File | Change | Why safe |
|---|---|---|
| `app/Console/Commands/AnalyzeNamingCommand.php` | `Schema::getColumnListing($table)` result: `/** @var array<int, mixed> $columnsRaw */` → `/** @var list<string> $columnsRaw */`; filter closure `static fn (mixed $column): bool => is_string($column) && $column !== ''` → `static fn (string $column): bool => $column !== ''`. | Laravel's own source (`vendor/laravel/framework/src/Illuminate/Database/Schema/Builder.php:379` — `@return list<string>`) guarantees the real shape; `mixed` here was only a workaround for the `Schema::` facade returning unresolved types because Larastan's PHPStan extension is intentionally disabled in this repo's `phpstan.neon`. Verified with a full module PHPStan run after the change: still 0 errors. |
| `app/Console/Commands/GenerateDbDocumentationCommand.php` | `@param array<mixed, mixed>` → `@param array<string, mixed>` on `generateDocumentation()`, `generateTableDocumentation()`, `generateRelationshipDocumentation()`; added `/** @var array<string, mixed> $x */` narrowing casts at the three call sites (`$formDecoded`, `$table`, `$relationship`) right after their existing `is_array()` guards. | The decoded JSON schema file is always accessed by literal string keys (`'tables'`, `'relationships'`, `'comment'`, `'columns'`, `'indices'`, `'foreign_keys'`, etc.) throughout the file — the key type was always string in practice, `json_decode(..., true)` just can't prove it statically (JSON arrays can have int keys in the general case). Added the `@var` casts at the narrowing points instead of just changing the parameter docblocks, because the latter alone produced 3 new `argument.type` PHPStan errors (caller passing the wider `array<mixed, mixed>` inferred from `json_decode`). Re-ran PHPStan after adding the casts: back to 0 errors. |

### Left as `mixed` (reviewed, not changed)

| File(s) | Occurrences | Reason |
|---|---|---|
| `app/Console/Commands/DatabaseSchemaExporterCommand.php` | 1 native (`function (mixed $table): ?string` in an `array_map` over `DB::connection($connection)->select(...)` rows) + docblocks | The closure already defensively checks `is_object($table)` before use — narrowing the param to `object` would make that check dead code (`declare(strict_types=1)` is set, so a non-object row would become a hard `TypeError` instead of being filtered to `null`). Left as `mixed` to preserve the existing defensive behavior; not confident enough that `DB::select()` always yields `stdClass` under every driver/fetch config to accept that risk. |
| `app/Console/Commands/SearchTextInDbCommand.php` | 1 native (`fn (mixed $value, int|string $key) => [...]`) | `$value` is a raw column value from `(array) $result` where `$result` is an arbitrary row from `DB::table($tableName)->select('*')->...->get()` on a dynamically-chosen table/column — genuinely polymorphic (string, int, float, bool, null, binary...). Correctly `mixed`. |
| `app/Console/Commands/DatabaseSchemaExportCommand.php`, `app/Console/Commands/GenerateModelsFromSchemaCommand.php` | docblocks only (`array<string, array<string, mixed>>`, `array<string, mixed>`) | Already at the best achievable specificity: key type is string (evident), but values genuinely mix types (bool `nullable`, string `type`/`key`/`extra`, `mixed` `default`) and/or originate from `DB::`/`Schema::` facade calls whose real return type PHPStan cannot resolve with Larastan disabled. Narrowing further would be an unverifiable claim, not a fact from usage. |
| `app/Models/DbForgeBackup.php`, `DbForgeMigration.php`, `DbForgeOperation.php`, `DbForgeSchema.php`, `DbForgeQueryLog.php` | 1-2 each (`@property array<string, mixed>|null $metadata`/`$settings`/`operation_data`/`schema_definition`/`query_bindings`) | Genuine polymorphic JSON columns cast to `array`. Verified via the factories (`DbForgeBackupFactory::full()`/`incremental()`/`differential()` etc.) that different states populate these columns with structurally different key sets and value types (bool flags, ints, strings) depending on backup/migration/operation type — there is no single stable shape to declare. `array<string, mixed>` is already the adequate form (key type is string, value type is genuinely heterogeneous). |
| `database/factories/DbForgeBackupFactory.php`, `DbForgeMigrationFactory.php`, `DbForgeSchemaFactory.php`, `DbForgeOperationFactory.php`, `DbForgeQueryLogFactory.php` | 1 each on `definition(): array` (`@return array<string, mixed>`) plus per-state `@var array<string, mixed> $existing*` casts | Matches `Illuminate\Database\Eloquent\Factories\Factory::definition()`'s own vendor contract (`@return array<string, mixed>`); the `$existing*` casts read back the same genuinely-polymorphic JSON columns discussed above before merging in new keys. |
| `tests/Pest.php` | 3 (`@param`/`@return array<string, mixed>` on generic test helper functions) | Generic Pest helpers designed to accept/return arbitrary Eloquent attribute arrays across different model factories in this module; no single call site narrows the shape. |

No `@phpstan-ignore` added, no `phpstan.neon` change, no widening of any existing
narrower type back to `mixed`.

**PHPStan**: `./vendor/bin/phpstan analyse Modules/DbForge --no-progress
--error-format=table` → **0 errors before, 0 errors after**.

**PHPMD**: `./tools/phpmd.sh Modules/DbForge text ../docs/phpmd.ruleset.xml` ran
without crashing. All findings are pre-existing and unrelated to this diff
(`UnusedFormalParameter` on unused `$attributes` in factory state closures,
`ExcessiveClassComplexity`/`ExcessiveMethodLength`/`CyclomaticComplexity`/
`NPathComplexity` on several factories and commands, one `CamelCaseMethodName` on
`insert_query` in `DbForgeQueryLogFactory.php`). Re-ran PHPMD scoped to the two
changed files specifically — findings there are all pre-existing complexity/else-
expression items on methods untouched by this change, nothing new introduced by the
type edits themselves. Not touched — out of scope for this task and pre-existing
debt.

**Pest**: **not verifiable**. `Modules/DbForge/phpunit.xml` does not exist. The
module's `tests/` directory contains only `TestCase.php` and `Pest.php` (test
helpers) plus empty `Unit/` and `Feature/` directories (`.gitkeep` only, no actual
test files) — there is no suite to run for this module.

**Git**: `app/Console/Commands/AnalyzeNamingCommand.php` and
`app/Console/Commands/GenerateDbDocumentationCommand.php` changed; committed and
pushed to the module's own `laraxot` remote (`dev` branch).
