<?php head(array('title' => 'Browse Items', 'content_class' => 'horizontal-nav', 'bodyclass' => 'items primary browse-items')); ?>
<h1><?php echo __('Ingest a Resource from Natural Europe federation'); ?></h1>
<?php if (has_permission('Items', 'add')): ?>

    <?php

    function onlyNumbers($string) {
        //This function removes all characters other than numbers
        $string = preg_replace("/[^0-9]/", "", $string);
        return (int) $string;
    }

    $exhibit_id = onlyNumbers($_GET['ex_id']);
    $sec_id = onlyNumbers($_GET['sec_id']);
    $pg_id = onlyNumbers($_GET['pg_id']);
    ?>
    <div style="text-align:center; width:850px;">
        <form action="#" method="post" style="text-align:center;">
            <div style="text-align:center;">
                <img src="<?php echo uri('themes/default/items/images/logonatural.png'); ?>"><br>
                <?php echo __('Search in Natural Europe'); ?>: 
            </div>
            <div style="text-align:center;">
                <input type="text" name="europeanatext"> 
                <input type="submit" class="button" value="<?php echo __('Search'); ?>" style="float:none;">
            </div>
        </form>

        <style>
            a {
                color:black;
                text-decoration:none;
            }
            #active{
                background-color:#cc6600;
                color:#ffffff;
            }
        </style>

        <?php
