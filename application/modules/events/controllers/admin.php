<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();

                if (!$this->ion_auth->logged_in())
                {
                        redirect('admin/login');
                }
                $this->load->model('events_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['events'] = $this->events_m->paginate_all($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];

                //load view
                $this->template->title(' Events & Announcements ')->build('admin/list', $data);
        }

        public function create($page = NULL)
        {
                // Create control variables
                $data['updType'] = 'create';
                $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : $page;

                // Rules for validation
                if ($this->input->post('announce')) {
                        $this->form_validation->set_rules($this->ann_validation());
                }

                // Validate the fields of the form
                if ($this->form_validation->run()) {

                        $uploadDir = FCPATH . 'assets/uploads/';

                        $uploadedFiles = $_FILES['file'];
                        $fileCount = count($uploadedFiles['name']);

                        $user = $this->ion_auth->get_user();

                        if ($this->input->post('announce')) {
                                $form_data = array(
                                        'title' => $this->input->post('stitle'),
                                        'cat' => $this->input->post('cat'),
                                        'description' => $this->input->post('desc'),
                                        'created_by' => $user->id,
                                        'created_on' => time()
                                );
                        }

                        $ok = $this->events_m->create($form_data);

                        // Define allowed MIME types and extensions
                        $allowedMimeTypes = ['application/pdf', 'image/jpeg', 'image/png'];
                        $allowedExtensions = ['pdf', 'jpeg', 'jpg', 'png'];

                        if ($ok) {
                                if ($fileCount > 0) {
                                        for ($i = 0; $i < $fileCount; $i++) {
                                                $fileName = $_FILES['file']['name'][$i];
                                                $fileTmpName = $_FILES['file']['tmp_name'][$i];
                                                $fileSize = $_FILES['file']['size'][$i];
                                                $fileError = $_FILES['file']['error'][$i];

                                                // Extract file extension and MIME type
                                                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                                $fileMimeType = mime_content_type($fileTmpName);

                                                // Check file extension and MIME type
                                                if (in_array($fileExtension, $allowedExtensions) && in_array($fileMimeType, $allowedMimeTypes)) {
                                                        $destination = $uploadDir . $fileName;

                                                        if (move_uploaded_file($fileTmpName, $destination)) {
                                                                $upform = [
                                                                        'filename' => $fileName,
                                                                        'file_path' => $uploadDir,
                                                                        'has_attachment' => 1
                                                                ];

                                                                $this->events_m->insert_event_filenames($ok, $upform);
                                                        } else {
                                                                // Handle file move error
                                                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Error moving the file: $fileName"));
                                                        }
                                                } else {
                                                        // Handle invalid file type
                                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Invalid file type for file: $fileName"));
                                                }
                                        }
                                }
                        }

                        // Logging and feedback
                        if ($ok) {
                                $details = implode(' , ', $this->input->post());
                                $user = $this->ion_auth->get_user();
                                $log = array(
                                        'module' => $this->router->fetch_module(),
                                        'item_id' => $ok,
                                        'transaction_type' => $this->router->fetch_method(),
                                        'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $ok,
                                        'details' => $details,
                                        'created_by' => $user->id,
                                        'created_on' => time()
                                );

                                $this->ion_auth->create_log($log);

                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        } else {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('admin/events/');
                } else {
                        $get = new StdClass();

                        if ($this->input->post('announce')) {
                                foreach ($this->ann_validation() as $field) {
                                        $get->{$field['field']} = set_value($field['field']);
                                }
                        }

                        $data['result'] = $get;
                        // Load the view and the layout
                        $this->template->title('Events & Announcements')->build('admin/create', $data);
                }
        }


        /**
         * Edit 
         * 
         * @param int $id
         * @param int $page
         */
        public function edit($id = FALSE, $page = 0)
        {
                // Redirect if no $id
                if (!$id) {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/events/');
                }
                if (!$this->events_m->exists($id)) {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/events');
                }
                // Search the item to show in edit form
                $get = $this->events_m->find($id);

                if ($this->input->post('announce')) {
                        $this->form_validation->set_rules($this->ann_validation());
                } else {
                        $this->form_validation->set_rules($this->validation());
                }

                // Create control variables
                $data['updType'] = 'edit';
                $data['page'] = $page;

                if ($this->form_validation->run()) {  // Validation has been passed
                        $user = $this->ion_auth->get_user();
                        if ($this->input->post('announce')) {
                                $form_data = array(
                                        'title' => $this->input->post('stitle'),
                                        'cat' => $this->input->post('cat'),
                                        'description' => $this->input->post('desc'),
                                        'modified_by' => $user->id,
                                        'modified_on' => time()
                                );
                        }

                        $done = $this->events_m->update_attributes($id, $form_data);

                        if ($done) {
                                // Handle file upload
                                $uploadDir = FCPATH . 'assets/uploads/';
                                $allowedMimeTypes = ['application/pdf', 'image/jpeg', 'image/png'];
                                $allowedExtensions = ['pdf', 'jpeg', 'jpg', 'png'];

                                if (isset($_FILES['file'])) {
                                        $uploadedFiles = $_FILES['file'];
                                        $fileCount = count($uploadedFiles['name']);

                                        if ($fileCount > 0) {
                                                for ($i = 0; $i < $fileCount; $i++) {
                                                        $fileName = $_FILES['file']['name'][$i];
                                                        $fileTmpName = $_FILES['file']['tmp_name'][$i];
                                                        $fileSize = $_FILES['file']['size'][$i];
                                                        $fileError = $_FILES['file']['error'][$i];

                                                        // Extract file extension and MIME type
                                                        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                                        $fileMimeType = mime_content_type($fileTmpName);

                                                        // Check file extension and MIME type
                                                        if (in_array($fileExtension, $allowedExtensions) && in_array($fileMimeType, $allowedMimeTypes)) {
                                                                $destination = $uploadDir . $fileName;

                                                                if (move_uploaded_file($fileTmpName, $destination)) {
                                                                        // Optionally, remove old files if replacing
                                                                        // (Implement logic to check and delete old files if necessary)

                                                                        $upform = [
                                                                                'filename' => $fileName,
                                                                                'file_path' => $uploadDir,
                                                                                'has_attachment' => 1
                                                                        ];

                                                                        $this->events_m->insert_event_filenames($id, $upform);
                                                                } else {
                                                                        // Handle file move error
                                                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Error moving the file: $fileName"));
                                                                }
                                                        } else {
                                                                // Handle invalid file type
                                                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Invalid file type for file: $fileName"));
                                                        }
                                                }
                                        }
                                }

                                // Logging and feedback
                                $details = implode(' , ', $this->input->post());
                                $user = $this->ion_auth->get_user();
                                $log = array(
                                        'module' => $this->router->fetch_module(),
                                        'item_id' => $done,
                                        'transaction_type' => $this->router->fetch_method(),
                                        'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $done,
                                        'details' => $details,
                                        'created_by' => $user->id,
                                        'created_on' => time()
                                );

                                $this->ion_auth->create_log($log);

                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/events/");
                        } else {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/events/");
                        }
                } else {
                        if ($this->input->post('announce')) {
                                foreach (array_keys($this->ann_validation()) as $field) {
                                        if (isset($_POST[$field])) {
                                                $get->$field = $this->form_validation->$field;
                                        }
                                }
                                if (isset($get->title)) {
                                        $get->stitle = $get->title;
                                }
                                if (isset($get->description)) {
                                        $get->desc = $get->description;
                                }
                                unset($get->description);
                                unset($get->title);
                        }
                }

                $data['result'] = $this->events_m->find($id);
                // Load the view and the layout
                $this->template->title('Edit Event ')->build('admin/create', $data);
        }


        function delete($id = NULL, $page = 1)
        {
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/events');
                }

                //search the item to delete
                if (!$this->events_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/events');
                }

                //delete the item
                if ($this->events_m->delete($id) == TRUE)
                {
                      // $details = implode(' , ', $this->input->post());
						$user = $this->ion_auth->get_user();
							$log = array(
								'module' =>  $this->router->fetch_module(), 
								'item_id' => $id, 
								'transaction_type' => $this->router->fetch_method(), 
								'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$id, 
								'details' => 'Record Deleted',   
								'created_by' => $user -> id,   
								'created_on' => time()
							);

						  $this->ion_auth->create_log($log); 
						
						$this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }

                redirect("admin/events/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'title',
                        'label' => 'Title',
                        'rules' => 'required|trim|xss_clean|max_length[60]'),
                    array(
                        'field' => 'date',
                        'label' => 'Date',
                        'rules' => 'required|trim|xss_clean|max_length[60]'),
                    array(
                        'field' => 'start',
                        'label' => 'Start',
                        'rules' => 'required|trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'end',
                        'label' => 'End',
                        'rules' => 'trim|xss_clean|max_length[60]'),
                    array(
                        'field' => 'venue',
                        'label' => 'Venue',
                        'rules' => 'trim|xss_clean'),
                    array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => 'required|trim|xss_clean|max_length[500]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function ann_validation()
        {
                $config = array(
                    array(
                        'field' => 'stitle',
                        'label' => 'Title',
                        'rules' => 'required|trim|xss_clean|max_length[60]'),
                    array(
                        'field' => 'desc',
                        'label' => 'Description',
                        'rules' => 'required|trim|xss_clean|max_length[500]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/events/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 10;
                $config['total_rows'] = $this->events_m->count();
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
