<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit13db5f7a09094abea887f930c98199b1
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Models\\' => 7,
            'MVC\\' => 4,
        ),
        'C' => 
        array (
            'Controllers\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/.models',
        ),
        'MVC\\' => 
        array (
            0 => __DIR__ . '/../..' . '/router',
        ),
        'Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/controllers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit13db5f7a09094abea887f930c98199b1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit13db5f7a09094abea887f930c98199b1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit13db5f7a09094abea887f930c98199b1::$classMap;

        }, null, ClassLoader::class);
    }
}
