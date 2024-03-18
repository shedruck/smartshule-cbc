   <div class="row">

     <?php

      if (count($classes)  > 0) {
        foreach ($classes as $cl => $row) {
          $obj = (object) $row;
      ?>
         <div class="col-lg-6 col-md-6 col-sm-6 col-xl-3">
           <div class="card">
             <div class="card-body">
               <div class="d-flex align-items-start">
                 <div class="flex-grow-1">
                   <p class="mb-0 text-gray-600"><?php echo $obj->name ?></p>
                   <span class="fs-5"><?php echo $obj->total ?></span>
                   <span class="fs-12 text-success ms-1">Student(s)</span>
                   <button class="btn btn-primary off-canvas" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" onclick="show_subjects(<?php echo $cl ?>)">Toggle right offcanvas</button>
                 </div>
                 <div class="min-w-fit-content ms-3">
                   <span class="avatar avatar-md br-5 bg-primary-transparent text-primary">
                     <i class="fe fe-user fs-18"></i>
                   </span>
                 </div>
               </div>
             </div>
           </div>
         </div>

       <?php }
      } else { ?>
       <div class="col-md-2 col-lg-3 col-xl-3"></div>
       <div class="col-md-8 col-lg-8 col-xl-5">
         <div class="card">
           <div class="card-header border-0 bg-danger-transparent">
             <div class="alert-icon-style"><span class="avatar avatar-lg bg-danger rounded-circle"><i class="fe fe-info" aria-hidden="true"></i></span></div>
             <div class="card-options">
               <a href="javascript:void(0);" class="card-options-remove z-index1 text-danger go_back" data-bs-toggle="card-"><i class="fe fe-x"></i></a>
             </div>
           </div>
           <div class="card-body text-center">
             <h4 class="fw-semibold mb-1 mt-3">Warning</h4>
             <p class="card-text text-muted">Class allocation for Term <?php echo $this->school->term . ' ' . $this->school->year ?> not available</p>
           </div>
           <div class="card-footer text-center border-0 pt-0">
             <div class="row">
               <div class="text-center">
                 <a href="javascript:void(0);" class="btn btn-danger me-2 go_back">Cancel</a>
               </div>
             </div>
           </div>
         </div>
       </div>
     <?php } ?>



     <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight">
       <div class="offcanvas-header">
         <h6 class="fw-bold offcanvas-title">Select Exams</h6>
         <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fe fe-x fs-18"></i></button>
       </div>
       <div class="offcanvas-body">
         <div>
           <h6 class="mb-3 fw-bold" id="class_name"></h6>
           <ul class="list-group list-group-flush border">
             <div class=" mb-2" id="myload" style="display: none; border:none">
               <div class="s-body d-flex justify-content-center align-items-center flex-wrap gap-1">
                 <span class="me-0">
                   <svg id="myloader" xmlns="http://www.w3.org/2000/svg" height="60" width="60" data-name="Layer 1" viewBox="0 0 24 24">
                     <path fill="#05c3fb" d="M12 1.99951a.99974.99974 0 0 0-1 1v2a1 1 0 1 0 2 0v-2A.99974.99974 0 0 0 12 1.99951zM12 17.99951a.99974.99974 0 0 0-1 1v2a1 1 0 0 0 2 0v-2A.99974.99974 0 0 0 12 17.99951zM21 10.99951H19a1 1 0 0 0 0 2h2a1 1 0 0 0 0-2zM6 11.99951a.99974.99974 0 0 0-1-1H3a1 1 0 0 0 0 2H5A.99974.99974 0 0 0 6 11.99951zM17.19629 8.99951a1.0001 1.0001 0 0 0 .86719.5.99007.99007 0 0 0 .499-.13428l1.73145-1a.99974.99974 0 1 0-1-1.73144l-1.73145 1A.9993.9993 0 0 0 17.19629 8.99951zM6.80371 14.99951a.99936.99936 0 0 0-1.36621-.36572l-1.73145 1a.99974.99974 0 1 0 1 1.73144l1.73145-1A.9993.9993 0 0 0 6.80371 14.99951zM15 6.80371a1.0006 1.0006 0 0 0 1.36621-.36621l1-1.73193a1.00016 1.00016 0 1 0-1.73242-1l-1 1.73193A1 1 0 0 0 15 6.80371zM3.70605 8.36523l1.73145 1a.99007.99007 0 0 0 .499.13428.99977.99977 0 0 0 .501-1.86572l-1.73145-1a.99974.99974 0 1 0-1 1.73144zM9 17.1958a.99946.99946 0 0 0-1.36621.36621l-1 1.73194a1.00016 1.00016 0 0 0 1.73242 1l1-1.73194A1 1 0 0 0 9 17.1958zM20.294 15.63379l-1.73145-1a.99974.99974 0 1 0-1 1.73144l1.73145 1a.99.99 0 0 0 .499.13428.99977.99977 0 0 0 .501-1.86572zM16.36621 17.562a1.00016 1.00016 0 1 0-1.73242 1l1 1.73194a1.00016 1.00016 0 1 0 1.73242-1z"></path>
                   </svg>
                 </span>
               </div>
             </div>
             <div id="data-container"></div>

           </ul>
         </div>

       </div>
     </div>

   </div>


   <script>
     function show_subjects(k) {
       var endpoint = "<?php echo base_url('cbc/trs/get_subjects') ?>/" + k;
       var BASE_URL = "<?php echo base_url() ?>";
       $('#data-container').empty();
       $.ajax({
         url: endpoint,
         method: 'GET',
         dataType: 'json',
         success: function(data) {
           $.each(data.load, function(index, item) {
             $("#myloader").addClass("loader");
             $("#myload").show();

             $('#class_name').text(data.class);

             var link = BASE_URL + 'cbc/trs/do_summative/' + k + '/' + item.id;

             setTimeout(function() {
               $("#myloader").removeClass('loader');
               $("#myload").hide();
               $('#data-container').append(`<a href=${link} onclick="return confirm('Are you sure to do assessment?')"><li class="list-group-item d-flex justify-content-between align-items-center pe-2">
                                              <span class="d-inline-flex align-items-center">
                                                   <i class="fe fe-check text-primary me-2" aria-hidden="true"></i>${item.name}</span>
                              <div class="form-check form-switch</a>">
                                   
                              </div>
                          </li>`);
             }, 1000);


           });
         },
         error: function(xhr, status, error) {
           console.error('Error fetching data:', error);
         }
       });
     }
   </script>