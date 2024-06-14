 <div class="row">
   <div class="col-xl-12">
     <div class="card">
       <div class="card-body p-3">
         <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
           <h5 class="mb-0"><b>All Teachers</b></h5>
           <div class="d-flex gap-2">
             <a href="<?= base_url('teachers/trs/create/') ?>" class="btn btn-primary btn-sm">
               <i class="fa fa-plus-square me-2"></i> Add New Teacher
             </a>
             <a class="btn btn-sm btn-secondary" onclick="goBack()">
               <i class="fa fa-caret-left"></i> Go Back
             </a>
           </div>
         </div>
       </div>

     </div>
   </div>
 </div>

 <div class="row">
   <div class="col-md-12">
     <div class="card">




       <div class="card-body p-2 bg-light">
         <div class="row">
           <?php

            ?>
           <?php foreach ($teachers as $teacher) {

              $p = (object) $teacher;
            ?>
             <div class="col-xxl-3 col-xl-3 col-lg-6 col-sm-6 col-md-3">
               <div class="card">
                 <div class="product-grid6">
                   <div class="product-image6">
                     <ul class="icons">
                       <li>
                         <a href="<?= base_url('teachers/trs/profile/' . $p->id) ?>" class="btn btn-primary"> <i class="fe fe-eye"> </i> </a>
                       </li>

                     </ul>
                   </div>
                   <div class="card-body shop-product">
                     <?php

                      $path = base_url('uploads/files/' . $p->passport);
                      $fake = base_url('uploads/files/member.png');

                      if (!empty($p->passport)) {
                        $ppst = '<image src="' . $path . '"  class="img-polaroid img-thumbnail" style="width:200px; height:180px" >';
                      } else {
                        $ppst = '<image src="' . $fake . '"  class="img-polaroid img-thumbnail" style="width:200px; height:190px"  >';
                      }
                      ?>

                     <div class="image col-md-12" style="text-align:center">
                       <?php echo $ppst; ?>
                     </div>
                     <!-- <a href="shop-description.html"><img src="../assets/images/shop/1.png" class="rounded-2 w-100" alt="img"></a> -->
                     <div class="d-flex justify-content-between mt-3">
                       <div>
                         <h6 class="mb-0"><?php echo $p->first_name . ' ' . $p->last_name ?></h6>
                         <small class="text-muted"><?php echo $p->position ?></small>


                       </div>
                       <div>
                         <?php if ($p->status == 1) {
                            $status = '<span class="badge bg-success">Active</span>';
                          } else {
                            $status = '<span class="badge bg-secondary">Disabled</span>';
                          }
                          echo $status;
                          ?>

                       </div>

                     </div>
                     <div class="button-container mt-4">
                       <a href="<?= base_url('teachers/trs/profile/' . $p->id) ?>" class="btn btn-primary btn-sm btn-left">
                         <i class="fa fa-eye me-2"></i>View
                       </a>
                       <a href="<?= base_url('teachers/trs/edit/' . $p->id) ?>" class="btn btn-sm btn-warning btn-right">
                         <i class="fa fa-pencil-alt me-2"></i>Edit
                       </a>
                     </div>

                   </div>
                 </div>
               </div>
             </div>
           <?php  } ?>
         </div>


       </div>

     </div>
   </div>
   <?php echo form_close(); ?>
 </div>

 <style>
   .card-header {
     display: flex;
     justify-content: space-between;
   }

   .button-container {
     overflow: hidden;
     /* To clear floats */
   }

   .button-container .btn-left {
     float: left;
   }

   .button-container .btn-right {
     float: right;
   }
 </style>