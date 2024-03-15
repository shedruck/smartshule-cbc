<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo form_open('contact', $attributes);
?>

<h1><?php echo lang('web_contact')?></h1>

<p>
	<label class='labelform' for="name"><?php echo lang('web_name')?> <span class="required">*</span></label>
	<input id="name" type="text" name="name" maxlength="256" value="<?php echo set_value('name'); ?>"  />
	<?php echo form_error('name'); ?>
</p>

<p>
	<label class='labelform' for="lastname"><?php echo lang('web_lastname')?> <span class="required">*</span></label>
	<input id="lastname" type="text" name="lastname" maxlength="256" value="<?php echo set_value('lastname'); ?>"  />
	<?php echo form_error('lastname'); ?>
</p>

<p>
    <label class='labelform' for="email"><?php echo lang('web_email')?> <span class="required">*</span></label>
    <input id="email" type="text" name="email" maxlength="256" value="<?php echo set_value('email'); ?>"  />
    <?php echo form_error('email'); ?>
</p>

<p>
    <label class='labelform' for="phone"><?php echo lang('web_phone')?> <span class="required">*</span></label>
    <input id="phone" type="text" name="phone" maxlength="256" value="<?php echo set_value('phone'); ?>"  />
    <?php echo form_error('phone'); ?>
</p>

<p>
    <label class='labelform' for="comments"><?php echo lang('web_comments')?> <span class="required">*</span></label>
    <textarea name='comments' id='comments' cols='10' rows='6'><?php echo set_value('comments'); ?></textarea>
    <?php echo form_error('comments'); ?>
</p>

<p>
    <?php echo form_submit( 'submit', 'Send  Message'); ?>
</p>
	

<?php echo form_close(); ?>

