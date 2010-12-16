<?php
/**
 * Client.php
 *
 * @package     Gittyhub
 * @author      Mattijs Hoitink <mattijs@monkeyandmachine.com>
 * @copyright   Copyright (c) 2010 Mattijs Hoitink
 * @license     The MIT License - https://github.com/mattijs/gittyhub/raw/master/LICENSE
 */

namespace gittyhub;
use \lithium\storage\Cache as Cache,
    \lithium\util\Set as Set,
    \lithium\util\String as String;

/**
 * API client for Github
 * @see http://develop.github.com
 * @uses \lithium\net\Socket
 * @uses \gittyhub\Request
 * @uses \gittyhub\Response
 */
class Client
{
    /**
     * Configuration for the Github Client
     * @var array
     */
    protected $config = array(
        'protocol'  => 'https',
        'host'      => 'github.com',
        'basePath'  => 'api/v2',
        'format'    => 'json',
        'port'      => 443,
        'login'     => '',
        'password'  => '',
        'token'     => true,
        'adapter'   => '\lithium\net\socket\Curl',
        'caching'   => array(
            'enabled'  => false,
            'adapter'  => '\lithium\storage\cache\adapter\File',
            'path'     => '',
            'lifetime' => '+5 minutes',
        )
    );
    
    /**
     * List fully namespaced class names of api extenions
     * @var array[string] string
     */
    public $extensions = array(
        'repository'   => '\gittyhub\extension\Repository',
        'commits'      => '\gittyhub\extension\Commits',
        'organization' => '\gittyhub\extension\Organization',
    );
    
    /**
     * List of extension instances
     * @var array[] \gittyhub\api\Extension
     */
    protected $instances = array();
    
    /** **/
    
    /**
     * Construct a new Github Client
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->configure($options);
    }
    
    /**
     * Configure the Github client
     * @param array $options    Array containing configuration options
     * @return array            The updated configuration
     */
    public function configure(array $options)
    {
        // Update configuration array
        $this->config = Set::merge($this->config, $options);
        
        // Check for caching configuration
        if (false !== $this->config('caching.enabled', false)) {
            $cachePath = $this->config('caching.path');
            if (empty($cachePath)) {
                throw new \Exception('Caching is enabled but no path is configured');
            }
            Cache::config(array(
                'request' => array(
                    'adapter' => $this->config('caching.adapter'),
                    'path'    => $cachePath,
                    'expiry'  => $this->config('caching.lifetime'),
                )
            ));
        }
        
        return $this->config;
    }
    
    /**
     * Get the complete or part of the Client configuration options. If no key 
     * is provided the complete configuration is returned.
     * If a non-existent key is requested the default value is returned.
     * @param string $key       The key for the requested configuration option
     * @param mixed $default    The default if the key does not exist
     * @return mixed            The configuration option, or the default if the 
     *                          key does not exist
     */
    public function config($key = null, $default = null)
    {
        // Do we need to return the complete config?
        if (null === $key) {
            return $this->config;
        }
        
        // Check if the config key exists with dots
        if (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }
        
        // Check if the config key exists as a path
        $path = '/' . str_replace('.', '/', $key);
        $matches = Set::extract($this->config, $path);
        if (!empty($matches)) {
            return array_shift($matches);
        }
        
        // Return the default, key was not found
        return $default;
    }
    
    /**
     * Send a GET request to the GitHub API. The endpoint is the relative URL 
     * to the API root. The complete path will be build by the Client.
     * @param string $endpoint  The endpoint to contact
     * @return Response         The response received from the GitHub API
     */
    public function get($endpoint)
    {
        // Build the complete path for the endpoint
        $path = $this->buildPath($endpoint);
        
        // Create a new Request
        $request = new Request(array(
            'scheme'   => $this->config('protocol'),
            'host'     => $this->config('host'),
            'port'     => $this->config('port'),
            'path'     => $path,
        ));
        
        // Send the request
        return $this->send($request);
    }
    
    /**
     * Send a POST request to the GitHub API. The endpoint is the relative URL 
     * to the API root. The complete path will be build by the Client. 
     * Data is an array containing the data to set as the POST body. The data is 
     * JSON encoded.
     * @param string $endpoint      The endpoint to contact 
     * @param array $data           The data to send in the POST body
     * @return \gittyhub\Response   The response received from the GitHub API
     */
    public function post($endpoint, array $data = array())
    {
        // Prepare path and data
        $path = $this->buildPath($endpoint);
        $data = \json_encode($data);
        
        // Build the request for the POST
        $request = new Request(array(
            'scheme'   => $this->config('protocol'),
            'host'     => $this->config('host'),
            'port'     => $this->config('port'),
            'path'     => $path,
            'method'   => 'POST',
            'headers'  => array(
                'Content-Type' => 'application/json'
            ),
            'body' => array(
                $data
            )
        ));
        
        // Send the request
        return $this->send($request);
    }
    
