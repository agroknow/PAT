<?php if ($exhibitSection->Pages): ?>
    <?php foreach ($exhibitSection->Pages as $key => $exhibitPage): ?>
        <li id="page_<?php echo html_escape($exhibitPage->id); ?>" class="exhibit-page-item">
            <div class="page-info">
                <span class="left">
                    <span class="handle"><img src="<?php echo html_escape(img('silk-icons/page_go.png')); ?>" alt="Move" /></span>
                    <span class="input">
                        <?php
                        if (isset($fromExhibitPage)):
                            $exhibitSectionId = $exhibitSection->id;
                            $exhibitPageId = $exhibitPage->id;
                        //echo text(array('name'=>"Pages[$exhibitSectionId][$exhibitPageId][order]",'size'=>2, 'id' => 'page-' . $exhibitPage->id . '-order'), $exhibitPage->order); 
                        else:
                        //  echo text(array('name'=>"Pages[$key][order]",'size'=>2,'id' => 'page-' . $exhibitPage->id . '-order'), $exhibitPage->order); 
                        endif;
                        ?></span>
                    <?php $pagetitle_custom = html_escape($exhibitPage->title); ?>

                    <?php
                    $custominfo=0;
                    $helpdiv='';
                    if ($pagetitle_custom == 'Guidance for preparation') {
                       $custominfo=1; 
                       $helpdiv='Info about any necessary arrangements needed by the interested teacher before launching the activities described and/or proposed in the following sections.';
                    }
                    if ($pagetitle_custom == 'Connection with curriculum') {
                       $custominfo=1; 
                       $helpdiv='Give the relevant education curriculum which inform in a direct way about the prerequisite knowledge of the students to participate in the educational pathway.';
                    }
                    if ($pagetitle_custom == 'Provoke curiosity') {
                       $custominfo=1; 
                       $helpdiv="Describe the means and material that would be used inside the classroom for attracting the student's attention.";
                    }
                    if ($pagetitle_custom == 'Define questions from current knowledge') {
                       $custominfo=1; 
                       $helpdiv='Format questions that will be presented to the students for further enhancement of their engagement in thinking about the target subject matter based on their existing knowledge.';
                    }
                    if ($pagetitle_custom == 'Propose preliminary explanations or hypotheses') {
                       $custominfo=1; 
                       $helpdiv='Describe the way that students can be encouraged to propose possible explanations to the questions emerged from the previous activity.';
                    }
                    if ($pagetitle_custom == 'Plan and conduct simple investigation') {
                       $custominfo=1; 
                       $helpdiv='Describe the means and material that will be used for facilitating the students to focus on evidence as a source of answers to scientific questions.';
                    }
                    if ($pagetitle_custom == 'Gather evidence from observation') {
                       $custominfo=1; 
                       $helpdiv='Locate the appropriate resource and/or the actual exhibit. Give details about the way that students will gather evidence according to the questions posed in the previous stages.';
                    }
                    if ($pagetitle_custom == 'Explanation based on evidence') {
                       $custominfo=1; 
                       $helpdiv='Explain the phases of the educational programme.';
                    }
                    if ($pagetitle_custom == 'Consider other explanations') {
                       $custominfo=1; 
                       $helpdiv='Explain how the students groups will evaluate their own explanations.';
                    }
                    if ($pagetitle_custom == 'Communicate explanation') {
                       $custominfo=1; 
                       $helpdiv='Details on how to produce a report with the findings of students, presenting and justifying its proposed explanations to other groups, and to the teacher.';
                    }
                    if ($pagetitle_custom == 'Follow-up activities and materials') {
                       $custominfo=1; 
                       $helpdiv='Describe the context of the follow-up activities and materials';
                    }
                    if ($pagetitle_custom == 'Sustainable contact') {
                       $custominfo=1; 
                       $helpdiv='Give the contact info of the persons and the organization that are related with this pathway.';
                    }
                    if ($pagetitle_custom == 'Introduction') {
                       $custominfo=1; 
                       $helpdiv='Give a basic description about the educational pathway. The means that will be used, the age range etc.';
                    }
                    if ($pagetitle_custom == 'Curiosity Provocation') {
                       $custominfo=1; 
                       $helpdiv='Set the activity context in a appropriate way in order to attract the attention of participants.';
                    }
                    if ($pagetitle_custom == 'Abstract Conceptulization') {
                       $custominfo=1; 
                       $helpdiv='Give guidelines on how the participants will fill in for example the questionnaires.';
                    }
                    if ($pagetitle_custom == 'Reflection-COMMUNICATE EXPLANATION') {
                       $custominfo=1; 
                       $helpdiv='Evaluate the results of the games, congratulate the winner and explain to him what his present is and how he can receive it.';
                    }
                    if ($exhibitSection->title == 'Game') {
                       $custominfo=1; 
                       $helpdiv='Give the differ kinds of games like crosswords, multiple choice questions etc. Explain how to play with them, in groups or individually.';
                    }
                    ?>







                    <?php if ($custominfo == 1) { ?>
                        <span class="page-title"><?php echo __($pagetitle_custom); ?><?php echo ' <img id="' . $exhibitPage->id . 'Text" src="' . uri("themes/default/items/images/information.png") . '">'; ?></span>
                    </span>
                    <div id="<?php echo $exhibitPage->id . 'Text'; ?>_help" style="display:none; position:absolute;top:-100px; border:1px solid #333;background:#f7f5d1;padding:2px 5px; color:#333;z-index:100;">
                        <?php
                        echo __($helpdiv); ?>
                        </div>
                                    <script type="text/javascript">
                        var my_tooltip = new Tooltip_sec('<?php echo $exhibitPage->id . 'Text'; ?>', '<?php echo $exhibitPage->id . 'Text'; ?>_help');
                    </script>
                <?php
                    } else {
                        ?>
                        <span class="page-title"><?php echo __($pagetitle_custom); ?></span>
                        </span>
                            <?php
                        }
                        ?>
                    <span class="right">
                        <span class="page-edit"><a href="<?php echo html_escape(uri('exhibits/edit-page-content/' . $exhibitPage->id)); ?>" class="edit"><?php echo __('Edit'); ?></a></span>
                        <?php /* <span class="page-delete"><a href="<?php echo html_escape(uri('exhibits/delete-page/'.$exhibitPage->id)); ?>" class="delete-page"><?php echo __('Delete'); ?></a></span> */ ?>
                    </span>
                </div>
        </li>
    <?php endforeach; ?>    
<?php endif; ?>
