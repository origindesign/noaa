<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9b88bbecce097beadb86960ee164e92b
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'Origindesign\\Noaa\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Origindesign\\Noaa\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9b88bbecce097beadb86960ee164e92b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9b88bbecce097beadb86960ee164e92b::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
