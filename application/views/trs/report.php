<?php $avt = strtolower(substr($this->user->first_name, 0, 1)); ?>
<div class="row">
    <div class=" col-md-4">
        <div class="text-center card-box">
            <div class="member-card">
                <div class="thumb-xl member-thumb m-b-10 center-block">
                    <img src="<?php echo base_url('assets/themes/default/img/avatar/' . $avt . '/150.png'); ?>" class="img-circle img-thumbnail" alt="profile-image">
                    <i class="mdi mdi-star-circle member-star text-success"></i>
                </div>
                <div>
                    <h4 class="m-b-5"><?php echo $this->user->first_name . ' ' . $this->user->last_name ?></h4>
                    <p class="text-muted">Teacher</p>
                </div>

                <button type="button" class="btn btn-success btn-sm w-sm waves-effect m-t-10 waves-light">Change Password</button>
                <p class="text-muted font-13 m-t-20"> </p>
                <hr>
                <div class="text-left">
                    <p class="text-muted font-13"><strong>Mobile :</strong><span class="m-l-15">(123) 123 1234</span></p>
                    <p class="text-muted font-13"><strong>Email :</strong> <span class="m-l-15">ss@gmail.com</span></p>
                    <p class="text-muted font-13"><strong>Last Login :</strong> <span class="m-l-15">USA</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card-bsox">
            <h4 class="header-title m-t-0 m-b-20">Recent Payslips</h4>

            <table class="table table-centered m-b-0">
                <thead>
                    <tr>
                        <th> #</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>
                            <p class="font-13 m-b-0">Date Processed</p>
                        </th>
                        <th class="text-center" width="20%"> Option  </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> <a class="user" href="#">   1 </a>  </td>
                        <td>  August</td>
                        <td>2017</td>
                        <td class="hide-phone">
                            <p class="font-13 m-b-0">  16/09/2016 10:45</p>
                        </td> 
                        <td class="text-center"><button class="btn btn-primary waves-effect waves-light m-b-5"> <i class="mdi mdi-account-search m-r-5"></i> View</button>
                        </td>
                    </tr>
                    <tr>
                        <td> <a class="user" href="#"> 2 </a>  </td>
                        <td>  July</td>
                        <td>2017</td>
                        <td class="hide-phone">
                            <p class="font-13 m-b-0">  16/09/2016 10:45</p>
                        </td> 
                        <td class="text-center"><button class="btn btn-primary waves-effect waves-light m-b-5"> <i class="mdi mdi-account-search m-r-5"></i> View</button>
                        </td>
                    </tr>
                    <tr>
                        <td> <a class="user" href="#"> 2 </a>  </td>
                        <td>  June</td>
                        <td>2017</td>
                        <td class="hide-phone">
                            <p class="font-13 m-b-0">  16/09/2016 10:45</p>
                        </td> 
                        <td class="text-center"><button class="btn btn-primary waves-effect waves-light m-b-5"> <i class="mdi mdi-account-search m-r-5"></i> View</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>