<?php

require_once(dirname(__FILE__) . '/converttopdf/html2pdf.class.php');
require_once 'Omeka/Core.php';
$core = new Omeka_Core;

try {
    $db = $core->getDb();

    //Force the Zend_Db to make the connection and catch connection errors
    try {
        $mysqli = $db->getConnection()->getConnection();
    } catch (Exception $e) {
        throw new Exception("<h1>MySQL connection error: [" . mysqli_connect_errno() . "]</h1>" . "<p>" . $e->getMessage() . '</p>');
    }
} catch (Exception $e) {
    die($e->getMessage() . '<p>Please refer to <a href="http://omeka.org/codex/">Omeka documentation</a> for help.</p>');
}
$metadataFile = Zend_Registry::get('metadataFile'); /////read metadata file
// LOGO!!!!
$content = '<img src="' . dirname(__FILE__) . '/images/logo_n.png">';
$content .="<h1>" . $exhibit['title'] . "</h1>";


$sqlehibitsections = "select * from omeka_sections where exhibit_id=" . $exhibit['id'] . " ";
//echo $sqlehibitsections; break;
$ehibitsections = $db->query($sqlehibitsections);
$sections = $ehibitsections->fetchAll();
$sqlmetadatarecordvalue_element_location = "select * from metadata_element_value where record_id=? and element_hierarchy=? ORDER BY element_hierarchy ASC";

foreach ($sections as $sections2) {
    $content .= '<h2>' . __($sections2['title']) . '</h2>';
    $sqlsectionpages = "select * from omeka_section_pages where section_id=" . $sections2['id'] . " ";
//echo $sqlsectionpages; 
    $sectionpages = $db->query($sqlsectionpages);
    $pages = $sectionpages->fetchAll();

    foreach ($pages as $pages) {
        $content .= '<h5>' . __($pages['title']) . '</h5>';
        $sqlpagestext = "select * from omeka_items_section_pages where page_id=" . $pages['id'] . " ORDER BY `order` ASC";
//echo $sqlmetadatarecord; //break;
        $pagestextr = $db->query($sqlpagestext);
        $pagestext2 = $pagestextr->fetchAll();
        foreach ($pagestext2 as $pagestext) {

            ////replace strange space ascii character////////////////
            $pagestexttext = trim($pagestext['text']);
            $pagestexttext = trim($pagestexttext, chr(0xC2) . chr(0xA0) . chr(0xb));
            $pagestexttext = str_replace("", " ", $pagestext['text']);

            $content .= trim($pagestexttext) . "<br>";
            if ($pagestext['item_id'] > 0) {


                $sqlmetadatarecord = "select * from metadata_record where object_id=" . $pagestext['item_id'] . " and object_type='item' and validate=1";
//echo $sqlmetadatarecord; break;
                $exec2 = $db->query($sqlmetadatarecord);
                $metadatarecord = $exec2->fetch();


                if (isset($metadatarecord['id']) and $metadatarecord['id'] > 0) {
                    //echo $metadataFile[metadata_schema_resources][element_hierarchy_location].'<br>'; break;
                    $exec = $db->query($sqlmetadatarecordvalue_element_location, array($metadatarecord['id'], $metadataFile[metadata_schema_resources][element_hierarchy_location]));
                    $metadatarecordvalue_res = $exec->fetch();
                    if (strlen($metadatarecordvalue_res['value']) > 0) {
                        if (is_array(getimagesize($metadatarecordvalue_res['value']))) {
                            $metadatarecordvalue_res['value'] = str_replace('http://', '', $metadatarecordvalue_res['value']);
                            $content .= '<a href="' . $metadatarecordvalue_res['value'] . '" target="new"><img src="http://images.weserv.nl/?url='.$metadatarecordvalue_res['value'].'&w=135&h=110&t=square&a=t" style="width:150px; height:150px;"></a>';
                        } else {
                            $content .= '<a href="' . $metadatarecordvalue_res['value'] . '" target="new">' . $metadatarecordvalue_res['value'] . '</a>';
                        }
                    }
                }
            }
        }
        

/// Add supporting material
        $maxIdSQL = "select * from omeka_teasers where exhibit_id=" . $exhibit['id'] . " and type!='europeana' and pg_id=" . $pages['id'] . " and sec_id=" . $sections2['id'];
//echo $maxIdSQL.'<br>';//break;
        $exec = $db->query($maxIdSQL);
        $result_multi = $exec->fetchAll();
        $outputteasers = '';
        $countteasers = 0;
        foreach ($result_multi as $result_multi) {
            $countteasers+=1;
            //echo $result_multi['item_id']; break;
            if (isset($result_multi['item_id']) and $result_multi['item_id'] > 0) {
//echo $result_multi['item_id'].'<br>'; break;
                $sqlmetadatarecord = "select * from metadata_record where object_id=" . $result_multi['item_id'] . " and object_type='item' and validate=1";
//echo $sqlmetadatarecord; break;
                $exec2 = $db->query($sqlmetadatarecord);
                $metadatarecord = $exec2->fetch();


                if ($metadatarecord['id'] > 0) {

                    //$sqlmetadatarecordvalue_element_location = "select * from metadata_element_value where record_id=" . $metadatarecord['id'] . " and element_hierarchy=32 ORDER BY element_hierarchy ASC";
                    $exec = $db->query($sqlmetadatarecordvalue_element_location, array($metadatarecord['id'], 32));
                    $metadatarecordvalue_res = $exec->fetch();

                    if (strlen($metadatarecordvalue_res['value']) > 0) {
                            $outputteasers .= '<a href="' . $metadatarecordvalue_res['value'] . '" target="new">' . $metadatarecordvalue_res['value'] . '</a>';
                    }
                }
            }
        }
        if ($countteasers > 0) {
            $content .= '<h4>' . __('Supporting Materials') . '</h4>';
            $content .= $outputteasers;
        }
    }
}


$content = '<page style="font-family: freeserif"><br />' . nl2br($content) . '</page>';

// convert to PDF
try {
    $html2pdf = new HTML2PDF('P', 'A4', 'en');
    $html2pdf->pdf->SetTitle(h($exhibit['title']));
    $html2pdf->pdf->SetDisplayMode('real');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output(h($exhibit['title']) . '.pdf');
    //$html2pdf->Output(''.$exhibit['title'].'.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>