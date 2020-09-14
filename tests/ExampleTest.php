<?php

namespace oeleco\PullDeploy\Tests;

use Orchestra\Testbench\TestCase;
use oeleco\PullDeploy\PullDeployServiceProvider;

class ExampleTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PullDeployServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
