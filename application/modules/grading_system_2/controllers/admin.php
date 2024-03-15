<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Admin_Controller
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

		/* if (!$this->ion_auth->is_in_group($this->user->id, 1) && !$this->ion_auth->is_in_group($this->user->id, 7))
        {
             $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
			redirect('admin');
        }*/

		$this->load->model('grading_system_m');
	}


	public function index()
	{
		$config = $this->set_paginate_options(); 	//Initialize the pagination class
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

		$data['grading_system'] = $this->grading_system_m->paginate_all($config['per_page'], $page);

		//create pagination links
		$data['links'] = $this->pagination->create_links();

		//page number  variable
		$data['page'] = $page;
		$data['per'] = $config['per_page'];

		//load view
		$this->template->title(' Grading System ')->build('admin/list', $data);
	}

	//Function to return return add grading views
	public function grades_add($id = NULL)
	{
		$data['gradingsys'] = $this->grading_system_m->find($id);
		$data['grades'] = $this->grading_system_m->fetchgrades($id);
		//Rules for validation
		$this->form_validation->set_rules($this->validation2());

		//validate the fields of form
		if ($this->form_validation->run()) {         //Validation OK!
			$user = $this->ion_auth->get_user();

			$k = 0;
			$kk = 0;
			$kkk = 0;
			$grades = $this->input->post('grade');

			//   echo "<pre>";
			//   print_r($this->input->post());
			//   echo "</pre>"; die;

			foreach ($grades as $z => $grade) {

				if (empty($grade)) {
					continue;
				}

				$gradavailable = $this->grading_system_m->checkgrade($id, $grade);
				if (empty($this->input->post('gid')[$z])) {
					if ($gradavailable) {
						$kkk++;
						continue;
					}

					$form_data = array(
						'grade_id' => $id,
						'grade' => trim($grade),
						'minimum_marks' => $this->input->post('minimum_marks')[$z],
						'maximum_marks' => $this->input->post('maximum_marks')[$z],
						'points' => $this->input->post('points')[$z],
						'comment' => $this->input->post('comment')[$z],
						'created_by' => $user->id,
						'created_on' => time()
					);


					$ok =  $this->grading_system_m->addgrades($form_data);
					if ($ok) {
						$details = implode(' , ', $this->input->post());
						$user = $this->ion_auth->get_user();
						$log = array(
							'module' =>  $this->router->fetch_module(),
							'item_id' => $ok,
							'transaction_type' => $this->router->fetch_method(),
							'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $ok,
							'details' => $details,
							'created_by' => $user->id,
							'created_on' => time()
						);

						$this->ion_auth->create_log($log);
						$k++;
					}
				} else {
					$form_data = array(
						'grade_id' => $id,
						'grade' => trim($grade),
						'minimum_marks' => $this->input->post('minimum_marks')[$z],
						'maximum_marks' => $this->input->post('maximum_marks')[$z],
						'points' => $this->input->post('points')[$z],
						'comment' => $this->input->post('comment')[$z],
						'created_by' => $user->id,
						'created_on' => time()
					);

					$ok =  $this->grading_system_m->update_gs_attributes($this->input->post('gid')[$z], $form_data);
					if ($ok) {
						$details = implode(' , ', $this->input->post());
						$user = $this->ion_auth->get_user();
						$log = array(
							'module' =>  $this->router->fetch_module(),
							'item_id' => $ok,
							'transaction_type' => $this->router->fetch_method(),
							'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $ok,
							'details' => $details,
							'created_by' => $user->id,
							'created_on' => time()
						);

						$this->ion_auth->create_log($log);
						$kk++;
					}
				}
			}


			$this->session->set_flashdata('message', array('type' => 'success', 'text' => $k . ' Grades added Successfully. ' . $kk . ' Grades Updated ' . $kkk . ' Grades Skipped'));

			redirect('admin/grading_system/grades_add/' . $id);
		} else {
			$get = new StdClass();
			foreach ($this->validation() as $field) {
				$get->{$field['field']}  = set_value($field['field']);
			}

			$data['result'] = $get;
			//load the view and the layout
			$this->template->title('Add Grading System ')->build('admin/addgrades', $data);
		}
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
				'title' => $this->input->post('title'),
				'pass_mark' => $this->input->post('pass_mark'),
				'description' => $this->input->post('description'),
				'created_by' => $user->id,
				'created_on' => time()
			);

			$ok =  $this->grading_system_m->create($form_data);

			if ($ok) {
				$details = implode(' , ', $this->input->post());
				$user = $this->ion_auth->get_user();
				$log = array(
					'module' =>  $this->router->fetch_module(),
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

			redirect('admin/grading_system/');
		} else {
			$get = new StdClass();
			foreach ($this->validation() as $field) {
				$get->{$field['field']}  = set_value($field['field']);
			}

			$data['result'] = $get;
			//load the view and the layout
			$this->template->title('Add Grading System ')->build('admin/create', $data);
		}
	}

	function quick_add($page = NULL)
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
				'title' => $this->input->post('title'),
				'pass_mark' => $this->input->post('pass_mark'),
				'description' => $this->input->post('description'),
				'created_by' => $user->id,
				'created_on' => time()
			);

			$ok =  $this->grading_system_m->create($form_data);

			if ($ok) {
				$details = implode(' , ', $this->input->post());
				$user = $this->ion_auth->get_user();
				$log = array(
					'module' =>  $this->router->fetch_module(),
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

			redirect('admin/grading/create');
		} else {
			$get = new StdClass();
			foreach ($this->validation() as $field) {
				$get->{$field['field']}  = set_value($field['field']);
			}

			$data['result'] = $get;
			//load the view and the layout
			$this->template->title('Add Grading System ')->build('admin/create', $data);
		}
	}

	function edit($id = FALSE, $page = 0)
	{

		//get the $id and sanitize
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		$page = ($page != 0) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

		//redirect if no $id
		if (!$id) {
			$this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
			redirect('admin/grading_system/');
		}
		if (!$this->grading_system_m->exists($id)) {
			$this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
			redirect('admin/grading_system');
		}
		//search the item to show in edit form
		$get =  $this->grading_system_m->find($id);
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
				'title' => $this->input->post('title'),
				'pass_mark' => $this->input->post('pass_mark'),
				'description' => $this->input->post('description'),
				'modified_by' => $user->id,
				'modified_on' => time()
			);

			//add the aux form data to the form data array to save
			$form_data = array_merge($form_data_aux, $form_data);

			//find the item to update

			$done = $this->grading_system_m->update_attributes($id, $form_data);


			if ($done) {

				$details = implode(' , ', $this->input->post());
				$user = $this->ion_auth->get_user();
				$log = array(
					'module' =>  $this->router->fetch_module(),
					'item_id' => $done,
					'transaction_type' => $this->router->fetch_method(),
					'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $done,
					'details' => $details,
					'created_by' => $user->id,
					'created_on' => time()
				);

				$this->ion_auth->create_log($log);


				$this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
				redirect("admin/grading_system/");
			} else {
				$this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
				redirect("admin/grading_system/");
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
		$this->template->title('Edit Grading System ')->build('admin/create', $data);
	}


	function delete($id = NULL, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id) {
			$this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

			redirect('admin/grading_system');
		}

		//search the item to delete
		if (!$this->grading_system_m->exists($id)) {
			$this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

			redirect('admin/grading_system');
		}

		//delete the item
		if ($this->grading_system_m->delete($id) == TRUE) {
			//$details = implode(' , ', $this->input->post());
			$user = $this->ion_auth->get_user();
			$log = array(
				'module' =>  $this->router->fetch_module(),
				'item_id' => $id,
				'transaction_type' => $this->router->fetch_method(),
				'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $id,
				'details' => 'Record Deleted',
				'created_by' => $user->id,
				'created_on' => time()
			);

			$this->ion_auth->create_log($log);


			$this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
		} else {
			$this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
		}

		redirect("admin/grading_system/");
	}

	private function validation()
	{
		$config = array(
			array(
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'
			),
			array(
				'field' => 'pass_mark',
				'label' => 'pass_mark',
				'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'
			),

			array(
				'field' => 'description',
				'label' => 'Description',
				'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'
			),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
		return $config;
	}

	private function validation2()
    {
$config = array(
	array(
		'field' =>'grade',
			   'label' => 'Grade',
			   'rules' => 'required|xss_clean'),
	array(
		'field' =>'minimum_marks',
			   'label' => 'Minimum Marks',
			   'rules' => 'required|xss_clean'),     
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
	return $config; 
	}

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'admin/grading_system/index/';
		$config['use_page_numbers'] = TRUE;
		$config['per_page'] = 100000000000;
		$config['total_rows'] = $this->grading_system_m->count();
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
