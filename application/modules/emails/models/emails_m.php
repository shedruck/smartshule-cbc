<?php
class Emails_m extends MY_Model{

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


    function create($data)
    {
    	$query = $this->db->insert('emails', $data);
    	return $query;
    }
	
// Get applicant Email address	
	
function get_applicant()
    {

        $data = $this->db->select('applications.*')
                ->get('applications')
                ->result();
        $arr = array();

        foreach ($data as $dat)
        {

            $arr[$dat->id] = $dat->first_name.' '.$dat->last_name.' ('.$dat->email.' )';
        }
        return $arr;
    }

	
function get_job()
    {

        $data = $this->db->select('jobs.*')
                ->get('jobs')
                ->result();
        $arr = array();

        foreach ($data as $dat)
        {

            $arr[$dat->id] = $dat->job_title.' ( Ref No.: '.$dat->reference_no.' )';
        }
        return $arr;
    }


    function get_applicant_details($applicant_id,$job_id)
    {
    	$query = $this->db->select('applications.*')
		          ->where('applications.id',$applicant_id)
				  ->where('applications.job_id',$job_id)
				  ->get('applications')
				  ->row();
    	return $query;
     }

 function find($id)
    {
    	$query = $this->db->get_where('emails', array('id' => $id));
    	return $query->row();
     }


    function exists($id)
    {
    	$query = $this->db->get_where('emails', array('id' => $id));
    	$result = $query->result();

    	if ($result)
    		return TRUE;
    	else
    		return FALSE;
    }


    function count()
    {
    	
    	return $this->db->count_all_results('emails');
    }


    function update_attributes($id, $data)
    {
    	$this->db->where('id', $id);
		$query = $this->db->update('emails', $data);

		return $query;
    }

function populate($table,$option_val,$option_text)
{
    $query = $this->db->select('*')->order_by($option_text)->get($table);
     $dropdowns = $query->result();

    foreach($dropdowns as $dropdown) {
        $options[$dropdown->$option_val] = $dropdown->$option_text;
    }
    return $options;
}


    function delete($id)
    {
    	$query = $this->db->delete('emails', array('id' => $id));

    	return $query;
    }


	function paginate_all($limit, $page)
	{
		$offset = $limit * ( $page - 1) ;
		
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('emails', $limit, $offset);

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
}