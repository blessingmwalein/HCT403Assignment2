<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd02a7f0fe1a8ee79dcc61347cf9d0247
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'Vendor\\Test\\' => 12,
        ),
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Vendor\\Test\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd02a7f0fe1a8ee79dcc61347cf9d0247::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd02a7f0fe1a8ee79dcc61347cf9d0247::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd02a7f0fe1a8ee79dcc61347cf9d0247::$classMap;

        }, null, ClassLoader::class);
    }
}
