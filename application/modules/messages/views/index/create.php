


<div class="row1 " id="x-acts">
				<div class="card shadow-sm ctm-border-radius grow">

			
				<div class="employee-office-table">
					<div class="table-responsive1">
							<div class="card-header d-flex align-items-center justify-content-between">
							
							  <div class="col-sm-12">
									<h4 class="card-title mb-0 d-inline-block">New Message
									
									
									</h4>
									<div class="pull-right">
									 <a class="btn btn-small pull-right btn-custom" href="<?php echo base_url('messages'); ?>"><i class="fa fa-caret-left"></i> Back</a>
										</div>
							  </div>		
							
						</div>

    <div class="block-fluid">
        <div class="clearfix"></div>
        <?php
        $attributes = array('class' => 'form-horizontal');
        echo form_open_multipart(current_url(), $attributes);
        $teachers = array();
        foreach ($this->parent->kids as $k)
        {
                $rw = $this->worker->get_student($k->student_id);

                $tch = $this->ion_auth->get_user($rw->cl->class_teacher);
                //$teachers[$rw->cl->class_teacher] = $tch->first_name . ' ' . $tch->last_name . ' (' . $rw->cl->name . ')';
                $teachers[$rw->cl->class_teacher] = 'Class Teacher (' . $rw->cl->name . ')';
        }
        ?>
		
	
												
												
        <div class="form-group">
              <div class="col-md-4">
                <label class="form-text">Title *</label> 
            </div>				
           <div class="col-md-4">
            <?php echo form_input('title', $result->title, 'id="title" class="form-control " placeholder="Message Title" '); ?>
            <?php echo form_error('title'); ?>
			</div>
        </div>
        
        <div class="form-group">
          <div class="col-md-4">
                <label class="">Send to*</label>             
           </div>
		    <div class="col-md-4">
            <select  name="to" class="form-control  ">
                <option value="10000">Headteacher</option>
                <option value="10002">Front Office</option>
                <?php
                foreach ($teachers as $user_id => $name)
                {
                        ?>
                        <option value="<?php echo $user_id ?>"> <?php echo $name; ?></option>
                <?php } ?>
            </select>
            <?php echo form_error('to'); ?>
			</div>
        </div>

        <div class="form-group">
            <div class="col-md-9">
                <?php echo form_error('message'); ?>
                <textarea name="message" class="summernote form-control" rows="4"><?php echo set_value((isset($result->message)) ? htmlspecialchars_decode($result->message) : ''); ?></textarea>
            </div>
        </div>
  
        <div class="form-group col-md-5">
            <div class="pull-right">
               
                <button  type="submit" class="btn btn-info"> <span>Submit Message</span> <i class="glyphicon glyphicon-send m-l-10"></i> </button>
            </div>
        </div>
        <?php echo form_close(); ?>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    </div>
    </div>
</div>
</div>
</div>
<style>
    .btn {
        border: 1px solid #84bb26;
        padding: 7px;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
        border-radius: 3px;
    }
</style>