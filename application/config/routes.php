<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$route['quickbooks/(:any)'] = 'quickbooks/quickbooks/$1';
$route['trs/zoom/extras'] = 'zoom/zoom/$1';
$route['trs/zoom/extras/(:any)'] = 'zoom/zoom/$1';
$route['trs/zoom/(:any)'] = 'zoom/zoom/$1';
$route['forgotten_password'] = 'admin/admin/forgot_password';
$route['login'] = "index/login";
$route['services/confirm'] = "fee_payment/fee_payment/paybill";
$route['services/validate'] = "fee_payment/fee_payment/tx_validate";

$route['portal'] = "reports/index/access_portal";

$route['lipa_na_mpesa'] = "fee_payment/index/stkpush";

$route['bk/kcb/test_bed'] = "fee_payment/fee_payment/kcb_test";
$route['bk/kcb/prod'] = "fee_payment/fee_payment/kcb_prod";

$route['fee_payment/callBack'] = "fee_payment/fee_payment/callBack";
$route['([a-zA-Z_-]+)'] = 'index/$1';

$route['transport'] = 'transport/tsp';
$route['transport/([a-zA-Z_-]+)'] = 'transport/tsp/$1';


// iga
$route['iga'] = 'other_revenue/other_revenue';
$route['iga/([a-zA-Z_-]+)'] = 'other_revenue/other_revenue/$1';

$route['parents_switch'] = "admin/admin/parents_switch/$1/$2/$3/$4";
$route['admin/login'] = "admin/admin/login";
$route['admin/rl'] = 'admin/admin/rl';
$route['admin/inventory'] = "admin/admin/inventory";
$route['admin/zoomMeeting'] = "admin/admin/zoomMeeting";
//Routes For help
$route['admin/help'] = 'admin/admin/help';
//rooutes for mobile

$route['postsid'] = "index/postsid";
$route['verifyurl'] = "index/url_verify";
$route['mlogin'] = "index/mobile_login";

$route['admin/fee_statement'] = "admin/admin/fee_statement";
$route['logout'] = "index/logout";
$route['sms'] = "sms";
//$route['sms/(:any)'] = "sms/$1";
$route['admin/logout'] = "users/admin/logout";
$route['admin/update_password'] = "admin/admin/update_password";
$route['default_controller'] = "index";
$route['404_override'] = 'index/gotcha';
$route['admin/(login|logout|profile|license|change_password|forgot_password|activity)'] = 'admin/admin/$1';

$route['admin/([a-zA-Z_-]+)'] = '$1/admin';
$route['admin/(search)/(:any)'] = 'admin/admin/search/$1';
$route['admin/([a-zA-Z_-]+)/(:any)'] = '$1/admin/$2';

$route['contact'] = "index/contact";
$route['admin/reset_password/(:any)'] = "users/admin/reset_password/$1";
$route['admin'] = "admin/admin/index";
$route['messages'] = 'messages';
$route['assignments'] = 'assignments';
$route['assignments/(:any)'] = 'assignments/$1';
$route['class_attendance'] = 'class_attendance';
//Routes For sub_cats
$route['sub_cats/(:num)'] = 'sub_cats/index/$1';
$route['my_sms/(:num)'] = 'index/my_sms/$1';

//api
$route['api'] = 'rest/api';
$route['api/([a-zA-Z_-]+)'] = 'rest/api/$1';
$route['api/([a-zA-Z_-]+)/(:any)'] = 'rest/api/$1/$2';
$route['api/([a-zA-Z_-]+)/(:any)/(:any)'] = 'rest/api/$1/$2/$3';
$route['api/([a-zA-Z_-]+)/(:num)/(:num)/(:num)'] = 'rest/api/$1/$2/$3/$4';

$route['parents/cbc'] = 'cbc/parents/$1';
$route['parents/cbc/(:any)'] = 'cbc/parents/$1';
//teacher portal routes
$route['trs/cbc'] = 'cbc/cbc';
$route['trs/cbc/(:any)'] = 'cbc/cbc/$1';

$route['trs/diary'] = 'diary/diary';
$route['trs/diary/extras'] = 'diary/diary/$1';
$route['trs/diary/extras/(:any)'] = 'diary/diary/$1';
$route['trs/diary/(:any)'] = 'diary/diary/$1';

$route['trs'] = 'trs';
$route['trs/([a-zA-Z_-]+)'] = 'trs/$1';
$route['trs/([a-zA-Z_-]+)/(:any)'] = 'trs/$1/$2';

//Student portal routes
$route['st'] = 'st';
$route['st/([a-zA-Z_-]+)'] = 'st/$1';
$route['st/([a-zA-Z_-]+)/(:any)'] = 'st/$1/$2';

//Routes For enquiries
$route['enquiries/(:num)'] = 'enquiries/index/$1';

//Routes For titles
$route['titles/(:num)'] = 'titles/index/$1';

//Routes For notice_board
$route['notice_board/(:num)'] = 'notice_board/index/$1';

//Routes For students_certificates
$route['students_certificates/(:num)'] = 'students_certificates/index/$1';

//Routes For registration_details
$route['registration_details/(:num)'] = 'registration_details/index/$1';

//Routes For ownership_details
$route['ownership_details/(:num)'] = 'ownership_details/index/$1';

//Routes For institution_doc
$route['institution_doc/(:num)'] = 'institution_doc/index/$1';

//Routes For folders
$route['folders/(:num)'] = 'folders/index/$1';

