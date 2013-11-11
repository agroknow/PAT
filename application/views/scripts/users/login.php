<?php
queue_js('login');
$pageTitle = __('Log In');
head(array('bodyclass' => 'login', 'title' => $pageTitle), $header);
?>
<style>
    #loginform .textinput{
        width:100px !important;
    }
    #loginform .inputs{
        width:150px !important;
    }
</style>
<div style=" float: left; width: 340px; margin-left: 20px;" id="loginform">
<h1><?php echo $pageTitle; ?></h1><br>

<p id="login-links">
<span id="backtosite"><?php echo link_to_home_page(__('Go to Home Page')); ?></span>  |  <span id="forgotpassword"><?php echo link_to('users', 'forgot-password', __('Lost your password?')); ?></span>
</p>

<?php echo flash(); ?>
    
<?php echo $this->form->setAction($this->url('users/login')); ?>
</div>
<?php foot(array(), $footer); ?>
