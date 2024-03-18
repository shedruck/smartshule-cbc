<?php

class Cbc_tr extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }


    function my_classes()
    {
        $list =  $this->db->where('teacher', $this->profile->id)->where(['term' => $this->school->term, 'year' => $this->school->year, 'type' => 2])->group_by('class')->get('subjects_assign')->result();

        $fn = [];
        $pop =  $this->count_students();
        foreach ($list as $p) {
            $cls = isset($this->streams[$p->class]) ? $this->streams[$p->class] : 'Unknown Class';
            $tt = isset($pop[$p->class]) ? $pop[$p->class]  : 0;
            $fn[$p->class] = [
                'id' => $p->class,
                'name' => $cls,
                'total' => $tt
            ];
        }

        return $fn;
    }

    function count_students()
    {
        $this->select_all_key('admission');
        $list =  $this->db->where($this->dx('status') . '=1', NULL, FALSE)->get('admission')->result();

        $out = [];
        foreach ($list as $p) {
            $out[$p->class][] = $p;
        }

        $fn = [];

        foreach ($out as $cls => $vl) {
            $fn[$cls] = count($vl);
        }

        return $fn;
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

    function find_allocation($clas)
    {
        $list =  $this->db
            ->where('teacher', $this->profile->id)
            ->where(
                [
                    'term' => $this->school->term,
                    'year' => $this->school->year,
                    'class' => $clas,
                    'type' => 2
                ]
            )
            ->get('subjects_assign')->result();

        $sub =  $this->populate('cbc_subjects', 'id', 'name');

        $out = [];
        foreach ($list as $p) {
            $nm = isset($sub[$p->subject]) ? $sub[$p->subject] : 'Undefined subject';
            $out[] =  [
                'id' => $p->subject,
                'name' => $nm
            ];
        }

        return $out;
    }

    function fetch_strands($subject)
    {
        return $this->db->where('subject', $subject)->where('status', 1)->order_by('id', 'ASC')->get('cbc_la')->result();
    }


    function fetch_substrands()
    {
        $list =  $this->db->where('status', 1)->get('cbc_topics')->result();

        $fn = [];

        foreach ($list as $p) {
            $fn[$p->strand][] = $p;
        }

        return $fn;
    }

    function fetch_remarks($subject, $strand, $sub, $task)
    {
        return $this->db
            ->where('subject', $subject)
            ->where('la', $strand)
            ->where('topic', $sub)
            ->where('task', $task)
            ->get('cbc_remarks')->result();
    }


    function fetch_remark($subject, $strand, $sub, $task)
    {
        return $this->db
            ->where('subject', $subject)
            ->where('la', $strand)
            ->where('topic', $sub)
            ->where('task', $task)
            ->get('cbc_remarks')->row();
    }

    function fetch_tasks($subject, $strand, $substrand)
    {
        $list =  $this->db->where(['topic' => $substrand, 'status' => 1])->get('cbc_tasks')->result();

        $fn = [];

        foreach ($list as $p) {
            $p->remarks =  $this->fetch_remarks($subject, $strand, $substrand, $p->id);
            $fn[] = $p;
        }

        return $fn;
    }

    function wrapWords($text)
    {
        $words = explode(' ', $text);
        $wordCount = count($words);
        $result = '';

        for ($i = 0; $i < $wordCount; $i++) {

            $result .= $words[$i];


            if (($i + 1) % 3 === 0 && $i !== $wordCount - 1) {
                $result .= "<br>";
            } else {
                $result .= " ";
            }
        }

        return $result;
    }

    function encryptParameters($params)
    {
        $serializedParams = serialize($params);
        $encryptedParams = base64_encode($serializedParams);
        return $encryptedParams;
    }


    function decryptParameters($encryptedParams)
    {
        $decodedParams = base64_decode($encryptedParams);
        $params = unserialize($decodedParams);
        return $params;
    }

    function get_students($class)
    {
        $this->select_all_key('admission');
        return $this->db
                    ->where($this->dx('class') . " ='" . $class . "'", NULL, FALSE)
                    ->where($this->dx('status') . " ='1'", NULL, FALSE)
                    ->order_by('first_name','ASC')
                    ->get('admission')
                    ->result();
    }

    function get_asses_strands($id, $strand, $substrand, $task)
    {
        return $this->db->where([
            'assess_id' => $id,
            'strand' => $strand,
            'sub_strand' => $substrand,
            'task' => $task
        ])->get('cbc_assess_tasks')->row();
    }

    function get_assessd($post)
    {
        $list = $this->db->where([
            'term' => $this->school->term,
            'year' => $this->school->year,
            'class' => $post->class,
            'subject' => $post->subject,
        ])->get('cbc_assess')->result();

        $fn = [];
        foreach($list as $p)
        {
            $row = $this->get_asses_strands($p->id, $post->strand, $post->substrand, $post->task);
            $fn[$p->student] =  $row;
        }   

        return $fn;
    }

    function find_task($id)
    {
        return $this->db->where('id',$id)->where('status',1)->get('cbc_tasks')->row();
    }
}
