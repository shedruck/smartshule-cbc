<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2> New E-videos  </h2>
             <div class="right"> 
            
              <?php echo anchor( 'admin/evideos' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'E-videos')), 'class="btn btn-info"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='title'>Title <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('title' ,$result->title , 'id="title_"  class="form-control" ' );?>
 	<?php echo form_error('title'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='level'>Level <span class='required'>*</span></div><div class="col-md-6">
	<?php 
	    $classes = $this->portal_m->get_class_options();
		echo form_dropdown('level',array(''=>'Select Class')+ $classes + array('999'=>'Any Level'), (isset($result->level)) ? $result->level : '', ' class="select level" id="level" data-placeholder="" ');
		?>
 	<?php echo form_error('level'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='type'>Education System  </div>
<div class="col-md-6">
	<?php $items = array('' =>'Select System', 
			"1"=>"8.4.4 / IGSCE",
			"2"=>"CBC",
			"3"=>"All Systems",
			);		
	 echo form_dropdown('type', $items,  (isset($result->type)) ? $result->type : ''     ,   ' id="type" class="select" data-placeholder="Select Options..." ');
	 echo form_error('type'); ?>
</div></div>


<div class='form-group'>
	<div class="col-md-3" for='subject'>Subject </div><div class="col-md-6">
	
	<?php $items = array('' =>'Select Subject');		
	 echo form_dropdown('subject', $items,  (isset($result->subject)) ? $result->subject : ''     ,   ' id="subject" class="select" data-placeholder="Select Options..." ');
	 echo form_error('subject'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='topic'>Topic </div><div class="col-md-6">
	<?php echo form_input('topic' ,$result->topic , 'id="topic_"  class="form-control" ' );?>
 	<?php echo form_error('topic'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='subtopic'>Subtopic </div><div class="col-md-6">
	<?php echo form_input('subtopic' ,$result->subtopic , 'id="topic_"  class="form-control" ' );?>
 	<?php echo form_error('subtopic'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Preview Link <span class='required'>*</span></h2></div>
	 <div class="block-fluid editor">
	<textarea id="preview_link"   style="height: 100px;" class=" ckeditor "  name="preview_link"  /><?php echo set_value('preview_link', (isset($result->preview_link)) ? htmlspecialchars_decode($result->preview_link) : ''); ?></textarea>
	<?php echo form_error('preview_link'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Video Embed Code <span class='required'>*</span></h2></div>
	 <div class="block-fluid editor">
	<textarea id="video_embed_code"   style="height: 100px;" class=" ckeditor "  name="video_embed_code"  placeholder="E.g OXVIoWz_uNc"/><?php echo set_value('video_embed_code', (isset($result->video_embed_code)) ? htmlspecialchars_decode($result->video_embed_code) : ''); ?></textarea>
	<?php echo form_error('video_embed_code'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Description </h2></div>
	 <div class="block-fluid editor">
	<textarea id="description"   style="height: 100px;" class=" ckeditor "  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/evideos','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
			
		<script>
    jQuery(function () {

        jQuery("#level").change(function () {
            jQuery('#subject').empty();

            var level = jQuery(".level").val();
           
            var options = '';
            jQuery('#subject').children().remove();

            jQuery.getJSON("<?php echo base_url('admin/evideos/list_subjects'); ?>", {id: jQuery(this).val()}, function (data) {


                for (var i = 0; i < data.length; i++) {
					
                    options += '<option value="' + data[i].optionValue + '">' + data[i].optionDisplay + '</option>';
                }

                jQuery('#subject').append(options);

            });

            //alert(options);
        });

        $(".tsel").select2({'placeholder': 'Please Select', 'width': '100%'});
    });

</script>	
			
			
			
			