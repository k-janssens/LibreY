<?php

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
    echo $response;

    if ($response === false) {
        return []; // Return empty array if there was an error
    }

    $decodedString = html_entity_decode($jsonString);

    // Step 2: Decode JSON
    $array = json_decode($decodedString, true);

    // Check for errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'Error decoding JSON: ' . json_last_error_msg();
    } else {
        // Successfully decoded, print the array
        print_r($array);
    }
}

// Example usage
$query = isset($_REQUEST['query']) ? $_REQUEST['query'] : '';
getGoogleAutocompleteSuggestions($query);


?>