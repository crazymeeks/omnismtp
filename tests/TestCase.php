<?php

namespace OmniSmtp\Tests;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
 
    
    public function tearDown()
    {
        \Mockery::close();

        parent::tearDown();
    }
}