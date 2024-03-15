<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> Bank Reconciliations  </h2>
    <div class="right">  
        <button id="reco" class="btn  btn-success" data-toggle="modal" data-target="#rct"> <i class="glyphicon glyphicon-link"></i>Reconciliation</button>

    </div>
</div>
<div class="block-fluid">
  <?php
    if($recs){
  ?>
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Period</th>
        <th>Bank</th>
        <th>Transaction</th>
        <th>Debit</th>
        <th>Credit</th>
        <th>Recorded By</th>
        <th>Date Recorded</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $index = 1;
      foreach($recs as $r)
      { 
        $user = $this->ion_auth->get_user($r->created_by);
        ?>
      <tr>
        <td><?php echo $index; ?></td>
        <td><?php echo date('M, d Y', $r->period)?></td>
        <td><?php echo isset($banks[$r->bank]) ? $banks[$r->bank] : ''; ?></td>
        <td><?php echo isset($transaction[$r->bank_trans_id]) ? $transaction[$r->bank_trans_id] : '';?></td>
        <td><?php echo number_format(isset($dr[$r->bank_trans_id]) ? $dr[$r->bank_trans_id] : '',2);?></td>
        <td><?php echo number_format(isset($cr[$r->bank_trans_id]) ? $cr[$r->bank_trans_id] : '',2);?></td>
        <td><?php echo ucwords($user->first_name.' '.$user->last_name)?></td>
        <td><?php echo date('M, d Y', $r->created_on)?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php } else { ?>
    <pre>No Data Found!</pre>
    <?php }?>
</div>

<div class="modal fade" id="rct" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Reconciliation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <?php echo form_open(current_url())?>
                <div class='form-group'>
                    <div class="col-md-2" for='bank'>Bank <span class='required'>*</span></div><div class="col-md-10">
                         <?php echo form_dropdown('bank_id', $banks,' class="select"  id="bank_"');?>
                    </div>
                </div>

                <div class='form-group'>
                    <div class="col-md-2" for='date'>Period <span class='required'>*</span></div><div class="col-md-10">
                    <input type="text" name="date" class="datepicker" placeholder="Period">
                    </div>
                </div>

                <div class='form-group'>
                    <div class="col-md-2" for='transaction'>Transction Type <span class='required'>*</span></div>
                    <div class="col-md-10">
                        <?php
                        $trans = ['Deposit' => 'Deposit', 'Widthrawal' => 'Widthrawal'];
                        echo form_dropdown('transaction', $trans,' class="select" id="transaction_" ');
                        ?>		
                    </div>
                </div>

                <div class="form-group col-md-12">
                <div class='col-md-6'>
                    <div class="col-md-2" for='dr'>Debit <span class='required'>*</span></div><div class="col-md-10">
                       <input type="number" name="dr" id="dr_" class="fom-control">
                    </div>
                </div>

                <div class='col-md-6'>
                    <div class="col-md-2" for='cr'>Credit <span class='required'>*</span></div><div class="col-md-10">
                    <input type="number" name="cr" id="cr_" class="fom-control">
                    </div>
                </div>
                </div>
                <br>

                <div class="form-group ">
                  <button type="submit" class="btn btn-success ">Submit</button>
                </div>
       
       </div>
       <?php echo form_close()?>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div> -->
    </div>
  </div>
</div>