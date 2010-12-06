<?php
/**
 * Request.php
 *
 * @package     Gittyhub
 * @author      Mattijs Hoitink <mattijs@monkeyandmachine.com>
 * @copyright   Copyright (c) 2010 Mattijs Hoitink
 * @license     The MIT License - https://github.com/mattijs/gittyhub/raw/master/LICENSE
 */

namespace gittyhub;

/**
 * Request class for sending calls to the Github API
 */
class Request extends \lithium\net\http\Request
{
    /**
     * Add authentication to the Github API Request
     * @param string $login
     * @param string $password
     * @param boolean $token
     */
    public function auth($login, $password, $token = false)
    {
        if (!empty($login) && !empty($password)) {
            // Check if we need to use a token or the real password
            if (false !== $token) {
                $login .= '/token';
            }
            $this->headers('Authorization', 'Basic ' . base64_encode("{$login}:{$password}"));
        }
    }
}