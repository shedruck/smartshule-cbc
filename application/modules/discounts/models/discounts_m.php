<?php
class Discounts_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('discount_groups', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('discount_groups')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('discount_groups') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('discount_groups');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('discount_groups', $data);
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
        return $this->db->delete('discount_groups', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  discounts (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
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
            $query = $this->db->get('discount_groups', $limit, $offset);

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

    function active_groups()
    {
        $list = $this->db->where('status',1)->get('discount_groups')->result();

        $drp = [];
        foreach($list as $l)
        {
            $drp[$l->id] = ucfirst($l->name).' ('.$l->percentage.' %)';
        }

        return $drp;
    }

    function save_data($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }


    function update_data($table, $id, $data)
    {
         return  $this->db->where('id', $id) ->update($table, $data);
    }

    function has_group($student)
    {
        $list = $this->db
                    ->where('student', $student)
                    ->where('status',1)
                    ->get('discounts_assign')
                    ->row();
        if (empty($list))
        {
                return FALSE;
        }
        else
        {
                return $list->id;
        }
    }

    function filter_students($group, $class = false)
    {
        $list = $this->portal_m->list_students($class);
        

        if ($class)
        {
            $this->db->_protect_identifiers = FALSE;
            $this->db->where_in('student', $list, FALSE);
            $this->db->_protect_identifiers = TRUE;
        }

        $this->db->select('discounts_assign.*' , FALSE);
        $this->db->join('admission', 'admission.id= student');
        $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
        $res = $this->db->get('discounts_assign')->result();

        return $res;
    }

    function get_std_invoices($student, $term, $year)
    {
        $invoices = [];
        $tt =  $this->db
                    ->where('term',$term)
                    ->where('year',$year)
                    ->where('student_id',$student)
                    ->where('check_st',1)
                    ->get('invoices')
                    ->result();

        foreach($tt as $t)
        {
            $invoices[] = [
                'type' => 'Tuition',
                'amount' => $t->amount,
                'fee_id' => $t->fee_id,
                'student' => $t->student_id
            ];
        }

        $this->select_all_key('fee_extra_specs');
        $extra = $this->db
                      // ->where($this->dx('status') . ' = 1', NULL, FALSE)
                      ->where($this->dx('term') . ' = '.$term, NULL, FALSE)
                      ->where($this->dx('year') . ' = '.$year, NULL, FALSE)
                      ->where($this->dx('student') . ' = '.$student, NULL, FALSE)
                      ->get('fee_extra_specs')
                      ->result();

        foreach($extra as $x)
        {
             $invoices[] = [
                'type' => 'Extras',
                'amount' => $x->amount,
                'fee_id' => $x->fee_id,
                'student' => $x->student
            ];
        }


        $trans = $this->db
                      ->where('term',$term)
                      ->where('year',$year)
                      ->where('student',$student)
                      ->where('status',1)
                      ->get('transport')
                      ->result();

        foreach($trans as $tr)
        {
            $invoices[] = [
                'type' => 'Transport',
                'amount' => $tr->amount,
                'fee_id' => $tr->route,
                'student' => $tr->student
            ];
        }

        return $invoices;
    }

    function discounted_fee($id)
    {
        return $this->db->where('id',$id)->where('discounted',1)->get('fee_extras')->row();
    }

    function get_percentages()
    {
        $list = $this->db->get('discounts_assign')->result();
        $drp =[];
        foreach($list as $l)
        {
            $drp[$l->student] = $l->percentage;
        }
        return $drp;
    }



    function has_discount($student, $term, $year)
    {
        $list = $this->db
                    ->where('student', $student)
                    ->where('term', $term)
                    ->where('year', $year)
                    ->where('status',1)
                    ->get('discounts')
                    ->row();
        if (empty($list))
        {
                return FALSE;
        }
        else
        {
                return $list->id;
        }
    }


    function get_discounts($term = false, $year = false, $group = false)
    {
        if($group)
        {
            $this->db->where('group',$group);
        }

        if($term)
        {
            $this->db->where('term',$term);
        }

        if($year)
        {
            $this->db->where('year',$year);
        }

        $list = $this->db->where('status',1)->get('discounts')->result();

        $payload = [];
        $grp = $this->populate('discount_groups','id','name');
        $pers = $this->get_percentages();
        foreach($list as $l)
        {
            $st = $this->worker->get_student($l->student);
            $payload[] = [
                'id' => $l->id,
                'student' => ucfirst($st->first_name.' '.$st->middle_name.' '.$st->last_name),
                'adm' => $st->admission_number ? $st->admission_number : $st->old_adm_no,
                'amount' => $l->amount,
                'total' => $l->total,
                'term' => $l->term,
                'year' => $l->year,
                'group' => isset($grp[$l->group]) ? $grp[$l->group] : ' - ',
                'percentage' =>  isset($pers[$l->student]) ? $pers[$l->student] : 0,
                'class' => isset($this->streams[$st->class]) ? $this->streams[$st->class] : ' - '
            ];
        }

        return $payload;
    }


}