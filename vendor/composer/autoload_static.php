<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit62516f8c24399270aa9930407c0e4d74
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PSR2R\\' => 6,
        ),
        'D' => 
        array (
            'Dealerdirect\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 55,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PSR2R\\' => 
        array (
            0 => __DIR__ . '/..' . '/fig-r/psr2r-sniffer/PSR2R',
        ),
        'Dealerdirect\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 
        array (
            0 => __DIR__ . '/..' . '/dealerdirect/phpcodesniffer-composer-installer/src',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit62516f8c24399270aa9930407c0e4d74::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit62516f8c24399270aa9930407c0e4d74::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit62516f8c24399270aa9930407c0e4d74::$classMap;

        }, null, ClassLoader::class);
    }
}
