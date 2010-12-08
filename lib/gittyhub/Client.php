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
use \lithium\util\String as String;

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
    );
    
    /**
     * List fully namespaced class names of api extenions
     * @var array[string] string
     */
    public $extensions = array(
        'repository' => '\gittyhub\extension\Repository',
        'commits'    => '\gittyhub\extension\Commits',
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
        $this->config = $options + $this->config;
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
        
        // Check if the config key exists
        if (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }
        
        // Return the default, key was not found
        return $default;
    }
    
    /**
     * Request a part of the Github API. Only the endpoint of the API section 
     * has to be provided. All other configuration is done by the Client, like 
     * the bas url, protocol, port and authorisation. This has to be configured 
     * in advance.
     * @param string $endpoint
     * @return Response
     */
    public function request($endpoint)
    {
        // Build the path
        $path = String::insert(
            '/{:base}/{:format}/{:endpoint}',
            array (
                'base'     => ltrim($this->config('basePath'), '/'),
                'format'   => $this->config('format', 'json'),
                'endpoint' => ltrim($endpoint, '/'),
            )
        );
        
        // Create a new Request
        $request = new Request(array(
            'scheme'   => $this->config('protocol'),
            'host'     => $this->config('host'),
            'port'     => $this->config('port'),
            'path'     => $path,
        ));
        
        // Handle authentication
        $request->auth(
            $this->config('login', null),
            $this->config('password', null),
            $this->config('token', false)
        );
        
        // Send the request
        return $this->send($request);
    }
    
    /**
     * Send a request to the Github API and return the Response
     * @param Request $request
     * @return Response
     */
    protected function send(Request $request)
    {
        // Create a new adapter for sending the request
        $adapterClass = $this->config('adapter');
        $adapter = new $adapterClass(array(
            'scheme' => $this->config('protocol'),
            'host'   => $this->config('host'),
            'port'   => $this->config('port'),
        ));
        
        // Use the adapter to send the Request
        $adapter->open();
        $response = $adapter->send($request, array(
            'response' => '\gittyhub\Response'
        ));
        $adapter->close();
        
        // Destroy the adapter
        unset($adapter);
        
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