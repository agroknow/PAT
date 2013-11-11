<?php

require_once 'Zend/Json.php';
global $language;
if (isset($_GET['lang'])) {
    $language = transform_language_id($_GET['lang']);
} elseif (isset($_SESSION['get_language'])) {
    $language = $_SESSION['get_language'];
} else {
    $language = 'en';
}

function Parse($id) {
    global $language;
//echo 'http://' . $_SERVER['SERVER_NAME'] . '' . uri('scorm?verb=GetJson&identifier=scorm:' . $_SERVER['SERVER_NAME'] . '' . uri('') .':'.$id.'');
    //$fileContents= file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '' . uri('jsonplayer?verb=GetJson&identifier=scorm:' . $_SERVER['SERVER_NAME'] . '' . uri('') .':'.$id.'').'');
    $fileContents = @simplexml_load_file('http://' . $_SERVER['SERVER_NAME'] . '' . uri('jsonplayer?verb=GetJson&identifier=scorm:' . $_SERVER['SERVER_NAME'] . '' . uri('') . ':' . $id . '&lang='.$language.'') . '', 'SimpleXMLElement', LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_NOCDATA);
    //var_dump($fileContents); break;	
    //$fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
    //$fileContents = trim(str_replace('"', "'", $fileContents));
    //$simpleXml = simplexml_load_string($fileContents, 'SimpleXMLElement', LIBXML_NOCDATA);
    
    
    /////function in order to get the children of the xml elements in order to have arrays for all elements and for single objects [http://www.binarytides.com/convert-simplexml-object-to-array-in-php/]  
    function xml2array($xml)
{
    $arr = array();
 
    foreach ($xml->children() as $r)
    {
        $t = array();
        if(count($r->children()) == 0)
        {
            $arr[$r->getName()] = strval($r);
        }
        else
        {
            $arr[$r->getName()][] = xml2array($r);
        }
    }
    return $arr;
}
if(isset($_GET['objectsinarrays']) and $_GET['objectsinarrays']==1){
$fileContents = xml2array ($fileContents);
}

    $json = Zend_Json::encode((array)$fileContents, false);
    if(isset($_GET['callback']) and strlen($_GET['callback'])>2){
    $json = $_GET['callback'] . ' (' . $json . ');'; 
    }
    return $json;
}

//
//echo Zend_Json::encode(simplexml_load_string('http://localhost/natural_europe_new/scorm?verb=GetRecord&identifier=scorm:localhost/natural_europe_new/:146'));
echo Parse($exhibit->id);
//echo $exhibit->id;
?>