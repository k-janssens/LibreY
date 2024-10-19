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

    if ($response === false) {
        return []; // Return empty array if there was an error
    }

    // Strip out the JSONP function wrapper
    $json = preg_replace('/^.+?\((.+)\);?$/', '$1', $response);

    // Decode the JSON response
    $data = json_decode($json, true);

    if ($data === null) {
        return []; // Return empty array if JSON decoding failed
    }

    // Assuming suggestions are in the first element of the array
    return isset($data[1]) ? $data[1] : [];
}

// Example usage
$query = isset($_REQUEST['query']) ? $_REQUEST['query'] : '';
$suggestions = getGoogleAutocompleteSuggestions($query);

// Display the suggestions
if (!empty($suggestions)) {
    echo "Suggestions for '$query':\n";
    foreach ($suggestions as $suggestion) {
        echo "- " . htmlspecialchars($suggestion) . "\n";
    }
} else {
    echo "No suggestions found.\n";
}
?>