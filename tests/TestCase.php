<?php

declare(strict_types=1);

namespace Modules\DbForge\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\DbForge\Providers\DbForgeServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
<<<<<<< HEAD
 * Base test case for DbForge module tests.
=======
 * Base test case for DbForge module.
 *
 * Uses MySQL from .env.testing.
>>>>>>> ce89e2f1 (,)
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

<<<<<<< HEAD
    /**
     * Setup the test environment.
     */
=======
    protected static bool $migrated = false;

>>>>>>> ce89e2f1 (,)
    protected function setUp(): void
    {
        parent::setUp();

<<<<<<< HEAD
        // Load DbForge module specific configurations
        $this->loadLaravelMigrations();

        // Seed any required data for DbForge tests
        $this->artisan('module:seed', ['module' => 'DbForge']);
=======
        if (! self::$migrated) {
            $this->artisan('migrate:fresh', [
                '--force' => true,
            ]);

            $this->artisan('module:migrate', [
                '--force' => true,
            ]);

            self::$migrated = true;
        }
>>>>>>> ce89e2f1 (,)
    }

    protected function getPackageProviders($app): array
    {
        return [
            DbForgeServiceProvider::class,
            UserServiceProvider::class,
            XotServiceProvider::class,
        ];
    }
}
