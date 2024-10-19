<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

function getGoogleAutocompleteSuggestions($query) {
    // Encode the query to make it URL-safe
    $query = urlencode($query);
    
    // Construct the URL with the query
    $url = "https://www.google.be/complete/search?q=$query&client=gws-wiz-serp&hl=en-BE";

    // Using cURL to fetch the response
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $response = substr($response, 19, -1);
    //echo $response;
   
    if ($response === false) {
        return [];
    }

    $decodedString = html_entity_decode($response);
    $convertedString = mb_convert_encoding($decodedString, 'UTF-8', 'UTF-8');

    // Step 2: Decode JSON
    $array = json_decode($convertedString, true);

    // Check for errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'Error decoding JSON: ' . json_last_error_msg();
        return [];
    } else {
        // Successfully decoded, print the array
        //print_r($array);
        return $array[0];
    }
}

function cleanString($string) {
    // Decode HTML entities
    $string = html_entity_decode($string);
    // Remove special characters using regex (allowing letters, numbers, and spaces)
    return preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
}

// Example usage
$query = isset($_REQUEST['query']) ? $_REQUEST['query'] : '';
$complete = getGoogleAutocompleteSuggestions($query);

foreach ($complete as $item) {
    $suggestion = $item[0];
    $search = strip_tags($suggestion);
    echo "<img src=\"static/images/search.png\"> <a href=\"/search.php?q=$search\">$suggestion</a><br>";
    
}

?>