<?php
$class = get_class($record);
if(Inflector::titleize($class)=='Exhibit'){
 $boxname='Delete Pathway';  
 $pageTitle = __($boxname);
}elseif(Inflector::titleize($class)=='Item'){
   $boxname='Delete Resource'; 
   $pageTitle = __($boxname);
}else{
   $boxname=Inflector::titleize($class); 
   $pageTitle = __('Delete %s', __($boxname));
}


if (!$isPartial):
head(array('title' => $pageTitle));
?>
<h1><?php echo $pageTitle; ?></h1>
<div id="primary">   
<?php endif; ?>
<div title="<?php echo $pageTitle; ?>">
<h2><?php echo __('Are you sure?'); ?></h2>
<?php echo nls2p(html_escape(__($confirmMessage))); ?>
<?php echo $form; ?>
</div>
<?php if (!$isPartial): ?>
</div>
<?php foot(); ?>
<?php endif; ?>