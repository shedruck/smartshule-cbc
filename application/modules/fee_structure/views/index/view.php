<div class="row" id='x-acts' > 
    <div class=" pull-right" > 
        <a href="" onClick="window.print();
                      return false" class="btn btn-custom"><i class="icos-printer"></i> Print</a>
    </div>
</div>
<div class="row">
    <div  class="col-md-12 col-sm-6 col-xs-12 " >

        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td style="margin: 0px" bgcolor="#ffffff" width="100%">
                    <table width="90%" cellpadding="0" cellspacing="0" border="0" align="center" style="background-color:#ffffff; font-size:14px; color: #7c7c7c">
                        <tr>
                            <td valign="top">
                        <tr>
                            <td valign="top" style=" font-size:14px; color: #7c7c7c; line-height:1.7em;  padding:10px;">
                                <div class="title-unit">
                                    <p><?php echo $this->school->school; ?> - School Fee Structure</p>
                                    <span class="small-bottom-border big"></span> 
                                </div>

                                <table cellspacing = "0" width="100%" class="display">
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
                                    <?php
                                    if (count($fxtras))
                                    {
                                            ?>
                                            <tr> <td colspan="4"> <strong>Other Charges</strong>(Kshs.)</td>  </tr>
                                            <?php
                                            $j = 0;
                                            foreach ($fxtras as $fx)
                                            {
                                                    $j++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $j . '.'; ?></td>
                                                        <td><?php echo $fx->title; ?> </td>
                                                        <td><?php echo $fx->cycle == 999 ? 'On Demand' : $fx->cycle; ?></td>
                                                        <td class="rttx"><?php echo number_format($fx->amount, 2); ?></td>
                                                    </tr>
                                            <?php } ?>

                                    <?php } ?>
                                </table>
                                <hr/>

                            </td>
                        </tr>
                </td>
            </tr>
            <tr>
                <td height="20">
                </td>
            </tr>
        </table>

        <!-- footer ends -->
        </td>
        </tr>
        </table>
    </div>
</div><!-- End .row -->
