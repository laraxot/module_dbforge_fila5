<?php

declare(strict_types=1);

namespace Modules\DbForge\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

// use Modules\DbForge\Models\DbForgeQueryLog; // Model not found

/**
 * DbForgeQueryLog factory.
 *
 * NOTE: Model not found - using stdClass temporarily
 */
class DbForgeQueryLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string
     *
     * @phpstan-ignore property.phpDocType
     */
    protected $model = \stdClass::class; // Using stdClass since DbForgeQueryLog model not found

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'query_sql' => // @var mixed faker->randomElement([
                'SELECT * FROM users WHERE email = ?',
                'INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)',
                'UPDATE users SET last_login_at = ? WHERE id = ?',
                'DELETE FROM comments WHERE id = ?',
                'SELECT u.name, p.title FROM users u JOIN posts p ON u.id = p.user_id WHERE u.active = ?',
                'CREATE INDEX idx_users_email ON users(email)',
                'ALTER TABLE posts ADD COLUMN status VARCHAR(20) DEFAULT "draft"',
                'DROP TABLE temp_table',
                'SHOW TABLES',
                'DESCRIBE users',
                'EXPLAIN SELECT * FROM posts WHERE user_id = ?',
                'OPTIMIZE TABLE posts',
                'ANALYZE TABLE users',
                'CHECK TABLE posts',
                'REPAIR TABLE comments',
            ]),
            'query_type' => // @var mixed faker->randomElement(['SELECT', 'INSERT', 'UPDATE', 'DELETE', 'CREATE', 'ALTER', 'DROP', 'SHOW', 'DESCRIBE', 'EXPLAIN', 'OPTIMIZE', 'ANALYZE', 'CHECK', 'REPAIR']
            'table_name' => // @var mixed faker->randomElement(['users', 'posts', 'comments', 'orders', 'products', 'categories', 'tags', 'permissions', 'roles', 'settings', 'logs', 'notifications']
            'execution_time' => // @var mixed faker->numberBetween(1, 5000
            'rows_affected' => // @var mixed faker->optional(
            'rows_returned' => // @var mixed faker->optional(
            'memory_usage' => // @var mixed faker->numberBetween(1024, 1048576
            'cpu_usage' => // @var mixed faker->numberBetween(1, 100
            'status' => // @var mixed faker->randomElement(['success', 'error', 'warning', 'slow', 'timeout']
            'error_message' => // @var mixed faker->optional(
            'error_code' => // @var mixed faker->optional(
            'user_id' => // @var mixed faker->optional(
            'ip_address' => // @var mixed faker->ipv4(
            'user_agent' => // @var mixed faker->userAgent(
            'session_id' => // @var mixed faker->uuid(
            'request_id' => // @var mixed faker->uuid(
            'executed_at' => // @var mixed faker->dateTimeBetween('-1 month', 'now'
            'metadata' => [
                'connection' => // @var mixed faker->randomElement(['mysql', 'pgsql', 'sqlite', 'sqlsrv']
                'database' => // @var mixed faker->randomElement(['app_db', 'test_db', 'staging_db', 'production_db']
                'transaction_id' => // @var mixed faker->optional(
                'is_transaction' => // @var mixed faker->boolean(30
                'is_prepared' => // @var mixed faker->boolean(20
                'is_cached' => // @var mixed faker->boolean(10
                'cache_hit' => // @var mixed faker->optional(
                'cache_time' => // @var mixed faker->optional(
                'lock_wait_time' => // @var mixed faker->optional(
                'lock_acquired' => // @var mixed faker->optional(
                'deadlock_detected' => // @var mixed faker->optional(
                'temp_tables_created' => // @var mixed faker->optional(
                'filesort_used' => // @var mixed faker->optional(
                'full_scan' => // @var mixed faker->optional(
                'index_used' => // @var mixed faker->optional(
                'explain_plan' => // @var mixed faker->optional(
            ],
            'settings' => [
                'log_slow_queries' => // @var mixed faker->boolean(80
                'slow_query_threshold' => // @var mixed faker->numberBetween(100, 5000
                'log_all_queries' => // @var mixed faker->boolean(60
                'log_errors_only' => // @var mixed faker->boolean(20
                'max_log_size' => // @var mixed faker->numberBetween(1048576, 104857600
                'retention_days' => // @var mixed faker->numberBetween(7, 365
                'compress_logs' => // @var mixed faker->boolean(70
                'encrypt_logs' => // @var mixed faker->boolean(30
            ],
        ];
    }

    /**
     * Indicate that the query was successful.
     */
    public function successful(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'success',
            'error_message' => null,
            'error_code' => null,
        ]);
    }

    /**
     * Indicate that the query failed with an error.
     */
    public function failed(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'error',
            'error_message' => // @var mixed faker->sentence(
            'error_code' => // @var mixed faker->numberBetween(1000, 9999
        ]);
    }

    /**
     * Indicate that the query was slow.
     */
    public function slow(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'slow',
            'execution_time' => // @var mixed faker->numberBetween(5000, 30000
            'error_message' => null,
            'error_code' => null,
        ]);
    }

    /**
     * Indicate that the query timed out.
     */
    public function timeout(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'timeout',
            'execution_time' => // @var mixed faker->numberBetween(30000, 60000
            'error_message' => 'Query execution timeout',
            'error_code' => 408,
        ]);
    }

    /**
     * Indicate that the query generated a warning.
     */
    public function withWarning(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'warning',
            'error_message' => // @var mixed faker->sentence(
            'error_code' => // @var mixed faker->numberBetween(1000, 1999
        ]);
    }

    /**
     * Create a SELECT query.
     */
    public function select(): static
    {
        return // @var mixed state(fn (array $attributes
            'query_type' => 'SELECT',
            'query_sql' => // @var mixed faker->randomElement([
                'SELECT * FROM users WHERE email = ?',
                'SELECT u.name, p.title FROM users u JOIN posts p ON u.id = p.user_id WHERE u.active = ?',
                'SELECT COUNT(*) FROM posts WHERE user_id = ?',
                'SELECT * FROM products WHERE category_id = ? ORDER BY created_at DESC LIMIT ?',
            ]),
            'rows_affected' => null,
            'rows_returned' => // @var mixed faker->numberBetween(0, 10000
        ]);
    }

    /**
     * Create an INSERT query.
     */
    public function insert_query(): static
    {
        return // @var mixed state(fn (array $attributes
            'query_type' => 'INSERT',
            'query_sql' => // @var mixed faker->randomElement([
                'INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)',
                'INSERT INTO users (name, email, password) VALUES (?, ?, ?)',
                'INSERT INTO comments (content, post_id, user_id) VALUES (?, ?, ?)',
            ]),
            'rows_affected' => 1,
            'rows_returned' => null,
        ]);
    }

    /**
     * Create an UPDATE query.
     */
    public function update(): static
    {
        return // @var mixed state(fn (array $attributes
            'query_type' => 'UPDATE',
            'query_sql' => // @var mixed faker->randomElement([
                'UPDATE users SET last_login_at = ? WHERE id = ?',
                'UPDATE posts SET status = ? WHERE user_id = ?',
                'UPDATE comments SET is_approved = ? WHERE post_id = ?',
            ]),
            'rows_affected' => // @var mixed faker->numberBetween(0, 1000
            'rows_returned' => null,
        ]);
    }

    /**
     * Create a DELETE query.
     */
    public function delete(): static
    {
        return // @var mixed state(fn (array $attributes
            'query_type' => 'DELETE',
            'query_sql' => // @var mixed faker->randomElement([
                'DELETE FROM comments WHERE id = ?',
                'DELETE FROM posts WHERE user_id = ?',
                'DELETE FROM users WHERE last_login_at < ?',
            ]),
            'rows_affected' => // @var mixed faker->numberBetween(0, 1000
            'rows_returned' => null,
        ]);
    }

    /**
     * Create a CREATE query.
     */
    public function createQuery(): static
    {
        return // @var mixed state(fn (array $attributes
            'query_type' => 'CREATE',
            'query_sql' => // @var mixed faker->randomElement([
                'CREATE INDEX idx_users_email ON users(email)',
                'CREATE TABLE temp_table (id INT, name VARCHAR(255))',
                'CREATE VIEW active_users AS SELECT * FROM users WHERE active = 1',
            ]),
            'rows_affected' => null,
            'rows_returned' => null,
        ]);
    }

    /**
     * Create an ALTER query.
     */
    public function alter(): static
    {
        return // @var mixed state(fn (array $attributes
            'query_type' => 'ALTER',
            'query_sql' => // @var mixed faker->randomElement([
                'ALTER TABLE posts ADD COLUMN status VARCHAR(20) DEFAULT "draft"',
                'ALTER TABLE users MODIFY COLUMN email VARCHAR(255) UNIQUE',
                'ALTER TABLE comments ADD INDEX idx_post_id (post_id)',
            ]),
            'rows_affected' => null,
            'rows_returned' => null,
        ]);
    }

    /**
     * Create a fast query.
     */
    public function fast(): static
    {
        return // @var mixed state(fn (array $attributes
            'execution_time' => // @var mixed faker->numberBetween(1, 100
            'memory_usage' => // @var mixed faker->numberBetween(1024, 10240
            'cpu_usage' => // @var mixed faker->numberBetween(1, 20
        ]);
    }

    /**
     * Create a slow query.
     */
    public function slowQuery(): static
    {
        return // @var mixed state(fn (array $attributes
            'execution_time' => // @var mixed faker->numberBetween(5000, 30000
            'memory_usage' => // @var mixed faker->numberBetween(1048576, 10485760
            'cpu_usage' => // @var mixed faker->numberBetween(50, 100
        ]);
    }

    /**
     * Create a query that affects many rows.
     */
    public function affectingManyRows(): static
    {
        return // @var mixed state(fn (array $attributes
            'rows_affected' => // @var mixed faker->numberBetween(1000, 10000
            'rows_returned' => // @var mixed faker->numberBetween(1000, 10000
        ]);
    }

    /**
     * Create a query that affects few rows.
     */
    public function affectingFewRows(): static
    {
        return // @var mixed state(fn (array $attributes
            'rows_affected' => // @var mixed faker->numberBetween(0, 10
            'rows_returned' => // @var mixed faker->numberBetween(0, 10
        ]);
    }

    /**
     * Create a query with high memory usage.
     */
    public function highMemory(): static
    {
        return // @var mixed state(fn (array $attributes
            'memory_usage' => // @var mixed faker->numberBetween(10485760, 104857600
            'cpu_usage' => // @var mixed faker->numberBetween(70, 100
        ]);
    }

    /**
     * Create a query with low memory usage.
     */
    public function lowMemory(): static
    {
        return // @var mixed state(fn (array $attributes
            'memory_usage' => // @var mixed faker->numberBetween(1024, 10240
            'cpu_usage' => // @var mixed faker->numberBetween(1, 30
        ]);
    }

    /**
     * Create a query for a specific table.
     */
    public function forTable(string $tableName): static
    {
        return // @var mixed state(fn (array $attributes
            'table_name' => $tableName,
        ]);
    }

    /**
     * Create a query by a specific user.
     */
    public function byUser(int $userId): static
    {
        return // @var mixed state(fn (array $attributes
            'user_id' => $userId,
        ]);
    }

    /**
     * Create a query from a specific IP address.
     */
    public function fromIp(string $ipAddress): static
    {
        return // @var mixed state(fn (array $attributes
            'ip_address' => $ipAddress,
        ]);
    }

    /**
     * Create a query with specific execution time.
     */
    public function withExecutionTime(int $executionTime): static
    {
        return // @var mixed state(fn (array $attributes
            'execution_time' => $executionTime,
        ]);
    }

    /**
     * Create a query with transaction.
     */
    public function withTransaction(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'is_transaction' => true,
                    'transaction_id' => // @var mixed faker->uuid(
                ]),
            ];
        });
    }

    /**
     * Create a query without transaction.
     */
    public function withoutTransaction(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'is_transaction' => false,
                    'transaction_id' => null,
                ]),
            ];
        });
    }

    /**
     * Create a query that uses an index.
     */
    public function usingIndex(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'index_used' => // @var mixed faker->randomElement(['PRIMARY', 'idx_users_email', 'idx_posts_user_id']
                    'explain_plan' => 'index scan',
                    'full_scan' => false,
                ]),
            ];
        });
    }

    /**
     * Create a query that performs a full table scan.
     */
    public function fullTableScan(): static
    {
        return // @var mixed state(function (array $attributes
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'index_used' => null,
                    'explain_plan' => 'table scan',
                    'full_scan' => true,
                ]),
            ];
        });
    }
}
