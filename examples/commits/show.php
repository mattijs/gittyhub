<?php
/**
 * Some examples of retreiving single commit information. 
 * 
 * This script can be called from the commandline from the project root.
 * For example:
 *     php examples/commits/show.php
 */

// Autoloading for examples
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'libraries.php';

// Create a new Client
$client = new \gittyhub\Client(array(
    'login' => 'mattijs'
));

// Get a single commit
$single = $client->commits->show('gittyhub', 'eeae3e6f64a8229b4f0d133ea215cd121ea2cea0');