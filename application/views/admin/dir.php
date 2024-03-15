<div class="row">
    <div class="col-md-12 middle">
        <div class="informer">
            <a href="<?php echo base_url('admin/admission'); ?>">
                <span class="icomg-user2"></span>
                <span class="text">Students</span>
            </a>           
        </div>
        <div class="informer">
            <a href="<?php echo base_url('admin/exams'); ?>">
                <span class="icomg-clipboard1"></span>
                <span class="text">Exams Management</span>                        
            </a>
        </div>             
        <div class="informer">
            <a href="<?php echo base_url('admin/fee_payment'); ?>">
                <span class="icomg-tag"></span>
                <span class="text">Fee Status</span>                        
            </a>
        </div> 
        <div class="informer">
            <a href="<?php echo base_url('admin/reports/fee'); ?>">
                <span class="icomg-stats-up"></span>
                <span class="text">Fee Summary</span>                     
            </a>
        </div>

        <div class="informer">
            <a href="<?php echo base_url('admin/expenses'); ?>">
                <span class="icomg-contract"></span>
                <span class="text">Expenses</span>
            </a>
        </div>
        <div class="informer">
            <a href="<?php echo base_url('admin/expenses/requisitions'); ?>">
                <span class="icomg-pencil2"></span>
                <span class="text">Requisitions</span>
            </a>
            <span class="caption purple"><?php echo $reqs; ?></span>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-8">
        <div class="widget">
            <div class="head dark">
                <div class="icon"><i class="icos-stats-up"></i></div>
                <h2>Recently Registered Students</h2>
                <ul class="buttons">                            
                    <li><a href="<?php echo base_url('admin/admission/create/'); ?>"><span class="icos-plus"></span></a></li>
                    <li><a href="<?php echo base_url('admin/admission/'); ?>"><span class="icos-cog"></span></a></li>
                </ul>                         
            </div>                
            <div class="block-fluid">
                <table class="table table-hover" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="checkall"/></th>
                            <th width="25%">Name</th>
                            <th width="20%">ADM Date</th>
                            <th width="20%">ADM No.</th>
                            <th width="14%">Gender</th>
                            <th width="26%">Time</th>
                            <th width="15%" class="TAC">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php
                             $i = 0;
                             $sts = $this->ion_auth->list_students();
                             foreach ($sts as $st):
                                  $i++;
                                  ?>
                                 <tr>
                                     <td><input type="checkbox" name="order[]" value="528"/></td>
                                     <td><a style="font-size:.8em" href="<?php echo base_url('admin/admission/view/' . $st->id); ?>"><?php echo $st->first_name . ' ' . $st->last_name; ?></a></td>
                                     <td><?php echo $st->admission_date > 10000 ? date('d/m/Y', $st->admission_date) : '-'; ?></td>
                                     <td><?php
                                          if (!empty($st->old_adm_no))
                                          {
                                               echo $st->old_adm_no;
                                          }
                                          else
                                          {
                                               echo $st->admission_number;
                                          }
                                          ?></td>
                                     <td><?php
                                          if ($st->gender)
                                          {
                                               if ($st->gender == 1)
                                                    echo 'Male';
                                               else
                                                    echo 'Female';
                                          }
                                          ?></td>
                                     <td><?php echo time_ago($st->created_on); ?></td>
                                     <td class="TAC">
                                         <a href="<?php echo base_url('admin/admission/view/' . $st->id); ?>"><span class="glyphicon glyphglyphicon glyphicon-eye-open"></span></a> 
                                         <a href="<?php echo base_url('admin/admission/edit/' . $st->id); ?>"><span class="glyphicon glyphglyphicon glyphicon-pencil"></span></a> 
                                     </td>
                                 </tr>
                            <?php endforeach ?>                         
                    </tbody>
                </table>                    
            </div> 
        </div>     
        <div class="widget">
            <div class="head dark">
                <div class="icon"><span class="icos-calendar"></span></div>
                <h2>Recent Fee Payments</h2>
                <ul class="buttons">                            
                    <li><a href="#"><span class="icos-refresh"></span></a></li>
                    <li><a href="#"><span class="icos-history"></span></a></li>
                    <li><a href="#"><span class="icos-flag1"></span></a></li>
                </ul>                         
            </div>
            <div class="block-fluid">
                <table class="table table-hover" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="checkall"/></th>
                            <th width="35%">Studennt</th>
                            <th width="10%">Amount</th>
                            <th width="20%">Paid On</th>
                            <th width="20%">Recorded By</th>
                            <th width="7%" class="TAC">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php
                             $this->load->library('Dates');
                             foreach ($recent_payments as $py):
                                  $u = $this->ion_auth->get_user($py->created_by);
                                  $st = $this->worker->get_student($py->reg_no);
                                  if (empty($st))
                                  {
                                       $st = new stdClass();
                                       $st->first_name = '';
                                       $st->last_name = '';
                                  }
                                  ?>
                                 <tr>
                                     <td><input type="checkbox" name="ids[]" value="<?php echo $py->id; ?>"/></td>
                                     <td><a style="font-size:.8em" href="<?php echo base_url('admin/admission/view/' . $py->reg_no); ?>"><?php echo $st->first_name . ' ' . $st->last_name; ?></a></td>
                                     <td><?php echo number_format($py->amount, 2); ?></td>
                                     <td><?php echo $this->dates->createFromTimeStamp($py->created_on)->diffForHumans(); ?></td>
                                     <td><?php echo $u->first_name . ' ' . $u->last_name; ?></td>
                                     <td class="TAC">
                                         <a href="<?php echo base_url('admin/fee_payment/receipt/' . $py->receipt_id); ?>" title="View Receipt"><span class="glyphicon glyphglyphicon glyphicon-eye-open"></span></a> 
                                     </td>
                                 </tr>
                            <?php endforeach ?>                         
                    </tbody>
                </table>                    
            </div> 
            <div class="toolbar-fluid">
                <div class="information">
                    <div class="item">
                        <div class="rates">
                            <div class="title"><?php
                                     if (empty($total_fees->total))
                                          echo '0.00';
                                     else
                                          echo number_format($total_fees->total, 2);
                                 ?></div>
                            <div class="description">Total Paid Fees (<?php echo $this->currency; ?>)</div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="rates">
                            <div class="title"><?php
                                     $t = $total_petty_cash->total + $wages + $total_expenses->total;
                                     echo number_format($t, 2);
                                 ?></div>
                            <div class="description">Total Expenses (<?php echo $this->currency; ?>)</div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="rates">
                            <div class="title"><?php
                                     if (empty($total_waiver->total))
                                          echo '0.00';
                                     else
                                          echo number_format($total_waiver->total, 2);
                                 ?> </div>
                            <div class="description">Total Fee Waivers (<?php echo $this->currency; ?>)</div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="rates">
                            <div class="title"><?php
                                     if (empty($total_stock->total))
                                          echo '0.00';
                                     else
                                          echo number_format($total_stock->total, 2);
                                 ?></div>
                            <div class="description">Inventory Totals</div>
                        </div>
                    </div>                            
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4" >
        <div class="widget">
            <div class="head dark">
                <div class="icon"><i class="icos-tag"></i></div>
                <h2>Cashflow Summary</h2>
                <ul class="buttons">                                                        
                    <li><a href="#"><span class="icos-cog"></span></a></li>
                </ul>                          
            </div>
            <div class="block TAC">
                <div id= "money" style="width: 100%; height: 350px;"></div>
            </div>
        </div>
        <div class="widget"> 
            <div class="head dark">
                <div class="icon"><i class="icos-user2"></i></div>
                <h2>Logged in Users</h2>
                <ul class="buttons">                                                        
                    <li><a href="#" class="cblock"><span class="icos-menu"></span></a></li>
                </ul>                       
            </div> 
            <div class="block-fluid users">
                <div class="scroll" style="height: 200px;">
                     <?php
                         foreach ($users as $u)
                         {
                              $user = $this->ion_auth->get_user($u->user_id);
                              ?>
                             <div class="userCard">
                                 <div class="image">
                                      <?php echo theme_image('examples/users/avatar.png', array('class' => "img-polaroid")); ?>
                                 </div>
                                 <div class="info-s">
                                     <h3><?php echo $user->first_name . ' ' . $user->last_name; ?></h3>
                                     <p><span class="glyphicon glyphglyphicon glyphicon-envelope"></span> <?php echo $user->email; ?></p>
                                     <?php
                                     foreach ($u->groups as $g)
                                     {
                                          ?>
                                          <span class="label label-info"><?php echo rtrim($g->description, 's'); ?></span>
                                     <?php } ?>
                                     <div class="informer">
                                         <span></span>
                                     </div>
                                 </div>
                             </div>
                        <?php } ?>
                </div>  
                <div class="toolbar">
                    <div class="left">
                        <div class="btn-group">
                            <button class="btn " >Total (<?php echo count($users); ?>)</button>                            
                        </div>                         
                    </div>
                </div>                    
            </div>                               
        </div>        
    </div>

