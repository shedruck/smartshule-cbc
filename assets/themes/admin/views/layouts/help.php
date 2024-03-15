<!doctype html>  
<!--[if IE 6 ]><html lang="en-us" class="ie6"> <![endif]-->
<!--[if IE 7 ]><html lang="en-us" class="ie7"> <![endif]-->
<!--[if IE 8 ]><html lang="en-us" class="ie8"> <![endif]-->
<!--[if (gt IE 7)|!(IE)]><!-->
<html lang="en-us"><!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title><?php echo $template['title']; ?></title>
        <meta name="description" content="">
        <meta name="author" content="Smart Shule">
        <meta name="copyright" content="Smart Shule">
        <?php echo theme_css('help/shCoreDefault.css'); ?>  
        <?php echo theme_css('help/shThemeDefault.css'); ?>  
        <?php echo theme_css('help/documenter_style.css'); ?>               
        <?php echo theme_js('help/jquery.1.6.4.js'); ?>
        <?php echo theme_js('help/jquery.scrollTo-1.4.2-min.js'); ?>
        <?php echo theme_js('help/jquery.easing.js'); ?>
        <?php echo theme_js('help/shCore.js'); ?>
        <?php echo theme_js('help/shBrushCss.js'); ?>
        <?php echo theme_js('help/shBrushXml.js'); ?>
        <?php echo theme_js('help/shBrushJScript.js'); ?>
        <script>SyntaxHighlighter.defaults['toolbar'] = false;SyntaxHighlighter.all();</script>
        <script>document.createElement('section');var duration = 500, easing = 'swing';</script>
        <?php echo theme_js('help/script.js'); ?>
        <style>		
            ::-moz-selection{background:#BBBBBB;color:#222222;}
            ::selection{background:#BBBBBB;color:#222222;}
            #documenter_sidebar #documenter_logo{background-image:url("css/img/logo.png");}
            a{color:#335A85;}
            hr{border-top: 1px solid #666; border-bottom:1px solid #FFF;}
            #documenter_sidebar, #documenter_sidebar ol a{background-color:#42536d; color:#FFF;}
            #documenter_sidebar ol a{-webkit-text-shadow:1px 1px 0px #222222;-moz-text-shadow:1px 1px 0px #222222;text-shadow:1px 1px 0px #222222;}
            #documenter_sidebar ol{}
            #documenter_sidebar ol a{border-top:1px solid #4D6383;border-bottom:1px solid #2F3F57;color:#FFF; background-color: #42536d;}
            #documenter_sidebar ol a:hover{background:#F5F5F5;color:#333;border-top:1px solid #52789E;}
            #documenter_sidebar ol a.current{background: #F5F5F5;color:#333;border-top:1px solid #52789E;}
            #documenter_sidebar ol li:last-child{border-bottom: 1px solid #143D6B;}
            #documenter_copyright{display:block !important;visibility:visible !important;}
            #documenter_copyright a{color: #fff;}
        </style>
    </head>
    <body class="ssGreen">
        <div id="documenter_sidebar">
            <a href="#intro" id="logo"> <?php echo theme_image('logo-sm.png'); ?></a>
            <ol id="documenter_nav">
                <li><a class="current" href="#intro">INTRO</a></li>
                <li><a href="#login">Login</a></li>
                <li><a href="#settings">Settings</a></li>
                <li><a href="#academics">Academics</a></li>
                <li><a href="#administration">Administration</a></li>
                <li><a href="#accounts">Accounts</a></li>
                <li><a href="#library">Library</a></li>
                <li><a href="#communication">Communication</a></li>
                <li><a href="#reports">Reports</a></li>
                <li><a href="#students_admission">Student Admission</a></li>
                <li><a href="#student_attachment">Student Attachment</a></li>
                <li><a href="#hostels1">Student Hostels</a></li>
                <li><a href="#grading_system">Grading System</a></li>
                <li><a href="#waiver1">Fee Waiver</a></li>
                <li><a href="#classatt">Class Attendance</a></li>
                <li><a href="#classgn">Class Assignments</a></li>
                <li><a href="#semevents">School Events</a></li>
                <li><a href="#feestructure">Fee Structure</a></li>
                <li><a href="#disciplinary">Discipline</a></li>
            </ol>
            <div id="documenter_copyright">&copy <?php echo date('Y'); ?> Smart Shule <br>
                made with the <a href="http://rxa.li/documenter">Documenter v1.6</a> 
            </div>
        </div>
        <div id="documenter_content">
            <section id="intro">
                <h1>Manual For Smart Shule</h1>
                <h2>School Management system</h2>
                <hr><ul> 
                    <li>By: Smart Shule</li>
                    <li><a href="http://smartshule.com">www.smartshule.com</a></li>
                    <li>Email: <a href="mailto">sales@smartshule.com</a></li>
                </ul>
            </section>
            <!----LOGIN---->
            <section id="login">
                <h3>Login Panel</h3>
                <hr class="notop">
                Below shows the Login Page<br>
                <p class="help-img"><?php echo theme_image('help/login.jpg'); ?><p>
                    You have to be authenticated to access the system. Enter your email and password and click on Login Button.<br>
                <hr />
                On successful login, the user will be redirected to the Dashboard <br>
                <p class="help-img"><?php echo theme_image('help/dashboard.jpg'); ?><p>
            </section>
            <!--End-->
            <!----Settings---->
            <section id="settings">
                <h3>Settings</h3><hr class="notop">
                Below shows the settings page<br>
                <p class="help-img"><?php echo theme_image('help/settings.jpg'); ?><p>
                    The user will be required to fill the form paying more attention to the fields marked with the red asterix(*).<br>
                    Once through, click on the "Update" button to save the form.
            </section>
            <!--End-->
            <!----Setup---->
            <section id="setup">
                <h3>Setup -<i>School Settings</i></h3><hr >
                Below shows the <i><b>School Settings </b></i>- setup page<br>
                <p class="help-img"><?php echo theme_image('help/setup1.jpg'); ?><p>
                    The user will be required to fill the form filling-in all the required fields. Once through, click on the "Update" button to save the form. Click on the <i>Next</i> button to proceed to the next page.
            </section>
            <!--End-->
            <section>
                <h3>Setup -<i>Lecturers</i></h3><hr >
                Below shows the <b>Lecturers </b>- setup page<br>
                <p class="help-img"><?php echo theme_image('help/classteachers.jpg'); ?><p>
                    The user can view, edit and add lecturer details from this page. To add a new lecturer, click on the <i>"+Add Lecturer"</i>button on the top-right corner.<br> Here is a sample page for Add Lecturers :<br>
                <p class="help-img"><?php echo theme_image('help/addteachers.jpg'); ?><p>
                    Fill-in all the fields then click on <i>Save</i>
                    Click on the <i>Next</i> button to proceed to the next page.
            </section>
            <section>
                <h3>Setup -<i>Classes</i></h3><hr >
                Below shows the <i><b>Classes</b></i>- setup page<br>
                <p class="help-img"><?php echo theme_image('help/classes.jpg'); ?><p>
                    The user can view, edit and add streams to classes from this page<br>
                    To add a new class-stream, click on the <i>"+Add Streams"</i> button next to the class you want to add the streams to.<br>
                    This page will open<br>
                <p class="help-img"><?php echo theme_image('help/streams.jpg'); ?><p>
                    Add the number of streams you want by clicking on the <i>Add</i> button, follow the prompts then click on<i>Save</i>
                    Click on the <i>Next</i> button to proceed to the next page.
            </section>
            <!--End-->
            <section>
                <h3>Setup -<i>Units</i></h3><hr >
                Below shows the <i><b>Units</b></i>- setup page<br>
                From this page, the user can create a unit as well as view, edit, remove and add a class to it.<br>
                <p class="help-img"><?php echo theme_image('help/subjects.jpg'); ?> <p>
                    To add a new unit, click on the <i>"+Add New Unit"</i>button on the top-right corner.<br>
                    This page will open<br>
                <p class="help-img"><?php echo theme_image('help/addsubject.jpg'); ?><p>
                    Fill-in the Title, Short Name and the rest of the details then click on Save<br>
                    To attach a unit to a course, click on the <i>"Add To Course"</i>button under the Options column.<br>
                    This page will open<br>
                <p class="help-img"><?php echo theme_image('help/addclasssubject.jpg'); ?><p>
                    Click on a class then select the arrow facing the adjacent box to drag it to the other side then click on <i>Update</i><br>
                    Click on the <i>Next</i> button to proceed to the next page.
            </section>
            <!--End-->
            <section id="academics">
                <h3>Academics</h3><hr class="notop">
                The Academics section page gives a general view of payments and any pending pledges if available. A sample page is displayed below and its divided into several sections:<br>
                <p class="help-img"><?php echo theme_image('help/academics.jpg'); ?><p>
                    Here are the sub-menus found under the academics section:<br><br>
                <h4>Classes</h4>
                The Classes section displays the created classes, courses, start and end dates, fee waiver and the number of registered students. The 'Action' button allows the administrator to view, edit or add more students to the selected class.<br> Here is a sample Classes page:<br>
                <p class="help-img"><?php echo theme_image('help/classes.jpg'); ?><p>
                <h4>Courses</h4>
                The Courses section displays the created courses allowing the administrator to add a venue/class where the course will be taught by clicking on the 'Add Class' button. to edit the course details, click on the 'Edit' button. To add a new course, click on the 'Add Courses' button, fill in all the fields and click on "Save" button. Here is a sample Courses page:<br>
                <p class="help-img"><?php echo theme_image('help/courses.jpg'); ?><p>
                <h4>Units</h4>
                The Units section displays the created units allowing the administrator to add it to an existing course by clicking on the 'Add To Course' button. To edit a unit, click on the 'Edit Details' button. To add a new unit, click on the 'Add New Unit' button, fill in all the fields and click on "Save" button. Here is a sample Units page:<br>
                <p class="help-img"><?php echo theme_image('help/units.jpg'); ?><p>
                <h4>Class Rooms</h4>
                The Class Rooms section displays the available class rooms which can always be edited by the administrator by clicking on the 'Edit' button. Here is a sample Class Rooms page:<br>
                <p class="help-img"><?php echo theme_image('help/classrooms.jpg'); ?><p>
                    To add a new class room, click on the 'Add Class Room' button, fill in all the fields and click on "Save" button. Here is a sample Add Class Rooms page:<br>
                <p class="help-img"><?php echo theme_image('help/addclass.jpg'); ?><p>
                <h4>Exam Type</h4>
                The Exam Type section displays any existing type of exams currently being offered at the institution - created by the administrator, to edit an entry, click on the 'Edit' button, make your changes then click on the 'Save' button to save and exit. To add an exam type, click on the 'Add Exam Types' button, fill in all the fields and click on "Save" button. Here is a sample Add Exam Type page:<br>
                <p class="help-img"><?php echo theme_image('help/examtype.jpg'); ?><p>
                <h4>Exams</h4>
                The Exams section displays dates for exams (Main Exams) and continuous assessment tests (CATs) to be done in the course of the semester. The administrator can make changes to the dates by clicking on the 'Edit Details' button, click on the 'Save' button once through to save and exit. To add exams, click on the 'Add Exams' button, fill in all the fields and click on "Save" button. Here is a sample Exams page:<br>
                <p class="help-img"><?php echo theme_image('help/exams.jpg'); ?><p>
                <h4 id="examgt">Exam Management</h4>
                The Exam Management section displays all the pending and past exams start and end dates, the number of students expected to sit for them and an option to record their marks and view the results instantly by clicking on the respective buttons under the 'Options' column. Here is a sample Exam Management page:<br>
                <p class="help-img"><?php echo theme_image('help/examgt.jpg'); ?><p>
                <h4 id="examttm">Exam Timetable</h4>
                Below shows the <b>Exams Timetable</b> section<br>
                <p class="help-img"><?php echo theme_image('help/examtt1.jpg'); ?><p>
                    From this page, a user can create a new exam timetable by clicking on the "+Add New Timetable" button then filling all the fields accordingly. Once through, click on Save. <br>Here is a sample of the page:<br>
                <p class="help-img"><?php echo theme_image('help/examtt.jpg'); ?><p>
                    To get a more detailed view of an exam timetable, click on the "View Timetable" button, under the "Options" column, the page that opens will indicate whether an exam has already been done or not. A sample page is displayed below:<br>
                <p class="help-img"><?php echo theme_image('help/viewtt.jpg'); ?><p>
                <h4>Class Timetable</h4>
                Below shows the <b>Class Timetable</b> section<br>
                <p class="help-img"><?php echo theme_image('help/classtt.jpg'); ?><p>
                    The page displays all the available class timetables created by the administrator. To create a new timetable, click on the "+Add New Class Timetable" button, choose the School Calender/Semester, Class, Day of the Week, Units, the Time and the Lecturer. To add another day/timeslot, click on the "Add New Line" button, fill-in the details as previous then click on "Bulk Save" to save and exit. Here is a sample of the page:<br>
                <p class="help-img"><?php echo theme_image('help/addclasstt.jpg'); ?><p>
                    To view existing or created timetables, click on the "Full Timetable" button, under the "Options" column.<br> A sample page is displayed below:<br>
                <p class="help-img"><?php echo theme_image('help/viewclasstt.jpg'); ?><p>
                <h4>Semester Calendar</h4>
                The Semester Calendar section displays a brief outlook of the entire semester. It shows opening and closing dates for each semester which is set by the administrator in collaboration with the institutions management. The entries can be edited by clicking on the 'Edit' button adjacent to the semester, make the required changes then click on 'Save'.<br> Here is a sample Semester Calendar page:<br>
                <p class="help-img"><?php echo theme_image('help/semcalendar.jpg'); ?><p>
                <h4 id="classatt">Class Attendance</h4>
                Below shows the <b>Class Attendance</b> section<br>
                <p class="help-img"><?php echo theme_image('help/classattendance.jpg'); ?><p>
                    The page displays the classes available, the number of registered students per class and an option to view the class attendance list as well as being able to mark the register for a particular day - this can be achieved by clicking on the "+New Attendance" button.<br>Here is a sample of the page:<br>
                <p class="help-img"><?php echo theme_image('help/classreg.jpg'); ?><p>
                    Once the attendance register has been marked, click on the "Bulk Save" button to save and exit. To view the register, click on the "View Attendance" button corresponding to the class you want to view. The sample marked register looks like this :<br>
                <p class="help-img"><?php echo theme_image('help/register.jpg'); ?><p>
                <h4 id="grading_system">Grading System</h4>
                Below shows the <b>Grading System</b><br>
                This page displays all the set grading systems to be used by the school during a term/year. The system can be internal or external (KNEC) or both. The entries can be edited at anytime or even deleted by clicking on the corresponding buttons. Here is a sample of the page:<br>
                <p class="help-img"><?php echo theme_image('help/gradingsys1.jpg'); ?><p>
                    To add a new grading system, click on the "+Add Grading System" button, enter the Title and the required Pass Mark and a brief description. Click on "Save" button to save and exit.<br>
                    A sample page for adding a new grading system looks like this:<br>
                <p class="help-img"><?php echo theme_image('help/addgradingsys1.jpg'); ?><p>
                <h4>Grading</h4>
                Below shows the <b>Grading</b><br>
                <p class="help-img"><?php echo theme_image('help/grading.jpg'); ?><p>
                    From here, the user can view the existing grading systems if any, and be able to make changes whenever necessary. By clicking on the "View Grades" button, the user can view the grade ranges from each grading system which could also be deleted by clicking on the "Move to Trash" button. A sample page for the View Grades looks like this:<br>
                <p class="help-img"><?php echo theme_image('help/gradingsys.jpg'); ?><p>
                    To add a new grading system, click on the "+Add Grading System" button and fill-in all fields specifying the ranges for the new grades. Click on "Save" button to save and exit.<br>
                    A sample page for adding a new grading system looks like this:<br>
                <p class="help-img"><?php echo theme_image('help/addgradsys.jpg'); ?><p>
                <h4 id="classgn">Assignments</h4>
                Below shows the <b>Assignments</b> section<br>
                <p class="help-img"><?php echo theme_image('help/assignment.jpg'); ?><p>
                    This page allows the lecturers to post assignments for their students easily by clicking on the "+Add Assignment" button, filling-in its duration, selecting the target classes, attaching the actual assignment if any then adding a brief description and comment just to ensure everyone will be able to understand what is required. The target group/classes will in-turn login to their accounts and be able to download and do the assignment thus improving efficiency and encouraging a paperless environment.
            </section>
            <section id="administration">
                <h3>Administration</h3><hr class="notop">
                The Administration section page gives a general view of payments and any pending pledges if available. A sample page is displayed below and its divided into several sections:<br>
                <p class="help-img"><?php echo theme_image('help/administration.jpg'); ?><p>
                    Here are the sub-menus found under the administration section:<br><br>
                <h4>Students Admission</h4>
                Below shows the <i><b>Student Admissions </b></i>page<br>
                <p class="help-img"><?php echo theme_image('help/admissioncole.jpg'); ?><p>
                    The page displays a list of all the students admitted by the school, the parents names, phone numbers and their email addresses. Under the "Options" column, the administrator can click on the "Profile" button to see more details about a particular student, "Edit" to make changes to the student profile or "Suspend" to suspend the student for a period.<br>Here is how a student profile page looks like when clicked:<br>
                <p class="help-img"><?php echo theme_image('help/viewstudent.jpg'); ?><p>
                    To add a new student to the system, click on "+New Admission" button, fill-in all the details then click on "Next".<br>
                <p class="help-img"><?php echo theme_image('help/addnewstudent.jpg'); ?><p>
                    This next page is where parent details are entered. Choose whether it's an existing or new parent, fill-in the other details then click on "Next".<br>
                <p class="help-img"><?php echo theme_image('help/parentdetails.jpg'); ?><p>
                    The next and the final stage of the admission process allows the user/administrator to assign the new student a class, an admission number and a "House" they will belong to. Click on "Submit" to save and exit.<br>
                <p class="help-img"><?php echo theme_image('help/registrationdetails.jpg'); ?><p>
                <h4>Extra Curricular Activities</h4>
                Below shows the Extra Curricular Activities section. The page displays all the students who are engaged in the different extra-curricular activities offered by the institution.<br>
                <p class="help-img"><?php echo theme_image('help/extracurricular.jpg'); ?><p>
                    To add a student to an activity, click on the "+Add Student To Activity" button, fill-in the details then click on the "Save" button to save and exit.
                <h4 id="hostels1">Hostels/Dormitories</h4>
                The Hostels/Dormitories section allows the administrator to manage hostels owned by the school. To add one, under the 'Manage Hostels' sub-menu, click on '+Add Hostels' button, fill-in the form then click on the 'Save' button once through. A sample page for adding hostels is displayed below:<br>
                <p class="help-img"><?php echo theme_image('help/addhostel.jpg'); ?><p>
                    The 'Manage Hostel Rooms' sub-menu enables the admin to add hostel rooms, assign names to them and add a brief description about each. This is done by clicking on the '+Add Hostel Rooms' button then filling-in the fields of the form that opens. Click on 'Save' once through. Here is a sample page :<br>
                <p class="help-img"><?php echo theme_image('help/addhostelroom.jpg'); ?><p>
                    The 'Manage Hostel Beds' sub-menu enables the admin to add hostel beds, by assigning them to specific hostels and giving them unique bed numbers for easy tracking in the future. This is done by clicking on the '+Add Hostel Bed' button then filling-in the fields of the form that opens.  Click on 'Save' once through. Here is a sample page :<br>
                <p class="help-img"><?php echo theme_image('help/managehostelbed.jpg'); ?><p>
                    The 'Assign Bed' sub-menu enables the admin to assign beds to specific students as the system captures the date the bed was assigned, the students name, school calendar year and any other relevant comment. This is done by clicking on the '+Assign Bed' button then filling-in the fields of the form that opens.  Click on 'Save' once through. Here is a sample page :<br>
                <p class="help-img"><?php echo theme_image('help/assignbed.jpg'); ?><p>
                <h4 id="disciplinary">Discipline</h4>
                Below shows the Disciplinary section. <br>
                The page displays all the students who are on a disciplinary-watch, what they did and the reason behind being disciplined by the school.<br>
                <p class="help-img"><?php echo theme_image('help/discipline.jpg'); ?><p>
                    By clicking on the "Action" button, the user can view, edit, take action or delete the disciplinary record against a student. To add a new disciplinary case, click on the "+Add New Disciplinary", fill-in the details then click on "Save". Here is a sample page for Add Disciplinary :<br>
                <p class="help-img"><?php echo theme_image('help/adddiscipline.jpg'); ?><p>
            </section>
            <section id="accounts">
                <h3>Accounts</h3><hr class="notop">
                The Accounts section page gives a general view of payments and any pending pledges if available. A sample page is displayed below and its divided into several sections:<br>
                <p class="help-img"><?php echo theme_image('help/academics.jpg'); ?><p>
                    Here are the sub-menus found under the Accounts - Financial Management section:<br><br>
                <h4>Fee Payment Status</h4>
                This section allows the admin view all the fee payments done during a specified period. It displays any fee balances due and an option to send reminders to students concerning the same. A fee statement for each student can easily be generated by clicking on the 'Statement' button, under the 'Options' column.<br> Here are sample pages:<br>
                <p class="help-img"><?php echo theme_image('help/feepaymentstatus.jpg'); ?><p>
                <p class="help-img"><?php echo theme_image('help/viewstatement.jpg'); ?><p>
                <h4>Payments List</h4>
                This section displays the payments deposited in the institutions bank account. It captures the student names, date of the payment as well as the payment method which in this case could have been via M-Pesa or directly at the bank and issued with a bank slip. Once the payment is reflected on the institution's database, the administrator has the option of printing or will be able to print a receipt which is automatically generated by the system.<br> Here are sample pages:<br>
                <p class="help-img"><?php echo theme_image('help/feepayment.jpg'); ?><p>
                <p class="help-img"><?php echo theme_image('help/viewreceipt.jpg'); ?><p>
                <h4>Receive Payment</h4>
                This section allows the administrator record the payments that were received during a semester. The administrator is able to select the student from the database, record the payment date, amount paid, payment method, transaction number, the bank account debited and a brief description of the payment. Once this is completed, click on the 'Save' button to save and exit. To add another transaction, click on the'Add New Line' button, fill-in the details as previous. Here is a sample page:<br>
                <p class="help-img"><?php echo theme_image('help/feepayment1.jpg'); ?><p>
                <h4 id="waiver1">Fee Waiver</h4>
                <p class="help-img"><?php echo theme_image('help/feewaiver1.jpg'); ?><p>
                    In this section, the user is able to view all the students who have fee waivers whereby they can be edited or deleted.<br>
                    To add more fee waivers, click on "+Add Fee Waiver" button on top of the section, this page will open, allowing the user to select an existing student, choose the waiver amount, the semester and the year for the waiver. Here is a sample page:<br>
                <p class="help-img"><?php echo theme_image('help/addwaiver.jpg'); ?><p>
                <h4>Fee Pledges</h4>
                <p class="help-img"><?php echo theme_image('help/feepledges.jpg'); ?><p>
                    This page displays all the students/parents who have pledges pending and those who have met the pledges. The "Action" button on the far right corner allows the user to edit the pledges as well as send reminders to the parents. To add a new pledge, click on "+Add Fee Pledge" button, fill-in all the necessary fields and click on the "Save" button<br>
                <p class="help-img"><?php echo theme_image('help/addpledge.jpg'); ?><p>
                    Here are the sub-menus found under the Accounts - Regular/Short Courses section:<br><br>
                <h4 id="feestructure">Fee Structure</h4>
                <p class="help-img"><?php echo theme_image('help/feestruct1.jpg'); ?><p>
                    This page displays the existing courses with their corresponding fee structures defined. To view the amount set for each level, click on the "Action" button and select "View Structure". A sample of the viewed fee structure will look like this:<br>
                <p class="help-img"><?php echo theme_image('help/viewstructure.jpg'); ?><p>
                    To add a new fee structure, click on the "+Add New Fee Structure" button on top of the section. This opens the following page: <br>
                <p class="help-img"><?php echo theme_image('help/addfeestructure.jpg'); ?><p>
                    Fill-in all the fields and click on "Save" button once through.
                <h4>Fee Extras</h4>
                <p class="help-img"><?php echo theme_image('help/feextra1.jpg'); ?><p>
                    This page displays all the students who have paid for extras i.e. in addition to the basic tution fee, they could have paid for transport, swimming, lunch, hostel fees e.t.c as well. To check more details on a specific student, click on the "Profile" button next to the student name under the "options" column. Here is a sample page:<br>
                <p class="help-img"><?php echo theme_image('help/extras.jpg'); ?><p>
                <h4>Accounts - Expenses</h4>
                This page displays all the expenses incurred during a specified period allowing the user to edit the entries or by marking them as "Void".<br>
                To view all the voided expenses, click on the "Voided Expenses" button on top of the section. 
                <p class="help-img"><?php echo theme_image('help/expenses.jpg'); ?><p>
                    To add a new expense, click on "+Add Expense" button, add the name of the expense, select the category, enter the expense details then click on "Save" to save and exit. Here is a sample page: <br>
                <p class="help-img"><?php echo theme_image('help/addexpense.jpg'); ?><p>
                <h4>Accounts - Petty Cash</h4>
                This page displays all the petty cash transactions incurred during a specified period allowing the user to edit the entries where applicable.<br>
                <p class="help-img"><?php echo theme_image('help/pettycash.jpg'); ?><p>
                    To edit a petty cash entry, click on the "Edit" button, change the fields you want edited then click on "Update". 
                <p class="help-img"><?php echo theme_image('help/editpettycash.jpg'); ?><p>
                    To add a new petty cash entry, click on "+Add Petty Cash" button, fill-in all the details then click on "Save" to save and exit. Here is a sample page: <br>
                <p class="help-img"><?php echo theme_image('help/addpettycash.jpg'); ?><p>
                <h4>Accounts - Purchase Orders</h4>
                This page displays all the purchase orders that are pending, the user can be able to View, Make Payment or make a transaction "Void" simply by clicking on the required button.<br>
                <p class="help-img"><?php echo theme_image('help/purchaseorders.jpg'); ?><p>
                    When the user clicks on the "Make Payment" button, a sample page like this one is displayed . 
                <p class="help-img"><?php echo theme_image('help/makepayment.jpg'); ?><p>
                    From the above example, the user is able to enter the date of the payment, the amount paid and the transaction method used after which the pending amount will be adjusted once the "Save" button is clicked. This method enables easy tracking of all the purchase transactions in a given period.<br> 
                    To add a new purchase order, click on "+New Order" button, fill-in all the details then click on "Save" to save and exit. Here is a sample page: <br>
                <p class="help-img"><?php echo theme_image('help/newpurchase.jpg'); ?><p>
                <h4>Accounts - Bank Accounts</h4>
                <p class="help-img"><?php echo theme_image('help/bankaccounts.jpg'); ?><p>
                    This page displays the bank account details for the school,to edit the details, click on the "Edit" button, do your changes then click on "Save" button to save and exit. Here is a sample for the page:<br>
                <p class="help-img"><?php echo theme_image('help/editbankacc.jpg'); ?><p>
                    To add a new bank account, click on "+Add Bank Accounts" button, fill-in all the necessary fields and click on the "Save" button<br>
                <p class="help-img"><?php echo theme_image('help/newbankacc.jpg'); ?><p>
                <h4>Accounts - Tax Config</h4>	
                This page displays the set tax values(if any) and allows the user to re-adjust them whenever necessary by clicking on the "Edit" button, key-in the new values then click on "Update" button to save and exit.<br>
                <p class="help-img"><?php echo theme_image('help/tax.jpg'); ?><p>
                    To add new tax values, click on "+Add Tax Config" button, enter the type of tax plus its percentage and click on the "Save" button<br>
                <p class="help-img"><?php echo theme_image('help/newtax.jpg'); ?><p>
                <h4>Accounts - Payrolls Management - Salaries</h4>	
                <p class="help-img"><?php echo theme_image('help/salary.jpg'); ?><p>
                    This page displays all the employees on the payroll, displaying all their details which the user can edit at anytime by clicking on the "Action" button and making the appropriate changes.<br>
                    To add an employee to the payroll, click on the "+Add Employee to Salary" button and fill-in the details, once through, click on "Save".<br>
                    Here is a sample of the page:<br>
                <p class="help-img"><?php echo theme_image('help/addemployeetosalary.jpg'); ?><p>
                <h4>Accounts - Payrolls Management - Process Salaries</h4>
                <p class="help-img"><?php echo theme_image('help/processalaries.jpg'); ?><p>
                    This page allows the user to process the salaries of all the employees on the payroll. It allows the user to view a list of all the paid employees thus eliminating a scenario of double payments. By clicking on the "ViewPaid Employees" button, a list is generated, giving a details of each payment. Here is a sample page:<br>
                <p class="help-img"><?php echo theme_image('help/viewpaidsalary.jpg'); ?><p>
                    "Pay Slip" button generates a pay slip which can printed. Here is a sample pay slip:<br>
                <p class="help-img"><?php echo theme_image('help/payslip.jpg'); ?><p>
                    To process a new salary, click on the "+Process Salary" button, fill-in all the details then click on the "Process" button. A sample page is displayed below.<br>
                <p class="help-img"><?php echo theme_image('help/processalarynew.jpg'); ?><p>
                <h4>Accounts - Payrolls Management - Advance Salaries</h4>
                <p class="help-img"><?php echo theme_image('help/advancesalo.jpg'); ?><p>
                    This page displays all the employees who took an advance on their salaries which will be deducted and reflected in the final payslip.<br>
                    To add an employee to the advance salary list, click on the "+Add Advance Salary" button and fill-in the details, then click on "Save".<br>	
                <h4>Accounts - Payrolls Management - Deductions</h4>
                <p class="help-img"><?php echo theme_image('help/deductions.jpg'); ?><p>
                    This page displays all the deductions made to the basic salary, for example, NSSF contributions, Tax, PAYE e.t.c. These deductions can later be re-adjusted accordingly by clicking on the "Edit" button or deleting the entry alltogether by clicking on the "Trash" button.<br>
                    To add more deductions, click on the "+Add Deductions" button and fill-in the details, then click on "Save".<br>
                <h4>Accounts - Payrolls Management - Allowances</h4>
                <p class="help-img"><?php echo theme_image('help/allowances.jpg'); ?><p>
                    This page displays all the allowances the employees enjoy, for example, house, hardship, travelling e.t.c. These allowances can later be re-adjusted accordingly by clicking on the "Edit" button or deleting the entry alltogether by clicking on the "Trash" button.<br>
                    To add more allowances, click on the "+Add Advances" button and fill-in the details, then click on "Save".<br>
                <h4>Accounts - Inventory Management </h4>
                <p class="help-img"><?php echo theme_image('help/inventorymgt.jpg'); ?><p>
                    This section allows the user to look at the school Inventory Trends by looking at the items/assets currently available. The assets can be categorized in specific groups depending on the type then edited whenever necessary. In cases where there is a new stock to be added, click on the "+Add Stock" button, fill-in all the fields then click on "Save".<br>
                    A sample Add Stock page is displayed below:<br>
                <p class="help-img"><?php echo theme_image('help/addstock.jpg'); ?><p>
                    Once the stock arrives, the user can take stock by recording each item into the system by clicking on the "+Take Stock" button. Fill-in all the fields then click on "Save" to save and exit.<br>
                    A sample page looks like this: <br>
                <p class="help-img"><?php echo theme_image('help/takestock.jpg'); ?><p>
                <h4>Accounts - Book of Accounts </h4>
                <p class="help-img"><?php echo theme_image('help/chartofacc.jpg'); ?><p>
                    The Chat of Accounts section gives a summary of all the transactions carried out during a financial year. The user is also able to break-down the transactions in easier to understand formats by the use of the Trial Balance, Balance Sheet and Profit & Loss by clicking on each.<br>
            </section>
            <section id="library">
                <h3>Library</h3><hr class="notop">
                The Library section allows the administrator/librarian track and manage all the books in the library. The system allows students to borrow books as well as fining those who return them late or loose them. The system also allows the administrator to adjust the amount of fine to be paid as well as the number of books allowed to be borrowed by a student at any given time.<br>
                Here are the sub-menus found under the library section:<br><br>
                <h4>Borrow Book</h4>
                This section allows the administrator issue books to a student provided the book is available. Click on the '+Borrow Book' button, fill-in the particulars then click on the 'Save' button. Incase the student wants to borrow more than one book, click on the 'Add New Line' button, fill-in the details then click on 'Save' to exit.<br>     
                A sample page looks like this: <br>
                <p class="help-img"><?php echo theme_image('help/borrowbook.jpg'); ?><p>
                <h4>Return Book</h4>
                This section displays all the books that are currently borrowed by students. For the administrator/librarian to receive a returned book, click on the '+Return Book' button, select the student, check-in the books returned, calculate the fine where applicable then click on 'Update Changes' to save and exit.<br>     
                A sample page looks like this: <br>
                <p class="help-img"><?php echo theme_image('help/returnbook.jpg'); ?><p>
                <h4>Books</h4>
                This section displays all the books that are currently in the school's database. To add a book, click on the '+Add Books' button, fill-in the form that opens then click on either 'Save and Exit' or 'Save and Add Stock' to continue adding more books. A sample page looks like this: <br>
                <p class="help-img"><?php echo theme_image('help/addbooks.jpg'); ?><p>
                    Once through, click on the 'Manage Books Stock' to capture the quantity of each book which will help the administrator/librarian know if there will be need to replenish the stock of a particular book(s).<br>
                <h4>Books Category</h4>
                This section allows the administrator/librarian categorize the books by genre/subject thus improving overall the search process. Enter the name of the book and a brief description then click on 'Save' button to save and exit. A sample page looks like this: <br>
                <p class="help-img"><?php echo theme_image('help/bookcategory.jpg'); ?><p>
                <h4>Library Settings</h4>
                This section allows the administrator/librarian to adjust the fine, the duration a student has once a book is borrowed and the number of books a student can be allowed to borrow.  A sample page looks like this: <br>
                <p class="help-img"><?php echo theme_image('help/libsettings.jpg'); ?><p>
                <section id="communication">
                    <h3>Communication</h3><hr class="notop">
                    The Communication section enables the school communicate easily with its stakeholders either via emails or text messaging. The school can send meeting, fee waiver, results and payments reminders to both students and parents/guardians easily by the click of a button.<br>
                    Here are the sub-menus found under the library section:<br><br>
                    <h4>SMS Messaging</h4>
                    <p class="help-img"><?php echo theme_image('help/smsmsg.jpg'); ?><p>
                        This page allows the user to compose and send text messages to the people on the school's mailing list, they may include parents, staff, students e.tc. The messages are stored on the database until they are manually deleted by the administrator.
                    <h4 id="semevents">Semester Events</h4>
                    <p class="help-img"><?php echo theme_image('help/schoolevents.jpg'); ?><p>
                        This page displays all the events the school plans to have during a semester. The events can be edited by clicking on the "Edit Details" button or deleted by clicking on the "Trash" button. To look at the full calendar, click on the "Full Calendar" menu, browse through the months and mark the days accordingly.<br><br>
                        To add a new event, simply click on the "+Add New Event" button, fill-in all the fields then click on Save. Here is a sample Add Event page:<br>
                    <p class="help-img"><?php echo theme_image('help/addevent.jpg'); ?><p>
                    <h4>Full Calendar</h4>
                    <p class="help-img"><?php echo theme_image('help/calendar.jpg'); ?><p>
                        From here, the administrator can schedule the school events for the whole semester/year by editing the existing entries or by creating a new schedule altogether by clicking on the "+Add New Calendar" button. Fill-in the details not forgetting to add a brief description then click on "Save".<br>
                        A sample page for the Add new Calendar looks like this:<br>
                    <p class="help-img"><?php echo theme_image('help/nucalendar.jpg'); ?><p>
                    <h4>Contacts Directory</h4>
                    <p class="help-img"><?php echo theme_image('help/contactsdir.jpg'); ?><p>
                        This page allows the administrator to create a contact list that the school will be using to pass any form of communication. The names can be put/saved in categories/groups to shorten the amount of time spent in searching for names one-by-one. The list can always be modified whenever necessary by selecting the name, clicking on "Edit", make your changes then click on "Update" to save the changes.
                    <section id="reports">
                        <h3>Reports</h3><hr class="notop">
                        The Communication section enables the school communicate easily with its stakeholders either via emails or text messaging. The school can send meeting, fee waiver, results and payments reminders to both students and parents/guardians easily by the click of a button.<br>
                        Here are the sub-menus found under the library section:<br><br>
                        <h4>Fee Payment Summary</h4>
                        When clicked, a Fee Status report is generated for the whole school year for all the classes. The report can also be generated on a per-semester basis by clicking on the drop-down menu and selecting the semester and year then clicking on the "View Report" button.<br>
                        <p class="help-img"><?php echo theme_image('help/feestatusreport1.jpg'); ?><p>
                            The parent can be contacted on a pending fee balance by clicking on the "SMS Parents With Balance" button. A text message will be sent on the parents phone reminding them of the exact balance due.
                        <h4>Campus Summaries</h4>
                        This section displays a summary of student admissions per branch. The data provided on this page allows the management be able to make decisions on matters like budgeting, resource allocation, expansion etc. A sample page looks like this:<br>
                        <p class="help-img"><?php echo theme_image('help/campusummary.jpg'); ?><p>
                        <h4>Expenses Report</h4>
                        When clicked, a Expenses Report is generated displaying all the expenses incurred during a certain period.<br>
                        <p class="help-img"><?php echo theme_image('help/expensesreport1.jpg'); ?><p>
                            To get a detailed view of a specific expense, click on "View Trend" under the Options column, this will take you back to the <i>Accounts - Expenses</i> section where the user can either edit or delete the entry. Here is a sample page that opens:<br>
                        <p class="help-img"><?php echo theme_image('help/viewtrend1.jpg'); ?><p>
                        <h4>Wages Report</h4>
                        When clicked, a Wages/Salary Report is generated which gives the total amount of money paid out to school employees/lectures during a certain period. It also shows who did the payment and the number of employees and lecturers who got their pay-checks.<br>
                        <p class="help-img"><?php echo theme_image('help/wagesreport1.jpg'); ?><p>
                        <h4>Assets Report</h4>
                        <b>Assets Report</b> - Displays all the assets owned by the school plus their values.<br>
                        <b>Fee Extras Report</b> - This page displays all the students who have paid for extras i.e. in addition to the basic tution fee, they could have paid for transport, swimming, lunch, hostel fees e.t.c as well.<br>
                        <p class="help-img"><?php echo theme_image('help/feextrareport1.jpg'); ?><p>
                            <!----Students Admission---->      
                        <section id="students_admission">
                            <h3>Students Admission</h3><hr class="notop">
                            Below shows the <i><b>Student Admissions </b></i>page<br>
                            <p class="help-img"><?php echo theme_image('help/admission.jpg'); ?><p>
                                The page displays a list of all the students admitted by the school, the parents names, phone numbers and their email addresses. Under the "Options" column, the administrator can click on the "Profile" button to see more details about a particular student, "Edit" to make changes to the student profile or "Suspend" to suspend the student for a period.<br>Here is how a student profile page looks like when clicked:<br>
                            <p class="help-img"><?php echo theme_image('help/viewstudent.jpg'); ?><p>
                                To add a new student to the system, click on "+New Admission" button, fill-in all the details then click on "Next".<br>
                            <p class="help-img"><?php echo theme_image('help/addnewstudent.jpg'); ?><p>
                                This next page is where parent details are entered. Choose whether it's an existing or new parent, fill-in the other details then click on "Next".<br>
                            <p class="help-img"><?php echo theme_image('help/parentdetails.jpg'); ?><p>
                                The next and the final stage of the admission process allows the user/administrator to assign the new student a class, an admission number and a "House" they will belong to. Click on "Submit" to save and exit.<br>
                            <p class="help-img"><?php echo theme_image('help/registrationdetails.jpg'); ?><p>
                        </section>
                        <!----End---->
                        <section id="grading_system">
                            <h3></h3><hr class="notop">
                        </section>
                        <section id="grades">                            
                        </section>
                        <section id="exams_mngmnt">
                            <hr class="notop">  
                        </section>    
                        </div>  
                        </body>
                        </html>
