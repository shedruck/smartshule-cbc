<div class="col-md-12">
    <div class="block-fluid card">
        <h2>Quickbooks Status - Pending Items</h2>
        <div class="col-md-5">
            <div class="d-flex flex-column h-100 text-center">
                <div class="row h-100">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h2 class="mt-4 ff-secondary fw-semibold"><span><?php echo number_format($qb->students); ?></span></h2>
                                            <p class="mb-0 text-muted">
                                                Students</p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-primary rounded-circle fs-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"><?php echo number_format($qb->invoices); ?></span></h2>
                                            <p class="mb-0 text-muted">Invoices</p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-danger rounded-circle fs-2">
                                                    <i class="icos-folder"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"><?php echo number_format($qb->paid); ?></span> </h2>
                                            <p class="mb-0 text-muted">Payments</p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-warning rounded-circle fs-2">
                                                    <i class="icos-share"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" ><?php echo number_format($qb->extras); ?></span></h2>
                                            <p class="mb-0 text-muted"> Fee Extras</p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success rounded-circle fs-2">
                                                    <i class="icos-newspaper"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="mt-4 mb-0">Reversals/Modified - Pending</p><hr class="m-0">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="a-data"><div class="title">Tuition Fee</div>
                                                <div class="fw-semibold text-danger"><?php echo number_format($reverse->invoices); ?></div>
                                            </div>
                                            <div class="a-data"><div class="title">Extras</div>
                                                <div class="fw-semibold text-danger"><?php echo number_format($reverse->extras); ?></div>                                                    
                                            </div>
                                            <div class="a-data">
                                                <div class="title">Payments</div> <div class="fw-semibold text-danger"><?php echo number_format($reverse->pay); ?></div>                                                    
                                            </div>
                                            <div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-warning rounded-circle fs-2">
                                                        <i class="icos-file"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    svg{-ms-touch-action:none;touch-action:none;}
    h2{margin-top:0;margin-bottom:.5rem;font-weight:500;line-height:1.2;}
    h2{font-size:calc(1.2875rem + .45vw);}
    @media (min-width:1200px){
        h2{font-size:1.625rem;}
    }
    img,svg{vertical-align:middle;}
    ::-moz-focus-inner{padding:0;border-style:none;}
    .img-fluid{max-width:100%;height:auto;}
    .col-12{-webkit-box-flex:0;-ms-flex:0 0 auto;flex:0 0 auto;width:100%;}
    .card-body{-webkit-box-flex:1;-ms-flex:1 1 auto;flex:1 1 auto;padding:1rem 1rem;}
    .badge{display:inline-block;padding:.35em .65em;font-size:.75em;font-weight:600;line-height:1;color:#fff;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25rem;}
    .badge:empty{display:none;}
    .alert{position:relative;padding:.8rem 1rem;margin-bottom:1rem;border:1px solid transparent;border-radius:.25rem;}
    .alert-warning{color:#bf8f08;background-color:#fff5da;border-color:#ffecb6;}
    .text-truncate{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
    .align-middle{vertical-align:middle!important;}
    .d-flex{display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important;}
    .border-0{border:0!important;}
    .h-100{height:100%!important;}
    .flex-column{-webkit-box-orient:vertical!important;-webkit-box-direction:normal!important;-ms-flex-direction:column!important;flex-direction:column!important;}
    .flex-shrink-0{-ms-flex-negative:0!important;flex-shrink:0!important;}
    .justify-content-between{-webkit-box-pack:justify!important;-ms-flex-pack:justify!important;justify-content:space-between!important;}
    .align-items-end{-webkit-box-align:end!important;-ms-flex-align:end!important;align-items:flex-end!important;}
    .align-items-center{-webkit-box-align:center!important;-ms-flex-align:center!important;align-items:center!important;}
    .m-0{margin:0!important;}
    .mt-3{margin-top:1rem!important;}
    .mt-4{margin-top:1.5rem!important;}
    .me-2{margin-right:.5rem!important;}
    .mb-0{margin-bottom:0!important;}
    .p-0{padding:0!important;}
    .p-3{padding:1rem!important;}
    .px-3{padding-right:1rem!important;padding-left:1rem!important;}
    .fs-2{font-size:calc(1.2875rem + .45vw)!important;}
    .lh-base{line-height:1.5!important;}
    .text-decoration-underline{text-decoration:underline!important;}
    .rounded-0{border-radius:0!important;}
    .rounded-circle{border-radius:50%!important;}
    .waves-effect{position:relative;cursor:pointer;display:inline-block;overflow:hidden;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;-webkit-tap-highlight-color:transparent;}
    .avatar-sm{height:3rem;width:3rem;}
    .avatar-title{-webkit-box-align:center;-ms-flex-align:center;align-items:center;background-color:#4b38b3;color:#fff;display:-webkit-box;display:-ms-flexbox;display:flex;font-weight:500;height:100%;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;width:100%;}
    .fs-16{font-size:16px!important;}
    .ff-secondary{font-family:Inter,sans-serif;}
    .fw-medium{font-weight:500;}
    .fw-semibold{font-weight:600!important;}
    .icon-sm{height:18px;width:18px;}
    @media print{
        .card-body{padding:0;margin:0;}
        .card{border:0;}
    }
    b{font-weight:600;}
    .row>*{position:relative;}
    .card{margin-bottom:1.5rem;-webkit-box-shadow:0 5px 10px rgba(30,32,37,.12);box-shadow:0 5px 10px rgba(30,32,37,.12);}
    .card-animate{-webkit-transition:all .4s;transition:all .4s;}
    .card-animate:hover{-webkit-transform:translateY(calc(-1.5rem / 5));transform:translateY(calc(-1.5rem / 5));-webkit-box-shadow:0 5px 10px rgba(30,32,37,.12);box-shadow:0 5px 10px rgba(30,32,37,.12);}
</style>