//Routes For past_papers
$route['past_papers/(:num)'] = 'past_papers/index/$1';

//Routes For past_papers
$route['past_papers/(:num)'] = 'past_papers/index/$1';

//Routes For institution_docs
$route['institution_docs/(:num)'] = 'institution_docs/index/$1';

//Routes For grants
$route['grants/(:num)'] = 'grants/index/$1';

//Routes For contracts
$route['contracts/(:num)'] = 'contracts/index/$1';

//Routes For departments
$route['departments/(:num)'] = 'departments/index/$1';

//Routes For board_members
$route['board_members/(:num)'] = 'board_members/index/$1';

//Routes For students_clearance
$route['students_clearance/(:num)'] = 'students_clearance/index/$1';

//Routes For students_clearance
$route['students_clearance/(:num)'] = 'students_clearance/index/$1';

//Routes For staff_clearance
$route['staff_clearance/(:num)'] = 'staff_clearance/index/$1';

//Routes For audit_logs
$route['audit_logs/(:num)'] = 'audit_logs/index/$1';

//Routes For emergency_contacts
$route['emergency_contacts/(:num)'] = 'emergency_contacts/index/$1';

//Routes For rules_regulations
$route['rules_regulations/(:num)'] = 'rules_regulations/index/$1';

//Routes For clearance_departments
$route['clearance_departments/(:num)'] = 'clearance_departments/index/$1';

//Routes For contact_person
$route['contact_person/(:num)'] = 'contact_person/index/$1';

//Routes For contact_person
$route['contact_person/(:num)'] = 'contact_person/index/$1';

//Routes For final_exams_certificates
$route['final_exams_certificates/(:num)'] = 'final_exams_certificates/index/$1';

//Routes For final_exams_grades
$route['final_exams_grades/(:num)'] = 'final_exams_grades/index/$1';

//Routes For verifiers
$route['verifiers/(:num)'] = 'verifiers/index/$1';

//Routes For subcounties
$route['subcounties/(:num)'] = 'subcounties/index/$1';

//Routes For positions
$route['positions/(:num)'] = 'positions/index/$1';

//Routes For positions
$route['positions/(:num)'] = 'positions/index/$1';

//Routes For payment_options
$route['payment_options/(:num)'] = 'payment_options/index/$1';

//Routes For favourite_hobbies
$route['favourite_hobbies/(:num)'] = 'favourite_hobbies/index/$1';

//Routes For lesson_plan
$route['lesson_plan/(:num)'] = 'lesson_plan/index/$1';

//Routes For lesson_plan
$route['lesson_plan/(:num)'] = 'lesson_plan/index/$1';

//Routes For newsletters
$route['newsletters/(:num)'] = 'newsletters/index/$1';

//Routes For evideos
$route['evideos/(:num)'] = 'evideos/index/$1';

//Routes For evideos
$route['evideos/(:num)'] = 'evideos/index/$1';

//Routes For evideos
$route['evideos/(:num)'] = 'evideos/index/$1';

//Routes For enotes
$route['enotes/(:num)'] = 'enotes/index/$1';

//Routes For enotes
$route['enotes/(:num)'] = 'enotes/index/$1';

//Routes For lesson_materials
$route['lesson_materials/(:num)'] = 'lesson_materials/index/$1';

//Routes For lesson_materials
$route['lesson_materials/(:num)'] = 'lesson_materials/index/$1';

//Routes For qa
$route['qa/(:num)'] = 'qa/index/$1';

//Routes For qa_questions
$route['qa_questions/(:num)'] = 'qa_questions/index/$1';

//Routes For mc
$route['mc/(:num)'] = 'mc/index/$1';

//Routes For mc_questions
$route['mc_questions/(:num)'] = 'mc_questions/index/$1';

//Routes For mc_choices
$route['mc_choices/(:num)'] = 'mc_choices/index/$1';

//Routes For effort
$route['effort/(:num)'] = 'effort/index/$1';

//Routes For book_list
$route['book_list/(:num)'] = 'book_list/index/$1';

//Routes For appraisal_targets
$route['appraisal_targets/(:num)'] = 'appraisal_targets/index/$1';

//Routes For ebooks
$route['ebooks/(:num)'] = 'ebooks/index/$1';

//Routes For schemes_of_work
$route['schemes_of_work/(:num)'] = 'schemes_of_work/index/$1';

//Routes For record_of_work_covered
$route['record_of_work_covered/(:num)'] = 'record_of_work_covered/index/$1';

//Routes For students_projects
$route['students_projects/(:num)'] = 'students_projects/index/$1';

//Routes For zoom
$route['zoom/(:num)'] = 'zoom/index/$1';
$route['trs/zoom'] = 'zoom/zoom';
// $route['trs/zoom/(:any)'] = 'zoom/zoom/$1';
//Routes For shop_item
$route['shop_item/(:num)'] = 'shop_item/index/$1';

//Routes For coop_bank_file
$route['coop_bank_file/(:num)'] = 'coop_bank_file/index/$1';


//Routes For transport_trips
$route['transport_trips/(:num)'] = 'transport_trips/index/$1';

//Routes For transport_drivers
$route['transport_drivers/(:num)'] = 'transport_drivers/index/$1';

//Routes For driver_categories
$route['driver_categories/(:num)'] = 'driver_categories/index/$1';

//Routes For mpesa
$route['mpesa/(:num)'] = 'mpesa/index/$1';

//Routes For igcse
$route['igcse/(:num)'] = 'igcse/index/$1';