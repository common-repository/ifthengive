<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita244edd13b9c281ca3578ba45c2bf467
{
    public static $prefixesPsr0 = array (
        'a' => 
        array (
            'angelleye\\PayPal' => 
            array (
                0 => __DIR__ . '/..' . '/angelleye/paypal-php-library/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInita244edd13b9c281ca3578ba45c2bf467::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}