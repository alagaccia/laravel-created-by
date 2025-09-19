<?php

namespace Alagaccia\CreatedBy\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Alagaccia\CreatedBy\CreatedByServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn(string $modelName) => 'Alagaccia\\CreatedBy\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            CreatedByServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-created-by_table.php.stub';
        $migration->up();
        */
    }
}
