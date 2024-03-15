<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Zoom extends Trs_Controller
{
    
    function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
        {
            redirect('/login');
        }
        $this->load->model('zoom_m');
    }
    function index(){
       $data['zoom']= $this->zoom_m->zoom_classes();
        //load view
        $this->template->title(' Zoom ' )->build('trs/list', $data);
    }

    function edit($id)
	{ 
        if($this->input->post()){
            $user=$this->ion_auth->get_user()->id;
            $form_data = array( 
                'title' => $this->input->post('title'), 
                'link' => $this->input->post('link'), 
                'time' => strtotime($this->input->post('time')), 
                'modified_by' => $user -> id ,   
                'modified_on' => time() 
            );
            $done = $this->zoom_m->update_attributes($id, $form_data);

            if ( $done) 
                    {
                    $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
                    redirect("trs/zoom/");
                }
    
                else
                {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
                    redirect("trs/zoom/");
                }
        }
        $data['zoom']=$this->zoom_m->zoom_classes_by_id($id);
        $this->template->title(' Zoom ' )->build('trs/edit', $data);
        
	}

    function create(){

        if($this->input->post()){
            $class= $this->input->post('class');
            $user = $this -> ion_auth -> get_user();
            $form_data = array(
				'title' => $this->input->post('title'), 
				'link' => $this->input->post('link'), 
                'class' => $class, 
				'time' => strtotime($this->input->post('time')), 
				 'created_by' => $user -> id ,   
				 'created_on' => time()
			);
           

            $ok=  $this->zoom_m->create($form_data);
            if($ok){
                 //create zoom notifications
                 $students= $this->zoom_m->get_students($class);
                 foreach($students as $std){
                     $z_data = array(
                         'zoom_id' => $ok, 
                         'student' => $std->id, 
                         'user_id' => $std->user_id, 
                         'created_by' => $user -> id ,   
                         'created_on' => time()
                     );

                     $this->zoom_m->create_notification($z_data);
                 }

                 //create log
                 $log = array(
                     'module' => $this->router->fetch_module(),
                     'item_id' => $ok,
                     'transaction_type' => $this->router->fetch_method(),
                     'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $adm->parent_id,
                     'details' => 'Created zoom meeting',
                     'created_by' => $user->id,
                     'created_on' => time()
                 );

                 $this->ion_auth->create_log($log);
                 $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }else{
                $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }
            redirect('trs/zoom/');
        }


        $this->template->title(' Zoom | Add class ' )->build('trs/create');
    }

    function delete($id = NULL, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('trs/zoom');
		}

		//search the item to delete
		if ( !$this->zoom_m->exists($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('trs/zoom');
		}
 
		//delete the item
		                     if ( $this->zoom_m->delete($id) == TRUE) 
		{
			$this->session->set_flashdata('message', array( 'type' => 'info', 'text' => lang('web_delete_success') ));
		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect("trs/zoom/");
	}
}