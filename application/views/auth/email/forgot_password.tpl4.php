<html>
<body>
	<h1>Reset Password for <?php echo $identity;?></h1>
	<p>Please click this link to <?php echo anchor('reset_password/'. $forgotten_password_code, 'Reset Your Password');?>.</p>
</body>
</html>