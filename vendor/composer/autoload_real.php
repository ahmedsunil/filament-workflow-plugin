<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitdcff87f48d45c84be9add0c67f24bce8
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitdcff87f48d45c84be9add0c67f24bce8', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitdcff87f48d45c84be9add0c67f24bce8', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitdcff87f48d45c84be9add0c67f24bce8::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
