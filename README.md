# DbForge Module

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 5.x](https://img.shields.io/badge/Filament-5.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
[![Actions 8](https://img.shields.io/badge/Actions-8-purple.svg)](#azioni)

> **Database schema automation**: reverse engineering da schema a codice, generazione automatica di modelli/migrazioni/factory, monitoraggio differenze schema-codice, query logging e analisi.

---

## Cosa fa

Il modulo DbForge automatizza le operazioni sul database: genera modelli, migrazioni e factory partendo dallo schema esistente (reverse engineering), monitora le differenze tra lo schema fisico e il codice, e fornisce strumenti per il logging e l'analisi delle query.

```php
// Reverse engineering: da tabella a modello + migrazione + factory
app(GenerateModelAction::class)->execute(
    table: 'lime_surveys',
    module: 'Limesurvey',
    connection: 'limesurvey',
);
// Genera: LimeSurvey.php, create_lime_surveys_table.php, LimeSurveyFactory.php

// Schema guard: trova differenze tra DB e codice
app(SchemaGuardAction::class)->execute('user');
// -> ['missing_columns' => [...], 'extra_indexes' => [...]]
```

---

## Modelli (2)

| Modello | Funzione |
|---------|----------|
| **DbForgeBackup** | Record backup database con metadati |
| **DbForgeMigration** | Tracking migrazioni generate |

---

## Azioni (8)

| Action | Funzione |
|--------|----------|
| **GenerateModelAction** | Genera modello Eloquent da tabella esistente |
| **GenerateMigrationAction** | Genera migrazione da schema |
| **GenerateFactoryAction** | Genera factory da colonne tabella |
| **SchemaGuardAction** | Confronta schema fisico con codice |
| **TableIndexAction** | Gestisce indici via classi modello |
| **QueryLogAction** | Logging e analisi query |
| **ExtractFieldNamesAction** | Estrae nomi colonne da tabella |
| **CheckColumnAction** | Verifica esistenza colonna |

---

## Reverse Engineering

```php
// Da una tabella esistente genera tutto il codice necessario
// 1. Modello con fillable, casts, relazioni base
// 2. Migrazione con schema completo
// 3. Factory con faker appropriato per tipo colonna

// Esempio: tabella con colonne varchar, integer, datetime, json
// -> TextInput, Number, DateTimePicker, JsonColumn
// -> fake()->name(), fake()->randomNumber(), fake()->dateTime(), json_encode([])
```

---

## Schema Guard

```php
// Monitora differenze tra schema fisico e codice
// Utile dopo aggiornamenti, merge di branch, o migrazioni mancanti

$diff = app(SchemaGuardAction::class)->execute('healthcare_app');
// [
//     'missing_in_code' => ['new_column_added_manually'],
//     'missing_in_db' => ['column_in_migration_not_migrated'],
//     'type_mismatches' => ['price: decimal(8,2) vs float'],
// ]
```

---

## Integrazione con altri moduli

```
DbForge ──> Limesurvey (reverse engineering tabelle lime_*)
DbForge ──> healthcare_app    (generazione modelli survey)
DbForge ──> Xot        (estende XotBaseMigration)
```

---

## Quick Start

```bash
php artisan module:enable DbForge
php artisan migrate
```

---

## Metriche

| Metrica | Valore |
|---------|--------|
| **Modelli** | 2 |
| **Azioni** | 8 |
| **PHPStan Level** | 10 |

---

**Module Type**: Database Automation
**Architecture**: Reverse engineering, schema guard, query analysis
**Quality**: PHPStan Level 10

*Dal database al codice e viceversa: generazione automatica, monitoraggio schema, analisi query.*
