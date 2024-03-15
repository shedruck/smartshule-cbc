<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends Public_Controller
{

        function __construct()
        {
                parent::__construct();

                if (!$this->ion_auth->logged_in())
                {
                        redirect('login');
                }
 
                $this->template
                             ->set_layout('default.php')
                             ->set_partial('meta', 'partials/meta.php')
                             ->set_partial('header', 'partials/header.php')
                             ->set_partial('sidebar', 'partials/sidebar.php')
                             ->set_partial('footer', 'partials/footer.php');
 
                $this->load->model('messages_m');
        }

        public function index()
        {
                $feed = $this->messages_m->get_feed(array($this->user->id));

                $data['messages'] = $feed;
                $this->template
                             ->title('Messages & Feedback')
                             ->build('index/messages', $data);
        }

             /**
         * View Message conversation
         * 
         * @param type $id
         */
        public function view($id)
        {
                $this->form_validation->set_rules($this->_rep_validation());
                $message = $this->messages_m->get_message($id);

                if ($this->form_validation->run())
                {
                        $rep = $this->input->post('message');
                        $user = $this->ion_auth->get_user();
                        $last = $this->messages_m->get_last($id);
                        $form = array(
                            'sender' => $user->id,
                            'convo_id' => $id,
                            'recipient' => $last->created_by == $this->ion_auth->get_user()->id ? $last->recipient : $last->created_by,
                            'message' => $rep,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $this->messages_m->create_convo($form);
                        redirect('messages/view/' . $id);
                }
				
				 $feed = $this->messages_m->get_feed(array($this->user->id));

                $data['feed'] = $feed;
				
                $data['message'] = $message;
                $this->template
                             ->title('View Message')
                             ->build('index/view', $data);
        }

        function create()
        {
                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {
                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'title' => $this->input->post('title'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->messages_m->create($form_data);

                        if ($ok)
                        {
                                $form = array(
                                    'convo_id' => $ok,
                                    'sender' => $user->id,
                                    'recipient' => $this->input->post('to'),
                                    'message' => $this->input->post('message'),
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );

                                $this->messages_m->create_convo($form);

                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('messages');
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
                        $this->template->title('New Message')->build('index/create', $data);
                }
        }

        private function _rep_validation()
        {
                $config = array(
                    array(
                        'field' => 'message',
                        'label' => 'Message',
                        'rules' => 'required|trim'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'message',
                        'label' => 'Message',
                        'rules' => 'required|max_length[10000]'),
                    array(
                        'field' => 'title',
                        'label' => 'Message Title',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'to',
                        'label' => 'Recipient',
                        'rules' => 'required')
                );
                $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
                return $config;
        }

}
