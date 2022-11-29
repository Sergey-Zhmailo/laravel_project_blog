<?php

namespace Tests;

use Artisan;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Notification;
use Storage;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $seed = true;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh');
        Notification::fake();
        Storage::fake();
    }

    /**
     * Reset the migrations.
     *
     * @throws \Throwable
     */
    public function tearDown(): void
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }
}
