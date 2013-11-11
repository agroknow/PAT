<?php

function is_valid_uri($identifier) {
    return true;
}

function oai_error($code, $argument = '', $value = '') {
    global $request;
    global $request_err;

    switch ($code) {
        case 'badArgument' :
            $text = "The argument '$argument' (value='$value') included in the request is not valid.";
            break;

        case 'badGranularity' :
            $text = "The value '$value' of the argument '$argument' is not valid.";
            $code = 'badArgument';
            break;

        case 'badResumptionToken' :
            $text = "The resumptionToken '$value' does not exist or has already expired.";
            break;

        case 'badRequestMethod' :
            $text = "The request method '$argument' is unknown.";
            $code = 'badVerb';
            break;

        case 'badVerb' :
            $text = "The verb '$argument' provided in the request is illegal.";
            break;

        case 'cannotDisseminateFormat' :
            $text = "The metadata format '$value' given by $argument is not supported by this repository.";
            break;

        case 'exclusiveArgument' :
            $text = 'The usage of resumptionToken as an argument allows no other arguments.';
            $code = 'badArgument';
            break;

        case 'idDoesNotExist' :
            $text = "The value '$value' of the identifier is illegal for this repository.";
            if (!is_valid_uri($value)) {
                $code = 'badArgument';
            }
            break;

        case 'missingArgument' :
            $text = "The required argument '$argument' is missing in the request.";
            $code = 'badArgument';
            break;

        case 'noRecordsMatch' :
            $text = 'The combination of the given values results in an empty list.';
            break;

        case 'noMetadataFormats' :
            $text = 'There are no metadata formats available for the specified item.';
            break;

        case 'noVerb' :
            $text = 'The request does not provide any verb.';
            $code = 'badVerb';
            break;

        case 'noSetHierarchy' :
            $text = 'This repository does not support sets.';
            break;

        case 'sameArgument' :
            $text = 'Do not use them same argument more than once.';
            $code = 'badArgument';
            break;

        case 'sameVerb' :
            $text = 'Do not use verb more than once.';
            $code = 'badVerb';
            break;

        default:
            $text = "Unknown error: code: '$code', argument: '$argument', value: '$value'";
            $code = 'badArgument';
    }

    if ($code == 'badVerb' || $code == 'badArgument') {
        $request = $request_err;
    }
    $error = ' <error code="' . xmlstr($code, 'iso8859-1', false) . '">' . xmlstr($text, 'iso8859-1', false) . "</error>\n";
    return $error;
}

function xmlstr($string, $charset = 'iso8859-1', $xmlescaped = 'false') {
    $xmlstr = stripslashes(trim($string));
    // just remove invalid characters
    $pattern = "/[\x-\x8\xb-\xc\xe-\x1f]/";
    $xmlstr = preg_replace($pattern, '', $xmlstr);

    // escape only if string is not escaped
    if (!$xmlescaped) {
        $xmlstr = htmlspecialchars($xmlstr, ENT_QUOTES);
    }

    if ($charset != "utf-8") {
        $xmlstr = utf8_encode($xmlstr);
    }

    return $xmlstr;
}

function scorm_close() {
    global $compress;

    echo "</manifest>\n";
}

function date2UTCdatestamp($date) {
    global $granularity;
    $granularity = 'YYYY-MM-DDThh:mm:ssZ';
    if ($date == '')
        return '';

    switch ($granularity) {

        case 'YYYY-MM-DDThh:mm:ssZ':
            // we assume common date ("YYYY-MM-DD") 
            // or datetime format ("YYYY-MM-DD hh:mm:ss")
            // or datetime format with timezone YYYY-MM-DD hh:mm:ss+02
            // or datetime format with GMT timezone YYYY-MM-DD hh:mm:ssZ
            // or datetime format with timezone YYYY-MM-DDThh:mm:ssZ
            // or datetime format with microseconds and
            //             with timezone YYYY-MM-DD hh:mm:ss.xxx+02
            // with all variations as above
            // in the database
            // 
            if (strstr($date, ' ') || strstr($date, 'T')) {
                $checkstr = '/([0-9]{4})(-)([0-9]{1,2})(-)([0-9]{1,2})([T ])([0-9]{2})(:)([0-9]{2})(:)([0-9]{2})(\.?)(\d*)([Z+-]{0,1})([0-9]{0,2})$/';
                $val = preg_match($checkstr, $date, $matches);
                if (!$val) {
                    // show that we have an error
                    return "0000-00-00T00:00:00.00Z";
                }
                // date is datetime format
                /*
                 * $matches for "2005-05-26 09:30:51.123+02"
                 * 	[0] => 2005-05-26 09:30:51+02
                 * 	[1] => 2005
                 * 	[2] => -
                 * 	[3] => 05
                 * 	[4] => -
                 * 	[5] => 26
                 * 	[6] =>
                 * 	[7] => 09
                 * 	[8] => :
                 * 	[9] => 30
                 * 	[10] => :
                 * 	[11] => 51
                 * 	[12] => .
                 * 	[13] => 123
                 * 	[14] => +
                 * 	[15] => 02
                 */
                if ($matches[14] == '+' || $matches[14] == '-') {
                    // timezone is given
                    // format ("YYYY-MM-DD hh:mm:ss+01")
                    $tz = $matches[15];
                    if ($tz != '') {
                        //$timestamp = mktime($h, $min, $sec, $m, $d, $y);
                        $timestamp = mktime($matches[7], $matches[9], $matches[11], $matches[3], $matches[5], $matches[1]);
                        // add, subtract timezone offset to get GMT
                        // 3600 sec = 1 h
                        if ($matches[14] == '-') {
                            // we are before GMT, thus we need to add
                            $timestamp += (int) $tz * 3600;
                        } else {
                            // we are after GMT, thus we need to subtract
                            $timestamp -= (int) $tz * 3600;
                        }
                        return strftime("%Y-%m-%dT%H:%M:%S.00Z", $timestamp);
                    }
                } elseif ($matches[14] == 'Z') {
                    return str_replace(' ', 'T', $date);
                }
                return str_replace(' ', 'T', $date) . 'Z';
            } else {
                // date is date format
                // granularity 'YYYY-MM-DD' should be used...
                return $date . 'T00:00:00.00Z';
            }
            break;

        case 'YYYY-MM-DD':
            if (strstr($date, ' ')) {
                // date is datetime format
                list($date, $time) = explode(" ", $date);
                return $date;
            } else {
                return $date;
            }
            break;

        default: die("Unknown granularity!");
    }
}

