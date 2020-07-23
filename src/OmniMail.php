<?php

/**
 * This class is responsible for mail provider instantiation
 * 
 * Sample usage:
 * 
 * <code>
 * $sendinblue = OmniSmtp::create(\Namespace\SendInBlue::class);
 * </code>
 * 
 * (c) Jeff Claud
 */

namespace OmniSmtp;

use OmniMail\Common\Factory\ProviderFactory;

class OmniSmtp
{
    

    private static $factory = null;

    private static function getFactory()
    {
        if (self::$factory == null) {
            self::$factory = new ProviderFactory();
        }

        return self::$factory;
    }

    public static function __callStatic($name, $arguments)
    {
        $factory = self::getFactory();
        
        return call_user_func_array(array($factory, $name), $arguments);
    }
}