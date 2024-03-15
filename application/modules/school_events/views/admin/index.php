
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2> School Events</h2> 
        <div class="right">                            
            <?php echo anchor('admin/school_events/create/', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Event')), 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/school_events/calendar', '<i class="glyphicon glyphicon-list"> </i> Full Calendar', 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/school_events/list_view', '<i class="glyphicon glyphicon-list"> </i> List All', 'class="btn btn-primary"'); ?>
        </div>    					
    </div>
    <?php if ($school_events): ?>              
            <div class="block-fluid"> 
                

                        <?php
                        $i = 0;
                        if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                        {
                                $i = ($this->uri->segment(4) - 1) * $per;
                        }
                        foreach ($school_events as $p):
                                $i++;
                                ?>
                                <div class="col-md-12">
                                    <div class="date ">
                                        <?php
                                        $date = time();
                                        if ($p->start_date > $date):
                                                ?>
                                                <div class="caption right green"><span class="glyphicon glyphicon glyphicon-calendar"></span></div>
                                        <?php else: ?>  
                                                <div class="caption  red"><span class="glyphicon glyphicon glyphicon-calendar"></span></div>
                                        <?php endif; ?>  

                                        <span class="day"><?php echo date('d', $p->start_date); ?></span>
                                        <span class="month"><?php echo date('M, Y', $p->start_date); ?></span>
                                        <p style="text-align:center;font-size:1.2em; color:green">Start Date</p>
                                    </div>
                                    <div class="info">
                                        <a href="#"><b>Title:</b> <span style="margin-left:20px;"><?php echo $p->title; ?></span></a>
                                        <ul class="sList ui-sortable" id="sort_1">
                                            <li>
                                                <b>End Date:</b> <span style="margin-left:20px;margin-right:20px;"><?php echo date('d M Y', $p->end_date); ?></span>
                                                <b>Venue:</b> <span style="margin-left:20px; margin-right:20px;"><?php echo $p->venue; ?></span>
                                                <b>Guests:</b> <span style="margin-left:20px; margin-right:20px;"><?php echo $p->visibility; ?></span></li>
                                            <li><b>Description:</b>
                                                <br>
                                                <span style="margin-left:20px;"><?php echo substr($p->description, 0, 100) . '...'; ?></span>
                                            </li>

                                        </ul>   
                                        <div class="TAR">
                                            <a class="btn btn-small btn-default" href="<?php echo site_url('admin/school_events/view/' . $p->id . '/' . $page); ?>"><i class="glyphicon glyphicon-eye-open"></i> View Details</a>
                                            <a class="btn btn-small btn-default" href="<?php echo site_url('admin/school_events/edit/' . $p->id . '/' . $page); ?>"><i class="glyphicon glyphicon-edit"></i> Edit Details</a>
                                            <a class="btn btn-small btn-default" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/school_events/delete/' . $p->id . '/' . $page); ?>'><i class="glyphicon glyphicon-trash"></i> Trash</a>
                                        </div>                                
                                    </div>
                                </div>          
                        <?php endforeach ?>
                  
               
            <?php echo $links; ?>
         </div>
<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif; ?>