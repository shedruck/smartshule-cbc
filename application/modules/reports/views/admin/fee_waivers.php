<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Fee Waivers  </h2>
    <div class="right">  
      
    </div>
</div>

<div class="toolbar">
    <div class="noof">
        <?php echo form_open(current_url()); ?>
       
     
       <div class="col-sm-3">   <?php echo form_dropdown('term', array('' => 'Select Term') + $this->terms, $this->input->post('term'), 'class ="fsel select" '); ?></div>
        
         <div class="col-sm-3"> <?php echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), 'class ="fsel select" '); ?></div>
		  <div class="col-sm-6">
        <button class="btn btn-primary "  type="submit">View Balances</button>
		 <a href="<?php echo base_url('admin/fee_waivers/');?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left"></i> Back
        </a>
		</div>
        <?php echo form_close(); ?>
    </div>
</div>


<?php if ($fee_waivers): ?>
    <div class="block-fluid">
         <table class="table table-striped table-bordered  table-full-width table-hover" id="basic-btn">  
            <thead>
            <th>#</th>
            <th>Date</th>
            <th>Student</th>
            <th>Amount (<?php echo $this->currency;?>)</th>
            <th>Term</th>
            <th>Year</th>
            <th>Remarks</th>
            <th>Recorded By</th>
   
            </thead>
            <tbody>
                <?php
                $i = 0;
                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                {
                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                }

				$total = 0;
                foreach ($fee_waivers as $p):
                    $st = $this->worker->get_student($p->student);
					$u = $this->ion_auth->get_user($p->created_by);
                    if (empty($st))
                    {
                        $st = new stdClass();
                        $st->first_name = '';
                        $st->last_name = '';
                    }
                    $i++;
					$total  +=$p->amount;
                    ?>
                    <tr>
                        <td><?php echo $i . '.'; ?></td>					
                        <td><?php echo date('d M Y', $p->date); ?></td>
                        <td><?php echo $st->first_name . ' ' . $st->last_name; ?></td>
                        <td><?php echo number_format($p->amount, 2); ?></td>
                        <td><?php echo $p->term; ?></td>
                        <td><?php echo $p->year; ?></td>
                        <td><?php echo $p->remarks; ?></td>
                        <td><?php echo $u->first_name; ?> <?php echo $u->last_name; ?></td>

                    </tr>
                <?php endforeach ?>
            </tbody>

        </table>
<center><h3 > TOTAL FEE WAIVERS : <?php echo number_format($total,2);?></h3></center>

    </div>

<?php else: ?>
    <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                 <?php endif ?>