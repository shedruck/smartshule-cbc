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
            redirect('admin/login');
        }
        $this->load->model('schemes_of_work_m');
    }

    public function index()
    {
        $config = $this->set_paginate_options(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['schemes_of_work'] = $this->schemes_of_work_m->paginate_trs($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' Schemes Of Work ')->build('index/list', $data);
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
            $form_data = array(
                'year' => $this->input->post('year'),
                'term' => $this->input->post('term'),
                'level' => $this->input->post('level'),
                'week' => $this->input->post('week'),
                'lesson' => $this->input->post('lesson'),
                'subject' => $this->input->post('subject'),
                'strand' => $this->input->post('strand'),
                'substrand' => $this->input->post('substrand'),
                'specific_learning_outcomes' => $this->input->post('specific_learning_outcomes'),
                'key_inquiry_question' => $this->input->post('key_inquiry_question'),
                'learning_experiences' => $this->input->post('learning_experiences'),
                'learning_resources' => $this->input->post('learning_resources'),
                'assessment' => $this->input->post('assessment'),
                'reflection' => $this->input->post('reflection'),
                'created_by' => $user->id,
                'created_on' => time()
            );

            $ok =  $this->schemes_of_work_m->create($form_data);

            if ($ok) {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('schemes_of_work/trs');
        } else {
            $get = new StdClass();
            foreach ($this->validation() as $field) {
                $get->$field['field']  = set_value($field['field']);
            }

            $data['result'] = $get;
            //load the view and the layout
            $this->template->title('Add Schemes Of Work ')->build('index/create', $data);
        }
    }


    function view_scheme($id = FALSE, $page = 0)
    {
        //get the $id and sanitize
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;
        $page = ($page != 0) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/schemes_of_work/');
        }
        if (!$this->schemes_of_work_m->exists($id)) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/schemes_of_work');
        }
        //search the item to show in edit form
        $get = $this->schemes_of_work_m->find($id);

        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('View Scheme of work ')->build('index/view', $data);
    }

    function edit($id = FALSE, $page = 0)
    {

        //get the $id and sanitize
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        $page = ($page != 0) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('schemes_of_work/trs');
        }
        if (!$this->schemes_of_work_m->exists($id)) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('schemes_of_work/trs');
        }
        //search the item to show in edit form
        $get =  $this->schemes_of_work_m->find($id);
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
            // build array for the model
            $form_data = array(
                'year' => $this->input->post('year'),
                'term' => $this->input->post('term'),
                'level' => $this->input->post('level'),
                'week' => $this->input->post('week'),
                'lesson' => $this->input->post('lesson'),
                'strand' => $this->input->post('strand'),
                'subject' => $this->input->post('subject'),
                'substrand' => $this->input->post('substrand'),
                'specific_learning_outcomes' => $this->input->post('specific_learning_outcomes'),
                'key_inquiry_question' => $this->input->post('key_inquiry_question'),
                'learning_experiences' => $this->input->post('learning_experiences'),
                'learning_resources' => $this->input->post('learning_resources'),
                'assessment' => $this->input->post('assessment'),
                'reflection' => $this->input->post('reflection'),
                'modified_by' => $user->id,
                'modified_on' => time()
            );

            //add the aux form data to the form data array to save
            $form_data = array_merge($form_data_aux, $form_data);

            //find the item to update

            $done = $this->schemes_of_work_m->update_attributes($id, $form_data);

            if ($done) {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("schemes_of_work/trs");
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("schemes_of_work/trs");
            }
        } else {
            foreach (array_keys($this->validation()) as $field) {
                if (isset($_POST[$field])) {
                    $get->$field = $this->form_validation->$field;
                }
            }
        }
        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('Edit Schemes Of Work ')->build('index/create', $data);
    }


    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('schemes_of_work/trs');
        }

        //search the item to delete
        if (!$this->schemes_of_work_m->exists($id)) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('schemes_of_work/trs');
        }

        //delete the item
        if ($this->schemes_of_work_m->delete($id) == TRUE) {
            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        } else {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("schemes_of_work/trs");
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'year',
                'label' => 'Year',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'
            ),

            array(
                'field' => 'term',
                'label' => 'Term',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'
            ),

            array(
                'field' => 'level',
                'label' => 'Level',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'
            ),

            array(
                'field' => 'week',
                'label' => 'Week',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'
            ),

            array(
                'field' => 'lesson',
                'label' => 'Lesson',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'
            ),

            array(
                'field' => 'subject',
                'label' => 'subject',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'
            ),

            array(
                'field' => 'strand',
                'label' => 'Strand',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'
            ),

            array(
                'field' => 'substrand',
                'label' => 'Substrand',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'
            ),

            array(
                'field' => 'specific_learning_outcomes',
                'label' => 'Specific Learning Outcomes',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[5500]'
            ),

            array(
                'field' => 'key_inquiry_question',
                'label' => 'Key Inquiry Question',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[5500]'
            ),

            array(
                'field' => 'learning_experiences',
                'label' => 'Learning experiences',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[5500]'
            ),

            array(
                'field' => 'learning_resources',
                'label' => 'Learning Resources',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[5500]'
            ),

            array(
                'field' => 'assessment',
                'label' => 'Assessment',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[5500]'
            ),

            array(
                'field' => 'reflection',
                'label' => 'Reflection',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[5500]'
            ),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }


    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'schemes_of_work/trs/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 100;
        $config['total_rows'] = $this->schemes_of_work_m->count();
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
