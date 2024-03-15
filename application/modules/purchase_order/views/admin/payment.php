<div class="col-md-8">
                <div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2>Make Payment for an Orders</h2> 
            <div class="right">                            
                       
             <?php echo anchor( 'admin/purchase_order/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> New Order ', 'class="btn btn-primary"');?>
			    <?php echo anchor( 'admin/purchase_order/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
				<?php echo anchor( 'admin/purchase_order/voided' , '<i class="glyphicon glyphicon-list">
                </i> Voided Purchase Orders', 'class="btn btn-warning"');?>
                     </div>    					
                </div>
				 <div class="block-fluid">
<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	 <div class="col-md-2" for='pay_date'>Payment Date </div>
	 <div class="col-md-3">
	  <div id="datetimepicker1" class="input-group date form_datetime">
	<input id='pay_date' type='text' name='pay_date' maxlength='' class='form-control datepicker' value="<?php echo set_value('pay_date', (isset($result->pay_date)) ? $result->pay_date : ''); ?>"  />
	<span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>
 	
</div>
 	<?php echo form_error('pay_date'); ?>

</div>
</div>

<div class='form-group' style="border:none !important">
	 <div class="col-md-2" for='amount'>Amount  </div><div class="col-md-4">
		
	<?php echo form_input('amount' ,(isset($result->amount)) ? $result->amount : ''    , 'id="amount_"  class="amount"' );?>
	<?php echo form_error('amount'); ?>
</div>
</div>

<div class='form-group'>
	 <div class="col-md-2" for='pay_type'>Payment type <span class='required'>*</span></div>
	<div class="col-md-4">
    <?php 
	$pays=array(
	'M-Pesa'=>'M-Pesa',
	'Cash'=>'Cash',
	'Cheque'=>'Cheque'
	);
	echo form_dropdown('pay_type',$pays,  (isset($result->pay_type)) ? $result->pay_type : ''     ,   ' class="select" data-placeholder="Select  Options..." ');
                            ?>		
 	<?php echo form_error('pay_type'); ?>
</div>
</div>
		
<div class='form-group'><label class="control-label"></div><div class="col-md-10">
   <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/purchase_order','Cancel','class="btn btn-default"');?>

</div></div>	
</div>

<?php echo form_close(); ?>
</div>
<div class="col-md-4">
<div class="widget">
                    <div class="head dark">
                        <div class="icon"><i class="icos-equalizer"></i></div>
                        <h2>Purchase Order Details</h2>
                    </div>                  
                    <div class="block-fluid">
                            <dl class="dl-horizontal red">
                                <dt>Order Date</dt>
                                    <dd><?php echo date('d/m/Y',$p->purchase_date);?></dd>
                                <dt>Due Date</dt>
                                    <dd><?php echo date('d/m/Y',$p->due_date);?></dd>
                                   
                                <dt>Supplier</dt>
                                    <dd><?php echo $address_book[$p->supplier];?></dd>
                                <dt>Amount Due</dt>
                                    <dd style="color:red; text-decoration:underline;">
									 <?php
                            $vat = $tax->amount;
                            if ($p->vat == 1)
                            {
                                $t = ($p->total * $vat) / 100; //echo $vat;
								 echo ' '.number_format($t + $p->total, 2);
                            }
                            else{ echo ' '.number_format($p->total, 2);}
							
                            ?></dd>
							<?php
							if($p->balance>0):
                            ?>
							  <dt>Balance Due</dt>
                                    <dd>  <?php echo number_format($p->balance,2);?></dd>
							<?php endif;?>
                            </dl>                            
                        </div>
                </div>
 
                        </div>
