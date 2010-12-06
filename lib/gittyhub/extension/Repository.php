<?php
/**
 * Repository.php
 *
 * @package     Gittyhub
 * @subpackage  Extension
 * @author      Mattijs Hoitink <mattijs@monkeyandmachine.com>
 * @copyright   Copyright (c) 2010 Mattijs Hoitink
 * @license     The MIT License - https://github.com/mattijs/gittyhub/raw/master/LICENSE
 */

namespace gittyhub\extension;
use \gittyhub\Extension as Extension;

/**
 * Implementation of the Github Repository API
 * @see http://develop.github.com/p/repo.html
 */
class Repository extends Extension
{
    /**
     * Repository API endpoints, relative to the API base URL
     * @var array
     */
    public $endpoints = array (
        'search'        => 'repos/search/:q',
        'all'           => 'repos/show/:user',
        'info'          => 'repos/show/:user/:repo',
        'collaborators' => 'repos/show/:user/:repo/collaborators',
        'contributors'  => 'repos/show/:user/:repo/contributors',
        'watchers'      => 'repos/show/:user/:repo/watchers',
        'network'       => 'repos/show/:user/:repo/network',
        'languages'     => 'repos/show/:user/:repo/languages',
        'tags'          => 'repos/show/:user/:repo/tags',
        'branches'      => 'repos/show/:user/:repo/branches',
        'keys'          => 'repos/keys/:user/:repo',
    );
    
    /** **/
    
    /**
     * Search repositories. The query is url encoded.
     * @param string $query
     * @return mixed
     */
    public function search($query)
    {
        $endpoint = $this->endpoint('search', array(
            'q' => url_encode($query),
        ));
        
        // Send a request to the Github API
        $response = $this->client->request($endpoint);
        
        return $response;
    }
    
    /**
     * Show repository information. The repository name is mandatory, the user 
     * is optional. If no user is specified the configured user from the Client 
     * will be used.
     * @param string $repository
     * @param string $user
     * @return mixed
     */
    public function info($repository, $user = null)
    {
        $endpoint = $this->endpoint('info', array(
            'user' => $user ?: $this->client->config('login'),
            'repo' => $repository,
        ));
        
        // Send a request to the Github API
        $response = $this->client->request($endpoint);
        
        return $response;
    }
    
    /**
     * List all repositories for a user.
     * If no user is specified the configured user from the Client will be used.
     * @param string $user
     * @return mixed
     */
    public function all($user = null)
    {
        $endpoint = $this->endpoint('all', array(
            'user' => $user ?: $this->client->config('login'),
        ));
        
        // Send a request to the Github API
        $response = $this->client->request($endpoint);
        
        return $response;
    }
    
    public function collaborators($repository, $user = null)
    {
        $endpoint = $this->endpoint('collaborators', array(
            'user' => $user ?: $this->client->config('login'),
            'repo' => $repository,
        ));
        
        // Send a request to the Github API
        $response = $this->client->request($endpoint);
        
        return $response;
    }
    
    public function contributers($repository, $user = null)
    {
        $endpoint = $this->endpoint('contributors', array(
            'user' => $user ?: $this->client->config('login'),
            'repo' => $repository,
        ));
        
        // Send a request to the Github API
        $response = $this->client->request($endpoint);
        
        return $response;
    }
    
    public function watchers($repository, $user = null)
    {
        $endpoint = $this->endpoint('watchers', array(
            'user' => $user ?: $this->client->config('login'),
            'repo' => $repository,
        ));
        
        // Send a request to the Github API
        $response = $this->client->request($endpoint);
        
        return $response;
    }
    
    public function network($repository, $user = null)
    {
        $endpoint = $this->endpoint('network', array(
            'user' => $user ?: $this->client->config('login'),
            'repo' => $repository,
        ));
        
        // Send a request to the Github API
        $response = $this->client->request($endpoint);
        
        return $response;
    }
    
    public function languages($repository, $user = null)
    {
        $endpoint = $this->endpoint('languages', array(
            'user' => $user ?: $this->client->config('login'),
            'repo' => $repository,
        ));
        
        // Send a request to the Github API
        $response = $this->client->request($endpoint);
        
        return $response;
    }
    
    /**
     * Show repository tags. The repository name is mandatory, the user name is 
     * optional. If no user is specified the configured user from the Client 
     * will be used.
     * @param string $repository
     * @param string $user
     * @return mixed
     */
    public function tags($repository, $user = null)
    {
        $endpoint = $this->endpoint('tags', array(
            'user' => $user ?: $this->client->config('login'),
            'repo' => $repository,
        ));
        
        // Send a request to the Github API
        $response = $this->client->request($endpoint);

        return $response;
    }
    
    public function branches($repository, $user = null)
    {
        $endpoint = $this->endpoint('branches', array(
            'user' => $user ?: $this->client->config('login'),
            'repo' => $repository,
        ));
        
        // Send a request to the Github API
        $response = $this->client->request($endpoint);

        return $response;
    }
    
}