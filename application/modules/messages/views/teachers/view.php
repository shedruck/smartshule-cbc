<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="btn-group btn-group-sm card-header" role="group">
                <h6 class="float-start">Messages & Feedback</h6>
                <div class="btn-group btn-group-sm float-end" role="group">
                    <a class="btn btn-secondary" href="<?php echo base_url('messages/trs'); ?>"><i class="fa fa-caret-left"></i>  Back</a>
                    
                </div>

            </div>
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-md-7 col-lg-7 col-xl-7">
                        <div class="card">
                            <div class="card-header bg-default">
                                <h6>Parent Chat Bot - <?php echo $message->title ?></h6>
                            </div>
                            <div class="card-body">
                                <ul class="notification">
                                    <?php
                                    foreach ($message->items as $m) {
                                        // $iconclass = 'style="color:#F06292"';
                                        if ($m->from === 'Me') {
                                            $iconclass = 'border-info';
                                        } else {
                                            $iconclass = 'border-secondary';
                                        }
                                    ?>
                                        <li>
                                            <div class="notification-time">
                                                <span class="date"><?php echo $m->created_on > 10000 ? date('jS M Y', $m->created_on) : ' - '; ?></span>
                                                <span class="time"><?php echo $m->created_on > 10000 ? date('H:i', $m->created_on) : ' - '; ?></span>
                                            </div>
                                            <div class="notification-icon">
                                                <a href="javascript:void(0);" class="<?php echo $iconclass; ?>"></a>
                                            </div>
                                            <div class="notification-time-date mb-2 d-block d-md-none">
                                                <span class="date">Today</span>
                                                <span class="time ms-2">02:31</span>
                                            </div>
                                            <div class="notification-body">
                                                <div class="media mt-0">
                                                    <div class="main-avatar avatar-md online">
                                                        <img alt="avatar" class="rounded-circle" src="<?php echo base_url('assets/themes/teachers/images/users/1.jpg') ?>">
                                                    </div>
                                                    <div class="media-body ms-3 d-flex">
                                                        <div class="">
                                                            <p class="fs-15 text-dark fw-bold mb-0"><?php echo $m->from; ?></p>
                                                            <p class="mb-0 fs-13 text-dark"><?php echo $m->message; ?></p>
                                                        </div>
                                                        <div class="notify-time">
                                                            <p class="mb-0 text-muted fs-11">TO : <?php echo $m->to; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="card-footer">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-5 col-xl-5">
                        <?php
                        $attributes = array('class' => 'form-horizontal', 'id' => '');
                        echo form_open_multipart(current_url(), $attributes);
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <h6><?php echo $message->title ?></h6>
                            </div>
                            <div class="card-body">
                                <h6>Reply</h6>
                                <?php echo form_error('message'); ?>
                                <textarea name="message" class="editor form-control"><?php echo set_value((isset($result->message)) ? htmlspecialchars_decode($result->message) : ''); ?></textarea>
                            </div>
                            <div class="card-footer">
                                <div class="form-check d-inline-block">

                                </div>
                                <div class="float-end d-inline-block btn-list">
                                    <button class="btn btn-primary btn-small" type="submit"><i class=" mdi mdi-send"></i> Send Reply</button>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
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