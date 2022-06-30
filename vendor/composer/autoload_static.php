<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf1f578d86dc97c0ea879dbba56220d8f
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitf1f578d86dc97c0ea879dbba56220d8f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf1f578d86dc97c0ea879dbba56220d8f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf1f578d86dc97c0ea879dbba56220d8f::$classMap;

        }, null, ClassLoader::class);
    }
}
