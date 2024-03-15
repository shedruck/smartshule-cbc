<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Transport Edit  </h2>
    <div class="right">  
      

    </div>
</div>
   <div class="block-fluid">
       <?php echo form_open(current_url()) ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Adm No</th>
                        <th>Student</th>
                        <th>Class</th>
                        <td>Transport Zone</td>
                        <td>Amount</td>
                        <th ><input type="checkbox" class="checkall" /></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $index = 1;
                        foreach($items as $p){
                            $st =  $this->worker->get_student($p->student);
                            if(!empty($st->id)){
                    ?>
                    <tr>
                        <td><?php echo $index; ?></td>
                        <td><?php echo $st->admission_number?></td>
                        <td><?php echo ucfirst($st->first_name.' '. $st->middle_name. ' '. $st->last_name)?></td>
                        <td><?php echo isset($this->streams[$st->class]) ? $this->streams[$st->class] : ''?></td>
                        <td><?php echo isset($extras[$p->fee_id]) ? $extras[$p->fee_id] : ''?></td>
                        <td><input type="number" name="amount[]" value="<?php echo $p->amount?>"></td>
                        <td><input type="checkbox" name="items[]" value="<?php echo $p->id?>" class="switchx check-lef"> </td>
                    </tr>
                <?php $index++;   } }?>

                </tbody>

            </table>
             <button class="btn btn-primary pull-right" type="submit">Submit</button>

       <?php echo form_close(); ?>
   </div>
 