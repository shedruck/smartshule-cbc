<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Invoice Fee Extras </h2> 
    <div class="right">                            
        
    </div>    					
</div>

<div class="toolbar">
    <div class="col-md-12"><br/>
        <?php echo form_open(current_url()); ?>
        Fee
        <?php echo form_dropdown('fee', array('' => 'Fee Extras') + $extras, $this->input->post('fee'), 'class ="tsel" '); ?>
        Student
        <?php 
            $students = $this->ion_auth->students_full_details();
        ?>
        <select class="tsel" name="student" >
            <option value="">Select Student</option>
            <?php
            $data = $this->ion_auth->students_full_details();
            foreach ($data as $key => $value):
                    ?>
                    <option value="<?php echo $key; ?>"><?php echo $value ?></option>
            <?php endforeach; ?>
        </select>
        Class
        <?php echo form_dropdown('class', array('' => 'Select Class') + $this->streams, $this->input->post('class'), 'class ="tsel" '); ?>
        Term
        <?php echo form_dropdown('term', array('' => 'Select Term') + $this->terms, $this->input->post('term'), 'class ="fsel" required '); ?>
        Year 
        <?php echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), 'class ="fsel" required'); ?>
        <button class="btn btn-primary"  type="submit">Submit</button>
    <?php echo form_close(); ?>
    </div>
</div>

<div class="block invoice">
    <?php echo form_open(current_url())?>

    <?php echo form_close()?>

    <?php
        if($payload){ ?>
            <?php echo form_open(base_url('admin/fee_structure/save_invoice'))?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Adm No</th>
                        <th>Student</th>
                        <th>Class</th>
                        <td>Fee Extras</td>
                        <td>Amount</td>
                        <th ><input type="checkbox" class="checkall" /></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $index = 1;
                        foreach($payload as $p){
                            $std =  $this->worker->get_student($p->student);
                    ?>
                    <tr>
                        <td><?php echo $index ?></td>
                        <td><?php echo $std->admission_number ? $std->admission_number : $std->old_adm_no ?></td>
                        <td><?php echo strtoupper($std->first_name.' '.$std->middle_name. ' '.$std->last_name)?></td>
                        <td><?php echo isset($this->streams[$std->class]) ? $this->streams[$std->class] : '-'?></td>
                        <td><?php echo isset($extras[$p->fee_id]) ? $extras[$p->fee_id] : '-' ?>
                            <input type="hidden" name="description[<?php echo $p->student?>][]" value="<?php echo $p->description?>">
                            <input type="hidden" name="feee[<?php echo $p->student?>][]" value="<?php echo $p->fee_id?>">
                        </td>
                        <td><input type="number" name="amount[<?php echo $p->student?>][]" class="form-control" value="<?php echo $p->amount?>"></td>
                        <td><input type="checkbox" name="sids[]" value="<?php echo $p->student?>" class="switchx check-lef"> </td>
                    </tr>
                    <?php $index++; }?>
                </tbody>
            </table>
             Term
        <?php echo form_dropdown('termx', array('' => 'Select Term') + $this->terms, $this->input->post('termx'), 'class ="fsel" '); ?>
        Year 
        <?php echo form_dropdown('yearx', array('' => 'Select Year') + $yrs, $this->input->post('yearx'), 'class ="fsel" '); ?>
        <button class="btn btn-primary"  type="submit">Submit</button>
            <?php echo form_close()?>
     <?php }else {?>

     <div class="alert alert-info">Please select Term, year, class, item (Select Previous Term)</div>

 <?php }?>
</div>

<script>
        $(document).ready(
                function ()
                {
                    $(".tsel").select2({'placeholder': 'Please Select', 'width': '140px'});
                    $(".tsel").on("change", function (e) {

                        notify('Select', 'Value changed: ' + e.added.text);
                    });

                    $(".fsel").select2({'placeholder': 'Please Select', 'width': '100px'});
                    $(".fsel").on("change", function (e) {

                        notify('Select', 'Value changed: ' + e.added.text);
                    });
                });
</script>

 