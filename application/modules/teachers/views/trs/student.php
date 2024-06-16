 <!-- CONTAINER -->
 <div class="main-container container-fluid">

   <!-- ROW-1 -->
   <div class="row">
     <div class="col-xxl-3 col-xl-4 col-lg-5 col-md-5">
       <div class="card text-center shadow-none border profile-cover__img">
         <div class="card-body">
           <div class="profile-img-1">

             <?php
              $photo = $this->trs_m->get_stpassport($stu->photo);

              if (isset($stu->photo) && $stu->photo !== null) { ?>
               <img src="<?php echo base_url('uploads/' . $photo->fpath . '' . $photo->filename); ?>" alt="user-img" width="150" height="150" class="img-circle">
             <?php } else { ?>
               <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" alt="user-img" width="150" class="img-circle">
             <?php }
              ?>

           </div>
           <div class="profile-img-content text-dark my-2">
             <div>
               <h5 class="mb-0"><?php echo ucwords($stu->first_name . ' ' . $stu->last_name) ?></h5>
               <p class="text-muted mb-0"><?php echo $stu->cl->name ?></p>
             </div>
           </div>
           <div>
             <div class="text-warning mb-0">
               <i class="fa fa-star fs-20"></i>
               <i class="fa fa-star fs-20"></i>
               <i class="fa fa-star fs-20"></i>
               <i class="fa fa-star fs-20"></i>
               <i class="fa fa-star fs-20"></i>
             </div>
           </div>

           <div class="d-flex btn-list btn-list-icon justify-content-center mt-3">

             <button type="button" class="btn btn-primary-gradient"><i class="fe fe-user-check me-1"></i><?php echo $att_total['present_count'] . ' ' ?> days Present</button>
             <button type="button" class="btn btn-secondary-gradient"><i class="fe fe-user-x me-1"></i><?php echo $att_total['absent_count'] . ' ' ?> days present</button>
           </div>
         </div>
       </div>


       <div class="card">
         <div class="card-header justify-content-between align-items-center">
           <div class="card-title">Siblings</div>
           <div class="dropdown">
             <a aria-label="anchor" href="javascript:void(0);" class="text-dark" data-bs-toggle="dropdown" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>
             <ul class="dropdown-menu">

             </ul>
           </div>
         </div>
         <div class="card-body pt-0">
           <?php
            if (!empty($sibling)) {
              foreach ($sibling as $sib) {

                if ($sib->id !== $stu->id) {

                  $sibdetails = $this->worker->get_student($sib->id);

            ?>
                 <div class="d-flex align-items-center mt-3">
                   <?php
                    $photo = $this->trs_m->get_stpassport($sibdetails->photo);

                    if (isset($sibdetails->photo) && $sibdetails->photo !== null) { ?>
                     <div class="avatar avatar-lg rounded-circle">

                       <img src="<?php echo base_url('uploads/' . $photo->fpath . '' . $photo->filename); ?>" class="rounded-circle img-circle" alt="img">
                     </div>
                   <?php } else { ?>
                     <div class="avatar avatar-lg rounded-circle">
                       <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" alt="user-img" class="rounded-circle img-circle">
                     </div>
                   <?php } ?>
                   <div class="ms-3">
                     <h6 class="mb-0 fw-semibold"><?php $ss = strtolower($sib->first_name . ' ' . $sib->last_name);
                                                  echo ucwords($ss);

                                                  ?></h6>
                     <p class="mb-0 fs-13"><?php echo $sibdetails->cl->name ?></p>
                   </div>
                   <div class="ms-auto">
                     <?php

                      $url = base_url('teachers/trs/student_view/' . $sibdetails->id);

                      echo anchor($url, '<span class="ms-1"><button type="button" aria-label="anchor" class="btn btn-icon btn-sm btn-success-light rounded-pill"><i class="fe fe-eye"></i></button></span>');

                      ?>

                   </div>
                 </div>
           <?php
                }
              }
            } ?>

         </div>
       </div>
     </div>
     <div class="col-xxl-9 col-xl-8 col-lg-7 col-md-7">
       <div class="card">
         <div class="card-header">
           <ul class="nav nav-pills gap-2" id="pills-tab" role="tablist">
             <li class="nav-item" role="presentation">
               <button type="button" aria-label="anchor" class="nav-link active" id="about-tab" data-bs-toggle="pill" data-bs-target="#about">About</button>
             </li>
             <li class="nav-item" role="presentation">
               <button class="nav-link" id="timeline-tab" data-bs-toggle="pill" data-bs-target="#timeline" type="button" role="tab" aria-controls="timeline" aria-selected="false">Parents</button>
             </li>
             <li class="nav-item" role="presentation">
               <button class="nav-link" id="projects-tab" data-bs-toggle="pill" data-bs-target="#projects" type="button" role="tab" aria-controls="projects" aria-selected="false">Projects</button>
             </li>
           </ul>
         </div>
         <div class="card-body p-0">
           <div class="tab-content" id="pills-tabContent">
             <div class="tab-pane fade show active mb-0" id="about">
               <div class="table-responsive p-5">
                 <h5 class="mb-3">Personal Info</h5>
                 <div class="row">
                   <div class="col-xl-8 ms-3">
                     <div class="row row-sm">
                       <div class="col-md-4">
                         <span class="fw-semibold fs-14">First Name : </span>
                       </div>
                       <div class="col-md-8">
                         <span class="fs-15"><?php echo ucwords($stu->first_name) ?></span>
                       </div>
                     </div>
                     <div class="row row-sm mt-3">
                       <div class="col-md-4">
                         <span class="fw-semibold fs-14">Last Name : </span>
                       </div>
                       <div class="col-md-8">
                         <span class="fs-15"><?php echo ucwords($stu->last_name) ?></span>
                       </div>
                     </div>
                     <div class="row row-sm mt-3">
                       <div class="col-md-4">
                         <span class="fw-semibold fs-14">Admission Number : </span>
                       </div>
                       <div class="col-md-8">
                         <span class="fs-15"><?php echo ucwords($stu->admission_number) ?></span>
                       </div>
                     </div>
                     <div class="row row-sm mt-3">
                       <div class="col-md-4">
                         <span class="fw-semibold fs-14">Gender : </span>
                       </div>
                       <div class="col-md-8">
                         <span class="fs-15"><?php if ($stu->gender == 1) {
                                                echo "Male";
                                              } else {
                                                echo "female";
                                              }
                                              ?></span>
                       </div>
                     </div>
                     <div class="row row-sm mt-3">
                       <div class="col-md-4">
                         <span class="fw-semibold fs-14">Date of Birth : </span>
                       </div>
                       <div class="col-md-8">
                         <span class="fs-15"><?php

                                              $timestamp = $stu->dob;
                                              $formatted_date = date('Y-m-d ', $timestamp);
                                              echo $formatted_date;
                                              ?>
                         </span>
                       </div>
                     </div>
                     <div class="row row-sm mt-3">
                       <div class="col-md-4">
                         <span class="fw-semibold fs-14">Admission Date : </span>
                       </div>
                       <div class="col-md-8">
                         <span class="fs-15"><?php

                                              $timestamp = $stu->admission_date;
                                              $formatted_date = date('Y-m-d ', $timestamp);
                                              echo $formatted_date;
                                              ?>
                         </span>
                       </div>
                     </div>

                     <div class="row row-sm mt-3">
                       <div class="col-md-4">
                         <span class="fw-semibold fs-14">Email : </span>
                       </div>
                       <div class="col-md-8">
                         <span class="fs-15 text-primary"><?php echo $stu->email ?></span>
                       </div>
                     </div>

                     <div class="row row-sm mt-3">
                       <div class="col-md-4">
                         <span class="fw-semibold fs-14">Address : </span>
                       </div>
                       <div class="col-md-8">
                         <span class="fs-15"><?php echo $stu->residence ?></span>
                       </div>
                     </div>
                     <div class="row row-sm mt-3">
                       <div class="col-md-4">
                         <span class="fw-semibold fs-14">Phone : </span>
                       </div>
                       <div class="col-md-8">
                         <span class="fs-15 text-primary"><?php echo $stu->phone ?></span>
                       </div>
                     </div>
                     <div class="row row-sm mt-3">
                       <div class="col-md-4">
                         <span class="fw-semibold fs-14">Class : </span>
                       </div>
                       <div class="col-md-8">
                         <span class="fs-15"><?php echo ucwords($stu->cl->name) ?></span>
                       </div>
                     </div>
                     <div class="row row-sm mt-3">
                       <div class="col-md-4">
                         <span class="fw-semibold fs-14">Class Teacher : </span>
                       </div>
                       <div class="col-md-8">
                         <span class="fs-15"><?php
                                              $this->load->model('trs_m');
                                              $tr = $this->trs_m->findtr($stu->cl->class_teacher);

                                              echo $tr->first_name . ' ' . $tr->last_name;

                                              ?></span>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
               <div class="border-top"></div>
               <div class="p-5">
                 <h5 class="mb-3">Health Records</h5>
                 <div class="d-flex mt-3">
                   <div class="experience-icon bg-primary rounded-circle">
                     <i class="fas fa-plus fs-22 tx-fixed-white" style="font-weight: 900;"></i>

                   </div>
                   <div class="ms-3">
                     <h6 class="text-dark fw-semibold mb-0">Allergies</h6>
                     <p class="mb-2 mt-2"><b><?php echo $stu->allergies ?></b></p>
                   </div>
                 </div>
                 <div class="d-flex mt-4">
                   <div class="experience-icon bg-secondary rounded-circle">
                     <i class="fe fe-droplet fs-22 tx-fixed-white"></i>

                   </div>
                   <div class="ms-3">
                     <h6 class="text-dark fw-semibold mb-0">Blood Group</h6>
                     <p class="mb-2 mt-2"><b><?php echo $stu->blood_group ?></b></p>
                   </div>
                 </div>
                 <div class="d-flex mt-4">
                   <div class="experience-icon bg-info rounded-circle">
                     <i class="fas fa-wheelchair fs-22 tx-fixed-white"></i>
                   </div>
                   <div class="ms-3">
                     <h6 class="text-dark fw-semibold mb-0">Disability</h6>

                     <p class="mb-2 mt-2"><b><?php echo $stu->disabled ?></b></p>

                   </div>
                 </div>

                 <div class="d-flex mt-4">
                   <div class="experience-icon bg-warning rounded-circle">
                     <i class="fas fa-blind fs-22 tx-fixed-white"></i>
                   </div>
                   <div class="ms-3">
                     <h6 class="text-dark fw-semibold mb-0">Disability Type</h6>
                     <p class="mb-2 mt-2"><b><?php echo $stu->disability_type ?></b></p>
                   </div>
                 </div>
               </div>
             </div>
             <div class="tab-pane fade" id="timeline">
               <div class="row p-5">
                 <div class="col-xl-12">
                   <div class="row">
                     <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
                       <div class="card text-center shadow-none border profile-cover__img">
                         <div class="card-body">
                           <div class="profile-img-1">

                             <?php
                              $this->load->model('parents/parents_m');
                              $pr = $this->parents_m->find($stu->parent_id);

                              $photo = $this->trs_m->get_prpassport($pr->father_photo);
                              if (isset($pr->father_photo) && $pr->father_photo !== null) { ?>
                               <img src="<?php echo base_url('uploads/' . $photo->fpath . '' . $photo->filename); ?>" alt="user-img" width="150" height="150" class="img-circle">
                             <?php } else { ?>
                               <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" alt="user-img" width="150" class="img-circle">
                             <?php }
                              ?>

                           </div>
                           <div class="profile-img-content text-dark my-2">
                             <div>
                               <h5 class="mb-0"><?php
                                                echo ucwords($pr->first_name . ' ' . $pr->last_name). ' (' . strtolower($pr->f_relation) . ')' ?></h5>
                               <p class="text-muted mb-0"><?php echo $pr->phone ?></p>
                               <p class="text-muted mb-0"><?php echo $pr->email ?></p>
                             </div>
                           </div>
                           <div>
                             <div class="text-primary mb-0">
                               <i class="fa fa-star fs-20"></i>
                               <i class="fa fa-star fs-20"></i>
                               <i class="fa fa-star fs-20"></i>

                             </div>
                           </div>

                           <div class="d-flex btn-list btn-list-icon justify-content-center mt-3">
                             <!-- <button type="button" class="btn btn-sm btn-primary"><i class="fe fe-user me-1"></i><?php echo $pr->f_relation ?></button> -->
                             <button type="button" class="btn btn-sm btn-info"><i class="fe fe-message-square me-1"></i>message</button>
                           </div>
                         </div>
                       </div>
                     </div>
                     <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
                       <?php if ($pr->mother_fname !== "" || $pr->mother_fname !== NULL) {
                        ?>
                         <div class="card text-center shadow-none border profile-cover__img">
                           <div class="card-body">
                             <div class="profile-img-1">

                               <?php

                                $photo = $this->trs_m->get_prpassport($pr->mother_photo);
                                if (isset($pr->mother_photo) && $pr->mother_photo !== null) { ?>
                                 <img src="<?php echo base_url('uploads/' . $photo->fpath . '' . $photo->filename); ?>" alt="user-img" width="150" height="150" class="img-circle">
                               <?php } else { ?>
                                 <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" alt="user-img" width="150" class="img-circle">
                               <?php }
                                ?>

                             </div>
                             <div class="profile-img-content text-dark my-2">
                               <div>
                                 <h5 class="mb-0"><?php echo ucwords($pr->mother_fname . ' ' . $pr->mother_lname).' ('.strtolower($pr->m_relation).')' ?></h5>
                                 <p class="text-muted mb-0"><?php echo $pr->mother_phone ?></p>
                                 <p class="text-muted mb-0"><?php echo $pr->mother_email ?></p>
                               </div>
                             </div>
                             <div>
                               <div class="text-primary mb-0">
                                 <i class="fa fa-star fs-20"></i>
                                 <i class="fa fa-star fs-20"></i>
                                 <i class="fa fa-star fs-20"></i>

                               </div>
                             </div>

                             <div class="d-flex btn-list btn-list-icon justify-content-center mt-3">
                               
                               <button type="button" class="btn btn-sm btn-info"><i class="fe fe-message-square me-1"></i>Message</button>
                             </div>
                           </div>
                         </div>
                       <?php }  ?>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
             <div class="tab-pane projects fade" id="projects">
               <div class="row p-5">
                 <?php if (!empty($projects)) { // Check if the projects array is not empty 
                  ?>
                   <?php foreach ($projects as $project) { ?>
                     <div class="col-md-12 col-xl-6">
                       <div class="card shadow-none">
                         <div class="card-body">
                           <div class="row">
                             <div class="col-md-12">
                               <div class="row">
                                 <div class="col">
                                   <div class="d-sm-flex align-items-center">
                                     <span class="avatar avatar-md br-5 bg-primary rounded-circle project-icon">
                                       <i class="fe fe-grid"></i>
                                     </span>
                                     <div class="ms-2 mt-sm-0 mt-2">
                                       <h6 class="mb-2">
                                         <a href="#" class="float-start"><?php echo $project->strand ?></a>
                                         <span class="badge bg-light text-muted fs-11 mx-2"></span>
                                       </h6>
                                       <span class="text-muted border-end pe-2 fs-12 float-start bg-light mt-2"><?php echo $subjects[$project->subject] ?></span>
                                       <span class="ps-1 fs-12"></span>
                                     </div>
                                   </div>
                                 </div>
                                 <div class="col-auto">
                                   <div class="d-flex align-items-center">
                                     <div class="stars-main me-2">
                                       <i class="fa fa-star text-light star"></i>
                                     </div>
                                   </div>
                                 </div>
                               </div>
                             </div>
                             <div class="col-md-12 mt-4">
                               <div class="row align-items-center">
                                 <div class="col-md-7">
                                   <p class="m-0 mb-2 fw-600">Project Photo</p>
                                   <?php if (isset($project->file_name) && $project->file_name !== null) { ?>
                                     <img src="<?php echo base_url($project->file_path . '/' . $project->file_name); ?>" alt="user-img" class="fixed-height-img">
                                   <?php } ?>
                                 </div>
                                 <div class="col-md-5">
                                   <p class="mb-0">
                                     <span class="text-muted d-block">Due Date</span>
                                     <span class="text-danger">Term <?php echo ' ' . $project->term ?> <?php echo $project->year ?></span>
                                   </p>
                                 </div>
                               </div>
                             </div>
                           </div>
                         </div>
                       </div>
                     </div>
                   <?php } ?>
                 <?php } else { ?>
                   <div class="col-md-12">
                     <p>No projects available.</p>
                   </div>
                 <?php } ?>
               </div>
             </div>
           </div>




         </div>
       </div>
     </div>
   </div>
 </div>
 <!-- ROW-1 CLOSED -->

 </div>
 <!-- CONTAINER CLOSED -->


 <style>
   .fixed-height-img {
     height: 150px;
     object-fit: cover;
     width: auto;
     display: block;
     margin: 0 auto;
     /* Centers the image */
   }
 </style>