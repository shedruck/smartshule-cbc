

<div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2>  Expenses </h2> 
                     <div class="right">                            
                       
            <?php echo anchor( 'admin/expenses/create/'.$page, '<i class="glyphicon glyphicon-plus">                </i>'.lang('web_add_t', array(':name' => 'Expenses')), 'class="btn btn-primary"');?>
                <?php echo anchor( 'admin/expenses/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
				<?php echo anchor( 'admin/expenses/voided' , '<i class="glyphicon glyphicon-list">
                </i> Voided Expenses', 'class="btn btn-warning"');?>
			
                     </div>    					
                </div>
				<?php if ($expenses): ?>    

 <div class="toolbar-fluid">
                            <div class="information">
								 <div class="item">
                                    <div class="rates">
                                        <div class="title"><?php 
										if(empty($total_exp_day->total)) echo '0.00';
										else echo number_format($total_exp_day->total,2);?> </div>
                                        <div class="description">Total Expenses Today (<?php echo $this->currency;?>)</div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="rates">
                                        <div class="title"><?php if(empty($total_exp_month->total))echo '0.00'; else echo number_format($total_exp_month->total,2);?></div>
                                        <div class="description">Total Expenses This Month (<?php echo $this->currency;?>)</div>
                                    </div>
                                </div>
                               
                               
                                <div class="item">
                                    <div class="rates">
                                        <div class="title"><?php 
										if(empty($total_exp_year->total)) echo '0.00';
										else echo number_format($total_exp_year->total,2);?></div>
                                        <div class="description">Total Expenses This Year (<?php echo $this->currency;?>)</div>
                                    </div>
                                </div> 
                                <div class="item">
                                    <div class="rates">
                                        <div class="title"><?php if(empty($total_expenses->total))echo '0.00'; else echo number_format($total_expenses->total,2);?></div>
                                        <div class="description">Full Total Expenses (<?php echo $this->currency;?>)</div>
                                    </div>
                                </div>								
                            </div>
                        </div>
				
               <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
  
	 <thead>
                <th>#</th>
				<th>Date</th>
				<th>Title</th>
				<th>Category</th>
				<th>Amount</th>
				<th>Person Responsible</th>
				<th>Receipt</th>
				<th>Description</th>
				<th >Voided By</th>
				<th >Date Voided</th>
		</thead>
		<tbody>
		<?php 
			 $i = 0;
			 $j = 0;
				if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
				{
					$i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
				}
                
            foreach ($expenses as $p ): 
			  $user=$this->ion_auth->get_user($p->person_responsible);
			  $u=$this->ion_auth->get_user($p->modified_by);
                 $i++;
                 $j++;
                     ?>
	 <tr>
                <td><?php echo $j . '.'; ?></td>					
				<td><?php echo date('d/m/Y',$p->expense_date);?></td>
				<td><?php echo isset($items[$p->title]) ? $items[$p->title] : ' ';?></td>
				<td><?php echo $cats[$p->category];?></td>
				<td><?php echo number_format($p->amount,2);?></td>
				<td><?php echo $user->first_name.' '.$user->last_name;?></td>
				<td>
				<?php if(!empty($p->receipt)):?>
				<a href='<?php echo base_url();?>uploads/files/<?php echo $p->receipt?>' />Download receipt</a>
				<?php else:?>
				................
				<?php endif?>
				</td>
				<td><?php echo $p->description;?></td>
				 <td><?php echo $u->first_name.' '.$u->last_name;?></td>
				 <td ><?php echo date('d/m/Y',$p->modified_on);?></td>
					</tr>
 			<?php endforeach ?>
		</tbody>

	</table>
</div>
	

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>