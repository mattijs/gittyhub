<?php
/**
 * Commits.php
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
 * @see http://develop.github.com/p/commits.html
 */
class Commits extends Extension
{
    /**
     * Commits API endpoints, relative to the API base URL
     * @var array
     */
    public $endpoints = array (
        'all'    => 'commits/list/:user_id/:repository/:branch/:path',
        'single' => 'commits/show/:user_id/:repository/:sha',
    );
    
    /** **/
    
    /**
     * Show all commits from a branch or a specific file. The repository name is 
     * mandatory, The other parameters are optional. 
     * The branch name defaults to 'master' and the path defaults to the branch 
     * root. If no path is supplied all commits from the entire branch will be 
     * returned. If no user is provided the configured login from the Client 
     * will be used.
     * @param string $repository    The name of the repository to contact
     * @param string $branch        The name of the branche to check
     * @param string $user          The name of the repository owner
     * @return Response             The response received from the Github API
     */
    public function all($repository, $branch = 'master', $path = '', $user = null)
    {
        $endpoint = $this->endpoint('all', array(
            'user_id'    => $user ?: $this->client->config('login'),
            'repository' => $repository,
            'branch'     => $branch,
            'path'       => ltrim($path, '/'),
        ));
        
        $response = $this->client->get($endpoint);
        
        return $response;
    }
    
    /**
     * Show a single commit. The user parameter is optional, if no user is 
     * provided the configured login from the Client will be used.
     * @param string $repository    The name of the repository to contact
     * @param string $sha           The hash for the commit to show
     * @param string $user          The owner of the repository
     * @return Response             The response received from the Github API
     */
    public function show($repository, $sha, $user = null)
    {
        $endpoint = $this->endpoint('single', array(
            'user_id'    => $user ?: $this->client->config('login'),
            'repository' => $repository,
            'sha'        => $sha,
        ));
        
        $response = $this->client->get($endpoint);
        
        return $response;
    }
}