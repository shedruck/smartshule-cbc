<?php
$settings = $this->ion_auth->settings();
$refNo = refNo();
?>
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
	
	  <?php
                $cc = '';
                if (isset($this->classlist[$dat->class_id]))
                {
                        $cro = $this->classlist[$dat->class_id];
                        $cc = isset($cro['name']) ? $cro['name'] : '';
                }
                ?>
				
    <h2> Class Attendance -  Class: <?php echo $cc; ?> </h2> 
    <div class="right">                            
        <?php echo anchor('admin/class_attendance/send_sms/1/' . $att_id, '<i class="glyphicon glyphicon-comment"></i> SMS Absent Only', 'class="btn btn-danger"'); ?>
		
        <?php echo anchor('admin/class_attendance/send_sms/2/' . $att_id, '<i class="glyphicon glyphicon-envelope"></i> SMS All Students', 'class="btn btn-success"'); ?>
		
		 <?php echo anchor('admin/class_attendance/list_attendance/' . $dat->class_id, '<i class="glyphicon glyphicon-list"></i> List All Class Attendance', 'class="btn btn-primary"'); ?>
    </div>    					
</div>

 <div class="block-fluid">
<?php if ($post): ?>  
        <div class="widget">
            
			<?php
			$i = 0;
			foreach ($post as $p):
					$i++;
					$classes = $this->ion_auth->list_classes();
					$u = $this->ion_auth->list_student($p->student);
					?>
                           <div class="quote <?php if ($p->status == 'Absent') echo 'changed';?>  ">Dear parent/guardian, your child <?php echo ucwords($u->first_name . ' ' . $u->last_name); ?> was  <?php echo strtolower($p->status); ?> for  <?php echo strtolower($dat->title); ?> roll call on  <?php echo date('d M Y', $dat->attendance_date); ?>. Thank you</div>
        <?php endforeach ?>        
                
            </div>
      
<?php else: ?>
 <p class='text'><?php echo lang('web_no_elements'); ?></p>
 <?php endif ?>
 
 </div>
 
 <style>
    .fless{width:100%; border:0;}
    .quote:before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        border-width: 0 3px 3px 0;
        border-style: solid;
        border-color: #658E15 #FFF;
        box-shadow: -3px 3px 5px rgba(0, 0, 0, 0.15);
        -webkit-transition: border-width 500ms ease, box-shadow 500ms ease; 
        transition: border-width 500ms ease, box-shadow 500ms ease;
    }

    .quote:hover:before {
        border-width: 0 3rem 3rem 0;
        box-shadow: -6px 6px 5px rgba(0, 0, 0, 0.15);
        -webkit-transition: border-width 500ms ease, box-shadow 500ms ease; 
        transition: border-width 500ms ease, box-shadow 500ms ease;
    }

    .quote {
        position: relative;
        width: 93%;
        padding: 1rem 1.6rem;
        margin: 2rem auto;
        font: italic 21px/1.4 Opensans, serif;
        color: #fff;
        background: #449D44;
        border-radius: 1rem;
    }
	.changed{
       
        font: italic 21px/1.4 Opensans, serif;
        color: #fff;
        background: #EC0A28 !important;
    
    }

    .quote:after {
        content: "";
        position: absolute;
        top: 100%;
        right: 25px;
        border-width: 10px 10px 0 0;
        border-style: solid;
        border-color: #449D44 transparent;
    }

	.changed:after {
        content: "";
        position: absolute;
        top: 100%;
        right: 25px;
        border-width: 10px 10px 0 0;
        border-style: solid;
        border-color: #EC0A28 transparent;
    }
	
</style>