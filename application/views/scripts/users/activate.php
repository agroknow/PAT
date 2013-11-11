<?php
$pageTitle = __('User Activation');
head(array('title' => $pageTitle), $header);
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
<h1><?php echo $pageTitle; ?></h1>

<?php echo flash(); ?>
<h2>Hello, <?php echo html_escape($user->first_name . ' ' . $user->last_name); ?>. Your username is: <?php echo html_escape($user->username); ?></h2>

<form method="post">
    <fieldset>
    <div class="field">
    <?php echo label('new_password1', __('Create a Password')); ?>
        <div class="inputs">
            <input type="password" name="new_password1" id="new_password1" class="textinput" />
        </div>
    </div>
    <div class="field">
        <?php echo label('new_password2', __('Re-type the Password')); ?>        
        <div class="inputs">
            <input type="password" name="new_password2" id="new_password2" class="textinput" />
        </div>
    </div>
    </fieldset>
    <div>
    <input type="submit" class="submit" name="submit" value="<?php echo __('Activate'); ?>"/>
    </div>
</form>
</div>
<?php foot(array(), $footer); ?>
