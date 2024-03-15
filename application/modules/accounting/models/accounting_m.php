<?php

class Accounting_m extends MY_Model
{

     function __construct()
     {
          // Call the Model constructor
          parent::__construct();
          $this->db_set();
     }

     function create($data)
     {
          $this->db->insert('accounting', $data);
          return $this->db->insert_id();
     }

     /**
      * Make Journal Entry
      * @param type $data
      * @return type
      */
     function enter_journal($data)
     {
          $this->db->insert('journal', $data);
          return $this->db->insert_id();
     }

     /**
      * Update an Entry 
      * 
      * @param type $id
      * @param type $data
      */
     function update_journal($id, $data)
     {
          return $this->db->where('parent_id', $id)->update('journal', $data);
     }

     /**
      * Remove for Voided Transaction
      * 
      * @param type $id
      * @return type
      */
     function remove_journal($id)
     {
          return $this->db->where('parent_id', $id)->delete('journal');
     }

     function find($id)
     {
          return $this->db->where(array('id' => $id))->get('accounting')->row();
     }

     function exists($id)
     {
          return $this->db->where(array('id' => $id))->count_all_results('accounting') > 0;
     }

     function count()
     {
          return $this->db->count_all_results('accounting');
     }

     function update_attributes($id, $data)
     {
          return $this->db->where('id', $id)->update('accounting', $data);
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

     /**
      * Setup DB Table Automatically
      * 
      */
     function db_set()
     {
          $this->db->query(" 
	CREATE TABLE IF NOT EXISTS `accounting`  (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`code` INT(11) NOT NULL,
	`name` VARCHAR(255) NOT NULL DEFAULT '',
	`cat` INT(11) NULL DEFAULT NULL,
	`status` INT(11) NULL DEFAULT NULL,
	`description` TEXT NULL,
	`created_by` INT(11) NULL DEFAULT NULL,
	`modified_by` INT(11) NULL DEFAULT NULL,
	`created_on` INT(11) NULL DEFAULT NULL,
	`modified_on` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
               )
               COLLATE='utf8_general_ci'
               ENGINE=InnoDB  ; ");
     }

     function paginate_all($limit, $page)
     {
          $offset = $limit * ( $page - 1);

          $this->db->order_by('id', 'asc');
          $query = $this->db->get('accounting', $limit, $offset);

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

     /**
      * Fetch all Expenses
      * 
      * @return type
      */
     function fetch_expenses()
     {
          return $this->db->get('expenses')->result();
     }

}
