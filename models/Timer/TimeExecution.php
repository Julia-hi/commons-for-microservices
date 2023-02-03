<?php

namespace BaseApp\Timer;

/**
 * Class TimerExecution
 * Calculate time of execution from sending request and geting response
 * This is part of commons for our microservices
 * 
 * location: commons/models/Timer/TimeExecution.php
 * 
 * @author kuuerusa@gmail.com
 */

class TimeExecution
{

    /**
     * Initial time of process
     * @var float
     */
    private $startTime;

    /**
     * Final time of process
     * @var float
     */
    private $endTime;

    /**
     * Execution time of process
     * @var float
     */
    private $executionTime;

    /**
     * constructor for TimerExecution
     * @param float $startTime
     * @param float $endTime
     */
    public function __construct(float $startTime, float $endTime)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->setExecutionTime();
    }

    /**
     * setter for execution time
     * Calculate execution time in miliseconds, rounded to 6 digits
     */
    private function setExecutionTime()
    {
        $this->executionTime = round($this->endTime - $this->startTime, 6);
    }

    /**
     * Universal getter
     * @param string $var
     * @return $val - value of variable type, depended on constructor
     */
    public function getter(string $var)
    {
        return $this->$var;
    }
}
