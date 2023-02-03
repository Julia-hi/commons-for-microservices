<?php
/**
 * This is the part of commons.
 * There is set of functions, variables included to 
 * microservices.
 * 
 * vars.php - Here we declare common variables for our microservices
 * @author kuuerusa@gmail.com
 */


/**
 * Status of the code.
 * 
 * must be "development" or "production"
 * 
 * In developping mode it should be "development",
 * when the API is in production, it should be changed to "production".
 * (in case "development" all developings errors will be desplayed)
 * If we need costume status code for particular microservice - just declare it manualy
 * 
 * @var string $status
 */
$status = "development";

/**
 * Domain name
 * 
 * location of our microservices
 * 
 * @var string
 */
$domainName = 'https://<domain_name.com>';

/**
 * width for error image
 * width for default image from error (in pixels)
 * 
 * @var int
 */
$widthErrorImg = 499;

/**
 * height for error image
 * height for default image from error (in pixels)
 * 
 * @var int
 */
$heightErrorImg = 499;




