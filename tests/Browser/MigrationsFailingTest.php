<?php

namespace Orchestra\Testbench\Dusk\Tests\Browser;

use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\Dusk\TestCase;

class MigrationsFailingTest extends TestCase
{

    protected function setUp(): void
    {
        passthru('php create-sqlite-db', $k);
        parent::setUp();
        copy(__DIR__ . '/../random_migration.php', database_path('migrations') . '/random_migration.php');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        passthru('php drop-sqlite-db', $k);
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations(['--force' => true, '--database' => config('database.default')]);
//        $this->loadMigrationsFrom(database_path('migrations'));
    }

    /** @test */
    public function can_authenticate_user()
    {
        self::assertTrue(Schema::hasTable('test'));
        $this->beforeApplicationDestroyed(function() {
            self::assertTrue(Schema::hasTable('test'));
        });
    }
}
