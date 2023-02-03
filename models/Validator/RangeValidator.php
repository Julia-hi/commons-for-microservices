<?php

namespace BaseApp\Validator;

/**
 * Class RangeValidator
 * 
 * This is the part of commons for our microservices
 *
 * Here we validate latitude and longitude, zoom, widht and height
 * from json config file of microservice
 * see example: /commons/config/mapper.json
 * if the value is not in range we collect errors into array and the result is false
 *
 * @author kuuerusa@gmail.com
 */
class RangeValidator
{
    /**
     * Set of parameters for validate
     * 
     * @var array $_dataSet
     */
    private $_dataSet = [];

    /**
     * JSON patch
     * 
     * Location of json config file
     * @var string
     */
    private $jsonPath;

    /**
     * Array from JSON
     * 
     * Content of json config file in array format
     * @var array
     */
    private $_arrayFromJson;

    /**
     * Checker for ranges
     * 
     * true if all values are correct
     * false for enother case
     * @var bool
     */
    private $result;

    /**
     * Array of errors
     * 
     * @var array $errors
     */
    private $errors;

    /**
     * Constructor for RangeValidator
     * 
     * @param array $dataSetArray
     * @param string $jsonPath
     */
    public function __construct(array $dataSetArray, string $jsonPath)
    {
        $this->setDataSet($dataSetArray);
        $this->setJsonPath($jsonPath);
        $this->setArrayFromJson();
        $this->errors = array();
        $this->result = $this->validate();
    }

    /**
     * Setter for parameters for validate
     * @param array $dataSetArray
     */
    public function setDataSet(array $dataSetArray)
    {
        $this->_dataSet = $dataSetArray;
    }

    /**
     * Setter for JsonPath
     * Location of json config file
     * @param string $jsonPath
     */
    public function setJsonPath(string $jsonPath)
    {
        $this->jsonPath = $jsonPath;
    }

    /**
     * setter for arrayFromJson
     * Set array of content from json file
     */
    public function setArrayFromJson()
    {
        $jsonString = file_get_contents($this->jsonPath);
        $this->_arrayFromJson = json_decode($jsonString, true);
    }

    /**
     * Range validator for  parameters from json config
     * (lang, long, zoom, width, height)
     */
    public function validate()
    {
        foreach (array_keys($this->_dataSet) as $key) {
            if (
                !$this->checkRange(
                    $this->_dataSet[$key],
                    $this->_arrayFromJson[$key]["min"],
                    $this->_arrayFromJson[$key]["max"]
                )
            )
                $this->set_err($key . " not in range. Must be between " . $this->_arrayFromJson[$key]["min"] . " and " . $this->_arrayFromJson[$key]["max"]);
        }
        if ((count($this->getErrors())) == 0) {
            $this->result = true;
        } else {
            $this->result = false;
        }
        return $this->result;
    }

    /**
     * Universal getter function
     * 
     * @param string $var
     * @return $var
     */
    function getter(string $var)
    {
        return $this->$var;
    }

    /**
     * Range checker
     * 
     * this function validates actual value with limits of value,
     * return true if actual value is validated, another way returns false
     * 
     * @param string $actualValue
     * @param string $minValue
     * @param string $maxValue
     * @return bool
     */
    private function checkRange(string $actualValue, string $minValue, string $maxValue)
    {
        if ($actualValue >= $minValue && $actualValue <= $maxValue) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set array of errors
     * 
     * this function collect array of errors, pushing each error into array
     * 
     * @param string $error - text message of error
     */
    private function set_err(string $error)
    {
        $this->errors[] = $error;
    }

    /**
     * Getter for errors
     * @return array 
     */
    function getErrors()
    {
        return $this->errors;
    }
}
