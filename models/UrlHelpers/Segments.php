<?php

namespace BaseApp\UrlHelpers;

/**
 * class Segments
 * This is part of commons for our microservices
 *
 * $_counterSegments = number of segments in the url
 *
 * Example URL: https://<domain_name.com/service/../../../../../token
 * 
 * @author kuuerusa@gmail.com
 *
 **/
class Segments
{
    /**
     * URL in array format
     * 
     * @var array
     */
    private $_url = array();

    /**
     * Number of segments in the url
     * excluding the protocol and root domain
     * 
     * @var int $_counterSegments
     */
    private $_counterSegments;

    /**
     * Name of microservice 
     * the segments after protocol and root domain
     * 
     * @var string $_microService
     */
    private $_microService;

    /**
     * Location of config json file for microservice
     * it always must locate in <name_mi croservice>/config/microServiceConfigFile.json
     * @var string $_microServiceConfigFile
     */
    private $_microServiceConfigFile;

    /**
     * Constructor for Segments
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->set_url($url);
        $this->set_counterSegments();
        $this->set_microService();
        $this->set_microServiceConfigFile();
    }

    /**
     * Setter for URL segments 
     * 
     * creates array from url requiest
     * @param string $url
     */
    private function set_url(string $url)
    {
        $this->_url = explode("/", parse_url($url, PHP_URL_PATH));
    }

    /**
     * Setter for counter of segments
     * count number of segments after domain name
     */
    private function set_counterSegments()
    {
        $this->_counterSegments = (count($this->_url) - 1);
    }

    /**
     * Setter for name of misroservice
     * 
     * microservice locates inside the folder
     * in our case /codebase/<microservice_name>/...
     * it will be the second segment of array
     */
    private function set_microService()
    {
        $this->_microService = $this->_url[1];
    }

    /**
     * Setter for location of config file.
     * Folder of microservice must locates inside the codebase folder,
     * config file must have the same name of microservice
     * Config json file in folder codebase/<microservice_name>/config/<microservice_name.json>
     */
    private function set_microServiceConfigFile()
    {
        $this->_microServiceConfigFile = $_SERVER['DOCUMENT_ROOT'] . 'codebase/' . $this->_microService . '/config/' . $this->_microService . '.json';
    }

    /**
     * Getter for microservice config file location
     *
     * @return string
     */
    public function getMicroserviceConfigfile()
    {
        return $this->_microServiceConfigFile;
    }

    /**
     * Getter for microservice name
     * 
     * @return string
     */
    public function getMicroservice()
    {
        return $this->_microService;
    }

    /**
     * Getter for particular segment
     * 
     * Return segment of required position in string format
     * 
     * @param int
     * @return string
     */
    public function get_segment($n)
    {
        return $this->_url[$n];
    }

    /**
     * Getter for counter of segments
     * 
     * Return number of urls segments
     * 
     * @return int
     */
    function get_counterSegments()
    {
        return $this->_counterSegments;
    }
}