// Get SimpleXMLElement object from an XML document
//$xml = simplexml_load_file("http://api.europeana.eu/api/opensearch.rss?searchTerms=bible&startPage=1&wskey=IIRTOOIRNG");
// Get XML string from a SimpleXML element
// When you select "View source" in the browser window, you will see the objects and elements
//echo $xml->asXML();
        if (isset($_POST['europeanatext'])) {
            $europeanatext = $_POST['europeanatext'];
            $_POST['europeanatext'] = str_replace(' ', '+', $_POST['europeanatext']);
            if (isset($_POST['startPage'])) {
                $startPage = $_POST['startPage'];
                $offset = $_POST['startPage'] * 12 - 12;
            } else {
                $offset = 0;
                $startPage = 1;
            }
            if (isset($_POST['bytype'])) {
                $bytypeforurl = $_POST['bytype'];
            } else {
                $bytypeforurl = "";
            }
            ?>
            <div>
                        <em><strong><?php echo __('Filter results by type'); ?>: </strong></em><br> 
                <script>
                    function GoType(type){
                        document.form4.bytype.value=''+type+'';
                        document.form4.submit();}
                </script>
                <form action="#" method="post" name="form4">
                    <input type="hidden" name="europeanatext" value="<?php echo $_POST['europeanatext']; ?>">
                    <input type="hidden" name="startPage" value="1">
                    <?php
                    if (isset($_POST['bytype'])) {
                        $bytype = $_POST['bytype'];
                    } else {
                        $bytype = '';
                    }
                    ?>
                    <input type="hidden" name="bytype" value="<?php echo $bytype; ?>">

                                        <div style="float:left; text-align:center;">
                      <?php    echo __('IMAGE'); ?><br>
                      <a href="#" onclick="GoType('IMAGE');"><img src="<?php echo uri('themes/default/items/images/image_icon.png'); ?>"> </a>
                      </div>
                      <div style="float:left;margin-left:10px;text-align:center;">
                      <?php    echo __('TEXT'); ?><br>
                      <a href="#" onclick="GoType('TEXT');"><img src="<?php echo uri('themes/default/items/images/text_icon.gif'); ?>"> </a>
                      </div>
                      <div style="float:left;margin-left:10px;text-align:center;">
                      <?php    echo __('VIDEO'); ?><br>
                      <a href="#" onclick="GoType('VIDEO');"><img src="<?php echo uri('themes/default/items/images/video_icon.png'); ?>"> </a>
                      </div>
                      <div style="float:left;margin-left:10px;text-align:center;">
                      <?php    echo __('SOUND'); ?><br>
                      <a href="#" onclick="GoType('SOUND');"><img src="<?php echo uri('themes/default/items/images/sound_icon.png'); ?>"> </a>
                      </div>
                     

                </form>
            </div>
            <?php
            $europeanatext_forcultural = urlencode($europeanatext);
            $resp = call_cultural_federation($europeanatext_forcultural, $offset, $bytypeforurl);            //print_r($resp);break;

            $output = '';
            if ($resp) {

                foreach ($resp as $key => $resp1) {
                    //echo $key . '<br>';
                    foreach ($resp1 as $key2 => $resp2) {
                        if ($key2 == 'nrOfResults') {
                            $totalResults = $resp2;
                        }
                        if ($key2 == 'metadata') {
                            foreach ($resp2 as $key3 => $resp3) {
                                //print_r($resp3);

                                $output.= "<div style='width:805px; margin-top:10px;clear:both;'>";
                                $output.= '<div style="float:left; width:130px;">';
                                if (strlen($resp3['thumbnailUri']) > 0) {
                                    $output.= "<a href='" . $resp3['objectUri'] . "' target='_new'><img src='" . $resp3['thumbnailUri'] . " ' width='100' height='100' border='0'></a><br />";
                                } elseif ($resp3['format'] == 'text/html') {
                                    $output.= '<a href="' . $resp3['objectUri'] . '" target="_new"><img src="http://img.bitpixels.com/getthumbnail?code=29089&size=200&url=' . $resp3['objectUri'] . '" width="100" height="100" border="0"></a><br />';
                                } elseif ($resp3['format'] == 'application/pdf') {
                                    $uri = WEB_ROOT;
                                    $output.= '<a href="' . $resp3['objectUri'] . '" target="_new"><img src="' . $uri . '/application/views/scripts/images/files-icons/pdf.png" width="100" height="100" border="0"></a><br />';
                                } elseif (stripos($resp3['objectUri'], ".pdf") > 0) {
                                    $uri = WEB_ROOT;
                                    $output.= '<a href="' . $resp3['objectUri'] . '" target="_new"><img src="' . $uri . '/application/views/scripts/images/files-icons/pdf.png" width="100" height="100" border="0"></a><br />';
                                } elseif ($resp3['format'] == 'application/msword' or $resp3['format'] == 'text') {
                                    $uri = WEB_ROOT;
                                    $output.= '<a href="' . $resp3['objectUri'] . '" target="_new"><img src="' . $uri . '/application/views/scripts/images/files-icons/word.png" width="100" height="100" border="0"></a><br />';
                                } elseif ($resp3['format'] == 'video/x-ms-wmv' or $resp3['format'] == 'video') {
                                    $uri = WEB_ROOT;
                                    $output.= '<a href="' . $resp3['objectUri'] . '" target="_new"><img src="' . $uri . '/application/views/scripts/images/files-icons/video.png" width="100" height="100" border="0"></a><br />';
                                } elseif ($resp3['format'] == 'application/vnd.ms-powerpoint') {
                                    $uri = WEB_ROOT;
                                    $output.= '<a href="' . $resp3['objectUri'] . '" target="_new"><img src="' . $uri . '/application/views/scripts/images/files-icons/powerpoint.png" width="100" height="100" border="0"></a><br />';
                                } else {
                                    $output.= '<a href="' . $resp3['objectUri'] . '" target="_new"><img src="http://img.bitpixels.com/getthumbnail?code=29089&size=200&url=' . $resp3['objectUri'] . '" width="100" height="100" border="0"></a><br />';
                                }

                                $output.='</div>';
                                $output.= '<div style="float:left;width:605px;">';

                                $titleforloop = $resp3['title'];
                                $titlegen = '';
                                $title1 = '';
                                $titleinter = '';
                                $titleen = '';
                                $title = '';
                                foreach ($titleforloop as $titleforloop) {
                                    if ($titleforloop['lang'] == $_SESSION['get_language']) {
                                        $titleinter = $titleforloop['value'];
                                    } elseif ($titleforloop['lang'] == 'en') {
                                        $titleen = $titleforloop['value'];
                                    } elseif (strlen($title) == 0) {
                                        $title1 = $titleforloop['value'];
                                    } else {
                                        $titlegen = $titleforloop['value'];
                                    }
                                }
                                if (strlen($titleinter) > 0) {
                                    $title = $titleinter;
                                } elseif (strlen($titleen) > 0) {
                                    $title = $titleen;
                                } elseif (strlen($title1) > 0) {
                                    $title = $title1;
                                } elseif (strlen($titlegen) > 0) {
                                    $title = $titlegen;
                                } else {
                                    $title = $resp3['title'];
                                }
                                $title = preg_replace('/(["\'])/ie', '', $title);
                                $output.="<strong>" . $title . "</strong><br />";

                                $descripforloop = $resp3['description'];
                                $descripgen = '';
                                $descrip1 = '';
                                $descripinter = '';
                                $descripen = '';
                                $descrip = '';
                                foreach ($descripforloop as $descripforloop) {
                                    if ($descripforloop['lang'] == $_SESSION['get_language']) {
                                        $descripinter = $descripforloop['value'];
                                    } elseif ($descripforloop['lang'] == 'en') {
                                        $descripen = $descripforloop['value'];
                                    } elseif (strlen($descrip) == 0) {
                                        $descrip1 = $descripforloop['value'];
                                    } else {
                                        $descripgen = $descripforloop['value'];
                                    }
                                }
                                if (strlen($descripinter) > 0) {
                                    $descrip = $descripinter;
                                } elseif (strlen($descripen) > 0) {
                                    $descrip = $descripen;
                                } elseif (strlen($descrip1) > 0) {
                                    $descrip = $descrip1;
                                } elseif (strlen($descripgen) > 0) {
                                    $descrip = $descripgen;
                                } else {
                                    $descrip = $resp3['description'];
                                }
                                $descrip = preg_replace('/(["\'])/ie', '', $descrip);
                                $output.="" . $descrip . "<br />";
                                //Use that namespace

                                $output.= "<a href='" . $resp3['objectUri'] . "' target='_new'>" . __('Access to the resource') . "</a><br>";
                                $output.= "<a href='" . $resp3['licenseUri'] . "' target='_new'>" . __('Rights') . "</a><br>";
                                if (strlen($resp3['dataProvider']) > 2) {
                                    $output.= "<strong>" . __('Provider') . " : </strong>" . $resp3['dataProvider'] . "<br />";
                                }

                                //  print  "<br><a href='". $resp3['fpath']."' target='_new'>".__('View Metadata')."</a>";
                                $source = $resp3['objectUri'];
                                $source = preg_replace('/(["\'])/ie', '', $source);
                                $format = $resp3['contentType'];
                                $user = current_user();
                                $params = array('title' => $title,
                                    'description' => $descrip,
                                    'source' => 'Natural_Europe_TUC',
                                    'format' => $format,
                                    'identifier' => $source,
                                    'user' => $user['entity_id']);
                                $output.= '<form method="post" target="_blank" name="' . $cb . '" action="' . uri("items/addinjestitem") . '">';


                                $output.= '<input type="hidden" name="title" value="'.base64_encode(json_encode($resp3['title'])).'">';
                                $output.= '<input type="hidden" name="description" value="'.base64_encode(json_encode($resp3['description'])).'">';
                                $output.= '<input type="hidden" name="source" value="Natural_Europe_TUC">';
                                $output.= '<input type="hidden" name="format" value="' . $format . '">';
                                $output.= '<input type="hidden" name="identifier" value="' . $source . '">';
                                $output.= '<input type="hidden" name="user" value="' . $user['entity_id'] . '">';
                                //echo '<br><div style="position:relative; top:2px;height:40px;"><a style="position:relative; top:10px;background-color: #F4F3EB;
                                //  color: #CC5500;
                                // padding-bottom: 10px;
                                // padding-right: 10px;
                                //padding-left: 10px;
                                // padding-top: 10px;" href="'.uri("items/addinjestitem",$params).'">Add it to my Repository</a>';
                                //echo '</div>';
                                $output.= "<br><div style='position:relative; top:-12px;height:40px;'>
<input id='newsubmit' type='submit' value='" . __('Add it to my Repository') . "' name='insert' 
style='background-color:#F4F3EB;color: #CC5500; background-image:none; border:none; float:left; font-weight:normal;text-shadow:none;'>";
                                $output.= '</div>';
                                $output.= '</form>';

                                $output.='</div>';
                                $output.='</div>';
                            }
                        }
                    }
                }
            }

            echo "<div style='width:850px; border-top:1px solid; border-bottom:1px solid; margin-top:10px;'>";
            // print  "Page you are: ". $startPage."<br />";
            print "" . __('You search') . ": " . $europeanatext . "<br />";
            print "" . __('Total results') . " : " . $totalResults;
            $pages = $totalResults / 12;
            $pages2 = round($pages);
            if ($pages2 > $pages) {
                $pages = $pages2;
            } else {
                $pages = $pages2 + 1;
            }
            echo '</div>';
            if ($pages > 0) {
                $i = 1;
                ?>
                <script>
                    function GoPage(iPage) {
                                                                              
                        document.form2.startPage.value = iPage;
                        document.form2.submit();
                    }

                </script>
                <form action="#" method="post" name="form2" class="pagination" style="float:none; margin-top:10px; width:540px;">
                    <input type="hidden" name="europeanatext" value="<?php echo $_POST['europeanatext']; ?>">
                    <input type="hidden" name="startPage" value="<?php echo $_GET['startPage']; ?>">
                    <?php if (isset($_POST['bytype'])) { ?> <input type="hidden" name="bytype" value="<?php echo $_POST['bytype']; ?>"> <?php } ?>

                    <?php
                    if ($pages < 10) {
                        while ($i <= $pages) {
                            echo "<a href='javascript:GoPage(" . $i . ")'   ";
                            if ($i == $startPage) {
                                echo "id='active'";
                            }
                            echo " >" . $i . "</a> ";
                            $i+=1;
                        }
                    } else {

                        if ($startPage < 8) {
                            while ($i < $pages and $i < 11) {
                                echo "<a href='javascript:GoPage(" . $i . ")'   ";
                                if ($i == $startPage) {
                                    echo "id='active'";
                                }
                                echo " >" . $i . "</a> ";
                                $i+=1;
                            }
                            echo ("...");

                            echo "<a href='javascript:GoPage(" . $pages . ")'   ";
                            if ($i == $startPage) {
                                echo "id='active'";
                            }
                            echo " >" . $pages . "</a> ";
                        } elseif ($startPage < ($pages - 8)) {
                            echo "<a href='javascript:GoPage(1)'   ";
                            if ($i == $startPage) {
                                echo "id='active'";
                            }
                            echo " >1</a> ";
                            echo ("...");
                            $i = $startPage - 5;
                            $x = $startPage + 5;
                            while ($i < $x) {
                                echo "<a href='javascript:GoPage(" . $i . ")'   ";
                                if ($i == $startPage) {
                                    echo "id='active'";
                                }
                                echo " >" . $i . "</a> ";
                                $i+=1;
                            }
                            echo ("...");
                            echo "<a href='javascript:GoPage(" . $pages . ")'   ";
                            if ($i == $startPage) {
                                echo "id='active'";
                            }
                            echo " >" . $pages . "</a> ";
                        }//elseif
                        elseif ($startPage > ($pages - 8)) {
                            echo "<a href='javascript:GoPage(1)'   ";
                            if ($i == $startPage) {
                                echo "id='active'";
                            }
                            echo " >1</a> ";
                            echo ("...");
                            $i = $pages - 10;
                            while ($i < $pages + 1) {
                                echo "<a href='javascript:GoPage(" . $i . ")'   ";
                                if ($i == $startPage) {
                                    echo "id='active'";
                                }
                                echo " >" . $i . "</a> ";
                                $i+=1;
                            }
                        }//elseif
                    }//else kenriko
                    ?>
                </form>

                <div style="float:left; text-align:center; margin-top:20px;">
            <?php echo ingest_search_total_block('' . $europeanatext . '', 1); ?>
                </div> 

                <div style="float:left; width:670px; margin-left:25px;margin-top:20px;">
            <?php echo $output; ?>
                </div>
                <script>
                    function GoPage2(iPage) {
                                                                              
                        document.form3.startPage.value = iPage;
                        document.form3.submit();
                    }

                </script>
                <form action="#" method="post" name="form3" class="pagination" style="float:none; margin-top:10px; width:540px;">
                    <input type="hidden" name="europeanatext" value="<?php echo $_POST['europeanatext']; ?>">
                    <input type="hidden" name="startPage" value="<?php echo $_GET['startPage']; ?>">
                    <?php if (isset($_POST['bytype'])) { ?> <input type="hidden" name="bytype" value="<?php echo $_POST['bytype']; ?>"> <?php } ?>

                    <?php
                    $i = 1;
                    if ($pages < 10) {
                        while ($i <= $pages) {
                            echo "<a href='javascript:GoPage2(" . $i . ")'   ";
                            if ($i == $startPage) {
                                echo "id='active'";
                            }
                            echo " >" . $i . "</a> ";
                            $i+=1;
                        }
                    } else {

                        if ($startPage < 8) {
                            while ($i < $pages and $i < 11) {
                                echo "<a href='javascript:GoPage2(" . $i . ")'   ";
                                if ($i == $startPage) {
                                    echo "id='active'";
                                }
                                echo " >" . $i . "</a> ";
                                $i+=1;
                            }
                            echo ("...");

                            echo "<a href='javascript:GoPage2(" . $pages . ")'   ";
                            if ($i == $startPage) {
                                echo "id='active'";
                            }
                            echo " >" . $pages . "</a> ";
                        } elseif ($startPage < ($pages - 8)) {
                            echo "<a href='javascript:GoPage2(1)'   ";
                            if ($i == $startPage) {
                                echo "id='active'";
                            }
                            echo " >1</a> ";
                            echo ("...");
                            $i = $startPage - 5;
                            $x = $startPage + 5;
                            while ($i < $x) {
                                echo "<a href='javascript:GoPage2(" . $i . ")'   ";
                                if ($i == $startPage) {
                                    echo "id='active'";
                                }
                                echo " >" . $i . "</a> ";
                                $i+=1;
                            }
                            echo ("...");
                            echo "<a href='javascript:GoPage2(" . $pages . ")'   ";
                            if ($i == $startPage) {
                                echo "id='active'";
                            }
                            echo " >" . $pages . "</a> ";
                        }//elseif
                        elseif ($startPage > ($pages - 8)) {
                            echo "<a href='javascript:GoPage2(1)'   ";
                            if ($i == $startPage) {
                                echo "id='active'";
                            }
                            echo " >1</a> ";
                            echo ("...");
                            $i = $pages - 10;
                            while ($i < $pages + 1) {
                                echo "<a href='javascript:GoPage2(" . $i . ")'   ";
                                if ($i == $startPage) {
                                    echo "id='active'";
                                }
                                echo " >" . $i . "</a> ";
                                $i+=1;
                            }
                        }//elseif
                    }//else kenriko
                    ?>
                </form>
            <?php
        }//if pages>0
        echo "</div>";
    }//is iiset europeana text
    ?>
    </div>
    <?php
endif; //permission to add item
?>
</div>

</div>