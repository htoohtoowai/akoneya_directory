<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Hotel;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    /**
     * Assert that the response has an bad request status code.
     *
     * @return $this
     */
    public function assertBadRequest($actual)
    {
        self::assertSame(
            400, $actual,
            "Response status code [{$actual}] is not an bad request status code."
        );

        return $this;
    }
}
