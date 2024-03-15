<div class="col-md-12">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>Manage Grading</h2> 
        <div class="right">                            
            <?php echo anchor('admin/grading/create/', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Grading')), 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/grading/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>

        </div>    					
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'> 
            <div class="head dark">
                <div class=""><h4 class="white">Grading System : <?php echo $sys[$dat->grading_system]; ?></h4></div>           
            </div>       
            <div class="block-fluid">
                <table class="table-hover fpTable"  cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="10%">
                                #
                            </th>
                            <th width="20%">
                                Grade
                            </th>
                            <th width="15%">
                                Minimum Marks
                            </th>
                            <th width="15%">
                                Maximum Marks
                            </th>
                            <th width="20%">
                                Remarks
                            </th>
                            <th width="20%">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($post as $p):
                                $g = $this->grading_m->grades_details($p->grade);
                                ?>  
                                <tr>
                                    <td width="3%">
                                        <span id="reference" name="reference" class="heading-reference"><?php echo $i; ?>	</span>
                                    </td>
                                    <td class="center" style="">
                                        <?php echo $g->title; ?>
                                    </td>
                                    <td   class="center">
                                        <?php echo $p->minimum_marks; ?>
                                    </td>
                                    <td  class="center">
                                        <?php echo $p->maximum_marks; ?>
                                    </td>
                                    <td class="center" width="">
                                        <?php echo $g->remarks; ?>
                                    </td>
                                    <td class="TAC ">
                                        <a class="btn btn-info" href='<?php echo site_url('admin/grades/edit_grading/' . $p->id.'/'.$grading_id); ?>'><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                        <!--a class="btn btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/grades/delete/' . $grading_id . '/' . $p->grade); ?>'><i class="glyphicon glyphicon-trash"></i> Move to Trash</a-->
                                    </td>
                                </tr> 
                                <?php
                                $i++;
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>           
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>