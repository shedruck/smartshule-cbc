<div class="navigation hidden-print">
    <ul class="main" >
        <li><a 
            <?php
            if (
                         preg_match('/^(admin)$/i', $this->uri->uri_string())
            )
                    echo 'class="active"';
            ?> href="<?php echo base_url('admin'); ?>" class="<?php if (preg_match('/^(admin)$/i', $this->uri->uri_string())) echo 'active'; ?>">
                <span class="icom-screen"></span><span class="text">Dashboard</span></a></li>
      
        
        <li >
            <a href="#forms"
            <?php
            if (
                         preg_match('/^(admin\/admission)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/leaving_certificate)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/house)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/enquiries)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/class_groups\/promotion)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/hostels)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/extra_curricular)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/favourite_hobbies)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/activities)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/students_placement)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/disciplinary)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/assign_bed)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/medical_records)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/hostel_rooms)/i', $this->uri->uri_string())
                ||
                preg_match('/^(admin\/branch)/i', $this->uri->uri_string()) ||
                       
                         preg_match('/^(admin\/hostel_beds)/i', $this->uri->uri_string())
            )
                    echo 'class="active"';
            ?>>
                <span class="icom-bookmark"></span><span class="text">Students Management</span></a>
        </li>
        
                
        <li><a href="#accounts"
<?php
if (
             preg_match('/^(admin\/fee_structure)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/fee_arrears)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/grants)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/fee_payment)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/lpo)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/fee_statement)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/fee_waivers)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/expenses_category)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/expense_items)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/expenses)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/transport)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/fee_pledge)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/fee_extras)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/sales_items)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/sales_items_category)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/record_sales)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/sales_items_stock)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/deductions)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/tax_config)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/bank_accounts)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/coop_bank_file)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/allowances)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/paye)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/salaries)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/advance_salary)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/record_salaries)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/invoices)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/supplier_invoices)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/accounting)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/discounts)/i', $this->uri->uri_string())
    ||
    preg_match('/^(admin\/mpesa)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/petty_cash)/i', $this->uri->uri_string())
)
{
        echo 'class="active"';
}
?>><span class = "icom-database"></span><span class = "text">Accounts</span></a>
        </li>
        
          <li>
            <a href="#ui" 
            <?php
            if (
                         preg_match('/^(admin\/class_groups\/classes)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/class_stream)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/subjects)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/cbc)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/subject_categories)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/teachers\/assign)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/grading)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/grades)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/students_certificates)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/grading_system)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/assessment)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/exams_management)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/exams)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/igcse)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/class_attendance)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/class_groups\/classes)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/class_timetable)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/sub_cats)/i', $this->uri->uri_string()) ||

                        (preg_match('/^(admin\/effort)/i', $this->uri->uri_string())) ||

                         preg_match('/^(admin\/sub_cats)/i', $this->uri->uri_string()) ||

                         preg_match('/^(admin\/final_exams_certificates)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/final_exams_grades)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/qa)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/mc)/i', $this->uri->uri_string()) ||
                       
                         preg_match('/^(admin\/assignments)/i', $this->uri->uri_string()))
                    echo 'class="active"';
            ?>>
                <span class="icom-pencil3"></span><span class="text">Academics</span></a>
                
        </li>
        

        
        
           <li><a href="#lib"
               class="  <?php
               if (preg_match('/^(admin\/book_category)/i', $this->uri->uri_string()) ||
                            (preg_match('/^(admin\/past_papers)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/elearning)/i', $this->uri->uri_string())) ||
                           
                            (preg_match('/^(admin\/evideos)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/general_evideos)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/enotes)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/lesson_materials)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/books)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/ebooks)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/schemes_of_work)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/record_of_work_covered)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/book_list)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/students_projects)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/add_book)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/add_book)/i', $this->uri->uri_string())) ||
                              preg_match('/^(admin\/lesson_plan)/i', $this->uri->uri_string()) ||
                            (preg_match('/^(admin\/borrow_book)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/return_book)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/renew_book)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/book_fund)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/library_settings)/i', $this->uri->uri_string()))
               )
                       echo 'active';
               ?>">
                <span class="lib"><img src="<?php echo base_url('assets/themes/admin/img/read.png'); ?>" /></span><span class="text">E-Classroom & Library</span></a>
        </li>
        
        
        
        <li><a href="#media"
               class="  <?php
            if ((preg_match('/^(admin\/address_book_category)/i', $this->uri->uri_string())) ||
                         (preg_match('/^(admin\/address_book)/i', $this->uri->uri_string())) ||
                         (preg_match('/^(admin\/messages)/i', $this->uri->uri_string())) ||
                         (preg_match('/^(admin\/newsletters)/i', $this->uri->uri_string())) ||
                         (preg_match('/^(admin\/visitors_book_cat)/i', $this->uri->uri_string())) ||
                         (preg_match('/^(admin\/vistors_book)/i', $this->uri->uri_string())) ||
                         (preg_match('/^(admin\/emails)/i', $this->uri->uri_string())) ||
                         (preg_match('/^(admin\/zoom)/i', $this->uri->uri_string())) ||
                           preg_match('/^(admin\/events)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/school_events)/i', $this->uri->uri_string()) ||
                         (preg_match('/^(admin\/email_templates)/i', $this->uri->uri_string())) ||
                         preg_match('/^(admin\/rules_regulations)/i', $this->uri->uri_string()) ||
                         (preg_match('/^(admin\/notice_board)/i', $this->uri->uri_string())) ||
                         (preg_match('/^(admin\/sms)/i', $this->uri->uri_string()))
            )
                    echo 'active';
?>">
                <span class="icom-videos"></span><span class="text">Communication</span></a>
        </li> 
        <li><a href="#inventory"
<?php
if (
             preg_match('/^(admin\/inventory)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/add_stock)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/items)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/items_category)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/give_items)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/stock_taking)/i', $this->uri->uri_string())
)
{
        echo 'class="active"';
}
?>><span class = "icom-list"></span><span class = "text">Inventory</span></a>
        </li>
     

        <li><a 
                class=" <?php
               if (
                            preg_match('/^(admin\/users)/i', $this->uri->uri_string()) ||
                            preg_match('/^(admin\/change_password)/i', $this->uri->uri_string()) ||
                            preg_match('/^(admin\/parents)/i', $this->uri->uri_string()) ||
                            preg_match('/^(admin\/emergency_contacts)/i', $this->uri->uri_string()) ||
                            preg_match('/^(admin\/non_teaching)/i', $this->uri->uri_string()) ||
                            preg_match('/^(admin\/staff_clearance)/i', $this->uri->uri_string()) ||
                            preg_match('/^(admin\/students_clearance)/i', $this->uri->uri_string()) ||
                            preg_match('/^(admin\/subordinate)/i', $this->uri->uri_string()) ||
                            preg_match('/^(admin\/board_members)/i', $this->uri->uri_string()) ||
                            preg_match('/^(admin\/teachers)/i', $this->uri->uri_string()) ||
                            preg_match('/^(admin\/appraisal_targets)/i', $this->uri->uri_string()) ||
                            preg_match('/^(admin\/employees_attendance)/i', $this->uri->uri_string()) ||
                            preg_match('/^(admin\/sandbox)/i', $this->uri->uri_string()) ||
                            preg_match('/^(admin\/groups)/i', $this->uri->uri_string())
               )
                       echo 'active';
               ?>"
                href="#users"><span class="icom-user"></span><span class="text">People Management</span></a>
        </li>


        <li><a href="#reports"
