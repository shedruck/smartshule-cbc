<div class="innerLR">

    <div class="col-md-11">
        <div class="widget widget-gray widget-body-black">
            <div class="widget-head">
                <h4 class="heading">Sms </h4>
             </div>
            <div class="widget-body" style="padding: 10px 0;">
                <?php echo anchor('admin/sms/create/' . $page, 'Send Email', 'class="btn btn-success pull-right" '); ?>
                <br>
                <br>
            
                        <div class='space-6'></div>
                        <div class="table-responsive" style="">
                            <table class="table">
                                <thead>
                                <th>#</th>
                                <th>Phone</th>
                                <th>Description</th>
                                <th ></th>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($sms as $sms_m): 
									
                                            ?>
                                            <tr>					
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $sms_m->dest; ?></td>
                                                <td><?php echo $sms_m->relay; ?></td>
                                               
                                            </tr>
                                            <?php
                                            $i++;
                                    endforeach
                                    ?>
                                </tbody>

                            </table>
                            

                </div>
            </div>
        </div>  
    </div>  
</div>