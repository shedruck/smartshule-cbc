<?php defined('BASEPATH') or exit('No direct script access allowed');

class Trs extends Trs_Controller
{
    function __construct()
    {
        parent::__construct();
        /*$this->template->set_layout('default');
			$this->template->set_partial('sidebar','partials/sidebar.php')
                    -> set_partial('top', 'partials/top.php');*/
        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }
        $this->load->model('lesson_plan_m');
    }

    public function index()
    {
        $config = $this->set_paginate_options(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['lesson_plan'] = $this->lesson_plan_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];
        $data['subjects'] = $this->lesson_plan_m->populate('cbc_subjects','id','name');

        //load view
        $this->template->title(' Lesson Plan ')->build('index/list', $data);
    }

    function create($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';
        $form_data_aux  = array();
        $data['page'] = ($this->uri->segment(4))  ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run()) {         //Validation OK!
 
            $user = $this->ion_auth->get_user();
            $scheme = $this->input->post('scheme');

            
            $form_data = array(
                'scheme' => $scheme,
                'core_competences' => $this->input->post('core_competences'),
                'organisation' => $this->input->post('organisation'),
                'introduction' => $this->input->post('introduction'),
                'extended_activity' => $this->input->post('extended_activity'),
                'conclusion' => $this->input->post('conclusion'),
                'reflection' => $this->input->post('reflection'),
                'created_by' => $user->id,
                'created_on' => time()
            );

            $has_plan =  $this->lesson_plan_m->get_by_scheme($scheme);
            if($has_plan)
            {
                $this->session->set_flashdata('message', array('type' => 'warning', 'text' => 'Lesson plan for the selected scheme of work exists!!'));
                redirect('lesson_plan/trs');
            }

            $ok =  $this->lesson_plan_m->create('lesson_plan',$form_data);

            if($ok)
            {
                // update relfection on the schmees of work
                $this->lesson_plan_m->update_attributes('schemes_of_work', $scheme, ['reflection' => $this->input->post('reflection')]);
            }

            if ($ok) {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
               
                redirect('lesson_plan/trs/lesson_steps/' . $ok . '/' . $scheme);
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                redirect('lesson_plan/trs/');
            }

           
        } else {
            $get = new StdClass();
            foreach ($this->validation() as $field) {
                $get->{$field['field']}  = set_value($field['field']);
            }

            $data['result'] = $get;
            $data['schemes'] = $this->lesson_plan_m->_get_scheme();
            //load the view and the layout
            $this->template->title('Add Lesson Plan ')->build('index/create', $data);
        }
    }

    function lesson_steps($plan,$scheme)
    {

        if($this->input->post())
        {

            $exists = $this->lesson_plan_m->has_steps($scheme, $plan, $this->input->post('step'));
           
            if($exists)
            {
                $up = $this->lesson_plan_m->update_attributes('lesson_developments', $exists->id, [
                    'lesson_plan' => $plan,
                    'scheme' => $scheme,
                    'step' => $this->input->post('step'),
                    'description' => $this->input->post('description'),
                ]);
            }
            else
            {
                $ok =  $this->lesson_plan_m->create('lesson_developments',[
                    'lesson_plan' => $plan,
                    'scheme' => $scheme,
                    'step' => $this->input->post('step'),
                    'description' => $this->input->post('description'),
                    'created_on' => time(),
                    'created_by' => $this->user->id,
                ]);
            }

            $mess = 'Created successfully';
            if($up)
            {
                $mess = 'Updated successfully';
            }

           

            $redirect = 'lesson_plan/trs';
            if($this->input->post('stay_here') == 1)
            {
                $redirect = 'lesson_plan/trs/lesson_steps/'.$plan.'/'.$scheme;
            }

            if ($ok || $up) 
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $mess));
                redirect($redirect);
            } 
            else 
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                redirect($redirect);
            }

        }
        $data['steps'] = $this->lesson_plan_m->_get_steps($plan,$scheme);
        $this->template->title('Add Lesson Plan ')->build('index/lesson_steps', []);
    }


    function view($plan, $scheme)
    {
        $data['post'] = $this->lesson_plan_m->get_the_plan($plan,$scheme);
        $data['subjects'] = $this->lesson_plan_m->populate('cbc_subjects', 'id', 'name');     

        $this->template->title('Lesson Plan ')->build('index/view', $data);
    }


    function edit($id = FALSE, $page = 0)
    {

        //get the $id and sanitize
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        $page = ($page != 0) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('lesson_plan/trs/');
        }
        if (!$this->lesson_plan_m->exists($id)) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/lesson_plan');
        }
        //search the item to show in edit form
        $get =  $this->lesson_plan_m->find($id);
        //variables for check the upload
        $form_data_aux = array();
        $files_to_delete  = array();
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //create control variables
        $data['updType'] = 'edit';
        $data['page'] = $page;

        if ($this->form_validation->run())  //validation has been passed
        {
            $user = $this->ion_auth->get_user();
            $scheme = $this->input->post('scheme');

            // build array for the model
            $form_data = array(
                'scheme' => $scheme,
                'core_competences' => $this->input->post('core_competences'),
                'organisation' => $this->input->post('organisation'),
                'introduction' => $this->input->post('introduction'),
                'extended_activity' => $this->input->post('extended_activity'),
                'conclusion' => $this->input->post('conclusion'),
                'reflection' => $this->input->post('reflection'),
                'modified_by' => $user->id,
                'modified_on' => time()
            );

            //add the aux form data to the form data array to save
            $form_data = array_merge($form_data_aux, $form_data);

            //find the item to update

            $done = $this->lesson_plan_m->update_attributes('lesson_plan', $id, $form_data);

            if ($done) {

                // 

                $this->lesson_plan_m->update_attributes('schemes_of_work', $scheme, ['reflection' => $this->input->post('reflection')]);

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("lesson_plan/trs/");
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("lesson_plan/trs/");
            }
        } else {
            foreach (array_keys($this->validation()) as $field) {
                if (isset($_POST[$field])) {
                    $get->{$field} = $this->form_validation->$field;
                }
            }
        }
        $data['result'] = $get;
        $data['schemes'] = $this->lesson_plan_m->_get_scheme();
        //load the view and the layout
        $this->template->title('Edit Lesson Plan ')->build('index/create', $data);
    }


    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/lesson_plan');
        }

        //search the item to delete
        if (!$this->lesson_plan_m->exists($id)) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/lesson_plan');
        }

        //delete the item
        if ($this->lesson_plan_m->delete($id) == TRUE) {
            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        } else {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("lesson_plan/trs/");
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'scheme',
                'label' => 'Scheme of work',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'core_competences',
                'label' => 'Core Competences',
                'rules' => 'trim|xss_clean'
            ),

            array(
                'field' => 'organisation',
                'label' => 'Organization of Learning',
                'rules' => 'trim|xss_clean'
            ),

            array(
                'field' => 'introduction',
                'label' => 'Introduction',
                'rules' => 'trim|xss_clean|required'
            ),

            array(
                'field' => 'extended_activity',
                'label' => 'Extended Activity',
                'rules' => 'trim|xss_clean|required'
            ),

            array(
                'field' => 'conclusion',
                'label' => 'Conclusion',
                'rules' => 'trim|xss_clean|required'
            ),

            array(
                'field' => 'reflection',
                'label' => 'Reflection',
                'rules' => 'trim|xss_clean|required'
            ),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }


    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'lesson_plan/trs/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['total_rows'] = $this->lesson_plan_m->count();
        $config['uri_segment'] = 4;

        $config['first_link'] = lang('web_first');
        $config['first_tag_open'] = "<li>";
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = lang('web_last');
        $config['last_tag_open'] = "<li>";
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = FALSE;
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = FALSE;
        $config['prev_tag_open'] = "<li>";
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active">  <a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = "<li>";
        $config['num_tag_close'] = '</li>';
        $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $choice = $config["total_rows"] / $config["per_page"];
        //$config["num_links"] = round($choice);

        return $config;
    }
}
