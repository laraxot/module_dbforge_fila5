<?php

declare(strict_types=1);

namespace Modules\DbForge\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

// use Modules\DbForge\Models\DbForgeOperation; // Model not found

/**
 * DbForgeOperation factory.
 *
 * NOTE: Model not found - using stdClass temporarily
 */
class DbForgeOperationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string
     *
     * @phpstan-ignore property.phpDocType
     */
    protected $model = \stdClass::class; // Using stdClass since DbForgeOperation model not found

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'operation_type' => // @var mixed faker->randomElement(['create_table', 'alter_table', 'drop_table', 'create_index', 'drop_index', 'backup_table', 'restore_table', 'optimize_table', 'analyze_table']
            'table_name' => // @var mixed faker->randomElement(['users', 'posts', 'comments', 'orders', 'products', 'categories', 'tags', 'settings', 'logs', 'notifications']
            'operation_data' => [
                'columns' => [
                    'id' => ['type' => 'bigint', 'unsigned' => true, 'auto_increment' => true],
                    'name' => ['type' => 'varchar', 'length' => 255, 'nullable' => false],
                    'email' => ['type' => 'varchar', 'length' => 255, 'unique' => true],
                    'created_at' => ['type' => 'timestamp', 'nullable' => true],
                    'updated_at' => ['type' => 'timestamp', 'nullable' => true],
                ],
                'indexes' => [
                    'primary' => ['type' => 'primary', 'columns' => ['id']],
                    'email_unique' => ['type' => 'unique', 'columns' => ['email']],
                ],
                'foreign_keys' => [],
                'options' => [
                    'engine' => 'InnoDB',
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                ],
            ],
            'status' => // @var mixed faker->randomElement(['pending', 'running', 'completed', 'failed']
            'error_message' => // @var mixed faker->optional(
            'created_by' => // @var mixed faker->optional(
            'completed_at' => // @var mixed faker->optional(
        ];
    }

    /**
     * Indicate that the operation is pending.
     */
    public function pending(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'pending',
            'completed_at' => null,
            'error_message' => null,
        ]);
    }

    /**
     * Indicate that the operation is running.
     */
    public function running(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'running',
            'completed_at' => null,
            'error_message' => null,
        ]);
    }

    /**
     * Indicate that the operation is completed.
     */
    public function completed(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'completed',
            'completed_at' => // @var mixed faker->dateTimeBetween('-1 month', 'now'
            'error_message' => null,
        ]);
    }

    /**
     * Indicate that the operation failed.
     */
    public function failed(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'failed',
            'completed_at' => // @var mixed faker->dateTimeBetween('-1 month', 'now'
            'error_message' => // @var mixed faker->sentence(
        ]);
    }

    /**
     * Create a create table operation.
     */
    public function createTable(): static
    {
        return // @var mixed state(fn (array $attributes
            'operation_type' => 'create_table',
            'operation_data' => [
                'columns' => [
                    'id' => ['type' => 'bigint', 'unsigned' => true, 'auto_increment' => true],
                    'name' => ['type' => 'varchar', 'length' => 255, 'nullable' => false],
                    'description' => ['type' => 'text', 'nullable' => true],
                    'is_active' => ['type' => 'boolean', 'default' => true],
                    'created_at' => ['type' => 'timestamp', 'nullable' => true],
                    'updated_at' => ['type' => 'timestamp', 'nullable' => true],
                ],
                'indexes' => [
                    'primary' => ['type' => 'primary', 'columns' => ['id']],
                    'name_index' => ['type' => 'index', 'columns' => ['name']],
                    'active_index' => ['type' => 'index', 'columns' => ['is_active']],
                ],
                'foreign_keys' => [],
                'options' => [
                    'engine' => 'InnoDB',
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                ],
            ],
        ]);
    }

    /**
     * Create an alter table operation.
     */
    public function alterTable(): static
    {
        return // @var mixed state(fn (array $attributes
            'operation_type' => 'alter_table',
            'operation_data' => [
                'changes' => [
                    'add_columns' => [
                        'new_field' => ['type' => 'varchar', 'length' => 100, 'nullable' => true],
                        'status' => ['type' => 'enum', 'values' => ['active', 'inactive', 'pending'], 'default' => 'active'],
                    ],
                    'modify_columns' => [
                        'name' => ['type' => 'varchar', 'length' => 500, 'nullable' => false],
                    ],
                    'drop_columns' => ['old_field'],
                ],
                'indexes' => [
                    'add' => [
                        'status_index' => ['type' => 'index', 'columns' => ['status']],
                    ],
                    'drop' => ['old_index'],
                ],
            ],
        ]);
    }

    /**
     * Create a drop table operation.
     */
    public function dropTable(): static
    {
        return // @var mixed state(fn (array $attributes
            'operation_type' => 'drop_table',
            'operation_data' => [
                'backup_before_drop' => true,
                'cascade' => false,
                'restrict' => true,
            ],
        ]);
    }

    /**
     * Create a create index operation.
     */
    public function createIndex(): static
    {
        return // @var mixed state(fn (array $attributes
            'operation_type' => 'create_index',
            'operation_data' => [
                'index_name' => // @var mixed faker->word(
                'index_type' => // @var mixed faker->randomElement(['btree', 'hash', 'fulltext']
                'columns' => // @var mixed faker->randomElements(['id', 'name', 'email', 'created_at'], $this->faker->numberBetween(1, 3
                'unique' => // @var mixed faker->boolean(30
            ],
        ]);
    }

    /**
     * Create a backup table operation.
     */
    public function backupTable(): static
    {
        return // @var mixed state(fn (array $attributes
            'operation_type' => 'backup_table',
            'operation_data' => [
                'backup_format' => // @var mixed faker->randomElement(['sql', 'csv', 'json']
                'include_data' => // @var mixed faker->boolean(80
                'include_structure' => true,
                'compression' => // @var mixed faker->randomElement(['none', 'gzip', 'bzip2']
                'backup_path' => '/backups/tables/'.// @var mixed faker->date('Y-m-d'
            ],
        ]);
    }

    /**
     * Create a restore table operation.
     */
    public function restoreTable(): static
    {
        return // @var mixed state(fn (array $attributes
            'operation_type' => 'restore_table',
            'operation_data' => [
                'backup_file' => // @var mixed faker->filePath(
                'restore_mode' => // @var mixed faker->randomElement(['replace', 'append', 'merge']
                'validate_before_restore' => true,
                'backup_original' => true,
            ],
        ]);
    }

    /**
     * Create an optimize table operation.
     */
    public function optimizeTable(): static
    {
        return // @var mixed state(fn (array $attributes
            'operation_type' => 'optimize_table',
            'operation_data' => [
                'analyze' => true,
                'check' => true,
                'repair' => // @var mixed faker->boolean(50
                'force' => false,
            ],
        ]);
    }

    /**
     * Create an analyze table operation.
     */
    public function analyzeTable(): static
    {
        return // @var mixed state(fn (array $attributes
            'operation_type' => 'analyze_table',
            'operation_data' => [
                'update_statistics' => true,
                'sample_percentage' => // @var mixed faker->numberBetween(10, 100
                'parallel' => // @var mixed faker->boolean(30
            ],
        ]);
    }

    /**
     * Create a quick operation (fast execution).
     */
    public function quick(): static
    {
        return // @var mixed state(fn (array $attributes
            'operation_data' => array_merge((array) ($attributes['operation_data'] ?? []), [
                'quick' => true,
                'low_priority' => false,
            ]),
        ]);
    }

    /**
     * Create a low priority operation.
     */
    public function lowPriority(): static
    {
        return // @var mixed state(fn (array $attributes
            'operation_data' => array_merge((array) ($attributes['operation_data'] ?? []), [
                'low_priority' => true,
                'quick' => false,
            ]),
        ]);
    }

    /**
     * Create an operation with specific table.
     */
    public function forTable(string $tableName): static
    {
        return // @var mixed state(fn (array $attributes
            'table_name' => $tableName,
        ]);
    }

    /**
     * Create an operation with specific user.
     */
    public function byUser(int $userId): static
    {
        return // @var mixed state(fn (array $attributes
            'created_by' => $userId,
        ]);
    }
}
