<?php

declare(strict_types=1);

namespace Modules\DbForge\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\DbForge\Providers\DbForgeServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for DbForge module.
 *
 * Uses MySQL from .env.testing.
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    protected static bool $migrated = false;

    protected function setUp(): void
    {
        parent::setUp();

        if (! self::$migrated) {
            $this->artisan('migrate:fresh', [
                '--force' => true,
            ]);

            $this->artisan('module:migrate', [
                '--force' => true,
            ]);

            self::$migrated = true;
        }
    }

    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders(Application $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            DbForgeServiceProvider::class,
            UserServiceProvider::class,
            XotServiceProvider::class,
        ];
    }
}
