 <?php
  $cc = '';
  if (isset($this->classlist[$dat->class_id])) {
    $cro = $this->classlist[$dat->class_id];
    $cc = isset($cro['name']) ? $cro['name'] : '';
  }
  ?>

 <div class="row">
   <div class="col-md-12">
     <div class="card">
       <div class="card-header">
         <h5 class="mb-0"><b>Class Attendance - <?php echo $cc; ?></b></h5>
         <div class="pull-right">
           <?php echo anchor('class_attendance/trs/list_register/' . $dat->class_id, '<i class="mdi mdi-reply"></i> Back', 'class="btn btn-secondary"'); ?>
         </div>
       </div>

       <div class="card-body p-2">

         <div class="row mt-3 mb-5">
           <div class="col-3 border-end">
             <div class="d-flex flex-column justify-content-center align-items-center">
               <span class="fs-20 fw-600">Date</span>
               <div class="text-muted fs-13 text-center "><?php echo date('d M Y', $dat->attendance_date); ?></div>
             </div>
           </div>
           <div class="col-3 border-end">
             <div class="d-flex flex-column justify-content-center align-items-center">
               <span class="fs-20 fw-600">Attendance Type</span>
               <div class="text-muted fs-13 text-center"><?php echo $dat->title; ?></div>
             </div>
           </div>
           <div class="col-3 border-end">
             <div class="d-flex flex-column justify-content-center align-items-center">
               <span class="fs-20 fw-600">Total Present</span>
               <div class="text-muted fs-13 text-center"><?php echo $present; ?> Student(s)</div>
             </div>
           </div>
           <div class="col-3">
             <div class="d-flex flex-column justify-content-center align-items-center">
               <span class="fs-20 fw-600">Total Absent</span>
               <div class="text-muted fs-13 text-center"> <?php echo $absent; ?> Student(s)</div>
             </div>
           </div>
         </div>
         <?php if ($post) : ?>
           <!-- <table id="datatable-buttons" class="table table-striped table-bordered"> -->
           <table id="grid-pagination" class="table table-bordered responsive">
             <thead class="bg-primary">
               <th width="8%" class="tx-fixed-white">#</th>
               <th width="30%" class="tx-fixed-white">Student Details</th>
               <th style="text-align:center" width="10%" class="tx-fixed-white">Present</th>
               <th style="text-align:center" width="10%" class="tx-fixed-white">Absent</th>
               <th width="40%" class="tx-fixed-white">Remarks</th>
             </thead>
             <tbody>
               <?php
                $i = 0;
                foreach ($post as $p) :
                  $i++;
                  $classes = $this->ion_auth->list_classes();
                  $u = $this->ion_auth->list_student($p->student);
                ?>
                 <tr class="new">
                   <td><?php echo $i; ?></td>
                   <td>
                     <?php echo $u->first_name . ' ' . $u->last_name; ?> [ ADM No. <?php
                                                                                    if (!empty($u->old_adm_no))
                                                                                      echo $u->old_adm_no;
                                                                                    else
                                                                                      echo $u->admission_number;
                                                                                    ?> ]
                   </td>
                   <?php if ($p->status == 'Present') : ?>
                     <td style="text-align:center">
                       <button class="btn btn-primary"><span class="mdi mdi-checkbox-marked-outline"></span></button>
                     </td>
                     <td style="text-align:center">---</td>
                   <?php else : ?>
                     <td style="text-align:center">---</td>
                     <td style="text-align:center;">
                       <button class="btn btn-secondary"><span class="mdi mdi-close"></span></button>
                     </td>
                   <?php endif; ?>
                   <td><?php echo $p->remarks; ?></td>
                 </tr>
               <?php endforeach ?>
             </tbody>

           </table>

         <?php else : ?>
           <p class='text'><?php echo lang('web_no_elements'); ?></p>
         <?php endif ?>
       </div>

     </div>
     <div class="card-footer">

     </div>
   </div>
 </div>
 </div>

 <style>
   .card-header {
     display: flex;
     justify-content: space-between;
   }
 </style>