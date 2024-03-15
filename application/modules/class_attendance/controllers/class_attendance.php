<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Class_attendance extends Public_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->template
                             ->set_layout('default.php')
                             ->set_partial('meta', 'partials/meta.php')
                             ->set_partial('header', 'partials/header.php')
                             ->set_partial('sidebar', 'partials/sidebar.php')
                             ->set_partial('footer', 'partials/footer.php');
                if (!$this->ion_auth->logged_in())
                {
                        redirect('login');
                }
                $this->load->model('class_attendance_m');
                $this->load->model('class_groups/class_groups_m');
        }

        /**
         * Show attendance
         */
        public function index()
        {
                $att = array();
                if ($this->input->post('student') && $this->input->post('month') && $this->input->post('year'))
                {
                        $student = $this->input->post('student');
                        $month = $this->input->post('month');
                        $year = $this->input->post('year');
                        
                        $att = $this->class_attendance_m->get_attendance($student, $month, $year);
                $data['month'] = $month;
                $data['year'] = $year;
                }
                $data['att'] = $att;

                $this->template->title('Class Attendance')->build('index/view', $data);
        }

}
