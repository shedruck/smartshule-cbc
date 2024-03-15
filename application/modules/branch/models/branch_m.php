<?php
class Branch_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
        $this->db_set_();
        $this->db__set();
    }

    function create($data)
    {
        $this->db->insert('branch', $data);
        return $this->db->insert_id();
    }

    function create_($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('branch')->row();
    }

    function find_student($id)
    {
        return $this->db->where('student', $id)->get('transfered_students')->row();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('branch') > 0;
    }


    function count()
    {

        return $this->db->count_all_results('branch');
    }

    function update_attributes($id, $data)
    {
        return  $this->db->where('id', $id)->update('branch', $data);
    }

    function populate($table, $option_val, $option_text)
    {
        $query = $this->db->select('*')->order_by($option_text)->get($table);
        $dropdowns = $query->result();
        $options = array();
        foreach ($dropdowns as $dropdown) {
            $options[$dropdown->$option_val] = $dropdown->$option_text;
        }
        return $options;
    }

    function delete($id)
    {
        return $this->db->delete('branch', array('id' => $id));
    }

    /**
     * Setup DB Table Automatically
     * 
     */
    function db_set()
    {
        $this->db->query(
            " 
	 CREATE TABLE IF NOT EXISTS  branch (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
	location  varchar(256)  DEFAULT '' NOT NULL, 
	url  text  , 
    client_id text,
    client_secret text,
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ;
    "
        );
    }

    function db_set_()
    {
        $this->db->query("
        CREATE TABLE IF NOT EXISTS `transfered_students` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`student` INT(11) NULL DEFAULT '0',
    `branch` INT(11) NULL DEFAULT '0',
	`transfered_to` TEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`created_on` INT(11) NULL DEFAULT '0',
	`created_by` INT(11) NULL DEFAULT '0',
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
");
    }

    function db__set()
    {
        $this->query("
            CREATE TABLE  IF NOT EXISTS `received_students` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`student` INT(11) NULL DEFAULT '0',
	`branch` INT(11) NULL DEFAULT '0',
	`received_from` TEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`created_on` INT(11) NULL DEFAULT '0',
	`created_by` INT(11) NULL DEFAULT '0',
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=2
;

        ");
    }

    function paginate_all($limit, $page)
    {
        $offset = $limit * ($page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('branch', $limit, $offset);

        $result = array();

        foreach ($query->result() as $row) {
            $result[] = $row;
        }

        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }

    function fetch_students($class)
    {
        $this->select_all_key('admission');
        return $this->db
            ->where($this->dx('class') . " ='" . $class . "'", NULL, FALSE)
            ->where($this->dx('status') . ' = 1', NULL, FALSE)
            // ->limit('10')
            ->get('admission')
            ->result();
    }

    function fetch_branches()
    {
        return $this->db->get('branch')->result();
    }

    function transfer($data)
    {
        $this->db->insert('incoming_learners', $data);
        return $this->db->insert_id();
    }

    function find_emmergency($id)
    {
        $this->select_all_key('emergency_contacts');

        return $this->db->where($this->dx('student') . '=' . $id, NULL, FALSE)->get('emergency_contacts')->row();
    }

    function find_balance($id)
    {
        $this->select_all_key('new_balances');

        return $this->db->where($this->dx('student') . '=' . $id, NULL, FALSE)->get('new_balances')->row();
    }



    function full_student_details($id)
    {
        $this->select_all_key('admission');

        $list = $this->db->where('id', $id)->get('admission')->row();

        $list->parentData = $this->portal_m->get_parent($list->parent_id);

        $list->parentUser = $this->ion_auth->get_user($list->parent_user);

        $list->studentUser = $this->ion_auth->get_user($list->user_id);

        $list->emergency = $this->find_emmergency($list->id);

        $list->balance = $this->find_balance($list->id);

        // invoices,transport, fee_extras, 

        return $list;
    }

    function get_parent($phone, $email)
    {
        $this->select_all_key('parents');
        $rw = $this->db
            ->where($this->dx('phone') . "='" . $phone . "'", NULL, FALSE)
            ->or_where($this->dx('email') . "='" . $email . "'", NULL, FALSE)
            ->get('parents')
            ->row();
        return empty($rw) ? FALSE : $rw->id;
    }


    function update_student($id, $data)
    {
        return $this->update_key_data($id, 'admission', $data);
    }

   

    function load_transfered($postData = null)
    {

        $response = [];

        // $this->select_all_key('admission');


        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value



        ## Total number of records without filtering
        $this->select_all_key('admission');
        $this->db->select('count(id) as allcount');
        $records = $this->db->where($this->dx('status'). '=4', NULL,FALSE)->get('admission')->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->select_all_key('admission');
        $this->db->select('count(id) as allcount');

        if ($searchValue != '') {
            $this->db->where($this->dx('phone') . " LIKE '%" . $searchValue . "%' ", NULL, FALSE)
                ->or_where('CONVERT(' . $this->dx('first_name') . " USING 'latin1') " . " LIKE '%" . $searchValue . "%' ", NULL, FALSE)
                ->or_where('CONVERT(' . $this->dx('last_name') . " USING 'latin1') " . " LIKE '%" . $searchValue . "%' ", NULL, FALSE)
                ->or_where('CONVERT(' . $this->dx('middle_name') . " USING 'latin1') " . " LIKE '%" . $searchValue . "%' ", NULL, FALSE);
        }
        $this->db->where($this->dx('status') . " = 4", NULL, FALSE);
        $records = $this->db->get('admission')->result();
        $totalRecordwithFilter = $records[0]->allcount;


        ## Fetch records
        $this->select_all_key('admission');
        if ($searchValue != '') {
            $this->db->where($this->dx('phone') . " LIKE '%" . $searchValue . "%' ", NULL, FALSE)
                ->or_where('CONVERT(' . $this->dx('first_name') . " USING 'latin1') " . " LIKE '%" . $searchValue . "%' ", NULL, FALSE)
                ->or_where('CONVERT(' . $this->dx('last_name') . " USING 'latin1') " . " LIKE '%" . $searchValue . "%' ", NULL, FALSE)
                ->or_where('CONVERT(' . $this->dx('middle_name') . " USING 'latin1') " . " LIKE '%" . $searchValue . "%' ", NULL, FALSE);
        }
        
        $this->db->where($this->dx('status') . " = 4", NULL, FALSE);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('admission')->result();

        $data = [];

        $st = [
            1 => '<span class="badge badge-success">Active</span>', 0 => '<span class="badge badge-danger">Inactive</span>'
        ];
        $i = 1;
        
        foreach ($records as $p) {
           $st = $this->find_student($p->id);
           $user = $this->ion_auth->get_user($p->created_by);
            $branch = $this->find($st->branch);
            $name = isset($branch->name) ? $branch->name : 'Virtual Account';
            $tag = '<a href="'.$st->transfered_to.'" target="_blank">'.$name.'</a>';
            $data[] = array(
                'index' => $i,
                "name" => $p->first_name.' '.$p->middle_name.' '.$p->last_name,
                "class" => isset($this->streams[$p->class]) ? $this->streams[$p->class] : '',
                'to' => $tag,
                'date' => date('dS M Y',$st->created_on),
                'user' => $user->first_name . ' ' . $user->last_name,
                'student' => $p->id,
            );
            $i++;
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );


        return $response;
    }
}
