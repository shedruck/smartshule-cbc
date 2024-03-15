<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Teaching Staff </h2>
   
</div>

<div class="block-fluid">
    <h4>
        <?php  foreach($teacher as $t){
             if($t->status =="1"){
                $status= "Active Teachers";
            }else{
                $status= "Inactive Teachers";
            }
        }
        echo $status ;
       ?>
    </h4>
    <button onClick='window.history.back();' class="btn btn-sm btn-danger">Back</button>
 
    <table id="ModeTable" cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>	
                <th>Status</th>	
                <th>Designation</th>	
                <th width="20%"><?php echo lang('web_options'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $index=1;
            foreach($teacher as $t){
                $name= ucfirst($t->first_name).' '.ucfirst($t->last_name);
                if($t->status =="1"){
                    $status= "<span class='btn btn-sm btn-success'>Active</span>";
                }else{
                    $status= "<span class='btn btn-sm btn-danger'>Inactive</span>";
                }
                ?>
            <tr>
                <td><?php echo $index?></td>
                <td><?php echo $name?></td>
                <td><?php echo $t->phone?></td>
                <td><?php echo $t->email?></td>
                <td><?php echo $status?></td>
                <td><?php echo $t->designation?></td>
                <td>
                    <a class="btn btn-sm btn-success" href="<?php  echo base_url('admin/teachers/profile/'.$t->id)?>">Profile</a>
                    <a class="btn btn-sm btn-primary" href="<?php  echo base_url('admin/teachers/edit/'.$t->id)?>">Edit</a>
                </td>
            </tr>
            <?php $index++; }?>
        </tbody>
        <tfoot></tfoot>
    </table>
            

</div>


