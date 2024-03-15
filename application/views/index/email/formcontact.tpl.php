<html>
<body>
	<h1 style='font-family: lucida grande,tahoma,verdana,arial,sans-serif;font-size:16px;'>
		Formulario de contacto
	</h1>

	<p style='font-family: lucida grande,tahoma,verdana,arial,sans-serif;font-size:13px;'>
		Has recibido un nuevo email de contacto desde la página web
	</p>

	<p style='font-family: lucida grande,tahoma,verdana,arial,sans-serif;font-size:13px;'>
		<b>Nombre:</b><br/>			<?php echo $name?> <br/><br/>
		<b>Apellidos:</b><br/>		<?php echo $lastname?> <br/><br/>
		<b>Email:</b><br/>			<?php echo $email?> <br/><br/>
		<b>Teléfono:</b><br/>		<?php echo $phone?> <br/><br/>
		<b>Comentarios:</b><br/>	<?php echo $comments?> <br/><br/>
	</p>

	<p style='font-family: lucida grande,tahoma,verdana,arial,sans-serif;font-size:13px;'>
		No olvide ponerse en contacto lo antes posible con este contacto.
	</p>

	<br>

	<p style='font-family: lucida grande,tahoma,verdana,arial,sans-serif;font-size:13px;'>
		<?php echo lang('confirm_email_thanks')?><br>
		<?php echo lang('confirm_email_team')?> <?php echo $this->config->item('site_title', 'ion_auth')?>
	</p>

</body>
</html>