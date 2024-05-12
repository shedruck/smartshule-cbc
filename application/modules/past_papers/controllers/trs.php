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
    $this->load->model('past_papers_m');
  }

  public function index()
  {
    $config = $this->set_paginate_options(); //Initialize the pagination class
    $this->pagination->initialize($config);
    $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
    $data['enotes'] = $this->enotes_m->get_all_enotes($config['per_page'], $page);

    //create pagination links
    $data['links'] = $this->pagination->create_links();

    //page number  variable
    $data['page'] = $page;
    $data['per'] = $config['per_page'];

    //load view
    // $this->template->title(' E-notes ')->build('trs/list', $data);
  }

  function past_papers()
  {

    $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
    $data['past_papers'] = $this->past_papers_m->folders(10000000, 1);

    //load view
    $this->template->title('All Past Papers ')->build('trs/pp-folders', $data);
  }


  function view_past_papers($id = FALSE, $page = NULL)
  {
    //redirect if no $id
    if (!$id) {
      $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
      redirect('past_papers/trs/past_papers');
    }

    $data['folder'] = $id;
    $data['pp'] = $this->past_papers_m->by_folder($id);

    //create pagination links
    $data['links'] = $this->pagination->create_links();
    //load the view and the layout
    $this->template->title('View Past Papers ')->build('trs/pp-files', $data);
  }
  
  

  /**
   * Shows a Sane File Size 
   * 
   * @param double $kb
   * @param int $precision
   * @return double
   */


  private function validation()
  {
    $config = array(
      array(
        'field' => 'term',
        'label' => 'Term',
        'rules' => 'required|trim'
      ),

      array(
        'field' => 'year',
        'label' => 'Year',
        'rules' => 'required|trim'
      ),

      array(
        'field' => 'class',
        'label' => 'Class',
        'rules' => 'required|trim'
      ),

      array(
        'field' => 'subject',
        'label' => 'Subject',
        'rules' => 'required|trim'
      ),

      array(
        'field' => 'topic',
        'label' => 'Topic',
        'rules' => 'trim'
      ),
      array(
        'field' => 'subtopic',
        'label' => 'Sub Topic',
        'rules' => 'trim'
      ),

      array(
        'field' => 'soft',
        'label' => 'Soft',
        'rules' => 'trim'
      ),

      array(
        'field' => 'remarks',
        'label' => 'Remarks',
        'rules' => 'trim'
      ),
    );
    $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
    return $config;
  }


  private function set_paginate_options()
  {
    $config = array();
    $config['base_url'] = site_url() . 'enotes/trs/index/';
    $config['use_page_numbers'] = TRUE;
    $config['per_page'] = 100;
    $config['total_rows'] = $this->enotes_m->count();
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

  private function set_upload_options($controller, $field)
  {
    //upload an image options
    $config = array();
    if ($field == 'file') {
      $config['upload_path']     = FCPATH . 'assets/uploads/' . $controller . '/files/';
      $config['allowed_types']   = 'pdf';
      $config['max_size']     = '2048';
      $config['encrypt_name']    = TRUE;
    }
    //create controller upload folder if not exists
    if (!is_dir($config['upload_path'])) {
      mkdir(FCPATH . "public/uploads/$controller/");
      mkdir(FCPATH . "public/uploads/$controller/files/");
      mkdir(FCPATH . "public/uploads/$controller/img/");
      mkdir(FCPATH . "public/uploads/$controller/img/thumbs/");
    }

    return $config;
  }
}
