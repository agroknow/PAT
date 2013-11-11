<?php

session_start();
/*    require_once("./custom/include/db_connect.php");  

  $path_db="./db.ini";
  db_connect($path_db); */
global $language;
if (isset($_GET['lang'])) {
            $language = transform_language_id($_GET['lang']);
        } else {
            $language = 'en';
        } 
        
require_once('functions.php');
require_once('common.php');

if (isset($args['verb'])) {
    switch ($args['verb']) {


        case 'GetJson':

            include 'scorm2/getjson.php';
            break;
        case 'Search':

            include 'scorm2/listidentifiers.php';
            break;

        default:
            // we never use compression with errors
            $compress = FALSE;
            $errors .= oai_error('badVerb', $args['verb']);
    } /* switch */
} else {
    $errors .= oai_error('noVerb');
    $args['verb'] = '';
}



//header($CONTENT_TYPE);
    echo $xmlheader;
    echo $output;
    echo $errors;
        scorm_close();


?>