function xmlformat($record, $element, $attr = '', $indent = 0) {
    $charset = "utf-8";
    global $xmlescaped;

    if ($attr != '') {
        $attr = ' ' . $attr;
    }

    $str = '';
    if (is_array($record)) {
        foreach ($record as $val) {
            $str .= str_pad('', $indent) . '<' . $element . $attr . '>' . xmlstr($val, $charset, $xmlescaped) . '</' . $element . ">\n";
        }
        return $str;
    } elseif ($record != '') {
        return str_pad('', $indent) . '<' . $element . $attr . '>' . xmlstr($record, $charset, $xmlescaped) . '</' . $element . ">\n";
    } else {
        return '';
    }
}

function oai_exit() {
    global $CONTENT_TYPE;
    global $xmlheader;
    global $request;
    global $errors;

    header($CONTENT_TYPE);
    echo $xmlheader;
    echo $request;
    echo $errors;

    oai_close();
    exit();
}

function preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, $elementPrefix = 'imsmd:') {
    global $language;
    global $xml_general;
    $db = Zend_Registry::get('db');
    $standar_query = Zend_Registry::get('standar_query');

    $thereturn = '';



    if ($datageneral3['machine_name'] == 'rights') { ///////if RIGHTS
        foreach ($datageneral4 as $datageneral4) {
            //$sql5 = "SELECT * FROM  metadata_element_value WHERE record_id=" . $metadatarecord['id'] . " and element_hierarchy=" . $datageneral4['id'] . " ORDER BY multi ASC;";
            //echo $sql4."<br>";
            $exec5 = $db->query($standar_query, array($metadatarecord['id'], $datageneral4['id']));
            $datageneral5 = $exec5->fetchAll();
            $exec_right = $db->query($standar_query, array($metadatarecord['id'], $datageneral4['id']));
            $datageneral_right = $exec_right->fetch();
            $count_results = count($datageneral5);

            if ($count_results > 0) {
                //echo $datageneral_right['element_hierarchy']."123";
                if ($datageneral_right['element_hierarchy'] == 22) {  /////rights for creative commons  element_id=22
                    if (strlen($datageneral_right['value']) > 0) {
                        $right1 = $datageneral_right['value'];
                    }
                } elseif ($datageneral_right['element_hierarchy'] == 23) {  /////rights for creative commons element_id=23
                    if (strlen($datageneral_right['value']) > 0) {
                        $right2 = $datageneral_right['value'];
                    }
                } elseif ($datageneral_right['element_hierarchy'] == 9) {  /////rights for adding source value element_id=9
                    if (strlen($datageneral_right['value']) > 0) {
                        $rightvaluetext='';
                        if($datageneral_right['value']=='yes'){$rightvaluetext='Yes';}
                        if($datageneral_right['value']=='no'){$rightvaluetext='No';}
                        if($datageneral_right['value']=='yes, if others share alike '){$rightvaluetext='Yes, if others share alike ';}
                        $thereturn.= '<' . $elementPrefix . '' . $datageneral4['machine_name'] . '>' . "\n";
                        $thereturn .= xmlformat('LOMv1.0', '' . $elementPrefix . 'source', '', $indent);
                        $thereturn .= xmlformat(__($rightvaluetext), '' . $elementPrefix . 'value', '', $indent);
                        $thereturn.= '</' . $elementPrefix . '' . $datageneral4['machine_name'] . '>' . "\n";
                    }
                } elseif ($datageneral_right['element_hierarchy'] == 24) {  /////rights for adding source value element_id=24
                    if (strlen($datageneral_right['value']) > 0) {
                        $rightvaluetext='';
                         if($datageneral_right['value']=='yes'){$rightvaluetext='Yes';}
                        if($datageneral_right['value']=='no'){$rightvaluetext='No';}
                        if($datageneral_right['value']=='yes, if others share alike '){$rightvaluetext='Yes, if others share alike ';}
                        $thereturn.= '<' . $elementPrefix . '' . $datageneral4['machine_name'] . '>' . "\n";
                        $thereturn .= xmlformat('LOMv1.0', '' . $elementPrefix . 'source', '', $indent);
                        $thereturn .= xmlformat(__($rightvaluetext), '' . $elementPrefix . 'value', '', $indent);
                        $thereturn.= '</' . $elementPrefix . '' . $datageneral4['machine_name'] . '>' . "\n";
                    }
                } elseif ($datageneral_right['element_hierarchy'] == 81) {  ////if isset description instead of creative commons
                    if (strlen($datageneral_right['value']) > 0) {
                        $right3 = $datageneral_right['value'];
                    }
                } else {
                    $thereturn.=preview_elements_from_datatype($datageneral4, $datageneral5, $metadatarecord, NULL, $elementPrefix); //else echo the element
                }
            }///if($count_results>0){ 
        }//foreach datageneral4 afou exei perasei oles tis times...
        //////////////diadikasia gia echo to creative commons h to description an uparxei auto.////////////////
        if (strlen($right3) > 0) {
            $thereturn.=preview_elements_from_datatype($datageneral4, $datageneral5, $metadatarecord, NULL, $elementPrefix);
        } elseif ($right1 == 'yes' and $right2 == 'yes') {
            $thereturn .= '<' . $elementPrefix . 'description>' . "\n";
            $thereturn .= xmlformat('http://www.creativecommons.org/licenses/by/3.0', '' . $elementPrefix . 'string', '', $indent);
            $thereturn .= '</' . $elementPrefix . 'description>' . "\n";
        } elseif ($right1 == 'yes' and $right2 == 'no') {
            $thereturn .= '<' . $elementPrefix . 'description>' . "\n";
            $thereturn .= xmlformat('http://www.creativecommons.org/licenses/by-nd/3.0', '' . $elementPrefix . 'string', '', $indent);
            $thereturn .= '</' . $elementPrefix . 'description>' . "\n";
        } elseif ($right1 == 'yes' and $right2 == 'Yes, if others share alike') {
            $thereturn .= '<' . $elementPrefix . 'description>' . "\n";
            $thereturn .= xmlformat('http://www.creativecommons.org/licenses/by-sa/3.0', '' . $elementPrefix . 'string', '', $indent);
            $thereturn .= '</' . $elementPrefix . 'description>' . "\n";
        } elseif ($right1 == 'no' and $right2 == 'yes') {
            $thereturn .= '<' . $elementPrefix . 'description>' . "\n";
            $thereturn .= xmlformat('http://www.creativecommons.org/licenses/by-nc/3.0', '' . $elementPrefix . 'string', '', $indent);
            $thereturn .= '</' . $elementPrefix . 'description>' . "\n";
        } elseif ($right1 == 'no' and $right2 == 'no') {
            $thereturn .= '<' . $elementPrefix . 'description>' . "\n";
            $thereturn .= xmlformat('http://www.creativecommons.org/licenses/by-nc-nd/3.0', '' . $elementPrefix . 'string', '', $indent);
            $thereturn .= '</' . $elementPrefix . 'description>' . "\n";
        } elseif ($right1 == 'no' and $right2 == 'Yes, if others share alike') {
            $thereturn .= '<' . $elementPrefix . 'description>' . "\n";
            $thereturn .= xmlformat('http://www.creativecommons.org/licenses/by-nc-sa/3.0', '' . $elementPrefix . 'string', '', $indent);
            $thereturn .= '</' . $elementPrefix . 'description>' . "\n";
        }
    } elseif ($datageneral3['machine_name'] == 'classification') { ///////if CLASSIFICATION
        $thereturn = '';
        $thereturnonto = '';
        foreach ($datageneral4 as $datageneral4) { ////foreach element_hierarchy under classification
            //$sql8 = "SELECT * FROM  metadata_element_value WHERE record_id=" . $metadatarecord['id'] . " and element_hierarchy=" . $datageneral4['id'] . " ORDER BY multi ASC ;";
            //echo $sql8."<br>"; break;
            $exec8 = $db->query($standar_query, array($metadatarecord['id'], $datageneral4['id']));
            $datageneral8 = $exec8->fetchAll();
            $count_results8 = count($datageneral8);
            if ($count_results8 > 0) {


                //print_r($datageneral8);break;
                $thereturnonto = '';
                foreach ($datageneral8 as $datageneral8) {

                    $sql6 = "SELECT c.*,b.machine_name,b.id as elm_id,b.vocabulary_id as vocabulary_id FROM  metadata_element b  LEFT JOIN metadata_element_hierarchy c 
			ON c.element_id = b.id  WHERE c.pelement_id=" . $datageneral4['elm_id'] . " and c.is_visible=1 ;";
                    //echo $sql6."<br>";
                    $exec6 = $db->query($sql6);
                    $datageneral6 = $exec6->fetchAll();
                    $ontology1 = '';
                    $ontology2 = '';
                    foreach ($datageneral6 as $datageneral6) {
                        //print_r($datageneral6);break;
                        $sql7 = "SELECT * FROM  metadata_element_value WHERE record_id=" . $metadatarecord['id'] . " and element_hierarchy=" . $datageneral6['id'] . " and multi=" . $datageneral8['multi'] . " ORDER BY parent_indexer ASC ;";
                        //echo $sql7; break;
                        $exec7 = $db->query($sql7);
                        $datageneral5 = $exec7->fetchAll();
                        $count_results5 = count($datageneral5);

                        if ($count_results5 > 0) {



                            foreach ($datageneral5 as $datageneral5) {
                                $ontology2_en_value_string = '';
                                if ($datageneral6['datatype_id'] == 5) {
                                    if (strlen($datageneral5['classification_id']) > 0) {

                                        //$sqlfindxml = "SELECT * FROM  metadata_vocabulary_record WHERE vocabulary_id=" . $datageneral6['vocabulary_id'] . "";
                                        //echo $sqlfindxml;
                                        //$execfindxml = $db->query($sqlfindxml);
                                        //$findxml = $execfindxml->fetch();
                                        //libxml_use_internal_errors(false);
                                        $uri = WEB_ROOT;
                                        //$file = $findxml['value'];
                                        //$xmlvoc = '' . $uri . '/archive/xmlvoc/' . $file . '.xml';
                                        //$xml = @simplexml_load_file($xmlvoc, NULL, LIBXML_NOERROR | LIBXML_NOWARNING);
                                        //$resultnewval = $xml->xpath("instances/instance[@instanceOf='" . $datageneral5['classification_id'] . "' and @lang='en']");
                                        $xml_general2 = Zend_Registry::get('xml_general');
                                        $xml = $xml_general2[$datageneral6['vocabulary_id']];
                                        $cus_lan=0;
                                        $ontology2_en_value_string1='';
                                        $ontology2_en_value_string2='';
                                        foreach ($xml as $key => $xml2) {
                                            if ($xml2['instanceOf'] == $datageneral5['classification_id'] and $xml2['lang'] == 'en') {
                                                $ontology2_en_value_string1 = $xml2['value'];
                                                $ontology2 = $datageneral5['classification_id'];
                                            }elseif($xml2['instanceOf'] == $datageneral5['classification_id'] and $xml2['lang'] == $_SESSION['get_language_for_internal_xml']){
                                                $cus_lan=1;
                                                $ontology2_en_value_string2 = $xml2['value'];
                                                $ontology2 = $datageneral5['classification_id'];
                                            }
                                            if($cus_lan===1){
                                                $ontology2_en_value_string=$ontology2_en_value_string2;
                                            }else{
                                               $ontology2_en_value_string=$ontology2_en_value_string1; 
                                            }
                                        }
                                    }

                                }

                                if ($datageneral6['datatype_id'] == 6) {
                                    if (strlen($datageneral5['vocabulary_record_id']) > 0) {
                                        $sql_ont = "SELECT * FROM  metadata_vocabulary_record WHERE id=" . $datageneral5['vocabulary_record_id'] . " ;";
                                        //echo $sql_ont."<br>";
                                        $exec_ont = $db->query($sql_ont);
                                        $datageneral_ont = $exec_ont->fetch();
                                        $valuetxt = get_label_from_voc_id($datageneral5['vocabulary_record_id'], $language);
                                        $ontology1 = $datageneral_ont['value'];
                                        $ontology1val = $valuetxt;
                                    }
                                }
                                if ($datageneral6['form_type_id'] == 2) {
                                    $ontology3 = $datageneral5['value'];
                                }
                            }//foreach($datageneral5 as $datageneral5){
                        }//if($count_results5>0){
                    }//foreach($datageneral6 as $datageneral6){
                    $sqlschema = "SELECT * FROM  metadata_schema WHERE id=1";
                    $execschema = $db->query($sqlschema);
                    $schema = $execschema->fetch();

                    if ($schema['name'] == 'organic_lingua') {
                        ////////////////view the ontology like organic-edunet schema//////////
                        ////////////for organic-lingua/////////////////
                        $selectvaluesvalue2 = explode(' ', $ontology2);
                        $ontology2 = '';
                        foreach ($selectvaluesvalue2 as $selectvaluesvalue2) {
                            $ontology2.=ucfirst($selectvaluesvalue2);
                        }

                        $selectvaluesvalue2 = explode(' ', $ontology1);
                        $ontology1 = '';
                        foreach ($selectvaluesvalue2 as $selectvaluesvalue2) {
                            $ontology1.=ucfirst($selectvaluesvalue2);
                        }
                        $taxon_id_value = "http://www.cc.uah.es/ie/ont/OE-Predicates#" . $ontology1 . " :: http://www.cc.uah.es/ie/ont/OE-OAAE#" . $ontology2 . "";
                        $taxon_entry = $ontology1 . " :: " . $ontology2 . "";
                        $class_source = 'Organic.Edunet Ontology';
                    }
                    ////////////for organic-lingua/////////////////

                    if ($schema['name'] == 'CoE') {
                        ////////////for CoE/////////////////
                        $taxon_entry = $ontology1 . "" . $ontology2 . "";
                        $taxon_id_value = ' ';
                        if ($datageneral4['machine_name'] == 'purpose_educational_level') {
                            $class_source = 'UNESCO';
                        } elseif ($datageneral4['machine_name'] == 'purpose_discipline') {
                            $class_source = 'huridocs';
                        } else {
                            $class_source = '';
                        }
                    }
                    ////////////for CoE/////////////////
                    if ($schema['name'] == 'NE') {
                        ////////////for NE/////////////////

                        $taxon_entry = $ontology1 . "" . $ontology2_en_value_string . "";
                        $taxon_id_value = ' ';
                        if ($datageneral4['machine_name'] == 'purpose_educational_level') {
                            $class_source = get_label_from_element_id(93, $language);
                            $taxon_id_value = $ontology1;
                            $taxon_id_value_id = $ontology1val;
                        } elseif ($datageneral4['machine_name'] == 'purpose_discipline') {
                            $class_source = 'LRE thesaurus';
                        } elseif ($datageneral4['machine_name'] == 'purpose_educational_objective') {
                            $class_source = "Revised Bloom's Taxonomy";
                            $taxon_id_value = $ontology1val;
                            $taxon_id_value_id = $ontology1;
                            $taxon_entry = $ontology3;
                        } else {
                            $class_source = '';
                        }
                    }
                    ////////////for NE/////////////////
                    ////////////////////create puprose value from element machine name//////////////////////
                    $for_purpose = $datageneral4['machine_name'];
                    $for_purpose = explode('purpose_', $for_purpose);
                    $for_purpose = $for_purpose[1];
                    $for_purpose = str_replace("_", " ", $for_purpose);
                    ////////////////////create puprose value from element machine name//////////////////////


                    if (strlen($ontology1) > 0 or strlen($ontology2) > 0) {
                        $thereturnonto .= '<' . $elementPrefix . 'taxonPath>' . "\n";
                        $thereturnonto .= '<' . $elementPrefix . 'source>' . "\n";
                        $thereturnonto .= xmlformat($class_source, '' . $elementPrefix . 'string', ' language="en"', $indent);
                        $thereturnonto .= '</' . $elementPrefix . 'source>' . "\n";
                        $thereturnonto .= '<' . $elementPrefix . 'taxon>' . "\n";
                        $thereturnonto .= xmlformat($taxon_id_value, '' . $elementPrefix . 'id', '', $indent);
                        $thereturnonto .= '<' . $elementPrefix . 'entry>' . "\n";
                        if(strlen($taxon_id_value)>1 and strlen($taxon_entry)>1 ){
                            //echo strlen($taxon_id_value);
                            $taxon_id_value.= ' : ';
                        }
                        $thereturnonto .= xmlformat($taxon_id_value.''.$taxon_entry, '' . $elementPrefix . 'string', '', $indent);
                        $thereturnonto .= '</' . $elementPrefix . 'entry>' . "\n";
                        $thereturnonto .= '</' . $elementPrefix . 'taxon>' . "\n";
                        $thereturnonto .= '</' . $elementPrefix . 'taxonPath>' . "\n";
                    }
                }//foreach($datageneral8 as $datageneral8){


                if (strlen($thereturnonto) > 0) {
                    $thereturn .= '<' . $elementPrefix . 'classification>' . "\n";
                    $thereturn .= '<label>';
                    $thereturn .=get_label_from_element_id(4, $language);
                    $thereturn .= '</label>' . "\n";
                    $thereturn .= '<' . $elementPrefix . 'purpose>' . "\n";
                    $thereturn .= xmlformat('LOMv1.0', '' . $elementPrefix . 'source', '', $indent);
                    $thereturn .= xmlformat($for_purpose, '' . $elementPrefix . 'value', '', $indent);
                    $thereturn .= '</' . $elementPrefix . 'purpose>' . "\n";
                    $thereturn .=$thereturnonto;
                    $thereturn .= '</' . $elementPrefix . 'classification>' . "\n";
                }
            }//if($count_results8>0){
        }//foreach datageneral4
    } elseif ($datageneral3['machine_name'] == 'relation') { ///////if RELATION
        foreach ($datageneral4 as $datageneral4) {
            //$sql5 = "SELECT * FROM  metadata_element_value WHERE record_id=" . $metadatarecord['id'] . " and element_hierarchy=" . $datageneral4['id'] . " ORDER BY multi ASC;";
            //echo $sql4."<br>";
            $exec5 = $db->query($standar_query, array($metadatarecord['id'], $datageneral4['id']));
            $datageneral5 = $exec5->fetchAll();
            $count_results = count($datageneral5);

            if ($count_results > 0) {
                if ($datageneral4['machine_name'] == 'identifier') {
                    $thereturn .= '<label>';
                    $thereturn .=get_label_from_element_id($datageneral4['element_id'], $language);
                    $thereturn .= '</label>' . "\n";
                    $thereturn.= '<' . $elementPrefix . 'resource>' . "\n";
                }
                $thereturn.=preview_elements_from_datatype($datageneral4, $datageneral5, $metadatarecord, NULL, $elementPrefix);
                if ($datageneral4['machine_name'] == 'identifier') {
                    $thereturn.= '</' . $elementPrefix . 'resource>' . "\n";
                }
            }
        }
    } elseif ($datageneral3['machine_name'] == 'general') { ///////if general
        $thereturn = preview_elements_from_datatype($datageneral4, $datageneral5, $metadatarecord, NULL, $elementPrefix);
    } elseif ($datageneral3['machine_name'] == 'lifeCycle') { ///////if lifeCycle
        $thereturn = preview_elements_from_datatype($datageneral4, $datageneral5, $metadatarecord, NULL, $elementPrefix);
    } elseif ($datageneral3['machine_name'] == 'technical') { ///////if technical
        $thereturn = preview_elements_from_datatype($datageneral4, $datageneral5, $metadatarecord, NULL, $elementPrefix);
    } elseif ($datageneral3['machine_name'] == 'educational') { ///////if educational
        $thereturn = preview_elements_from_datatype($datageneral4, $datageneral5, $metadatarecord, NULL, $elementPrefix);
    } elseif ($datageneral3['machine_name'] == 'annotation') { ///////if annotation
        $thereturn = preview_elements_from_datatype($datageneral4, $datageneral5, $metadatarecord, NULL, $elementPrefix);
    } elseif ($datageneral3['machine_name'] == 'metaMetadata') { ///////if metaMetadata
        $thereturn = preview_elements_from_datatype($datageneral4, $datageneral5, $metadatarecord, NULL, $elementPrefix);
    } else {
        $thereturn = preview_elements_from_datatype($datageneral4, $datageneral5, $metadatarecord, NULL, $elementPrefix);
    }

    return $thereturn;
}

