<?php

namespace BaseApp\Validator;

/**
 * Class TokenValidator
 *
 * validate token and clients IP using token config file,
 * collect errors into array and set result as true if IP and token are correct
 * or false in another case
 *
 * @author kuuerusa@gmail.com
 */

class TokenValidator
{
    /**
     * Location of config token file
     * 
     * @var string
     */
    private $filePath;

    /**
     * data from config token file
     * 
     * @var array
     */
    private $arrayFromFile = array();

    /**
     * token
     * 
     * @var string
     */
    private $token;

    /**
     * Clients IP address
     * 
     * @var string
     */
    private $ip;

    /**
     * List of allowed IP
     * 
     * it is the part of content of config token file
     * 
     * @var string
     */
    private $_allowedIps;

    /**
     * Checker for IP
     * 
     * true if IP of client exixts in the allowed list
     * @var bool
     */
    public $result;

    /**
     * array of errors
     * 
     * @var array
     */
    private $errors;

    /**
     * Constructor for Token validator
     * 
     * @param string $ip
     * @param string $token
     */
    public function __construct(string $token, string $ip)
    {
        $this->errors = array();
        $this->result = false;
        $this->setToken($token);
        $this->setIp($ip);
        $this->setFilePath();
        $this->setArrayFromFile();
        $this->setResult();
    }

    /**
     * Setter for token config file location
     */
    private function setFilePath()
    {
        $this->filePath = $_SERVER["DOCUMENT_ROOT"] . "codebase/commons/config/token.json";
    }

    /**
     * Setter for token config file 
     */
    private function setArrayFromFile()
    {
        $content = file_get_contents($this->filePath);
        $this->arrayFromFile = json_decode($content, true);
    }

    /**
     * Setter for token 
     * 
     * @param string $token
     */
    private function setToken(string $token)
    {
        $this->token = $token;
    }

    /**
     * Setter for IP
     * @param string $ip
     */
    private function setIp(string $ip)
    {
        $this->ip = $ip;
    }

    /**
     * Setter for allowed IPs
     * Set list of IP allowed for the given token
     */
    private function setAllowedIps()
    {
        $this->_allowedIps = $this->arrayFromFile[$this->token];
    }

    /**
     * Token validator
     * 
     * check config file for presence of given token
     * return true if exist,
     * another case send a message about wrong token as parameter to errors setter
     * and return false
     * 
     * @return bool
     */
    private function validateToken()
    {
        if (isset($this->arrayFromFile[$this->getter('token')])) {
            $this->setAllowedIps();
            return true;
        } else {
            $this->setErr("token not valid");
            return false;
        }
    }

    /**
     * Setter for result
     * 
     * Set result as true if token and IP are validated,
     * another case don't change value of result (it is false by default)
     */
    private function setResult()
    {
        if ($this->validateToken()) {
            $this->setAllowedIps();
            if ($this->validateIP()) {
                $this->result = true;
            }
        }
    }

    /**
     * IP validator
     * 
     * This function check if given IP is included to list of allowed IPs
     * if IP is correct returns true,
     * another case send a message about wrong IP to setter of errors list
     * and return false
     * 
     * @return bool
     */
    private function validateIP()
    {
        if (strpos($this->_allowedIps, $this->ip) !== false) {
            return true;
        } else {
            $this->setErr('IP NOT ALLOWED');
            return false;
        }
    }

    /**
     * Universal getter function
     * 
     * @param string $var
     * @return $var - may be of different type, depends on on constructor
     */
    function getter($var)
    {
        return $this->$var;
    }

    /**
     * Set array of errors
     * 
     * this function collect array of errors, pushing each error into array
     * 
     * @param string $error - text message of error
     */
    private function setErr($error)
    {
        $this->errors[] = $error;
    }
}
