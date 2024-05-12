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

        $this->load->model('trs_m');
        $this->load->model('messages/messages_m');
    }


    public function index()
    {
        $data['years'] = $this->trs_m->appraisalyears();
        $data['rules'] = $this->trs_m->checkappraisee_rate();
        $data['targets'] = $this->trs_m->checkpast_date();
        $data['teacher'] = $this->trs_m->getteacher();
        if ($this->input->post()) {
            $this->form_validation->set_rules('target_id', 'Target', 'required');
            $this->form_validation->set_rules('teacher', 'teacher', 'required');

            if (!$this->form_validation->run()) {
                //load view
                $this->template->title('Add Book List ')->build('admin/appraise', $data);
            } else {
                $teacher = $this->input->post('teacher');
                $user_id = $this->ion_auth->get_user()->id;

                $target_id = $this->input->post('target_id');
                $rate = $this->input->post('rate');
                foreach ($target_id as $t_id) {
                    foreach ($rate as $r) {
                        $data = array(
                            'target' => $t_id,
                            'user_id' => $user_id,
                            'teacher' => $teacher,
                            'appraisee_rate' => $r,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );
                    }

                    // if($this->trs_m->limitteacher($t_id,$teacher)){
                    //     $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => 'You have already appraised this target' ));
                    // }else{
                    $ok = $this->trs_m->insertresults($data);
                    // }
                }
                $this->template->title(' Teacher | Appraisal ')->build('teachers/index', $data);

                if ($ok) {
                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                } else {
                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                }

                redirect('appraisal_targets/trs');
            }
        }
        $this->template->title('Appraisal Reports')->build('teachers/index', $data);
    }

    public function selfAppraisal($target){
     
        $data['targets']=$this->trs_m->get_target_by_id($target);
        $data['teacher']= $this->trs_m->getteacher();
 
        if( $this->input->post()){
          $rate= $this->input->post('rate');
          $teacher= $this->input->post('teacher');
             $data= array(
                 'target' =>$target,
                 'user_id'=>$this->ion_auth->get_user()->id,
                 'teacher'=>$teacher,
                 'appraisee_rate'=>$rate,
                 'created_on'=>time(),
                 'created_by'=>$this->ion_auth->get_user()->id
             );
 
               $ok= $this->trs_m->insertresults($data);
                    
                  $this->template->title(' Teacher | Appraisal ' )->build('teachers/index',$data);
                  
                  if ( $ok)
                  {
                          $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
                  }
                  else
                  {
                          $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
                  }
      
                  redirect('appraisal_targets/trs');
          }
        $this->template->title('Teacher | Self Appraisal')->build('teachers/appraisal_form',$data);
 
    }

    public function appraisalResults(){

        if ($this->input->post()) {
            $year = $this->input->post('year');
            $term = $this->input->post('term');

            $data['results']=$this->trs_m->appraisalresults($year,$term);
        }
        
        $this->template->title('Appraisal Reports')->build('teachers/appraisal_results',$data);
       }
}
