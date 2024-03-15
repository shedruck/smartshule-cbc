<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Branch extends Public_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('branch_m');
        $this->load->model('admission/admission_m');
        $this->load->model('parents/parents_m');
        $this->load->model('users/users_m');
        $this->load->model('fee_arrears/fee_arrears_m');
        $this->load->model('teachers/teachers_m');
        $this->load->model('non_teaching/non_teaching_m');
        $this->load->model('subordinate/subordinate_m');
        $this->load->model('emergency_contacts/emergency_contacts_m');
    }


    function receive_students()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data)) {
            $message = ['status' => 101, 'response' => 'Not accepted'];
        }

        $post = (object) $data['1'];



        $i = 0;


        foreach ($data as $key =>  $payload) {

            $exists = 0;

            $exists_std = 0;

            $p = (object) $payload;

            if ($p->id) {



                // echo $p->new_class;die;

                $parent = (object) $p->parentData;

                $parent_user = (object)  $p->parentUser;

                $emergency = (object) $p->emergency;

                $balance = (object) $p->balance;

                $student_user = (object) $p->studentUser;




                //search for parent
                $exs_id = $this->admission_m->parent_exists($parent->email, $parent->phone);
                if ($exs_id) {
                    $exists = 1;
                    $ex_row = $this->admission_m->get_parent($exs_id);
                }


                // parent exists
                if ($exists) {
                    $pid = $ex_row->user_id;
                    $ps_id = $ex_row->id;
                } else {
                    $ppassword = '12345678'; //temporary password
                    $additional = [
                        'first_name' => $parent_user->first_name,
                        'last_name' => $parent_user->last_name,
                        'phone' => $parent_user->phone,
                        'me' => 1,
                    ];
                    $pt = explode('@', $parent_user->email);
                    $pid = $exists ? $ex_row->user_id : $this->ion_auth->register($pt[0], $ppassword, $parent_user->email, $additional);
                }



                if ($pid) {
                    $this->ion_auth->add_to_group(6, $pid);
                    /* End Parent Add to Users */

                    $pdata = [
                        'first_name' => $parent->first_name,
                        'last_name' =>  $parent->last_name,
                        'f_middle_name' => $parent->f_middle_name,
                        'email' => $parent->email,
                        'identity' => $parent->identity,
                        'f_relation' => $parent->f_relation,
                        'mother_fname' => $parent->mother_fname,
                        'mother_lname' => $parent->mother_lname,
                        'm_middle_name' => $parent->m_middle_name,
                        'mother_email' => $parent->mother_email,
                        'mother_phone' => $parent->mother_phone,
                        'f_id' =>  $parent->f_id,
                        'm_id' => $parent->m_id,
                        'status' => 1,
                        'user_id' => $pid,
                        'phone' => $parent->phone,
                        'phone2' => $parent->phone2,
                        'address' => $parent->address,
                        'created_on' => time(),
                        'created_by' => 1,
                        'occupation' => $parent->occupation,
                        'mother_occupation' => $parent->mother_occupation,

                    ];

                    $ps_id = $exists ? $ex_row->id : $this->admission_m->save_parent($pdata); //parent id
                } else {

                    $pid = $this->ion_auth->register($pt[0], $ppassword, $parent, $additional);
                    $pdata['user_id'] = $pid;
                    $ps_id = $exists ? $ex_row->id : $this->admission_m->save_parent($pdata);
                }


                //check if student exists
                $std = $this->admission_m->get_by_adm_no($p->admission_number);

                if ($std) {
                    $exists_std = 1;
                    $student = $this->admission_m->find($std->id);
                }



                /* Create Student User */

                $username = strtolower(str_replace(' ', '', $student_user->first_name . '.' . $student_user->last_name));
                $email = $student_user->email;
                $password = '12345678'; //temporary password

                $additional_data = [
                    'first_name' => $student_user->first_name,
                    'last_name' => $student_user->last_name,
                    'me' => 1,
                ];

                if ($this->admission_m->user_email_exists($email)) {
                    $email = $username . $p->admission_number . '@smartshule.com';
                }
                $u_id = ($exists_std == 1) ? $student->user_id : $this->ion_auth->register($username, $password, $email, $additional_data);


                //student data

                $sdata = [
                    'first_name' => $p->first_name,
                    'middle_name' => $p->middle_name,
                    'last_name' => $p->last_name,
                    'house' => $p->house,
                    'boarding_day' => $p->boarding_day,
                    'email' => $p->email,
                    'user_id' => $u_id,
                    'parent_id' => $ps_id,
                    'parent_user' => $pid,
                    'gender' => $p->gender,
                    'status' => 1,
                    'dob' => $p->dob,
                    'admission_date' => $p->admission_date,
                    'admission_number' => $p->admission_number,
                    'old_adm_no' => $p->old_adm_no,
                    'class' => $post->new_class,
                    'created_on' => time(),
                    'created_by' => 1,
                    'scholarship_type' => $p->scholarship_type,
                    'upi_number' =>  $p->upi_number,
                    'residence' => $p->residence,
                    'allergies' => $p->allergies,
                    'doctor_name' => $p->doctor_name,
                    'doctor_phone' => $p->doctor_phone,
                    'birth_cert_no' => $p->birth_cert_no,
                    'entry_marks' => $p->entry_marks,
                    'list_id' => $p->list_id,
                    'qb_status' => $p->qb_status,
                    'edit_sequence' => $p->edit_sequence
                ];

                // $rec = ($exists_std == 1) ? $student->id : $this->admission_m->create($sdata); //student admission id


                if ($exists_std) {
                    $message[] = ['status' => 201, 'response' => 'Student exists, Adm No: ' . $p->admission_number];
                } else {
                    $rec = $this->admission_m->create($sdata);

                    $i++;

                    // $this->post_callback(json_encode([$rec]), $post->url);

                    $this->branch_m->create_('received_students', ['student' => $rec, 'branch' => $post->branch, 'transfered_to' => $post->url, 'created_by' => 1, 'created_on'  => time()]);



                    // $post->url . 'branch/change_status/' . $p->id;

                    $ec = array(
                        'parent_id' => $ps_id,
                        'student' => $rec,
                        'name' => $emergency->name,
                        'middle_name' => $emergency->middle_name,
                        'last_name' => $emergency->last_name,
                        'relation' => $emergency->relation,
                        'phone' => $emergency->phone,
                        'email' => $emergency->email,
                        'provided_by' => $emergency->provided_by,
                        'id_no' => $emergency->id_no,
                        'address' => $emergency->address,
                        'created_by' =>  1,
                        'created_on' => time()
                    );

                    $this->admission_m->insert_emergency_contacts($ec);

                    if ($rec && $balance->balance != 0) {

                        $prev = 0;
                        $term = $post->term;
                        $year = $post->year;

                        if ($term == 1) {
                            $prev = 3;
                            $year = $year - 1;
                        } elseif ($term == 2) {
                            $prev = 1;
                        } elseif ($term == 3) {
                            $prev = 2;
                        } else {
                            $prev = 0;
                        }

                        $bal = [
                            'student' => $rec,
                            'amount' => $balance->balance,
                            'term' => $prev,
                            'year' => $year,
                            'created_by' => 1,
                            'created_on' => time()
                        ];

                        $this->fee_arrears_m->create($bal);
                    }

                    $message[] = ['status' => 200, 'response' => 'Transfer successfull'];
                }
            }
        }





        echo json_encode($message);
    }

    function classes()
    {
        header("Access-Control-Allow-Origin:*");

        $load = ['Only Post Allowed'];

        if ($this->input->post()) {
            $classes = $this->portal_m->get_all_streams();
            $load = [];
            foreach ($classes as $cl => $class) {
                $load[] = '<option value="' . $cl . '">' . $class . '</option>';
            }
        }

        echo json_encode($load);
    }



    function change_status($id)
    {
        $message = [];

        if ($this->branch_m->update_student($id, ['status' => 4])) {
            $message[] = ['status' => 200, 'response' => 'Success'];
        } else {
            $message[] = ['status' => 201, 'response' => 'Something went wrong'];
        }

        echo json_encode($message);
    }
}
