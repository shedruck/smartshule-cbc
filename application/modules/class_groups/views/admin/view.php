
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>View Class</h2> 
    <div class="right">
	   <button onClick="window.print();
                      return false" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print Class List</button>
        <a href="<?php echo base_url('admin/class_groups/classes'); ?>" class="btn btn-info"><i class="glyphicon glyphicon-list">
            </i> List All</a>    
    </div>    					
</div>
<div class="block slip">

 <div class="row-fluid center">
        <div class="col-sm-12">
            <span class="" style="text-align:center">
                <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  width="100" height="100" />
            </span>
            <h3>
                <span style="text-align:center !important;font-size:15px;"><?php echo strtoupper($this->school->school); ?></span>
            </h3>
            <small style="text-align:center !important;font-size:12px; line-height:2px;">
                <?php
                if (!empty($this->school->tel))
                {
                    echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                }
                else
                {
                    echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                }
                ?>
            </small>
            <h3>
                <span style="text-align:center !important;font-size:13px; font-weight:700; border:double; padding:5px;">MOTTO: <?php echo strtoupper($this->school->motto); ?></span>
            </h3>
            <br>
            <small style="text-align:center !important;font-size:20px; line-height:2px; border-bottom:2px solid  #ccc;">Students Class List as at <?php echo date('jS M Y'); ?></small>
            <br>
            <br>
            <br>
        </div>
    </div>
    <hr>
	<div class="row">
	<div class="col-sm-12">
	
    <h3>LEVEL: <?php
        $cc = isset($classes[$class->class]) ? $classes[$class->class] : ' -';
        $ss = isset($streams[$class->stream]) ? $streams[$class->stream] : ' -';
        echo $cc . ' ' . $ss;
        ?></h3>
   
     <h4>Number of Registered Students <span style="color:red"><?php echo count($post); ?></span>
	 <span class="right">
	 Class Teacher : 
	 <?php
	 $u = $this->ion_auth->get_user($class->class_teacher);
			$tr = ' ';
			if($class->class_teacher>0){
				
				$tr = $u->first_name.' '.$u->last_name;
			}
			echo '<span style="color:red">'.$tr.'</span>';
			?></span>
	 </h4>

    <table cellpadding="0" cellspacing="0" width="100%" border="1">
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="30%">Name</th>
                <th width="20%">ADM No.</th>
                <th width="10%">Gender</th>
                <th width="15%">Admission Date</th>
                <th width="15%">Parent</th>
                <th width="15%">Phone</th>
               
                <th width="5%" class="option">Options</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $gender = array(1 => 'Male', 0 => 'Female',2 => 'Female');
            $i = 0;
			
            foreach ($post as $s)
            {
				$pp = $this->portal_m->get_parent($s->parent_id);
                $i++;
                ?>

                <tr>
                    <td><?php echo $i . '. '; ?></td>
                    <td><?php echo $s->first_name . ' ' . $s->last_name; ?></td>
                    <td><?php
                        if (!empty($s->old_adm_no))
                        {
                            echo $s->old_adm_no;
                        }
                        else
                        {
                            echo $s->admission_number;
                        }
                        ?></td>
                    <td>
						 <?php
                        if ($s->gender == 1)
                                echo 'Male';
                        elseif($s->gender == 2)
                                echo 'Female';
						else echo $s->gender;
                        ?>
					</td>
                    <td><?php if(is_numeric($s->admission_date)) echo $s->admission_date > 0 ? date('d M Y', $s->admission_date) : ' '; 
echo ' - '.$s->boarding_day ; echo '-'.$s->gender ; ?></td>
                    <td>
					<?php echo $pp->first_name; ?> <?php echo $pp->last_name; ?><hr> 
					<?php echo $pp->mother_fname; ?> <?php echo $pp->mother_lname; ?>
					</td>
                    <td><?php echo $pp->phone; ?> <hr><?php echo $pp->mother_phone; ?></td>
                    <td class="option">
                        <div class="btn-group">
                            <a class='btn btn-success'  href="<?php echo site_url('admin/admission/view/' . $s->id); ?>"><i class="glyphicon glyphicon-edit"></i> View Profile</a>
                        </div>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3">

        </div>
    </div>

</div>
</div>
</div>

<style>
    @media print{

         .buttons-hide{
              display:none !important;
         }

		 .option{
              display:none !important;
         }
         .col-md-4 {
              width: 200px !important;
              float: left !important;
              margin:0px !important; 
         }
		 
		  table tr{
			  border:1px solid #666 !important;
		  }
		  table th{
			  border:1px solid #666 !important;
			   padding:5px;
		  }
 table td{
			  border:1px solid #666 !important;
			   padding:5px;
		  }

         .col-md-4 {
              width: 200px !important;
              float: left !important;
         }
         .right{
              float:right;

         }
         .bold{
              font-weight:bold;
              font-size:1.5em;
              color:#000;
         }
         .kes{
              color:#000;
              font-weight:bold;
         }
         .item{
              padding:3px;
         }
         .col-md-3 {
              width: 200px !important;
              float: left !important;
         }
         .col-md-6 {
              width: 300px !important;
              float: left !important;
         }
         .col-md-2 {
              width: 150px !important;
              float: left !important;
         }

         .navigation{
              display:none;
         }
         .alert{
              display:none;
         }
         .alert-success{
              display:none;
         }

         .img{
              align:center !important;
         } 
         .print{
              display:none !important;
         }
         .bank{
              float:right;
         }
         .view-title h1{border:none !important; text-align:center }
         .view-title h3{border:none !important; }

         .split{

              float:left;
         }
         .header{display:none}
         .invoice { 
              width:100%;
              margin: auto !important;
              padding: 0px !important;
         }
         .invoice table{padding-left: 0; margin-left: 0; }

         .smf .content {
              margin-left: 0px;
         }
         .content {
              margin-left: 0px;
              padding: 0px;
         }
    }
</style>    