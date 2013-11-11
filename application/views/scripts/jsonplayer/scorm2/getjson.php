<?php

/*
 * +----------------------------------------------------------------------+
 * | PHP Version 4                                                        |
 * +----------------------------------------------------------------------+
 * | Copyright (c) 2002-2005 Heinrich Stamerjohanns                       |
 * |                                                                      |
 * | getrecord.php -- Utilities for the OAI Data Provider                 |
 * |                                                                      |
 * | This is free software; you can redistribute it and/or modify it under|
 * | the terms of the GNU General Public License as published by the      |
 * | Free Software Foundation; either version 2 of the License, or (at    |
 * | your option) any later version.                                      |
 * | This software is distributed in the hope that it will be useful, but |
 * | WITHOUT  ANY WARRANTY; without even the implied warranty of          |
 * | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the         |
 * | GNU General Public License for more details.                         |
 * | You should have received a copy of the GNU General Public License    |
 * | along with  software; if not, write to the Free Software Foundation, |
 * | Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA         |
 * |                                                                      |
 * +----------------------------------------------------------------------+
 * | Derived from work by U. M�ller, HUB Berlin, 2002                     |
 * |                                                                      |
 * | Written by Heinrich Stamerjohanns, May 2002                          |
 * |            stamer@uni-oldenburg.de                                   |
 * +----------------------------------------------------------------------+
 */
//
// $Id: getrecord.php,v 1.02 2003/04/08 14:22:07 stamer Exp $
//
// parse and check arguments
foreach ($args as $key => $val) {

    switch ($key) {
        case 'identifier':
            $identifier = $val;
            if (!is_valid_uri($identifier)) {
                $errors .= oai_error('badArgument', $key, $val);
            }
            break;
    }
}

if (!isset($args['identifier'])) {
    $errors .= oai_error('missingArgument', 'identifier');
}
//if (!isset($args['metadataPrefix'])) {
//    $errors .= oai_error('missingArgument', 'metadataPrefix');
//}
///////explode identifier for use/////////////
$identifier = explode('scorm:' . $repositoryIdentifier . ':', $identifier);
$identifier = $identifier[1];
$identifier = onlyNumbers($identifier);


/* $XMLHEADER =
  '<?xml version="1.0" encoding="UTF-8"?>
  <OAI-PMH xmlns="http://www.openarchives.org/OAI/2.0/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"  xmlns:lom="http://ltsc.ieee.org/xsd/LOM" xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/ http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd">' . "\n";
 */
$XMLHEADER = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<manifest>';




$xmlheader = $XMLHEADER;

////////////query if exist metadata record in the db!!!!//////////////////////////////
$sqlmetadatarecord = "select * from metadata_record where object_id=? and object_type=?";
//echo $sqlmetadatarecord; //break;
$exec2 = $db->query($sqlmetadatarecord, array($identifier, 'exhibit'));
$metadatarecord = $exec2->fetch();

if (!isset($metadatarecord['id'])) {
    $errors .= oai_error('idDoesNotExist', NULL, $identifier);
}

