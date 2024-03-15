<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  PAYE  </h2>
    <div class="right">  
    </div>
</div>
<?php if ($paye): ?>
        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Range From (<?php echo $this->currency; ?>)</th>
                        <th>Range To (<?php echo $this->currency; ?>)</th>
                        <th>Tax</th>
                        <th>Amount (<?php echo $this->currency; ?>)</th>
                        <th ><?php echo lang('web_options'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per;
                    }
                    foreach ($paye as $p):
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php
                                    if (is_numeric($p->range_from))
                                    {
                                            echo number_format($p->range_from, 2);
                                    }
                                    else
                                    {
                                            echo '<i style="color:green">' . $p->range_from . '</i>';
                                    }
                                    ?></td>
                                <td><?php
                                    if (is_numeric($p->range_to))
                                    {
                                            echo number_format($p->range_to, 2);
                                    }
                                    else
                                    {
                                            echo '<i style="color:green">' . $p->range_to . '</i>';
                                    }
                                    ?></td>
                                <td><?php echo $p->tax; ?>%</td>
                                <td><?php
                                    if (is_numeric($p->amount))
                                    {
                                            echo number_format($p->amount, 2);
                                    }
                                    else
                                    {
                                            echo $p->amount;
                                    }
                                    ?></td>
                                <td width='20%'>
                                    <a class="btn btn-primary" href='<?php echo site_url('admin/paye/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
                                </td>
                            </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif; ?>