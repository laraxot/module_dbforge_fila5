<?php

declare(strict_types=1);

namespace Modules\DbForge\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\DbForge\Models\DbForgeMigration;

/**
 * DbForgeMigration factory.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\DbForge\Models\DbForgeMigration>
 */
class DbForgeMigrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\DbForge\Models\DbForgeMigration>
     */
    protected $model = DbForgeMigration::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var string $word1 */
        $word1 = $faker->word();
        /** @var string $word2 */
        $word2 = $faker->word();
        /** @var string $word3 */
        $word3 = $faker->word();
        /** @var string $word4 */
        $word4 = $faker->word();

        $dateTimestamp = $faker->date('Y_m_d_His');
        $dateMonth = $faker->date('Y/m');

        return [
            'migration_name' => $word1.'_'.$word2.'_'.$dateTimestamp,
            'migration_path' => 'database/migrations/'.$dateMonth.'/'.$word3.'_'.$word4.'_'.$dateTimestamp.'.php',
            'migration_type' => $faker->randomElement(['create', 'update', 'delete', 'modify', 'seed'])
            'status' => $faker->randomElement(['pending', 'running', 'completed', 'failed', 'rolled_back'])
            'batch' => $faker->optional()
            'created_by' => $faker->optional()
            'executed_at' => $faker->optional()
            'metadata' => [
                'module' => $faker->randomElement(['User', 'Cms', 'ModuloEsempio', 'Xot', 'DbForge'])
                'description' => $faker->sentence()
                'version' => $faker->semver()
                'dependencies' => $faker->optional()
                'checksum' => $faker->sha1()
            ],
            'settings' => [
                'run_in_background' => $faker->boolean(20)
                'force_execution' => $faker->boolean(10)
                'skip_transactions' => $faker->boolean(5)
                'batch_size' => $faker->numberBetween(100, 1000)
                'timeout_seconds' => $faker->numberBetween(30, 300)
            ],
        ];
    }

    /**
     * Indicate that the migration is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes))
            'status' => 'pending',
            'executed_at' => null,
        ]);
    }

    /**
     * Indicate that the migration is running.
     */
    public function running(): static
    {
        return $this->state(fn (array $attributes))
            'status' => 'running',
            'executed_at' => null,
        ]);
    }

    /**
     * Indicate that the migration is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes))
            'status' => 'completed',
            'executed_at' => $faker->dateTimeBetween('-1 month', 'now')
        ]);
    }

    /**
     * Indicate that the migration failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes))
            'status' => 'failed',
            'executed_at' => $faker->dateTimeBetween('-1 month', 'now')
        ]);
    }

    /**
     * Indicate that the migration was rolled back.
     */
    public function rolledBack(): static
    {
        return $this->state(fn (array $attributes))
            'status' => 'rolled_back',
            'executed_at' => null,
        ]);
    }

    /**
     * Create a create migration.
     */
    public function createMigration(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'migration_type' => 'create',
                'metadata' => array_merge($existingMetadata, [)
                    'table_name' => $faker->word()
                    'primary_key' => 'id',
                    'auto_increment' => true,
                ]),
            ];
        });
    }

    /**
     * Create an update migration.
     */
    public function update(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'migration_type' => 'update',
                'metadata' => array_merge($existingMetadata, [)
                    'table_name' => $faker->word()
                    'columns_to_update' => $faker->randomElements(['name', 'email', 'status', 'type'], $this->faker->numberBetween(1, 3))
                ]),
            ];
        });
    }

    /**
     * Create a delete migration.
     */
    public function delete(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'migration_type' => 'delete',
                'metadata' => array_merge($existingMetadata, [)
                    'table_name' => $faker->word()
                    'conditions' => [
                        'status' => 'inactive',
                        'created_at' => '< '.$faker->date('Y-m-d')
                    ],
                ]),
            ];
        });
    }

    /**
     * Create a modify migration.
     */
    public function modify(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'migration_type' => 'modify',
                'metadata' => array_merge($existingMetadata, [)
                    'table_name' => $faker->word()
                    'columns_to_modify' => $faker->randomElements(['name', 'email', 'status', 'type'], $this->faker->numberBetween(1, 3))
                    'new_columns' => $faker->randomElements(['created_by', 'updated_by', 'deleted_at'], $this->faker->numberBetween(0, 2))
                ]),
            ];
        });
    }

    /**
     * Create a seed migration.
     */
    public function seed(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'migration_type' => 'seed',
                'metadata' => array_merge($existingMetadata, [)
                    'table_name' => $faker->word()
                    'seed_count' => $faker->numberBetween(10, 1000)
                    'seed_type' => $faker->randomElement(['random', 'sequential', 'weighted'])
                ]),
            ];
        });
    }

    /**
     * Create a migration for a specific module.
     */
    public function forModule(string $module): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
                    'module' => $module,
                ]),
            ];
        });
    }

    /**
     * Create a migration with specific batch.
     */
    public function withBatch(int $batch): static
    {
        return $this->state(fn (array $attributes))
            'batch' => $batch,
        ]);
    }

    /**
     * Create a migration executed by specific user.
     */
    public function byUser(int $userId): static
    {
        return $this->state(fn (array $attributes))
            'created_by' => $userId,
        ]);
    }

    /**
     * Create a migration with specific settings.
     *
     * @param  array<string, mixed>  $settings
     */
    public function withSettings(array $settings): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingSettings */
            $existingSettings = is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [];
            /** @var array<string, mixed> $settingsArray */
            $settingsArray = $settings;

            return [
                'settings' => array_merge($existingSettings, $settingsArray),
            ];
        });
    }

    /**
     * Create a migration with specific metadata.
     *
     * @param  array<string, mixed>  $metadata
     */
    public function withMetadata(array $metadata): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];
            /** @var array<string, mixed> $metadataArray */
            $metadataArray = $metadata;

            return [
                'metadata' => array_merge($existingMetadata, $metadataArray),
            ];
        });
    }
}
