<?php
class Appraisal_targets_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('appraisal_targets', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('appraisal_targets')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('appraisal_targets') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('appraisal_targets');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('appraisal_targets', $data);
    }

function populate($table,$option_val,$option_text)
{
    $query = $this->db->select('*')->order_by($option_text)->get($table);
     $dropdowns = $query->result();
       $options=array();
    foreach($dropdowns as $dropdown) {
        $options[$dropdown->$option_val] = $dropdown->$option_text;
    }
    return $options;
}

    function delete($id)
    {
        return $this->db->delete('appraisal_targets', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  appraisal_targets (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	term  varchar(32)  DEFAULT '' NOT NULL, 
	year  varchar(256)  DEFAULT '' NOT NULL, 
	target  varchar(256)  DEFAULT '' NOT NULL, 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
      }
      
    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('appraisal_targets', $limit, $offset);

            $result = array();

            foreach ($query->result() as $row)
            {
                $result[] = $row;
            }

            if ($result)
            {
                    return $result;
            }
            else
            {
                    return FALSE;
            }
    }

    public function checkpast_date(){
        // $today=date('m/d/y', time());
        $this->load->helper('date');
        $format = "%Y-%m-%d";
        $today =mdate($format);
        return $this->db->order_by('target','ASC')->where('end_date >',$today)->get('appraisal_targets')->result();
    }

    public function getteachers(){
        $this->select_all_key('teachers');
        return $this->db->order_by('id','DESC')->get('teachers')->result();
    }

    public function insertresults($data)
    {
        return  $this->db->insert('appraisal_results', $data);
    }

    public function getappraisalresults(){
        $this->select_all_key('teachers');
        $this->select('appraisal_results.*');
        $this->select('appraisal_targets.*');
        return $this->db
                    ->order_by('appraisal_results.appraisal_id','DESC')
                    ->join('appraisal_targets','appraisal_targets.id=appraisal_results.target')
                    ->join('teachers','teachers.id=appraisal_results.teacher')
                    ->get('appraisal_results')
                    ->result();
    }

    public function appraisalresult(){
        $user_id= $this->ion_auth->get_user()->id;
        $this->select_all_key('teachers');
        $this->select('appraisal_results.*');
        $this->select('appraisal_targets.*');
        return $this->db
                    ->join('appraisal_targets','appraisal_targets.id=appraisal_results.target')
                    ->join('teachers','teachers.id=appraisal_results.teacher')
                    ->where('appraisal_results.user_id',$user_id)
                    ->get('appraisal_results')
                    ->result();
    }

    public function filterresults_byteacher($teacher){
        $this->select_all_key('teachers');
        $this->select('appraisal_results.*');
        $this->select('appraisal_targets.*');
        return $this->db
                    ->join('appraisal_targets','appraisal_targets.id=appraisal_results.target')
                    ->join('teachers','teachers.id=appraisal_results.teacher')
                    ->where('appraisal_results.teacher',$teacher)
                    ->get('appraisal_results')
                    ->result();
    }

    public function filterresults_bytarget($target){
        $this->select_all_key('teachers');
        $this->select('appraisal_results.*');
        $this->select('appraisal_targets.*');
        return $this->db
                    ->join('appraisal_targets','appraisal_targets.id=appraisal_results.target')
                    ->join('teachers','teachers.id=appraisal_results.teacher')
                    ->where('appraisal_results.target',$target)
                    ->get('appraisal_results')
                    ->result();
    }

    public function listteachers(){
        $this->select_all_key('teachers');
        $this->select('appraisal_results.*');
        $this->select('appraisal_targets.*');
        return $this->db
                    ->group_by('appraisal_results.teacher')
                    ->join('appraisal_targets','appraisal_targets.id=appraisal_results.target')
                    ->join('teachers','teachers.id=appraisal_results.teacher')
                    ->get('appraisal_results')
                    ->result();
    }

    public function appraisetacher($id,$data){
         return $this->db
                        ->where('appraisal_id', $id) 
                        ->update('appraisal_results', $data);
    }

}