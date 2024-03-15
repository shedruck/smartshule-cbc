<div class="row">
    <?php echo form_open()?>

        <?php echo form_dropdown('student',['' => ''] + $students,$this->input->post('student'),'class="select select2"')?>
    <?php echo form_close()?>
</div>