function langstring_for_oai($machine_name, $datageneral5, $multi, $previousmulti, $elementPrefix = 'imsmd:', $datageneral4 = NULL) {
    global $language;
    $thereturn_lnstr = '';
    $thereturn_lnstr.= '<' . $elementPrefix . '' . $machine_name . '>';
    $thereturn_lnstr .= '<label>';
    $thereturn_lnstr .=get_label_from_element_id($datageneral4['element_id'], $language);
    $thereturn_lnstr .= '</label>' . "\n";
    $valuestr = '';
    $valuestren = '';
    $valuestrrandom = '';
    foreach ($datageneral5 as $datageneral5) {

        $multi = $datageneral5['multi'];
        if ($multi != $previousmulti and $previousmulti != 0) {
            if (strlen($valuestr) > 0) {
                $thereturn_lnstr.=xmlformat($valuestr, '' . $elementPrefix . 'value', 'language="' . $langfortxt . '" ', $indent);
            } elseif (strlen($valuestren) > 0) {
                $thereturn_lnstr.=xmlformat($valuestren, '' . $elementPrefix . 'value', 'language="' . $langfortxten . '" ', $indent);
            } else {
                $thereturn_lnstr.=xmlformat($valuestrrandom, '' . $elementPrefix . 'value', 'language="' . $langfortxtrandom . '" ', $indent);
            }
            $thereturn_lnstr.= '</' . $elementPrefix . '' . $machine_name . '>' . "\n";
            $thereturn_lnstr.= '<' . $elementPrefix . '' . $machine_name . '>';
            $thereturn_lnstr .= '<label>';
            $thereturn_lnstr .=get_label_from_element_id($datageneral4['element_id'], $language);
            $thereturn_lnstr .= '</label>' . "\n";
            $valuestr = '';
            $valuestren = '';
            $valuestrrandom = '';
        }

        if ($datageneral5['language_id'] == $language) {
            $valuestr = h(strip_tags($datageneral5['value']));
            $langfortxt = $datageneral5['language_id'];
        }
        if ($datageneral5['language_id'] == 'en') {
            $valuestren = h(strip_tags($datageneral5['value']));
            $langfortxten = $datageneral5['language_id'];
        }
        $valuestrrandom = h(strip_tags($datageneral5['value']));
        $langfortxtrandom = $datageneral5['language_id'];



        $previousmulti = $datageneral5['multi'];
    }
    if (strlen($valuestr) > 0) {
        $thereturn_lnstr.=xmlformat($valuestr, '' . $elementPrefix . 'value', 'language="' . $langfortxt . '" ', $indent);
    } elseif (strlen($valuestren) > 0) {
        $thereturn_lnstr.=xmlformat($valuestren, '' . $elementPrefix . 'value', 'language="' . $langfortxten . '" ', $indent);
    } else {
        $thereturn_lnstr.=xmlformat($valuestrrandom, '' . $elementPrefix . 'value', 'language="' . $langfortxtrandom . '" ', $indent);
    }
    $thereturn_lnstr.= '</' . $elementPrefix . '' . $machine_name . '>' . "\n";

    return $thereturn_lnstr;
}

