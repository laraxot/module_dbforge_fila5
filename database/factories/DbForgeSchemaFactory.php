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
            'table_name' => $faker->randomElement(['users', 'posts', 'comments', 'orders', 'products', 'categories', 'tags', 'permissions', 'roles', 'settings', 'logs', 'notifications', 'migrations', 'failed_jobs', 'password_resets', 'personal_access_tokens'])
            'table_comment' => $faker->optional()
            'engine' => $faker->randomElement(['InnoDB', 'MyISAM', 'MEMORY', 'CSV', 'ARCHIVE'])
            'collation' => $faker->randomElement(['utf8mb4_unicode_ci', 'utf8mb4_general_ci', 'utf8_unicode_ci', 'latin1_swedish_ci'])
            'row_format' => $faker->randomElement(['Dynamic', 'Fixed', 'Compressed', 'Redundant'])
            'table_rows' => $faker->numberBetween(0, 1000000)
            'avg_row_length' => $faker->numberBetween(100, 10000)
            'data_length' => $faker->numberBetween(1024, 1073741824)
            'max_data_length' => $faker->optional()
            'index_length' => $faker->numberBetween(1024, 536870912)
            'data_free' => $faker->optional()
            'auto_increment' => $faker->optional()
            'create_time' => $faker->dateTimeBetween('-2 years', 'now')
            'update_time' => $faker->optional()
            'check_time' => $faker->optional()
            'checksum' => $faker->optional()
            'create_options' => $faker->optional()
            'table_catalog' => $faker->randomElement(['def', 'information_schema', 'mysql', 'performance_schema'])
            'table_schema' => $faker->randomElement(['app_db', 'test_db', 'staging_db', 'production_db', 'backup_db'])
            'version' => $faker->numberBetween(1, 10)
            'is_active' => $faker->boolean(90)
            'last_analyzed' => $faker->optional()
            'last_optimized' => $faker->optional()
            'metadata' => [
                'columns_count' => $faker->numberBetween(3, 50)
                'indexes_count' => $faker->numberBetween(1, 20)
                'foreign_keys_count' => $faker->numberBetween(0, 10)
                'triggers_count' => $faker->numberBetween(0, 5)
                'views_count' => $faker->numberBetween(0, 3)
                'stored_procedures_count' => $faker->numberBetween(0, 5)
                'functions_count' => $faker->numberBetween(0, 3)
                'events_count' => $faker->numberBetween(0, 2)
                'partitioned' => $faker->boolean(20)
                'partition_count' => $faker->optional()
                'compression' => $faker->optional()
                'encryption' => $faker->boolean(10)
                'tablespace' => $faker->optional()
                'row_security' => $faker->boolean(5)
                'force_row_level_security' => $faker->boolean(5)
                'inherit' => $faker->optional()
                'persistence' => $faker->randomElement(['PERMANENT', 'TEMPORARY'])
                'log' => $faker->boolean(30)
                'temporary' => $faker->boolean(10)
                'unlogged' => $faker->boolean(5)
                'oids' => $faker->boolean(5)
                'on_commit' => $faker->optional()
                'parallel_workers' => $faker->optional()
                'fillfactor' => $faker->optional()
                'autovacuum_enabled' => $faker->boolean(80)
                'autovacuum_vacuum_threshold' => $faker->optional()
                'autovacuum_analyze_threshold' => $faker->optional()
                'autovacuum_vacuum_scale_factor' => $faker->optional()
                'autovacuum_analyze_scale_factor' => $faker->optional()
                'autovacuum_vacuum_cost_limit' => $faker->optional()
                'autovacuum_vacuum_cost_delay' => $faker->optional()
                'autovacuum_freeze_min_age' => $faker->optional()
                'autovacuum_freeze_max_age' => $faker->optional()
                'autovacuum_freeze_table_age' => $faker->optional()
                'autovacuum_multixact_freeze_min_age' => $faker->optional()
                'autovacuum_multixact_freeze_max_age' => $faker->optional()
                'autovacuum_multixact_freeze_table_age' => $faker->optional()
                'toast_tuple_target' => $faker->optional()
                'autovacuum_vacuum_insert_threshold' => $faker->optional()
                'autovacuum_vacuum_insert_scale_factor' => $faker->optional()
                'user_catalog_table' => $faker->boolean(5)
                'is_insert_only' => $faker->boolean(5)
                'has_oids' => $faker->boolean(5)
                'relispartition' => $faker->boolean(20)
                'relispartition_parent' => $faker->boolean(5)
                'relpartbound' => $faker->optional()
                'relhasindex' => $faker->boolean(80)
                'relhasrules' => $faker->boolean(20)
                'relhastriggers' => $faker->boolean(30)
                'relhasoids' => $faker->boolean(5)
                'relhasprimarykey' => $faker->boolean(90)
                'relhasforeignkeys' => $faker->boolean(40)
                'relhascheck' => $faker->boolean(30)
                'relhaspartialindexes' => $faker->boolean(20)
                'relhasreplident' => $faker->boolean(10)
                'relisreplicated' => $faker->boolean(10)
                'relfrozenxid' => $faker->optional()
                'relminmxid' => $faker->optional()
                'relacl' => $faker->optional()
                'reloptions' => $faker->optional()
                'relpartbound_expr' => $faker->optional()
            ],
            'settings' => [
                'auto_increment_increment' => $faker->optional()
                'auto_increment_offset' => $faker->optional()
                'character_set_name' => $faker->randomElement(['utf8mb4', 'utf8', 'latin1', 'ascii'])
                'collation_name' => $faker->randomElement(['utf8mb4_unicode_ci', 'utf8mb4_general_ci', 'utf8_unicode_ci', 'latin1_swedish_ci'])
                'table_type' => $faker->randomElement(['BASE TABLE', 'VIEW', 'SYSTEM VIEW', 'LOCAL TEMPORARY', 'GLOBAL TEMPORARY'])
                'table_collation' => $faker->randomElement(['utf8mb4_unicode_ci', 'utf8mb4_general_ci', 'utf8_unicode_ci', 'latin1_swedish_ci'])
                'checksum' => $faker->optional()
                'create_options' => $faker->optional()
                'table_comment' => $faker->optional()
                'max_index_length' => $faker->optional()
                'temporary' => $faker->optional()
                'update_time' => $faker->optional()
                'check_time' => $faker->optional()
                'table_rows' => $faker->optional()
                'avg_row_length' => $faker->optional()
                'data_length' => $faker->optional()
                'max_data_length' => $faker->optional()
                'index_length' => $faker->optional()
                'data_free' => $faker->optional()
                'auto_increment' => $faker->optional()
                'create_time' => $faker->optional()
                'table_catalog' => $faker->optional()
                'table_schema' => $faker->optional()
                'version' => $faker->optional()
                'is_active' => $faker->optional()
                'last_analyzed' => $faker->optional()
                'last_optimized' => $faker->optional()
            ],
        ];
    }

    /**
     * Indicate that the table is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes))
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the table is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes))
            'is_active' => false,
        ]);
    }

    /**
     * Create a large table.
     */
    public function large(): static
    {
        return $this->state(fn (array $attributes))
            'table_rows' => $faker->numberBetween(100000, 10000000)
            'avg_row_length' => $faker->numberBetween(5000, 50000)
            'data_length' => $faker->numberBetween(1073741824, 10737418240)
            'index_length' => $faker->numberBetween(536870912, 2147483648)
        ]);
    }

    /**
     * Create a small table.
     */
    public function small(): static
    {
        return $this->state(fn (array $attributes))
            'table_rows' => $faker->numberBetween(0, 1000)
            'avg_row_length' => $faker->numberBetween(100, 1000)
            'data_length' => $faker->numberBetween(1024, 1048576)
            'index_length' => $faker->numberBetween(1024, 1048576)
        ]);
    }

    /**
     * Create a partitioned table.
     */
    public function partitioned(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
                    'partitioned' => true,
                    'partition_count' => $faker->numberBetween(2, 16)
                ]),
            ];
        });
    }

    /**
     * Create a non-partitioned table.
     */
    public function notPartitioned(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
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
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
                    'compression' => $faker->randomElement(['ZLIB', 'LZ4', 'ZSTD'])
                ]),
            ];
        });
    }

    /**
     * Create an uncompressed table.
     */
    public function uncompressed(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
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
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
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
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
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
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
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
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
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
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
                    'columns_count' => $faker->numberBetween(20, 100)
                ]),
            ];
        });
    }

    /**
     * Create a table with few columns.
     */
    public function fewColumns(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
                    'columns_count' => $faker->numberBetween(3, 10)
                ]),
            ];
        });
    }

    /**
     * Create a table with many indexes.
     */
    public function manyIndexes(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
                    'indexes_count' => $faker->numberBetween(10, 30)
                ]),
            ];
        });
    }

    /**
     * Create a table with few indexes.
     */
    public function fewIndexes(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
                    'indexes_count' => $faker->numberBetween(1, 5)
                ]),
            ];
        });
    }

    /**
     * Create a table with foreign keys.
     */
    public function withForeignKeys(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
                    'relhasforeignkeys' => true,
                    'foreign_keys_count' => $faker->numberBetween(1, 10)
                ]),
            ];
        });
    }

    /**
     * Create a table without foreign keys.
     */
    public function withoutForeignKeys(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
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
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
                    'relhastriggers' => true,
                    'triggers_count' => $faker->numberBetween(1, 5)
                ]),
            ];
        });
    }

    /**
     * Create a table without triggers.
     */
    public function withoutTriggers(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
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
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
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
        return $this->state(fn (array $attributes))
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [)
                'relhasrules' => false,
            ]),
        ]);
    }

    /**
     * Create a table with checks.
     */
    public function withChecks(): static
    {
        return $this->state(fn (array $attributes))
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [)
                'relhascheck' => true,
            ]),
        ]);
    }

    /**
     * Create a table without checks.
     */
    public function withoutChecks(): static
    {
        return $this->state(fn (array $attributes))
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [)
                'relhascheck' => false,
            ]),
        ]);
    }

    /**
     * Create a table for a specific database.
     */
    public function forDatabase(string $databaseName): static
    {
        return $this->state(fn (array $attributes))
            'table_schema' => $databaseName,
        ]);
    }

    /**
     * Create a table with specific engine.
     */
    public function withEngine(string $engine): static
    {
        return $this->state(fn (array $attributes))
            'engine' => $engine,
        ]);
    }

    /**
     * Create a table with specific collation.
     */
    public function withCollation(string $collation): static
    {
        return $this->state(fn (array $attributes))
            'collation' => $collation,
        ]);
    }

    /**
     * Create a table with specific row format.
     */
    public function withRowFormat(string $rowFormat): static
    {
        return $this->state(fn (array $attributes))
            'row_format' => $rowFormat,
        ]);
    }

    /**
     * Create a table with specific character set.
     */
    public function withCharacterSet(string $characterSet): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingSettings */
            $existingSettings = is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [];

            return [
                'settings' => array_merge($existingSettings, [)
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
        return $this->state(fn (array $attributes))
            'create_time' => $faker->dateTimeBetween('-1 month', 'now')
        ]);
    }

    /**
     * Create a table that was created long ago.
     */
    public function old(): static
    {
        return $this->state(fn (array $attributes))
            'create_time' => $faker->dateTimeBetween('-5 years', '-2 years')
        ]);
    }

    /**
     * Create a table that was recently updated.
     */
    public function recentlyUpdated(): static
    {
        return $this->state(fn (array $attributes))
            'update_time' => $faker->dateTimeBetween('-1 month', 'now')
        ]);
    }

    /**
     * Create a table that was recently analyzed.
     */
    public function recentlyAnalyzed(): static
    {
        return $this->state(fn (array $attributes))
            'last_analyzed' => $faker->dateTimeBetween('-1 month', 'now')
        ]);
    }

    /**
     * Create a table that was recently optimized.
     */
    public function recentlyOptimized(): static
    {
        return $this->state(fn (array $attributes))
            'last_optimized' => $faker->dateTimeBetween('-1 month', 'now')
        ]);
    }
}
