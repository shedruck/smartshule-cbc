<?php

class Transport_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function create($data)
        {
                $this->db->insert('transport', $data);
                return $this->db->insert_id();
        }
        
        function add_extras_1($daata){
                $this->db->insert('fee_extras', $daata);
                return $this->db->insert_id();
        }

        function add_extras_2($dataa){
                $this->db->insert('fee_extras', $dataa);
                return $this->db->insert_id();
        }

        function update_extras($id, $data)
        {
                return $this->db->where('id', $id)->update('fee_extras', $data);
        }

        function create_route($data)
        {
                $this->db->insert('transport_routes', $data);
                return $this->db->insert_id();
        }

        function get_routes()
        {
                return $this->db->get('transport_routes')->result();
        }

        /**
         * Transport Report 
         * 
         * @param int $route
         * @param int $class
         * @param int $term
         * @param int $year
         */
        function filter_transport($route, $class, $term, $year, $stage)
        {
                $this->db->select('transport.*');
                if ($class)
                {
                        // $this->db->join('admission', 'admission.id=transport.student');
                        $this->db->where($this->dx('admission.class') . ' = ' . $class, NULL, FALSE);
                        $this->db->where($this->dx('admission.status') . ' = 1' , NULL, FALSE);
                }
                if ($route)
                {
                        $this->db->where('route', (int) $route);
                }
                if ($term)
                {
                        $this->db->where('term', $term);
                }


                if($stage)
                {
                        $this->db->where('stage',$stage);
                }

                if($year){
                        $this->db->where('year', $year);
                }
                return $this->db 
                                          ->join('admission', 'admission.id=transport.student')
                                          ->where('transport.status', 1)
                                          // ->where('custom = 0 OR (custom IS NULL)', NULL, FALSE)
                                          ->where($this->dx('admission.status') . ' = 1' , NULL, FALSE)
                                          ->order_by('transport.id', 'ASC')
                                          ->get('transport')
                                          ->result();
                
        }

        function filter_custom($route, $class, $stage, $term, $year, $desc =false)
        {
                $this->db->select('transport.*');
                if ($class)
                {
                        // $this->db->join('admission', 'admission.id=transport.student');
                        $this->db->where($this->dx('admission.class') . ' = ' . $class, NULL, FALSE);
                        $this->db->where($this->dx('admission.status') . ' = 1' , NULL, FALSE);
                }
                if ($route)
                {
                        $this->db->where('route', (int) $route);
                }
                if ($term)
                {
                        $this->db->where('term', $term);
                }


                if($stage)
                {
                        $this->db->where('stage',$stage);
                }

                if($year){
                        $this->db->where('year', $year);
                }

                return $this->db 
                ->join('admission', 'admission.id=transport.student')
                ->where('transport.status', 1)
                ->where('custom = 1', NULL, FALSE)
                ->where($this->dx('admission.status') . ' = 1' , NULL, FALSE)
                ->order_by('transport.id', 'ASC')
                ->group_by('transport.student')
                ->get('transport')
                ->result();
        }

        function custom_std($route, $class, $stage, $term, $year)
        {

                $this->db->select('transport.*');
                if ($class)
                {
                        $this->db->where($this->dx('admission.class') . ' = ' . $class, NULL, FALSE);
                        $this->db->where($this->dx('admission.status') . ' = 1' , NULL, FALSE);
                }
                if ($route)
                {
                        $this->db->where('route', (int) $route);
                }
                if ($term)
                {
                        $this->db->where('term', $term);
                }


                if($stage)
                {
                        $this->db->where('stage',$stage);
                }

                if($year){
                        $this->db->where('year', $year);
                }
                $list = $this->db
                        ->join('admission', 'admission.id=transport.student')
                        ->where('transport.custom',1)
                        ->where($this->dx('admission.status') . ' = 1' , NULL, FALSE)
                        ->where('transport.status',1)
                        ->get('transport')->result();
                
                $desc = [];

                foreach($list as $l)
                {
                        $user = $this->ion_auth->get_user($l->created_by);
                        $desc[$l->student][] = [
                                'description' => $l->description,
                                'amount' => $l->amount,
                                'created_by' => $user->first_name.' '.$user->last_name
                        ];
                }

                return $desc;
        }

        function custom_prep_total($route, $class, $stage, $term, $year)
        {

                $this->db->select('transport.*');
                if ($class)
                {
                        $this->db->where($this->dx('admission.class') . ' = ' . $class, NULL, FALSE);
                        $this->db->where($this->dx('admission.status') . ' = 1' , NULL, FALSE);
                }
                if ($route)
                {
                        $this->db->where('route', (int) $route);
                }
                if ($term)
                {
                        $this->db->where('term', $term);
                }


                if($stage)
                {
                        $this->db->where('stage',$stage);
                }

                if($year){
                        $this->db->where('year', $year);
                }
                $list = $this->db
                        ->join('admission', 'admission.id=transport.student')
                        ->where('transport.custom',1)
                        ->where($this->dx('admission.status') . ' = 1' , NULL, FALSE)
                        ->where('transport.status',1)
                        ->get('transport')->result();
                
                $data = [];
                foreach($list as $l)
                {
                        $data[$l->student][] = $l->amount;
                }

                $total =[];
                foreach($data as $st => $tt)
                {
                        $total[$st] = array_sum($tt);
                }

                return $total;
        }

        function has_route($student, $term, $year)
        {
                $row = $this->db
                             ->where('student', $student)
                             ->where('term', $term)
                             ->where('year', $year)
                             ->get('transport')
                             ->row();
                if (empty($row))
                {
                        return FALSE;
                }
                else
                {
                        return $row->id;
                }
        }

        function get_route_students($route)
        {
                return $this->db
                                          ->where('route', $route)
                                          ->join('transport_routes','transport_routes.id=transport.route')
                                          ->get('transport')
                                          ->result();
        }

        function set_route_update($rt_id, $data)
        {
                return $this->db->where('id', $rt_id)->update('transport', $data);
        }

        function find_route($id)
        {
                return $this->db->where(array('id' => $id))->get('transport_routes')->row();
        }

        function route_exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('transport_routes') > 0;
        }

        function update_route($id, $data)
        {
                return $this->db->where('id', $id)->update('transport_routes', $data);
        }

        function delete($id, $table)
        {
                return $this->db->delete($table, array('id' => $id));
        }

        function remove_student($id, $table)
        {
                return $this->db->delete($table, array('student' => $id));
        }

        function find($id)
        {
                return $this->db->where(array('id' => $id))->get('transport')->row();
        }

        function this_route($field,$route){

                $res =  $this->db
                ->select($field)
                ->where('id',$route)
                ->get('transport_routes')
                ->result();
                        
                        if($res){
                                return  $res;
                        }else{
                                return false;
                        } 
        }

        function this_route_($field,$route){

                $res =  $this->db
                ->select($field)
                ->where('id',$route)
                ->get('transport_routes')
                ->row();
                        
                $amount = [
                        "one_way_charge" => $res->one_way_charge,
                        "two_way_charge" => $res->two_way_charge
                ];

                return $amount;
                 
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('transport') > 0;
        }

        function count()
        {
                return $this->db->count_all_results('transport');
        }

        function update_attributes($id, $data)
        {
                return $this->db->where('id', $id)->update('transport', $data);
        }

        function populate($table, $option_val, $option_text)
        {
                $query = $this->db->select('*')->order_by($option_text)->get($table);
                $dropdowns = $query->result();
                $options = array();
                foreach ($dropdowns as $dropdown)
                {
                        $options[$dropdown->$option_val] = $dropdown->$option_text;
                }
                return $options;
        }

        function transport_routes()
        {
                return $this->db->get('transport_routes')->result();
        }

        function get_fee_extra($way,$route){
                return $this->db
                        ->where('description',$way)
                        ->where('f_id',$route)
                        ->get('fee_extras')->result();
        }

        function get_fee_extra_($way,$route){
                $data =  $this->db
                        ->where('description',$way)
                        ->where('f_id',$route)
                        ->get('fee_extras')->row();
                return $data->id;
        }

        function invoice_rt($data){
                return $this->insert_key_data('fee_extra_specs', $data);
        }

        function get_stages($id){
                
                return $this->db
                            
                            ->where('route',$id)
                            ->get('transport_stages')
                            ->result();
        }

        function create_stage($data){
                $this->db->insert('transport_stages', $data);
                return $this->db->insert_id();
        }

        function get_rt_stages(){
                $list = $this->db->select('stage_name,id')
                ->get('transport_stages')
                ->result();
                $stages= array();
                foreach($list as $l){
                        $stages[$l->id] = $l->stage_name;
                }
                return $stages;
        }

        function get_f_extras($student){
               
                $this->select_all_key('fee_extra_specs');
                return $this->db
                        ->where($this->dx('student') . '='.$student, NULL, FALSE)
                        ->where($this->dx('description') . '= "Transport"', NULL, FALSE)
                        ->get('fee_extra_specs')->result();
        }

        function list_routes(){
                $list = $this->db->get('transport_routes')->result();
                return $list;

        }

        function fetch_stds($id)
        {
                $this->select_all_key('fee_extra_specs');
                $list = $this->db
                        ->where($this->dx('fee_id') . '='.$id, NULL, FALSE)
                        ->where($this->dx('status') . '= 1', NULL, FALSE)
                        ->get('fee_extra_specs')
                        ->result();
                return $list;

        }

        function transport_stds()
        {
              $this->select_all_key('fee_extra_specs');
                return $this->db
                        ->where($this->dx('status') . '= 1', NULL, FALSE)
                        ->where($this->dx('fee_id') . '>=15', NULL, FALSE)
                        ->where($this->dx('fee_id') . '<=32', NULL, FALSE)
                        // ->where($this->dx('description') . '= "Transport"', NULL, FALSE)
                        ->get('fee_extra_specs')
                        ->result();   
        }

        function get_route_amount()
        {
               
                $list = $this->db
                             ->get('transport_routes')
                             ->result();
                $dt = [];
                foreach($list as $l)
                {
                        $dt[$l->id] = ['one_way_charge' => $l->one_way_charge, 'two_way_charge' => $l->two_way_charge];
                }

                return $dt;
        }

		function is_invoiced($fee, $student, $term, $year)
     {
        $row = $this->db
                                            ->where($this->dx('fee_id') . '=' . $fee, NULL, FALSE)
                                            ->where($this->dx('student') . '=' . $student, NULL, FALSE)
                                            ->where('('.$this->dx('status') . '= 1 OR ' .$this->dx('status').'=0 )', NULL, FALSE)
                                            ->where($this->dx('year') . '=' . $year, NULL, FALSE)
                                            ->where($this->dx('term') . '=' . $term, NULL, FALSE)
                                            ->get('fee_extra_specs')->row();
        if (empty($row))
        {
            return FALSE;
        }
        else
        {
            return $row->id;
        }
    }

     function update_fee($id, $data)
    {
        return $this->db->where('id', $id)->update('fee_extra_specs', $data);
    }


    function get_series()
    {
        $count = $this->db->count_all_results('transport');
        if (!$count)
        {
            $series = 10000;

            return $series;
        }

        $row_max = $this->db
                          ->order_by('id', 'DESC')
                          ->limit(1)
                          ->get('transport')
                          ->row();

        if (empty($row_max->invoice_no))
        {
            return 10000 + ($row_max->id + 1);
        }

        return ((str_replace('INMT', '', $row_max->invoice_no)) + 1);
    }
        function transport_heads()
        {
                $list = $this->db->get('fee_extras')->result();

                $res =[];
                foreach($list as $l)
                {
                        if(!empty($l->f_id))
                        {
                                $res[] = $l->id;
                        }
                        
                }

                return $res;
        }

       function tx_stds($id)
        {
                $this->select_all_key('fee_extra_specs');
                return $this->db
                        
                        ->where($this->dx('fee_id') . '='.$id, NULL, FALSE)
                        ->get('fee_extra_specs')
                        ->result();   
        }


        function transport_payments($id)
        {
                $this->select_all_key('fee_payment');
                return $this->db
                        
                        ->where($this->dx('description') . '='.$id, NULL, FALSE)
                        ->get('fee_payment')
                        ->result();   
        }


        function transport_pay($id)
        {
                return $this->db
                        
                        ->where('fee_id='.$id, NULL, FALSE)
                        ->get('fee_split')
                        ->result();   
        }



        function get_fee($id)
        {
                return $this->db->where('id',$id)->get('fee_extras')->row();
        }

        function do_update($table, $data, $id)
        {
                return $this->db->where('id', $id)->update($table, $data);
        }

}
