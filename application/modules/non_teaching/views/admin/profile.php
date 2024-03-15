<?php
//Variables;
$total_sales = $this->portal_m->merchant_sales($post->user_id)->total;
if (!$total_sales == 0)
        $percent = ($total_sales * 100) / $my_target;
else
        $percent = 0;
?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="col-md-3 col-sm-4 col-xs-12">
        <div class="uprofile-image">
            <?php echo theme_image('m1.png'); ?>
        </div>
        <div class="uprofile-name">
            <h3>
                <a href="#"><?php echo $post->first_name . ' ' . $post->last_name ?></a>
                <!-- Available statuses: online, idle, busy, away and offline -->
                <span class="uprofile-status online"></span>
            </h3>
            <p class="uprofile-title"><?php echo $group[$post->group_id] ?></p>
        </div>
        <div class="uprofile-info">
            <ul class="list-unstyled">
                <li><i class='fa fa-user'></i> <?php echo $post->gender ?></li>
                <li><i class='fa fa-phone'></i> <?php echo $post->phone ?></li>
                <li><i class='fa fa-envelope'></i> <?php echo $post->email ?></li>
                <?php
                if (isset($post->address) && !empty($post->address))
                {
                        ?>
                        <li><i class='fa fa-folder-open'></i> <?php echo $post->address ?></li>
                <?php } ?>
                <?php
                if (isset($post->additionals) && !empty($post->additionals))
                {
                        ?>
                        <li><i class='fa fa-book'></i> <?php echo $post->additionals ?></li>
                <?php } ?>
            </ul>
        </div>
        <div class="uprofile-buttons">
            <a class="btn btn-md btn-primary">Send Message</a>

        </div>

    </div>
    <div class="col-md-9 col-sm-8 col-xs-12">

        <div class="row">
            <div class="col-md-4 percent">

                <span class=''>
                    <i class='icon-purple fa fa-square icon-xs icon-1'></i>&nbsp;<small>Achieved</small>
                    &nbsp; &nbsp;<i class='fa fa-square icon-xs icon-2'></i>&nbsp;<small>Target</small></span>
                <div style="width:120px;height:120px;margin: 0 auto;">
                    <span class="db_easypiechart1 easypiechart" data-percent="<?php echo $percent ?>">
                        <span class="percent" style='line-height:120px;'></span></span>
                </div>

            </div>

            <div class="col-md-4 col-sm-6 col-xs-6">
                <div class="r4_counter db_box">
                    <i class='pull-left fa fa-shopping-cart icon-md icon-rounded icon-warning'></i>
                    <div class="stats">
                        <h4><strong><?php echo number_format($my_target) ?> </strong></h4>
                        <span><?php echo date('M') ?> Target</span>
                    </div>
                </div>
            </div> 
            <div class="col-md-4 col-sm-6 col-xs-6">
                <div class="r4_counter db_box">
                    <i class='pull-left fa fa-thumbs-up icon-md icon-rounded icon-success'></i>
                    <div class="stats">
                        <h4><strong><?php echo number_format($total_sales); ?></strong></h4>
                        <span>Achieved</span>
                    </div>
                </div>
            </div>


        </div>  <hr>

        <div class="panel panel-default"> 
            <header class="panel_header">

                <h2 class="title pull-left " >  Recent Orders By <?php echo $post->first_name; ?></h2>
                <br>

            </header>

            <?php if ($recent_sales): ?>
                    <div class='clearfix'></div>


                    <table class="table table-bordered table-striped ">       	
                        <thead>
                        <th>#</th>
                        <th>Item</th>

                        <th>Size</th>
                        <th>Quantity</th>	

                        <th>Retailer</th>	
                        <th>Time Ago</th>	

                        <th>Status</th>	
                        <th ><?php echo lang('web_options'); ?></th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;

                            foreach ($recent_sales as $p):
                                    $u = $this->ion_auth->get_user($p->created_by);
                                    $i++;
                                    if ($i == 6)
                                            break;
                                    ?>
                                    <tr>
                                        <td><?php echo $i . '.'; ?></td>					
                                        <td><?php echo $items[$p->product_item]; ?></td>

                                        <td><?php echo $p->size; ?></td>
                                        <td><?php echo $p->quantity . ' ' . $p->type; ?></td>

                                        <td><?php echo $retailers[$p->retailer]; ?></td>
                                        <td><?php echo time_ago($p->date); ?></td>

                                        <td><?php
                                            if ($p->status == "Pending")
                                                    echo '<b class="label label-warning">' . $p->status . '</b>';
                                            elseif ($p->status == "Delivered")
                                                    echo '<b class="label label-success">' . $p->status . '</b>';
                                            ?></td>
                                        <td width=''>

                                            <a role='menuitem' class="btn btn-sm btn-success" style='color:green' tabindex='-1' data-toggle="modal" href='#view_<?php echo $p->id; ?>'>
                                               <i class='fa fa-arrow-right'></i> View
                                            </a>

                                        </td>
                                    </tr>



                                    <!----- View Details--------------->
                                <div id="view_<?php echo $p->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-responsive-label" data-width="800" aria-hidden="true" class="modal fade">


                                    <div class="modal-dialog" style="width: 65%">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" data-dismiss="modal" aria-hidden="true"
                                                        class="close">&times;</button>
                                                <h4 id="modal-responsive-label" class="modal-title">Order Details</h4></div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        <div class="col-md-6">     
                                                            <p><b class="col-md-4">Order Date:</b> <?php echo date('d M y', $p->created_on); ?></p>
                                                            <p><b class="col-md-4">Item:</b> <?php echo $items[$p->product_item]; ?></p>
                                                            <p><b class="col-md-4">Category:</b> <?php echo $category[$p->product_category]; ?></p>
                                                            <p><b class="col-md-4">Size:</b> <?php echo $p->size; ?></p>
                                                            <p><b class="col-md-4">Quantity:</b> <?php echo $p->quantity; ?></p>

                                                        </div>
                                                        <div class="col-md-6"> 
                                                            <p><b class="col-md-4">Packages:</b> <?php echo $p->type; ?></p>
                                                            <p><b class="col-md-4">Retailer</b> <?php echo $retailers[$p->retailer]; ?></p>
                                                            <p><b class="col-md-4">Order By:</b> <?php echo $u->first_name . ' ' . $u->last_name; ?></p>
                                                            <p><b  class="col-md-4">Status</b><?php
                                                                if ($p->status == "Pending")
                                                                        echo '<b class="label label-warning">' . $p->status . '</b>';
                                                                elseif ($p->status == "Delivered")
                                                                        echo '<b class="label label-success">' . $p->status . '</b>';
                                                                ?></p>
                                                        </div>

                                                        <?php
                                                        if (isset($p->delivery_date) && !empty($p->delivery_date))
                                                        {
                                                                ?>
                                                                <div class="col-md-12">
                                                                    <hr>
                                                                    <h4 id="modal-responsive-label" class="modal-title">Delivery Details</h4>
                                                                    <hr>				  
                                                                    <p><b class="col-md-4">Delievery Date:</b> <?php echo date('d M Y', $p->delivery_date); ?></p>
                                                                    <p><b class="col-md-4">Person Responsible:</b> <?php echo $drivers[$p->person_responsible]; ?></p>

                                                                    <p><b class="col-md-4">Comment</b><?php echo $p->comment; ?></p>

                                                                </div>	
                                                        <?php } ?>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">


                                                <button type="button" data-dismiss="modal" class="btn btn-default">Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>




                        <?php endforeach ?>
                        </tbody>

                    </table>

                    <?php //echo $links;    ?>

            <?php else: ?>
                    <p class='text'><?php echo lang('web_no_elements'); ?></p>
            <?php endif ?>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">


    <!-- Vertical - start -->


    <div class="row">

        <div class="col-md-12">

            <!-- <div class="tabs-vertical-env"> -->
            <h4>Activities Streams</h4>

            <ul class="nav nav-tabs vertical col-lg-3 col-md-3 col-sm-4 col-xs-4 left-aligned primary">
                <li class="active">
                    <a href="#home-5" data-toggle="tab">
                        <i class="fa fa-folder-open-o"></i> Daily Observations

                    </a>
                </li>
                <li>
                    <a href="#profile-5" data-toggle="tab">
                        <i class="fa fa-list-ol"></i> <?php echo $post->first_name; ?>'s Orders 
                    </a>
                </li>
                <li>
                    <a href="#messages-5" data-toggle="tab">
                        <i class="fa fa-home"></i> <?php echo $post->first_name; ?>'s Outlets
                    </a>
                </li>
                <li>
                    <a href="#settings-5" data-toggle="tab">
                        <i class="fa fa-dashboard"></i> New Outlets Introduced 
                    </a>
                </li>
                <li>
                    <a href="#location-6" data-toggle="tab">
                        <i class="fa fa-globe"></i> Current Location 
                    </a>
                </li>
            </ul>					

            <div class="tab-content vertical col-lg-9 col-md-9 col-sm-8 col-xs-8 left-aligned primary">
                <div class="tab-pane fade in active" id="home-5">

                    <?php if ($daily_observations): ?>
                            <div class='clearfix'></div>

                            <table id="table_1" class="table table-hover table-bordered table-striped table-advanced">         	
                                <thead>
                                <th>#</th>
                                <th>Date</th>
                                <th>Outlet</th>
                                <th>Observation</th>
                                <th>Action Taken</th>
                                <th>Allowance</th>	

                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;


                                    foreach ($daily_observations as $p):
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i . '.'; ?></td>					
                                                <td><?php echo date('d M Y', $p->created_on); ?></td>
                                                <td><?php echo $retailers[$p->outlet]; ?></td>
                                                <td><?php echo $p->observation; ?></td>
                                                <td><?php echo $p->action_taken; ?></td>
                                                <td>Ksh.<?php echo number_format($p->allowance, 2); ?></td>

                                            </tr>
                                    <?php endforeach ?>
                                </tbody>

                            </table>

                            <?php //echo $links;  ?>
                    <?php else: ?>
                            <p class='text'><?php echo lang('web_no_elements'); ?></p>
                    <?php endif ?>
                </div>
                <!--------------TAB TWO ----------------------------->
                <div class="tab-pane fade" id="profile-5">

                    <table id="table_2" class="table table-hover table-bordered table-striped table-advanced">          	
                        <thead>
                        <th>#</th>
                        <th>Item</th>
                        <th>Size</th>
                        <th>Quantity</th>	
                        <th>Retailer</th>	
                        <th>Time Ago</th>	
                        <th>Status</th>	
                        <th ><?php echo lang('web_options'); ?></th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;

                            foreach ($recent_sales as $p):
                                    $u = $this->ion_auth->get_user($p->created_by);
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i . '.'; ?></td>					
                                        <td><?php echo $items[$p->product_item]; ?></td>

                                        <td><?php echo $p->size; ?></td>
                                        <td><?php echo $p->quantity . ' ' . $p->type; ?></td>

                                        <td><?php echo $retailers[$p->retailer]; ?></td>
                                        <td><?php echo time_ago($p->date); ?></td>

                                        <td><?php
                                            if ($p->status == "Pending")
                                                    echo '<b class="label label-warning">' . $p->status . '</b>';
                                            elseif ($p->status == "Delivered")
                                                    echo '<b class="label label-success">' . $p->status . '</b>';
                                            ?></td>
                                        <td width=''>

                                            <a role='menuitem' class="btn btn-sm btn-success" style='color:green' tabindex='-1' data-toggle="modal" href='#view_<?php echo $p->id; ?>'>
                                               <i class='fa fa-arrow-right'></i> View
                                            </a>

                                        </td>
                                    </tr>



                                    <!----- View Details--------------->
                                <div id="view_<?php echo $p->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-responsive-label" data-width="800" aria-hidden="true" class="modal fade">


                                    <div class="modal-dialog" style="width: 65%">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" data-dismiss="modal" aria-hidden="true"
                                                        class="close">&times;</button>
                                                <h4 id="modal-responsive-label" class="modal-title">Order Details</h4></div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        <div class="col-md-6">     
                                                            <p><b class="col-md-4">Order Date:</b> <?php echo date('d M y', $p->created_on); ?></p>
                                                            <p><b class="col-md-4">Item:</b> <?php echo $items[$p->product_item]; ?></p>
                                                            <p><b class="col-md-4">Category:</b> <?php echo $category[$p->product_category]; ?></p>
                                                            <p><b class="col-md-4">Size:</b> <?php echo $p->size; ?></p>
                                                            <p><b class="col-md-4">Quantity:</b> <?php echo $p->quantity; ?></p>

                                                        </div>
                                                        <div class="col-md-6"> 
                                                            <p><b class="col-md-4">Packages:</b> <?php echo $p->type; ?></p>
                                                            <p><b class="col-md-4">Retailer</b> <?php echo $retailers[$p->retailer]; ?></p>
                                                            <p><b class="col-md-4">Order By:</b> <?php echo $u->first_name . ' ' . $u->last_name; ?></p>
                                                            <p><b  class="col-md-4">Status</b><?php
                                                                if ($p->status == "Pending")
                                                                        echo '<b class="label label-warning">' . $p->status . '</b>';
                                                                elseif ($p->status == "Delivered")
                                                                        echo '<b class="label label-success">' . $p->status . '</b>';
                                                                ?></p>
                                                        </div>

                                                        <?php
                                                        if (isset($p->delivery_date) && !empty($p->delivery_date))
                                                        {
                                                                ?>
                                                                <div class="col-md-12">
                                                                    <hr>
                                                                    <h4 id="modal-responsive-label" class="modal-title">Delivery Details</h4>
                                                                    <hr>				  
                                                                    <p><b class="col-md-4">Delievery Date:</b> <?php echo date('d M Y', $p->delivery_date); ?></p>
                                                                    <p><b class="col-md-4">Person Responsible:</b> <?php echo $drivers[$p->person_responsible]; ?></p>

                                                                    <p><b class="col-md-4">Comment</b><?php echo $p->comment; ?></p>

                                                                </div>	
                                                        <?php } ?>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">


                                                <button type="button" data-dismiss="modal" class="btn btn-default">Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                        <?php endforeach ?>
                        </tbody>

                    </table>

                </div>
                <div class="tab-pane fade" id="messages-5">

                    <?php if ($outlets): ?>
                            <div class='clearfix'></div>

                            <table id="table_3" class="table table-hover table-bordered table-striped table-advanced">         	
                                <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Branch</th>
                                <th>Contact Person</th>
                                <th>Phone</th>
                                <th>Email</th>

                                <th>Status</th>

                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;

                                    foreach ($outlets as $p):
                                            $u = $this->ion_auth->get_user($p->user_id);
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i . '.'; ?></td>					
                                                <td><?php echo $p->name; ?></td>
                                                <td><?php echo $p->branch; ?></td>
                                                <td><?php echo $p->contact_person; ?></td>
                                                <td><?php echo $p->phone; ?></td>
                                                <td><?php echo $p->email; ?></td>

                                                <td><?php
                                                    if ($p->status == 'Confirmed')
                                                            echo '<i class="label label-success">Confirmed</i>';
                                                    else
                                                            echo '<i class="label label-warning">Pending</i>';
                                                    ?></td>

                                            </tr>
                                    <?php endforeach ?>
                                </tbody>

                            </table>

                    <?php else: ?>
                            <p class='text'><?php echo lang('web_no_elements'); ?></p>
                    <?php endif ?>

                </div>

                <div class="tab-pane fade" id="settings-5">

                    <?php if ($new_outlets): ?>
                            <div class='clearfix'></div>

                            <table id="table_4" class="table table-hover table-bordered table-striped table-advanced">         	
                                <thead>
                                <th>#</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Branch</th>
                                <th>Contact Person</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Status</th>

                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;

                                    foreach ($new_outlets as $p):
                                            $u = $this->ion_auth->get_user($p->user_id);
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i . '.'; ?></td>					
                                                <td><?php echo date('d/m/Y', $p->created_on); ?></td>
                                                <td><?php echo $p->name; ?></td>
                                                <td><?php echo $p->branch; ?></td>
                                                <td><?php echo $p->contact_person; ?></td>
                                                <td><?php echo $p->phone; ?></td>
                                                <td><?php echo $p->email; ?></td>

                                                <td><?php
                                                    if ($p->status == 'Confirmed')
                                                            echo '<i class="label label-success">Confirmed</i>';
                                                    else
                                                            echo '<i class="label label-warning">Pending</i>';
                                                    ?></td>

                                            </tr>
                                    <?php endforeach ?>
                                </tbody>

                            </table>

                    <?php else: ?>
                            <p class='text'><?php echo lang('web_no_elements'); ?></p>
                    <?php endif ?>


                </div>

                <div class="tab-pane fade" id="location-6">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.8239046299122!2d36.87543141425394!3d-1.2792460359781217!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f13f8128d56f7%3A0x64405d423a67f65e!2sMesora+Shopping+Centre!5e0!3m2!1sen!2ske!4v1452761676194" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>

                </div>


            </div>


            <!-- </div>	 -->

        </div>

    </div>
    <!-- Merchant targets	 -->						
    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default"> 
                <header class="panel_header">
                    <h2 class="title pull-left"><i class='fa fa-list'></i> <?php echo $post->first_name; ?>'s  Targets Summary</h2>

                </header>   

                <div class="panel-body" style="display: block;">   
                    <div class="widget-main">


                        <?php if ($targets): ?>
                                <div class='clearfix'></div>

                                <table id="" class="table table-hover table-bordered table-striped table-advanced">         	
                                    <thead>
                                    <th>#</th>
                                    <?php
                                    foreach ($targets as $p)
                                    {
                                            $tags = $this->portal_m->target_values($p->outlet);
                                            ?>	
                                            <th>Outlet</th>
                                            <?php
                                            foreach ($tags as $q)
                                            {
                                                    ?>
                                                    <th><?php echo $category[$q->category]; ?></th>
                                            <?php } ?>	
                                            <?php
                                            break;
                                    }
                                    ?>		
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $qnty = 0;
                                        foreach ($targets as $p):
                                                $i++;
                                                $tags = $this->portal_m->target_values($p->outlet);
                                                ?>
                                                <tr>
                                                    <td><?php echo $i . '.'; ?></td>

                                                    <td><?php echo $retailers[$p->outlet]; ?></td>

                                                    <?php
                                                    foreach ($tags as $q)
                                                    {
                                                            ?>
                                                            <td><?php
                                                                $qnty += $q->quantity;
                                                                echo $q->quantity;
                                                                ?></td>

                                                    <?php } ?>



                                                </tr>


                                        <?php endforeach ?>

                                    </tbody>

                                </table>
                                <div class=" pull-right">
                                    <h3>Total Target: <?php echo number_format($pp->target); ?></h3>
                                    <hr><hr>
                                </div>
                                <?php //echo $links;    ?>
                        <?php else: ?>
                                <p class='text'><?php echo lang('web_no_elements'); ?></p>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Vertical - end -->

</div>		 



