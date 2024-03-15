<div class="divider"><div><span></span></div></div>
 <div class="col-md-6">
     <?php
    $message = $this->session->flashdata('message');
    if($message)
    {
    	if ( is_array($message['text']))
    	{
	        echo "<div class='alert alert-".$message['type']."'>";

                echo "<ul>";
                foreach ($message['text'] as $msg) {
                    echo "<li><span>".$msg."</span></li>";
                }
                echo "<ul>";
	        echo "</div>";
	    }
    	else
    	{
	        echo "<div class='alert alert-".$message['type']." '>";
             echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                        echo "<strong>".ucwords($message['type'])."! </strong>  ".$message['text'] ;
	            
	        echo "</div>";
	    }
    }
?>
 <div class="widget"> 
  
             <div class="widget-block" id="w_sort01">
           <div class="wTitle">  <div class="wIcon">
                      <?php echo theme_image('icons/14x14/dice1.png');?> 
                    </div>   <h5>Users </h5>
                            </div>
                <div class="widget-content">
                                 

              <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
		
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered " id="editable" aria-describedby="editable_info" style="">
           
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Group</th>
                        <th>Status</th>
                    </tr>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['first_name'] ?></td>
                            <td><?php echo $user['last_name'] ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['group_description']; ?></td>
                            <td><?php echo ($user['active']) ? anchor("admin/users/deactivate/" . $user['id'], 'Active') : anchor("admin/users/activate/" . $user['id'], 'Inactive'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                </div>

                <div class="clearfix"></div>
                </div>
                <div class="widget-bottom ">
                  <a class="btn btn-blue"   href="<?php echo site_url('admin/users/create_user'); ?>">Create New user</a></div>
              
            </div>
             
    </div>
    </div>
