<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Issue Discount </h2>
             <div class="right"> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
 


<div class='form-group'>
    <div class="col-md-3" for='name'>Select Group </div><div class="col-md-6">
   <?php echo form_dropdown('group', array('' => '') + $list, $this->input->post('group'), 'class ="select select-2" '); ?>
</div>
</div>

<div class='form-group'>
    <div class="col-md-3" for='name'>Term </div><div class="col-md-6">
   <?php 
    $terms = [1 => 'Term 1', 2 => 'Term 2', 3 => 'Term 3'];
    echo form_dropdown('term', array('' => '') + $terms, $this->input->post('term'), 'class ="select select-2" '); ?>
</div>
</div>

<div class='form-group'>
    <div class="col-md-3" for='name'>Year </div><div class="col-md-6">
   <?php 
    
    echo form_dropdown('year', array('' => '') + $yrs, $this->input->post('year'), 'class ="select select-2" '); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    <button class="btn btn-primary" onClick="return confirm('<?php echo 'Are you sure ?';?>')" type="submit">Submit</button>
	<?php echo anchor('admin/discounts','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>


<script>
        $(document).ready(
                function ()
                {
                    $(".tsel").select2({'placeholder': 'Please Select', 'width': '140px'});
                    $(".tsel").on("change", function (e) {

                        notify('Select', 'Value changed: ' + e.added.text);
                    });

                    $(".fsel").select2({'placeholder': 'Please Select', 'width': '100px'});
                    $(".fsel").on("change", function (e) {

                        notify('Select', 'Value changed: ' + e.added.text);
                    });
                });
</script>