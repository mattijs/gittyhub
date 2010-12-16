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
 * Gittyhub extension for interaction with the Github Repository API
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
     * Search repositories. The search query is url encoded before sending it to 
     * the Github API.
     * @param string $query The search query
     * @return Response     The response received from the Github API
     */
    public function search($query)
    {
        $endpoint = $this->endpoint('search', array(
            'q' => url_encode($query),
        ));
        
        $response = $this->client->get($endpoint);
        
        return $response;
    }
    
    /**
     * Show repository information. The repository name is mandatory, the user 
     * is optional. If no user is specified the configured login from the Client 
     * will be used.
     * @param string $repository    The repository to contact
     * @param string $user          The owner of the repository
     * @return Response             The response received from the Github API
     */
    public function info($repository, $user = null)
    {
        $endpoint = $this->endpoint('info', array(
            'user' => $user ?: $this->client->config('login'),
            'repo' => $repository,
        ));
        
        $response = $this->client->get($endpoint);
        
        return $response;
    }
    
    /**
     * List all repositories for a user. The user is optional. If no user is 
     * specified the configured login from the Client will be used.
     * @param string $user  The user to list the repositories for
     * @return Response     The response reveived from the Github API
     */
    public function all($user = null)
    {
        $endpoint = $this->endpoint('all', array(
            'user' => $user ?: $this->client->config('login'),
        ));
        
        $response = $this->client->get($endpoint);
        
        return $response;
    }
    
    /**
     * Show collaborators for a repository. The repository name is mandatory, 
     * the user is optional. If no user is specified the configured login from 
     * the Client will be used.
     * @param string $repository    The repository to contact
     * @param string $user          The owner of the repository
     * @return Response             The response received from the Github API
     */
    public function collaborators($repository, $user = null)
    {
        $endpoint = $this->endpoint('collaborators', array(
            'user' => $user ?: $this->client->config('login'),
            'repo' => $repository,
        ));
        
        $response = $this->client->get($endpoint);
        
        return $response;
    }
    
    /**
     * Show contributers for a repository. The repository name is mandatory, 
     * the user is optional. If no user is specified the configured login from 
     * the Client will be used.
     * @param string $repository    The repository to contact
     * @param string $user          The owner of the repository
     * @return Response             The response received from the Github API
     */
    public function contributers($repository, $user = null)
    {
        $endpoint = $this->endpoint('contributors', array(
            'user' => $user ?: $this->client->config('login'),
            'repo' => $repository,
        ));
        
        $response = $this->client->get($endpoint);
        
        return $response;
    }
    
    /**
     * Show watchers for a repository. The repository name is mandatory, the 
     * user is optional. If no user is specified the configured login from the 
     * Client will be used.
     * @param string $repository    The repository to contact
     * @param string $user          The owner of the repository
     * @return Response             The response received from the Github API
     */
    public function watchers($repository, $user = null)
    {
        $endpoint = $this->endpoint('watchers', array(
            'user' => $user ?: $this->client->config('login'),
            'repo' => $repository,
        ));
        
        $response = $this->client->get($endpoint);
        
        return $response;
    }
    
    /**
     * Show the network for a repository. The repository name is mandatory, the 
     * user is optional. If no user is specified the configured login from the 
     * Client will be used.
     * @param string $repository    The repository to contact
     * @param string $user          The owner of the repository
     * @return Response             The response received from the Github API
     */
    public function network($repository, $user = null)
    {
        $endpoint = $this->endpoint('network', array(
            'user' => $user ?: $this->client->config('login'),
            'repo' => $repository,
        ));
        
        $response = $this->client->get($endpoint);
        
        return $response;
    }
    
    /**
     * Show the languages used in a repository. The repository name is mandatory, 
     * the user is optional. If no user is specified the configured login from 
     * the Client will be used.
     * @param string $repository    The repository to contact
     * @param string $user          The owner of the repository
     * @return Response             The response received from the Github API
     */
    public function languages($repository, $user = null)
    {
        $endpoint = $this->endpoint('languages', array(
            'user' => $user ?: $this->client->config('login'),
            'repo' => $repository,
        ));
        
        $response = $this->client->get($endpoint);
        
        return $response;
    }
    
    /**
     * Show the tags for a repository. The repository name is mandatory, the 
     * user is optional. If no user is specified the configured login from the 
     * Client will be used.
     * @param string $repository    The repository to contact
     * @param string $user          The owner of the repository
     * @return Response             The response received from the Github API
     */
    public function tags($repository, $user = null)
    {
        $endpoint = $this->endpoint('tags', array(
            'user' => $user ?: $this->client->config('login'),
            'repo' => $repository,
        ));
        
        $response = $this->client->get($endpoint);

        return $response;
    }
    
    /**
     * Show the branches for a repositury. The repository name is mandatory, the 
     * user is optional. If no user is specified the configured login from the 
     * Client will be used.
     * @param string $repository    The repository to contact
     * @param string $user          The owner of the repository
     * @return Response             The response received from the Github API
     */
    public function branches($repository, $user = null)
    {
        $endpoint = $this->endpoint('branches', array(
            'user' => $user ?: $this->client->config('login'),
            'repo' => $repository,
        ));
        
        $response = $this->client->get($endpoint);

        return $response;
    }
    
}