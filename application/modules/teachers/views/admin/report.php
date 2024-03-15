<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Subjects Assigned </h2>
   <div class="right">
        <button class="btn btn-success" onClick="window.print()"><i class="glyphicon glyphicon-print"></i>Print</button>
    </div>
</div>

<div class="block-fluid">
    <?php echo form_open('admin/teachers/filter_alocation')?>
    <div class="row col-md-12">
        <table class="table">
            <th>
                <div class="form-group">
                    <label>Select Class</label>
                    <select class="select select-2" name="class">
                        <option>Select Class</option>
                        <?php
                        foreach($classes as $class){?>
                        <option value="<?php echo $class->class?>"><?php echo $this->streams[$class->class];?></option>
                        <?php }?>
                    </select>
                </div>
            </th>
            <th class="">
                <div class="form-group">
                    <label>Select Subject</label>
                    <select class="select select-2" name="subject">
                        <option>Select Subject</option>
                        <?php foreach($subjects as $s){?>
                            <option value="<?php echo $s->subject?>"><?php echo $s->name?> <?php echo $this->streams[$s->class];?></option>
                        <?php }?>
                    </select>
                   
                </div>
            </th>
            <th>
                <button class="btn btn-success">Filter Data</button>
            </th>
        </table>
        
       
    </div>
    <?php echo form_close()?>
  
   
    <div class="row col-md-12">
    <?php echo form_open('admin/teachers/filter_alocations')?>
        <table class="table">
            <th class="col-md-3">
                <div class="form-group">
                    <label>Select Class</label>
                    <select class="select select-2" name="class">
                        <option>Select Class</option>
                        <?php
                        foreach($classes as $class){?>
                        <option value="<?php echo $class->class?>"><?php echo $this->streams[$class->class];?></option>
                        <?php }?>
                    </select>
                </div>
            </th>
            <th class="col-md-3">
                <div class="form-group">
                    <label>Select Teacher</label>
                    <select class="select select-2" name="teacher">
                        <option>Select Teacher</option>
                        <?php foreach($teachers as $teacher){?>
                            <option value="<?php echo $teacher->teacher?>"><?php echo ucfirst($teacher->first_name. ' '.$teacher->last_name);?></option>
                        <?php }?>
                    </select>
                </div>
            </th>
            
            <!-- <th class="col-md-3">
               
            </th> -->
        </table>
        
        <?php echo form_close()?>
    </div>
   
  
    <table id="ModeTable" cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Class</th>
                <th>Term</th>
                <th>Year</th>
                <th>Teacher</th>
                <th>subject</th>	
            </tr>
        </thead>
        <tbody>
            <?php
            $index=1;
            foreach($reports as $value){
            ?>
            <tr>
                <td><?php echo $index;?></td>
                <td><?php echo $this->streams[$value->class];?></td>
                <td>Term <?php echo $value->term;?></td>
                <td><?php echo date("Y",$value->date_Add);?></td>
                <td><?php echo ucfirst($value->first_name. ' '.$value->last_name);?></td>
                <td><?php echo $value->name?></td>
            </tr>
            <?php $index++;  }?>
        </tbody>
        <tfoot></tfoot>
    </table>
            

</div>



