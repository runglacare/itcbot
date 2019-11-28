<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitacc0869fb4ccf27729ffcabc3c32ba31
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'LINE\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'LINE\\' => 
        array (
            0 => __DIR__ . '/..' . '/linecorp/line-bot-sdk/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitacc0869fb4ccf27729ffcabc3c32ba31::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitacc0869fb4ccf27729ffcabc3c32ba31::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}