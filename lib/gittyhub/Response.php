<?php
/**
 * Response.php
 *
 * @package     Gittyhub
 * @author      Mattijs Hoitink <mattijs@monkeyandmachine.com>
 * @copyright   Copyright (c) 2010 Mattijs Hoitink
 * @license     The MIT License - https://github.com/mattijs/gittyhub/raw/master/LICENSE
 */

namespace gittyhub;

/**
 * Response class for Github API responses
 */
class Response extends \lithium\net\http\Response
{
    /**
     * Returns the shorthand format name of the Response body
     * @return string|boolean  Returns the short name for the body content type,
     *                         or FALSE when the type could not be determined.
     */
    public function format()
    {
        switch(strtolower($this->type)) {
            case 'application/json':
                return 'json';
                break;
            case 'application/yaml':
                return 'yaml';
                break;
            case 'application/xml':
            case 'text/xml':
                return 'xml';
                break;
            case 'text/html':
                return 'html';
                break;
            case 'text/plain':
            default:
                return 'text';
        }
    }
    
    /**
     * Returns the decoded Response body
     * @return mixed
     */
    public function decoded()
    {
        $format = $this->format();
        switch($format) {
            case 'json':
                return json_decode($this->body());
            break;
            case 'yaml':
                throw new \Exception('YAML decoding not supported yet, do something with the Symfony 2 Yaml component here (or something)');
            break;
            case 'xml':
                return simplexml_load_string($this->body());
            break;
            case 'html':
            case 'text':
            default:
                return $this->body();
            break;
        }
        
        return false;
    }
}