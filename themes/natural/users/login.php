<?php head(array(), 'login'); ?>

<h1>Login</h1>
	<?php
	session_start();
	if (isset($errorMessage)) {
		?><div class="error">Error: <span>
			
		<?php 
			foreach ($errorMessage as $msg): ?>
			<?php echo $msg; ?>
		<?php endforeach; ?>
		</span></div>
	<?php
	}
	
	$_SESSION["admin_logged"]=false;
	
	?>
	
<form id="login-form" action="" method="post" accept-charset="utf-8">
	<fieldset>
		<div class="field">
	<label for="username">Username</label> 
	<input type="text" name="username" class="textinput" id="username" />
	</div>
	<div class="field">
	<label for="password">Password</label> 
	<input type="password" name="password" class="textinput" id="password" />
	</div>
	</fieldset>
	<input type="submit" name="loginButt" class="login" value="Login" />
	
</form>

<ul>
<li id="backtosite"><?php echo link_to_home_page('View Public Site', array('id'=>'public-link')); ?></li>
<li id="forgotpassword"><a href="<?php echo uri('users/forgotPassword'); ?>">Lost your password?</a></li>
</ul>

<?php foot();
?>