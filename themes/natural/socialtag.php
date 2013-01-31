<?php 
$user = return_user();
if ($user>0){
include('./custom/exhibits/social_tags.php'); } else{ 
?>You have to <a href="<?php echo uri(''); ?>admin/users/login?redirect_custom=<?php echo curPageURL(); ?>">login</a>

<?php }?>