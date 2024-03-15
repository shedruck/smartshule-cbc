<div class="navigation hidden-print">
    <ul class="main" >
        <li><a 
            <?php
            if (
                         preg_match('/^(admin)$/i', $this->uri->uri_string()))
                    echo 'class="active"';
            ?> href="<?php echo base_url('admin'); ?>" class="<?php if (preg_match('/^(admin)$/i', $this->uri->uri_string())) echo 'active'; ?>">
                <span class="icom-screen"></span><span class="text">Dashboard</span></a></li>
        <li><a 
            <?php
            if (
                         preg_match('/^(admin\/admission)/i', $this->uri->uri_string()))
                    echo 'class="active"';
            ?> href="<?php echo base_url('admin/admission'); ?>" class="<?php if (preg_match('/^(admin\/admission)/i', $this->uri->uri_string())) echo 'active'; ?>">
                <span class="icom-user"></span><span class="text"> Students</span></a>
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
                <span class="icom-bookmark"></span><span class="text">Academics</span></a>
        </li>
        <li><a href="#media" class="  <?php
            if ((preg_match('/^(admin\/fee_payment)/i', $this->uri->uri_string())) ||
                         (preg_match('/^(admin\/expenses)/i', $this->uri->uri_string())) ||
                         (preg_match('/^(admin\/expenses\/requisitions)/i', $this->uri->uri_string())))
                    echo 'active';
            ?>">
                <span class="icom-videos"></span><span class="text">Fee</span></a>
        </li>
        <li><a href="#reports"
            <?php
            if (preg_match('/^(admin\/reports)/i', $this->uri->uri_string()))
            {
                    echo 'class="active"';
            }
            ?>><span class = "icom-stats-up"></span><span class = "text">Reports</span></a>
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
                    Welcome back!: <?php echo $this->ion_auth->get_user()->last_login ? date('d M Y H:i', $this->ion_auth->get_user()->last_login) : ''; ?>
                </div>
            </div>
            <div class="menu">

            </div>
            <div class="dr"><span></span></div>
            <ul class="fmenu">
                <li>
                    <a href="#">All Teachers</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_teachers();
                        echo $count;
                        ?></span>
                </li>                 
            </ul>
            <div class="dr"><span></span></div>
        </div>
        <div id="ui">                
            <div class="menu">
                <a  <?php if (preg_match('/^(admin\/exams)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/exams'); ?>"><span class="glyphicon glyphicon-folder-open "></span> Exams Management</a>
                <a  <?php if (preg_match('/^(admin\/reports\/exam)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/reports/exam'); ?>"><span class="glyphicon glyphicon-calendar "></span> Class Performance</a>
                <div class="dr"><span></span></div>
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
        <!--******************************COMM MENU******************************************-->		
        <div id="media">
            <div class="menu">
                <a  <?php if (preg_match('/^(admin\/fee_payment\/paid)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_payment/paid'); ?>"><span class="glyphicon glyphicon-calendar"></span> Fee Payments</a>
                <a  <?php if (preg_match('/^(admin\/expenses)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/expenses'); ?>"><span class="glyphicon glyphicon-bullhorn"></span> Expenses</a>
                <a  <?php if (preg_match('/^(admin\/expenses\/requisitions)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/expenses/requisitions'); ?>"><span class="glyphicon glyphicon-bullhorn"></span> Requisitions</a>
            </div>                                                              
            <div class="dr"><span></span></div>            
        </div>
        <div id="reports">
            <div class="menu">
                <a href="<?php echo base_url('admin/reports/student_report'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/student_report)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-folder-open"></span> Student History Report</a>
                <a href="<?php echo base_url('admin/reports/fee'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/fee)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-list-alt"></span> Fee Payment Summary</a>
                <a href="<?php echo base_url('admin/reports/admission'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/admission)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-user"></span> Admission Report</a>   
                <a href="<?php echo base_url('admin/reports/fee_status'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/fee_status)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-briefcase"></span> Fee Status Report</a>   
                <a href="<?php echo base_url('admin/reports/arrears'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/arrears)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-question-sign"></span> Arrears Report</a> 
                <a href="<?php echo base_url('admin/reports/fee_extras'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/fee_extras)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-signal"></span> Fee Extras Report</a>   
                <a href="<?php echo base_url('admin/reports/paid'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/paid)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-list"></span> Fee Payments Report</a>   
                <a href="<?php echo base_url('admin/reports/exam'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/exam)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-star"></span> Exam Results Report</a> 
                <a href="<?php echo base_url('admin/reports/expenses'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/expenses)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-indent-left"></span> Expenses Summary Report</a> 
                <a href="<?php echo base_url('admin/reports/expense_trend'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/expense_trend)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-indent-left"></span> Detailed  Expenses Report</a> 
                <a href="<?php echo base_url('admin/reports/wages'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/wages)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-barcode"></span> Wages Report</a>               
            </div>                
            <div class="dr"><span></span></div>
        </div>
    </div>
</div>
