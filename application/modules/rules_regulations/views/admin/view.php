<div class="head"> 
<h2 class=""> Rules and Regulations </h2>
    <div class="  right" id="menus">
     
	  
        <a href="" onClick="window.print();
                    return false" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
    </div>
</div>
 <?php if ($rules_regulations): ?>
<div class="widget">
    <div class="col-md-12 slip">

        <div class="statement">
            <div class="block invoice slip-content">
			  <?php foreach ($rules_regulations as $p ): ?>
			    <hr>
			    <h3 style="text-align:center"> <?php echo $p->title;?></h3>
				<hr>
			      <?php echo $p->content;?>
				  
			  <?php endforeach ?>
			</div>
		</div>
	</div>
</div>


<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>
