<?php

class Cbc_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('cbc', $data);
        return $this->db->insert_id();
    }


    function db_set()
    {
        $this->db->query(
            " 
	 CREATE TABLE IF NOT EXISTS  branch (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`subject` INT(11) NULL DEFAULT '0',
	`la` INT(11) NULL DEFAULT '0',
	`topic` INT(11) NULL DEFAULT '0',
	`task` INT(11) NULL DEFAULT '0',
	`ee_remarks` TEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`me_remarks` TEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`ae_remarks` TEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`be_remarks` TEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ;
    "
        );
    }

    function create_sub($data, $table)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function create_exam($data, $table)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
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

    function passport($id)
    {
        return $this->db->where(array('id' => $id))->get('passports')->row();
    }

    function save_by_classes($data, $class = 0, $subject = 0)
    {
        $exix = $this->db->where(['class_id' => $class, 'subject_id' => $subject])->count_all_results('cbc') > 0;
        if (!$exix) {
            $this->db->insert('cbc', $data);
            return $this->db->insert_id();
        }
    }

    function all_cbc()
    {
        return $this->db->get('cbc')->result();
    }

    function find($id, $table = 'cbc')
    {
        return $this->db->where(['id' => $id])->get($table)->row();
    }

    function exists($id, $table = 'cbc')
    {
        return $this->db->where(['id' => $id])->count_all_results($table) > 0;
    }

    function task_exists($id)
    {
        return $this->db->where(['id' => $id])->count_all_results('cbc_tasks') > 0;
    }

    function get_assess($class, $student, $subject, $term, $year)
    {
        return $this->db->where(['class' => $class, 'student' => $student, 'subject' => $subject, 'term' => $term, 'year' => $year])->get('cbc_assess')->row();
    }

    function get_social($class, $student, $term, $year)
    {
        return $this->db->where(['class' => $class, 'student' => $student, 'term' => $term, 'year' => $year])->get('cbc_social')->row();
    }

    function get_social_report($class, $term, $year)
    {
        return $this->db->where(['class' => $class, 'term' => $term, 'year' => $year])->get('cbc_social')->result();
    }

    function get_assess_strands($id, $strand = 0, $subject = 0)
    {
        if ($subject) {
            $this->db->join('cbc_la', 'strand= cbc_la.id')->where(['subject' => $subject]);
        }
        if ($strand) {
            $this->db->where(['strand' => $strand]);
            return $this->db->select('id, strand, rating')->where(['assess_id' => $id])->get('cbc_assess_strands')->row();
        }
        return $this->db->select('cbc_assess_strands.id as id, strand, rating')->where(['assess_id' => $id])->get('cbc_assess_strands')->result();
    }

    function get_assess_subs_join($id, $subject)
    {
        return $this->db->select('cbc_assess_sub.id as id,strand, sub_strand, remarks, rating')
            ->join('cbc_la', 'strand= cbc_la.id')
            ->where(['subject' => $subject])
            ->where(['assess_id' => $id])
            ->get('cbc_assess_sub')
            ->result();
    }

    function get_assess_subs($id, $strand = 0)
    {
        if ($strand) {
            $this->db->where(['strand' => $strand]);
        }
        return $this->db->select('id,strand, sub_strand, remarks, rating')->where(['assess_id' => $id])->get('cbc_assess_sub')->result();
    }

    function get_assess_tasks($id, $strand = 0, $sub = 0)
    {
        if ($strand) {
            $this->db->where(['strand' => $strand]);
        }
        if ($sub) {
            $this->db->where(['sub_strand' => $sub]);
        }
        return $this->db->select('id,strand,sub_strand, task, rating,remarks')->where(['assess_id' => $id,'status' => 1])->get('cbc_assess_tasks')->result();
    }

    function get_summ_report($class, $term, $year)
    {
        return $this->db->where(['class' => $class, 'term' => $term, 'year' => $year])->get('cbc_summ')->result();
    }

    function fetch_students($class, $term, $year)
    {
        $res = $this->db->where(['class' => $class, 'term' => $term, 'year' => $year])->get('cbc_summ')->result();
        $ls = [];
        foreach ($res as $r) {
            $ls[$r->student] = $r->student;
        }

        return $ls;
    }

    function get_summ($class, $student, $term, $year)
    {
        return $this->db->where(['class' => $class, 'student' => $student, 'term' => $term, 'year' => $year])->get('cbc_summ')->row();
    }

    function get_summ_score($cbc_id, $subject, $exam)
    {
        return $this->db->where(['cbc_id' => $cbc_id, 'subject' => $subject, 'exam' => $exam])->get('cbc_summ_score')->row();
    }

    function get_summ_ratings($cbc_id, $exam = 0)
    {
        if ($exam) {
            $this->db->where(['exam' => $exam]);
        }
        return $this->db->select('id,exam,subject, rating')->where(['cbc_id' => $cbc_id])->get('cbc_summ_score')->result();
    }

    function get_strand_rating($id, $strand)
    {
        return $this->db->select('id, strand, rating')->where(['assess_id' => $id, 'strand' => $strand])->get('cbc_assess_strands')->row();
    }

    function get_sub_rating($id, $strand, $sub)
    {
        return $this->db->select('id, strand, sub_strand, rating')->where(['assess_id' => $id, 'strand' => $strand, 'sub_strand' => $sub])->get('cbc_assess_sub')->row();
    }

    function get_task_rating($id, $strand, $sub, $task)
    {
        return $this->db->select('id, strand, sub_strand, task, rating')->where(['assess_id' => $id, 'strand' => $strand, 'sub_strand' => $sub, 'task' => $task])->get('cbc_assess_tasks')->row();
    }

    function get_assess_report($class, $subject, $term, $year, $student = 0)
    {
        if ($student) {
            $this->db->where(['student' => $student]);
            return $this->db->where(['class' => $class, 'subject' => $subject, 'term' => $term, 'year' => $year])->get('cbc_assess')->row();
        }
        return $this->db->where(['class' => $class, 'subject' => $subject, 'term' => $term, 'year' => $year])->get('cbc_assess')->result();
    }

    function get_assess_st($student, $subject, $term, $year)
    {
        return $this->db->where(['student' => $student, 'subject' => $subject, 'term' => $term, 'year' => $year])->get('cbc_assess')->row();
    }

    function get_summ_st($student, $term, $year)
    {
        return $this->db->where(['student' => $student, 'term' => $term, 'year' => $year])->order_by('id', 'DESC')->get('cbc_summ')->row();
    }

    function count()
    {
        return $this->db->count_all_results('cbc');
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('cbc', $data);
    }

    function update_with($id, $data, $table)
    {
        return $this->db->where('id', $id)->update($table, $data);
    }

    function populate($table, $id, $name)
    {
        $rs = $this->db->select('*')->order_by($id)->get($table)->result();

        $options = [];
        foreach ($rs as $r) {
            $options[$r->{$id}] = $r->{$name};
        }
        return $options;
    }

    function remove_assigned($subject, $id)
    {
        return $this->db->delete('cbc', ['subject_id' => $subject, 'class_id' => $id]);
    }

    function delete($id)
    {
        return $this->db->delete('cbc', array('id' => $id));
    }

    function delete_task($id)
    {
        return $this->db->delete('cbc_tasks', array('id' => $id));
    }

    function delete_row($id, $table)
    {
        return $this->db->delete($table, ['id' => $id]);
    }

    function remove_assess_str($assess, $strand)
    {
        return $this->db->delete('cbc_assess_strands', ['assess_id' => $assess, 'strand' => $strand]);
    }

    function remove_sub_rating($id, $strand, $sub)
    {
        return $this->db->delete('cbc_assess_sub', ['assess_id' => $id, 'strand' => $strand, 'sub_strand' => $sub]);
    }

    function remove_task_rating($id, $strand, $sub)
    {
        return $this->db->delete('cbc_assess_tasks', ['assess_id' => $id, 'strand' => $strand, 'sub_strand' => $sub]);
    }

    function paginate_all($limit, $page)
    {
        $offset = $limit * ($page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('cbc', $limit, $offset);

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

    function get_cbc_sub($limit = 0, $page = 0, $class = 0)
    {
        $offset = $limit * ($page - 1);

        $this->db->select('cbc_subjects.*');
        if ($class) {
            $this->db->join('cbc', 'subject_id=cbc_subjects.id')->where('class_id', $class);
        }
        return $limit ?
            $this->db->order_by('cbc_subjects.id', 'desc')->get('cbc_subjects', $limit, $offset)->result() :
            $this->db->order_by('cbc_subjects.id', 'desc')->get('cbc_subjects')->result();
    }

    function get_la($subject)
    {
        $la = $this->db->select('id, name')
            ->where('subject', $subject)
            ->get('cbc_la')
            ->result();
        foreach ($la as $l) {
            $l->subs = $this->get_topics($l->id);
        }

        return $la;
    }

    function get_topics($id, $sub = 0)
    {
        $topics = $sub ?
            $this->db->select('id,name')->where('id', $sub)->get('cbc_topics')->result() :
            $this->db->select('id,name')
            ->where('strand', $id)
            ->get('cbc_topics')
            ->result();

        foreach ($topics as $l) {
            $l->rate = '';
            $l->remarks = "";
            $l->tasks = $this->get_tasks($l->id);
        }

        return $topics;
    }

    function get_tasks($topic)
    {
        $tasks = $this->db->select('id,name')
            ->where('topic', $topic)
            ->get('cbc_tasks')
            ->result();
        foreach ($tasks as $t) {
            $t->rate = '';
            $t->check = true;
        }
        return $tasks;
    }

    function list_assigned_classes($subject)
    {
        return $this->db->select('class_id')
            ->where('subject_id', $subject)
            ->group_by('class_id')
            ->get('cbc')
            ->result();
    }

    function get_the_class($id)
    {
        return $this->db->where('subject_id', $id)
            ->order_by('id', 'ASC')
            ->get('cbc')
            ->result();
    }

    function list_assess($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $aColumns = $this->db->list_fields('cbc_assess');

        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }

        if (isset($sSearch) && !empty($sSearch)) {
            $where = "   ";
            $s_cols = ['class', 'term', 'year'];
            for ($i = 0; $i < count($s_cols); $i++) {
                // Individual column filtering
                if ($s_cols[$i] == 'class') {
                    $where .= " class_groups.name LIKE '%" . $sSearch . "%'  OR ";
                } else if ($s_cols[$i] == 'year') {
                    $where .= $s_cols[$i] . "  LIKE '%" . $sSearch . "%'  OR ";
                }
            }

            $this->db->where(' (' . trim($where, 'OR ') . ')', null, false);
        }

        // Select Data
        $this->db->select('SQL_CALC_FOUND_ROWS distinct cbc_assess.class, term, year', false);
        $rResult = $this->db
            ->join('classes', 'classes.id=cbc_assess.class')
            ->join('class_groups', 'class_groups.id=classes.class')
            ->where('term is not null and year is not null ', null, false)
            ->group_by('cbc_assess.class,term,year')
            ->order_by('year', 'DESC')
            ->order_by('cbc_assess.class', 'DESC')
            ->get('cbc_assess');
        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
        // Total data set length
        $iTotal = $this->db->select('distinct  cbc_assess.class, term, year', false)
            ->join('classes', 'classes.id=cbc_assess.class')
            ->join('class_groups', 'class_groups.id=classes.class')
            ->where('term is not null and year is not null ', null, false)
            ->group_by('cbc_assess.class,term,year')
            ->count_all('cbc_assess');
        // Output
        $output = [
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => []
        ];

        $aaData = [];
        $obData = [];
        foreach ($rResult->result_array() as $aRow) {
            $row = array();
            foreach ($aRow as $Key => $Value) {
                if ($Key && $Key !== ' ') {
                    $row[$Key] = $Value;
                }
            }
            $obData[] = $row;
        }

        foreach ($obData as $iCol) {
            $iCol = (object) $iCol;

            $aaData[] = [
                $iCol->class,
                isset($this->streams[$iCol->class]) ? $this->streams[$iCol->class] : ' - ',
                $iCol->term,
                $iCol->year,
                $iCol->class
            ];
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    function fetch_classes($subject)
    {
        $list = $this->list_assigned_classes($subject);

        $fn = [];
        foreach ($list as $f) {
            $fn[] = isset($this->classes[$f->class_id]) ? $this->classes[$f->class_id] : '  - ';
        }

        return $fn;
    }

    function get_exams($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $aColumns = $this->db->list_fields('exams');

        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }

        // Ordering
        if (isset($iSortCol_0)) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $iSortCol = $this->input->get_post('iSortCol_' . $i, true);
                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_' . $i, true);

                if ($bSortable == 'true') {
                    $this->db->_protect_identifiers = FALSE;
                    $this->db->order_by('exams.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir), FALSE);
                    $this->db->_protect_identifiers = TRUE;
                }
            }
        }

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        if (isset($sSearch) && !empty($sSearch)) {
            for ($i = 0; $i < count($aColumns); $i++) {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true') {
                    $sSearch = $this->db->escape_like_str($sSearch);
                    $this->db->or_like($aColumns[$i], $sSearch, 'both', FALSE);
                }
            }
        }

        // Select Data
        $this->db->select(' SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $rResult = $this->db->order_by('id', 'DESC')->get('exams');
        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all('exams');

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        $aaData = array();
        $obData = array();
        foreach ($rResult->result_array() as $aRow) {
            $row = array();
            foreach ($aRow as $Key => $Value) {
                if ($Key && $Key !== ' ') {
                    $row[$Key] = $Value;
                }
            }
            $obData[] = $row;
        }

        foreach ($obData as $iCol) {
            $iCol = (object) $iCol;

            $aaData[] = [
                $iCol->id,
                $iCol->title,
                $iCol->term,
                $iCol->year,
                $iCol->start_date ? date('d M Y', $iCol->start_date) : ' ',
            ];
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    function fetch_class($id)
    {
        return $this->db->where(array('id' => $id))->get('classes')->row();
    }

    function get_subjects($class)
    {
        return $this->db->select('cbc.id as id,subject_id as subject, name, cbc_subjects.id as cbb_id')
            ->join('cbc_subjects', 'subject_id=cbc_subjects.id')
            ->where('class_id', $class)
            ->get('cbc')
            ->result();
    }

    function get_students($class)
    {
        $ls = $this->db->select('id,' . $this->dxa('class') . ',' 
        . $this->dxa('first_name') . ',' 
        . $this->dxa('middle_name') . ',' 
        . $this->dxa('last_name'), FALSE)
            ->where($this->dx('admission.class') . ' = ' . $class, NULL, FALSE)
            ->where($this->dx('admission.status') . '= 1', NULL, FALSE)
            ->order_by($this->dx('first_name'), 'ASC', false)
            ->get('admission')
            ->result();
        $res = [];
        foreach ($ls as $st) {
            $res[$st->id] = $st->first_name . ' ' . $st->last_name;
        }

        return $res;
    }

    function get_subs($ids)
    {
        if (empty($ids)) {
            $ids = [0];
        }
        $rs = $this->db->where_in('id', $ids)
            ->order_by('id')
            ->get('cbc_subjects')
            ->result();

        $options = [];
        foreach ($rs as $r) {
            $options[$r->id] = $r->name;
        }
        return $options;
    }

    function get_assess_meta($class, $term, $year)
    {
        $res = $this->db->select('student, term, year, subject', false)
            ->where('class', $class)
            ->where('term', $term)
            ->where('year', $year)
            ->get('cbc_assess')
            ->result();

        $ids = [];
        $subs = [];

        foreach ($res as $r) {
            $ids[$r->student] = $r->student;
            $subs[$r->subject] = $r->subject;
        }
        if (empty($ids)) {
            $ids = [0];
        }
        $ls = $this->db->select('id,' . $this->dxa('class') . ',' . $this->dxa('first_name') . ',' . $this->dxa('last_name'), FALSE)
            ->where_in('id', $ids)
            ->order_by($this->dx('first_name'), 'ASC', false)
            ->get('admission')
            ->result();
        $adm = [];
        foreach ($ls as $st) {
            $adm[$st->id] = $st->first_name . ' ' . $st->last_name;
        }

        return (object) ['students' => $adm, 'subjects' => $subs];
    }

    function get_assess_list($ids)
    {
        if (empty($ids)) {
            $ids = [0];
        }
        return $this->db->where_in('student', $ids)
            ->order_by('created_on', 'DESC')
            ->get('cbc_assess')
            ->result();
    }

    function get_summative_list($ids)
    {
        if (empty($ids)) {
            $ids = [0];
        }
        return $this->db->where_in('student', $ids)
            ->order_by('created_on', 'DESC')
            ->get('cbc_summ')
            ->result();
    }

    function fix_cbc($per, $fl)
    {
        $mp = [1 => 'cbc_assess_strands', 2 => 'cbc_assess_sub', 3 => 'cbc_assess_tasks', 4 => 'cbc_summ_score'];
        $keymap = ['BE' => 1, 'AE' => 2, 'ME' => 3, 'EE' => 4, '4' => 4, '3' => 3, '2' => 2];

        $table = $mp[$fl];
        $ct = $this->count_pending($table);
        echo '<pre>Pending b4: ';
        print_r($ct);
        echo '</pre>';
        $list = $this->get_pending($table, $per);

        foreach ($list as $r) {
            $rt = str_replace(' ', '', $r->rating__);
            $rts = str_replace('.', '', $rt);
            $rts = str_replace(',', '', $rts);
            $rts = str_replace('/', '', $rts);

            $val = strtoupper(strtolower($rts));

            echo '<pre>' . $r->id . '=> ' . $val . '</pre>';

            if (isset($keymap[$val])) {
                $this->update_with($r->id, ['rating' => $keymap[$val], 'modified_on' => time()], $table);
            }
        }

        $ctn = $this->count_pending($table);
        echo '<pre>Pending After: ';
        print_r($ctn);
        echo '</pre>';
    }

    function count_pending($table)
    {
        return $this->db->where(" (rating__ IS NOT NULL AND rating__ !='' ) AND rating IS NULL ", null, false)
            ->count_all_results($table);
    }

    function get_pending($table, $per)
    {
        return $this->db->where(" (rating__ IS NOT NULL AND rating__ !='' ) AND rating IS NULL ", null, false)
            ->limit($per)
            ->get($table)
            ->result();
    }

    function _get_subs()
    {
        return $this->db->order_by('class_id', 'ASC')->get('cbc')->result();
    }


    function _gen_analysis($class, $term, $year, $exam)
    {
        $out = $this->db
            ->where('class', $class)
            ->where('term', $term)
            ->where('year', $year)
            ->get('cbc_summ')
            ->result();




        $data = [];
        $marks = $this->_get_marks($class, $term, $year, $exam);
        foreach ($out as $p) {

            $mks = isset($marks[$p->student]) ? $marks[$p->student] : [];
            $data[] = [
                'student' => $p->student,
                'score' => array_sum($mks)
            ];
        }


        $totals = [];
        foreach ($data as $item) {
            $total = $item['score'];
            if ($total == 0) {
                continue;
            }
            $totals[] = ['data' => $item, 'total' => $total];
        }

        // Sort the array based on the 'total' values in descending order
        usort($totals, function ($a, $b) {
            return $b['total'] - $a['total'];
        });


        return $totals;
    }

    function get_subjs($class)
    {

        $cls = $this->db->where('id', $class)->get('classes')->row();
        $list = $this->db->where('class_id', $cls->class)->get('cbc')->result();
        $sub = $this->populate('cbc_subjects', 'id', 'name');
        $out = [];
        foreach ($list as $p) {
            $name = isset($sub[$p->subject_id]) ? $sub[$p->subject_id] : '';
            $nm = explode(' ', $name);
            $count =  count($nm);

            $namee = ($count > 2) ?   $name : $name;
            $out[$p->subject_id] =  $namee;
        }

        return $out;
    }

    function short_name($string)
    {
        $words = str_word_count($string, 1);
        $shortForm = implode('', array_map(function ($word) {
            return $word[0];
        }, $words));

        return $shortForm;
    }

    function _get_marks($class, $term, $year, $exam)
    {
        $list = $this->db
            ->where('class', $class)
            ->where('term', $term)
            ->where('year', $year)
            ->get('cbc_summ')
            ->result();

        $marks = [];
        foreach ($list as $l) {
            $marks[$l->student] = $this->db
                ->where('cbc_id', $l->id)
                ->where('exam', $exam)
                ->get('cbc_summ_score')
                ->result();
        }

        $mmks = [];
        foreach ($marks as $st =>  $r) {
            foreach ($r as $p) {
                $mmks[$st][$p->subject] = $p->rating;
            }
        }



        return $mmks;
    }

    function _count_grades_per_class($class, $term, $year, $exam)
    {
        $list = $this->db
            ->where('class', $class)
            ->where('term', $term)
            ->where('year', $year)
            ->get('cbc_summ')
            ->result();
        $marks = [];
        foreach ($list as $l) {
            $marks[] = $this->db
                ->where('cbc_id', $l->id)
                ->where('exam', $exam)
                ->get('cbc_summ_score')
                ->result();
        }




        $mmks = [];
        foreach ($marks as $rr => $load) {
            foreach ($load as $p) {
                $mmks[$p->rating][] = $p->id;
            }
        }

        $out = [];
        foreach ($mmks as $rt => $val) {
            $out[$rt] = count($val);
        }

        ksort($out);



        return $out;
    }

    function _subject_analysis($class, $term, $year, $exam)
    {
        $list = $this->db
            ->where('class', $class)
            ->where('term', $term)
            ->where('year', $year)
            ->get('cbc_summ')
            ->result();
        $marks = [];
        foreach ($list as $l) {
            $marks[] = $this->db
                ->where('cbc_id', $l->id)
                ->where('exam', $exam)
                ->get('cbc_summ_score')
                ->result();
        }

        $count = [];
        foreach ($marks as $mm => $mks) {
            foreach ($mks as $p) {
                $count[$p->subject][$p->rating][] =  $p;
            }
        }

        return $count;
    }

    function _graphical_rep($class, $term, $year, $exam)
    {
        $list = $this->db
            ->where('class', $class)
            ->where('term', $term)
            ->where('year', $year)
            ->get('cbc_summ')
            ->result();
        $marks = [];
        foreach ($list as $l) {
            $marks[] = $this->db
                ->where('cbc_id', $l->id)
                ->where('exam', $exam)
                ->get('cbc_summ_score')
                ->result();
        }





        $mmks = [];
        foreach ($marks as $rr => $load) {
            foreach ($load as $p) {
                $mmks[$p->rating][] = $p->id;
            }
        }

        $out = [];
        foreach ($mmks as $rt => $val) {
            $out[$rt] = count($val);
        }

        ksort($out);
        $output = [];
        $map_grades = [
            1 => 'BE',
            2 => 'AE',
            3 => 'ME',
            4 => 'EE'
        ];
        foreach ($out as $grd => $tt) {
            $output[] = [
                'grade' => isset($map_grades[$grd]) ? $map_grades[$grd] : '',
                'value' => $tt
            ];
        }


        return $output;
    }


    function get_teachers()
    {
        $this->select_all_key('teachers');

        $list = $this->db->where($this->dx('status') . '=1', NULL, FALSE)->get('teachers')->result();



        $out = [];

        foreach ($list as $p) {
            $out[$p->user_id] = $p->first_name . ' ' . $p->middle_name . ' ' . $p->last_name;
        }



        return $out;
    }



    // tr analysis
    function get_results($teacher,   $term = false, $year = false, $class = false)
    {
        if ($teacher) {
            $this->db->where('created_by', $teacher);
        }

        if ($term) {
            $this->db->where('term', $term);
        }

        if ($year) {
            $this->db->where('year', $year);
        }

        if ($class) {
            $this->db->where('class', $class);
        }

        $results = $this->db
            ->order_by('year', 'DESC')
            ->get('cbc_summ')
            ->result();

        $finalResult = [];

        foreach ($results as $p) {
            $payload = $this->db
                ->select('AVG(rating) as average_rating, cbc_summ_score.*')
                ->where('cbc_id', $p->id)
                ->group_by('exam')
                ->get('cbc_summ_score')
                ->result();

            $out = [];

            foreach ($payload as $k) {
                $out[$k->subject] = round($k->average_rating);
            }

            $finalResult[$p->class][$p->year][$p->term] = $out;
        }





        return $finalResult;
    }




    //student analysis
    function get_student_analysis($student,$exam, $term = false, $year = false, $class = false)
    {
        if ($student) {
            $this->db->where('student', $student);
        }

        if ($term) {
            $this->db->where('term', $term);
        }

        if ($year) {
            $this->db->where('year', $year);
        }

        if ($class) {
            $this->db->where('class', $class);
        }

        $results = $this->db
            ->order_by('year', 'DESC')
            ->get('cbc_summ')
            ->result();

        $finalResult = [];

        foreach ($results as $p) {
            $payload = $this->db
                // ->select('AVG(rating) as average_rating, cbc_summ_score.*')
                ->where('cbc_id', $p->id)
                // ->group_by('exam')
                ->where('exam', $exam)
                ->get('cbc_summ_score')
                ->result();

            $out = [];

            foreach ($payload as $k) {
                $out[$k->subject] = round($k->rating);
            }

            $finalResult[$p->class][$p->year][$p->term] = $out;
        }





        return $finalResult;
    }


    function all_students()
    {
        $this->select_all_key('admission');

        $list = $this->db->order_by($this->dx('first_name'), 'ASC', false)->get('admission')->result();

        $out = [];

        foreach($list as $p)
        {
            $out[$p->id] = $p->admission_number.' '.$p->first_name.' '.$p->middle_name.' '.$p->last_name;
        }

        return $out;
    }


    function has_remarks($subject, $topic, $task)
    {
        return $this->db->where([
            'subject' => $subject,
            'topic' => $topic,
            'task' => $task
        ])->get('cbc_remarks')->row();
    }

    // migration
    function find_sub($class)
    {
        $cbc = $this->load->database('cbc', TRUE);

        $list = $cbc->where('class_id', $class)->get('cbc')->result();

        $out = [];

        foreach($list as $p)
        {
            $f = $cbc->where('id',$p->subject_id)->get('cbc_subjects')->result();
            foreach($f as $k)
            {
                $out[$k->id] = [
                    'name' => $k->name,
                    'code' => $k->code,
                    'priority' => $k->priority,
                    'cat' => $k->cat
                ];
            }
        }

        return (object) $out;
    }

    function fetchla($subject)
    {
        $cbc = $this->load->database('cbc', TRUE);

        return $cbc->where('subject', $subject)->where('status',1)->get('cbc_la')->result();

    }

    function fetch_topic($strand)
    {
        $cbc = $this->load->database('cbc', TRUE);

        return $cbc->where('strand', $strand)->where('status', 1)->get('cbc_topics')->result();
    }

    function fetch_tasks($topic)
    {
        $cbc = $this->load->database('cbc', TRUE);

        return $cbc->where('topic', $topic)->where('status', 1)->get('cbc_tasks')->result();
    }

    function fetch_remarks($subject, $la, $topic, $task)
    {
        $cbc = $this->load->database('cbc', TRUE);

        return $cbc
                    ->where('subject', $subject)
                    ->where('la', $la)
                    ->where('topic', $topic)
                    ->where('task', $task)
                    ->get('cbc_remarks')->result();
    }

    function fetch_subjects($class)
    {

        $payload = [];


        $subjects = $this->find_sub($class);
    
        foreach($subjects as $subject => $s)
        {
            $s = (object) $s;
            $laas = $this->fetchla($subject);
            $cbc_la = [];
            foreach($laas as $la)
            {
                $s->cbc_la[$la->id] = [
                    'name' => $la->name,
                    'status' => $la->status,                    
                ];

                $topics =  $this->fetch_topic($la->id);

                $la->cbc_topics = [];
                foreach ($topics as  $tp) 
                {
                    $s->cbc_topics[$tp->id] = [
                        'name' => $tp->name,
                        'status' => $tp->status
                    ];


                    $tasks = $this->fetch_tasks($tp->id);
                    $cbc_tasks = [];
                    foreach($tasks as $tsk)
                    {
                        $s->cbc_tasks[$tsk->id] = [
                            'name' => $tsk->name,
                            'status' => $tsk->status,
                        ];

                        $remarks =  $this->fetch_remarks($subject,$la->id,$tp->id,$tsk->id);

                        $cbc_remarks = [];
                        foreach($remarks as $r)
                        {
                            $s->cbc_remarks[$r->id] = [
                                'ee_remarks' => $r->ee_remarks,
                                'me_remarks' => $r->me_remarks,
                                'ae_remarks' => $r->ae_remarks,
                                'be_remarks' => $r->be_remarks
                            ];
                        }
                        $tsk->remarks = $cbc_remarks;
                    }
                     $tp->tasks= $cbc_tasks;
                }
                $s->topics= $la;

            }
            // $s->items= $cbc_la;
            // $s->topics = $cbc_topics;
            // $s->tasks = $cbc_tasks;
            // $s->remarks = $cbc_remarks;

             $payload[] =$s;
        }


       

        return $payload;
    }

    function _fetch_subjects($class)
    {
        $payload = [];
        $subjects = $this->find_sub($class);

        foreach ($subjects as $subject => $s) {
            $s = (object)$s;
            $laas = $this->fetchla($subject);
            $cbc_la = [];

            foreach ($laas as $la) {
                $laData = [
                    'name' => $la->name,
                    'status' => $la->status,
                    'topics' => []
                ];

                $topics = $this->fetch_topic($la->id);

                foreach ($topics as $tp) {
                    $topicData = [
                        'name' => $tp->name,
                        'status' => $tp->status,
                        'tasks' => []
                    ];

                    $tasks = $this->fetch_tasks($tp->id);

                    foreach ($tasks as $tsk) {
                        $taskData = [
                            'name' => $tsk->name,
                            'status' => $tsk->status,
                            'remarks' => $this->fetch_remarks($subject, $la->id, $tp->id, $tsk->id)
                        ];

                        $topicData['tasks'][] = $taskData;
                    }

                    $laData['topics'][] = $topicData;
                }

                $cbc_la[] = $laData;
            }

            $s->items = $cbc_la;
            $payload[] = $s;
        }

        $subjectsArray = ['subjects' => $payload];

        return $subjectsArray;
    }


   


}
