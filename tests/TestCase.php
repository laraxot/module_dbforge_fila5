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
