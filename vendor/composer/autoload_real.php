<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit28189765206a1baa46b1f7cda1dc6e9e
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

        spl_autoload_register(array('ComposerAutoloaderInit28189765206a1baa46b1f7cda1dc6e9e', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit28189765206a1baa46b1f7cda1dc6e9e', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit28189765206a1baa46b1f7cda1dc6e9e::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
