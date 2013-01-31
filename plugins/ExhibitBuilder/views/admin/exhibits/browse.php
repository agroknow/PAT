<?php
$title = __('Browse Pathways');
head(array('title'=>$title, 'bodyclass'=>'exhibits'));
?>
<h1><?php echo $title; ?> <?php echo __('(%s total)', $total_records); ?></h1>
<?php if (has_permission('ExhibitBuilder_Exhibits','add')): ?>
    <p id="add-exhibit" class="add-button"><a class="add" href="<?php echo html_escape(uri('exhibits/add')); ?>"><?php echo __('Add Pathway'); ?></a></p>
<?php endif; ?>
<div id="primary">
    
<?php if (!count($exhibits)): ?> 
    <div id="no-exhibits">
    <p><?php echo __('There are no pathways yet.'); ?>
    
    <?php if (has_permission('ExhibitBuilder_Exhibits','add')): ?>
        <a href="<?php echo html_escape( uri('exhibits/add')); ?>"><?php echo __('Add a Pathway'); ?></a></p>
    <?php endif; ?>
    </div>
    
<?php else: //Show the exhibits in a table?>
<?php $user = current_user();
if($user['id']==1 or $user['role']=='super'){ ?>
<div class="pagination"><?php echo pagination_links(); ?></div>
<?php } ?>

<table id="exhibits">
    <col id="col-id" />
    <col id="col-title" />
    <col id="col-tags" />
    <col id="col-preview">
    <col id="col-edit" />
    <col id="col-delete" />
    <thead>
    <tr>
        <?php /*<th><?php echo __('Title'); ?></th>
        <th><?php echo __('Tags'); ?></th>
        <th><?php echo __('Theme'); ?></th>
        <th><?php echo __('Public'); ?></th>
        <th><?php echo __('Featured'); ?></th>
        <th><?php echo __('Edit?'); ?></th>
        <th><?php echo __('Delete?'); ?></th> */?>
        
        <th><?php echo __('Title'); ?></th>

        <th><?php echo __('Public'); ?></th>

        <th><?php echo __('Edit?'); ?></th>
        <th><?php echo __('Delete?'); ?></th>
    </tr>
    </thead>
    <tbody>
        
<?php if($user['id']!=1 and $user['role']!='super'){  $exhibits = exhibit_builder_get_exhibits(array('sort'=>'alpha')); } ?>       
<?php foreach($exhibits as $key=>$exhibit): ?>
        
 <?php if($user['id']==1 or $user['role']=='super' or $exhibit->wasAddedBy(current_user()) or sameinstitutionexhibit($exhibit,$user)){  //if he has add the exhibit ?>       
    <tr class="exhibit <?php if($key%2==1) echo ' even'; else echo ' odd'; ?>">
        <td><a href="<?php echo html_escape(exhibit_builder_exhibit_uri($exhibit)); ?>/to-begin-with"><?php echo html_escape($exhibit->title); ?></a></td>
        <?php /*<td><?php echo tag_string($exhibit, uri('exhibits/browse/tag/')); ?></td> */?>
        <?php /*
        if ($exhibit->theme==null) {
            $themeName = 'Current Public Theme';
        } else {
            $theme = Theme::getAvailable($exhibit->theme);
            $themeName = !empty($theme->title) ? $theme->title : $exhibit->theme;
        }
        ?>
        <td><?php echo html_escape($themeName);?></td> <?php */ ?>
        <td>
        <?php if($exhibit->public): ?>
            <img src="<?php echo img('silk-icons/tick.png'); ?>" alt="<?php echo __('Public'); ?>"/>
        <?php endif; ?>
        </td>
        <?php /*
        <td>
        <?php if($exhibit->featured): ?>
            <img src="<?php echo img('silk-icons/star.png'); ?>" alt="<?php echo __('Featured'); ?>"/>
        <?php endif; ?>
        </td> */?>
        <td>
        <?php if (exhibit_builder_user_can_edit($exhibit)): ?>
        <?php echo link_to($exhibit, 'edit', __('Edit'), array('class'=>'edit')); ?>
        <?php endif; ?>
        </td>
        <td>
        <?php if (exhibit_builder_user_can_delete($exhibit)): ?>
        <?php echo delete_button($exhibit, "delete-exhibit-{$exhibit->id}") ?>
        <?php endif; ?>
        </td>
    </tr>
    <?php } //natural europe if ceate pathway?>
<?php endforeach; ?>
</tbody>
</table>
<?php if($user['id']==1 or $user['role']=='super'){ ?>
<div class="pagination"><?php echo pagination_links(); ?></div>
<?php } ?>
<?php endif; ?>

</div>
<?php foot(); ?>
