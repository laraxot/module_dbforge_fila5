<?php

declare(strict_types=1);

/*
 * Bootstrap Pest — modulo DbForge.
 * Ogni file test dichiara uses(\Modules\DbForge\Tests\TestCase::class).
 * Vietato pest()->extend() e expect()->extend() qui (PHPStan method.internalClass).
 */

require_once __DIR__.'/../../Xot/tests/XotBasePest.php';

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
