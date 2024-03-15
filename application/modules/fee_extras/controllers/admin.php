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
              $this->load->model('fee_extras_m');
         }

         public function index()
         {
              $config = $this->set_paginate_options();  //Initialize the pagination class
              $this->pagination->initialize($config);
              $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
              $data['fee_extras'] = $this->fee_extras_m->paginate_all($config['per_page'], $page);
              //create pagination links
              $data['links'] = $this->pagination->create_links();
              //page number  variable
              $data['page'] = $page;
              $data['per'] = $config['per_page'];
              //load view
              $this->template->title('Fee Extras')->build('admin/list', $data);
         }

         function create($page = NULL)
         {
              //create control variables
              $data['updType'] = 'create';
              $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
              //Rules for validation
              $this->form_validation->set_rules($this->validation());
              //validate the fields of form
              if ($this->form_validation->run())
              {         //Validation OK!
                   $user = $this->ion_auth->get_user();
                   $form_data = array(
                           'title' => $this->input->post('title'),
                           'ftype' => $this->input->post('ftype'),
                           'cycle' => $this->input->post('cycle'),
                           'amount' => $this->input->post('amount'),
                           'discounted' => $this->input->post('discounted'),
                           'description' => $this->input->post('description'),
                           'created_by' => $user->id,
                           'created_on' => time()
                   );
                   $ok = $this->fee_extras_m->create($form_data);
                   if ($ok) 
                   { 
			              $details = implode(' , ', $this->input->post());
								$user = $this->ion_auth->get_user();
									$log = array(
										'module' =>  $this->router->fetch_module(), 
										'item_id' => $ok, 
										'transaction_type' => $this->router->fetch_method(), 
										'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$ok, 
										'details' => $details,   
										'created_by' => $user -> id,   
										'created_on' => time()
									);

								  $this->ion_auth->create_log($log);
                        
						$this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                   }
                   else
                   {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                   }
                   redirect('admin/fee_extras/');
              }
              else
              {
                   $get = new StdClass();
                   foreach ($this->validation() as $field)
                   {
                        $get->{$field['field']} = set_value($field['field']);
                   }
                   $data['result'] = $get;
                   //load the view and the layout
                   $this->template->title('Add Fee Extras ')->build('admin/create', $data);
              }
         }

         function edit($id = FALSE, $page = 0)
         {
              //redirect if no $id
              if (!$id)
              {
                   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                   redirect('admin/fee_extras/');
              }
              if (!$this->fee_extras_m->exists($id))
              {
                   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                   redirect('admin/fee_extras');
              }
              //search the item to show in edit form
              $get = $this->fee_extras_m->find($id);
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
                           'ftype' => $this->input->post('ftype'),
                           'cycle' => $this->input->post('cycle'),
                           'amount' => $this->input->post('amount'),
                           'discounted' => $this->input->post('discounted'),
                           'description' => $this->input->post('description'),
                           'modified_by' => $user->id,
                           'modified_on' => time());
                   $done = $this->fee_extras_m->update_attributes($id, $form_data);
                   
                   if ($done)
                   {
                        
						 $details = implode(' , ', $this->input->post());
								$user = $this->ion_auth->get_user();
									$log = array(
										'module' =>  $this->router->fetch_module(), 
										'item_id' => $done, 
										'transaction_type' => $this->router->fetch_method(), 
										'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$done, 
										'details' => $details,   
										'created_by' => $user -> id,   
										'created_on' => time()
									);

								  $this->ion_auth->create_log($log);
								  
								  
						$this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                        redirect("admin/fee_extras/");
                   }
                   else
                   {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                        redirect("admin/fee_extras/");
                   }
              }
              else
              {
                   foreach (array_keys($this->validation()) as $field)
                   {
                        if (isset($_POST[$field]))
                        {
                             $get->$field = $this->form_validation->$field;
                        }
                   }
              }
              $data['result'] = $get;
              //load the view and the layout
              $this->template->title('Edit Fee Extras ')->build('admin/create', $data);
         }

         function delete($id = NULL, $page = 1)
         {
              //filter & Sanitize $id
              $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;
              //redirect if its not correct
              if (!$id)
              {
                   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                   redirect('admin/fee_extras');
              }
              //search the item to delete
              if (!$this->fee_extras_m->exists($id))
              {
                   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                   redirect('admin/fee_extras');
              }
              //delete the item
              if ($this->fee_extras_m->delete($id) == TRUE)
              {
                    //$details = implode(' , ', $this->input->post());
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
              redirect("admin/fee_extras/");
         }

         private function validation()
         {
              $config = array(
                      array(
                              'field' => 'title',
                              'label' => 'Title',
                              'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                      array(
                              'field' => 'ftype',
                              'label' => 'Ftype',
                              'rules' => 'required|xss_clean'),
                      array(
                              'field' => 'amount',
                              'label' => 'Amount',
                              'rules' => 'required|trim|xss_clean|numeric|max_length[20]'),
                      array(
                              'field' => 'cycle',
                              'label' => 'Payable Type',
                              'rules' => 'required|trim'),
                      array(
                              'field' => 'discounted',
                              'label' => 'Discounted',
                              'rules' => 'required|trim'),
                      array(
                              'field' => 'description',
                              'label' => 'Description',
                              'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
              );
              $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
              return $config;
         }

         private function set_paginate_options()
         {
              $config = array();
              $config['base_url'] = site_url() . 'admin/fee_extras/index/';
              $config['use_page_numbers'] = TRUE;
              $config['per_page'] = 1000000;
              $config['total_rows'] = $this->fee_extras_m->count();
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

         public function get_All(){
              echo '<pre>';
              print_r($this->fee_extras_m->getInvoiced());
              echo '</pre>';
          //     $in= $this->fee_extras_m->getInvoiced();
          //     foreach($in as $value){
          //          echo 'Date-'.date('d/m/Y', $value->created_on).'<br>';
          //     }


         }

         public function updateInv(){
              $in= $this->fee_extras_m->getInvoiced();
              foreach($in as $value){
                         // echo 'Date-'.date('d/m/Y', $value->created_on).'<br>';
                    $id= $value->id;
                    // $created_on="230,229";
                    $data= array(
                         'created_on' => time()
                    );
                    $this->fee_extras_m->updateAll_($id, $data);
             }
     
         }

         function edit_invoices()
         {
               if($this->input->post())
               {
                    $items =  $this->input->post('items');
                    $amount =  $this->input->post('amount');
                    $user = $this->ion_auth->get_user();

                    if(is_array($items) && count($items))
                    {
                         $count =  count($items);
                         $k = 0;
                         for($i=0; $i<$count; $i++)
                         {
                              $data = [
                                   'amount' =>  $amount[$i],
                                   'modified_on' => time(),
                                   'modified_by' => $user->id
                              ];

                              $ok =  $this->fee_extras_m->updateAll_($items[$i], $data);
                              $k++;
                         }

                         if($ok)
                         {
                                 $mess = 'Updated:  ' . $k. ' Records';
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $mess));
                         }
                         else
                         {
                               $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                         }

                         redirect('admin/fee_extras/edit_invoices/');

                    }
                   
               }
               $data['items'] = $this->fee_extras_m->get_f_extras();
               $data['extras'] = $this->fee_extras_m->populate('fee_extras','id', 'title');
               $this->template->title('Edit Transport')->build('admin/edit_trans', $data);
         }

         
         function invoice_xtra()
         {

          $this->load->model('fee_structure/fee_structure_m');
          $xr = [
              'student' => 6,
              'term' => 2,
              'year' => 2022,
              'amount' => 9700,
              'description' => 'Transport',
              'fee_id' => 16,
              'created_on' => time(),
              'created_by' => 2,
              'qb_status' => 0,
              'status' => 0,
              'flagged' => 0,
          ];

          $this->fee_structure_m->invoice_fee($xr);
         }

         function invoice_tx()
         {

          $this->load->model('transport/transport_m');
          $rt = [
              'student' => 654,
              'term' => 2,
              'year' => 2022,
              'route' => 1,
              'way' => 2,
              'status' => 1,
              'created_on' => time(),
              'created_by' => 2,
          ];

          $ok = $this->transport_m->create($rt);

          echo $ok;
         }

         function count_trans()
          {

        $this->load->model('transport/transport_m');
        $this->load->model('fee_structure/fee_structure_m');
        $settings =  $this->ion_auth->settings();
        $extras = $this->fee_extras_m->_get_trans_invoices();
        $transport = $this->fee_extras_m->get_transport_stds();
        $trans = [];
        $x = [];
        $ft = [];
        $fx = [];

        foreach ($transport as $t)
        {
            $ft[$t->student] = $t->student;
            $trans[$t->student][] = [
                'student' => $t->student,
                'term' => $t->term,
                'year' => $t->year,
            ];
        }

        foreach ($extras as $ex)
        {
              $fx[$ex->student] = $ex->student;
            $x[$ex->student][] = [
                'student' => $ex->student,
                'term' => $ex->term,
                'year' => $ex->year,
            ];
        }
        
        $misx=[];
        foreach ($fx as $f)
        {
            if (!array_key_exists($f, $ft))
            {
                 $misx[]=$f;
            }
        }
        $mist=[];
        foreach ($ft as $t)
        {
            if (!array_key_exists($t, $fx))
            {
                 $mist[]=$t;
            }
        }

        //invoice transport

        $up = 0;
        foreach($misx as $key => $stude)
        {

           $record = $this->fee_extras_m->v_look_t($stude);
           if(!empty($record->student))
           {
                $rt = [
                    'student' => $record->student,
                    'term' => $settings->term,
                    'year' => $settings->year,
                    'route' => $record->route,
                    'way' => $record->way,
                    'status' => 1,
                    'created_on' => time(),
                    'created_by' => 2,
                    'stage' => $record->stage
                ];


               $has_rt = $this->transport_m->has_route($record->route, $record->student, $settings->term, $settings->year);

               if($has_rt)
               {
                     $put = $this->transport_m->set_route_update($has_rt, $rt);
               }
               else
               {
                    $put = $this->transport_m->create($rt);
               }


          }
        }

        //invoice extra
        foreach($mist as $key => $pupil)
        {
           $record = $this->fee_extras_m->v_look_x($pupil);
           if(!empty($record->student))
           {
               $xr = [
                   'student' => $record->student,
                   'term' => $settings->term,
                   'year' => $settings->year,
                   'amount' => $record->amount,
                   'description' => $record->description,
                   'fee_id' => $record->fee_id,
                   'created_on' => time(),
                   'created_by' =>2,
                   'qb_status' => 0,
                   'status' => 0,
                   'flagged' => 0,
               ];

               $has_id = $this->fee_structure_m->is_invoiced($record->fee_id, $record->student, $settings->term, $settings->year);

               if(!$has_id)
               {
                    $rid = $this->fee_structure_m->invoice_fee($xr);
               }
           }
        }

        



        
        // echo '<pre>not in Transport';
        // print_r($misx);
        // echo '</pre>';
        
        // echo '<pre>not in Extras';
        // print_r($mist);
        // echo '</pre>';
        $data['misx'] = $misx;
        $data['mist'] = $mist;

        $this->template->title(' Comparison ')->build('admin/comparison', $data);
        
    }


    }
    