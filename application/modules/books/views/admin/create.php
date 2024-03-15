<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Books  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/books/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Books')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/books' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Books')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-2" for='title'>Title <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('title' ,$result->title , 'id="title_"  class="form-control" ' );?>
 	<?php echo form_error('title'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='author'>Author <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('author' ,$result->author , 'id="author_"  class="form-control" ' );?>
 	<?php echo form_error('author'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='publisher'>Publisher <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('publisher' ,$result->publisher , 'id="publisher_"  class="form-control" ' );?>
 	<?php echo form_error('publisher'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='year_published'>Year Published </div><div class="col-md-6">
	<?php echo form_input('year_published' ,$result->year_published , 'id="year_published_"  placeholder=" E.g 2010" class="form-control" ' );?>
 	<?php echo form_error('year_published'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='isbn_number'>ISBN Number </div><div class="col-md-6">
	<?php echo form_input('isbn_number' ,$result->isbn_number , 'id="isbn_number_"  class="form-control" ' );?>
 	<?php echo form_error('isbn_number'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='category'>Category <span class='required'>*</span></div><div class="col-md-6">
	  <?php 		
     echo form_dropdown('category',$category,  (isset($result->category)) ? $result->category : ''     ,   ' class="select" data-placeholder="Select Options..." ');
     echo form_error('category'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='edition'>Edition </div><div class="col-md-6">
	<?php echo form_input('edition' ,$result->edition , 'id="edition_"  class="form-control" ' );?>
 	<?php echo form_error('edition'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='pages'>Pages </div><div class="col-md-6">
	<?php echo form_input('pages' ,$result->pages , 'id="pages_"  class="form-control" ' );?>
 	<?php echo form_error('pages'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='copyright'>Copyright </div><div class="col-md-6">
	<?php echo form_input('copyright' ,$result->copyright , 'id="copyright_"  class="form-control" ' );?>
 	<?php echo form_error('copyright'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='shelf'>Shelf </div><div class="col-md-6">
	<?php echo form_input('shelf' ,$result->shelf , 'id="shelf_"  class="form-control" ' );?>
 	<?php echo form_error('shelf'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Memo </h2></div>
	 <div class="block-fluid editor">
	<textarea id="memo"   style="height: 300px;" class=" wysiwyg "  name="memo"  /><?php echo set_value('memo', (isset($result->memo)) ? htmlspecialchars_decode($result->memo) : ''); ?></textarea>
	<?php echo form_error('memo'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-2"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save and Exit', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo form_submit( 'submit', 'Save and Add Stock',(($add == 'add_stock') ?  "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/books','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
			
			
 <div class="col-md-4">
	  
	       <div class="widget">
                    <div class="head dark">
                        <div class="icon"></div>
                        <h2>Add Book Category</h2>
                    </div>
					
                    <div class="block-fluid">
                         <?php echo form_open('admin/books_category/quick_add','class=""'); ?>
                        <div class="form-group">
                            <div class="col-md-3">Name:</div>
                            <div class="col-md-9">                                      
                                 <?php echo form_input('name','', 'id="title_1"  placeholder=" e.g Social Studies"' );?>
 	                           <?php echo form_error('title'); ?>
                            </div>
                        </div>
                                                    
                        <div class="form-group">
						 <div class="col-md-3">Description:</div>
                            <div class="col-md-9">
                                <textarea name="description"></textarea> 
                            </div>
                        </div>                        
                   
                    <div class="toolbar TAR">
                        <button class="btn btn-primary">Add</button>
                    </div>
					   <?php echo form_close(); ?> 
					   </div>
                </div>
	
  
	</div>