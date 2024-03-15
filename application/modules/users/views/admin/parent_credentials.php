<div class="col-md-9">
<div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>Send Credentials </h2> 
         				
    </div>

    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>

            <div class='form-group'>
            <div class="col-md-3" for='student'>Select Student</div>
            <div class="col-md-9">
               <select name="students[]" multiple id="langOpt" class="fsel">
                   <?php
                        $data = $this->ion_auth->students_full_details();
                        foreach ($data as $key => $value):
                                ?>
                                <option value="<?php echo $key; ?>"><?php echo $value ?></option>
                        <?php endforeach; ?>
               </select>
            </div>
        </div>

        <button class="btn btn-success" onClick="return confirm('<?php echo 'Are you sure you want send login credentials to selected Parents/Guardians via SMS?';?>')" type="submit">Send</button>
        <?php echo form_close()?>
    </div>

</div>

 

<script type="text/javascript">
      $(function ()
    {
            $(".fsel").select2({'placeholder': 'Please Select', 'width': '70%'});
             // $('select[multiple]').multiselect();
        });
</script>