    /**
     * Send a PUT request to the GitHub API. The endpoint is the relative URL 
     * to the API root. The complete path will be build by the Client. 
     * Data is an array containing the data to set as the POST body. The data is 
     * JSON encoded.
     * @param string $endpoint      The endpoint to contact 
     * @param array $data           The data to send in the POST body
     * @return \gittyhub\Response   The response received from the GitHub API
     */
    public function put($endpoint, array $data = array())
    {
        // Prepare path and data
        $path = $this->buildPath($endpoint);
        $data = \json_encode($data);
        
        // Build the request for the PUT
        $request = new Request(array(
            'scheme'   => $this->config('protocol'),
            'host'     => $this->config('host'),
            'port'     => $this->config('port'),
            'path'     => $path,
            'method'   => 'PUT',
            'headers'  => array(
                'Content-Type' => 'application/json'
            ),
            'body' => array(
                $data
            )
        ));
        
        // Send the request
        $this->send($request);
    }
    
    /**
     * Send a PUT request to the GitHub API. The endpoint is the relative URL 
     * to the API root. The complete path will be build by the Client. 
     * @param string $endpoint      The endpoint to contact 
     * @return \gittyhub\Response   The response received from the GitHub API
     */
    public function delete($endpoint)
    {
        // Build the path
        $path = $this->endpoint($endpoint);
        
        // Build the request for the DELETE
        $request = new Request(array(
            'scheme'   => $this->config('protocol'),
            'host'     => $this->config('host'),
            'port'     => $this->config('port'),
            'path'     => $path,
            'method'   => 'DELETE',
        ));
        
        // Send the request
        $this->send($request);
    }
    
    /**
     * Build a complete path to the API for an endpoint
     * @param string $endpoint  The endpoint for the path
     * @return string           The complete path
     */
    public function buildPath($endpoint)
    {
        $path = String::insert(
            '/{:base}/{:format}/{:endpoint}',
            array (
                'base'     => ltrim($this->config('basePath'), '/'),
                'format'   => $this->config('format', 'json'),
                'endpoint' => ltrim($endpoint, '/'),
            )
        );
        return $path;
    }
    
    /**
     * Send a request to the Github API and return the Response
     * @param Request $request
     * @return Response
     */
    protected function send(Request $request)
    {
        // Generate request fingerprint
        $cacheKey = \sha1($request->to('url'));
        
        // Check if caching is enabled
        if (false !== $this->config('caching.enabled', false)) {
            $cached = Cache::read('request', $cacheKey);
            if (null !== $cached && false !== $cached) {
                // Load the cached result
                return new \gittyhub\Response(array(
                    'message' => $cached
                ));
            }
        }
        
        // Handle request authentication
        $request->auth(
            $this->config('login', null),
            $this->config('password', null),
            $this->config('token', true)
        );
        
        // Create a new adapter for sending the request
        $adapterClass = $this->config('adapter');
        $adapter = new $adapterClass(array(
            'scheme' => $this->config('protocol'),
            'host'   => $this->config('host'),
            'port'   => $this->config('port'),
        ));
        $adapter->timeout(30);
        
        // Use the adapter to send the Request
        $adapter->open();
        $response = $adapter->send($request, array(
            'response' => '\gittyhub\Response'
        ));
        $adapter->close();
        
        // Destroy the adapter
        unset($adapter);
        
        // Check the response
        if (null === $response || false === $response) {
            throw new \Exception("Could not complete the request to '{$request->to('url')}'");
        }
        
        // Check if the response needs to be cached
        if (false !== $this->config('caching.enabled', false)) {
            // Reconstruct the HTTP response message
            $message = implode("\r\n", $response->headers()) . "\r\n\r\n" . $response->body();
            Cache::write('request', $cacheKey, $message);
        }
        
        // Return the response
        return $response;
    }
    
    /**
     * Return the API extension if it extists
     * @param string $name
     */
    protected function extension($name)
    {
        // Check if an instance is available
        if (array_key_exists($name, $this->instances)) {
            return $this->instances[$name];
        }
        
        // Check if the extension is registered
        if (array_key_exists($name, $this->extensions)) {
            // Create a new instance
            $class = $this->extensions[$name];
            $this->instances[$name] = new $class($this);
            
            return $this->instances[$name];
        }
        
        // Extension was not found
        return null;
    }
    
    /**
     * Install a check to search for an extension with the name
     * @param string $name
     */
    public function __get($name)
    {
        // Check if an extension with the name exists
        $extension = $this->extension($name);
        if (null !== $extension) {
            return $extension;
        }
    }
}