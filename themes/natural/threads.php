<?php 
$user = return_user();
if ($user>0){
include('./custom/threads/threads_exhibit_form.php'); } else{ 
?>You have to <a href="http://education.natural-europe.eu/natural_europe/admin/users/login?redirect_custom=<?php echo curPageURL(); ?>">login</a>

<?php }?>