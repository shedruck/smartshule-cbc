<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">  
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                           <div class="col-md-6">					  
                                <h4 class="m-b-10"> Fee Structure </h4>
                            </div>
                            <div class="col-md-6">
                                <div class="pull-right">
								 
                 <a href="" onClick="window.print();
                    return false" class="btn btn-success"><i class="icos-printer"></i> Print</a>
				
				<?php echo anchor( 'st#finance' , '<i class="fa fa-home">
                </i> Exit', 'class="btn btn-sm btn-danger"');?> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<hr>
				
				
     <div class="block-fluid">
		  <?php $settings = $this->ion_auth->settings();?>
		  
  <div class="image text-center" >
			<img  src="<?php echo base_url('uploads/files/' . $settings->document); ?>" class="text-center" align="center" style="" width="120" height="120" />    
		</div>

                
				<h3 style="text-align: center;"><?php echo $settings->school;?></h3>
<ul style="text-align: center;">
<li><?php echo $settings->postal_addr;?></li>
</ul>
<p style="text-align: center;">Tel: <?php echo $settings->tel;?> <?php echo $settings->cell;?>&nbsp; &nbsp;&nbsp;&nbsp; Email: <?php echo $settings->email;?></p>


<div class="row">
    <div  class="col-sm-12" >
                     <strong>Tuition Fee </strong>(Kshs.)
					 <hr>
                        <div class="dt-responsive table-responsive">
                         <table id="" class="table table-striped table-bordered"> 
							
								
								      <thead>
									  <tr>  
											<th>#</th>
											<th>Class/Level</th>
											<th>Term</th>
											<th>Amount</th>
                                         </tr> 
									</head>
                                    <?php
                                    $i = 0;
                                    foreach ($fee as $title => $feest)
                                    {
                                            ?>
                                            <tr> <td colspan="4"> <strong><?php echo $title; ?></strong>(Kshs.)</td>  </tr>
                                            <?php
                                            ksort($feest);
                                            foreach ($feest as $class => $specs)
                                            {
                                                    $fs = (object) $specs;
                                                    $fcl = isset($this->classes[$class]) ? $this->classes[$class] : ' -';
                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td> <?php echo $i . '.'; ?></td>
                                                        <td><?php echo $fcl; ?></td>
                                                        <td><?php echo $fs->term; ?></td>
                                                        <td class="rttx"><?php echo number_format($fs->amount, 2); ?></td>
                                                    </tr>
                                                    <?php
                                            }
                                    }
                                    ?>
									
								</table>
							<strong>Other Charges</strong>(Kshs.)
							<hr>
                                    <?php
                                    if (count($fxtras))
                                    {
                                            ?>
								 <div class="dt-responsive table-responsive">
                                   <table id="" class="table table-striped table-bordered"> 
                                     <thead>								   
										<tr>  
											<th>#</th>
											<th>Description</th>
											<th>Charge</th>
											<th>Amount</th>
                                         </tr> 
                                       </thead> 
                                            <?php
                                            $j = 0;
                                            foreach ($fxtras as $fx)
                                            {
                                                    $j++;
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $j . '.'; ?></td>
                                                        <td class="text-center"><?php echo $fx->title; ?> </td>
                                                        <td class="text-center"><?php echo $fx->cycle == 999 ? 'On Demand' : $fx->cycle; ?></td>
                                                        <td class="rttx text-center"><?php echo number_format($fx->amount, 2); ?></td>
                                                    </tr>
                                            <?php } ?>

                                    <?php } ?>
                                </table>
               

        <!-- footer ends -->
        </td>
        </tr>
        </table>
		
		  <?php
                                if ($banks)
                                {
                                        ?>
								<strong>Bank(s) Details</strong>
								
							   <div class="dt-responsive table-responsive">
                                   <table id="" class="table table-striped table-bordered"> 
                                        <thead>
                                            <tr style="border:none !important">
                                                <th width="3%">#</th>
                                                <th>Bank Name</th>
                                                <th>Account Name</th>
                                                <th>Branch</th>
                                                <th>Account No.</th>
                                            </tr>
                                        </thead>
                                            <?php
                                            $i = 0;
                                            foreach ($banks as $b)
                                            {
                                                    $i++;
                                                    ?>
                                                    <tr style="border:none !important">
                                                        <td class="text-center"><?php echo $i; ?></td>
                                                        <td class="text-center"><?php echo $b->bank_name ?></td>
                                                        <td class="text-center"><?php echo $b->account_name ?></td>
                                                        <td class="text-center"><?php echo $b->branch ?></td>
                                                        <td class="text-center"><?php echo $b->account_number ?></td>
                                                    </tr>

                                            <?php } ?>
                                    <?php } ?>
                                </table>
                                <span class="bg-red text-center" >
                                    <h4 style="background:#0083C4; padding:6px;"> Thank you for choosing <?php
                                        $ss = $this->school;
                                        echo $ss->school;
                                        ?>
									</h4>
                                </span>
								
								
    </div>
</div><!-- End .row -->