function preview_elements_from_datatype($datageneral4, $datageneral5, $metadatarecord, $parent_machine_name = NULL, $elementPrefix = 'imsmd:') {
    global $language;
    $db = Zend_Registry::get('db');
    $standar_query = Zend_Registry::get('standar_query');

//////get the machine name
    if (strlen($datageneral4['machine_name']) > 0) {
        $machine_name = $datageneral4['machine_name'];
    } else {
        $machine_name = 'no_machine_name';
    }

    $multi = 0;
    $previousmulti = 0;




    if ($datageneral4['datatype_id'] == 1) {

        $output.=langstring_for_oai($machine_name, $datageneral5, $multi, $previousmulti, $elementPrefix, $datageneral4);


        ///////////////////Parent Element///////////////////////
    } elseif ($datageneral4['datatype_id'] == 2) {

        //$sql8 = "SELECT * FROM  metadata_element_value WHERE record_id=" . $metadatarecord['id'] . " and element_hierarchy=" . $datageneral4['id'] . " ORDER BY multi ASC ;";
        //echo $sql8."<br>"; break;
        $exec8 = $db->query($standar_query, array($metadatarecord['id'], $datageneral4['id']));
        $datageneral8 = $exec8->fetchAll();
        $count_results8 = count($datageneral8);
        if ($count_results8 > 0) {

            //print_r($datageneral8);break;
            $sql6 = "SELECT c.*,b.machine_name,b.id as elm_id FROM  metadata_element b  LEFT JOIN metadata_element_hierarchy c 
			ON c.element_id = b.id  WHERE c.pelement_id=? and c.is_visible=? ;";
            foreach ($datageneral8 as $datageneral8) {
                $output2 = '';

                
                //echo $sql6."<br>";
                $exec6 = $db->query($sql6, array($datageneral4['elm_id'], 1));
                $datageneral6 = $exec6->fetchAll();
                
                $sql7 = "SELECT * FROM  metadata_element_value WHERE record_id=? and element_hierarchy=? and multi=? ORDER BY parent_indexer ASC ;";
                foreach ($datageneral6 as $datageneral6) {
                    //print_r($datageneral6);break;
                    
                    //echo $sql7; break;
                    $exec7 = $db->query($sql7, array($metadatarecord['id'], $datageneral6['id'], $datageneral8['multi']));
                    $datageneral7 = $exec7->fetchAll();
                    $count_results2 = count($datageneral7);

                    if ($count_results2 > 0) {

                        $output2.=preview_elements_from_datatype($datageneral6, $datageneral7, $metadatarecord, NULL, $elementPrefix);
                    }///if($count_results2>0){
                }///foreach datageneral6
                if (strlen($output2) > 0) {
                    $output.= '<' . $elementPrefix . '' . $machine_name . '>' . "\n";
                    $output .= '<label>';
                    $output .=get_label_from_element_id($datageneral4['element_id'], $language);
                    $output .= '</label>' . "\n";
                    $output.= $output2;
                    $output.= '</' . $elementPrefix . '' . $machine_name . '>' . "\n";
                }
            }///foreach datageneral6
        }///if($count_results8>0){
        ///////////////////vcard///////////////////////			
    } elseif ($datageneral4['datatype_id'] == 3) {
        
        $sql10 = "SELECT * FROM  metadata_vcard WHERE id=? ;";
        foreach ($datageneral5 as $datageneral5) {
            
            //echo $sql10;break;
            $exec10 = $db->query($sql10, array($datageneral5['vcard_id']));
            $datageneral10 = $exec10->fetch();

            if (strlen($datageneral10['name']) > 0 or strlen($datageneral10['surname']) > 0) {
                $fullname = "FN:" . $datageneral10['name'] . " " . $datageneral10['surname'] . "\r\n";
            } else {
                $fullname = '';
            }
            if (strlen($datageneral10['email']) > 0) {
                $email = "EMAIL;TYPE=INTERNET:" . $datageneral10['email'] . "\r\n";
            } else {
                $email = '';
            }

            if (strlen($datageneral10['organization']) > 0) {
                $organization = "ORG:" . $datageneral10['organization'] . "\r\n";
            } else {
                $organization = '';
            }
            if (strlen($datageneral10['name']) > 0 or strlen($datageneral10['surname']) > 0) {
                if (strlen($datageneral10['surname']) > 0) {
                    $surname = $datageneral10['surname'] . ';';
                } else {
                    $surname = '';
                }
                if (strlen($datageneral10['name']) > 0) {
                    $name = $datageneral10['name'];
                } else {
                    $name = '';
                }
                $name = "N:" . $surname . "" . $datageneral10['name'] . "\r\n";
            } else {
                $name = '';
            }


            $output.= '<' . $elementPrefix . '' . $machine_name . '>' . "\n";
            $output .= '<label>';
            $output .=get_label_from_element_id($datageneral4['element_id'], $language);
            $output .= '</label>' . "\n";
            $output .= '<value>';
            $output.="<![CDATA[BEGIN:VCARD\r\n" . $fullname . "" . $email . "" . $organization . "" . $name . "VERSION:3.0\r\nEND:VCARD]]>";
            $output .= '</value>';
            $output.= '</' . $elementPrefix . '' . $machine_name . '>' . "\n";
        }

        ///////////////////vocabulary///////////////////////			
    } elseif ($datageneral4['datatype_id'] == 6) {

        $sql10 = "SELECT * FROM  metadata_vocabulary_record WHERE id=? ;";
        foreach ($datageneral5 as $datageneral5) {
            if ($datageneral5['vocabulary_record_id'] > 0) {
                
                //echo $sql10;break;
                $exec10 = $db->query($sql10, array($datageneral5['vocabulary_record_id']));
                $datageneral10 = $exec10->fetch();
                $output.= '<' . $elementPrefix . '' . $machine_name . '>' . "\n";
                $output .= '<label>';
                $output .=get_label_from_element_id($datageneral4['element_id'], $language);
                $output .= '</label>' . "\n";
                $valuetxt = get_label_from_voc_id($datageneral5['vocabulary_record_id'], $language);
                //$output.=xmlformat($datageneral10['source'], ''.$elementPrefix.'source', '', $indent);
                $output.=xmlformat($valuetxt, '' . $elementPrefix . 'value', '', $indent);
                $output.=xmlformat($datageneral10['value'], '' . $elementPrefix . 'id', '', $indent);
                $output.= '</' . $elementPrefix . '' . $machine_name . '>' . "\n";
            }//if($datageneral5['vocabulary_record_id']>0){
        }//foreach($datageneral5 as $datageneral5){
        ///////////////////$datetime///////////////////////
    } elseif ($datageneral4['form_type_id'] == 5) {

        foreach ($datageneral5 as $datageneral5) {
            $datetime = returndatetime($datageneral5['value']);

            $output.= '<' . $elementPrefix . '' . $machine_name . '>';
            $output .= '<label>';
            $output .=get_label_from_element_id($datageneral4['elm_id'], $language);
            $output .= '</label>' . "\n";
            $output.=xmlformat($datetime, '' . $elementPrefix . 'dateTime', '', $indent);
            $output.= '</' . $elementPrefix . '' . $machine_name . '>' . "\n";
        }

        ///////////////////Nothing///////////////////////
    } else {

        foreach ($datageneral5 as $datageneral5) {
            $output.= '<' . $elementPrefix . '' . $machine_name . '>';
            $output .= '<label>';
            $output .=get_label_from_element_id($datageneral4['elm_id'], $language);
            $output .= '</label>' . "\n";
            $output.=xmlformat($datageneral5['value'], 'value', '', $indent);
            $output.= '</' . $elementPrefix . '' . $machine_name . '>' . "\n";
        }
    }

    return $output;
}

