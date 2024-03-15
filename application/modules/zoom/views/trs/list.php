<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           Zoom Classes
        </h3>
        <div class="portlet-widgets">
            <?php echo anchor('trs/zoom/create', '<i class="mdi mdi-plus"></i> Add', 'class="btn btn-primary"'); ?>
        </div>
        <div class="clearfix"></div>
        <hr>
    </div>
    <div id="bg-default" class="panel-collapse collapse in">
        <div class="portlet-body">
            <?php if ($zoom): ?>
                <div class="table-responsive">
                     <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Link</th>
                                <th>Class</th>
                                <th ><?php echo lang('web_options');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   
                            $i=0;
                            foreach ($zoom as $p ): 
                                $i++;
                                $link= $p->link;
                                $new_link = explode ('/', $link);
                                $meeting_id= $new_link[4];

                                $new_link= str_replace("?","&","$meeting_id");
                                $email=$this->user->email;
                                $name=$this->user->first_name.' '.$this->user->last_name;
                                $prev="https://smartshulezoom.smartshule.com/zoom/index.php?name=$name&email=$email&meeting_id=";
                                $meeting_link= $prev.$new_link;

                                //  $users= explode(",",$p->user_group);
                                
                                $cc = '';
                                if (isset($this->classlist[$p->class])){
                                    $cro = $this->classlist[$p->class];
                                    $cc = isset($cro['name']) ? $cro['name'] : '';
                                }
                             ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo $p->title;?></td>
                                <td><a href="<?php echo $meeting_link?>" target="_blank"><?php echo $meeting_link;?></a></td>
                                <td><?php echo $cc;?></td>

                                <td width='30'>
                                        <div class='btn-group'>
                                            <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                            <ul class='dropdown-menu pull-right'>
                                                <li><a href='<?php echo base_url('trs/zoom/edit/'.$p->id);?>'><i class='fa fa-eye-open'></i> Edit</a></li>
                                                <li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo base_url('trs/zoom/delete/'.$p->id);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
                                            </ul>
                                        </div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                            
                        </tbody>
                    </table>
                </div>

            <?php else: ?>
                <p class='text'><?php echo lang('web_no_elements'); ?></p>
            <?php endif ?>
        </div>
    </div>
</div>

