<div class="navigation hidden-print">
    <ul class="main" >
        <li><a 
            <?php
            if (preg_match('/^(admin)$/i', $this->uri->uri_string()))
                    echo 'class="active"';
            ?> href="<?php echo base_url('admin'); ?>" class="<?php if (preg_match('/^(admin)$/i', $this->uri->uri_string())) echo 'active'; ?>">
                <span class="icom-screen"></span><span class="text">Dashboard</span></a></li>
        <li><a 
            <?php
            if (
                         preg_match('/^(admin\/admission)/i', $this->uri->uri_string()))
                    echo 'class="active"';
            ?> href="<?php echo base_url('admin/admission/my_students'); ?>" class="<?php if (preg_match('/^(admin\/admission)/i', $this->uri->uri_string())) echo 'active'; ?>">
                <span class="icom-user"></span><span class="text">My Students</span></a>
        </li>
        <li>
            <a href="#ui" 
            <?php
            if (
                         preg_match('/^(admin\/students_placement)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/school_classes)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/class_stream)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/subjects)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/grading)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/class_rooms)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/grades)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/grading_system)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/exams)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/class_attendance)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/school_events)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/assignments)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/disciplinary)/i', $this->uri->uri_string()))
                    echo 'class="active"';
            ?>>
                <span class="icom-bookmark"></span><span class="text">Academics</span></a></li>
        <li><a href="#media"
               class="  <?php
               if (        (preg_match('/^(admin\/address_book_category)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/address_book)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/sms)/i', $this->uri->uri_string()))
               )
                       echo 'active';
               ?>">
                <span class="icom-videos"></span><span class="text">Communication</span></a>
        </li>
        <li><a 
            <?php
            if (preg_match('/^(admin\/record_salaries)/i', $this->uri->uri_string()))
                    echo 'class="active"';
            ?> href="<?php echo base_url('admin/record_salaries/my_slips'); ?>" class="<?php if (preg_match('/^(admin\/record_salaries)/i', $this->uri->uri_string())) echo 'active'; ?>">
                <span class="icom-database"></span><span class="text">Salaries</span></a>
        </li> 
    </ul>
    <div class="control"></div>        
    <div class="submain">
        <div id="default">
            <div class="widget-fluid userInfo clearfix">
                <div class="image" >
                    <img style="padding:1px;"src="<?php echo base_url('assets/themes/admin/img/us.jpg'); ?>" width="60" height="60" />
                </div>              
                <div class="name"><?php
                    $user = $this->ion_auth->get_user();
                    echo trim($user->first_name);
                    ?> </div>
                <ul class="menuList">
                    <li><strong>Email:</strong> <?php echo $this->user->email; ?></li>
                    <li><strong>Phone:</strong><?php echo $this->user->phone; ?></li>
                    <li><a href="<?php echo base_url('admin/sms'); ?>"><span class="glyphicon glyphicon-comment"></span> Messaging</a></li>
                    <li><a href="<?php echo base_url('admin/logout'); ?>"><span class="glyphicon glyphicon-share-alt"></span> Logout</a></li>                        
                </ul>
                <div class="text">
                 </div>
            </div>

            <div class="dr"><span></span></div>
            <ul class="fmenu">
                <li>
                    <a href="#">All Teachers</a>
                    <span class="caption blue"><?php
                       echo  $this->ion_auth->count_teachers();
                        ?>
                    </span>
                </li>                
            </ul>
            <div class="dr"><span></span></div>
        </div>
        <div id="ui">                
            <div class="menu">
                <a  <?php if (preg_match('/^(admin\/exams)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/exams'); ?>"><span class="glyphicon glyphicon-folder-open "></span> Exams Management</a>
                <div class="dr"><span></span></div>
                <a  <?php if (preg_match('/^(admin\/class_attendance)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/class_attendance'); ?>"><span class="glyphicon glyphicon-check "></span> Class Attendance</a>
                <a  <?php if (preg_match('/^(admin\/assignments)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/assignments'); ?>"><span class="glyphicon glyphicon-file "></span> Assignments</a>
                <a  <?php if (preg_match('/^(admin\/school_events)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/school_events'); ?>"><span class="glyphicon glyphicon-calendar "></span> School Events</a>
                <a  <?php if (preg_match('/^(admin\/school_events\/calendar)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/school_events/calendar'); ?>"><span class="glyphicon glyphicon-calendar "></span> Full Calendar</a>
                <a  <?php if (preg_match('/^(admin\/students_placement)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/students_placement'); ?>"><span class="glyphicon glyphicon-thumbs-up "></span> Placement</a>
                <a  <?php if (preg_match('/^(admin\/disciplinary)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/disciplinary'); ?>"><span class="glyphicon glyphicon-fire "></span> Discipline</a>
            </div>    
            <div class="dr"><span></span></div>
            <ul class="fmenu">
                <li>
                    <a href="<?php echo base_url('admin/admission'); ?>">All Registered Students </a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_students();
                        echo $count;
                        ?></span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/school_classes'); ?>" >All Classes</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_classes();
                        echo $count;
                        ?></span>
                </li> 
                <li>
                    <a href="<?php echo base_url('admin/subjects'); ?>">All Subjects</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_subjects();
                        echo $count;
                        ?></span>
                </li>
            </ul>
        </div>         
    </div>
</div>
