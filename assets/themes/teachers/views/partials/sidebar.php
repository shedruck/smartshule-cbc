<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="index.html" class="header-logo">
            <img src="<?php echo base_url('assets/themes/teachers') ?>/images/brand/desktop-logo.png" alt="logo" class="desktop-logo">
            <img src="<?php echo base_url('assets/themes/teachers') ?>/images/brand/toggle-logo.png" alt="logo" class="toggle-logo">
            <img src="<?php echo base_url('assets/themes/teachers') ?>/images/brand/desktop-dark.png" alt="logo" class="desktop-dark">
            <img src="<?php echo base_url('assets/themes/teachers') ?>/images/brand/toggle-dark.png" alt="logo" class="toggle-dark">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Main</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide <?php echo $this->uri->segment(1) === "trs" ? 'active' : '';  ?>">
                    <a href="<?php echo base_url('trs') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "trs" ? 'active' : '';  ?>">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M12 5.69l5 4.5V18h-2v-6H9v6H7v-7.81l5-4.5M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3z" />
                    </svg> -->
                        <i class="fa fa-home side-menu__icon"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <!-- End::slide -->

                <li class="slide__category"><span class="category-name">CLASSES & STUDENTS</span></li>
                <li class="slide <?php echo $this->uri->segment(1) === "class_groups" ? 'active' : '';  ?>">
                    <a href="<?php echo base_url('class_groups/trs/myclasses') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "class_groups" ? 'active' : '';  ?>">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 -960 960 960" fill="#000000">
                        <path d="M679-466 466-679l213-213 213 213-213 213Zm-559-72v-301h301v301H120Zm418 418v-301h301v301H538Zm-418 0v-301h301v301H120Zm60-478h181v-181H180v181Zm502 51 129-129-129-129-129 129 129 129Zm-84 367h181v-181H598v181Zm-418 0h181v-181H180v181Zm181-418Zm192-78ZM361-361Zm237 0Z" />
                    </svg> -->
                        <i class="fa fa-bars side-menu__icon"></i>
                        <span class="side-menu__label">My Classes</span>
                    </a>
                </li>
                <li class="slide <?php echo $this->uri->segment(1) === "class_attendance" ? 'active' : '';  ?>">
                    <a href="<?php echo base_url('class_attendance/trs/list') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "class_attendance" ? 'active' : '';  ?>">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 -960 960 960" fill="#000000">
                        <path d="M679-466 466-679l213-213 213 213-213 213Zm-559-72v-301h301v301H120Zm418 418v-301h301v301H538Zm-418 0v-301h301v301H120Zm60-478h181v-181H180v181Zm502 51 129-129-129-129-129 129 129 129Zm-84 367h181v-181H598v181Zm-418 0h181v-181H180v181Zm181-418Zm192-78ZM361-361Zm237 0Z" />
                    </svg> -->
                        <i class="fa fa-calendar side-menu__icon"></i>
                        <span class="side-menu__label">Roll Call</span>
                    </a>
                </li>


                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">PAGES</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <?php
                $set = array('assignments', 'qa', 'mc', 'cbc', 'students_projects', 'diary');
                ?>
                <li class="slide has-sub <?php echo in_array($this->uri->segment(1), $set) ? 'active open' : ''; ?>">
                    <a href="javascript:void(0);" class="side-menu__item <?php echo in_array($this->uri->segment(1), $set) ? 'active' : ''; ?>">

                        <i class="fa fa-graduation-cap side-menu__icon"></i>
                        <span class="side-menu__label">Academics</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 <?php echo in_array($this->uri->segment(1), $set) ? 'active' : ''; ?>">
                        <li class="slide">
                            <a href="<?php echo base_url('cbc/trs') ?>" class="side-menu__item <?php echo ($this->uri->segment(1) === "cbc" && $this->uri->segment(2) === "trs" && !$this->uri->segment(3)) ? 'active' : ''; ?>">CBC Assessments</a>
                        </li>

                        <li class="slide <?php echo $this->uri->segment(1) === "assignments" ? 'active' : '';  ?>">
                            <a href="<?php echo base_url('assignments/trs') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "assignments" ? 'active' : '';  ?>">Assignments</a>
                        </li>
                        <li class="slide <?php echo $this->uri->segment(1) === "qa" ? 'active' : '';  ?>">
                            <a href="<?php echo base_url('qa/trs') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "qa" ? 'active' : '';  ?>">QA</a>
                        </li>
                        <li class="slide <?php echo $this->uri->segment(1) === "mc" ? 'active' : '';  ?>">
                            <a href="<?php echo base_url('mc/trs') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "mc" ? 'active' : '';  ?>">Multiple Choice</a>
                        </li>
                        <li class="slide <?php echo $this->uri->segment(1) === "diary" ? 'active' : '';  ?>">
                            <a href="<?php echo base_url('diary/trs') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "diary" ? 'active' : '';  ?>">Academic Dairy</a>
                        </li>
                        <!-- <li class="slide <?php echo $this->uri->segment(1) === "diary" ? 'active' : '';  ?>">
                        <a href="<?php echo base_url('diary/trs/extra') ?>" class="side-menu__item <?php echo $this->uri->segment(3) === "diary" ? 'active' : '';  ?>">Extra-Curricular Diary</a>
                    </li> -->
                        <li class="slide <?php echo $this->uri->segment(1) === "students_projects" ? 'active' : '';  ?>">
                            <a href="<?php echo base_url('students_projects/trs') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "students_projects" ? 'active' : '';  ?>">Student Projects</a>
                        </li>
                    </ul>
                </li>
                <!-- End::slide -->

                <!-- Start::slide -->
                <?php
                $set = array('schemes_of_work', 'lesson_plan', 'record_of_work_covered');
                ?>
                <li class="slide has-sub <?php echo in_array($this->uri->segment(1), $set) ? 'active open' : ''; ?>">
                    <a href="javascript:void(0);" class="side-menu__item <?php echo in_array($this->uri->segment(1), $set) ? 'active open' : ''; ?>">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" class="side-menu__icon" fill="#000000">
                        <path d="M11 15h2v2h-2v-2zm0-8h2v6h-2V7zm.99-5C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z">
                        </path>
                    </svg> -->
                        <i class="fa fa-folder-o side-menu__icon"></i>
                        <span class="side-menu__label">Professional Docs</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 <?php echo in_array($this->uri->segment(1), $set) ? 'active open' : ''; ?>">
                        <li class="slide <?php echo $this->uri->segment(1) === "schemes_of_work" ? 'active' : '';  ?>">
                            <a href="<?php echo base_url('schemes_of_work/trs') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "schemes_of_work" ? 'active' : '';  ?>">Schemes of Work</a>
                        </li>
                        <li class="slide <?php echo $this->uri->segment(1) === "lesson_plan" ? 'active' : '';  ?>">
                            <a href="<?php echo base_url('lesson_plan/trs') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "lesson_plan" ? 'active' : '';  ?>">Lesson Plans</a>
                        </li>
                        <li class="slide <?php echo $this->uri->segment(1) === "record_of_work_covered" ? 'active' : '';  ?>">
                            <a href="<?php echo base_url('record_of_work_covered/trs') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "record_of_work_covered" ? 'active' : '';  ?>">Record of Work Covered</a>
                        </li>
                    </ul>
                </li>

                <!-- End::slide -->
                <?php
                $set = array('evideos', 'enotes', 'past_papers', 'lesson_materials', 'newsletters');
                ?>
                <li class="slide has-sub <?php echo in_array($this->uri->segment(1), $set) ? 'active open' : ''; ?>">
                    <a href="javascript:void(0);" class="side-menu__item <?php echo in_array($this->uri->segment(1), $set) ? 'active open' : ''; ?>">
                        <i class="fa fa-folder-open side-menu__icon"></i>
                        <span class="side-menu__label">Repositories</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 <?php echo in_array($this->uri->segment(1), $set) ? 'active open' : ''; ?>">
                        <li class="slide <?php echo $this->uri->segment(1) === "lesson_materials" ? 'active' : '';  ?>">
                            <a href="<?php echo base_url('lesson_materials/trs') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "lesson_materials" ? 'active' : '';  ?>">Lesson Materials</a>
                        </li>
                        <li class="slide <?php echo $this->uri->segment(1) === "past_papers" ? 'active' : '';  ?>">
                            <a href="<?php echo base_url('past_papers/trs/past_papers') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "past_papers" ? 'active' : '';  ?>">Past Papers</a>
                        </li>
                        <li class="slide <?php echo $this->uri->segment(1) === "enotes" ? 'active' : '';  ?>">
                            <a href="<?php echo base_url('enotes/trs') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "enotes" ? 'active' : '';  ?>">E-Notes</a>
                        </li>
                        <li class="slide <?php echo $this->uri->segment(1) === "evideos" ? 'active' : '';  ?>">
                            <a href="<?php echo base_url('evideos/trs/evideos_landing') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "evideos" ? 'active' : '';  ?>">E-videos</a>
                        </li>
                        <li class="slide <?php echo $this->uri->segment(1) === "newsletters" ? 'active' : '';  ?>">
                            <a href="<?php echo base_url('newsletters/trs/newsletters') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "newsletters" ? 'active' : '';  ?>">News Letters</a>
                        </li>
                    </ul>
                </li>
                <!-- Start::slide -->

                <!-- Start::special menu -->

                <?php
                $set = array('cbc');

                $set1 = array('cbc');
                ?>
                <?php
                if ($this->profile->special === "" || $this->profile->special === null) {
                    # code...
                } else { ?>
                    <li class="slide has-sub <?php echo in_array($this->uri->segment(1), $set) ? 'active open' : ''; ?>">
                        <a href="javascript:void(0);" class="side-menu__item <?php echo in_array($this->uri->segment(1), $set) ? 'active open' : ''; ?>">

                            <i class="fas fa-shield-alt mdi-24px side-menu__icon"></i>
                            <span class="side-menu__label">Special Roles</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item <?php echo in_array($this->uri->segment(1), $set1) ? 'active open' : ''; ?>">Exams
                                    <i class="fe fe-chevron-right side-menu__angle <?php echo in_array($this->uri->segment(1), $set1) ? 'active open' : ''; ?>"></i></a>
                                <ul class="slide-menu child2">
                                    <li class="slide <?php echo $this->uri->segment(3) === "set_exam" ? 'active open' : '';  ?>">
                                        <a href="<?php echo base_url('cbc/trs/set_exam') ?>" class="side-menu__item <?php echo $this->uri->segment(3) === "set_exam" ? 'active' : '';  ?>">Exam Setup</a>
                                    </li>
                                    <li class="slide <?php echo $this->uri->segment(3) === "all_exams" ? 'active' : '';  ?>">
                                        <a href="<?php echo base_url('cbc/trs/all_exams') ?>" class="side-menu__item <?php echo $this->uri->segment(3) === "all_exams" ? 'active' : '';  ?>">Manage Exams</a>
                                    </li>
                                    <li class="slide <?php echo $this->uri->segment(3) === "bulk_formative" ? 'active' : '';  ?>">
                                        <a href="<?php echo base_url('cbc/trs/bulk_formative') ?>" class="side-menu__item <?php echo $this->uri->segment(3) === "bulk_formative" ? 'active' : '';  ?>">Formative Reports Per Class</a>
                                    </li>

                                    <li class="slide <?php echo $this->uri->segment(3) === "bulk_formative" ? 'active' : '';  ?>">
                                        <a href="<?php echo base_url('cbc/trs/formative_perstudent') ?>" class="side-menu__item <?php echo $this->uri->segment(3) === "bulk_formative" ? 'active' : '';  ?>">Formative Reports Per Student</a>
                                    </li>

                                    <li class="slide <?php echo $this->uri->segment(3) === "generate_reports" ? 'active' : '';  ?>">
                                        <a href="<?php echo base_url('cbc/trs/generate_reports') ?>" class="side-menu__item <?php echo $this->uri->segment(3) === "generate_reports" ? 'active' : '';  ?>">Summative Reports Per Exam</a>
                                    </li>
                                    <!-- <li class="slide <?php echo $this->uri->segment(3) === "summ_single" ? 'active' : '';  ?>">
                                        <a href="<?php echo base_url('cbc/trs/summ_single') ?>" class="side-menu__item <?php echo $this->uri->segment(3) === "summ_single" ? 'active' : '';  ?>">Summative Reports Per Student</a>
                                    </li> -->

                                </ul>
                            </li>
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">CBC management
                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                <ul class="slide-menu child2">
                                    <li class="slide">
                                        <a href="javascript:void(0);" class="side-menu__item">CBC content</a>
                                    </li>
                                    <li class="slide">
                                        <a href="javascript:void(0);" class="side-menu__item">Approve Results</a>
                                    </li>

                                </ul>
                            </li>
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">Teacher Management
                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                <ul class="slide-menu child2">
                                    <li class="slide">
                                        <a href="<?php echo base_url('teachers/trs/assign_sub') ?>" class="side-menu__item">Assign Subjects</a>
                                    </li>
                                    <li class="slide">
                                        <a href="<?php echo base_url('class_groups/trs/assign_ctr') ?>" class="side-menu__item">Assign ClassTeacher</a>
                                    </li>
                                    <li class="slide">
                                        <a href="javascript:void(0);" class="side-menu__item">Manage Teachers</a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php }

                ?>

                <!-- End::slide -->

                <!-- End::slide -->

                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">COMMUNCATION</span></li>
                <li class="slide <?php echo $this->uri->segment(1) === "messages" ? 'active' : '';  ?>">
                    <a href="<?php echo base_url('messages/trs') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "messages" ? 'active' : '';  ?>">

                        <i class="fa fa-comments side-menu__icon"></i>
                        <span class="side-menu__label">Messages</span>
                    </a>
                </li>
                <!-- <li class="slide <?php echo $this->uri->segment(1) === "newsletters" ? 'active' : '';  ?>">
                <a href="<?php echo base_url('newsletters/trs/newsletters') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "newsletters" ? 'active' : '';  ?>">
                    <i class="fa fa-file-pdf-o side-menu__icon"></i>
                    <span class="side-menu__label">News Letters</span>
                </a>
            </li> -->
                <li class="slide <?php echo $this->uri->segment(1) === "appraisal_targets" ? 'active' : '';  ?>">
                    <a href="<?php echo base_url('appraisal_targets/trs') ?>" class="side-menu__item <?php echo $this->uri->segment(1) === "appraisal_targets" ? 'active' : '';  ?>">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 -960 960 960" fill="#000000">
                        <path d="M679-466 466-679l213-213 213 213-213 213Zm-559-72v-301h301v301H120Zm418 418v-301h301v301H538Zm-418 0v-301h301v301H120Zm60-478h181v-181H180v181Zm502 51 129-129-129-129-129 129 129 129Zm-84 367h181v-181H598v181Zm-418 0h181v-181H180v181Zm181-418Zm192-78ZM361-361Zm237 0Z" />
                    </svg> -->
                        <i class="fa fa-check side-menu__icon"></i>
                        <span class="side-menu__label">Self Appraisal</span>
                    </a>
                </li>

                <!-- End::slide__category -->

            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
                    </path>
                </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>