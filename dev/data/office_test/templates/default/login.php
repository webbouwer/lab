<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Wordpress login Oddsized Office</title>
<link href="<?php echo $admin->getThemeFolder(); ?>style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div align="center">
	<h1>The Office</h1>
	<form name="loginform" id="loginform" action="https://oddsized.com/net/login/" method="post">
	<p>
		<label for="user_login">Username<br>
		<input type="text" name="log" id="user_login" class="input" value="" size="20"></label>
	</p>
	<p>
		<label for="user_pass">Password<br>
		<input type="password" name="pwd" id="user_pass" class="input" value="" size="20"></label>
	</p>
		<p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever"> Remember Me</label></p>
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="Log In">
		<input type="hidden" name="redirect_to" value="https://oddsized.com/office">
		<input type="hidden" name="testcookie" value="1">
	</p>
	</form>
</div>
</body>
</html>