function onlyNumbers($string) {
    //This function removes all characters other than numbers
    $string = preg_replace("/[^0-9]/", "", $string);
    return (int) $string;
}

function returndatetime($date) {
    $datetime = $date;
    $selectvaluesvalue2 = explode(' ', $datetime);
    $datetime = '';
    //$selectvaluesvalue2[0]=date2UTCdatestamp($selectvaluesvalue2[0]);
    //$selectvaluesvalue2[0] = date("YYYY-mm-dd", strtotime($selectvaluesvalue2[0]));
    $datetime.=$selectvaluesvalue2[0];
    $datetime.='T';
    if (strlen($selectvaluesvalue2[1]) > 0) {
        $datetime.=$selectvaluesvalue2[1];
    } else {
        $datetime.='00:00:00';
    }
    $datetime.='.00Z';
    $datetime = date2UTCdatestamp($datetime);
    return $datetime;
}

function get_label_from_element_id($elementid, $language = 'en') {
    $db = Zend_Registry::get('db');
    $sqltr = Zend_Registry::get('get_label_elem_sqltr');
    $sqltrrd = Zend_Registry::get('get_label_elem_sqltrrd');

    //$sqltr = "SELECT * FROM metadata_element_label WHERE element_id=? and language_id=?";
    //$sqltrrd = "SELECT * FROM metadata_element_label WHERE element_id=? LIMIT 1";
    $execrecordtr = $db->query($sqltr, array($elementid, $language));
    $metadatarecordtr = $execrecordtr->fetch();

    $execrecordtren = $db->query($sqltr, array($elementid, 'en'));
    $metadatarecordtren = $execrecordtren->fetch();

    $execrecordtrrd = $db->query($sqltrrd, array($elementid));
    $metadatarecordtrrd = $execrecordtrrd->fetch();

    if (strlen($metadatarecordtr['labal_name']) > 0) {
        $value = $metadatarecordtr['labal_name'];
    } elseif (strlen($metadatarecordtren['labal_name']) > 0) {
        $value = $metadatarecordtren['labal_name'];
    } else {
        $value = $metadatarecordtrrd['labal_name'];
    }
    //return $language;
    return $value;
}

function get_label_from_voc_id($elementid, $language = 'en') {
    $db = Zend_Registry::get('db');
    $sqltr = Zend_Registry::get('get_label_voc_sqltr');
    $sqltrrd = Zend_Registry::get('get_label_voc_sqltrrd');

    //$sqltr = "SELECT * FROM metadata_vocabulary_value WHERE vocabulary_rid=? and language_id=?";
    //$sqltrrd = "SELECT * FROM metadata_vocabulary_value WHERE vocabulary_rid=? LIMIT 1";
    $execrecordtr = $db->query($sqltr, array($elementid, $language));
    $metadatarecordtr = $execrecordtr->fetch();

    $execrecordtren = $db->query($sqltr, array($elementid, 'en'));
    $metadatarecordtren = $execrecordtren->fetch();

    $execrecordtrrd = $db->query($sqltrrd, array($elementid));
    $metadatarecordtrrd = $execrecordtrrd->fetch();

    if (strlen($metadatarecordtr['label']) > 0) {
        $value = $metadatarecordtr['label'];
    } elseif (strlen($metadatarecordtren['label']) > 0) {
        $value = $metadatarecordtren['label'];
    } else {
        $value = $metadatarecordtrrd['label'];
    }
    //return $language;
    return $value;
}

?>