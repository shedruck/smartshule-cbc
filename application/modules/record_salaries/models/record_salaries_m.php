<?php

class Record_salaries_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function create($data)
        {
                $this->db->insert('record_salaries', $data);
                return $this->db->insert_id();
        }

        function get_all($id = 0)
        {
                return $this->db->select('record_salaries.*')->where('salary_date', $id)->order_by('created_on', 'DESC')->get('record_salaries')->result();
        }

        //Employee's Salary Slips
        function get_my_slip()
        {
                $u = $this->ion_auth->get_user()->id;
                return $this->db->where('employee', $u)->order_by('created_on', 'DESC')->get('record_salaries')->result();
        }

        function get_tax()
        {
                return $this->db->where('name', 'PAYE')->get('tax_config')->row();
        }

        //Get Employee Salary details

        function salary_details($id)
        {
                return $this->db->where('employee', $id)->get('salaries')->row();
        }

        //Get Advance Salary 

        function get_advance($id)
        {
                return $this->db->where(array('employee' => $id, 'status' => 1))->get('advance_salary')->row();
        }

        //Get All Employees in salary records
        function get_employees()
        {
                return $this->db->select('salaries.*')->get('salaries')->result();
        }

        //Get Deductions
        function salary_deductions($id)
        {
                return $this->db->where('salary_id', $id)->get('employee_deductions')->result();
        }

        //Total Deductions
        function total_deductions($arr)
        {
                return $this->db->select('sum(amount) as totals')->where_in('id', $arr)->get('deductions')->row();
        }

        //Get Allowances
        function salary_allowances($id)
        {
                return $this->db->where('salary_id', $id)->get('employee_allowances')->result();
        }

        //Total Deductions
        function total_allowances($arr)
        {
                return $this->db->select('sum(amount) as totals')->where_in('id', $arr)->get('allowances')->row();
        }

        //List Deductions
        function list_deductions()
        {

                $results = $this->db->get('deductions')->result();
                $arr = array();

                foreach ($results as $r)
                {

                        $arr[$r->id] = $r->name . ':' . $r->amount;
                }

                return $arr;
        }

        //List Allowances
        function list_allowances()
        {

                $results = $this->db->get('allowances')->result();
                $arr = array();

                foreach ($results as $r)
                {

                        $arr[$r->id] = $r->name . ':' . $r->amount;
                }

                return $arr;
        }

        //List Employees
        //Head Teachers	
        public function list_employees()
        {
                $results = $this->db->where($this->dx('active') . '=1', NULL, FALSE)
                                          ->join('users', 'employee=users.id')
                                          ->get('salaries')->result();

                $arr4 = array();

                foreach ($results as $res)
                {
                        $user = $this->ion_auth->get_user($res->employee);
                        $arr4[$res->employee] = $user->first_name . ' ' . $user->last_name;
                }

                return $arr4;
        }

        public function get_paye_ranges()
        {
                return $this->db->select('range_from,range_to,tax, amount')->get('paye')->result();
        }

        function find($id)
        {
                return $this->db->where(array('id' => $id))->get('record_salaries')->row();
        }

        function count_employees($date)
        {
                return $this->db->where(array('salary_date' => $date))->count_all_results('record_salaries');
        }

        function total_salo($date)
        {
                return $this->db->select('sum(basic_salary) as total')->where(array('salary_date' => $date))->get('record_salaries')->row();
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('record_salaries') > 0;
        }

        function count()
        {
                return $this->db->count_all_results('record_salaries');
        }

        function update_attributes($id, $data)
        {
                return $this->db->where('id', $id)->update('record_salaries', $data);
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

        function delete($id)
        {
                return $this->db->delete('record_salaries', array('id' => $id));
        }

        function void($id)
        {
                return $this->db->delete('record_salaries', array('salary_date' => $id));
        }

        function paginate_all($limit, $page)
        {
                $offset = $limit * ( $page - 1);
                $this->db->order_by('id', 'desc');
                $this->db->group_by('salary_date');
                $query = $this->db->get('record_salaries', $limit, $offset);

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
