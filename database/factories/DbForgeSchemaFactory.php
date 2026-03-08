<?php

declare(strict_types=1);

namespace Modules\DbForge\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

// use Modules\DbForge\Models\DbForgeSchema; // Model not found

/**
 * DbForgeSchema factory.
 *
 * NOTE: Model not found - using stdClass temporarily
 */
class DbForgeSchemaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string
     *
     * @phpstan-ignore property.phpDocType
     */
    protected $model = \stdClass::class; // Using stdClass since DbForgeSchema model not found

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'table_name' => // @var mixed faker->randomElement(['users', 'posts', 'comments', 'orders', 'products', 'categories', 'tags', 'permissions', 'roles', 'settings', 'logs', 'notifications', 'migrations', 'failed_jobs', 'password_resets', 'personal_access_tokens']
            'table_comment' => // @var mixed faker->optional(
            'engine' => // @var mixed faker->randomElement(['InnoDB', 'MyISAM', 'MEMORY', 'CSV', 'ARCHIVE']
            'collation' => // @var mixed faker->randomElement(['utf8mb4_unicode_ci', 'utf8mb4_general_ci', 'utf8_unicode_ci', 'latin1_swedish_ci']
            'row_format' => // @var mixed faker->randomElement(['Dynamic', 'Fixed', 'Compressed', 'Redundant']
            'table_rows' => // @var mixed faker->numberBetween(0, 1000000
            'avg_row_length' => // @var mixed faker->numberBetween(100, 10000
            'data_length' => // @var mixed faker->numberBetween(1024, 1073741824
            'max_data_length' => // @var mixed faker->optional(
            'index_length' => // @var mixed faker->numberBetween(1024, 536870912
            'data_free' => // @var mixed faker->optional(
            'auto_increment' => // @var mixed faker->optional(
            'create_time' => // @var mixed faker->dateTimeBetween('-2 years', 'now'
            'update_time' => // @var mixed faker->optional(
            'check_time' => // @var mixed faker->optional(
            'checksum' => // @var mixed faker->optional(
            'create_options' => // @var mixed faker->optional(
            'table_catalog' => // @var mixed faker->randomElement(['def', 'information_schema', 'mysql', 'performance_schema']
            'table_schema' => // @var mixed faker->randomElement(['app_db', 'test_db', 'staging_db', 'production_db', 'backup_db']
            'version' => // @var mixed faker->numberBetween(1, 10
            'is_active' => // @var mixed faker->boolean(90
            'last_analyzed' => // @var mixed faker->optional(
            'last_optimized' => // @var mixed faker->optional(
            'metadata' => [
                'columns_count' => // @var mixed faker->numberBetween(3, 50
                'indexes_count' => // @var mixed faker->numberBetween(1, 20
                'foreign_keys_count' => // @var mixed faker->numberBetween(0, 10
                'triggers_count' => // @var mixed faker->numberBetween(0, 5
                'views_count' => // @var mixed faker->numberBetween(0, 3
                'stored_procedures_count' => // @var mixed faker->numberBetween(0, 5
                'functions_count' => // @var mixed faker->numberBetween(0, 3
                'events_count' => // @var mixed faker->numberBetween(0, 2
                'partitioned' => // @var mixed faker->boolean(20
                'partition_count' => // @var mixed faker->optional(
                'compression' => // @var mixed faker->optional(
                'encryption' => // @var mixed faker->boolean(10
                'tablespace' => // @var mixed faker->optional(
                'row_security' => // @var mixed faker->boolean(5
                'force_row_level_security' => // @var mixed faker->boolean(5
                'inherit' => // @var mixed faker->optional(
                'persistence' => // @var mixed faker->randomElement(['PERMANENT', 'TEMPORARY']
                'log' => // @var mixed faker->boolean(30
                'temporary' => // @var mixed faker->boolean(10
                'unlogged' => // @var mixed faker->boolean(5
                'oids' => // @var mixed faker->boolean(5
                'on_commit' => // @var mixed faker->optional(
                'parallel_workers' => // @var mixed faker->optional(
                'fillfactor' => // @var mixed faker->optional(
                'autovacuum_enabled' => // @var mixed faker->boolean(80
                'autovacuum_vacuum_threshold' => // @var mixed faker->optional(
                'autovacuum_analyze_threshold' => // @var mixed faker->optional(
                'autovacuum_vacuum_scale_factor' => // @var mixed faker->optional(
                'autovacuum_analyze_scale_factor' => // @var mixed faker->optional(
                'autovacuum_vacuum_cost_limit' => // @var mixed faker->optional(
                'autovacuum_vacuum_cost_delay' => // @var mixed faker->optional(
                'autovacuum_freeze_min_age' => // @var mixed faker->optional(
                'autovacuum_freeze_max_age' => // @var mixed faker->optional(
                'autovacuum_freeze_table_age' => // @var mixed faker->optional(
                'autovacuum_multixact_freeze_min_age' => // @var mixed faker->optional(
                'autovacuum_multixact_freeze_max_age' => // @var mixed faker->optional(
                'autovacuum_multixact_freeze_table_age' => // @var mixed faker->optional(
                'toast_tuple_target' => // @var mixed faker->optional(
                'autovacuum_vacuum_insert_threshold' => // @var mixed faker->optional(
                'autovacuum_vacuum_insert_scale_factor' => // @var mixed faker->optional(
                'user_catalog_table' => // @var mixed faker->boolean(5
                'is_insert_only' => // @var mixed faker->boolean(5
                'has_oids' => // @var mixed faker->boolean(5
                'relispartition' => // @var mixed faker->boolean(20
                'relispartition_parent' => // @var mixed faker->boolean(5
                'relpartbound' => // @var mixed faker->optional(
                'relhasindex' => // @var mixed faker->boolean(80
                'relhasrules' => // @var mixed faker->boolean(20
                'relhastriggers' => // @var mixed faker->boolean(30
                'relhasoids' => // @var mixed faker->boolean(5
                'relhasprimarykey' => // @var mixed faker->boolean(90
                'relhasforeignkeys' => // @var mixed faker->boolean(40
                'relhascheck' => // @var mixed faker->boolean(30
                'relhaspartialindexes' => // @var mixed faker->boolean(20
                'relhasreplident' => // @var mixed faker->boolean(10
                'relisreplicated' => // @var mixed faker->boolean(10
                'relfrozenxid' => // @var mixed faker->optional(
                'relminmxid' => // @var mixed faker->optional(
                'relacl' => // @var mixed faker->optional(
                'reloptions' => // @var mixed faker->optional(
                'relpartbound_expr' => // @var mixed faker->optional(
            ],
            'settings' => [
                'auto_increment_increment' => // @var mixed faker->optional(
                'auto_increment_offset' => // @var mixed faker->optional(
                'character_set_name' => // @var mixed faker->randomElement(['utf8mb4', 'utf8', 'latin1', 'ascii']
                'collation_name' => // @var mixed faker->randomElement(['utf8mb4_unicode_ci', 'utf8mb4_general_ci', 'utf8_unicode_ci', 'latin1_swedish_ci']
                'table_type' => // @var mixed faker->randomElement(['BASE TABLE', 'VIEW', 'SYSTEM VIEW', 'LOCAL TEMPORARY', 'GLOBAL TEMPORARY']
                'table_collation' => // @var mixed faker->randomElement(['utf8mb4_unicode_ci', 'utf8mb4_general_ci', 'utf8_unicode_ci', 'latin1_swedish_ci']
                'checksum' => // @var mixed faker->optional(
                'create_options' => // @var mixed faker->optional(
                'table_comment' => // @var mixed faker->optional(
                'max_index_length' => // @var mixed faker->optional(
                'temporary' => // @var mixed faker->optional(
                'update_time' => // @var mixed faker->optional(
                'check_time' => // @var mixed faker->optional(
                'table_rows' => // @var mixed faker->optional(
                'avg_row_length' => // @var mixed faker->optional(
                'data_length' => // @var mixed faker->optional(
                'max_data_length' => // @var mixed faker->optional(
                'index_length' => // @var mixed faker->optional(
                'data_free' => // @var mixed faker->optional(
                'auto_increment' => // @var mixed faker->optional(
                'create_time' => // @var mixed faker->optional(
                'table_catalog' => // @var mixed faker->optional(
                'table_schema' => // @var mixed faker->optional(
                'version' => // @var mixed faker->optional(
                'is_active' => // @var mixed faker->optional(
                'last_analyzed' => // @var mixed faker->optional(
                'last_optimized' => // @var mixed faker->optional(
            ],
        ];
    }

    /**
     * Indicate that the table is active.
     */
    public function active(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the table is inactive.
     */
    public function inactive(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_active' => false,
        ]);
    }

    /**
     * Create a large table.
     */
    public function large(): static
    {
        return // @var mixed state(fn (array $attributes
            'table_rows' => // @var mixed faker->numberBetween(100000, 10000000
            'avg_row_length' => // @var mixed faker->numberBetween(5000, 50000
            'data_length' => // @var mixed faker->numberBetween(1073741824, 10737418240
            'index_length' => // @var mixed faker->numberBetween(536870912, 2147483648
        ]);
    }

    /**
     * Create a small table.
     */
    public function small(): static
    {
        return // @var mixed state(fn (array $attributes
            'table_rows' => // @var mixed faker->numberBetween(0, 1000
            'avg_row_length' => // @var mixed faker->numberBetween(100, 1000
            'data_length' => // @var mixed faker->numberBetween(1024, 1048576
            'index_length' => // @var mixed faker->numberBetween(1024, 1048576
        ]);
    }

    /**
     * Create a partitioned table.
     */
    public function partitioned(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'partitioned' => true,
                    'partition_count' => // @var mixed faker->numberBetween(2, 16
                ]),
            ];
        });
    }

    /**
     * Create a non-partitioned table.
     */
    public function notPartitioned(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'partitioned' => false,
                    'partition_count' => null,
                ]),
            ];
        });
    }

    /**
     * Create a compressed table.
     */
    public function compressed(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'compression' => // @var mixed faker->randomElement(['ZLIB', 'LZ4', 'ZSTD']
                ]),
            ];
        });
    }

    /**
     * Create an uncompressed table.
     */
    public function uncompressed(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'compression' => 'NONE',
                ]),
            ];
        });
    }

    /**
     * Create an encrypted table.
     */
    public function encrypted(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'encryption' => true,
                ]),
            ];
        });
    }

    /**
     * Create an unencrypted table.
     */
    public function unencrypted(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'encryption' => false,
                ]),
            ];
        });
    }

    /**
     * Create a temporary table.
     */
    public function temporary(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'temporary' => true,
                    'persistence' => 'TEMPORARY',
                ]),
            ];
        });
    }

    /**
     * Create a permanent table.
     */
    public function permanent(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'temporary' => false,
                    'persistence' => 'PERMANENT',
                ]),
            ];
        });
    }

    /**
     * Create a table with many columns.
     */
    public function manyColumns(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'columns_count' => // @var mixed faker->numberBetween(20, 100
                ]),
            ];
        });
    }

    /**
     * Create a table with few columns.
     */
    public function fewColumns(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'columns_count' => // @var mixed faker->numberBetween(3, 10
                ]),
            ];
        });
    }

    /**
     * Create a table with many indexes.
     */
    public function manyIndexes(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'indexes_count' => // @var mixed faker->numberBetween(10, 30
                ]),
            ];
        });
    }

    /**
     * Create a table with few indexes.
     */
    public function fewIndexes(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'indexes_count' => // @var mixed faker->numberBetween(1, 5
                ]),
            ];
        });
    }

    /**
     * Create a table with foreign keys.
     */
    public function withForeignKeys(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'relhasforeignkeys' => true,
                    'foreign_keys_count' => // @var mixed faker->numberBetween(1, 10
                ]),
            ];
        });
    }

    /**
     * Create a table without foreign keys.
     */
    public function withoutForeignKeys(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'relhasforeignkeys' => false,
                    'foreign_keys_count' => 0,
                ]),
            ];
        });
    }

    /**
     * Create a table with triggers.
     */
    public function withTriggers(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'relhastriggers' => true,
                    'triggers_count' => // @var mixed faker->numberBetween(1, 5
                ]),
            ];
        });
    }

    /**
     * Create a table without triggers.
     */
    public function withoutTriggers(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'relhastriggers' => false,
                    'triggers_count' => 0,
                ]),
            ];
        });
    }

    /**
     * Create a table with rules.
     */
    public function withRules(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'relhasrules' => true,
                ]),
            ];
        });
    }

    /**
     * Create a table without rules.
     */
    public function withoutRules(): static
    {
        return // @var mixed state(fn (array $attributes
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'relhasrules' => false,
            ]),
        ]);
    }

    /**
     * Create a table with checks.
     */
    public function withChecks(): static
    {
        return // @var mixed state(fn (array $attributes
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'relhascheck' => true,
            ]),
        ]);
    }

    /**
     * Create a table without checks.
     */
    public function withoutChecks(): static
    {
        return // @var mixed state(fn (array $attributes
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'relhascheck' => false,
            ]),
        ]);
    }

    /**
     * Create a table for a specific database.
     */
    public function forDatabase(string $databaseName): static
    {
        return // @var mixed state(fn (array $attributes
            'table_schema' => $databaseName,
        ]);
    }

    /**
     * Create a table with specific engine.
     */
    public function withEngine(string $engine): static
    {
        return // @var mixed state(fn (array $attributes
            'engine' => $engine,
        ]);
    }

    /**
     * Create a table with specific collation.
     */
    public function withCollation(string $collation): static
    {
        return // @var mixed state(fn (array $attributes
            'collation' => $collation,
        ]);
    }

    /**
     * Create a table with specific row format.
     */
    public function withRowFormat(string $rowFormat): static
    {
        return // @var mixed state(fn (array $attributes
            'row_format' => $rowFormat,
        ]);
    }

    /**
     * Create a table with specific character set.
     */
    public function withCharacterSet(string $characterSet): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingSettings */
            $existingSettings = is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [];

            return [
                'settings' => array_merge($existingSettings, [
                    'character_set_name' => $characterSet,
                ]),
            ];
        });
    }

    /**
     * Create a table that was recently created.
     */
    public function recentlyCreated(): static
    {
        return // @var mixed state(fn (array $attributes
            'create_time' => // @var mixed faker->dateTimeBetween('-1 month', 'now'
        ]);
    }

    /**
     * Create a table that was created long ago.
     */
    public function old(): static
    {
        return // @var mixed state(fn (array $attributes
            'create_time' => // @var mixed faker->dateTimeBetween('-5 years', '-2 years'
        ]);
    }

    /**
     * Create a table that was recently updated.
     */
    public function recentlyUpdated(): static
    {
        return // @var mixed state(fn (array $attributes
            'update_time' => // @var mixed faker->dateTimeBetween('-1 month', 'now'
        ]);
    }

    /**
     * Create a table that was recently analyzed.
     */
    public function recentlyAnalyzed(): static
    {
        return // @var mixed state(fn (array $attributes
            'last_analyzed' => // @var mixed faker->dateTimeBetween('-1 month', 'now'
        ]);
    }

    /**
     * Create a table that was recently optimized.
     */
    public function recentlyOptimized(): static
    {
        return // @var mixed state(fn (array $attributes
            'last_optimized' => // @var mixed faker->dateTimeBetween('-1 month', 'now'
        ]);
    }
}
