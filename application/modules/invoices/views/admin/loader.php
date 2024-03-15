<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2 class=""> <?php echo $res?>  invoice generated </h2>
    <div class="right">  
         <?php echo anchor('admin/invoices/create', '<i class="glyphicon glyphicon-list">
                </i> Do Invoice' , 'class="btn btn-primary"'); ?> 


		<?php echo anchor('admin/fee_payment', '<i class="glyphicon glyphicon-list">
                </i> View Statements ' , 'class="btn btn-success"'); ?> 
    </div>
</div>

 <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">  <i class="glyphicon glyphicon-remove"></i>  </button>
                              <?php echo $res?>  invoice generated 
                            </div>

