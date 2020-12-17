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
}