if (empty($errors)) { //if no errors
    $sqlomekaitemfind = "select * from omeka_items where id=? ";
    $standar_query = "SELECT * FROM  metadata_element_value WHERE record_id=? and element_hierarchy=? ORDER BY multi ASC ;";
    $sqlomekaitem = "select * from omeka_exhibits where id=? ";
//echo $sqlmetadatarecord; //break;
    $execomekaitem = $db->query($sqlomekaitem, array($identifier));
    $omekaitem = $execomekaitem->fetch();




    $sqlmetadatarecordvalue = "select * from metadata_element_value where record_id=? ORDER BY element_hierarchy ASC";
    $exec = $db->query($sqlmetadatarecordvalue, array($metadatarecord['id']));
    $metadatarecordvalue_res = $exec->fetchAll();
//echo $sqlmetadatarecordvalue; break;
//$metadatarecordvalue_res=mysql_query($sqlmetadatarecordvalue);
//$metadatarecordvalue=mysql_fetch_array($metadatarecordvalue_res);



    $output .= '<metadata>';
    $output .= '<lom>';

//query for creating general elements pelement=0		 
    $sql3 = "SELECT c.*,b.machine_name,b.id as elm_id2 FROM  metadata_element b  LEFT JOIN metadata_element_hierarchy c 
			ON c.element_id = b.id WHERE c.pelement_id=? and c.is_visible=?  ORDER BY (case WHEN c.sequence IS NULL THEN '9999' ELSE c.sequence END) ASC;";
    $exec3 = $db->query($sql3, array(0, 1));
    $datageneral3 = $exec3->fetchAll();


/////////////////////////

    $sql4 = "SELECT c.*,b.machine_name,b.id as elm_id FROM  metadata_element b  LEFT JOIN metadata_element_hierarchy c 
			ON c.element_id = b.id  WHERE c.pelement_id=? and c.is_visible=? ORDER BY (case WHEN c.sequence IS NULL THEN '9999' ELSE c.sequence END) ASC;";
    foreach ($datageneral3 as $datageneral3) {

        $output2 = '';

        //echo $sql4;break;
        $exec4 = $db->query($sql4, array($datageneral3['elm_id2'], 1));
        $datageneral4 = $exec4->fetchAll();




        if ($datageneral3['machine_name'] == 'rights') { ///////if RIGHTS
            $output2.= preview_elements($datageneral4, NULL, $metadatarecord, $datageneral3, '');
        } elseif ($datageneral3['machine_name'] == 'classification') { ///////if CLASSIFICATION
            $output.= preview_elements($datageneral4, NULL, $metadatarecord, $datageneral3, '');
        } elseif ($datageneral3['machine_name'] == 'relation') { ///////if RELATION
            $output2.= preview_elements($datageneral4, NULL, $metadatarecord, $datageneral3, '');
        } else { ///the rest parent elements///////////////////////////////
            foreach ($datageneral4 as $datageneral4) {



                //echo $sql4."<br>";
                $exec5 = $db->query($standar_query, array($metadatarecord['id'], $datageneral4['id']));
                $datageneral5 = $exec5->fetchAll();
                $count_results = count($datageneral5);


                if ($count_results > 0) {

                    if ($datageneral3['machine_name'] == 'general') { ///////if GENERAL
                        $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                    } elseif ($datageneral3['machine_name'] == 'educational') { ///////if EDUCATIONAL
                        $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                    } elseif ($datageneral3['machine_name'] == 'technical') { ///////if TECHNICAL
                        $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                    } elseif ($datageneral3['machine_name'] == 'lifeCycle') { ///////if LIFECYCLE
                        $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                    } elseif ($datageneral3['machine_name'] == 'metaMetadata') { ///////if META-METADATA
                        $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                    } elseif ($datageneral3['machine_name'] == 'annotation') { ///////if ANNOTATION
                        $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                    } else {
                        $output2.= preview_elements_from_datatype($datageneral4, $datageneral5, $metadatarecord, NULL, '');
                    }
                }//if count_results
            }//datageneral4
        } ///the rest parent elements///////////////////////////////	
        ////////////////echo the result of all parent element if exist
        if (strlen($output2) > 0) {

            $output.= '<' . $datageneral3['machine_name'] . '>';
            $output .= '<label>';
            $output .=get_label_from_element_id($datageneral3['id'], $language);
            $output .= '</label>' . "\n";
            $output.= $output2;
            $output.= '</' . $datageneral3['machine_name'] . '>' . "\n";
        }
    }//datageneral3



    $output .= '</lom>' . "\n";
    $output .= '<omeka>';
    $output .= '<dateModified >';
    $output.= $metadatarecord['date_modified'];
    $output .= '</dateModified >' . "\n";
    $output .= '</omeka>' . "\n";
    $output .= '</metadata>' . "\n";


    $sqlehibitsections = "select * from omeka_sections where exhibit_id=? ";
//echo $sqlmetadatarecord; //break;
    $ehibitsections = $db->query($sqlehibitsections, array($omekaitem['id']));
    $sections = $ehibitsections->fetchAll();


    //$output .= '<organizations default="ORG-Pathway">';
    $output .= '<organizations>';
    $output .= '<default>';
    $output .= 'ORG-Pathway';
    $output .= '</default>' . "\n";
    //$output .= '<organization identifier="ORG-' . $omekaitem['id'] . '" structure="hierarchical">';
    $output .= '<organization>';
    $output .= '<identifier>';
    $output .= 'ORG-' . $omekaitem['id'] . '';
    $output .= '</identifier>' . "\n";
    $output .= '<structure>';
    $output .= 'hierarchical';
    $output .= '</structure>' . "\n";
    $output .= '<title>'; ///for pathway
    $output .= '<![CDATA[' . $omekaitem['title'] . ']]>'; ///for pathway
    $output .= '</title>' . "\n";
    $sqlsectionpages = "select * from omeka_section_pages where section_id=? ";
    $sqlpagestext = "select * from omeka_items_section_pages where page_id=? ORDER BY `order` ASC";
    foreach ($sections as $sections2) {


//echo $sqlmetadatarecord; //break;
        $sectionpages = $db->query($sqlsectionpages, array($sections2['id']));
        $pages = $sectionpages->fetchAll();

        //$output .= '<item identifier="ITEM-' . $sections2['id'] . '" isvisible="true">';
        $output .= '<item>';
        $output .= '<identifier>';
        $output .= 'ITEM-' . $sections2['id'] . '';
        $output .= '</identifier>' . "\n";
        $output .= '<isvisible>';
        $output .= 'true';
        $output .= '</isvisible>' . "\n";
        $output .= '<title>'; //for section
        $output .= '<![CDATA[' . __($sections2['title']) . ']]>'; 
        $output .= '</title>' . "\n";

        foreach ($pages as $pages) {
            //$output .= '<item identifier="ITEM-' . $sections2['id'] . '-' . $pages['id'] . '" identifierref="RES-' . $sections2['id'] . '-' . $pages['id'] . '" isvisible="true">';

            $pagestextr = $db->query($sqlpagestext, array($pages['id']));
            $pagestext2 = $pagestextr->fetchAll();
            $checki = 0;
            foreach ($pagestext2 as $pagestext) {
                ////replace strange space ascii character////////////////
                $pagestexttext = trim($pagestext['text']);
                $pagestexttext = trim($pagestexttext, chr(0xC2) . chr(0xA0) . chr(0xb));
                $pagestexttext = str_replace("", " ", $pagestext['text']);
                $item_page_id = $pagestext['item_id'];
                if (($pagestexttext != '<p>Put text here</p>' and $pagestexttext != 'Put text here' and $pagestexttext != '<p><p>Put text here</p></p>' and strlen($pagestexttext) > 0) or $item_page_id > 0) {
                    $checki+=1;
                }
            }


            if ($checki > 0) {
                $output .= '<item>';
                $output .= '<identifier>';
                $output .= 'ITEM-' . $sections2['id'] . '-' . $pages['id'] . '';
                $output .= '</identifier>' . "\n";
                $output .= '<identifierref>';
                $output .= 'RES-' . $sections2['id'] . '-' . $pages['id'] . '';
                $output .= '</identifierref>' . "\n";
                $output .= '<isvisible>';
                $output .= 'true';
                $output .= '</isvisible>' . "\n";
                $output .= '<title>'; //for page
                $output .= '<![CDATA[' . __($pages['title']) . ']]>'; 
                $output .= '</title>' . "\n";
                $output .= '</item>' . "\n";
            }
        }
        $output .= '</item>' . "\n";
    }

    $output .= '</organization>' . "\n";
    $output .= '</organizations>' . "\n";
    $sqlmetadatarecordvalue_element_location = "select * from metadata_element_value where record_id=? and element_hierarchy=? ORDER BY element_hierarchy ASC";
    $sqlmetadatarecordintext = "select * from metadata_record where object_id=? and object_type=? and validate=? ";
    $output .= '<resources>';

    $sqlpagestext = "select * from omeka_items_section_pages where page_id=? ORDER BY `order` ASC";
    foreach ($sections as $sections2) {

        //$sqlsectionpages = "select * from omeka_section_pages where section_id=" . $sections2['id'] . " ";
//echo $sqlmetadatarecord; //break;
        $sectionpages = $db->query($sqlsectionpages, array($sections2['id']));
        $pages = $sectionpages->fetchAll();

        foreach ($pages as $pages) {
            //$output .= '<resource identifier="RES-' . $sections2['id'] . '-' . $pages['id'] . '" >';
            $output .= '<resource>';
            $output .= '<identifier>';
            $output .= 'RES-' . $sections2['id'] . '-' . $pages['id'] . '';
            $output .= '</identifier>' . "\n";
            $output .= '<metadata>';
            $output .= '<lom>';
            $output .= '<general>';
            $output .= '<title>';
            $output .= '<string>';
            $output .= '<![CDATA[' . __($pages['title']) . ']]>'; 
            $output .= '</string>' . "\n";
            $output .= '</title>' . "\n";



            //$sqlpagestext = "select * from omeka_items_section_pages where page_id=" . $pages['id'] . " ORDER BY `order` ASC";
//echo $sqlmetadatarecord; //break;
            $pagestextr = $db->query($sqlpagestext, array($pages['id']));
            $pagestext2 = $pagestextr->fetchAll();
            $checkorder = 0;
            $checkordervalue = 0;
            foreach ($pagestext2 as $pagestext) {
                $checkorder+=1;
                $checkordervalue = $pagestext['order'];
                $output .= '<order>';
                $output .= '<ordering>';
                $output .= '' . $pagestext['order'] . '';
                $output .= '</ordering>' . "\n";
                ////replace strange space ascii character////////////////
                $pagestexttext = trim($pagestext['text']);
                $pagestexttext = trim($pagestexttext, chr(0xC2) . chr(0xA0) . chr(0xb));
                $pagestexttext = str_replace("", " ", $pagestext['text']);
                if (strlen($pagestexttext) > 0) {
                    //$output .= '<description order="' . $pagestext['order'] . '">';
                    $output .= '<description>';
                    $output .= '<order>';
                    $output .= '' . $pagestext['order'] . '';
                    $output .= '</order>' . "\n";
                    $output .= '<string>';
                    $output .= '<![CDATA[';
                    $output .= trim(nls2p($pagestexttext)) . "";
                    $output .= ']]>';
                    $output .= '</string>' . "\n";
                    $output .= '</description>' . "\n";
                }
                $pagestext3 = $pagestext;
                if ($pagestext3['item_id'] > 0) {


                    //$sqlmetadatarecord = "select * from metadata_record where object_id=" . $pagestext3['item_id'] . " and object_type='item' and validate=1";
//echo $sqlmetadatarecord; //break;
                    $exec2 = $db->query($sqlmetadatarecordintext, array($pagestext3['item_id'], 'item', 1));
                    $metadatarecord = $exec2->fetch();

                    
//echo $sqlmetadatarecord; //break;
                    $execomekaitem = $db->query($sqlomekaitemfind, array($pagestext3['item_id']));
                    $omekaitem = $execomekaitem->fetch();

                    //$sqlmetadatarecordvalue_element_location = "select * from metadata_element_value where record_id=" . $metadatarecord['id'] . " and element_hierarchy=32 ORDER BY element_hierarchy ASC";
                    $exec = $db->query($sqlmetadatarecordvalue_element_location, array($metadatarecord['id'], 32));
                    $metadatarecordvalue_res = $exec->fetch();
                    if (strlen($metadatarecordvalue_res['value']) > 0) {
                        if ($metadatarecord['id'] > 0) {
                            // $output .= '<file inText="yes" order="' . $pagestext3['order'] . '">';
                            $output .= '<file>';
                            $output .= '<inText>';
                            $output .= 'yes';
                            $output .= '</inText>' . "\n";
                            $output .= '<order>';
                            $output .= '' . $pagestext3['order'] . '';
                            $output .= '</order>' . "\n";
                            $output .= '<caption>';
                            $output .= '<![CDATA[';
                            $output .= '' . trim(nls2p($pagestext3['caption'])) . '';
                            $output .= ']]>';
                            $output .= '</caption>' . "\n";





                            $output .= '<metadata>';
                            $output .= '<lom>';

//query for creating general elements pelement=0		 
                            //$sql3 = "SELECT c.*,b.machine_name,b.id as elm_id2 FROM  metadata_element b  LEFT JOIN metadata_element_hierarchy c 
                            //ON c.element_id = b.id WHERE c.pelement_id=0 and c.is_visible=1  ORDER BY (case WHEN c.sequence IS NULL THEN '9999' ELSE c.sequence END) ASC;";
                            $exec3 = $db->query($sql3, array(0, 1));
                            $datageneral3 = $exec3->fetchAll();


/////////////////////////




                            foreach ($datageneral3 as $datageneral3) {

                                $output2 = '';
                                //$sql4 = "SELECT c.*,b.machine_name,b.id as elm_id FROM  metadata_element b  LEFT JOIN metadata_element_hierarchy c 
                                //ON c.element_id = b.id  WHERE c.pelement_id=" . $datageneral3['elm_id2'] . " and c.is_visible=1 ORDER BY (case WHEN c.sequence IS NULL THEN '9999' ELSE c.sequence END) ASC;";
                                //echo $sql4;break;
                                $exec4 = $db->query($sql4, array($datageneral3['elm_id2'], 1));
                                $datageneral4 = $exec4->fetchAll();


                                if ($datageneral3['machine_name'] == 'rights') { ///////if RIGHTS
                                    $output2.= preview_elements($datageneral4, NULL, $metadatarecord, $datageneral3, '');
                                } elseif ($datageneral3['machine_name'] == 'classification') { ///////if CLASSIFICATION
                                    $output.= preview_elements($datageneral4, NULL, $metadatarecord, $datageneral3, '');
                                } elseif ($datageneral3['machine_name'] == 'relation') { ///////if RELATION
                                    $output2.= preview_elements($datageneral4, NULL, $metadatarecord, $datageneral3, '');
                                } else { ///the rest parent elements///////////////////////////////
                                    foreach ($datageneral4 as $datageneral4) {



                                        //$sql5 = "SELECT * FROM  metadata_element_value WHERE record_id=" . $metadatarecord['id'] . " and element_hierarchy=" . $datageneral4['id'] . " ORDER BY multi ASC;";
                                        //echo $sql4."<br>";
                                        $exec5 = $db->query($standar_query, array($metadatarecord['id'], $datageneral4['id']));
                                        $datageneral5 = $exec5->fetchAll();
                                        $count_results = count($datageneral5);

                                        if ($count_results > 0) {

                                            if ($datageneral3['machine_name'] == 'general') { ///////if GENERAL
                                                $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                                            } elseif ($datageneral3['machine_name'] == 'educational') { ///////if EDUCATIONAL
                                                $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                                            } elseif ($datageneral3['machine_name'] == 'technical') { ///////if TECHNICAL
                                                $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                                            } elseif ($datageneral3['machine_name'] == 'lifeCycle') { ///////if LIFECYCLE
                                                $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                                            } elseif ($datageneral3['machine_name'] == 'metaMetadata') { ///////if META-METADATA
                                                $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                                            } elseif ($datageneral3['machine_name'] == 'annotation') { ///////if ANNOTATION
                                                $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                                            } else {
                                                $output2.= preview_elements_from_datatype($datageneral4, $datageneral5, $metadatarecord, NULL, '');
                                            }
                                        }//if count_results
                                    }//datageneral4
                                } ///the rest parent elements///////////////////////////////	
                                ////////////////echo the result of all parent element if exist
                                if (strlen($output2) > 0) {

                                    $output.= '<' . $datageneral3['machine_name'] . '>';
                                    $output .= '<label>';
                                    $output .=get_label_from_element_id($datageneral3['id'], $language);
                                    $output .= '</label>' . "\n";
                                    $output.= $output2;
                                    $output.= '</' . $datageneral3['machine_name'] . '>' . "\n";
                                }
                            }//datageneral3



                            $output .= '</lom>' . "\n";
                            $output .= '</metadata>' . "\n";

                            $sqlomekaitemfile = "select * from omeka_files where item_id=" . $omekaitem['id'] . "";
//echo $sqlmetadatarecord; //break;
                            $execomekaitemfile = $db->query($sqlomekaitemfile);
                            $omekaitemfile = $execomekaitemfile->fetch();

                            if (strlen($omekaitemfile['archive_filename']) > 4 and $omekaitem['item_type_id'] == 6) {
                                $filefile = 'http://' . $_SERVER['SERVER_NAME'] . '' . uri('archive/files/' . $omekaitemfile['archive_filename'] . '');
                                if (is_array(getimagesize($filefile))) {
                                    $output .= '<thumbs>';
                                    $output .= '<full>';
                                    $output .= 'http://' . $_SERVER['SERVER_NAME'] . '' . uri('archive/files/' . $omekaitemfile['archive_filename'] . '');
                                    $output .= '</full>' . "\n";
                                    $output .= '<thumbnails>';
                                    $output .= 'http://' . $_SERVER['SERVER_NAME'] . '' . uri('archive/thumbnails/' . $omekaitemfile['archive_filename'] . '');
                                    $output .= '</thumbnails>' . "\n";
                                    $output .= '<square_thumbnails>';
                                    $output .= 'http://' . $_SERVER['SERVER_NAME'] . '' . uri('archive/square_thumbnails/' . $omekaitemfile['archive_filename'] . '');
                                    $output .= '</square_thumbnails>' . "\n";
                                    $output .= '</thumbs>' . "\n";
                                }
                            }
                            $euroepanasql = "select * from metadata_element_value where element_hierarchy=34 and record_id=" . $metadatarecord['id'] . "";
//echo $sqlmetadatarecord; //break;
                            $europeanaexec = $db->query($euroepanasql);
                            $europeanaid = $europeanaexec->fetch();
                            $europeanaid = $europeanaid['value'];
                            if (isset($europeanaid) and strlen($europeanaid) > 10 and $europeanaid != 'Natural_Europe_TUC' and $europeanaid != 'Ariadne') {
                                $output .= '<europeana>';
                                $output .= '<url>';
                                $output .= '<![CDATA[';
                                 $output .= $europeanaid;
                                $output .= ']]>';
                                $output .= '</url>' . "\n";
                                $output .= '</europeana>' . "\n";
                            }


                            $output .= '</file>' . "\n";
                        }///if($metadatarecord['id']>0){
                    }
                }
                $output .= '</order>' . "\n";
            }
            if ($checkorder < 2) {
                $output .= '<order>';
                $output .= '<ordering>';
                $checkordervalue+=1;
                $output .= '' . $checkordervalue . '';
                $output .= '</ordering>' . "\n";
                $output .= '</order>' . "\n";
            }



            $output .= '</general>' . "\n";
            $output .= '</lom>' . "\n";
            $output .= '</metadata>' . "\n";



            $maxIdSQL = "select * from omeka_teasers where exhibit_id=" . $identifier . " and type!='europeana' and pg_id=" . $pages['id'] . " and sec_id=" . $sections2['id'];
//echo $maxIdSQL;break;
            $exec = $db->query($maxIdSQL);
            $result_multi = $exec->fetchAll();
            foreach ($result_multi as $result_multi) {
                if ($result_multi['item_id'] > 0) {

                    $sqlmetadatarecord = "select * from metadata_record where object_id=" . $result_multi['item_id'] . " and object_type='item' and validate=1";
//echo $sqlmetadatarecord; //break;
                    $exec2 = $db->query($sqlmetadatarecord);
                    $metadatarecord = $exec2->fetch();

                    //$sqlomekaitem = "select * from omeka_items where id=" . $result_multi['item_id'] . "";
                    $sqlomekaitem = $db->query($sqlomekaitemfind, array($result_multi['item_id']));
//echo $sqlmetadatarecord; //break;
                    //$execomekaitem = $db->query($sqlomekaitem);
                    $omekaitem = $sqlomekaitem->fetch();


                    if ($metadatarecord['id'] > 0) {

                        //$sqlmetadatarecordvalue_element_location = "select * from metadata_element_value where record_id=" . $metadatarecord['id'] . " and element_hierarchy=32 ORDER BY element_hierarchy ASC";
                        $exec = $db->query($sqlmetadatarecordvalue_element_location, array($metadatarecord['id'], 32));
                        $metadatarecordvalue_res = $exec->fetch();
//echo $sqlmetadatarecordvalue; break;
//$metadatarecordvalue_res=mysql_query($sqlmetadatarecordvalue);
//$metadatarecordvalue=mysql_fetch_array($metadatarecordvalue_res);


                        if (strlen($metadatarecordvalue_res['value']) > 0) {

                            $output .= '<file>';
                            $output .= '<metadata>';
                            $output .= '<lom>';

//query for creating general elements pelement=0		 
                            //$sql3 = "SELECT c.*,b.machine_name,b.id as elm_id2 FROM  metadata_element b  LEFT JOIN metadata_element_hierarchy c 
                            //ON c.element_id = b.id WHERE c.pelement_id=0 and c.is_visible=1  ORDER BY (case WHEN c.sequence IS NULL THEN '9999' ELSE c.sequence END) ASC;";
                            $exec3 = $db->query($sql3, array(0, 1));
                            $datageneral3 = $exec3->fetchAll();


/////////////////////////




                            foreach ($datageneral3 as $datageneral3) {

                                $output2 = '';
                                //$sql4 = "SELECT c.*,b.machine_name,b.id as elm_id FROM  metadata_element b  LEFT JOIN metadata_element_hierarchy c 
                                //ON c.element_id = b.id  WHERE c.pelement_id=" . $datageneral3['elm_id2'] . " and c.is_visible=1 ORDER BY (case WHEN c.sequence IS NULL THEN '9999' ELSE c.sequence END) ASC;";
                                //echo $sql4;break;
                                $exec4 = $db->query($sql4, array($datageneral3['elm_id2'], 1));
                                $datageneral4 = $exec4->fetchAll();


                                if ($datageneral3['machine_name'] == 'rights') { ///////if RIGHTS
                                    $output2.= preview_elements($datageneral4, NULL, $metadatarecord, $datageneral3, '');
                                } elseif ($datageneral3['machine_name'] == 'classification') { ///////if CLASSIFICATION
                                    $output.= preview_elements($datageneral4, NULL, $metadatarecord, $datageneral3, '');
                                } elseif ($datageneral3['machine_name'] == 'relation') { ///////if RELATION
                                    $output2.= preview_elements($datageneral4, NULL, $metadatarecord, $datageneral3, '');
                                } else { ///the rest parent elements///////////////////////////////
                                    foreach ($datageneral4 as $datageneral4) {



                                        //$sql5 = "SELECT * FROM  metadata_element_value WHERE record_id=" . $metadatarecord['id'] . " and element_hierarchy=" . $datageneral4['id'] . " ORDER BY multi ASC;";
                                        //echo $sql4."<br>";
                                        $exec5 = $db->query($standar_query, array($metadatarecord['id'], $datageneral4['id']));
                                        $datageneral5 = $exec5->fetchAll();
                                        $count_results = count($datageneral5);

                                        if ($count_results > 0) {

                                            if ($datageneral3['machine_name'] == 'general') { ///////if GENERAL
                                                $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                                            } elseif ($datageneral3['machine_name'] == 'educational') { ///////if EDUCATIONAL
                                                $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                                            } elseif ($datageneral3['machine_name'] == 'technical') { ///////if TECHNICAL
                                                $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                                            } elseif ($datageneral3['machine_name'] == 'lifeCycle') { ///////if LIFECYCLE
                                                $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                                            } elseif ($datageneral3['machine_name'] == 'metaMetadata') { ///////if META-METADATA
                                                $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                                            } elseif ($datageneral3['machine_name'] == 'annotation') { ///////if ANNOTATION
                                                $output2.= preview_elements($datageneral4, $datageneral5, $metadatarecord, $datageneral3, '');
                                            } else {
                                                $output2.= preview_elements_from_datatype($datageneral4, $datageneral5, $metadatarecord, NULL, '');
                                            }
                                        }//if count_results
                                    }//datageneral4
                                } ///the rest parent elements///////////////////////////////	
                                ////////////////echo the result of all parent element if exist
                                if (strlen($output2) > 0) {

                                    $output.= '<' . $datageneral3['machine_name'] . '>';
                                    $output .= '<label>';
                                    $output .=get_label_from_element_id($datageneral3['id'], $language);
                                    $output .= '</label>' . "\n";
                                    $output.= $output2;
                                    $output.= '</' . $datageneral3['machine_name'] . '>' . "\n";
                                }
                            }//datageneral3



                            $output .= '</lom>' . "\n";
                            $output .= '</metadata>' . "\n";

                            $sqlomekaitemfile = "select * from omeka_files where item_id=" . $omekaitem['id'] . "";
//echo $sqlmetadatarecord; //break;
                            $execomekaitemfile = $db->query($sqlomekaitemfile);
                            $omekaitemfile = $execomekaitemfile->fetch();
                            if (strlen($omekaitemfile['archive_filename']) > 4 and $omekaitem['item_type_id'] == 6) {
                                $filefile = 'http://' . $_SERVER['SERVER_NAME'] . '' . uri('archive/files/' . $omekaitemfile['archive_filename'] . '');
                                if (is_array(getimagesize($filefile))) {
                                    $output .= '<thumbs>';
                                    $output .= '<full>';
                                    $output .= 'http://' . $_SERVER['SERVER_NAME'] . '' . uri('archive/files/' . $omekaitemfile['archive_filename'] . '');
                                    $output .= '</full>' . "\n";
                                    $output .= '<thumbnails>';
                                    $output .= 'http://' . $_SERVER['SERVER_NAME'] . '' . uri('archive/thumbnails/' . $omekaitemfile['archive_filename'] . '');
                                    $output .= '</thumbnails>' . "\n";
                                    $output .= '<square_thumbnails>';
                                    $output .= 'http://' . $_SERVER['SERVER_NAME'] . '' . uri('archive/square_thumbnails/' . $omekaitemfile['archive_filename'] . '');
                                    $output .= '</square_thumbnails>' . "\n";
                                    $output .= '</thumbs>' . "\n";
                                }
                            }
                            $euroepanasql = "select * from metadata_element_value where element_hierarchy=34 and record_id=" . $metadatarecord['id'] . "";
//echo $euroepanasql; break;
                            $europeanaexec = $db->query($euroepanasql);
                            $europeanaid = $europeanaexec->fetch();
                            $europeanaid = $europeanaid['value'];
                            if (isset($europeanaid) and strlen($europeanaid) > 10 and $europeanaid != 'Natural_Europe_TUC' and $europeanaid != 'Ariadne') {
                                $output .= '<europeana>';
                                $output .= '<url>';
                                $output .= '<![CDATA[';
                                $output .= $europeanaid;
                                $output .= ']]>';
                                $output .= '</url>' . "\n";
                                $output .= '</europeana>' . "\n";
                            }
                            $output .= '</file>' . "\n";
                        }
                    }
                }
            }




            $output .= '</resource>' . "\n";
        }
    }

    $output .= '</resources>' . "\n";
    $recordsfortranslation = array('You are here', 'Pathways', 'Supporting Materials', 'Access the Resource', 'Email', 'Full Name', 'Organization', 'Print', 'Name', 'Surname', 'Pathway last saved at', 'License');
    $output .= '<records>';
    foreach ($recordsfortranslation as $recordsfortranslation) {
        $output .= '<record>';
        $output .= '<id>';
        $output .= '' . str_replace(" ", "_", "$recordsfortranslation") . '';
        $output .= '</id>' . "\n";
        $output .= '<english_value>';
        $output .= '' . $recordsfortranslation . '';
        $output .= '</english_value>' . "\n";
        $output .= '<english_translation>';
        $output .= '' . __($recordsfortranslation) . '';
        $output .= '</english_translation>' . "\n";
        $output .= '</record>' . "\n";
    }
    $recordsfortranslation = array(9, 22, 50, 4);
    foreach ($recordsfortranslation as $recordsfortranslation) {
        $recordsfortranslationtext = get_label_from_element_id($recordsfortranslation, 'en');
        $recordsfortranslationtexttranslated = get_label_from_element_id($recordsfortranslation, $language);
        $output .= '<record>';
        $output .= '<id>';
        $output .= '' . str_replace(" ", "_", "$recordsfortranslationtext") . '';
        $output .= '</id>' . "\n";
        $output .= '<english_value>';
        $output .= '' . $recordsfortranslationtext . '';
        $output .= '</english_value>' . "\n";
        $output .= '<english_translation>';
        $output .= '' . $recordsfortranslationtexttranslated . '';
        $output .= '</english_translation>' . "\n";
        $output .= '</record>' . "\n";
    }
    $output .= '</records>' . "\n";
}//if no errors!!!
?>
