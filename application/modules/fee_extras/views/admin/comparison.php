<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Comparison  </h2>
    <div class="right">  
      

    </div>
</div>
 
 
        <div class="block-fluid row">
            <div class="col-md-6">
                 <h5>In Extras & Not in Transport</h5>
            <table class="table" cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                     <th>#</th>
                     <th>Admission</th>
                     <td>Student</td>
                     <td>Status</td>
                     <td>Statement</td>
                 </thead>
                 <tbody>
                     <?php
                     $i = 1;
                        foreach($misx as $key => $student)
                        {
                            $std =  $this->worker->get_student($student);
                     ?>
                        <tr>
                            <td><?php echo $i?></td>
                            <td><?php echo $std->admission_number ? $std->admission_number : $std->old_adm_no ?></td>
                            <td><?php echo ucfirst($std->first_name.' '.$std->middle_name.' '.$std->last_name)?></td>
                            <td><?php echo ($std->status ==1) ? 'Active': 'Inactive'?></td>
                            <td><a href="<?php echo base_url('admin/fee_payment/statement/'.$student)?>" target="_blank">View</a></td>
                        </tr>

                 <?php $i++; }?>
                 </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <h5>In Transport & Not in Extras</h5>
            <table class="table" cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                     <th>#</th>
                     <th>Admission</th>
                     <td>Student</td>
                     <td>Status</td>
                     <td>Statement</td>
                 </thead>

                 <tbody>
                     <?php
                     $i = 1;
                        foreach($mist as $key => $st)
                        {
                            $std =  $this->worker->get_student($st);
                     ?>
                        <tr>
                            <td><?php echo $i?></td>
                            <td><?php echo $std->admission_number ? $std->admission_number : $std->old_adm_no ?></td>
                            <td><?php echo ucfirst($std->first_name.' '.$std->middle_name.' '.$std->last_name)?></td>
                            <td><?php echo ($std->status ==1) ? 'Active': 'Inactive'?></td>
                             <td><a href="<?php echo base_url('admin/fee_payment/statement/'.$student)?>" target="_blank">View</a></td>
                        </tr>

                 <?php $i++; }?>
                 </tbody>
                 
            </table>
        </div>

        </div>

 