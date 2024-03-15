<div class="head">
    <div class="icon">
        <span class="icosg-target1"></span></div>
    <h2>Admission Report</h2>
    <div class="right">  
    <div class="noof">
    
        <div class="pull-right"> 
            <a href="" onClick="window.print();
                      return false" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
        </div>
     
    </div>                     
    </div>    					
</div>



<div class=" center">

 <div class="col-sm-12 ">
            <span class="" style="text-align:center">
                <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  width="100" height="100" />
            </span>
            <h3>
                <span style="text-align:center !important;font-size:15px;"><?php echo strtoupper($this->school->school); ?></span>
            </h3>
            <small style="text-align:center !important;font-size:12px; line-height:2px;">
                <?php
                if (!empty($this->school->tel))
                {
                    echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                }
                else
                {
                    echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                }
                ?>
            </small>
            <h3>
                <span style="text-align:center !important;font-size:13px; font-weight:700; border:double; padding:5px;">MOTTO: <?php echo strtoupper($this->school->motto); ?></span>
            </h3>
            <br>
            <small style="text-align:center !important;font-size:20px; line-height:2px; border-bottom:2px solid  #ccc;">School Population as at <?php echo date('d M Y - h:i:s')?></small>
            <br>
           
            <br>
        </div>
		
    
</div>
<div class="block invoice">

             <table cellpadding="0" class="table" cellspacing="0" width="100%">
                 <thead>
				      <tr>
                         <th colspan="4"><center>FEMALE</center></th>
                         <th colspan="3"><center>MALE</center></th>
                         <th colspan="3"><center>TOTAL STUDENTS</center></th>
                       </tr> 
                    
                         <th >Class</th>
                         <th >Day Scholars</th>
                         <th >Boarders</th>
                         <th >Total</th>

                         <th >Day Scholars</th>
                         <th >Boarders</th>
                         <th >Total</th>
						 			 
                         <th >Day Scholars</th>
                         <th >Boarders</th>
                         <th >Total</th>
                           
                 </thead>
                 <tbody>
                    
					<?php 
								 $total_female_day = 0;
                                        $total_female_bodas = 0;

                                        $total_male_day = 0;
                                        $total_male_bodas = 0;


                                        $total_day = 0;
                                        $total_bodas = 0;

                                        $total_students = 0;


							foreach($adm as $p) {
                ?>
                     <tr >
                         <td colspan="10" style="text-decoration:underline"><b><?php echo strtoupper($p->name); ?></b> </td>
                     </tr>
					 <?php 
										
										$cls = $this->portal_m->get_cls($p->id);
                                       



										foreach($cls  as $c){ 
										
											$f_day = $this->portal_m->count_pop($c->id,'Day Scholar',2);
											$f_border = $this->portal_m->count_pop($c->id,'Boarding',2);
											
											$m_day = $this->portal_m->count_pop($c->id,'Day Scholar',1);
											$m_border = $this->portal_m->count_pop($c->id,'Boarding',1);

											
											$tborders = $f_border + $m_border;
											$tday = $f_day + $m_day;
											
											$tot_class = $tborders + $tday;

											$total_female_day +=$f_day;
											$total_male_bodas +=$f_border;

											 $total_male_day += $m_day;
                                             $total_male_bodas = $m_border;

											 $total_day += $tday ;
                                             $total_bodas += $tborders;
											
										
										?>
					<tr style="background:none"> 
						<td  ><?php echo $streams[$c->stream]; ?></td>
	
							 <td><?php echo $f_day;?></td>
							 <td><?php echo $f_border; ?></td>
							 <td><?php $tot_f = $f_day +$f_border; echo number_format($tot_f) ?></td>
							 
							 
							 <td><?php echo $m_day;?></td>
							 <td><?php echo $m_border; ?></td>
							 <td><?php $tot_m = $m_day + $m_border; echo number_format($tot_m) ?></td>
							 
							
							 <td><?php echo $tday ;?></td>
							 <td><?php echo $tborders ;?></td>
							 <td><?php echo $tot_class ;?></td>
						</tr>
						<?php } ?>


					<?php } ?>

<tr style="border:double"> 
						<td  >TOTALS</td>
	
							 <td><?php echo $total_female_day;?></td>
							 <td><?php echo $total_female_bodas; ?></td>
							 <td><?php $tot_ff = $total_female_day +$total_female_bodas; echo number_format($tot_ff) ?></td>
							 
							 
							 <td><?php echo $total_male_day;?></td>
							 <td><?php echo $total_male_bodas; ?></td>
							 <td><?php $tot_mm = $total_male_day + $total_male_bodas; echo number_format($tot_mm) ?></td>
							 
							
							 <td><?php echo $total_day ;?></td>
							 <td><?php echo $total_bodas ;?></td>
							 <td><?php $total_students = $total_day + $total_bodas; echo number_format($total_students) ;?></td>
						</tr>
                    
                 </tbody>
             </table>
          
      
    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3"> </div>
    </div>

</div>

