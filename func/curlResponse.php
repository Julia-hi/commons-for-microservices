<?php
/**
 * This is part of commons for our microservices
 * @author kuuerusa@gmail.com
 */

/**
 * Function makes curl request to required URL
 * location: codebase/commons/func/curlResponse.php
 * @param string $listenerURL
 * @param string $postParameter
 * 
 */

    $curlHandle = curl_init($listenerURL);
    curl_setopt($curlHandle, CURLOPT_POST, true);
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($postParameter));
    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
    $curlResponse = curl_exec($curlHandle);
    curl_close($curlHandle);
    