<?php
/**
 * Set up libraries and autoloading for the examples
 */

$includePath = array(
    dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib',
    get_include_path(),
);
set_include_path(implode(PATH_SEPARATOR, $includePath));

require 'Loader.php';
Loader::registerAutoload();
