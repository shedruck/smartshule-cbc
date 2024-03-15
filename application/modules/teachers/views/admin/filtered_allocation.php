<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Subjects Assigned </h2>
   <div class="right">
        <button class="btn btn-success" onClick="window.print()"><i class="glyphicon glyphicon-print"></i>Print</button>
    </div>
</div>

<div class="block-fluid">
   <button class="btn btn-danger" onClick="history.back()">Back</button>
  
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
                <td><?php echo $index;?>
                <td><?php echo $this->streams[$value->class];?>
                <td>Term <?php echo $value->term;?>
                <td><?php echo date("Y",$value->date_Add);?>
                <td><?php echo ucfirst($value->first_name. ' '.$value->last_name);?>
                <td><?php echo $value->name?>
            </tr>
            <?php $index++;  }?>
        </tbody>
        <tfoot></tfoot>
    </table>
            

</div>



