<?php $avt = strtolower(substr($this->user->first_name, 0, 1)); ?>
<div class="row">
    <div class=" col-md-4">
        <div class="text-center card-box">
            <div class="member-card">
                <div class="thumb-xl member-thumb m-b-10 center-block">
                    <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" alt="user-img" width="150"  class="img-circle">
                    <i class="mdi mdi-star-circle member-star text-success"></i>
					
                </div>

                <div class=""><br>
					<br>
                    <h4 class="m-b-5"><?php echo $this->user->first_name . ' ' . $this->user->last_name ?></h4>
                    <p class="text-muted">Teacher</p>
                </div>

                <a href="<?php echo base_url('trs/change_password'); ?>" class="btn btn-success btn-sm w-sm waves-effect m-t-10 waves-light">Change Password</a>
                <p class="text-muted font-13 m-t-20"> </p>
                <hr>

                <div class="text-left">
                    <p class="text-muted font-13"><strong>Mobile :</strong><span class="m-l-15"><?php echo $this->user->phone; ?></span></p>
                    <p class="text-muted font-13"><strong>Email :</strong> <span class="m-l-15"><?php echo $this->user->email; ?></span></p>
                    <p class="text-muted font-13"><strong>Joined :</strong> <span class="m-l-15"><?php echo $this->user->created_on > 10000 ? date('d M Y', $this->user->created_on) : ' - '; ?></span></p>
                </div>
            </div>

        </div> <!-- end card-box -->

    </div> <!-- end col -->

    <div class="col-md-8">
        <div class="card-bsox">
            <h4 class="header-title m-t-0 m-b-20">Recent Payslips</h4>
            <table class="table table-centered m-b-0">
                <thead>
                    <tr>
                        <th> #</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Bank</th>
                        <th>
                            <p class="font-13 m-b-0">Date Processed</p>
                        </th>
                        <th class="text-center" width="20%"> Option  </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($slips))
                    {
                            ?>
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <strong>No record found
                                    </div>
                                </td>

                            </tr>                            
                            <?php
                    }
                    else
                    {
                            $i = 0;
                            foreach ($slips as $p)
                            {
                                    $i++;
                                    $u = $this->ion_auth->get_user($p->employee);
                                    ?>
                                    <tr class="">
                                        <td><?php echo $i ?>.   </td>
                                        <td>  <?php echo $p->month ?></td>
                                        <td><?php echo $p->year ?></td>
                                        <td><?php echo $p->bank_details ?></td>
                                        <td class="hide-phone">
                                            <p class="font-13 m-b-0"> <?php echo date('jS M, Y', $p->salary_date); ?></p>
                                        </td> 
                                        <td class="text-center"><a href="<?php echo base_url('trs/slip/' . $p->id) ?>" class="btn btn-primary waves-effect waves-light m-b-5"> <i class="mdi mdi-account-search m-r-5"></i> View</a>
                                        </td>
                                    </tr>
                            <?php }
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>