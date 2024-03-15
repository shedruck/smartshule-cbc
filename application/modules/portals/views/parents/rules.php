


<div class="row " id="x-acts">
				<div class="card shadow-sm ctm-border-radius grow">

				<div class="employee-office-table">
					<div class="table-responsive1">
							<div class="card-header d-flex align-items-center justify-content-between">
							
							  <div class="col-sm-12">
									<h4 class="card-title mb-0 d-inline-block">Rules and Regulations</h4>
									
									 <div class="pull-right">	
									 <a href="" onClick="window.print();return false" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
							       </div>
							  </div>		
							 		
							
						</div>
 <div class="col-sm-12">
		 <?php if ($rules_regulations): ?>
		
		
					<div class="block invoice slip-content">
					  <?php foreach ($rules_regulations as $p ): ?>
						
						<h3 style="text-align:center"> <?php echo $p->title;?></h3>
						<hr>
						  <?php echo $p->content;?>
						  
					  <?php endforeach ?>
					</div>
		
		
		<?php else: ?>
			<p class='text'><?php echo lang('web_no_elements');?></p>
		 <?php endif ?>
</div>

		</div>
    <p>&nbsp;</p>

</div>
</div>
</div>








<style>
    table.calendar{ border-left:1px solid #999;     width: 100%;}
    table.calendar   td.calendar-day-head
    { 
        font-weight:bold; text-align:center; width:14.3%;  
        text-transform: uppercase;
        font-size: 12px;
        padding-top: 20px;
        color: rgba(255,255,255,0.2);
    }
    /* shared */
    table.calendar  td.calendar-day, td.calendar-day-np {  padding:5px; }
</style>