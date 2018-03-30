<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp()
    {
        $this->afterApplicationCreated(function () {
            $this->withoutExceptionHandling();
        });

        parent::setUp();
    }
}