</div>
<?php
            $pie[] = array(
                    'label' => "Fee Paid",
                    'data' => $total_fees->total,
            );
            $pie[] = array(
                    'label' => "Expenses",
                    'data' => $total_expenses->total,
            );
            if (isset($total_petty_cash->total) && $total_petty_cash->total)
            {
                 $pie[] = array(
                         'label' => "Petty Cash",
                         'data' => $total_petty_cash->total,
                 );
            }
            if (isset($wages) && $wages)
            {
                 $pie[] = array(
                         'label' => "Payroll",
                         'data' => $wages,
                 );
            }
            $tam = get_term(date('m'));
        ?>
 <script>
             $(document).ready(function ()
             {
                  // PIE CHART
                  var chartData = <?php echo json_encode($pie); ?>;
                  pie = new AmCharts.AmPieChart();
                  pie.dataProvider = chartData;
                  pie.titles = [{"text": " Cashflow <?php echo ' - Term ' . $tam . ' ' . date('Y') . ' (' . $this->currency . ')'; ?> ", "size": 12, "color": "#4B990F", "alpha": 0, "bold": true}];
                  pie.titleField = "label";
                  pie.valueField = "data";
                  pie.labelsEnabled = false;
                  pie.autoMargins = false;
                  pie.marginTop = 0;
                  pie.marginBottom = 0;
                  pie.marginLeft = 0;
                  pie.marginRight = 0;
                  pie.pullOutRadius = 10;
                  pie.depth3D = 15;
                  pie.angle = 52;
                  pie.exportConfig = {
                       menuTop: '21px',
                       menuLeft: 'auto',
                       menuRight: '21px',
                       menuBottom: '0px',
                       menuItems: [{
                                 textAlign: 'center',
                                 onclick: function ()
                                 {
                                 },
                                 icon: '<?php echo base_url('assets/export.png'); ?>',
                                 iconTitle: 'Save chart as an image',
                                 items: [{
                                           title: 'IMAGE',
                                           format: 'png'
                                      }, {
                                           title: 'PDF',
                                           format: 'pdf'
                                      }]
                            }],
                       menuItemStyle: {
                            backgroundColor: 'transparent',
                            rollOverBackgroundColor: '#EFEFEF',
                            color: '#000000',
                            rollOverColor: '#CC0000',
                            paddingTop: '6px',
                            paddingRight: '6px',
                            paddingBottom: '6px',
                            paddingLeft: '6px',
                            marginTop: '0px',
                            marginRight: '0px',
                            marginBottom: '0px',
                            marginLeft: '0px',
                            textAlign: 'left',
                            textDecoration: 'none'
                       }
                  };
                  // LEGEND
                  legend = new AmCharts.AmLegend();
                  legend.align = "center";
                  legend.markerType = "circle";
                  pie.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
                  pie.addLegend(legend);
                  // WRITE
                  pie.write("money");
             });
             /*End Dashboard PIE*/
             
        </script>