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
         <h5 class="mb-0"><b>Edit Class Attendance - <span class="text-primary"> <?php
                                                                                  echo $cc;
                                                                                  ?></span></b></h5>
         <div class="float-end">
           <?php echo anchor('class_attendance/attendance/list', '<i class="mdi mdi-reply"></i> List All', 'class="btn btn-secondary"'); ?>
         </div>
       </div>

       <div class="card-body p-2">


         <?php
          $attributes = array('class' => 'form-horizontal', 'id' => '');
          echo form_open_multipart(current_url(), $attributes);
          ?>
         <div class="row mb-4">
           <label for="attendance_date" class="col-md-2 form-label">Attendance Date <span class='required'>*</span></label>
           <div class="col-md-6">
             <div class="input-group">
               <div class="input-group-text">
                 <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
               </div>
               <?php echo form_input('attendance_date', $dat->attendance_date > 0 ? date('d M Y', $dat->attendance_date) : $dat->attendance_date, 'class="validate[required] form-control datepicker placeholder="Choose date"'); ?>
             </div>
             <?php echo form_error('attendance_date'); ?>
           </div>
         </div>

         <div class="row mb-4">
           <label for="title" class="col-md-2 form-label">Attendance For <span class='required'>*</span></label>
           <div class="col-md-6">
             <?php
              $items = array(
                'Whole Day' => 'Whole Day',
                "Morning" => "Morning Classes",
                "Evening" => "Evening Classes",
                "Class Time" => "Class Time",
              );

              echo form_dropdown('title', $items, (isset($dat->title)) ? $dat->title : '', ' class="select form-select form-control" data-placeholder="Select Options..." id="inputGroupSelect02" ');
              echo form_error('title');
              ?>
           </div>
         </div>

         <table id="grid-example1" class="table table-bordered">
           <thead>
             <tr class="table-primary bg-primary">
               <th class="tx-fixed-white" width="3">#</th>
               <th class="tx-fixed-white">Student</th>
               <th class="tx-fixed-white">
                 <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top secondary">
                   <input class="custom-control-input checks" id="user1" type="checkbox" name="present">
                   <label class="custom-control-label" for="user1">Present</label>
                 </div>


               </th>
               <th class="tx-fixed-white">
                 <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top secondary">
                   <input class="custom-control-input checkall" id="user2" type="checkbox" name="absent">
                   <label class="custom-control-label" for="user2">Absent</label>
                 </div>
               </th>
               <th class="tx-fixed-white">Remarks</th>
             </tr>
           </thead>
           <tbody>
             <?php
              $i = 1;
              foreach ($post as $p) :
              ?>
               <tr>
                 <td>
                   <span id="reference" name="reference" class="heading-reference"><?php echo $i; ?></span>
                 </td>
                 <td>
                   <?php
                    $st = $this->worker->get_student($p->student);
                    echo $st->first_name . ' ' . $st->last_name;
                    ?>
                 </td>
                 <td>
                   <div class="form-check form-check-md">
                     <?php echo form_radio('status[' . $p->student . ']', 'Present', $p->status == 'Present' ? 1 : 0, 'class="switchx check-lef form-check-input" id="Radio-md" style="margin: 0 auto;display: inline-block;"') ?>
                   </div>
                 </td>
                 <td>
                   <div class="form-check form-check-md">
                     <?php echo form_radio('status[' . $p->student . ']', 'Absent', $p->status == 'Absent' ? 1 : 0, 'class="switchx check form-check-input" id="Radio-md" style="margin: 0 auto;display: inline-block;"') ?>
                     <?php echo form_error('status'); ?>
                   </div>
                 </td>
                 <td>
                   <textarea name="remarks[<?php echo $p->student; ?>]" cols="25" rows="1" class="col-md-12 form-control remarks  validate[required]" style="resize:vertical;" id="remarks"><?php echo set_value('remarks', (isset($p->remarks)) ? htmlspecialchars_decode($p->remarks) : ''); ?></textarea>
                 </td>
               </tr>
             <?php
                $i++;
              endforeach;
              ?>
           </tbody>

         </table>


       </div>
       <div class="card-footer">
         <div class='form-group'>
           <div class="col-md-12 text-md-end">
             <?php echo anchor('class_attendance/attendance/list', '<i class="fe fe-arrow-left-circle me-1 lh-base"></i> Cancel', 'class="btn btn-secondary mb-1 d-inline-flex go_back"'); ?>
             <span></span>
             <?php
              $button_text = ($updType == 'edit') ? 'Update' : '<i class="fe fe-check-square me-1 lh-base"></i> Save';
              $button_attributes = ($updType == 'create') ? "id='submit' class='btn btn-info mb-1 d-inline-flex' onclick='return confirm(\"Are you sure?\")'" : "id='submit' class='btn btn-info mb-1 d-inline-flex' onclick='return confirm(\"Are you sure?\")'";
              ?>

             <button type="submit" <?php echo $button_attributes ?>><?php echo $button_text ?></button>

           </div>
         </div>
         <?php echo form_close(); ?>
       </div>

     </div>
   </div>
 </div>
 <script>
   document.addEventListener("DOMContentLoaded", function() {
     document.getElementById("user1").addEventListener("change", function() {
       updatePresentRadioButtons(this.checked);
     });

     document.getElementById("user2").addEventListener("change", function() {
       updateAbsentRadioButtons(this.checked);
     });

     function updatePresentRadioButtons(isChecked) {
       var presentRadioButtons = document.querySelectorAll('.switchx.check-lef[value="Present"]');
       presentRadioButtons.forEach(function(radioButton) {
         radioButton.checked = isChecked;
       });
     }

     function updateAbsentRadioButtons(isChecked) {
       var absentRadioButtons = document.querySelectorAll('.switchx.check[value="Absent"]');
       absentRadioButtons.forEach(function(radioButton) {
         radioButton.checked = isChecked;
       });
     }
   });
 </script>
 <style>
   .card-header {
     display: flex;
     justify-content: space-between;
   }

   /* style radio button */
   .custom-control-input:checked+.custom-control-label::before {
     border-color: #000000 !important;
     background-color: #000000 !important;
   }
 </style>