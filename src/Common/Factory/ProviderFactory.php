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
     * @param string $apikey
     * 
     * @return \OmniSmtp\Common\ProviderInterface
     */
    public function create(string $class, string $apikey)
    {
        
        if ($this->instance && get_class($this->instance) == $class) {
            return $this->instance;
        }
        
        $reflection = new ReflectionClass($class);
        
        return $reflection->newInstanceArgs([$apikey]);
    }
}