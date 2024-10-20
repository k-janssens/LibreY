<?php require_once "locale/localization.php";
      $GLOBALS["opts"] = require_once "config.php";

    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);
 ?>

<!DOCTYPE html >
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta charset="UTF-8"/>
        <meta name="description" content="A privacy respecting meta search engine."/>
        <meta name="referrer" content="no-referrer"/>
        <link rel="stylesheet" type="text/css" href="static/css/styles.css"/>
        <link rel="stylesheet" type="text/css" href="static/css/google.css">
        <link title="<?php printtext("page_title"); ?>" type="application/opensearchdescription+xml" href="opensearch.xml?method=POST" rel="search"/>
        <script src="static/css/jquery-3.6.0.min.js"></script>
        <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">


        
        
