

<div class="col-md-6">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2> Student Details </h2> 

    </div>



    <div class="profile clearfix">

        <div class="text-center ">

            <div  <?php if (empty($post->action_taken)) echo 'class="left"'; ?>>
                <div class="image text-center" >
						<?php
						$user=$this->ion_auth->list_student($post->culprit);
						$passport = $this->ion_auth->passport($user->photo);
						if(!empty($user->photo)):?>	
						<image src="<?php echo base_url('uploads/'.$passport->fpath.'/'.$passport->filename);?>" width="100" height="100" class="img-polaroid" style="align:left">

						 <?php else:?>   
						   <?php echo theme_image("thumb.png", array('class'=>"img-polaroid",'style'=>"width:100px; height:100px; align:left"));?>
											 
						 <?php endif;?>      
                    </div>  
				<div class="col-md-12">
                <h2 ><?php
                    $class = $this->ion_auth->list_classes();
                    $user = $this->ion_auth->list_student($post->culprit);
                    echo $user->first_name . ' ' . $user->last_name;
                    ?></h2>
                <p><strong>ADM No.: </strong> <?php echo $user->admission_number; ?></p>
                <p><strong>ADM Date.:</strong> <?php echo date('d M Y', $user->admission_date); ?></p>
                <p><strong>Gender: </strong> <?php if ($user->gender == 1) echo 'Male';
                    else echo 'Female'; ?></p>
                <p><strong>Email: </strong> <?php echo $user->email; ?></p>
                <p><strong>Class: </strong> <?php echo $class[$user->class]; ?></p>
                <br>
                <div class="item">
                    <div class="title"><strong>Date Reported</strong></div>
                    <div class="descr"><?php echo date('d M Y', $post->date_reported); ?></div>
                </div>
                <div class="item clearfix" style="width:450px">
                    <strong>Reason :</strong><br> <?php echo $post->description; ?>                               
                </div>
                <div class="item">
                    <strong>Reported By</strong>
                    <div class="descr">
                        <?php
                        $user = $this->ion_auth->get_user($post->created_by);

                        if ($post->reported_by == '')
                        {
                                echo $post->others;
                        }
                        else
                        {
                                echo $user->first_name . ' ' . $user->last_name;
                        }
                        ?>

                    </div>
                </div>

                <div class="item">
                    <strong>Created By</strong>
                    <div class="descr"><?php $user = $this->ion_auth->get_user($post->created_by);
                        echo $user->first_name . ' ' . $user->last_name; ?></div>
                </div>
            </div>


            <?php if (!empty($post->action_taken)): ?>

                    <div class="status" style="width:300px">ACTION TAKEN : <?php echo strtoupper($post->action_taken); ?></div>
<?php else: ?>
                    <div style="width:300px" class="status">NO ACTION HAS BEEN TAKEN</div>
        <?php endif; ?>

        </div>
<?php if (!empty($post->action_taken)): ?>
                <div class="stats">

                    <div class="item">
                        <strong>Comment :</strong><br> <?php echo $post->comment; ?>                               
                    </div>                            
                    <div class="clearfix"></div>
                    <div class="left">
                        <div class="item">
                            <div class="title">Recorded By</div>
                            <div class="descr"><?php $user = $this->ion_auth->get_user($post->modified_by);
        echo $user->first_name . ' ' . $user->last_name; ?></div>
                        </div>

                    </div> 
                    <div class="right">
                        <div class="item">
                            <div class="title">Date Punished</div>
                            <div class="descr"><?php echo date('d M Y', $post->date_reported); ?></div>
                        </div>

                    </div>                            
                </div>
<?php endif; ?>
    </div>
</div>
</div>



<div class="col-md-6">

    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2> Disciplinary </h2> 
        <div class="right">                            

<?php echo anchor('admin/disciplinary/create/', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Disciplinary')), 'class="btn btn-primary"'); ?>
    <?php echo anchor('admin/disciplinary/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>

        </div>    					
    </div>
<?php if ($disciplinary): ?>              
            <div class="block-fluid">
                <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">



                    <thead>
                    <th>#</th>
                    <th>Repored on</th>
                    <th>Culprit</th>

                    <th>Status</th>

                    <th><?php echo lang('web_options'); ?></th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
 
                        $user = $this->ion_auth->students_full_details();
                        foreach ($disciplinary as $p):
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>					
                                    <td><?php echo date('d/m/Y', $p->date_reported); ?></td>
                                    <td><?php echo $user[$p->culprit]; ?></td>

                                    <td width="20%">
                                        <?php
                                        if (!empty($p->action_taken))
                                        {
                                                echo '<span class="label label-success">Action Taken</span>';
                                        }
                                        else
                                        {
                                                echo '<span class="label label-warning">Pending </span>';
                                        }
                                        ?>
                                    </td>
                                    <td width="20%">
                                        <a href="<?php echo site_url('admin/disciplinary/view/' . $p->id); ?>"><i class="glyphicon glyphicon-eye-open"></i> View</a>
                                    </td>
                                </tr>
            <?php endforeach ?>
                    </tbody>

                </table>
            </div>



<?php else: ?>
            <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif ?>
</div>