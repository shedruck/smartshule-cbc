<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Fee Status Report</h2> 
    <div class="right">                       
    </div>    					
</div>
<div class="toolbar">
    <div class="noof">
        <div class="col-md-2">&nbsp;</div>
        <div class="col-md-7"><?php echo form_open(current_url()); ?>
             <?php echo form_dropdown('term', array('' => 'Select Term') + $this->terms, $this->input->post('term'), 'class ="fsel" '); ?>
             <?php echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), 'class ="fsel" '); ?>
            <button class="btn btn-primary"  type="submit">View Report</button>
            <?php echo form_close(); ?>
        </div>
        <div class="col-md-2"><div class="date  right" id="menus">
            </div>
            <a href="" onClick="window.print();
                      return false" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
        </div></div>
</div>
<div class="block invoice">
    <?php
        $tyr = date('Y');
        $term = get_term(date('m'));
        if ($this->input->post('term'))
        {
             $term = $this->input->post('term');
        }
        $tm = ' Term ' . $term;
        if ($this->input->post('year'))
        {
             $tyr = $this->input->post('year');
        }
        if ($term == 1)
        {
             $atm = 3;
        }
        else
        {
             $atm = $term - 1;
        }
    ?>
    <div  class="hding">Fee Payment Summary Report  <?php echo $tm . ' ' . $tyr; ?></div>
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="15%">Class</th>
                <th width="15%"> Invoiced Amt</th>
                <?php /*  <th width="15%">Term <?php echo $atm; ?> Arrears</th> */ ?>
                <th width="15%">Waivers</th>
                <th width="15%">Received</th>
                <th width="15%">Balance</th>
                <th width="15%" class="sbh">Action</th>
            </tr>
        </thead>
        <tbody>
             <?php
                 $i = 0;
                 $pd = 0;
                 $invs = 0;
                 $bl = 0;
                 $rr = 0;
                 $wv = 0;
                 foreach ($payload as $kla => $specs)
                 {
                      foreach ($specs as $str => $sp)
                      {
                           $cl = isset($classes[$kla]) ? $classes[$kla] : ' - ';
                           $scl = isset($classes[$kla]) ? class_to_short($cl) : ' - ' . $kla;
                           $strr = isset($streams[$str]) ? $streams[$str] : ' - ' . $str;
                           $invs += $payload[$kla][$str]['Inv'];
                           $pd += $payload[$kla][$str]['Paid'];
                           
                           if (isset($payload[$kla][$str]['waivers']))
                           {
                                $wv += $payload[$kla][$str]['waivers'];
                           }

                           if (isset($payload[$kla][$str]['bal']))
                           {
                                $bl += $payload[$kla][$str]['bal'];
                           }
                           $i++;
                           ?>
                          <tr>
                              <td><?php echo $i . '. '; ?></td>
                              <td> <?php echo $scl . ' ' . $strr; ?></td>
                              <td class="rttb"><?php echo number_format($payload[$kla][$str]['Inv'], 2); ?></td>
                                /* */  <td class="rttb"><?php
                                $ark = (isset($payload[$kla][$str]['arrears'])) ? number_format($payload[$kla][$str]['arrears'], 2) : 0;
                                echo $ark ? anchor('admin/reports/list_arrears/' . $kla . '/' . $str . '/' . $term, $ark) : '0.00';
                                ?></td> 
                              <td class="rttb"><?php echo (isset($payload[$kla][$str]['waivers'])) ? number_format($payload[$kla][$str]['waivers'], 2) : '0.00'; ?></td>
                              <td class="rttb"><?php echo number_format($payload[$kla][$str]['Paid'], 2); ?></td>
                              <td class="rttb"><?php
                                   $arb = (isset($payload[$kla][$str]['bal'])) ? number_format($payload[$kla][$str]['bal'], 2) : 0;
                                   echo anchor('admin/reports/list_bals/' . $kla . '/' . $str . '/', $arb);
                                   ?>
                              </td>
                              <td class="rttb sbh">
                                  <div class='btn-group'>  
                                      <a class='btn btn-warning' href ="<?php echo base_url('admin/fee_payment/blast_sms/' . $kla); ?>"><i class="glyphicon glyphicon-envelope"></i> SMS Parents With Balance</a></div>
                              </td>
                          </tr>
                          <?php
                     }
                }
            ?>
            <tr>
                <td></td>
                <td>Totals</td>
                <td class="rttbd"><?php echo number_format($invs, 2); ?></td>
                <?php /*                     * <td class="rttbd"><?php echo number_format($rr, 2); ?></td> */ ?>
                <td class="rttbd"><?php echo number_format($wv, 2); ?></td>
                <td class="rttbd"><?php echo number_format($pd, 2); ?></td>
                <td class="rttbd"><?php echo number_format($bl, 2); ?></td>
                <td class="rttbd sbh"></td>
            </tr>
        </tbody>
    </table>

    <div class="row">
        <div class="col-md-3"> </div>
        <div class="col-md-9"> <br/><small>Report Generated at : <?php echo date('jS M Y H:i:s'); ?></small> </div>
    </div>

</div>

<script type = "text/javascript">
     $(document).ready(function () {
          $(".fsel").select2({'placeholder': 'Please Select', 'width': '170px'});
          $(".fsel").on("change", function (e) {
               notify('Select', 'Value changed: ' + e.val);
          });
     });
</script>
<style>
    @media print
    {
         .sbh{ display: none;}
         a {color: #000;}

         h3{border: none;}
    }
    .hding
    {
         width: 100%;
         margin: 15px auto;
         font-size: 20px; 
         text-shadow: 1px 1px 0px #FFF;
         color: #42536d;
         border-bottom: 1px solid #DDD; 
    }
</style>