<?php
if (preg_match('/^(admin\/reports)/i', $this->uri->uri_string()) || preg_match('/^(admin\/accounts)/i', $this->uri->uri_string()))
{
        echo 'class="active"';
}
?>><span class = "icom-stats-up" style=""></span><span class = "text">Reports</span></a>
        </li>

        <li><a  class = " <?php
            if (preg_match('/^(admin\/settings)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/class_groups)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/positions)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/class_stream)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/registration_details)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/institution_docs)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/ownership_details)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/permissions)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/contact_person)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/license)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/verifiers)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/clearance_departments)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/class_rooms)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/audit_logs)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/suspended)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/titles)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/payment_options)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/contracts)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/subcounties)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/counties)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/departments)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/uploads)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/shop_item)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/setup)/i', $this->uri->uri_string()))
                    echo 'active';
            ?>" href="#other"><span class="icom-cog"></span><span class="text">Settings</span></a>
        </li>
    </ul>
    <div class="control"></div>        
    <div class="submain">
        <div id="default">
            <div class="widget-fluid  clearfix" style="text-align:center">

<?php $settings = $this->ion_auth->settings(); ?>
                <img style="padding:1px;"src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="120" height="120" />

                <h4><?php echo $settings->school; ?>
                    <small><br>
                        <b>Motto: </b>"<?php echo $settings->motto; ?>"<br> 
<?php
if (!empty($settings->tel))
{
        echo $settings->postal_addr . '<br> Tel:' . $settings->tel . ' ' . $settings->cell;
}
else
{
        echo $settings->postal_addr . ' Cell:' . $settings->cell;
}
?> </small> </h4> 

            </div>
            <div class="dr"><span></span></div>
            <ul class="fmenu">
                <li>
                    <a href="<?php echo base_url('admin/admission'); ?>"> Students </a>
                    <span class="caption blue">
<?php
$count = $this->ion_auth->count_students();
echo $count;
?>
                    </span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/teachers'); ?>">All Teachers</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_teachers();
                        echo $count;
