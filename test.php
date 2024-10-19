<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        return [];
    }

    $decodedString = html_entity_decode($response);

    // Step 2: Decode JSON
    $array = json_decode($decodedString, true);

    // Check for errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        //echo 'Error decoding JSON: ' . json_last_error_msg();
        return [];
    } else {
        // Successfully decoded, print the array
        //print_r($array);
         return $array[0];
    }
}

// Example usage
$query = isset($_REQUEST['query']) ? $_REQUEST['query'] : '';
$complete = getGoogleAutocompleteSuggestions($query);

foreach ($complete as $item) {
    // Access the first element, which is the suggestion
    $suggestion = $item[0];
    // Access the count (the second element)
    $count = $item[1];
    // Access the IDs (the third element)
    $ids = $item[2];
    // Access additional details (the fourth element)
    $details = $item[3];

    // Output the suggestion and details
    echo "Suggestion: " . htmlspecialchars($suggestion) . "<br>";
    echo "Count: " . $count . "<br>";
    echo "IDs: " . implode(", ", $ids) . "<br>";
    echo "Details:<br>";
    echo "- Name: " . htmlspecialchars($details['zh']) . "<br>";
    echo "- Company: " . htmlspecialchars($details['zi']) . "<br>";
    echo "- gs_ssp: " . htmlspecialchars($details['zp']['gs_ssp']) . "<br>";
    echo "<br>"; // Just for better separation in output
}

?>