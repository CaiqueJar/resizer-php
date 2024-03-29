<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit998c420dfd07ea6429d5aa325fe91294
{
    public static $files = array (
        '7c5b73c2fe178aa929b809d595767b6a' => __DIR__ . '/../..' . '/app/functions/custom.php',
    );

    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit998c420dfd07ea6429d5aa325fe91294::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit998c420dfd07ea6429d5aa325fe91294::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit998c420dfd07ea6429d5aa325fe91294::$classMap;

        }, null, ClassLoader::class);
    }
}
