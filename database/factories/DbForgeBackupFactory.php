<?php

declare(strict_types=1);

namespace Modules\DbForge\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\DbForge\Models\DbForgeBackup;

/**
 * DbForgeBackup factory.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\DbForge\Models\DbForgeBackup>
 */
class DbForgeBackupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\DbForge\Models\DbForgeBackup>
     */
    protected $model = DbForgeBackup::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var string $backupPrefix */
        $backupPrefix = $faker->randomElement(['daily_backup', 'weekly_backup', 'monthly_backup', 'manual_backup', 'emergency_backup', 'migration_backup', 'table_backup', 'schema_backup']);
        $dateTime = date('Y-m-d_H-i-s');
        $dateMonth = date('Y/m');
        /** @var string $word */
        $word = $faker->word();

        return [
            'backup_name' => $backupPrefix.'_'.$dateTime,
            'backup_path' => '/backups/database/'.$dateMonth.'/'.$dateTime.'_'.($word !== '' ? $word : 'backup').'.sql',
            'backup_size' => $faker->numberBetween(1024 * 1024, 1024 * 1024 * 1024)
            'backup_type' => $faker->randomElement(['full', 'incremental', 'selective'])
            'status' => $faker->randomElement(['pending', 'running', 'completed', 'failed'])
            'retention_days' => $faker->randomElement([7, 14, 30, 60, 90, 180, 365])
            'created_by' => $faker->optional()
            'completed_at' => $faker->optional()
            'metadata' => [
                'compression' => $faker->randomElement(['none', 'gzip', 'bzip2', 'lz4'])
                'encryption' => $faker->boolean(20)
                'checksum' => $faker->sha1()
                'version' => $faker->semver()
                'tables_included' => $faker->randomElements(['users', 'posts', 'comments', 'orders', 'products'], $this->faker->numberBetween(1, 5))
                'tables_excluded' => $faker->optional()
            ],
            'settings' => [
                'include_structure' => true,
                'include_data' => $faker->boolean(90)
                'include_triggers' => $faker->boolean(80)
                'include_procedures' => $faker->boolean(70)
                'include_functions' => $faker->boolean(70)
                'include_events' => $faker->boolean(60)
                'single_transaction' => $faker->boolean(80)
                'lock_tables' => $faker->boolean(40)
            ],
        ];
    }

    /**
     * Indicate that the backup is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes))
            'status' => 'pending',
            'completed_at' => null,
        ]);
    }

    /**
     * Indicate that the backup is running.
     */
    public function running(): static
    {
        return $this->state(fn (array $attributes))
            'status' => 'running',
            'completed_at' => null,
        ]);
    }

    /**
     * Indicate that the backup is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes))
            'status' => 'completed',
            'completed_at' => $faker->dateTimeBetween('-1 month', 'now')
        ]);
    }

    /**
     * Indicate that the backup failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes))
            'status' => 'failed',
            'completed_at' => $faker->dateTimeBetween('-1 month', 'now')
        ]);
    }

    /**
     * Create a full backup.
     */
    public function full(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingSettings */
            $existingSettings = is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [];

            return [
                'backup_type' => 'full',
                'backup_size' => $faker->numberBetween(100 * 1024 * 1024, 1024 * 1024 * 1024)
                'settings' => array_merge()
                    $existingSettings,
                    [
                        'include_structure' => true,
                        'include_data' => true,
                        'include_triggers' => true,
                        'include_procedures' => true,
                        'include_functions' => true,
                        'include_events' => true,
                    ]
                ),
            ];
        });
    }

    /**
     * Create an incremental backup.
     */
    public function incremental(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'backup_type' => 'incremental',
                'backup_size' => $faker->numberBetween(10 * 1024 * 1024, 100 * 1024 * 1024)
                'metadata' => array_merge()
                    $existingMetadata,
                    [
                        'base_backup_id' => $faker->numberBetween(1, 1000)
                        'incremental_since' => $faker->dateTimeBetween('-1 week', 'now')
                    ]
                ),
            ];
        });
    }

    /**
     * Create a selective backup.
     */
    public function selective(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'backup_type' => 'selective',
                'backup_size' => $faker->numberBetween(1 * 1024 * 1024, 50 * 1024 * 1024)
                'metadata' => array_merge($existingMetadata, [)
                    'tables_included' => $faker->randomElements(['users', 'posts', 'comments'], $this->faker->numberBetween(1, 3))
                    'tables_excluded' => $faker->randomElements(['logs', 'temp_data', 'cache', 'sessions'], $this->faker->numberBetween(1, 4))
                ]),
            ];
        });
    }

    /**
     * Create a daily backup.
     */
    public function daily(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'backup_name' => 'daily_backup_'.$faker->date('Y-m-d_H-i-s')
                'retention_days' => 7,
                'metadata' => array_merge($existingMetadata, [)
                    'schedule' => 'daily',
                    'time' => '02:00:00',
                ]),
            ];
        });
    }

    /**
     * Create a weekly backup.
     */
    public function weekly(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'backup_name' => 'weekly_backup_'.$faker->date('Y-m-d_H-i-s')
                'retention_days' => 30,
                'metadata' => array_merge($existingMetadata, [)
                    'schedule' => 'weekly',
                    'day' => 'sunday',
                    'time' => '03:00:00',
                ]),
            ];
        });
    }

    /**
     * Create a monthly backup.
     */
    public function monthly(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'backup_name' => 'monthly_backup_'.$faker->date('Y-m-d_H-i-s')
                'retention_days' => 365,
                'metadata' => array_merge($existingMetadata, [)
                    'schedule' => 'monthly',
                    'day' => 1,
                    'time' => '04:00:00',
                ]),
            ];
        });
    }

    /**
     * Create a compressed backup.
     */
    public function compressed(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
                    'compression' => $faker->randomElement(['gzip', 'bzip2', 'lz4'])
                    'compression_ratio' => $faker->randomFloat(2, 0.3, 0.8)
                ]),
            ];
        });
    }

    /**
     * Create an encrypted backup.
     */
    public function encrypted(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [)
                    'encryption' => true,
                    'encryption_algorithm' => $faker->randomElement(['AES-256', 'ChaCha20', 'Twofish'])
                    'encryption_key_id' => $faker->uuid()
                ]),
            ];
        });
    }

    /**
     * Create a large backup.
     */
    public function large(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'backup_size' => $faker->numberBetween(1024 * 1024 * 1024, 10 * 1024 * 1024 * 1024)
                'metadata' => array_merge($existingMetadata, [)
                    'estimated_time' => $faker->numberBetween(300, 3600)
                    'parallel_jobs' => $faker->numberBetween(2, 8)
                ]),
            ];
        });
    }

    /**
     * Create a small backup.
     */
    public function small(): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'backup_size' => $faker->numberBetween(1024 * 1024, 10 * 1024 * 1024)
                'metadata' => array_merge($existingMetadata, [)
                    'estimated_time' => $faker->numberBetween(10, 300)
                    'parallel_jobs' => 1,
                ]),
            ];
        });
    }

    /**
     * Create a backup with specific retention.
     */
    public function withRetention(int $days): static
    {
        return $this->state(fn (array $attributes))
            'retention_days' => $days,
        ]);
    }

    /**
     * Create a backup with specific user.
     */
    public function byUser(int $userId): static
    {
        return $this->state(fn (array $attributes))
            'created_by' => $userId,
        ]);
    }

    /**
     * Create a backup for specific tables.
     *
     * @param  array<string>  $tables
     */
    public function forTables(array $tables): static
    {
        return $this->state(function (array $attributes))
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'backup_type' => 'selective',
                'metadata' => array_merge($existingMetadata, [)
                    'tables_included' => $tables,
                    'tables_excluded' => [],
                ]),
            ];
        });
    }
}
