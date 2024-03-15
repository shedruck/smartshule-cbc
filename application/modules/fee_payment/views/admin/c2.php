<?php
$range = range(date('Y') - 5, date('Y') + 2);
$yrs = array_combine($range, $range);
krsort($yrs);
$settings = $this->ion_auth->settings();
$students = $this->ion_auth->students_full_details();

$roster = [];
foreach ($students as $k => $s)
{
    $roster[] = ['id' => $k, 'name' => $s];
}
$t1 = '';
$t2 = 'active';
$t3 = ''; //'active';
if ($this->input->post())
{
    $t1 = '';
    $t2 = '';
    $t3 = 'active';
}
?>
<div class="col-md-12">
    <div class="widget">
          <div class="block-fluid tabbable">
            <ul class="nav nav-tabs">
                <li class="hidden <?php echo $t1; ?>"><a href="#tab1" data-toggle="tab"><i class="glyphicon glyphicon-file"></i> Payments from Bank - KCB</a></li>
                <li class="<?php echo $t2; ?>"><a href="#tab2" data-toggle="tab"><i class="glyphicon glyphicon-file"></i> M-Pesa Payments</a></li>
                <li class="<?php echo $t3; ?>"><a href="#tab3" data-toggle="tab"><i class="glyphicon glyphicon-plus"></i> New Payment</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane <?php echo $t1; ?>" id="tab1" v-cloak>
                    <div class="card">                     
                        <h4>BANK PAYMENTS</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <div id="tabs">
                                    <ul class="tabs__nav m-1 ml-2">
                                        <li :class="tab==1 ? 'active' : ' ' " @click='showTab(1)'>
                                            <div class="tabs__nav--name">Processed</div>
                                        </li>
                                        <li :class="tab==0 ? 'active' : ' ' " @click='showTab(0)'>
                                            <div class="tabs__nav--name">Pending</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3 st-t">
                                <h5>Processed Today</h5>
                                <h2 class="text-primary"><a class="success" href="#">{{ total }}</a></h2>
                            </div>
                            <div class="col-md-2">
                                <div class="pull-right">
                                    <img :src="loaderPath()" alt="user" v-if='loading' class="avatar-img rounded-circle" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control m-b-1" placeholder="Search" v-model="filters.search" @input="searchPaid"/>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th width="13%">Date</th>
                                        <th>Method</th>
                                        <th>Tx. No.</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Bank Ref.</th>
                                        <th width="10%"> &nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(p, index) in paid">
                                        <td>{{(index+1)+offset}}.</td>
                                        <td :title="p.ago">{{ p.date }}</td>
                                        <td>
                                            <p class="mb-2 p-0"> {{ p.method }} </p>
                                            <span class="border-top pt-2" v-if="tab ==3"><small>{{ p.txid }}</small></span>
                                        </td>
                                        <td>
                                            <span class="label label-primary sw" v-on:click="show(p.id, 1)" v-if="tab==1">{{ p.tx_no }}</span>
                                            <span v-if="tab ==0"> {{ p.tx_no }}</span>
                                        </td>
                                        <td><strong>{{ p.amount }}</strong></td>
                                        <td>
                                            <p>{{ p.description }}</p>
                                            <p class="label label-primary m-0" v-if="tab==1">{{ p.assigned }}</p>
                                        </td>
                                        <td v-if="tab !=3">
                                            <span> {{ p.bank_ref }}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary icon-right btn-sm" v-on:click="show(p.id, 0)" v-if="tab==0">
                                                View
                                                <i class="ft-chevron-right "></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <paginate
                                    :page-count="pcount"
                                    :container-class="'pagination pagination-sm' "
                                    :page-class="'page-item' "
                                    :prev-class="'page-item' "
                                    :next-class="'page-item'"
                                    :page-link-class="'page-link'"
                                    :prev-link-class="'page-link'" 
                                    :next-link-class="'page-link'"                                       
                                    :click-handler="getPaid">
                                </paginate>
                            </div>
                            <div class="col-md-4">
                                <div class="float-right" v-if="count"> per page
                                    <select name="per_page" class="form-control" v-model="filters.per_page" @change="getPaid" >
                                        <option v-for="option in options" v-bind:value="option.value">
                                            {{ option.text }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Modal -->
                    <div class="modal subby" 
                         :class="{ 'in': modalOpen}"
                         :style="modalOpen? 'display: block': 'display: none'"
                         role="dialog"
                         tabindex="-1" 
                         :aria-hidden="modalOpen? 'false' : 'true' "
                         >
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header faded smaller">
                                    <div class="modal-title">
                                        <h4 class="subby-headerd"> View Transaction: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ payment.description }}</h4>
                                    </div>
                                    <button aria-label="Close" class="close" @click='toggle_show()' type="button"><span aria-hidden="true"> ×</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h6><small>Date</small></h6>
                                            <h4 class="text-primary"> {{ payment.date }} </h4>
                                        </div>
                                        <div class="col-sm-4">
                                            <h6><small>Method</small></h6>
                                            <h4 class="text-primary">{{ payment.method }} {{ payment.tx_no }}</h4>
                                        </div>
                                        <div class="col-sm-4">
                                            <h6><small>Amount </small></h6>
                                            <h4 class="text-primary">{{ payment.amount }}</h4>
                                        </div>
                                    </div>
                                    <hr class="m-0">
                                    <div class="card">
                                        <form class="form mt-5" v-if='tab==0'>
                                            <h4>Assign Payment to Student  
                                                <span class="pull-right">
                                                    <button class="btn-primary btn btn-sm" type="button"@click="add_item(1)">Add Uniform</button>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <button class="btn-primary btn btn-sm" type="button"@click="add_item(0)">Add Row</button>
                                                </span>
                                            </h4>
                                            <table class="table m-0 mxl">
                                                <thead>
                                                    <tr>
                                                        <th width='6%'>#</th>
                                                        <th width='30%'>Student</th>
                                                        <th width='8%'>Amount</th>
                                                        <th width='13%'>Term</th>
                                                        <th width='14%'>Year</th>
                                                        <th width='37%'>&nbsp;</th>
                                                        <th width='4%'></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, index) in items">
                                                        <td>{{index+1 }}.</td>
                                                        <td><multiselect v-model="item.student" :options="students" label="name" placeholder="-- Select Student --"></multiselect></td>
                                                <td><input type="number" v-model="item.amount" oninput="validity.valid||(value='');" min="0" placeholder="Amount"></td>
                                                <td><multiselect v-model="item.term" :options="terms" label="text" placeholder="-- Term --"></multiselect></td>
                                                <td><multiselect v-model="item.year" :options="years" label="name" placeholder="Year"></multiselect></td>
                                                <td><multiselect v-model="item.fee" :options="uniform" label="name" placeholder="-- Select --" v-if='item.uf'></multiselect></td>
                                                <td><button type="button" class="btn-floating btn-danger" @click="remove_item(index)">X</button></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <div class="form-actions text-center">
                                                <hr>
                                                <div v-if='ask==false'>
                                                    <button type="button" class="btn btn-warning mr-1" @click.prevent="close">
                                                        <i class="ft-x"></i> Cancel
                                                    </button>
                                                    <button type="button" class="btn btn-primary" :disabled='!items.length' @click.prevent="confirm(true)">
                                                        <i class="ft-check"></i> Submit
                                                    </button>
                                                </div>

                                                <div class="form-actions text-center" v-if='ask==true'>
                                                    <div class="iziToast iziToast-theme-light iziToast-color-yellow iziToast-animateInside iziToast-opened" id="questionq" style="padding-right: 18px;">
                                                        <div class="iziToast-body" style="padding-left: 33px;">
                                                            <i class="iziToast-icon ico-question slideIn"></i>
                                                            <div class="iziToast-texts" style="margin-right: 10px;">
                                                                <strong class="iziToast-title slideIn" style="margin-right: 10px;">Are you sure?</strong>
                                                                <p class="iziToast-message slideIn" style="margin-bottom: 0px;"></p>
                                                            </div>

                                                            <div class="iziToast-buttons">
                                                                <button type="button" class="btn btn-default" @click.prevent="confirm(false)"><b><i class="ft-x"></i> No. Cancel</b></button>
                                                                <button type="button" class="btn btn-success" @click.prevent="post"><b><i class="ft-check"></i> Yes</b></button>
                                                            </div>
                                                        </div>
                                                        <div class="iziToast-progressbar"><div></div></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div v-if="modalOpen || showPay" class="modal-backdrop in"></div>
                </div>
                <div class="tab-pane <?php echo $t2; ?>" id="tab2" v-cloak>
                    <div class="card">
                        <br>
                        <div class="row">
                            <div class="col-md-4 st-t">
                                <h5>Total (Today)</h5>
                                <h2 class="text-primary">{{ totals.total }}</h2>
                            </div>
                            <div class="col-md-4 st-t">
                                <h5>Processed</h5>
                                <h2 class="text-success">{{ totals.seen }}</h2>
                            </div>
                            <div class="col-md-4 st-t">
                                <h5>Pending</h5>
                                <h2 class="text-danger">{{ totals.missing }}</h2>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div id="tabs">
                                    <ul class="tabs__nav m-1 ml-2">
                                        <li :class="tab==1 ? 'active' : ' ' " @click='showTab(1)'>
                                            <div class="tabs__nav--name">Processed</div>
                                        </li>
                                        <li :class="tab==0 ? 'active' : ' ' " @click='showTab(0)'>
                                            <div class="tabs__nav--name">Pending</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3 st-t">
                            </div>
                            <div class="col-md-2">
                                <div class="pull-right">
                                    <img :src="loaderPath()" alt="user" v-if='loading' class="avatar-img rounded-circle" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control m-b-1" placeholder="Search" v-model="filters.search" @input="searchPaid"/>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th width="13%">Date</th>
                                        <th>Tx. No.</th>
                                        <th>Amount</th>
                                        <th>Adm. No</th>
                                        <th>Paid by</th>
                                        <th>Phone</th>
                                        <th width="10%"> &nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(p, index) in paid">
                                        <td>{{(index+1)+offset}}.</td>
                                        <td :title="p.ago">{{ p.date }}</td>
                                        <td>
                                            <span class="label label-primary sw" v-on:click="show(p.id, 1)" v-if="tab==1">{{ p.txid }}</span>
                                            <span v-if="tab ==0"> {{ p.txid }}</span>
                                        </td>
                                        <td><strong>{{ p.amount }}</strong></td>
                                        <td>
                                            <p>{{ p.reg_no }}</p>
                                            <p class="label label-primary m-0" v-if="tab==1">{{ p.assigned }}</p>
                                        </td>
                                        <td>
                                            <span> {{ p.first_name }} {{ p.middle_name }} {{ p.last_name }}</span>
                                        </td>
                                        <td>
                                            <span> {{ p.phone }} </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary icon-right btn-sm" v-on:click="show(p.id, 0)" v-if="tab==0">
                                                View
                                                <i class="ft-chevron-right "></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <paginate
                                    :page-count="pcount"
                                    :container-class="'pagination pagination-sm' "
                                    :page-class="'page-item' "
                                    :prev-class="'page-item' "
                                    :next-class="'page-item'"
                                    :page-link-class="'page-link'"
                                    :prev-link-class="'page-link'" 
                                    :next-link-class="'page-link'"                                       
                                    :click-handler="getPaid">
                                </paginate>
                            </div>
                            <div class="col-md-4">
                                <div class="float-right" v-if="count"> per page
                                    <select name="per_page" class="form-control" v-model="filters.per_page" @change="getPaid" >
                                        <option v-for="option in options" v-bind:value="option.value">
                                            {{ option.text }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Modal -->
                    <div class="modal subby spl" 
                         :class="{ 'in': modalOpen}"
                         :style="modalOpen? 'display: block': 'display: none'"
                         role="dialog"
                         tabindex="-1" 
                         :aria-hidden="modalOpen? 'false' : 'true' "
                         >
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header faded smaller">
                                    <div class="modal-title">
                                        <h4 class="subby-header"> View Transaction &nbsp;&nbsp;&nbsp;&nbsp; Paid By: {{ payment.first_name }} {{ payment.middle_name }} {{ payment.last_name }}</h4>
                                    </div>
                                    <button aria-label="Close" class="close" @click='toggle_show()' type="button"><span aria-hidden="true"> ×</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img :src="loaderPath()" alt="user" v-if='loading' class="avatar-img rounded-circle" />
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h6><small>Date</small></h6>
                                            <h4 class="text-primary"> {{ payment.date }} </h4>
                                        </div>
                                        <div class="col-sm-6">
                                            <h6><small>Adm. No.</small></h6>
                                            <h4 class="text-primary">{{ payment.reg_no }}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h6><small>Amount </small></h6>
                                            <h4 class="text-primary">{{ payment.amount }}</h4>
                                        </div>
                                        <div class="col-sm-6">
                                            <h6><small>Transaction No.</small></h6>
                                            <h4 class="text-primary">{{ payment.txid }}</h4>
                                        </div>
                                    </div>
                                    <hr class="m-0">

                                    <div class="card" v-if="tab==1 && payment.receipt" >
                                        <div class="card-content">
                                            <div class="row rounded">
                                                <div class="col-md-7">
                                                    <small>Payment assigned to: </small>
                                                    <h4 class="text-white text-uppercase">{{ payment.receipt.student }}</h4> <span>ADM NO. {{ payment.receipt.adm }}</span>
                                                </div>
                                                <div class="col-md-5 border-left" style="padding-left: 12px;">
                                                    <h4 class="text-white pt-20">AMOUNT: {{ payment.receipt.total }} </h4>
                                                    <button type="button" class="btn btn-danger btn-sm hidden" v-if='ask==false' @click="confirm(true)">
                                                        <i class="ft-x"></i>
                                                        Void Payment
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="form-actions text-center" v-if='ask==true'>
                                                <div class="iziToast iziToast-theme-light iziToast-color-yellow iziToast-animateInside iziToast-opened" id="question" style="padding-right: 18px;">
                                                    <div class="iziToast-body" style="padding-left: 33px;">
                                                        <i class="iziToast-icon ico-question slideIn"></i>
                                                        <div class="iziToast-texts" style="margin-right: 10px;">
                                                            <strong class="iziToast-title slideIn" style="margin-right: 10px;">Are you sure?</strong>
                                                            <p class="iziToast-message slideIn" style="margin-bottom: 0px;"></p>
                                                        </div>

                                                        <div class="iziToast-buttons">
                                                            <button type="button" class="btn btn-default" @click.prevent="confirm(false)"><b><i class="ft-x"></i> No. Cancel</b></button>
                                                            <button type="button" class="btn btn-success" @click.prevent="void_fee(payment.receipt)"><b><i class="ft-check"></i> Yes</b></button>
                                                        </div>
                                                    </div>
                                                    <div class="iziToast-progressbar"><div></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <form class="form mt-5" v-if='tab==0'>
                                            <h4>Assign Payment to Student  <span class="pull-right"><button type="button"@click="add_item">Add Student</button></span> </h4>
                                            <table class="table m-0 mxl">
                                                <thead>
                                                    <tr>
                                                        <th width='6%'>#</th>
                                                        <th width='40%'>Student</th>
                                                        <th width='12%'>Amount</th>
                                                        <th width='18%'>Term</th>
                                                        <th width='20%'>Year</th>
                                                        <th width='4%'></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, index) in items">
                                                        <td>{{index+1 }}.</td>
                                                        <td><multiselect v-model="item.student" :options="students" label="name" placeholder="-- Select Student --"></multiselect></td>
                                                <td><input type="number" v-model="item.amount" oninput="validity.valid||(value='');" min="0" placeholder="Amount"></td>
                                                <td><multiselect v-model="item.term" :options="terms" label="text" placeholder="-- Term --"></multiselect></td>
                                                <td><multiselect v-model="item.year" :options="years" label="name" placeholder="-- Year --"></multiselect></td>
                                                <td><button type="button" class="btn-floating btn-danger" v-if='index>0' @click="remove_item(index)">X</button></td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <div class="form-actions text-center">
                                                <hr>
                                                <div v-if='ask==false'>
                                                    <button type="button" class="btn btn-warning mr-1" @click.prevent="close">
                                                        <i class="ft-x"></i> Cancel
                                                    </button>
                                                    <button type="button" class="btn btn-primary" :disabled='!items.length' @click.prevent="confirm(true)">
                                                        <i class="ft-check"></i> Submit
                                                    </button>
                                                </div>

                                                <div class="form-actions text-center" v-if='ask==true'>
                                                    <div class="iziToast iziToast-theme-light iziToast-color-yellow iziToast-animateInside iziToast-opened" id="questionx" style="padding-right: 18px;">
                                                        <div class="iziToast-body" style="padding-left: 33px;">
                                                            <i class="iziToast-icon ico-question slideIn"></i>
                                                            <div class="iziToast-texts" style="margin-right: 10px;">
                                                                <strong class="iziToast-title slideIn" style="margin-right: 10px;">Are you sure?</strong>
                                                                <p class="iziToast-message slideIn" style="margin-bottom: 0px;"></p>
                                                            </div>

                                                            <div class="iziToast-buttons">
                                                                <button type="button" class="btn btn-default" @click.prevent="confirm(false)"><b><i class="ft-x"></i> No. Cancel</b></button>
                                                                <button type="button" class="btn btn-success" @click.prevent="post"><b><i class="ft-check"></i> Yes</b></button>
                                                            </div>
                                                        </div>
                                                        <div class="iziToast-progressbar"><div></div></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="modalOpen || showPay" class="modal-backdrop in"></div>
                </div>
                <div class="tab-pane <?php echo $t3; ?>" id="tab3">
                    <div class="block-fluid">
                        <?php
                        $attributes = array('class' => 'form-horizontal', 'id' => 'fpaym');
                        echo form_open_multipart(current_url(), $attributes);
                        ?>
                        <div class='form-group'>
                            <div class="col-md-3" for='reg_no'>Student <span class='required'>*</span></div>
                            <div class="col-md-4">  
                                <?php
                                echo form_dropdown('reg_no', array('' => 'Select Student') + $students, (isset($result->reg_no)) ? $result->reg_no : '', ' class="select reg_no" id="reg_no"');
                                echo form_error('reg_no');
                                ?>
                            </div>
                            <div class="col-md-3">
                                <?php
                                echo form_dropdown('term', array('' => '') + $this->terms, (isset($result->term)) ? $result->term : '', ' class="tsel" placeholder="Select Term" ');
                                echo form_error('term');
                                ?>
                            </div>
                            <div class="col-md-2">
                                <?php
                                echo form_dropdown('year', array('' => '') + $yrs, (isset($result->year) && !empty($result->year)) ? $result->year : date('Y'), ' class="tsel" placeholder="Select Year" ');
                                echo form_error('year');
                                ?>
                                <span class="pull-right">Receipt #: <?php echo number_format($next); ?></span>
                            </div>
                        </div>

                        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <thead>
                                    <tr role="row">
                                        <th width="3%">#</th>
                                        <th width="10%">Payment Date</th>
                                        <th width="10%">Amount</th>
                                        <th width="15%">Payment Method</th>
                                        <th width="15%">Transaction No.</th>
                                        <th width="20%">Bank</th>
                                        <th width="47%">Description</th>
                                    </tr>
                                </thead>
                            </table>
                            <div id="entry1" class="clonedInput">
                                <?php echo validation_errors(); ?>
                                <table cellpadding="0" cellspacing="0" width="100%">  
                                    <tbody>
                                        <tr>
                                            <td width="3%">
                                                <span id="reference" name="reference" class="heading-reference">1</span>
                                            </td>
                                            <td width="10%">
                                                <input id='payment_date' type='text' name='payment_date[]' style="" class='payment_date   datepicker' value="<?php
                                                if (!empty($result->payment_date))
                                                {
                                                    echo date('d/m/Y', $result->payment_date);
                                                }
                                                else
                                                {
                                                    echo set_value('payment_date', (isset($result->payment_date)) ? $result->payment_date : '');
                                                }
                                                ?>"  />
                                            </td>
                                            <td width="10%">
                                                <input type="text" name="amount[]" id="amount" class="amount" value="<?php
                                                if (!empty($result->amount))
                                                {
                                                    echo $result->amount;
                                                }
                                                ?>" class="amount"> 
                                            </td>
                                            <td width="15%">
                                                <?php
                                                $items = array('Bank Slip' => 'Bank Slip', 'Cash' => 'Cash', 'Mpesa' => 'Mpesa', 'Cheque' => 'Cheque', 'Paybill' => 'Paybill');
                                                echo form_dropdown('payment_method[]', array('' => 'Select Pay Method') + $items, (isset($result->payment_method)) ? $result->payment_method : '', ' class="payment_method" id="payment_method" data-placeholder="Select Options..." ');
                                                ?>
                                            </td>
                                            <td width="15%">
                                                <input type="text" name="transaction_no[]" id="transaction_no" class="validate[required,ajax[ajaxTransactionCallPhp]] transaction_no" value="<?php
                                                if (!empty($result->transaction_no))
                                                {
                                                    echo $result->transaction_no;
                                                }
                                                ?>">
                                                       <?php echo form_error('transaction_no'); ?>
                                            </td>
                                            <td width="20%">
                                                <?php
                                                echo form_dropdown('bank_id[]', array('' => 'Select Bank Account') + $bank, (isset($result->bank_id)) ? $result->bank_id : '', ' class="bank_id" id="bank_id" ');
                                                ?>
                                            </td>
                                            <td width="47%">
                                                <?php
                                                echo form_dropdown('description[]', array('' => 'Select option', '0' => 'Tuition Fee Payment') + $extras, (isset($result->description)) ? $result->description : '', ' class="description validate[required]" id="description" ');
                                                ?>
                                            </td> 
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="actions">
                                <a href="#" id="btnAdd" class="btn btn-success clone">Add New Line</a> 
                                <a href="#" id="btnDel" class="btn btn-danger remove">Remove</a>
                            </div>
                        </div>

                        <div class='form-group'><div class="col-md-2"></div><div class="col-md-10">
                                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Process Payment', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                                <?php echo anchor('admin/fee_payment', 'Cancel', 'class="btn  btn-default"'); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                        </div>

                        <div class="col-md-6">
                            <center>
                                <h4 ><b>CURRENT FEE BALANCE: <span id="bals"></span></b> </h4>
                                <h4 ><b>NEW FEE BALANCE: <span id="new_bals"></span></b> </h4>
                            </center>   
                             <table class="table bordered" id="invoices">
 
                            </table>
                         </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<style>
    table.mxl td{padding: 3px !important; border: none !important;}
    table.mxl .multiselect__tags {min-height: 30px;padding: 3px 40px 0 3px !important;}
    .multiselect__select { height: 30px !important;}
    .iziToast-capsule *{box-sizing:border-box;}
    .iziToast{display:inline-block;clear:both;position:relative;font-size:14px;padding:8px 45px 9px 0;background:rgba(238,238,238,.9);border-color:rgba(238,238,238,.9);width:100%;pointer-events:all;cursor:default;transform:translateX(0);-webkit-touch-callout:none;-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;min-height:54px;}
    .iziToast>.iziToast-progressbar{position:absolute;left:0;bottom:0;width:100%;z-index:1;background:rgba(255,255,255,.2);}
    .iziToast>.iziToast-progressbar>div{height:2px;width:100%;background:rgba(0,0,0,.3);border-radius:0 0 3px 3px;}
    .iziToast>.iziToast-body{position:relative;padding:0 0 0 10px;height:auto;min-height:36px;margin:0 0 0 15px;text-align:left;}
    .iziToast>.iziToast-body:after{content:"";display:table;clear:both;}
    .iziToast>.iziToast-body .iziToast-texts{margin:10px 0 0;padding-right:2px;display:inline-block;float:left;}
    .iziToast>.iziToast-body .iziToast-buttons{min-height:17px;float:left;margin:4px -2px;}
    .iziToast>.iziToast-body .iziToast-buttons>button{position:relative;display:inline-block;margin:2px;}
    .iziToast>.iziToast-body .iziToast-buttons>button:active{top:1px;}
    .iziToast>.iziToast-body .iziToast-icon{position:absolute;left:0;top:50%;display:table;font-size:23px;line-height:24px;margin-top:-12px;color:#000;width:24px;height:24px;}
    .iziToast>.iziToast-body .iziToast-icon.ico-question{background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAQAAAAAYLlVAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAADdcAAA3XAUIom3gAAAAHdElNRQfhCQkUEhFovxTxAAAEDklEQVRo3s2ZTWgTQRTHf03ipTRUqghNSgsRjHgQrFUQC6JgD1Kak3gQUUoPqRdBglf1oBehBws9Cn4cGk+1SOmh2upBxAYVoeJHrR9tgq0i1Cq0lqYeks7MbpPdmU00/c8hm9n33v/t7Nt5M2+qMEWQI0QIibZKRrQpHvLL2KI2wnQzzBKrDm2RIeKEy01dTYKUI7G1ZRknQXV5yP10kTYgly1NF/5S6duZ8ES+1iZodyaocrjXxE0OFeifYYgp0mRIkwFChAkRJsIxGgrIP+I0n82fvZW5dc/zkss0O2o1c5mX6/TmaDWl77RFe5YkUW3tKEmyFv0lOvXJ/fTYnmCEFuMRbGHEZqVHLyT9DFjUJmkzJl9DG5MWWwM6Llif/gF1nukB6nhgGwUXdFrE+wiURA8QoM9i0zEWWpXQW+ZsyeRrOMuyEo5Fv4gmy4dXPvqcC+pH2VRYaMwy+OWG+iLGCgm0W0Kv9HdvR8ASjmKCXpuK/bxiV/76A/v5UdDIZuKcJGjrnec5KZ7wwsWFOp6xPX/9mt2sqDe7FO+Kf/fXHBPPDWpdXGhTpLvUG9VKwh1xMDDjkvu+cNDFBTk7ptX1QkKZ850m3duu6fcrWxwdaFFyREJ2j4vOpKP6Du6z4uJCv8sYJIVkCnJBGGZaBONO3roY2EqNrSfIPi7SKP4fdXyNUd6I6wbSAHEl33tFLe+FlSsusnK90A0+oEPcuufZgXnOi+u9LrKSJQZQw6LwqBnv2CKsfHORbFbyQhA6xN/pEuihSdj56Co7LWRjPiKie6gkB2LiKuUqK5kiPkLiz1QJ9K1cNXBAMoUCigNpQ9IqDtMI1HKA4/jyvUsaoSyZLA5kjOjDPFZen8Ql5TsvBskUgjciIPSX3QAXC86DT7VWvlEh/xZ+ij9BDVWJ0QL0SbZq6QaFxoLPcXPmBLveLCc4wXdDK6s+6/vwhCSniFLPXW0NJe5UB8zKCsviqpc7vGPVQFcyZbyPwGD+d5ZnxmNWlhG4xSBZZjivjIWHEQgoDkSMjMwTo54569JSE5IpA7EyJSMTyGTUAUFlO1ZKOtaHTMeL1PhYYFTcihmY2cQ5+ullj7EDkiVfVez2sCTz8yiv84djhg7IJVk81xFWJlPdfHBG0flkRC/zQFZ+DSllNtfDdUsOMCliyGX5uOzU3ZhIXFDof4m1gDuKbEx0t2YS25gVGpcMnr/I1kx3c6piB8P8ZoqEwfMX3ZyCXynJTmq/U7NUXqfUzCbWL1wqVKBQUeESzQYoUlW8TAcVL1RCxUu1G6BYXfFyfQ4VPbDI4T8d2WzgQ6sc/vmxnTsqfHCZQzUJxm1h5dxS5Tu6lQgTZ0ipqRVqSwzTbbLHMt+c19iO76tsx/cLZub+Ali+tYC93olEAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDE3LTA5LTA5VDIwOjE4OjE3KzAyOjAwjKtfjgAAACV0RVh0ZGF0ZTptb2RpZnkAMjAxNy0wOS0wOVQyMDoxODoxNyswMjowMP325zIAAAAZdEVYdFNvZnR3YXJlAHd3dy5pbmtzY2FwZS5vcmeb7jwaAAAAAElFTkSuQmCC) no-repeat 50% 50%;background-size:85%;}
    .iziToast>.iziToast-body .iziToast-message,.iziToast>.iziToast-body .iziToast-title{padding:0;font-size:14px;line-height:16px;text-align:left;float:left;white-space:normal;}
    .iziToast>.iziToast-body .iziToast-title{color:#000;margin:0;}
    .iziToast>.iziToast-body .iziToast-message{margin:0 0 10px;color:rgba(0,0,0,.6);}
    .iziToast.iziToast-animateInside .iziToast-icon,.iziToast.iziToast-animateInside .iziToast-inputs-child,.iziToast.iziToast-animateInside .iziToast-message,.iziToast.iziToast-animateInside .iziToast-title{opacity:0;}
    @media only screen and (min-width:568px){
        .iziToast{margin:5px 0;border-radius:3px;width:auto;}
        .iziToast:after{content:'';z-index:-1;position:absolute;top:0;left:0;width:100%;height:100%;border-radius:3px;box-shadow:inset 0 -10px 20px -10px rgba(0,0,0,.2),inset 0 0 5px rgba(0,0,0,.1),0 8px 8px -5px rgba(0,0,0,.25);}
    }
    .iziToast.iziToast-color-yellow{background:rgba(255,249,178,.9);border-color:rgba(255,249,178,.9);}
    .iziToast .slideIn{-webkit-animation:iziT-slideIn 1s cubic-bezier(.16,.81,.32,1) both;-moz-animation:iziT-slideIn 1s cubic-bezier(.16,.81,.32,1) both;animation:iziT-slideIn 1s cubic-bezier(.16,.81,.32,1) both;}
    /*! CSS Used keyframes */
    @-webkit-keyframes iziT-slideIn{0%{opacity:0;-webkit-transform:translateX(50px);}to{opacity:1;-webkit-transform:translateX(0);}}
    @-moz-keyframes iziT-slideIn{0%{opacity:0;-moz-transform:translateX(50px);}to{opacity:1;-moz-transform:translateX(0);}}
    @-moz-keyframes iziT-slideIn{0%{opacity:0;transform:translateX(50px);}to{opacity:1;transform:translateX(0);}}
    @-webkit-keyframes iziT-slideIn{0%{opacity:0;transform:translateX(50px);}to{opacity:1;transform:translateX(0);}}
    @-o-keyframes iziT-slideIn{0%{opacity:0;transform:translateX(50px);}to{opacity:1;transform:translateX(0);}}
    @keyframes iziT-slideIn{0%{opacity:0;transform:translateX(50px);}to{opacity:1;transform:translateX(0);}}
</style>
<?php
$list = [];
$campus = $this->config->item('campus_id');
$title = isset($list[$campus]) ? $list[$campus] : '';
$years = [];
foreach ($yrs as $k => $y)
{
    $years[] = ['id' => $k, 'name' => $y];
}
$fee_ex = [];
foreach ($extras as $id => $v)
{
    $fee_ex[] = ['id' => $id, 'name' => $v];
}
 
?>
<script>
    var campus = 1<?php //echo $campus;    ?>;
            var title = '';
    var roster = <?php echo json_encode($roster); ?>;
    var years = <?php echo json_encode($years); ?>;
    var extras = <?php echo json_encode($fee_ex); ?>;
    var unf = [];
    //Vue.use(VueToast, {position: 'top', pauseOnHover: true, duration: 6000});
    const mpesa = new Vue({
        el: '#tab2',
        components: {multiselect: VueMultiselect.default, paginate: VuejsPaginate},
        data() {
            return {
                url: BASE_URL,
                payment: {},
                totals: {},
                modalOpen: false,
                showPay: false,
                tab: 0,
                campuses: [],
                terms: [{id: 1, text: 'Term 1'}, {id: 2, text: 'Term 2'}, {id: 3, text: 'Term 3'}],
                years: years,
                year: {id: new Date().getFullYear(), name: new Date().getFullYear()},
                term: '',
                campus: {id: campus, text: title},
                paid: {},
                items: [
                    {
                        student: '',
                        amount: '',
                        term: '',
                        year: ''
                    }
                ],
                student: '',
                students: roster,
                rows: 0,
                pcount: 0,
                page: 1,
                count: 0,
                offset: 0,
                loading: false,
                ask: false,
                filters: {
                    sortBy: 'id',
                    order: 'desc',
                    status: '',
                    per_page: 20
                },
                options: [
                    {text: '3', value: 3},
                    {text: '10', value: 10},
                    {text: '20', value: 20},
                    {text: '50', value: 50}
                ]
            };
        },
        mounted()
        {
            //Vue.$toast.success(' Payments from Bank!');
            this.getPaid(0);
            this.getTotals();
        },
        methods: {
            showTab(tab)
            {
                this.paid = {};
                this.tab = tab;
                this.getPaid(0);
            },
            toggle_show()
            {
                this.close();
            },
            close()
            {
                this.modalOpen = false;
                this.showPay = false;
                this.ask = false;
                this.payment = {};
                this.student = '';
                this.term = '';
                this.items = [
                    {
                        student: '',
                        amount: '',
                        term: '',
                        year: ''
                    }
                ];
                this.year = {id: new Date().getFullYear(), name: new Date().getFullYear()};
            },
            confirm(ask)
            {
                this.ask = ask;
            },
            add_item: function ()
            {
                if (this.items.length == 1)
                {
                    this.items[0].amount = '';
                }
                this.items.push({
                    student: '',
                    amount: '',
                    term: '',
                    year: ''
                });
            },
            remove_item: function (index)
            {
                this.items.splice(index, 1);
            },
            searchPaid()
            {
                if (this.filters.search.length > 2)
                {
                    this.getPaid(0);
                }
                if (this.filters.search.length == 0)
                {
                    this.getPaid(0);
                }
            },
            getPaid(page, ref)
            {
                this.loading = true;
                if (typeof page === 'undefined' || typeof page !== 'number')
                {
                    var page = 0;
                }
                if (typeof ref !== 'undefined' && ref == 1)
                {
                    this.getTotals();
                }
                let url = this.getFilterURL(this.filters);
                axios.get(BASE_URL + 'admin/fee_payment/get_mobile_payments?tab=' + this.tab + '&page=' + page + url)
                        .then(response => {
                            var ret = response.data;
                            this.paid = ret.paid;
                            this.count = this.paid.length;
                            this.rows = parseFloat(ret.total);
                            this.pcount = Math.ceil(this.rows / this.filters.per_page);
                            this.offset = page ? parseInt((page - 1) * this.filters.per_page) : 0;
                            this.loading = false;
                        })
                        .catch(response => {
                            this.loading = false;
                        });
            },
            post()
            {
                this.loading = true;
                axios.post(BASE_URL + 'admin/fee_payment/process_mpesa', {id: this.payment.id, date: this.payment.created_on, tx: this.payment.txid, amount: this.payment.amount, items: this.items})
                        .then(response => {
                            console.log(response.data);
                            if (response.data.success) {
                                //this.$toast.success(response.data.message);
                                console.log(response.data.message);
                            }
                            else
                            {
                                //this.$toast.error(response.data.message);
                                console.log(response.data.message);
                            }

                            //refresh & close modal
                            this.getPaid(0);
                            this.getTotals();
                            this.close();
                            this.loading = false;
                        })
                        .catch(response => {
                            //this.$toast.error(response.message);
                            console.log(response.data.message);
                            this.loading = false;
                        });
            },
            show(id, tab)
            {
                this.modalOpen = true;
                this.getInfo(id, tab);
            },
            void_fee()
            {
                Vue.$toast.success('Payments voided successfully!');
            },
            getInfo(id, opt)
            {
                this.loading = true;
                axios.get(BASE_URL + 'admin/fee_payment/show/' + id + '/2')
                        .then(response => {
                            this.payment = response.data;
                            this.items[0].amount = this.payment.raw_amt;
                            this.modalOpen = true;
                            this.loading = false;
                        })
                        .catch(response => {
                            //this.$toast.error(response.message);
                            console.log(response.message);
                            this.loading = false;
                        });
            },
            getTotals()
            {
                axios.get(BASE_URL + 'admin/fee_payment/mobile_totals')
                        .then(response => {
                            this.totals = response.data;
                        })
                        .catch(response => {
                            console.log(response.message);
                        });
            },
            getFilterURL(data)
            {
                let url = '';
                $.each(data, function (key, value) {
                    url += (value) ? '&' + key + '=' + encodeURI(value) : '';
                });
                return url;
            },
            loaderPath()
            {
                return BASE_URL + 'assets/ico/loader.gif';
            }
        }
    });
    const app = new Vue({
        el: '#tab1',
        components: {multiselect: VueMultiselect.default, paginate: VuejsPaginate},
        data() {
            return {
                url: BASE_URL,
                payment: {},
                total: '0.00',
                modalOpen: false,
                showPay: false,
                tab: 0,
                campuses: [{id: 1, text: 'Kathome'}, {id: 2, text: 'Mumbuni'}, {id: 3, text: 'Eastleigh'}],
                terms: [{id: 1, text: 'Term 1'}, {id: 2, text: 'Term 2'}, {id: 3, text: 'Term 3'}],
                years: years,
                extras: extras,
                uniform: unf,
                year: {id: new Date().getFullYear(), name: new Date().getFullYear()},
                term: '',
                campus: {id: campus, text: title},
                paid: {},
                items: [
                    {
                        student: '',
                        amount: '',
                        term: '',
                        year: '',
                        uf: false,
                        fee: ''
                    }
                ],
                student: '',
                students: roster,
                rows: 0,
                pcount: 0,
                page: 1,
                count: 0,
                offset: 0,
                loading: false,
                ask: false,
                filters: {
                    sortBy: 'id',
                    order: 'desc',
                    status: '',
                    per_page: 20
                },
                options: [
                    {text: '3', value: 3},
                    {text: '10', value: 10},
                    {text: '20', value: 20},
                    {text: '50', value: 50}
                ]
            };
        },
        mounted()
        {
            //Vue.$toast.success(' Payments from Bank!');
            this.getPaid(0);
            this.getTotals();
        },
        computed: {
            isDisabled()
            {
                return this.student == '' || this.term == '';
            }
        },
        methods: {
            showTab(tab)
            {
                this.paid = {};
                this.tab = tab;
                this.getPaid(0);
            },
            add_item: function (uf)
            {
                if (this.items.length == 1)
                {
                    this.items[0].amount = '';
                }
                this.items.push({
                    student: '',
                    amount: '',
                    term: '',
                    year: '',
                    uf: uf ? true : false,
                    fee: ''
                });
            },
            remove_item: function (index)
            {
                this.items.splice(index, 1);
            },
            toggle_show()
            {
                this.close();
            },
            close()
            {
                this.modalOpen = false;
                this.showPay = false;
                this.ask = false;
                this.payment = {};
                this.items = [
                    {
                        student: '',
                        amount: '',
                        term: '',
                        year: '',
                        uf: false,
                        fee: ''
                    }
                ];
                this.student = '';
                this.term = '';
                this.year = {id: new Date().getFullYear(), name: new Date().getFullYear()};
            },
            confirm(ask)
            {
                this.ask = ask;
            },
            searchPaid()
            {
                if (this.filters.search.length > 2)
                {
                    this.getPaid(0);
                }
                if (this.filters.search.length == 0)
                {
                    this.getPaid(0);
                }
            },
            getPaid(page, ref)
            {
                this.loading = true;
                if (typeof page === 'undefined' || typeof page !== 'number')
                {
                    var page = 0;
                }
                if (typeof ref !== 'undefined' && ref == 1)
                {
                    this.getTotals();
                }
                let url = this.getFilterURL(this.filters);
                axios.get(BASE_URL + 'admin/fee_payment/get_bank_upload?tab=' + this.tab + '&page=' + page + url)
                        .then(response => {
                            var ret = response.data;
                            this.paid = ret.paid;
                            this.count = this.paid.length;
                            this.rows = parseFloat(ret.total);
                            this.pcount = Math.ceil(this.rows / this.filters.per_page);
                            this.offset = page ? parseInt((page - 1) * this.filters.per_page) : 0;
                            this.loading = false;
                        })
                        .catch(response => {
                            this.loading = false;
                        });
            },
            post()
            {
                axios.post(BASE_URL + 'admin/fee_payment/assign_student', {id: this.payment.id, date: this.payment.tx_date, tx: this.payment.tx_no, amount: this.payment.amount, method: this.payment.method, items: this.items})
                        .then(response => {
                            console.log(response.data);
                            if (response.data.success) {
                                //this.$toast.success(response.data.message);
                                console.log(response.data.message);
                            }
                            else
                            {
                                //this.$toast.error(response.data.message);
                                console.log(response.data.message);
                            }

                            //refresh & close modal
                            this.getPaid(0);
                            this.getTotals();
                            this.close();
                        })
                        .catch(response => {
                            //this.$toast.error(response.message);
                            console.log(response.message);
                        });
            },
            show(id, tab)
            {
                this.modalOpen = true;
                this.getInfo(id, tab);
            },
            getInfo(id, opt)
            {
                axios.get(BASE_URL + 'admin/fee_payment/show/' + id)
                        .then(response => {
                            this.payment = response.data;
                            this.items[0].amount = this.payment.raw_amt;
                            console.log(this.items[0]);
                            this.modalOpen = true;
                        })
                        .catch(response => {
                            //this.$toast.error(response.message);
                            console.log(response.message);
                        });
            },
            getTotals()
            {
                axios.get(BASE_URL + 'admin/fee_payment/daily_bank_totals')
                        .then(response => {
                            this.total = response.data.total;
                        })
                        .catch(response => {
                            console.log(response.message);
                        });
            },
            getFilterURL(data)
            {
                let url = '';
                $.each(data, function (key, value) {
                    url += (value) ? '&' + key + '=' + encodeURI(value) : '';
                });
                return url;
            },
            loaderPath()
            {
                return BASE_URL + 'assets/ico/loader.gif';
            }
        }
    });
</script>
<style scoped>
    .text-danger {    color: #FF4961!important;}
    .text-success {    color: #28D094!important;}
    .sw{cursor: pointer;}
    [v-cloak] {display: none;}
    .tabs__nav{font-size:13px;display:flex;text-transform:uppercase;list-style-type:none;font-weight:500}.tabs__nav li{padding:4px 10px;cursor:pointer;border:1px solid #f0629226;background:#eee}.tabs__nav li.active{background:#428bca;color:#fff}.tabs__nav li:not(:last-child){border-right:none;border-radius:4px 0 0 4px}.tabs__nav li:not(:first-child){border-radius:0 4px 4px 0}.tabs__nav li:not(:first-child):not(:last-child){border-radius:0}.tabs__content{padding:20px}
    .st-t{text-align: center;}
    .st-t h2{margin-top: 2px;}
    .st-t h5{margin-top: 2px; margin-bottom: 2px;}
    .close{float:right;font-size:30px;font-weight:500;line-height:1;color:#00008b;}
    .close:hover,.close:focus{color:#FFF;text-decoration:none;}
    button.close{padding:1rem;margin-top: 0!important;margin:-1rem -1rem -1rem auto;background-color:transparent;border:0;-webkit-appearance:none;opacity: 1;}
    .modal{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1050;display:none;overflow:auto;outline:0;}
    .modal-dialog{position:relative;width:auto;margin:0.5rem;pointer-events:none;}
    .modal.fade .modal-dialog{-webkit-transition:-webkit-transform 0.3s ease-out;transition:-webkit-transform 0.3s ease-out;transition:transform 0.3s ease-out;transition:transform 0.3s ease-out, -webkit-transform 0.3s ease-out;-webkit-transform:translate(0, -25%);transform:translate(0, -25%);}
    .modal-content{position:relative;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;width:100%;pointer-events:auto;background-color:#fff;background-clip:padding-box;border:0px solid rgba(0, 0, 0, 0.2);border-radius:6px;outline:0;}
    .modal-header{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:start;-ms-flex-align:start;align-items:flex-start;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;padding:8px;border-bottom:0px solid #e9ecef;border-top-left-radius:6px;border-top-right-radius:6px;}
    .modal-title{margin-bottom:0;line-height:1.5;}
    .modal-body{position:relative;-webkit-box-flex:1;-ms-flex:1 1 auto;flex:1 1 auto;padding:12px;}
    .modal-footer{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:end;-ms-flex-pack:end;justify-content:flex-end;padding:10px;border-top:0px solid #e9ecef;}
    .modal-footer > :not(:first-child){margin-left:.25rem;}
    .modal-footer > :not(:last-child){margin-right:.25rem;}
    @media (min-width: 576px)
    {
        .prl{margin-right: 25%;}
        .modal-dialog:not(.spl){max-width:550px;margin:1.75rem auto;}
        .modal-dialog{max-width:70% !important;margin:1.75rem auto;}
    }
    .modal-content{-webkit-box-shadow:0 25px 65px rgba(15, 24, 33, 0.29);box-shadow:0 25px 65px rgba(15, 24, 33, 0.29);}
    .modal-footer.buttons-on-left{-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start;}
    .modal-header.faded{background-color:rgba(0, 0, 0, 0.05);}
    .modal-header.smaller{font-size:0.99rem;}
    .modal-header span,.modal-header strong,.modal-header .avatar{display:inline-block;vertical-align:middle;}
    .modal-header span{color:#999;margin-right:5px;}
    .modal-header .avatar{border-radius:50%;width:40px;height:auto;}
    .modal-header .avatar + span{border-left:1px solid rgba(0, 0, 0, 0.1);padding-left:15px;margin-left:15px;}
    .subby-header{margin-bottom:20px;color:#047bf8;}
    .subby-header i{margin-right:10px;font-size:22px;display:inline-block;vertical-align:middle;}
    .subby-header span{display:inline-block;vertical-align:middle;}
    .m-0{margin: 0 !important;}
</style>
<script type="text/javascript">
    $(function ()
    {
        var amtts = 0;
        $('#btnAdd').click(function ()
        {
            var num = $('.clonedInput').length, // how many "duplicatable" input fields we currently have
                    newNum = new Number(num + 1), // the numeric ID of the new input field being added
                    newElem = $('#entry' + num).clone(true, true).attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
            // manipulate the name/id values of the input inside the new element
            // H2 - section
            newElem.find('.heading-reference').attr('id', 'reference').attr('name', 'reference').html(' ' + newNum);
            // sum amounts
            var val = parseFloat($('#entry' + num).find('.amount').val());
            amtts += isNaN(val) ? 0 : val;
            // subject - select
            newElem.find('.payment_date').attr('id', 'ID' + newNum + '_payment_date').val('').removeClass("hasDatepicker").datepicker({
                format: "dd MM yyyy",
            }).focus();

            newElem.find('.amount').attr('id', 'ID' + newNum + '_amount').val('');

            newElem.find('.payment_method').attr('id', 'ID' + newNum + '_payment_method').val('');
            newElem.find('.transaction_no').attr('id', 'ID' + newNum + '_transaction_no').val('');

            newElem.find('.bank_id').attr('id', 'ID' + newNum + '_bank_id').val('');
            newElem.find('.description').attr('id', 'ID' + newNum + '_description').val('');

            // insert the new element after the last "duplicatable" input field
            $('#entry' + num).after(newElem);

            // enable the "remove" button
            $('#btnDel').attr('disabled', false);

            // right now you can only add 5 sections. change '5' below to the max number of times the form can be duplicated
            if (newNum == 100)
                $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
        });

        $('#btnDel').click(function () {
            // confirmation
            if (confirm("Are you sure you wish to remove this section? This cannot be undone."))
            {
                var num = $('.clonedInput').length;
                // how many "duplicatable" input fields we currently have
                $('#entry' + num).slideUp('slow', function () {
                    $(this).remove();
                    // sum amounts
                    var val = parseFloat($('#entry' + num).find('.amount').val());
                    amtts -= isNaN(val) ? 0 : val;
                    // if only one element remains, disable the "remove" button
                    if (num - 1 === 1)
                        $('#btnDel').attr('disabled', true);
                    // enable the "add" button
                    $('#btnAdd').attr('disabled', false).prop('value', "add section");
                });
            }
            return false;
            // remove the last element

            // enable the "add" button
            $('#btnAdd').attr('disabled', false);
        });

        $('#btnDel').attr('disabled', true);

        $(".tsel").select2({'placeholder': 'Please Select', 'width': '100%'});
    });

</script>

<script>
    jQuery(function () {

        jQuery("#reg_no").change(function () {

            jQuery('#invoices').empty();
            jQuery('#bals').empty();
            var reg_no = jQuery(".reg_no").val();

            var options = '';
            var th = '<tr><th>#</th><th><b>THIS TERM INVOICES </b></th><th><b>AMOUNT</b></th>zzz</tr>';


            jQuery.getJSON("<?php echo base_url('admin/fee_payment/list_invoices'); ?>", {id: jQuery(this).val()}, function (data) {

                var j = 0;
                for (var i = 0; i < data.length; i++) {
                    j += 1
                    options += '<tr><td>' + j + '</td><td>' + data[i].optionValue + '</td><td>' + data[i].optionDisplay + '</td></tr>';

                }

                jQuery('#invoices').append(th + options);

            });

            var bal = '';
            jQuery.getJSON("<?php echo base_url('admin/fee_payment/f_bal'); ?>", {id: jQuery(this).val()}, function (data) {
                bal = data[0].optionDisplay;

                jQuery('#bals').append(bal);

            });


            //
        });

        jQuery(".amount").on('keyup', function () {

            var amount = $(this).closest('table').find(".amount").val();

            var balance;
            var bal;
            var new_bal;

            jQuery.getJSON("<?php echo base_url('admin/fee_payment/f_bal'); ?>", {id: jQuery(this).val()}, function (data) {
                bal = data[0].optionDisplay;
            });

            balance = $("#bals").text();
            bal = balance.replace(",", "")
            new_bal = Number(bal) - Number(amount);
            jQuery('#new_bals').html(new_bal);
        });
    });

    function numberWithCommas(x) {
        var parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    }
</script>
<script>
    $(document).ready(function () {
        $("#fpaym").validationEngine('attach', {promptPosition: "topLeft"});
    });
</script>