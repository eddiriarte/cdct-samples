<?php

namespace Tests\Order\Components;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->get('/');

        $this->assertEquals(
            '"Order Service v1.0.0, powered by Lumen"',
            $this->response->getContent()
        );
    }
}
