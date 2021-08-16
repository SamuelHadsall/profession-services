<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitaddaafbdd7fdcef60541c8608676d446
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PostTypes\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PostTypes\\' => 
        array (
            0 => __DIR__ . '/..' . '/jjgrainger/posttypes/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitaddaafbdd7fdcef60541c8608676d446::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitaddaafbdd7fdcef60541c8608676d446::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitaddaafbdd7fdcef60541c8608676d446::$classMap;

        }, null, ClassLoader::class);
    }
}