?></span>
                </li> 
                <li>
                    <a href="<?php echo base_url('admin/parents'); ?>">Registered Parents</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_parents();
                        echo $count;
                        ?></span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/class_groups/classes'); ?>" >All Classes</a>
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

                <li>
                    <a href="<?php echo base_url('admin/sms'); ?>">All SMS'</a>
                    <span class="caption blue"><?php echo $this->ion_auth->count_sms(); ?></span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/admission'); ?>">All Registered Users </a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_users();
                        echo $count;
                        ?></span>
                </li>
            </ul>
            <div class="dr"><span></span></div>
        </div>
        <div id="ui">                
            <div class="menu">
                <a  <?php if (preg_match('/^(admin\/class_stream)/i', $this->uri->uri_string()) || preg_match('/^(admin\/class_groups\/classes)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/class_groups/classes'); ?>"><span class="glyphicon glyphicon-home"></span>All Classes</a>

                <a  <?php if (preg_match('/^(admin\/subjects)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/subjects'); ?>"><span class="glyphicon glyphicon-list "></span> Subjects</a>


                <a  <?php if (preg_match('/^(admin\/teachers\/assign)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/teachers/assign'); ?>"><span class="glyphicon glyphicon-list "></span>Assign Educators Subjects</a>
                
                
                <a  <?php if (preg_match('/^(admin\/subject_categories)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/subject_categories'); ?>"><span class="glyphicon glyphicon-list-alt "></span> Subject Categories</a>
                
                <a  <?php if (preg_match('/^(admin\/cbc)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/cbc'); ?>"><span class="glyphicon glyphicon-folder-open "></span> CBC Subjects</a>
                <a  <?php if (preg_match('/^(admin\/cbc\/assessment)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/cbc/assessment'); ?>"><span class="glyphicon glyphicon-folder-open "></span> CBC Formative Report</a>
                <a  <?php if (preg_match('/^(admin\/cbc\/summative)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/cbc/summative'); ?>"><span class="glyphicon glyphicon-folder-open "></span> CBC Summative Report</a>
                
                <a  <?php if (preg_match('/^(admin\/class_timetable)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/class_timetable'); ?>"><span class="glyphicon glyphicon-calendar "></span> Class Timetable</a>
                
                 <a  <?php if (preg_match('/^(admin\/class_attendance)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/class_attendance'); ?>"><span class="glyphicon glyphicon-check "></span> Students Roll Call</a>
                 
                <a  <?php if (preg_match('/^(admin\/assignments)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/assignments'); ?>"><span class="glyphicon glyphicon-file "></span> Assignments</a>

                


                <h5 class="center"> Exams Management </h5>



                <a  <?php if (preg_match('/^(admin\/exams)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/exams'); ?>"><span class="glyphicon glyphicon-list "></span> Exams</a>

                <a  <?php if (preg_match('/^(admin\/igcse)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/igcse'); ?>"><span class="glyphicon glyphicon-list "></span> IGCSE</a>

                <a  <?php if (preg_match('/^(admin\/igcse\/report)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/igcse/report'); ?>"><span class="glyphicon glyphicon-list "></span> IGCSE Report</a>

                <a  <?php if (preg_match('/^(admin\/igcse\/sub_report)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/igcse/sub_report'); ?>"><span class="glyphicon glyphicon-list "></span> IGCSE Subjects Report</a>

                <a href="<?php echo base_url('admin/reports/exam'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/exam)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-folder-open"></span> Exam Results Report</a> 

                <a href="<?php echo base_url('admin/reports/joint'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/joint)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-file"></span> Students Exam Report</a> 

                <a href="<?php echo base_url('admin/reports/sms_exam'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/sms_exam)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-comment"></span> SMS Exams Results </a> 

                <a href="<?php echo base_url('admin/reports/grade_analysis'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/grade_analysis)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-folder-close"></span> Grade Analysis </a> 

                <a  <?php if (preg_match('/^(admin\/grading)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/grading\/view)/i', $this->uri->uri_string()) || preg_match('/^(admin\/grades)/i', $this->uri->uri_string()) || preg_match('/^(admin\/grading\/edit)/i', $this->uri->uri_string()) || preg_match('/^(admin\/grading\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/grading'); ?>"><span class="glyphicon glyphicon-list "></span> Grading</a>
                <a  <?php if (preg_match('/^(admin\/grading_system)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/grading_system'); ?>"><span class="glyphicon glyphicon-list-alt "></span> Grading System</a>


                <h5 class="center"> Other Activities </h5>

                

                <a  <?php if (preg_match('/^(admin\/final_exams_certificates)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/final_exams_certificates'); ?>"><span class="glyphicon glyphicon-file"></span> National Exams Certificates</a> 

                <a  <?php if (preg_match('/^(admin\/students_certificates)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/students_certificates'); ?>"><span class="glyphicon glyphicon-folder-close"></span> Other Certificates</a> 
               
               

               


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
                    <a href="<?php echo base_url('admin/class_groups/classes'); ?>" >All Classes</a>
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
        <!--******************************ADMINISTRATION MENU******************************************-->  
        <div id="forms">                                                
            <div class="menu">

                <a  <?php if (preg_match('/^(admin\/admission\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/admission/create'); ?>"><span class="glyphicon glyphicon-edit"></span> New Admission</a>


                <a  
<?php if (preg_match('/^(admin\/admission)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> 
<?php if (preg_match('/^(admin\/admission\/edit)/i', $this->uri->uri_string())) echo 'class="active"'; ?> 
<?php //if (preg_match('/^(admin\/admission\/create)/i', $this->uri->uri_string())) echo 'class="active"';  ?> 
<?php if (preg_match('/^(admin\/admission\/student)/i', $this->uri->uri_string())) echo 'class="active"'; ?> 
                <?php if (preg_match('/^(admin\/admission\/inactive)/i', $this->uri->uri_string())) echo 'class="active"'; ?> 
                <?php if (preg_match('/^(admin\/admission\/view)/i', $this->uri->uri_string())) echo 'class="active"'; ?> 

                    href="<?php echo base_url('admin/admission'); ?>"><span class="glyphicon glyphicon-file"></span> All Students </a>
                    
                       <a  <?php if (preg_match('/^(admin\/enquiries)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/enquiries'); ?>"><span class="glyphicon glyphicon-file"></span> Admission Enquiries</a> 

  <a  <?php if (preg_match('/^(admin\/class_groups\/promotion)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/class_groups/promotion'); ?>"><span class="glyphicon glyphicon-share "></span> Move Students to Next Class</a>

                <a  <?php if (preg_match('/^(admin\/admission\/siblings)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/admission/siblings'); ?>"><span class="glyphicon glyphicon-list"></span> Siblings (Students)</a>


                <a  <?php if (preg_match('/^(admin\/admission\/alumni)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/admission/alumni'); ?>"><span class="glyphicon glyphicon-list"></span> Alumni Students</a>

             


                <h5 class="center"> Students Life </h5>
                <a  <?php if (preg_match('/^(admin\/disciplinary)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/disciplinary'); ?>"><span class="glyphicon glyphicon-question-sign "></span> Students Discipline</a>
  
                
                <a  <?php if (preg_match('/^(admin\/medical_records)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/medical_records'); ?>"><span class="glyphicon glyphicon-briefcase"></span> Medical Records</a>
                
                <a  <?php if (preg_match('/^(admin\/extra_curricular)/i', $this->uri->uri_string()) || preg_match('/^(admin\/activities)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/extra_curricular'); ?>"><span class="glyphicon glyphicon-tasks"> </span> Extra Curricular Activities</a>
                

                <a  <?php if (preg_match('/^(admin\/favourite_hobbies)/i', $this->uri->uri_string()) || preg_match('/^(admin\/favourite_hobbies)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/favourite_hobbies'); ?>"><span class="glyphicon glyphicon-tasks"> </span> Hobbies & Favourites</a>
                
                
                <a  <?php if (preg_match('/^(admin\/admission\/birthdays)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/admission/birthdays'); ?>"><span class="glyphicon glyphicon-list"></span> Birthday Reminders</a>

                <a  <?php if (preg_match('/^(admin\/leaving_certificate)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/leaving_certificate'); ?>"><span class="glyphicon glyphicon-bookmark"></span> Leaving Certificate</a>

                <a  <?php if (preg_match('/^(admin\/students_placement)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/students_placement'); ?>"><span class="glyphicon glyphicon-thumbs-up "></span> Leadership Position</a>
                
              


                <div class="dr"><span></span></div> 
                <ul class="fmenu changed" >
                    <li  <?php
                if (preg_match('/^(admin\/hostels)/i', $this->uri->uri_string()) ||
                             (preg_match('/^(admin\/hostel_rooms)/i', $this->uri->uri_string())) ||
                             (preg_match('/^(admin\/assign_bed)/i', $this->uri->uri_string())) ||
                             (preg_match('/^(admin\/hostel)/i', $this->uri->uri_string()))
                )
                        echo 'class="active"';
                ?>>
                        <a  <?php
                    if (preg_match('/^(admin\/hostels)/i', $this->uri->uri_string()) ||
                                 (preg_match('/^(admin\/hostel_rooms)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/assign_bed)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/hostel)/i', $this->uri->uri_string()))
                    )
                            echo 'class="active"';
                    ?> href="#"><span class="glyphicon glyphicon-home"></span> Hostels/Dormitories <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                        <ul >
                            <li><a  <?php if (preg_match('/^(admin\/hostels)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/hostels\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/hostels'); ?>"><span class="glyphicon glyphicon-list"></span> Manage Hostels</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/hostel_rooms)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/hostel_rooms\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/hostel_rooms'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Manage Hostel Rooms</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/hostel_beds)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/hostel_beds\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/hostel_beds'); ?>"><span class="glyphicon glyphicon-random"></span> Manage Hostel Beds</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/assign_bed)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/assign_bed\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/assign_bed'); ?>"><span class="glyphicon glyphicon-fast-forward"></span> Assign Bed</a></li>
                        </ul>
                    </li> 
                </ul>
                <!--New menu
                <ul class="fmenu changed" >
                    <li  class="
<?php if (preg_match('/^(admin\/transport)/i', $this->uri->uri_string())) echo 'active'; ?>
                         ">
                        <a  <?php
if (preg_match('/^(admin\/transport)$/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/transport\/routes)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/transport\/students)/i', $this->uri->uri_string()))
        echo 'class="active"';
?> href="#"><span class="icosg-bus"></span> Transport <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                        <ul >
                            <li><a  <?php if (preg_match('/^(admin\/transport)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/transport\/routes)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/transport'); ?>"><span class="glyphicon glyphicon-list"></span> Transport</a></li>
                        </ul>
                    </li>
                </ul> 
            --> 
                
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
                    <a href="<?php echo base_url('admin/class_rooms'); ?>">All Class Rooms </a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_class_rooms();
                        echo $count;
                        ?></span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/hostels'); ?>">All Dormitories /Hostels</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_hostels();
                        echo $count;
                        ?></span>
                </li> 
                <li>
                    <a href="<?php echo base_url('admin/hostel_rooms'); ?>">All Dormitories /Hostels Rooms</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_hostel_rooms();
                        echo $count;
                        ?></span>
                </li> 
                <li>
                    <a href="<?php echo base_url('admin/hostel_beds'); ?>">All Hostel Beds</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_hostel_beds();
                        echo $count;
                        ?></span>
                </li> 
            </ul>
            <div class="dr"><span></span></div>                
        </div> 
        <!--******************************ACCOUNTS MENU******************************************-->        
        <div id="accounts">                                                
            <div class="menu">
                <ul class="fmenu changed" style="background:#ccc; display:block;" >
                    <li
<?php
if (preg_match('/^(admin\/fee_payment)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/fee_structure)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/fee_extras)/i', $this->uri->uri_string()) ||
             preg_match('/^(admin\/fee_waivers)/i', $this->uri->uri_string()))
        echo 'class="active"';
?> >
                        <a  <?php
                    if (preg_match('/^(admin\/fee_payment)/i', $this->uri->uri_string()) ||
                                 preg_match('/^(admin\/fee_structure)/i', $this->uri->uri_string()) ||
                                 preg_match('/^(admin\/fee_extras)/i', $this->uri->uri_string()) ||
                                 preg_match('/^(admin\/fee_waivers)/i', $this->uri->uri_string()))
                            echo 'class="active"';
                    ?> href="#"><span class="glyphicon glyphicon-lock"></span> Financial Management</a>
                        <ul style="display:block;" >

                            <li> <a  <?php if (preg_match('/^(admin\/fee_payment\/create)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_payment/create'); ?>"><span class="glyphicon glyphicon-share"></span> Receive Payment</a></li>


                            <li><a  <?php if (preg_match('/^(admin\/fee_payment\/statement)/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_payment)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_payment\/view)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_payment'); ?>"><span class="glyphicon glyphicon-briefcase"></span> Fee Statements</a></li>

                            <li> <a  <?php if (preg_match('/^(admin\/fee_payment\/paid)/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_payment\/receipt)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_payment/paid'); ?>"><span class="glyphicon glyphicon-list"></span> Payment Receipts</a></li>
                            
                             <li> <a  <?php if (preg_match('/^(admin\/fee_payment\/bulk)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_payment/bulk'); ?>"><span class="glyphicon glyphicon-share"></span> SMS Fee Balance </a></li>

                             <li> <a  <?php if (preg_match('/^(admin\/fee_payment\/generate_balances)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_payment/generate_balances'); ?>"><span class="glyphicon glyphicon-file"></span> Print Fee Balance </a></li>

                           

                            <li> <a  <?php if (preg_match('/^(admin\/fee_waivers)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_waivers'); ?>"><span class="glyphicon glyphicon-thumbs-up"></span> Fee Waiver / Discounts</a></li>

                            <li> <a  <?php if (preg_match('/^(admin\/fee_waivers\/pending)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_waivers/pending'); ?>"><span class="glyphicon glyphicon-thumbs-down"></span> Pending Waivers 
                            <sup>  <span class="label label-warning"><?php echo $this->fee_payment_m->total_pending_waivers(); ?></span></sup></a></li>
                           
                            <li> <a  <?php if (preg_match('/^(admin\/fee_pledge)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_pledge'); ?>"><span class="glyphicon glyphicon-tasks"></span> Fee Pledges</a></li>

                            <li> <a  <?php if (preg_match('/^(admin\/fee_arrears)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_arrears'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Balance Brought Forward</a></li>                            
                            
                            <a   href="#" style="background:#394960; color:#fff">Manage Invoices & Vote Heads</a>


                            <li> <a  <?php if (preg_match('/^(admin\/fee_structure)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_structure\/edit)/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_structure)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_structure\/view)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_structure'); ?>"><span class="glyphicon glyphicon-list-alt"></span>Manage Fee Structure</a></li>
                            
                            <li> <a  <?php if (preg_match('/^(admin\/fee_extras)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_extras'); ?>"><span class="glyphicon glyphicon-list"></span>Manage Fee Vote Heads </a></li> 

                            <li> <a  <?php if (preg_match('/^(admin\/fee_structure\/extras)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_structure/extras'); ?>"><span class="glyphicon glyphicon-list"></span> Invoice Vote Heads </a></li>
                            
                             <li> <a  <?php if (preg_match('/^(admin\/invoices\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/invoices/create'); ?>"><span class="glyphicon glyphicon-share"></span> Invoice  Tuition Fee</a></li> 
                             
                              <li><a  <?php if (preg_match('/^(admin\/transport)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/transport\/routes)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/transport'); ?>"><span class="glyphicon glyphicon-list"></span> Transport Manager</a></li>

                               <li><a  <?php if (preg_match('/^(admin\/transport_buses)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/transport_buses)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/transport_buses'); ?>"><span class="glyphicon glyphicon-list"></span> Transport Buses</a></li>
                             
                             
                            <li> <a  <?php if (preg_match('/^(admin\/fee_structure\/my_extras)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_structure/my_extras'); ?>"><span class="glyphicon glyphicon-file"></span> Manage Invoices </a></li>
                            
                            <li> <a  <?php if (preg_match('/^(admin\/invoices\/edit_pay)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/invoices/edit_pay'); ?>"><span class="glyphicon glyphicon-edit"></span> Bulk Manage Invoices </a></li>

                          

                            <li> <a  <?php if (preg_match('/^(admin\/fee_structure\/invoice)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_structure/invoice'); ?>"><span class="glyphicon glyphicon-edit"></span> Generate Invoices </a></li> 

                          <!--   <li> <a  <?php if (preg_match('/^(admin\/invoices)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/invoices'); ?>"><span class="glyphicon glyphicon-list"></span> All Tuition Invoices </a></li> -->
                          
                          <a   href="#" style="background:#394960; color:#fff">Bank File Reconciliation</a>
                            
                              <li> <a  <?php if (preg_match('/^(admin\/coop_bank_file)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/coop_bank_file'); ?>"><span class="glyphicon glyphicon-edit"></span> Coop Bank Files </a></li> 

                            
                        </ul>
                    </li>
                </ul>
                <a  <?php if (preg_match('/^(admin\/lpo)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/lpo'); ?>"><span class="glyphicon glyphicon-list"></span> Purchase Orders</a>

                  <a  <?php if (preg_match('/^(admin\/supplier_invoices)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/supplier_invoices'); ?>"><span class="glyphicon glyphicon-edit"></span> Supplier Invoices </a> 

                <a  <?php if (preg_match('/^(admin\/expenses)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/expenses'); ?>"><span class="glyphicon glyphicon-shopping-cart"></span> Expenses</a> 
                <a  <?php if (preg_match('/^(admin\/expenses\/requisitions)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/expenses/requisitions'); ?>"><span class="glyphicon glyphicon-check"></span>Requisitions</a> 
                <a  <?php if (preg_match('/^(admin\/petty_cash)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/petty_cash'); ?>"><span class="glyphicon glyphicon-briefcase"></span> Petty Cash</a> 


                <a  <?php if (preg_match('/^(admin\/grants)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/grants'); ?>"><span class="glyphicon glyphicon-list"></span> Grants</a>


                <a  <?php if (preg_match('/^(admin\/bank_accounts)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/bank_accounts'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Bank Accounts</a>


                <div class="dr"><span></span></div>  


                <ul class="fmenu changed" >
                    <li  <?php
                        if (preg_match('/^(admin\/deductions)/i', $this->uri->uri_string()) ||
                                     (preg_match('/^(admin\/salaries)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/advance_salary)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/record_salaries)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/paye)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/allowances)/i', $this->uri->uri_string()))
                        )
                                echo 'class="active"';
                    ?>>
                        <a  <?php
                    if (preg_match('/^(admin\/deductions)/i', $this->uri->uri_string()) ||
                                 (preg_match('/^(admin\/allowances)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/paye)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/advance_salary)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/salaries)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/record_salaries)/i', $this->uri->uri_string()))
                    )
                            echo 'class="active"';
                    ?> href="http://payroll.keypadsystems.co.ke/login" target="_blank"><span class="glyphicon glyphicon-th"></span> Payroll Management <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                      
                    </li> 
                </ul>
                <ul class="fmenu changed">
                    <li  <?php
                            if (preg_match('/^(admin\/sales_items)/i', $this->uri->uri_string()) ||
                                         (preg_match('/^(admin\/sales_items_stock)/i', $this->uri->uri_string())) ||
                                         (preg_match('/^(admin\/record_sales)/i', $this->uri->uri_string())))
                                    echo 'class="active"';
                    ?>>
                        <a <?php
                    if (preg_match('/^(admin\/sales_items)/i', $this->uri->uri_string()) ||
                                 (preg_match('/^(admin\/sales_items_stock)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/record_sales)/i', $this->uri->uri_string())))
                            echo 'class="active"';
                    ?> href="#"><span class="glyphicon glyphicon-folder-open"></span> Sales <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                        <ul>
                            <li><a  <?php if (preg_match('/^(admin\/sales_items)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/sales_items\/create)/i', $this->uri->uri_string()) || preg_match('/^(admin\/sales_items\/edit)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/sales_items'); ?>"><span class="glyphicon glyphicon-list"></span> Sales Items</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/sales_items_stock)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/sales_items_stock'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Sales Items Stock Trend</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/record_sales)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/record_sales'); ?>"><span class="glyphicon glyphicon-briefcase"></span> Record Sales</a></li>
                        </ul>
                    </li> 
                </ul>
                <div class="dr"><span></span></div>                
            </div>   
            <div class="dr"><span></span></div>                
        </div>          
        <div id="inventory">
            <div class="menu">
                <a  <?php if (preg_match('/^(admin\/inventory)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/inventory\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/inventory'); ?>"><span class="glyphicon glyphicon-list"></span> Inventory Trend</a>
                <a  <?php if (preg_match('/^(admin\/items)/i', $this->uri->uri_string()) || preg_match('/^(admin\/items\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/items'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Manage Items</a>
                <a  <?php if (preg_match('/^(admin\/items_category)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/items_category\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/items_category'); ?>"><span class="glyphicon glyphicon-random"></span> Items Category</a>
                <a  <?php if (preg_match('/^(admin\/add_stock)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/add_stock\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/add_stock'); ?>"><span class="glyphicon glyphicon-edit"></span> Add Items (Stock)</a>
                <a  <?php if (preg_match('/^(admin\/give_items)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/give_items)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/give_items'); ?>"><span class="glyphicon glyphicon-book"></span> Giving Out Items</a>
                <a  <?php if (preg_match('/^(admin\/stock_taking)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/stock_taking\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/stock_taking'); ?>"><span class="glyphicon glyphicon-shopping-cart"></span> Stock Takings</a>
            </div>  
        </div>
        <div id="files">
            <div class="menu">
                <a  <?php if (preg_match('/^(admin\/files)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/files'); ?>"><span class="glyphicon glyphicon-bullhorn"></span> File Management</a>
                <a  <?php if (preg_match('/^(admin\/folders)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/folders'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Folders Management</a>
                <a  <?php if (preg_match('/^(admin\/folders\/gallery)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/folders'); ?>"><span class="glyphicon glyphicon-picture"></span> Gallery Management</a>
            </div>      
        </div>
        <!--******************************LIBRARY MENU******************************************-->     
        <!--******************************LIBRARY MENU******************************************-->     
        <!--******************************LIBRARY MENU******************************************-->         
        <div id="lib">
            <div class="menu">
            
             <ul class="fmenu changed"  >
                    <li><a  <?php
                        if (preg_match('/^(admin\/books)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/past_papers)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/evideos)/i', $this->uri->uri_string()) ||
                                  
                                     preg_match('/^(admin\/lesson_plan)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/general_evideos)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/enotes)/i', $this->uri->uri_string())||
                                     preg_match('/^(admin\/lesson_materials)/i', $this->uri->uri_string()))
                                echo 'class="active"';
                    ?> href="#"><span class="glyphicon glyphicon-book"></span> E-Classroom <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                     
                      <ul style="display:block" >
                        <li><a  <?php if (preg_match('/^(admin\/past_papers)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/past_papers'); ?>"><span class="glyphicon glyphicon-file"></span> E-Past Papers</a></li>

                        <li><a  <?php if (preg_match('/^(admin\/evideos)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/evideos'); ?>"><span class="glyphicon glyphicon-folder-open"></span> E-Videos per Level</a></li>
                        
                        <li><a  <?php if (preg_match('/^(admin\/general_evideos)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/general_evideos'); ?>"><span class="glyphicon glyphicon-folder-open"></span> General E-Videos</a></li>
                        
                        <li><a  <?php if (preg_match('/^(admin\/enotes)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/enotes'); ?>"><span class="glyphicon glyphicon-file"></span> E-Notes</a></li>
                        
                        <li><a  <?php if (preg_match('/^(admin\/ebooks)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/ebooks'); ?>"><span class="glyphicon glyphicon-file"></span> E-Books</a></li>

                        <li><a  <?php if (preg_match('/^(admin\/schemes_of_work)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/schemes_of_work'); ?>"><span class="glyphicon glyphicon-folder-close"></span> Schemes of work</a></li>
                        
                        
                        <li><a  <?php if (preg_match('/^(admin\/record_of_work_covered)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/record_of_work_covered'); ?>"><span class="glyphicon glyphicon-folder-close"></span> Record of Covered</a></li>
                        
                        <li><a  <?php if (preg_match('/^(admin\/students_projects)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/students_projects'); ?>"><span class="glyphicon glyphicon-folder-close"></span> Students Projects</a></li>
                        
                        
                        <li><a  <?php if (preg_match('/^(admin\/lesson_materials)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/lesson_materials'); ?>"><span class="glyphicon glyphicon-file"></span> E-Lesson Materials</a></li>
                        
                        <li><a  <?php if (preg_match('/^(admin\/lesson_plan)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/lesson_plan'); ?>"><span class="glyphicon glyphicon-list "></span> Educators Lesson Plans</a></li>

                        <li><a  <?php if (preg_match('/^(admin\/#)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/ebooks'); ?>"><span class="glyphicon glyphicon-tasks"></span> E-learning</a></li>
                        </ul>
                  </li>
              </ul>
                <div class="dr"><span></span></div> 

                <ul class="fmenu changed"  >
                    <li><a  <?php
                        if (preg_match('/^(admin\/books)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/book_list)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/books_stock)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/borrow_book)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/return_book)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/library_settings)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/books_category)/i', $this->uri->uri_string()))
                                echo 'class="active"';
                    ?> href="#"><span class="glyphicon glyphicon-book"></span> Books Library <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                    
                    
                        <ul style="display:block" >
                            <li> <a  <?php if (preg_match('/^(admin\/borrow_book)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/borrow_book\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/borrow_book'); ?>"><span class="glyphicon glyphicon-share"></span> Borrow Book</a> </li>
                            <li><a  <?php if (preg_match('/^(admin\/return_book)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/return_book\/create)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/return_book\/view)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/return_book\/edit)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/return_book'); ?>"><span class="glyphicon glyphicon-check"></span> Return Book</a></li>
                            <li>
                                <a  <?php if (preg_match('/^(admin\/books)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/books\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/books'); ?>"><span class="glyphicon glyphicon-book"></span> Books</a></li>
                               <li> <a  <?php if (preg_match('/^(admin\/books)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/book_list)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/book_list'); ?>"><span class="glyphicon glyphicon-book"></span> Book List</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/books_stock)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/books_stock'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Manage Books Stock </a></li>
                            <li> <a  <?php if (preg_match('/^(admin\/books_category)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/books_category'); ?>"><span class="glyphicon glyphicon-random"></span> Books Category </a></li>
                            <li><a  <?php if (preg_match('/^(admin\/library_settings)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/library_settings'); ?>"><span class="glyphicon glyphicon-asterisk"></span> Library Settings</a></li>
                        </ul>
                    </li>
                </ul>   
                <div class="dr"><span></span></div> 
                <ul class="fmenu changed"  >
                    <li><a  <?php
                            if (preg_match('/^(admin\/book_fund)/i', $this->uri->uri_string()) ||
                                         preg_match('/^(admin\/return_book_fund)/i', $this->uri->uri_string()) ||
                                         preg_match('/^(admin\/borrow_book_fund)/i', $this->uri->uri_string()))
                                    echo 'class="active"';
                    ?> href="#"><span class="glyphicon glyphicon-book"></span> Book Fund <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                        <ul style="display:block" >
                            <li><a  <?php if (preg_match('/^(admin\/book_fund)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/book_fund\/edit)/i', $this->uri->uri_string()) || preg_match('/^(admin\/book_fund\/view)/i', $this->uri->uri_string()) || preg_match('/^(admin\/book_fund\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/book_fund'); ?>"><span class="glyphicon glyphicon-list"></span> Books For Fund</a> </li>
                            <li>  <a  <?php if (preg_match('/^(admin\/borrow_book_fund)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/borrow_book_fund'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Give out Book Fund</a></li>
                            <li>  <a  <?php if (preg_match('/^(admin\/return_book_fund)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/return_book_fund'); ?>"><span class="glyphicon glyphicon-folder-close"></span> Return Book</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/book_fund_stock)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/book_fund_stock'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Books Fund Stocks</a> </li>
                        </ul> 
                    </li>
                </ul>               
            </div>    

            
            <div class="dr"><span></span></div> 
            <ul class="fmenu">
                <li>
                    <a href="<?php echo base_url('admin/books'); ?>">All Library Books </a>
                    <span class="caption blue"><?php
                            $bk = $this->ion_auth->count_books();
                            echo $bk->total;
                    ?></span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/borrow_book'); ?>">All Borrowed Library Books</a>
                    <span class="caption blue"><?php echo $this->ion_auth->count_borrowed_books(); ?></span>
                </li> 
                <li>
                    <a href="<?php echo base_url('admin/books_category'); ?>">All Books Category</a>
                    <span class="caption blue"><?php echo $this->ion_auth->count_books_category(); ?></span>
                </li>               
            </ul>
            <div class="dr"><span></span></div> 
        </div> 

        <div id="media">
            <div class="menu">
                <a  <?php if (preg_match('/^(admin\/sms)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/sms'); ?>"><span class="glyphicon glyphicon-envelope"></span> SMS Messaging</a>
                <a  <?php if (preg_match('/^(admin\/messages)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/messages'); ?>"><span class="glyphicon glyphicon-comment"></span>Messages & Feedback</a>


                <a  <?php if (preg_match('/^(admin\/emails)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/emails'); ?>"><span class="glyphicon glyphicon-envelope"></span>Emails </a>
                <a  <?php if (preg_match('/^(admin\/zoom)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/zoom'); ?>"><span class="glyphicon glyphicon-hd-video"></span>Zoom Meeting </a>

                <a  <?php if (preg_match('/^(admin\/email_templates)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/email_templates'); ?>"><span class="glyphicon glyphicon-list"></span>Email Templates </a>

                <a  <?php if (preg_match('/^(admin\/newsletters)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/newsletters'); ?>"><span class="glyphicon glyphicon-file"></span>Newsletters</a>

                <a  <?php if (preg_match('/^(admin\/notice_board)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/notice_board'); ?>"><span class="glyphicon glyphicon-file"></span>Notice Board</a>

                <a  <?php if (preg_match('/^(admin\/rules_regulations)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/rules_regulations'); ?>"><span class="glyphicon glyphicon-folder-close"></span>Rules & Regulations</a>

                <a  <?php if (preg_match('/^(admin\/vistors_book)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/vistors_book'); ?>"><span class="glyphicon glyphicon-user"></span>Visitor's Book</a>
                
                 <h5 class="center"> Academics Events </h5>

                <a  <?php if (preg_match('/^(admin\/school_events)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/school_events'); ?>"><span class="glyphicon glyphicon-calendar "></span> Academics Events</a>

                <a  <?php if (preg_match('/^(admin\/events)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/events'); ?>"><span class="glyphicon glyphicon-calendar "></span> Other Events</a>

                <a  <?php if (preg_match('/^(admin\/school_events\/calendar)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/school_events/calendar'); ?>"><span class="glyphicon glyphicon-calendar "></span> Calendar View </a>


                <div class="dr"><span></span></div> 
                
                <h5 class="center"> Send Credentials  </h5>

                <a  onClick="return confirm('<?php echo 'Are you sure you want send login credentials to Teachers via SMS?';?>')" href="<?php echo base_url('admin/users/send_credential/teachers'); ?>"><span class="glyphicon glyphicon-envelope"></span> To All Teachers</a>
                
                <a onClick="return confirm('<?php echo 'Are you sure you want send login credentials to all Parents/Guardians via SMS?';?>')"  href="<?php echo base_url('admin/users/send_credential/parents'); ?>"><span class="glyphicon glyphicon-envelope"></span> To All Parents</a>
                
                <a onClick="return confirm('<?php echo 'Are you sure you want send login credentials to all Students via SMS?';?>')"  href="<?php echo base_url('admin/users/send_credential/students'); ?>"><span class="glyphicon glyphicon-envelope"></span> To All Students</a>
                
                
                <div class="dr"><span></span></div> 
                <ul class="fmenu changed">
                    <li  <?php
                        if (preg_match('/^(admin\/address_book)/i', $this->uri->uri_string()) ||
                                     (preg_match('/^(admin\/address_book_category)/i', $this->uri->uri_string()))
                        )
                                echo 'class="active"';
                    ?>>
                        <a  <?php
                    if (preg_match('/^(admin\/address_book)/i', $this->uri->uri_string()) ||
                                 (preg_match('/^(admin\/address_book_category)/i', $this->uri->uri_string()))
                    )
                            echo 'class="active"';
                    ?> href="#"><span class="glyphicon glyphicon-th"></span> Contacts Directory <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                        <ul style="display:block">
                            <li><a <?php if (preg_match('/^(admin\/address_book)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/address_book'); ?>"><span class="glyphicon glyphicon-book"></span> Address Book</a>      </li>              
                            <li><a <?php if (preg_match('/^(admin\/address_book\/customers)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/address_book/customers'); ?>"><span class="glyphicon glyphicon-thumbs-up"></span> Customers</a> </li>                   
                            <li><a <?php if (preg_match('/^(admin\/address_book\/suppliers)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/address_book/suppliers'); ?>"><span class="glyphicon glyphicon-shopping-cart"></span> Suppliers</a>   </li>                 
                            <li><a <?php if (preg_match('/^(admin\/others)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/address_book/others'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Others</a>   </li>
                            <li><a <?php if (preg_match('/^(admin\/address_book_category)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/address_book_category'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Manage Categories</a></li>
                        </ul>
                </ul>
            </div>                                                              
            <div class="dr"><span></span></div>
            <ul class="fmenu">               
                <li>
                    <a href="<?php echo base_url('admin/sms'); ?>">All SMS'</a>
                    <span class="caption blue"><?php echo $this->ion_auth->count_sms(); ?></span>
                </li>                
            </ul>
            <div class="dr"><span></span></div> 
           
            <div class="dr"><span></span></div> 
        </div>
        <div id="reports">
            <div class="menu">

                <h5 class="center" style="background:#394960; color:#fff; padding:7px;"> Students Reports  </h5>

                <a href="<?php echo base_url('admin/reports/student_report'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/student_report)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-folder-open"></span> Student History Report</a>
               

<a href="<?php echo base_url('admin/reports/school_population'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/school_population)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-list"></span> School Population Report</a>  

 <a href="<?php echo base_url('admin/reports/admission'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/admission)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-user"></span> Admission Report</a>  

                <a href="<?php echo base_url('admin/reports/activities'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/activities)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-send"></span> Extra Curricular Activities</a>    

                <h5 class="center" style="background:#394960; color:#fff; padding:7px;"> Financial Reports  </h5>


                <a href="<?php echo base_url('admin/reports/fee'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/fee)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-list-alt"></span> Fee Payment Summary</a>

                <a href="<?php echo base_url('admin/reports/fee_status'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/fee_status)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-briefcase"></span> Fee Status Report</a>   
                <a href="<?php echo base_url('admin/reports/arrears'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/arrears)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-question-sign"></span> Arrears Report</a> 
                <a href="<?php echo base_url('admin/reports/fee_extras'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/fee_extras)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-signal"></span> Fee Extras Report</a>   
                <a href="<?php echo base_url('admin/reports/all_extras'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/all_extras)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-list"></span> Fee Extras List</a>   
                <a href="<?php echo base_url('admin/reports/paid'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/paid)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-file"></span> Fee Payments Report</a>  

                    <a href="<?php echo base_url('admin/reports/detailed_paid'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/detailed_paid)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-file"></span> Detailed Fee Payments</a>


                    <a href="<?php echo base_url('admin/reports/export_waivers'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/export_waivers)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-file"></span> Fee Waivers/Discount Report</a>  


                    <a href="<?php echo base_url('admin/fee_payment/mpesa_payment_logs'); ?>" 
<?php echo (preg_match('/^(admin\/fee_payment\/mpesa_payment_logs)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-file"></span>M-Pesa Payment Logs</a>  

               <h5 class="center" style="background:#394960; color:#fff; padding:7px;"> Books of Accounts  </h5>

        

                      <!--    <a href="<?php echo base_url('admin/reports/bank_transactions'); ?>" 
                       <?php echo (preg_match('/^(admin\/reports\/bank_transactions)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                        <span class="glyphicon glyphicon-file"></span> Bank Transactions </a -->

   <a href="<?php echo base_url('admin/accounts'); ?>" 
                   <?php echo (preg_match('/^(admin\/accounts)$/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-folder-close"></span> Chart of Accounts </a>               

                <a href="<?php echo base_url('admin/reports/sales_ledger'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/sales_ledger)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-folder-open"></span> Sales/Income Ledger</a> 

                     <a href="<?php echo base_url('admin/accounts/cash_book'); ?>" 
                       <?php echo (preg_match('/^(admin\/accounts\/cash_book)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                        <span class="glyphicon glyphicon-file"></span> Cash Book </a>   


                    <a href="<?php echo base_url('admin/accounts/trial_'); ?>" 
<?php echo (preg_match('/^(admin\/accounts\/trial_)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-folder-open"></span> Trial Balance</a> 
                    
                <a href="<?php echo base_url('admin/accounts/pnl__'); ?>" 
<?php echo (preg_match('/^(admin\/accounts\/pnl__)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-file"></span> Profit and Loss</a> 

                     <a href="<?php echo base_url('admin/accounts/gl'); ?>" 
<?php echo (preg_match('/^(admin\/accounts\/gl)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-file"></span> General Ledger</a> 

                <a href="<?php echo base_url('admin/accounts/balance'); ?>" 
                   <?php echo (preg_match('/^(admin\/accounts\/balance)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-comment"></span> Balance Sheet </a> 

                    
                    
                    <h5 class="center" style="background:#394960; color:#fff; padding:7px;"> Exams Reports  </h5>   

                <a href="<?php echo base_url('admin/reports/exam'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/exam)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-folder-open"></span> Exam Results Report</a> 
                <a href="<?php echo base_url('admin/reports/joint'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/joint)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-file"></span> Joint Exam Results Report</a> 

                <a href="<?php echo base_url('admin/reports/sms_exam'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/sms_exam)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-comment"></span> SMS Exams Results </a> 

                <a href="<?php echo base_url('admin/reports/grade_analysis'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/grade_analysis)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-folder-close"></span> Grade Analysis </a>  

               <h5 class="center" style="background:#394960; color:#fff; padding:7px;"> Other Reports  </h5>    

                <a href="<?php echo base_url('admin/reports/expenses'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/expenses)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-indent-left"></span> Expenses Summary Report</a> 
                <a href="<?php echo base_url('admin/reports/expense_trend'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/expense_trend)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-indent-left"></span> Detailed  Expenses Report</a> 
                <a href="<?php echo base_url('admin/reports/wages'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/wages)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-barcode"></span> Wages Report</a> 

                <a href="<?php echo base_url('admin/reports/assets'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/assets)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-indent-right"></span> Assets Report</a> 

                <h5 class="center" style="background:#394960; color:#fff; padding:7px;"> Library Books Reports  </h5>


                <a href="<?php echo base_url('admin/reports/book_fund'); ?>" 
<?php echo (preg_match('/^(admin\/reports\/book_fund)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-book"></span> Book Fund Report</a>  


            </div>                
            <div class="dr"><span></span></div>
        </div>
        
        
        
        <div id="users">
            <div class="menu">

                <a <?php echo (preg_match('/^(admin\/employees_attendance)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/employees_attendance'); ?>"><span class="glyphicon glyphicon-time"></span> Employees Attendance</a>

                <h5 class="center"> Institution Management  </h5>


                <a <?php echo (preg_match('/^(admin\/teachers)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/teachers'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Teaching Staff</a>

                <a <?php echo (preg_match('/^(admin\/appraisal_targets)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/appraisal_targets'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Teachers Appraisal</a>

                <a <?php echo (preg_match('/^(admin\/appraisal_targets\/appraisalResults)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/appraisal_targets/appraisalResults'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Teachers Appraisal Results</a>

                <a <?php echo (preg_match('/^(admin\/non_teaching)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/non_teaching'); ?>"><span class="glyphicon glyphicon-list"></span> Non Teaching Staff</a>

                <a <?php echo (preg_match('/^(admin\/subordinate)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/subordinate'); ?>"><span class="glyphicon glyphicon-file"></span> Supporting Staff</a>

                <a <?php echo (preg_match('/^(admin\/board_members)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/board_members'); ?>"><span class="glyphicon glyphicon-file"></span> Board Members</a>

                <h5 class="center"> Parents/Students  </h5>

                <a <?php echo (preg_match('/^(admin\/parents)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/parents'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Parents</a>
                <a <?php echo (preg_match('/^(admin\/admission)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/admission'); ?>"><span class="glyphicon glyphicon-list"></span> Students</a>

                <a <?php echo (preg_match('/^(admin\/emergency_contacts)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/emergency_contacts'); ?>"><span class="glyphicon glyphicon-folder-close"></span> Emergency Contacts</a>

                <h5 class="center"> Clearance </h5>

                <a  <?php if (preg_match('/^(admin\/students_clearance)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/students_clearance'); ?>"><span class="glyphicon glyphicon-folder-close"></span> Students Clearance</a>

                <a  <?php if (preg_match('/^(admin\/staff_clearance)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/staff_clearance'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Staff Clearance</a>



                <h5 class="center"> System Users  </h5>

                <a <?php echo (preg_match('/^(admin\/users\/create)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/users/create'); ?>"><span class="glyphicon glyphicon-plus"></span> Add Staff</a>
                <a <?php echo (preg_match('/^(admin\/users)$/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/users'); ?>"><span class="glyphicon glyphicon-list"></span> List all Users</a>
                <a <?php echo (preg_match('/^(admin\/groups)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/groups'); ?>"><span class="glyphicon glyphicon-user"></span> User Groups</a>


                
            </div>
            <div class="dr"><span></span></div>
        </div>
        <div id="other">
            <div class="menu">

                <h5 class="center"> Institution Setup  </h5>

                <a <?php if (preg_match('/^(admin\/settings)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/settings'); ?>"><span class="glyphicon glyphicon-cog"></span> Settings</a>

                <a <?php if (preg_match('/^(admin\/registration_details)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/registration_details'); ?>"><span class="glyphicon glyphicon-list"></span> Registration Details</a>

                <a <?php if (preg_match('/^(admin\/ownership_details)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/ownership_details'); ?>"><span class="glyphicon glyphicon-file"></span> Ownership Details</a>

                <a <?php if (preg_match('/^(admin\/institution_docs)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/institution_docs'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Institution Documents</a>

                <a <?php if (preg_match('/^(admin\/settings\/certificate)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/settings/certificate'); ?>"><span class="glyphicon glyphicon-file"></span> Approval Certificate</a>

                <a <?php if (preg_match('/^(admin\/settings\/contact_person)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/contact_person'); ?>"><span class="glyphicon glyphicon-user"></span> Contact Person</a>


                <a <?php if (preg_match('/^(admin\/settings\/payment_options)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/payment_options'); ?>"><span class="glyphicon glyphicon-user"></span> M-Pesa Payment Options</a>




                <h5 class="center"> System Setup  </h5>
                <a  <?php if (preg_match('/^(admin\/class_groups)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/class_groups)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/class_groups'); ?>"><span class="glyphicon glyphicon-home"></span> Classes Settings</a>

                <a  <?php if (preg_match('/^(admin\/class_stream)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/class_stream'); ?>"><span class="glyphicon glyphicon-list"></span> Class Streams</a>

                <a  <?php if (preg_match('/^(admin\/class_rooms)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/class_rooms'); ?>"><span class="glyphicon glyphicon-list"></span> Class Rooms</a>

                <a  <?php if (preg_match('/^(admin\/house)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/house'); ?>"><span class="glyphicon glyphicon-home"></span> Students Houses</a>



                <a <?php if (preg_match('/^(admin\/contracts)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/contracts'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Employment Contracts</a>

                <a <?php if (preg_match('/^(admin\/departments)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/departments'); ?>"><span class="glyphicon glyphicon-home"></span> Departments</a>

                <a <?php if (preg_match('/^(admin\/clearance_departments)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/clearance_departments'); ?>"><span class="glyphicon glyphicon-list"></span> Clearance Departments</a>

                <a <?php if (preg_match('/^(admin\/counties)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/counties'); ?>"><span class="glyphicon glyphicon-list"></span> Counties</a>

                <a <?php if (preg_match('/^(admin\/subcounties)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/subcounties'); ?>"><span class="glyphicon glyphicon-list"></span> Sub Counties</a>

                <a <?php if (preg_match('/^(admin\/positions)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/positions'); ?>"><span class="glyphicon glyphicon-list"></span> Positions</a>


                <h5 class="center"> Advance Settings  </h5>
                <a  <?php if (preg_match('/^(admin\/permissions)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/permissions'); ?>"><span class="glyphicon glyphicon-lock"></span> Permissions</a>



                <a <?php if (preg_match('/^(admin\/audit_logs)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/audit_logs/'); ?>"><span class="glyphicon glyphicon-list"></span> Audit logs</a>

              

                <a href="<?php echo base_url('admin/settings/backup'); ?>"><span class="glyphicon glyphicon-download-alt"></span> Data Backup</a>
                
                <h5 class="center"> Other Settings  </h5>
                <a <?php if (preg_match('/^(admin\/shop_item)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/shop_item/'); ?>"><span class="glyphicon glyphicon-list"></span> Shop Items</a>

            </div>
            <div class="dr"><span></span><?php echo $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end'); ?> sec.</div>
        </div>   
    </div>
</div>