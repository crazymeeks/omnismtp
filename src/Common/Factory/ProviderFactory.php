<?php

/**
 * SMTP factory
 * 
 * (c) Jeff Claud
 */

namespace OmniSmtp\Common\Factory;

use ReflectionClass;

class ProviderFactory
{
 
    private $instance = null;


    /**
     * Create a new smtp instance
     *
     * @param string $class Fully qualified namespace of the class
     * 
     * @return \OmniSmtp\Common\ProviderInterface
     */
    public function create(string $class)
    {

        if ($this->instance && get_class($this->instance) == $class) {
            return $this->instance;
        }
        
        $reflection = new ReflectionClass($class);
        
        return $reflection->newInstanceArgs();
    }
}