<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Transition_profile extends Trs_Controller{
        function __construct()
        {
            parent::__construct();
    
            if (!$this->ion_auth->logged_in())
            {
                redirect('/login');
            }
            $this->load->model('transition_profile_m');
            $this->load->model('admission/admission_m');
        }

        function index(){

            $config = $this->set_paginate_options(); //Initialize the pagination class
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
            $data['links'] = $this->pagination->create_links();
            $data['profiles'] = $this->transition_profile_m->paginate_all_($config['per_page'], $page);

            //page number  variable
            $data['page'] = $page;
            $data['per'] = $config['per_page'];
            $data['classes'] = $this->trs_m->list_my_classes();
            $this->template->title(' Transition Profile ')->build('trs/list', $data);
        }

        function create($page = NULL)
                {
                    //create control variables
                    $data['updType'] = 'create';
                    $form_data_aux  = array();
                    $data['page'] = ( $this->uri->segment(4) )  ? $this->uri->segment(4) : $page;
         
                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                    //validate the fields of form
                    if ($this->form_validation->run() )
                    {         //Validation OK!
                  $user = $this -> ion_auth -> get_user();
                $form_data = array(
                        'student' => $this->input->post('student'),
                        'class' => $this->input->post('class'),
                        'allergy' => $this->input->post('allergy'), 
                        'general_health' => $this->input->post('general_health'), 
                        'general_academic' => $this->input->post('general_academic'), 
                        'feeding_habit' => $this->input->post('feeding_habit'), 
                        'behaviour' => $this->input->post('behaviour'), 
                        'co_curriculum' => $this->input->post('co_curriculum'), 
                        'parental_involvement' => $this->input->post('parental_involvement'), 
                        'transport' => $this->input->post('transport'), 
                         'created_by' => $user -> id ,   
                         'created_on' => time(),
                         'any_info' => $this->input->post('any_info'),
                         'year' => $this->input->post('year'),
                    );

                    $ok=  $this->transition_profile_m->create($form_data);

                    if ( $ok)
                    {
                            $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
                    }
                    else
                    {
                            $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
                    }

                    redirect('trs/transition_profile/');

                }else
                        {
                        $get = new StdClass();
                        foreach ($this -> validation() as $field)
                        {   
                                 $get -> {$field['field']}  = set_value($field['field']);
                         }
                         $class = $this->streams;

                         $range = range(date('Y') - 15, date('Y') + 1);
                         $yrs = array_combine($range, $range);
                         krsort($yrs);

                         
                         $data['yrs'] = $yrs;
                         $data['classes'] = $class;
                 
                        // $data['students'] = $this->trs_m->my_students();
                        $data['students'] = $this->ion_auth->students_full_details();
                         $data['result'] = $get; 
                         //load the view and the layout
                         $this->template->title('Add Transition Profile ' )->build('trs/create', $data);
                }       
            }

            function edit($id){
                if($this->input->post()){
                  $user = $this -> ion_auth -> get_user();
                        $form_data = array(
                                'allergy' => $this->input->post('allergy'), 
                                'general_health' => $this->input->post('general_health'), 
                                'general_academic' => $this->input->post('general_academic'), 
                                'feeding_habit' => $this->input->post('feeding_habit'), 
                                'behaviour' => $this->input->post('behaviour'), 
                                'co_curriculum ' => $this->input->post('co_curriculum'), 
                                'parental_involvement' => $this->input->post('parental_involvement'), 
                                'transport' => $this->input->post('transport'), 
                                'modified_by' => $user -> id ,   
                                'modified_on' => time(),
                                'any_info' => $this->input->post('any_info'),
                        );
                         
                         $done = $this->transition_profile_m->update_attributes($id, $form_data);

                         if ( $done)
                         {
                                 $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
                         }
                         else
                         {
                                 $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
                         }

                         redirect('trs/transition_profile/');


                }
                $get = $this->transition_profile_m->find($id);
                $data['get'] = $get;
                $this->template->title('Transition Profile Update')->build('trs/edit', $data);
            }

            function delete($id = NULL, $page = 1)
            {
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                //redirect if its not correct
                if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

                    redirect('trs/transition_profile');
                }

                //search the item to delete
                if ( !$this->transition_profile_m->exists($id) )
                {
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

                    redirect('trs/transition_profile');
                }
            
                //delete the item
                                     if ( $this->transition_profile_m->delete($id) == TRUE) 
                {
                    $this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' => lang('web_delete_success') ));
                }
                else
                {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
                }

                redirect("trs/transition_profile");
            }
             
        function view($id){
            $get = $this->transition_profile_m->find($id);
            $data['get'] = $get;
            $stud = $this->admission_m->find($get->student);
            $data['student'] = $stud;
            $data['passport'] = $this->admission_m->passport($stud->photo);
            $this->template->title('Transition Profile')->build('trs/view', $data);
        }


         private function set_paginate_options()
        {
            $config = array();
            $config['base_url'] = site_url() . 'trs/transition_profile/index/';
            $config['use_page_numbers'] = TRUE;
            $config['per_page'] = 100;
            $config['total_rows'] = $this->transition_profile_m->count();
            $config['uri_segment'] = 4;

            $config['first_link'] = lang('web_first');
            $config['first_tag_open'] = "<li class='paginate_button'>";
            $config['first_tag_close'] = '</li>';
            $config['last_link'] = lang('web_last');
            $config['last_tag_open'] = "<li class='paginate_button'>";
            $config['last_tag_close'] = '</li>';
            $config['next_link'] = FALSE;
            $config['next_tag_open'] = "<li class='paginate_button'>";
            $config['next_tag_close'] = '</li>';
            $config['prev_link'] = FALSE;
            $config['prev_tag_open'] = "<li class='paginate_button'>";
            $config['prev_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active">  <a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = "<li class='paginate_button pull-right'>";
            $config['num_tag_close'] = '</li>';
            $config['full_tag_open'] = '<div class="pagination pull-right1"><ul class="pagination">';
            $config['full_tag_close'] = '</ul></div><hr>';
            $choice = $config["total_rows"] / $config["per_page"];
            //$config["num_links"] = round($choice);

            return $config;
        }




        private function validation()
    {
$config = array(
                array(
         'field' =>'allergy',
                'label' => 'Allergy',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),

                array(
         'field' =>'general_health',
                'label' => 'General Health',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),

                array(
         'field' =>'general_academic',
                'label' => 'General Academic',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),

                array(
         'field' =>'feeding_habit',
                'label' => 'Feeding Habit',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),

                array(
         'field' =>'behaviour',
                'label' => 'Behaviour',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),

                array(
         'field' =>'co_curriculum ',
                'label' => 'Co Curriculum',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),

                array(
         'field' =>'parental_involvement',
                'label' => 'Parental Involvement',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),

                 array(
         'field' =>'transport',
                 'label' => 'Transport',
                 'rules' =>'xss_clean'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
    }
    }
?>