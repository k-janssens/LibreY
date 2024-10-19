<?php

// The URL to fetch the autocomplete suggestions
$url = "https://www.google.be/complete/search?q=bmw&cp=3&client=gws-wiz-serp&xssi=t&gs_pcrt=undefined&hl=en-BE&authuser=0&pq=can%20I%20use%20google%20autocomplete%20suggestions&psi=QfQTZ_7NLtWikdUPqvCR8Qk.1729360962195&dpr=1";

// Function to fetch and parse Google Autocomplete suggestions
function getGoogleAutocompleteSuggestions($url) {
    // Using file_get_contents (ensure allow_url_fopen is enabled in php.ini)
    // $response = file_get_contents($url);

    // Alternatively, using cURL (recommended for better error handling)
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    echo "response::".$response;
    curl_close($ch);

    if ($response === false) {
        return []; // Return empty array if there was an error
    }

    // Strip out the JSONP function wrapper
    // Example of response: google.ac.h(a, b) => [suggestions]
    $json = preg_replace('/^.+?\((.+)\);?$/', '$1', $response);

    echo "json::".$json;

    // Decode the JSON
    $data = json_decode($json, true);

    echo "data::".$data;

    if ($data === null) {
        return []; // Return empty array if JSON decoding failed
    }

    // Assuming suggestions are in the first element of the array
    return isset($data[1]) ? $data[1] : [];
}

// Get suggestions
$suggestions = getGoogleAutocompleteSuggestions($url);

// Display the suggestions
if (!empty($suggestions)) {
    echo "Suggestions for 'bmw':\n";
    foreach ($suggestions as $suggestion) {
        echo "- " . htmlspecialchars($suggestion) . "\n";
    }
} else {
    echo "No suggestions found.\n";
}
?>
