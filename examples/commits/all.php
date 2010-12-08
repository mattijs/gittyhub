<?php
/**
 * Some examples of retreiving commit information. 
 * 
 * This script can be called from the commandline from the project root.
 * For example:
 *     php examples/commits/all.php
 */

// Autoloading for examples
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'libraries.php';

// Create a new Client
$client = new \gittyhub\Client(array(
    'login' => 'mattijs'
));

// Get all commits
$all = $client->commits->all('gittyhub');

// Get all commits for a specific branch
$branch = $client->commits->all('gittyhub', 'master');

// Get all commits for a specific path
$file = $client->commits->all('gittyhub', 'master', 'README.md');
