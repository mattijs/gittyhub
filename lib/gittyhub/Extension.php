<?php
/**
 * Extension.php
 *
 * @package     Gittyhub
 * @author      Mattijs Hoitink <mattijs@monkeyandmachine.com>
 * @copyright   Copyright (c) 2010 Mattijs Hoitink
 * @license     The MIT License
 */

namespace gittyhub;
use \lithium\util\String as String;

/**
 * Github API extension
 * @uses \lithium\util\String
 */
abstract class Extension
{
    /**
     * The Client the Extension was instantiated by
     * @var Client
     */
    protected $client = null;
    
    /** **/
    
    /**
     * Construct a new Extension
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    /**
     * Get a configured endpoint with inserted parameters
     * @param string $name          The name of the registered endpoint
     * @param array $parameters     The parameters to insert into the endpoint
     * @throws Exception            If endpoint is not registered
     * @return string               The formatted endpoint
     */
    public function endpoint($name, array $parameters = array())
    {
        // Check if the endpoint exists
        if (!array_key_exists($name, $this->endpoints)) {
            throw new \Exception("Endpoint '{$name}' is not configured");
        }
        
        // Get the endpoint
        $endpoint = $this->endpoints[$name];
        
        // Insert parameters into the endpoint
        $endpoint = String::insert($endpoint, $parameters, array(
            'before' => ':',
            'after'  => '',
        ));
        
        // Return the parsed endpoint
        return $endpoint;
    }
}