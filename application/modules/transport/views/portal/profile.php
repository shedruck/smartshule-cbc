   <div class="page-title-container mb-3">
       <div class="row">
           <div class="col mb-2">
               <h1 class="mb-2 pb-0 display-4" id="title"><?php echo $this->school->school; ?> TRANSPORT</h1>
               <div class="text-muted font-heading text-small">Check in & Checkout students in transport.</div>
           </div>

           <div class="col-12 col-sm-auto justify-content-end">
               <button type="button" class="btn btn-quaternary w-md-auto" @click="show(1)"> Check in</button>
               <button type="button" class="btn btn-tertiary w-md-auto dropdown-toggle" @click="show(2)">
                   Check out
               </button> &nbsp;
           </div>
       </div>
   </div>


   <div class="row g-2">
       <div class="col-12 col-md-6 h-100">
           <h2 class="small-title">Term <?php echo $this->school->term; ?> <?php echo $this->school->year; ?></h2>
           <div class="card hover-scale-up cursor-pointer mb-1">
               <div class="h-100 row g-0 p-4 align-items-center">
                   <div class="col-auto">
                       <div class="bg-gradient-2 sw-5 sh-5 rounded-xl d-flex justify-content-center align-items-center">
                           <em class="icon ni ni-map-pin text-white"></em>
                       </div>
                   </div>
                   <div class="col">
                       <div class="p mb-0 sh-5 d-flex align-items-center lh-1-25 ps-3">Assigned Routes</div>
                   </div>
                   <div class="col-auto ps-3">
                       <div class="cta-2 text-primary"><?php echo number_format($total_r); ?></div>
                   </div>
               </div>
           </div>
           <div class="card hover-scale-up cursor-pointer mb-1">
               <div class="h-100 row g-0 p-4 align-items-center">
                   <div class="col-auto">
                       <div class="bg-gradient-2 sw-5 sh-5 rounded-xl d-flex justify-content-center align-items-center">
                           <em class="icon ni ni-users-fill text-white"></em>
                       </div>
                   </div>
                   <div class="col">
                       <div class="p mb-0 sh-5 d-flex align-items-center lh-1-25 ps-3">Total Assigned Students</div>
                   </div>
                   <div class="col-auto ps-3">
                       <div class="cta-2 text-primary"><?php echo number_format($total_s); ?></div>
                   </div>
               </div>
           </div>
           <div class="col-12 mt-3 h-100">
               <h2 class="small-title">My Routes</h2>
               <div class="scroll-out h-100">
                   <div class="scroll-by-count" data-count="4">
                       <?php
                        $i = 0;
                        foreach ($assigned as $ky => $v) {
                            $i++;
                        ?>
                           <div class="card mb-1 hover-border-primary ">
                               <div class="row g-0 sh-9 pt-0 pb-0">
                                   <div class="col-2 d-flex align-items-center justify-content-center">
                                       <div class="p-1">
                                           <?php echo $i; ?>.
                                       </div>
                                   </div>
                                   <div class="col-10 d-flex flex-column justify-content-center">
                                       <p class="heading mb-0"><?php echo $ky; ?></p>
                                       <p class="text-small text-muted mb-0"><?php echo number_format($v); ?> students.</p>
                                   </div>
                               </div>
                           </div>
                       <?php } ?>
                   </div>
               </div>
           </div>
       </div>
   </div>