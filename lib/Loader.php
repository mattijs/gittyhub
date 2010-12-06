<?php
/**
 * Loader.php
 */

/**
 * Simple autoloading implementation for based on an example from the PHP
 * standards group. This is not a full implementation, just the parts that are
 * needed to load classes from the lib directory.
 *
 * @see http://groups.google.com/group/php-standards/web/psr-0-final-proposal
 * @see https://gist.github.com/221634
 *
 * @author  Mattijs Hoitink <mattijs@monkeyandmachine.com>
 */
class Loader
{
    /**
     * Separator for PHP namespaces
     * @var string
     */
    private static $namespaceSeparator = '\\';

    /** **/

    /**
     * Load a class from the include path based on its namespace and filename.
     * @param string $className The class name to load
     */
    public static function loadClass($className)
    {
        $className = ltrim($className, static::$namespaceSeparator);
        $fileName  = '';
        $namespace = '';
        if (false !== ($lastNsPos = strripos($className, static::$namespaceSeparator))) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace(static::$namespaceSeparator, DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        require $fileName;
    }

    /**
     * Register this class with the autoloading stack.
     */
    public static function registerAutoload()
    {
        \spl_autoload_register(array('self', 'loadClass'));
    }

    /**
     * Unregister this class from the autoloading stack
     */
    public static function unregisterAutoload()
    {
        \spl_autoload_unregister(array(self, 'loadClass'));
    }
}