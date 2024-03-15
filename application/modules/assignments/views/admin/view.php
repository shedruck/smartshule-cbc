


<div class="col-md-4">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span> </div>
        <h2>  Assignment Details  </h2>
        <div class="right">  
            <?php echo anchor('admin/assignments/edit/' . $p->id, '<i class="glyphicon glyphicon-edit"></i> Edit Details', 'class="btn btn-primary"'); ?> 
        </div>
    </div>

    <div class="block-fluid">

        <div class="col-md-12">

            <div class="timeline">

                <div class="event">

                    <div class="icon"><span class="icos-comments3"></span></div>
                    <div class="body">
                        <div class="arrow"></div>
                        <div class="user"><a href="#">  Title</a> </div>
                        <div class="text"><?php echo $p->title; ?></div>
                    </div>
                </div>    
                <div class="event">
                    <div class="icon"><span class="icos-calendar"></span></div>
                    <div class="body">
                        <div class="arrow"></div>
                        <div class="user"><a href="#"> Date From</a> </div>
                        <div class="text"><?php echo date('d M Y', $p->start_date); ?></div>
                    </div>
                </div>  
                <div class="event">
                    <div class="icon"><span class="icos-calendar"></span></div>
                    <div class="body">
                        <div class="arrow"></div>
                        <div class="user"><a href="#"> Date To</a> </div>
                        <div class="text"><?php echo date('d M Y', $p->end_date); ?></div>
                    </div>
                </div>
                <div class="event">
                    <div class="icon"><span class="icos-download"></span></div>
                    <div class="body">
                        <div class="arrow"></div>
                        <div class="user"><a href="#"> Attachment</a> </div>
                        <div class="text">
                            <?php if (!empty($p->document))
                            {
                                    ?>
                                    <a href="<?php echo base_url('uploads/files/' . $p->document); ?>"><i class="glyphicon glyphicon-download"></i> Download Attachment</a>
                            <?php
                            }
                            else
                            {
                                    ?>
                                    <b >No Attachment</b>
<?php } ?>

                        </div>
                    </div>
                </div>  
                <div class="event">
                    <div class="icon"><span class="icos-power"></span></div>
                    <div class="body">
                        <div class="arrow"></div>
                        <div class="user"><a href="#"> Assignment To</a> </div>
                        <div class="text">
                            <?php
                            $class_id = $this->assignments_m->get_classes($p->id);
                            $class = $this->ion_auth->classes_and_stream();
                            $i = 0;
                            foreach ($class_id as $c)
                            {
                                    $i++;
                                    echo $i . '. ' . $class[$c->class] . '<br>';
                            }
                            ?>
                        </div>
                    </div>
                </div>  




                <div class="event">

                    <div class="icon"><span class="icos-clipboard1"></span></div>
                    <div class="body">
                        <div class="arrow"></div>
                        <div class="user"><a href="#"> Comment</a></div>

                        <div class="text"><?php echo $p->comment; ?></div>

                    </div>
                </div> 
                <div class="event">                        
                    <div class="icon"><span class="icos-locked"></span></div>
                    <div class="body">
                        <div class="arrow"></div>
                        <div class="head">
                            <a href="#">Created By: </a> <?php $u = $this->ion_auth->get_user($p->created_by);
                            echo $u->first_name . ' ' . $u->last_name;
                            ?> 
                            <a href="#">Created on: </a> <?php echo date('d M Y', $p->created_on); ?></div>                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-8">

    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span> </div>
        <h2>  Assignment  </h2>
        <div class="right">  
<?php echo anchor('admin/assignments/create/', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Assignment')), 'class="btn btn-primary"'); ?>

<?php echo anchor('admin/assignments', '<i class="glyphicon glyphicon-list"></i> List View', 'class="btn btn-primary"'); ?> 

        </div>
    </div>



    <div class="block-fluid" style="padding:20px !important;">

<?php echo $p->assignment; ?>


    </div>

</div>