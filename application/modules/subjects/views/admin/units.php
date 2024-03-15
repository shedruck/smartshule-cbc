<div class="col-md-12">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>  Assign Sub Units For <?php echo $sub->name; ?> </h2> 
        <div class="right">                            
             <?php echo anchor('admin/subjects/', '<i class="glyphicon glyphicon-list">  </i> All Subjects', 'class="btn btn-primary"'); ?>
        </div>    					
    </div>
    <div class="block-fluid">
        <!------NEW WIDGET------>
        <div class="widget col-md-12">

            <div class="block-fluid">
                 <?php echo form_open('admin/subjects/quick_add/' . $id, 'class=""'); ?>
                <div class="form-group">
                    <div class="col-md-1">Name:</div>
                    <div class="col-md-6">                                      
                         <?php echo form_input('name', '', 'id="name" placeholder="Unit Title" '); ?>
                         <?php echo form_error('name'); ?>
                    </div>
                    <div class="col-md-2">                                      
                         <?php echo form_input('out_of', '', 'id="out_of" placeholder="Marks Out of" '); ?>
                         <?php echo form_error('out_of'); ?>
                    </div>
                    <div class="col-md-3"> <button class="btn btn-primary">Add Sub Unit</button></div>
                </div>

                <?php echo form_close(); ?> 
            </div>
        </div>

        <div class="clearfix"></div>
        <!------END WIDGET------>

        <div class="head">
            <div class="icon"><span class="icosg-target1"></span></div>
            <h2>  Sub unit  Details</h2> 
        </div>
        <?php
            $attributes = array('class' => 'form-horizontal', 'id' => '');
            echo form_open_multipart(current_url(), $attributes);
        ?>
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <div id="entry1" class="clonedInput">
                <table cellpadding="0" cellspacing="0" width="100%">  
                    <thead>
                        <tr role="row">
                            <th width="3%">#</th>
                            <th>Title</th>
                            <th>Out Of</th>
                            <th width="30%">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php
                             $i = 0;
                             foreach ($sub->subs as $uid => $unit):
                                  $p = (object) $unit;
                                  $i++;
                                  ?>
                                 <tr>
                                     <td><?php echo $i . '.'; ?></td>
                                     <td><?php echo $p->title; ?></td>
                                     <td><?php echo $p->out_of; ?></td>
                                     <td width='20%'>
                                         <a class="btn btn-primary" href='<?php echo site_url('admin/subjects/edit_unit/' . $uid); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a> 
                                         <a class="btn btn-danger" href='<?php echo site_url('admin/subjects/rem_unit/' . $id . '/' . $uid); ?>' onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')"><i class='glyphicon glyphicon-trash'></i> Remove</a> 
                                     </td>
                                 </tr>
                            <?php endforeach ?>
                    </tbody>
                </table>
            </div>

        </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>

