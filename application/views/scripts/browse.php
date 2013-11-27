<?php head(); ?>
<div id="page-body" class="one_column">
    <?php include ("common/menu.php"); ?>
    <script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/javascripts/jquery.js'); ?>"></script>
    <script>
        jQuery.noConflict();
    </script>
    <script type="text/javascript" language="javascript" src="<?php echo uri('application/views/scripts/pager.js'); ?>"></script>

    <!-- the input fields that will hold the variables we will use -->
    <input type='hidden' id='current_page' />
    <input type='hidden' id='show_per_page' />		




    <div class="column" id="column-c">


        <div class="quick_links exhibits">
            <h2 class="section_sub_title">
                <?php
                if (strlen(target()) > 1) {

                    if ($_GET['nhm'] == 'MNHN') { //if MNHN
                        echo "National Museum of Natural History – University of Lisbon -";
                    }
                    if ($_GET['nhm'] == 'TNHM') { //if MNHN
                        echo "The Estonian Museum of Natural History -";
                    }
                    if ($_GET['nhm'] == 'NHMC') { //if NHMC
                        echo "Natural History Museum of Crete -";
                    }
                    if ($_GET['nhm'] == 'JME') { //if JME
                        echo "Jura-Museum Eichstätt -";
                    }
                    if ($_GET['nhm'] == 'HNHM') { //if HNHM
                        echo "Hungarian Natural History Museum -";
                    }
                    if ($_GET['nhm'] == 'AC') { //if NHMC
                        echo "Arctic-Centre -";
                    }
                }
                ?>
                <?php echo __('Educational Pathways'); ?></h2>
            




            <?php if (strlen(target()) > 1) { ?>
            <script>
                var show_per_page = 15;
            </script>
                <div id='page_navigation' class='page_navigation' style="margin-top:15px; max-width:490px;"></div>

                <ul id="content_paging" class="digital_exhibits"> 
                    <?php
                    if ($menuexhibits):
                        $o = 0;
                        foreach ($menuexhibits as $key => $exhibits2):
                            if ($_GET['nhm'] == 'MNHN') { //if MNHN
                                //print_r($exhibits2); break;
                                if ($exhibits2->wasAddedBy('74')) {//print_r(current_user());
                                    //check the target group of the exhibit
                                    $o+=1;
                                    $exhibits2_id = (string) $exhibits2['id'];
                                    ?>


                                    <?php $target = target(); ?>
                                    <li>
                                        <a target="_blank" href="<?php echo uri('exhibits/show/' . $exhibits2['slug'] . '/to-begin-with'); ?>" class="block"></a>
                                        <?php echo exhibit_picture($exhibits2['id'], '135', 'indexstund'); ?>
                                        <div class="exhibit-data">
                                            <p><?php echo $exhibits2['title']; ?></p>
                                        </div>
                                        <a target="_blank" href="<?php echo uri('exhibits/show/' . $exhibits2['slug'] . '/to-begin-with'); ?>" class="more"><?php echo __('GO NOW!'); ?></a>
                                    </li>




                                    <?php
                                }//if user of mnhm
                            }//if MNHN
                            if ($_GET['nhm'] == 'TNHM') { //if TNHM
                                if ($exhibits2->wasAddedBy('106')) {//print_r(current_user());
                                    //check the target group of the exhibit
                                    $o+=1;
                                    $exhibits2_id = (string) $exhibits2['id'];
                                    ?>


                                    <?php $target = target(); ?>
                                    <li>
                                        <a target="_blank" href="<?php echo uri('exhibits/show/' . $exhibits2['slug'] . '/to-begin-with'); ?>" class="block"></a>
                                        <?php echo exhibit_picture($exhibits2['id'], '135', 'indexstund'); ?>
                                        <div class="exhibit-data">
                                            <p><?php echo $exhibits2['title']; ?></p>
                                        </div>
                                        <a target="_blank" href="<?php echo uri('exhibits/show/' . $exhibits2['slug'] . '/to-begin-with'); ?>" class="more"><?php echo __('GO NOW!'); ?></a>
                                    </li>




                                    <?php
                                }//if user of mnhm
                            }//if TNHM
                            //echo $_GET['nhm'];
                            if ($_GET['nhm'] == 'NHMC') { //if NHMC
                                if ($exhibits2->wasAddedBy('69') or $exhibits2->wasAddedBy('77') or $exhibits2->wasAddedBy('97')) {//print_r(current_user());
                                    //check the target group of the exhibit
                                    $o+=1;
                                    $exhibits2_id = (string) $exhibits2['id'];
                                    ?>


                                    <?php $target = target(); ?>
                                    <li>
                                        <a target="_blank" href="<?php echo uri('exhibits/show/' . $exhibits2['slug'] . '/to-begin-with'); ?>" class="block"></a>
                                        <?php echo exhibit_picture($exhibits2['id'], '135', 'indexstund'); ?>
                                        <div class="exhibit-data">
                                            <p><?php echo $exhibits2['title']; ?></p>
                                        </div>
                                        <a target="_blank" href="<?php echo uri('exhibits/show/' . $exhibits2['slug'] . '/to-begin-with'); ?>" class="more"><?php echo __('GO NOW!'); ?></a>
                                    </li>




                                    <?php
                                }//if user of mnhm
                            }//if NHMC

                            if ($_GET['nhm'] == 'JME') { //if JME
                                //print_r($exhibits2); break;
                                if ($exhibits2->wasAddedBy('72')) {//print_r(current_user());
                                    //check the target group of the exhibit
                                    $o+=1;
                                    $exhibits2_id = (string) $exhibits2['id'];
                                    ?>


                                    <?php $target = target(); ?>
                                    <li>
                                        <a target="_blank" href="<?php echo uri('exhibits/show/' . $exhibits2['slug'] . '/to-begin-with'); ?>" class="block"></a>
                                        <?php echo exhibit_picture($exhibits2['id'], '135', 'indexstund'); ?>
                                        <div class="exhibit-data">
                                            <p><?php echo $exhibits2['title']; ?></p>
                                        </div>
                                        <a target="_blank" href="<?php echo uri('exhibits/show/' . $exhibits2['slug'] . '/to-begin-with'); ?>" class="more"><?php echo __('GO NOW!'); ?></a>
                                    </li>




                                    <?php
                                }//if user of JME
                            }//if JME

                            if ($_GET['nhm'] == 'AC') { //if AC
                                //print_r($exhibits2); break;
                                if ($exhibits2->wasAddedBy('73')) {//print_r(current_user());
                                    //check the target group of the exhibit
                                    $o+=1;
                                    $exhibits2_id = (string) $exhibits2['id'];
                                    ?>


                                    <?php $target = target(); ?>
                                    <li>
                                        <a target="_blank" href="<?php echo uri('exhibits/show/' . $exhibits2['slug'] . '/to-begin-with'); ?>" class="block"></a>
                                        <?php echo exhibit_picture($exhibits2['id'], '135', 'indexstund'); ?>
                                        <div class="exhibit-data">
                                            <p><?php echo $exhibits2['title']; ?></p>
                                        </div>
                                        <a target="_blank" href="<?php echo uri('exhibits/show/' . $exhibits2['slug'] . '/to-begin-with'); ?>" class="more"><?php echo __('GO NOW!'); ?></a>
                                    </li>




                                    <?php
                                }//if user of AC
                            }//if AC

                            if ($_GET['nhm'] == 'HNHM') { //if HNHM
                                //print_r($exhibits2); break;
                                if ($exhibits2->wasAddedBy('100') or $exhibits2->wasAddedBy('101') or $exhibits2->wasAddedBy('104') or $exhibits2->wasAddedBy('134')) {//print_r(current_user());
                                    //check the target group of the exhibit
                                    $o+=1;
                                    $exhibits2_id = (string) $exhibits2['id'];
                                    ?>


                                    <?php $target = target(); ?>
                                    <li>
                                        <a target="_blank" href="<?php echo uri('exhibits/show/' . $exhibits2['slug'] . '/to-begin-with'); ?>" class="block"></a>
                                        <?php echo exhibit_picture($exhibits2['id'], '135', 'indexstund'); ?>
                                        <div class="exhibit-data">
                                            <p><?php echo $exhibits2['title']; ?></p>
                                        </div>
                                        <a target="_blank" href="<?php echo uri('exhibits/show/' . $exhibits2['slug'] . '/to-begin-with'); ?>" class="more"><?php echo __('GO NOW!'); ?></a>
                                    </li>




                                    <?php
                                }//if user of HNHM
                            }//if HNHM
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>
            <!--<div id='page_navigation2' class='page_navigation' ></div>	 -->	
            <?php
        }//if target
        else {

            $o+=1;
            $exhibits2_id = (string) $exhibits2['id'];
            ?>

            <?php $target = target(); ?>
            
            <div id="exhibtpagination" style="clear:both; padding-bottom:10px;"><?php echo pagination_links(); ?></div>
            <div id="exhibits" style="width:100%;">	
                <?php $exhibitCount = 0; ?>
                <ul class="digital_exhibits">
                <?php while ($paths = loop_records('exhibits', $menuexhibits_paging, 'set_current_exhibit')): ?>
                    <li>
                <a target="_blank" href="<?php echo uri('exhibits/show/' . $paths['slug'] . '/to-begin-with'); ?>" class="block"></a>
                <?php echo exhibit_picture($paths['id'], '135', 'indexstund'); ?>
                <div class="exhibit-data">
                    <p><?php echo $paths['title']; ?></p>
                </div>
                <a target="_blank" href="<?php echo uri('exhibits/show/' . $paths['slug'] . '/to-begin-with'); ?>" class="more"><?php echo __('GO NOW!'); ?></a>
            </li>
                <?php endwhile; ?>
                </ul>
            </div>
            <div style="clear:both; padding-top:10px;" id="exhibtpagination"><?php echo pagination_links(); ?></div>




            <?php
        }//else target
        ?>




    </div>


</div><!-- end div.column #column-c -->

<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->
<?php foot(); ?>
