<?php
/**
 * Organization.php
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
 * Gittyhub extension for interaction with the Github Organization API
 * @see http://develop.github.com/p/orgs.html
 */
class Organization extends Extension
{
    /**
     * Organization API endpoints, relative to the API base URL
     * @var array
     */
    public $endpoints = array (
        // General Organization API endpoints
        'org_info'                 => '/organizations/:org',
        'org_members'              => '/organizations/:org/members',
        'org_repositories'         => '/organizations/:org/repositories',
        'org_members_public'       => '/organizations/:org/public_members',
        'org_repositories_public'  => '/organizations/:org/public_repositories',
        'org_teams'                => '/organizations/:org/teams',
        // Organization API Team endpoints
        'team_info'                => '/teams/:team_id',
        'team_members'             => '/teams/:team_id/members',
        'team_repositories'        => '/teams/:team_id/repositories',
        // Other Organization API endpoints
        'user_memberships'         => '/user/show/:user/organizations',
        'own_memberships'          => '/organizations',
        'all_repos'                => '/organizations/repositories',
    );
    
    /** **/
    
    /**
     * Retreive information about an organization.
     * @param string $organization  The name of the Organization to look up
     * @return \gittyhub\Response   The response received from the Github API
     */
    public function info($organization)
    {
        $endpoint = $this->endpoint('org_info', array(
            'org' => $organization,
        ));
        
        $response = $this->client->request($endpoint);
        
        return $response;
    }
    
    /**
     * Retreive public members from an Organization. 
     * @param string $organization  The name of the Organization to look up
     * @return \gittyhub\Response   The response received from the Github API
     */
    public function members($organization, $public = true)
    {
        $endpoint = $this->endpoint('org_members', array(
            'org' => $organization
        ));
        
        $response = $this->client->request($endpoint);
        
        return $response;
    }
    
    /**
     * Retreive public repositories for an Organization
     * @param string $organization  The name of the Organization to look up
     * @return \gittyhub\Response   The response received from the Github API
     */
    public function repositories($organization, $public = true)
    {
        $endpoint = $this->endpoint('org_repositories', array(
            'org' => $organization,
        ));
        
        $response = $this->client->request($endpoint);
        
        return $response;
    }
    
    /**
     * Retreive teams for an Organization
     * @param string $organization  The name of the Organization to look up
     * @return \gittyhub\Response   The response received from the Github API
     */
    public function teams($organization)
    {
        $endpoint = $this->endpoint('org_teams', array(
            'org' => $organization
        ));
        
        $response = $this->client->request($endpoint);
        
        return $response;
    }
    
    /**
     * Show the Organization memberships for a user. If no user is provided the 
     * configured login from the Client will be used.
     * @param string $user          The user to retreive the memberships for
     * @return \gittyhub\Response   The reponse received from the Github API
     */
    public function userMemberships($user = null)
    {
        $endpoint = $this->endpoint('user_membership', array(
            'user' => $user ?: $this->client->config('login')
        ));
        
        $response = $this->client->request($endpoint);
        
        return $response;
    }
}
