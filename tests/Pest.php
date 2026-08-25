<?php

declare(strict_types=1);

/**
 * Bootstrap Pest — modulo DbForge.
 * Ogni file test dichiara uses(\Modules\DbForge\Tests\TestCase::class).
 * Per estendere si usa l'API idiomatica di Pest — `pest()->extend(...)`, in fondo
 * a questo file — senza nessuna annotazione di soppressione: con
 * `pestphp/pest-plugin-phpstan 5.2.0` installato, `method.internalClass` non
 * viene piu' segnalato. Misurato il 2026-08-25 su tutti i bootstrap dei moduli:
 * `phpstan analyse Modules/<Modulo>/tests/Pest.php` = 0 errori.
 * Se ricomparisse, verificare che il plugin sia ancora caricato da
 * `phpstan/extension-installer`, non reintrodurre il divieto.
 * Vedi story XOT-5.41 e ROOT-17.6.
 */

/**
 * @param  array<string, mixed>  $attributes
 *
 * @return array<string, mixed>
 */
function createDbForgeConnection(array $attributes = []): array
{
    return array_merge([
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'test_db',
        'username' => 'test_user',
        'password' => 'test_password',
    ], $attributes);
}

/**
 * @return array<string, mixed>
 */
function makeDbForgeSchema(string $table = 'test_table'): array
{
    return [
        'table' => $table,
        'columns' => [
            'id' => ['type' => 'bigint', 'auto_increment' => true, 'primary' => true],
            'name' => ['type' => 'varchar', 'length' => 255, 'nullable' => false],
            'created_at' => ['type' => 'timestamp', 'nullable' => true],
            'updated_at' => ['type' => 'timestamp', 'nullable' => true],
        ],
    ];
}
pest()->extend(\Modules\DbForge\Tests\TestCase::class)->in(__DIR__.'/Unit', __DIR__.'/Feature');
