<div class="col-md-12">
    <div class="panel panel-primary" >
        <div class="panel-heading">   
            Counties  
            <span class="tools pull-right">
                <a class="fa fa-chevron-down" href="javascript:;"></a>
            </span>
        </div>

        <div class="panel-body" >  

            <div class="bs-example pull-right">
                <?php echo anchor('admin/counties/', '<i class="fa fa-list"></i> List All', 'class="btn btn-info btn-icon icon-left"'); ?> 
            </div> 

            <div class="col-sm-12">
                <section class="panel">
                    <div class="panel-body invoice">
                        <div class="invoice-header">
                            <div class="invoice-title col-md-5 col-xs-12">
                                <h1>View </h1>
                            </div>
                            <div class="invoice-info col-md-7 col-xs-12">
                                <div class="col-md-6 col-sm-3">
                                    <p>124 King Street, Nairobi <br>
                                        Victoria 2324  </p>
                                </div>
                                <div class="col-md-6 col-sm-3">
                                    <p>Phone: +61 3 8376 6284 <br>
                                        Email : info@admin.com</p>
                                </div>
                            </div>
                        </div>
                        <div class="row invoice-to">
                            <div class="col-md-4 col-sm-4">
                                <h4>Details:</h4>
                                <p>
                                    You are now Viewing the Selected Item
                                </p>
                            </div>
                            <div class="col-md-8 col-sm-5 pull-right">
                                <?php
                                if (isset($result) && !empty($result))
                                {
                                    foreach ($result as $r => $v)
                                    {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-5 inv-label"><?php echo humanize($r); ?></div>
                                            <div class="col-md-8 col-sm-7"><?php echo $v; ?></div>
                                        </div>
                                        <br>
                                        <?php
                                    }
                                }
                                ?>

                                <div class="row">
                                    <div class="col-md-12 inv-label">
                                        <h3>######</h3>
                                    </div>

                                </div>


                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
</div>