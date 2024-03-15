<?php
$task_arr = [];
$top_arr = [];
?>
<div id="tasks" v-cloak>
    <div class="col-md-12 hidden-print">
        <div class="page-header row">
            <div class="col-md-11">
                <h4 class="text-uppercase black">STRAND: <?php echo $post->name; ?> </h4>
                <p> </p>
            </div>
            <div class="col-md-1">
                <a href="<?php echo base_url('admin/cbc/learning_areas/' . $post->subject); ?>" class="pull-right btn btn-primary"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
    <div class="card-box hidden-print">
        <h4 class="m-t-0 m-b-10 header-title text-center text-uppercase">Add Sub Strands</h4>
        <form class="form-horizontal form-main" role="form" action="<?php echo current_url(); ?>" method="POST">
            <div class="form-group" id="clone">
                <label class="col-sm-3 control-label">Name</label>
                <div class="col-sm-9 rows">
                    <input type="text" name="topic[]" class="form-control m-b-10" placeholder="Name">
                    <input type="text" name="topic[]" class="form-control m-b-10" placeholder="Name">
                </div>
                <div class="text-center"><a href="javascript:" id="adder" class="btn-link"><strong>+ Add New Row </strong></a></div>
            </div>
            <div class="form-group m-b-0">
                <div class="col-sm-offset-3 col-sm-9">
                    <a href="<?php echo base_url('admin/cbc/learning_areas/' . $post->subject) ?>" class="btn btn-default ">Go Back</a>
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-box">
        <div class="subby row">
            <div class="row">
                <div class="col-md-8">
                    <h4 class="subby-header">
                        <span>SUBJECT: <?php echo $subject->name; ?></span>
                    </h4>
                </div>
                <div class="col-md-4">
                    <div class=" pull-right">
                        <a href="javascript:" @click="expand()" class=" btn btn-white btn-dim btn-outline-light">
                            <i class="glyphicon glyphicon-cog"></i><span ref="excol">&nbsp; &nbsp; {{ sf? 'Hide Indicators': 'Show Indicators' }}</span>
                            <em class="glyphicon glyphicon-chevron-right"></em>
                        </a>
                        <a href="<?php echo current_url() ?>" class="btn btn-info ">Refresh Page</a>
                    </div>
                </div>
            </div>

            <div class="all-tasks-w">
                <div class="tasks-section">
                    <div class="tasks-header-w bg-e">
                        <h5 class="tasks-header text-uppercase">
                            <strong><?php echo $post->name; ?></strong>
                        </h5>
                    </div>
                    <div class="tasks-list-w">
                        <?php
                        $j = 0;


                        foreach ($post->topics as $s) {


                            $top_arr[$s->id] = $s->name;
                            $j++;
                        ?>
                            <div class="pb">
                                <div class="tl-header">
                                    <?php echo '1.' . $j . " &nbsp; &nbsp; &nbsp;" . $s->name; ?>
                                    <a class="pull-right prl btn-link" href="javascript:" @click="manage_tasks(<?php echo $s->id ?>)"><strong>+Add Indicators </strong></a>
                                </div>
                                <?php
                                if (count($s->tasks)) {
                                ?>
                                    <table class="table" v-if="sf">
                                        <tbody>
                                            <?php
                                            $ii = 0;
                                            foreach ($s->tasks as $t) {
                                                $task_arr[$t->id] = $t->name;
                                                $ii++;
                                            ?>
                                                <tr>
                                                    <td><?php echo $ii; ?>.</td>
                                                    <td width="70%"><?php echo $t->name; ?></td>
                                                    <td>
                                                        <div class="btn-group hidden-print">
                                                            <a class="btn btn-success btn-sm" @click="add_remarks('<?php echo $post->subject ?>','<?php echo $s->id ?>','<?php echo $t->id ?>')" href="javascript:"><span>Remarks</span></a>
                                                            <a class="btn btn-primary btn-sm" @click="show_task('<?php echo $t->id ?>')" href="javascript:"><span>Edit</span></a>
                                                            <a class="btn btn-danger btn-sm" href="<?php echo base_url('admin/cbc/remove_task/' . $t->id . "/" . $post->id); ?>" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')"><span>Delete</span></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!--Modal -->
            <div class="modal" :class="{ 'in': active}" :style="active? 'display: block': 'display: none'" role="dialog" tabindex="-1" :aria-hidden="active? 'false' : 'true' ">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header faded smaller">
                            <div class="modal-title">
                                <h4 class="subby-header">
                                    {{ topic }}
                                </h4>
                            </div>
                            <button aria-label="Close" class="close" @click='toggle_show()' type="button"><span aria-hidden="true"> ×</span></button>
                        </div>
                        <div class="modal-body card-box">
                            <h4 class="m-t-0 m-b-10 header-title">Add Tasks</h4>
                            <form class="form-horizontal form-main" role="form">
                                <div class="form-group" id="clone">
                                    <div class="col-sm-10 rows">
                                        <input type="text" v-for="(t, index) in tasks" v-model='t.name' class="form-control m-b-10" placeholder="Name">
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="text-center"><a href="javascript:" @click='add_item()' class="btn-link"><strong>+ Add New Row </strong></a></div>
                                </div>
                                <div class="form-group m-b-0">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="button" @click='save_tasks(topic_id)' class="btn btn-info">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer buttons-on-left">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" :class="{ 'in': edit}" :style="edit? 'display: block': 'display: none'" role="dialog" tabindex="-1" :aria-hidden="edit? 'false' : 'true' ">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header faded smaller">
                            <div class="modal-title">
                                <h4 class="subby-header">
                                    Edit Task
                                </h4>
                            </div>
                            <button aria-label="Close" class="close" @click='toggle_edit()' type="button"><span aria-hidden="true"> ×</span></button>
                        </div>
                        <div class="modal-body card-box">
                            <form class="form-horizontal form-main" role="form">
                                <div class="form-group" id="clone">
                                    <div class="col-sm-10 rows">
                                        <input type="text" v-model='item.name' class="form-control m-b-10" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group m-b-0">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="button" @click='edit_task(item)' class="btn btn-info">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>



            <!-- add remarks -->


        </div>
    </div>
    <div v-if="active==true || edit==true" class="modal-backdrop in"></div>
</div>


<div class="modal" id="add_remarks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="subby-header">
                    <span>SUBJECT: <?php echo $subject->name; ?></span>
                </h4>



                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Topic: <span id="topic_vl"></span><br>
                Task: <span id="task_val"></span><br>
                <?php echo form_open(base_url('admin/cbc/add_remarks'), ['id' => 'remarks_form']) ?>

                <input type="hidden" name="subject" id="sbj">
                <input type="hidden" name="topic" id="tpc">
                <input type="hidden" name="task" id="tsk">
                <input type="hidden" name="la" value="<?php echo $post->id ?>">
                <table class="table">
                    <tr>
                        <td>EE</td>
                        <td><textarea style="min-height: 89px;" name="ee_remarks" id="ee_val"></textarea></td>
                    </tr>

                    <tr>
                        <td>ME</td>
                        <td><textarea style="min-height: 89px;" name="me_remarks" id="me_val"></textarea></td>
                    </tr>

                    <tr>
                        <td>AE</td>
                        <td><textarea style="min-height: 89px;" name="ae_remarks" id="ae_val"></textarea></td>
                    </tr>

                    <tr>
                        <td>BE</td>
                        <td><textarea style="min-height: 89px;" name="be_remarks" id="be_val"></textarea></td>
                    </tr>
                </table>

                <hr>
                <div class="right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" type="submit">Save Remarks</button>
                </div>
                <?php echo form_close() ?>
            </div>
            <div class="modal-footer">


            </div>
        </div>
    </div>
</div>
<style>
    .btn-outline-light {
        color: #e5e9f2;
        border-color: #e5e9f2;
    }

    .btn .icon {
        font-size: 1.4em;
        line-height: inherit;
    }

    .btn>span {
        display: inline-block;
        white-space: nowrap;
    }

    .btn .icon+span,
    .btn span+.icon {
        padding-left: 8px;
    }

    .btn-dim.btn-outline-light {
        color: #526484;
        background-color: #f5f6fa;
        border-color: #dbdfea;
    }

    .btn-outline-light {
        border-color: #dbdfea;
        color: #526484;
    }

    .btn-white,
    .btn-white.btn-dim {
        background: #fff;
    }
</style>
<script>
    let tsk_arr = <?php echo json_encode($task_arr); ?>;
    let top_arr = <?php echo json_encode($top_arr); ?>;
    const tsk = new Vue({
        el: '#tasks',
        data: {
            active: false,
            show: false,
            topic: '',
            sf: true,
            post_error: '',
            topic_id: '',
            tasks: [{
                name: ''
            }],
            edit: false,
            item: {
                id: '',
                name: ''
            }
        },
        methods: {
            manage_tasks: function(id) {
                this.topic = top_arr[id];
                this.topic_id = id;
                this.toggle_show();
            },
            show_task: function(id) {
                this.item.id = id;
                this.item.name = tsk_arr[id];
                this.toggle_edit();
            },
            edit_task: function(task) {
                axios.post("<?php echo base_url('admin/cbc/update_task') ?>" + "/" + task.id, {
                        name: task.name
                    })
                    .then(function(response) {
                        notify('Success', "Updated Successfully");
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
                this.toggle_edit();
                setTimeout(() => (window.location.reload(true)), 10);
            },
            save_tasks: function(id) {
                this.post_error = '';
                if (this.isEmpty(this.tasks[0].name)) {
                    this.post_error = 'Tasks are empty';
                    return false;
                }
                axios.post("<?php echo base_url('admin/cbc/tasks') ?>" + "/" + id, {
                        tasks: this.tasks
                    })
                    .then(function(response) {
                        notify('Success', "Completed Successfully");
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
                this.tasks = [{
                    name: ''
                }];
                this.toggle_show();
                setTimeout(() => (window.location.reload(true)), 1000);
            },
            isEmpty: function(str) {
                return (!str || 0 === str.length);
            },
            add_item: function() {
                this.tasks.push({
                    name: ''
                });
            },
            remove_item: function(index) {
                this.tasks.splice(index, 1);
            },
            toggle_show: function() {
                this.active = !this.active;
                setTimeout(() => (this.show = !this.show), 10);
            },
            toggle_edit: function() {
                this.edit = !this.edit;
            },
            expand: function() {
                this.sf = !this.sf;
            }
        },
        filters: {
            format(x) {
                return x.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        }
    });


    function add_remarks(subject, topic, task) {
        $('#add_remarks').modal('toggle');

        var task_name = tsk_arr[task];
        var topic_name = top_arr[topic];

        $('#topic_vl').html(topic_name);
        $('#task_val').html(task_name);
        $('#sbj').val(subject);
        $('#tpc').val(topic);
        $('#tsk').val(task);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/cbc/get_remarks'); ?>",
            data: {
                'subject': subject,
                'topic': topic,
                'task': task
            },
            dataType: "json",
            success: function(response) {
                $('#ee_val').val(response.ee_remarks);
                $('#me_val').val(response.me_remarks);
                $('#ae_val').val(response.ae_remarks);
                $('#be_val').val(response.be_remarks);
            },
            error: function(error) {
                console.error("Error submitting form:", error);
            }
        });
    }

    $(document).ready(function() {
        $("#remarks_form").submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('admin/cbc/add_remarks'); ?>",
                data: formData,
                dataType: "json",
                success: function(response) {

                    if (response.status == 200) {
                        notify('Success', response.message);
                    } else {
                        notify('Error', response.message);
                    }

                    setTimeout(function() {
                        location.reload();
                    }, 1000);

                },
                error: function(error) {
                    console.error("Error submitting form:", error);
                }
            });
        });
    });
</script>
<style>
    a.btn-link {
        color: #047bf8 !important;
    }

    h3,
    .h3 {
        font-size: 21px;
    }

    .close {
        float: right;
        font-size: 30px;
        font-weight: 500;
        line-height: 1;
        color: #00008b;
    }

    .close:hover,
    .close:focus {
        color: #FFF;
        text-decoration: none;
    }

    button.close {
        padding: 1rem;
        margin-top: 0 !important;
        margin: -1rem -1rem -1rem auto;
        background-color: transparent;
        border: 0;
        -webkit-appearance: none;
        opacity: 1;
    }

    .modal {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1050;
        display: none;
        overflow: hidden;
        outline: 0;
    }

    .modal-dialog {
        position: relative;
        width: auto;
        margin: 0.5rem;
        pointer-events: none;
    }

    .modal.fade .modal-dialog {
        -webkit-transition: -webkit-transform 0.3s ease-out;
        transition: -webkit-transform 0.3s ease-out;
        transition: transform 0.3s ease-out;
        transition: transform 0.3s ease-out, -webkit-transform 0.3s ease-out;
        -webkit-transform: translate(0, -25%);
        transform: translate(0, -25%);
    }

    .modal-content {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        width: 100%;
        pointer-events: auto;
        background-color: #fff;
        background-clip: padding-box;
        border: 0px solid rgba(0, 0, 0, 0.2);
        border-radius: 6px;
        outline: 0;
    }

    .modal-header {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        padding: 8px;
        border-bottom: 0px solid #e9ecef;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
    }

    .modal-title {
        margin-bottom: 0;
        line-height: 1.5;
    }

    .modal-body {
        position: relative;
        -webkit-box-flex: 1;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 12px;
    }

    .modal-footer {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: end;
        -ms-flex-pack: end;
        justify-content: flex-end;
        padding: 10px;
        border-top: 0px solid #e9ecef;
    }

    .modal-footer> :not(:first-child) {
        margin-left: .25rem;
    }

    .modal-footer> :not(:last-child) {
        margin-right: .25rem;
    }

    @media (min-width: 576px) {
        .prl {
            margin-right: 25%;
        }

        .modal-dialog {
            max-width: 550px;
            margin: 1.75rem auto;
        }
    }

    .modal-content {
        -webkit-box-shadow: 0 25px 65px rgba(15, 24, 33, 0.29);
        box-shadow: 0 25px 65px rgba(15, 24, 33, 0.29);
    }

    .modal-footer.buttons-on-left {
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: flex-start;
    }

    .modal-header.faded {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .modal-header.smaller {
        font-size: 0.99rem;
    }

    .modal-header span,
    .modal-header strong,
    .modal-header .avatar {
        display: inline-block;
        vertical-align: middle;
    }

    .modal-header span {
        color: #999;
        margin-right: 5px;
    }

    .modal-header .avatar {
        border-radius: 50%;
        width: 40px;
        height: auto;
    }

    .modal-header .avatar+span {
        border-left: 1px solid rgba(0, 0, 0, 0.1);
        padding-left: 15px;
        margin-left: 15px;
    }

    .subby {
        background-color: #fff;
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
    }

    .subby-header {
        margin-bottom: 20px;
        color: #047bf8;
    }

    .subby-header i {
        margin-right: 10px;
        font-size: 22px;
        display: inline-block;
        vertical-align: middle;
    }

    .subby-header span {
        display: inline-block;
        vertical-align: middle;
    }

    .tl-header {
        font-size: 13px;
        font-weight: 600;
        margin-top: 12px;
    }

    .tasks-header-w {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        position: relative;
        margin-bottom: 10px;
    }

    .tasks-header-w .tasks-header {
        width: 100%;
        padding-left: 4px;
        display: inline-block;
        margin-bottom: 0px;
    }

    .tasks-list-w {
        padding-left: 24px;
    }

    @media (min-width: 768px) and (max-width: 1024px) {
        .subby {
            padding: 30px;
        }
    }

    @media (max-width: 768px) {
        .subby {
            padding: 30px;
        }

        .all-tasks-w {
            padding-left: 5px;
        }

        .tasks-header-w {
            padding-left: 20px;
        }

        .subby-header {
            font-size: 1.25rem;
        }

        .all-tasks-w {
            padding-top: 0px;
            padding-right: 0px;
        }
    }

    @media (max-width: 767px) {
        .subby {
            padding: 30px 20px;
        }

        .subby-header {
            font-size: 1.25rem;
        }

        .all-tasks-w {
            padding-top: 0px;
            padding-right: 0px;
        }
    }
</style>
<style>
    .mni {
        color: #555555b8;
    }

    .icosg-arrow-right4 {
        color: #ccc !important;
    }

    input.form-control {
        height: 36px !important;
    }

    label {
        font-size: 14px;
        color: #313a46;
        letter-spacing: 0.01em;
    }

    .form-controls {
        border: 1px solid #dadada;
        border-radius: 4px;
        padding: 7px 12px;
        height: 38px;
        max-width: 100%;
        font-size: 14px;
        -webkit-box-shadow: none;
        box-shadow: none;
        -webkit-transition: all 300ms linear;
        -moz-transition: all 300ms linear;
        -o-transition: all 300ms linear;
        transition: all 300ms linear;
    }

    .form-control:focus {
        border: 1px solid #afafaf;
        -webkit-box-shadow: none;
        box-shadow: none;
        outline: 0 !important;
    }

    .form-horizontal .form-group {
        margin-left: -10px;
        margin-right: -10px;
    }
</style>
<script>
    $('#adder').click(function() {
        var clone = $('#clone .rows input.form-control:first').clone();
        clone.val('');
        $('#clone .rows').append(clone);
    });
</script>