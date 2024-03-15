<div class="col-md-12">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Fee Arrears  </h2>
        <div class="right"> 

        </div>
    </div>

    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>

        <div class='form-group'>
            <div class="col-md-3" for='reg_no'>Student Registration Number <span class='required'>*</span></div><div class="col-md-6">
                <?php
                $data = $this->ion_auth->students_full_details();
                echo form_dropdown('student', array('' => 'Select Student') + $data, $this->input->post('student'), ' class="select"');
                echo form_error('student');
                ?>
            </div>
        </div>

        <!-- BEGIN TABLE DATA -->
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <table cellpadding="0" cellspacing="0" width="100%">
                <!-- BEGIN -->
                <thead>
                    <tr role="row">
                        <th width="3%">#</th>
                        <th width="10%">Amount</th>
                        <th width="10%">Term</th>
                        <th width="15%">Year</th>

                    </tr>
                </thead>
            </table>

            <div id="entry1" class="clonedInput">

                <table cellpadding="0" cellspacing="0" width="100%">  
                    <tbody>
                        <tr >
                            <td width="3%">
                                <span id="reference" name="reference" class="heading-reference">1</span>
                            </td>
                            <td width="10%">
                                <input type="text" name="amount" id="amount" class="amount" value="<?php
                                echo $this->input->post('amount');
                                ?>">
                                       <?php echo form_error('amount'); ?>
                            </td>
                            <td width="15%">
                                <?php
                                echo form_dropdown('term', array('' => 'Select Term') + $this->terms, $this->input->post('term'), ' class="term" id="rn" data-placeholder="Select Options..." ');
                                echo form_error('term');
                                ?>
                            </td>
                            <td width="10%">
                                <input type="text" name="year" id="sdfs" class="dgd" value="<?php
                                echo $this->input->post('year');
                                ?>">
                                       <?php echo form_error('year'); ?>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
 
        </div>

        <div class='form-group'><div class="col-md-2"></div><div class="col-md-10">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div> 