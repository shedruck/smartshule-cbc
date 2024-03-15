<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Give out  Book Fund  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/borrow_book_fund/create' , '<i class="glyphicon glyphicon-plus">
                </i> Give out  Book Fund', 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/borrow_book_fund' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Borrowed Books')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-2" for='borrow_date'>Borrow Date <span class='required'>*</span></div><div class="col-md-10">
	<div id="datetimepicker1" class="input-group date form_datetime">
	 <?php echo form_input('borrow_date', $result->borrow_date > 0 ? date('d M Y', $result->borrow_date) : $result->borrow_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
	<span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
	</div>
 	<?php echo form_error('borrow_date'); ?>
</div>
</div>
<div class='form-group'>
	<div class="col-md-2" for='student'>Student </div><div class="col-md-10">
	   <?php
                $data = $this->ion_auth->students_full_details();
                echo form_dropdown('student', array('' => 'Select Student') + $data, (isset($result->student)) ? $result->student : '', ' class="select" data-placeholder="Select Options..." ');
                ?>
	
 	<?php echo form_error('student'); ?>
</div>
</div>


  <!-- BEGIN TABLE DATA -->
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <table cellpadding="0" cellspacing="0" width="100%">
                <!-- BEGIN -->
                <thead>
                    <tr role="row">
                        <th width="3%">#</th>
                        <th width="30%">Book</th>
                        <th width="67%">Remarks</th>
                    </tr>
                </thead>
            </table>

            <div id="entry1" class="clonedInput">

                <table cellpadding="0" cellspacing="0" width="100%">  
                    <tbody>

                        <tr >

                            <td width="3%">
                                <span id="reference" name="reference" class="heading-reference">1</span>
                            </td>

                            <td width="30%">

                               <?php
                               echo form_dropdown('book', $books, (isset($result->book)) ? $result->book : '', ' class="book" id="book" data-placeholder="Select Options..." ');
                                ?>
                                       <?php echo form_error('book'); ?>
                            </td>
                       
                            <td width="67%">
                                <textarea name="remarks" cols="25" rows="1" class="col-md-12 remarks  validate[required]" style="resize:vertical;" id="remarks"><?php echo set_value('remarks', (isset($result->remarks)) ? htmlspecialchars_decode($result->remarks) : ''); ?></textarea>
                            </td>


                        </tr>

                    </tbody>
                </table>
            </div>


        </div>


<div class='form-group'><div class="col-md-2"></div><div class="col-md-10">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/borrow_book_fund','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
	