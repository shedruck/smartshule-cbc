<div class="col-md-8">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>Grading</h2> 
        <div class="right">                            
            <?php echo anchor('admin/grading/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Grading')), 'class="btn btn-primary"'); ?>
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
            <div class="col-md-2" for='grading_system'>Grading System </div>
            <div class="col-md-10">
                <?php
                echo form_dropdown('grading_system', $grading, (isset($result->grading_system)) ? $result->grading_system : '', ' class="chzn-select" data-placeholder="Select Options..." ');
                echo form_error('grading_system');
                ?>
            </div>
        </div>
        <div class="head dark">
        </div>                
        <div class="block-fluid">
            <table cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="3%">
                            #
                        </th>
                        <th width="10%">
                            Grade
                        </th>
                        <th width="10%">
                            Minimum Marks
                        </th>
                        <th width="10%">
                            Maximum Marks
                        </th>
                        <th width="10%">
                            Remarks
                        </th>
                    </tr>
                </thead>
            </table>
            <div id="entry1" class="clonedInput">
                <table cellpadding="0" cellspacing="0" width="100%">  
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($list_grades as $post):
                                ?>  
                                <tr>
                                    <td width="3%">
                                        <span id="reference" name="reference" class="heading-reference"><?php echo $i; ?>	</span>
                                    </td>
                                    <td style="display:none">
                                        <input type="text" name="grade[]" id="grade" value=" <?php echo $post->id; ?>" class="grade">
                                        <?php echo form_error('grade[]'); ?>
                                    </td>
                                    <td width="10%">
                                        <?php echo $post->title; ?>
                                    </td>
                                    <td width="10%">
                                        <input type="text" name="minimum_marks[]" id="minimum_marks" class="minimum_marks" placeholder="E.g 60" >
                                        <?php echo form_error('minimum_marks[]'); ?>
                                    </td>
                                    <td width="10%">
                                        <input type="text" name="maximum_marks[]" id="maximum_marks" class="maximum_marks" placeholder="E.g 75">
                                        <?php echo form_error('maximum_marks[]'); ?>
                                    </td>
                                    <td width="10%">
                                        <?php echo $post->remarks; ?>
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
        <div class='form-group'><div class="control-div"></div>
            <div class="col-md-10">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/grading', 'Cancel', 'class="btn btn-danger"'); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-md-4">

    <div class="widget">
        <div class="head dark">
            <div class="icon"></div>
            <h2>Add Grading System</h2>
        </div>

        <div class="block-fluid">
            <?php echo form_open('admin/grading_system/quick_add', 'class=""'); ?>
            <div class="form-group">
                <div class="col-md-3">Name:<span class='required'>*</span></div>
                <div class="col-md-9">                                      
                    <?php echo form_input('title', '', 'id="title_1"  placeholder=" E.g KNEC"'); ?>
                    <?php echo form_error('title'); ?>
                </div>
            </div>
            <div class='form-group'>
                <div class='col-md-3' for='title'>Pass Mark <span class='required'>*</span></div>
                <div class="col-md-5">
                    <?php echo form_input('pass_mark', '', 'id="pass_mark" placeholder="E.g 250" class="form-control" '); ?>
                    <?php echo form_error('pass_mark'); ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">Description:</div>
                <div class="col-md-9">
                    <textarea name="description"></textarea> 
                </div>
            </div>                        

            <div class="toolbar TAR">
                <button class="btn btn-primary">Add</button>
            </div>
            <?php echo form_close(); ?> 
        </div>
    </div>
    <div class="widget">
        <div class="head dark">
            <div class="icon"></div>
            <h2>Add Grades</h2>
        </div>

        <div class="block-fluid">
            <?php echo form_open('admin/grades/quick_add', 'class=""'); ?>
            <div class="form-group">
                <div class="col-md-3">Title:<span class='required'>*</span></div>
                <div class="col-md-9">                                      
                    <?php echo form_input('title', '', 'id="title_1"  placeholder=" E.g Distinction"'); ?>
                    <?php echo form_error('title'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-3">Remarks:<span class='required'>*</span></div>
                <div class="col-md-9">                                      
                    <?php echo form_input('remarks', '', 'id="remarks"  placeholder=" e.g Very Good"'); ?>
                    <?php echo form_error('remarks'); ?>
                </div>
            </div>


            <div class="toolbar TAR">
                <button class="btn btn-primary">Add</button>
                <a href="<?php echo base_url('admin/grades'); ?>" class="btn btn-primary"> Manage Grades</a>
            </div>
            <?php echo form_close(); ?> 
        </div>
    </div>


</div>

