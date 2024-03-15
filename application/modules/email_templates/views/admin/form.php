<div class="head">                    <div class="icon"><span class="icosg-target1"></span></div>                    <h2>  Email Templates </h2>                      <div class="right">                                                                <?php echo anchor( 'admin/email_templates/create/', '<i class="glyphicon glyphicon-plus">                </i>'.lang('web_add_t', array(':name' => ' New Template')), 'class="btn btn-primary"');?>                <?php echo anchor( 'admin/email_templates/' , '<i class="glyphicon glyphicon-list">                </i> List All Templates', 'class="btn btn-primary"');?>			                     </div>    					                </div>         	                                 <div class="block-fluid">
<?php $post = (object) $post; ?>	

        <!-- tabular listing -->
        <?php echo form_open_multipart($this->uri->uri_string(), ' id="form"  class="form-horizontal"'); ?>
  
            <div class="form-group">
                <label class="col-md-2" for="title">Title</label>
                <div class="col-md-4">
                    <?php echo form_input('title', $post->title, ' class="input-xlarge focused"'); ?>
                </div>
            </div>											
            <div class="form-group">
                <label class="col-md-2" for="slug">Slug</label>
                <div class="col-md-4">
                    <?php echo form_input('slug', $post->slug, ' class="input-xlarge focused"'); ?>
                </div>
            </div>	<div class="widget">                    <div class="head dark">                        <div class="icon"><i class="icos-pencil"></i></div>                        <h2>Description</h2>                    </div>                    <div class="block-fluid editor">                                                <textarea class="wysiwyg"  name="description" style="height: 300px;">                          <?php echo set_value('description', (isset($post->description)) ? htmlspecialchars_decode($post->description) : ''); ?></textarea>	<?php echo form_error('description'); ?>                                            </div>                                   </div> 			
            <div class="widget">                    <div class="head dark">                        <div class="icon"><i class="icos-pencil"></i></div>                        <h2>Email Body</h2>                    </div>                    <div class="block-fluid editor">                                                <textarea class="wysiwyg"  name="content" style="height: 300px;">                          <?php echo set_value('content', (isset($post->content)) ? htmlspecialchars_decode($post->content) : ''); ?></textarea>	<?php echo form_error('content'); ?>                                            </div>                                   </div> 											
         

            <div class="form-group">
                <label class="col-md-2" for="status">Status</label>
                <div class="col-md-10">
<?php echo form_dropdown('status', array('draft' => 'Draft', 'live' => 'Live'), $post->status); ?>
                    <span class="help-inline">Whether to publish or not</span>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" name="" class="btn btn-primary blue">Save changes</button>
                <button class="btn">Cancel</button>
            </div>
<?php echo form_close(); ?>
    </div><!--/span-->

