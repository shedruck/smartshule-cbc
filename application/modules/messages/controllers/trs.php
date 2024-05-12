<?php defined('BASEPATH') or exit('No direct script access allowed');

class Trs extends Trs_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->ion_auth->logged_in()) {
            if (!$this->is_teacher) {
                redirect('admin');
            }
        } else {
            redirect('login');
        }

        // $this->load->model('lesson_materials_m');
        $this->load->model('messages/messages_m');
    }

    public function index()
    {
        $feed = $this->messages_m->get_feed(array($this->user->id));

        $data['messages'] = $feed;
        $this->template
                          ->title('Messages & Feedback')
                          ->build('teachers/messages', $data);
    }

    function new_message()
    {
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {
            $user = $this->ion_auth->get_user();

            $recps = $this->input->post('to');
            foreach ($recps as $r)
            {
                $form_data = array(
                    'title' => $this->input->post('title'),
                    'created_by' => $user->id,
                    'created_on' => time()
                );

                $msid = $this->messages_m->create($form_data);

                if ($msid)
                {
                    $form = array(
                        'convo_id' => $msid,
                        'sender' => $user->id,
                        'recipient' => $r,
                        'seen' => 0,
                        'message' => $this->input->post('message'),
                        'created_by' => $user->id,
                        'created_on' => time()
                    );

                    $this->messages_m->create_convo($form);
                }
            }
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            redirect('trs/messages');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }
            $data['result'] = $get;
            $data['parents'] = $this->messages_m->list_class_parents();

            //load the view and the layout
            $this->template->title('New Message')->build('teachers/create', $data);
        }
    }

    public function view_message($id)
    {
        $this->form_validation->set_rules($this->_rep_validation());
        $message = $this->messages_m->get_message($id);
        //set seen
        if ($this->input->get('st'))
        {
            $last = $this->messages_m->get_last($id);
            $this->messages_m->update_link($last->id, array('seen' => 1, 'modified_on' => time()));
        }

        $valid = $this->messages_m->list_mine(array($this->user->id));
        //limit access to my messages when manipulating the id in url
        if (!in_array($id, $valid))
        {
            redirect('messages/trs');
        }
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
            redirect('messages/trs/view_message/' . $id);
        }
        $data['message'] = $message;
        $this->template
                          ->title('View Message')
                          ->build('teachers/view', $data);
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
