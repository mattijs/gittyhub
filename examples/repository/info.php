<?php
/**
 * Some examples of retreiving repository information. Fill in your own 
 * username, password and private repository for the second example.
 * 
 * This script can be called from the commandline from the project root.
 * For example:
 *     php examples/repository/info.php
 */

// Autoloading for examples
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'libraries.php';

// Create a new Client
$client = new \gittyhub\Client();

// Find out some repository information without authentication
$info = $client->repository->info('gittyhub', 'mattijs');
$repository = (array) $info->decoded()->repository;

foreach ($repository as $key => $value) {
    echo str_pad($key, 15) . ': ' . $value . "\n";
}

// Reconfigure the client to authenticate and retreive private repository information
$client->configure(array(
    'login'    => 'USERNAME',    // The username to authenticate with
    'password' => 'TEH_S3CRET',  // The password for authentication
    'token'    => true,          // If the password is a token
));

$info = $client->repository->info('private_repository_name');
$privateRepository = (array) $info->decoded()->repository;

foreach ($privateRepository as $key => $value) {
    echo str_pad($key, 15) . ': ' . $value . "\n";
}