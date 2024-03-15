<?php

    /**
     * Class Subjects_m
     */
    class Subjects_m extends MY_Model
    {

         /**
          *
          */
         function __construct()
         {
              // Call the Model constructor
              parent::__construct();
              $this->db_set();
         }

         /**
          * @param $data
          *
          * @return mixed
          */
         function create($data)
         {
              $this->db->insert('subjects', $data);
              return $this->db->insert_id();
         }

         function save_quick($data)
         {
              $this->db->insert('sub_cats', $data);
              return $this->db->insert_id();
         }

         /**
          * Save Sub Units  if not  Exists
          *
          * @param array $data
          * @param string $title
          * @param int $parent
          *
          * @return void
          */
         function save_units($data, $title = FALSE, $parent = FALSE)
         {
              $exix = $this->db->where('title', $title)->where('parent', $parent)->count_all_results('sub_cats') > 0;
              if (!$exix)
              {
                   $this->db->insert('sub_cats', $data);
                   return $this->db->insert_id();
              }
              else
              {
                   return $this->update_where("title='{$title}' ", 'sub_cats', $data);
              }
         }

         /**
          * Save Paper Upload
          *
          * @param array $data
          *
          * @return boolean
          */
         function save_paper($data)
         {
              $this->db->insert('exam_questions', $data);
              return $this->db->insert_id();
         }

         /**
          * Update Paper
          *
          * @param array $id
          *
          * @return boolean
          */
         function update_paper($id, $data)
         {
              return $this->db->where('id', $id)->update('exam_questions', $data);
         }

         /**
          * Fetch Uploaded Papers for Viewing
          *
          * @param type $subject
          *
          * @return type
          */
         function fetch_questions($subject)
         {
              $res = $this->db->where('subject', $subject)
                           ->get('exam_questions')
                           ->result();
              $qs = array();
              foreach ($res as $q)
              {
                   $qs[$q->exam]['id'] = $q->id;
                   $qs[$q->exam]['created_by'] = $q->created_by;
                   $qs[$q->exam]['created_on'] = $q->created_on;
                   $qs[$q->exam]['files'][] = array(
                           'filename' => $q->filename,
                           'filesize' => $q->filesize,
                           'fpath' => $q->fpath,
                   );
              }

              return $qs;
         }

         /**
          * Clear Old Sub Units
          *
          * @param type $id
          *
          * @return boolean
          */
         function clear_units($id)
         {
              return $this->db->delete('sub_cats', array('parent' => $id));
         }

         /**
          * Remove Sub Unit
          * @param type $parent
          * @param type $id
          * @return type
          */
         function delink($parent, $id)
         {
              return $this->db->delete('sub_cats', array('id' => $id, 'parent' => $parent));
         }

         /**
          * Clear Assigned Subjects
          *
          * @param type $id
          *
          * @return boolean
          */
         function clear_assignment($id)
         {
              return $this->db->delete('subjects_classes', array('subject_id' => $id));
         }

         /**
          * Assign Subjects to Classes by Term
          *
          * @param array $data
          * @param int $class
          * @param int $subject
          * @param int $term
          *
          * @return void
          */
         function save_by_classes($data, $class = 0, $subject = 0, $term = 0)
         {
              $exix = $this->db->where(array('class_id' => $class, 'subject_id' => $subject, 'term' => $term))->count_all_results('subjects_classes') > 0;
              if (!$exix)
              {
                   $this->db->insert('subjects_classes', $data);
                   return $this->db->insert_id();
              }
         }

         /**
          * remove_class
          *
          * @param $id
          * @param $class
          *
          * @return mixed
          */
         function remove_class($id, $class)
         {
              return $this->db->delete('subjects_classes', array('subject_id' => $id, 'class_id' => $class));
         }

         /**
          * Fetch Sub Cats for this Subject
          *
          * @param type $subject
          *
          * @return type
          */
         function fetch_subcats($subject)
         {
              $list = $this->db->where('parent', $subject)
                           ->get('sub_cats')
                           ->result();
              $fn = array();
              foreach ($list as $f)
              {
                   $fn[$f->id] = array('title' => $f->title, 'out_of' => $f->out_of);
              }
              return $fn;
         }

         /**
          * Fetch Assigned Classes
          *
          * @param int $subject
          *
          * @return array
          */
         function fetch_assigned_classes($subject)
         {
              $list = $this->db->where('subject_id', $subject)
                           ->get('subjects_classes')
                           ->result();
              $fns = array();
              foreach ($list as $f)
              {
                   $fns[$f->class_id][] = $f->term;
              }

              return $fns;
         }

         /**
          * List Subjects For This Class
          *
          * @param type $class
          *
          * @return type
          */
         function get_subjects($class)
         {
              $list = $this->db->where('class_id', $class)
                           ->get('subjects_classes')
                           ->result();
              $fcl = array();
              foreach ($list as $f)
              {
                   $units = $this->fetch_subcats($f->subject_id);
                   $fcl[$f->subject_id]['terms'][] = $f->term;
                   $fcl[$f->subject_id]['has'] = 0;
                   if (count($units))
                   {
                        $fcl[$f->subject_id]['units'] = $units;
                        $fcl[$f->subject_id]['has'] = 1;
                   }
              }

              return $fcl;
         }

         /**
          * Fetch Specific Row
          *
          * @param type $id
          *
          * @return type
          */
         function find($id)
         {
              return $this->db->where(array('id' => $id))->get('subjects')->row();
         }

         function find_unit($id)
         {
              return $this->db->where(array('id' => $id))->get('sub_cats')->row();
         }

         /**
          * If Subject Exists
          *
          * @param type $id
          *
          * @return type
          */
         function exists($id)
         {
              return $this->db->where(array('id' => $id))->count_all_results('subjects') > 0;
         }

         function unit_exists($id)
         {
              return $this->db->where(array('id' => $id))->count_all_results('sub_cats') > 0;
         }

         /**
          * @return mixed
          */
         function count()
         {
              return $this->db->count_all_results('subjects');
         }

         /**
          * @param $id
          * @param $data
          *
          * @return mixed
          */
         function update_attributes($id, $data)
         {
              return $this->db->where('id', $id)->update('subjects', $data);
         }

         function update_unit($id, $data)
         {
              return $this->db->where('id', $id)->update('sub_cats', $data);
         }

         /**
          * @param $table
          * @param $option_val
          * @param $option_text
          *
          * @return array
          */
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
          * Fetch Exam List
          *
          * @return type
          */
         function fetch_exam_list()
         {
              $qs = $this->db->select('id,title,term, year')->order_by('id')->get('exams')->result();
              $options = array();
              foreach ($qs as $d)
              {
                   $options[$d->id] = $d->title . ' Term ' . $d->term . ' ' . $d->year;
              }
              return $options;
         }

         function get_electives()
         {
              $qs = $this->db->select('id,name')
                           ->where('is_optional', 2)
                           ->order_by('id')
                           ->get('subjects')
                           ->result();
              $options = array();
              foreach ($qs as $d)
              {
                   $options[$d->id] = $d->name;
              }
              return $options;
         }

         /**
          * Assign Elective Subject
          * 
          * @param array $data
          * @param int $student
          * @param int $subject
          * @param int $year
          * @return boolean success
          */
         function assign_elective($data, $student, $subject, $year)
         {
              $has = $this->db->where('student', $student)
                           ->where('subject', $subject)->where('year', $year)
                           ->get('subjects_assign')
                           ->row();
              if ($has)
              {
                   return $this->db->where('id', $has->id)->update('subjects_assign', array('modified_on' => time()));
              }
              else
              {
                   return $this->db->insert('subjects_assign', $data);
              }
         }

         /**
          * @param int $id
          *
          * @return mixed
          */
         function delete($id)
         {
              return $this->db->delete('subjects', array('id' => $id));
         }

         /**
          * Setup DB Table Automatically
          *
          */
         function db_set()
         {
              $this->db->query("
	CREATE TABLE IF NOT EXISTS  subjects (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
	code  varchar(256)  DEFAULT '' NOT NULL, 
	short_name  varchar(256)  DEFAULT '' NOT NULL, 
	sub_units  INT(11), 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
         }

         /**
          * @param $limit
          * @param $page
          *
          * @return array|bool
          */
         function paginate_all($limit, $page)
         {
              $offset = $limit * ($page - 1);
              $this->db->order_by('id', 'ASC');
              return $this->db->get('subjects', $limit, $offset)
                                        ->result();
         }

    }
    