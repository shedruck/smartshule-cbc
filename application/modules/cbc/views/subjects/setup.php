<div id="setup" v-cloak>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header row">
                <div class="col-md-11">
                    <h3 class="text-uppercase">CBC Exam Setup</h3>
                </div>
                <div class="col-md-1">
                    <a href="#" class="pull-right btn btn-primary"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
                </div>
            </div>
        </div>
        <div class="card-box">
            <h4 class="m-t-0 m-b-10 header-title text-center">Select Exam & Class</h4>
            <form role="form" action="#" class="form-horizontal form-main">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="col-sm-3 control-label">Exam</label>
                        <div class="col-sm-9 rows">
                            <multiselect placeholder="Select Exam" v-model="exam" :options="exams" track-by="id" label="text" :searchable="true" :reset-after="false" @select="update"></multiselect>
                            <code>{{ exam }}</code>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-sm-3 control-label">Class</label>
                        <div class="col-sm-9 rows">
                            <multiselect placeholder="Select Class" v-model="classs" :options="classes" track-by="id" label="text" :searchable="true" :reset-after="false" @select="update"></multiselect>
                            <code>{{ classs }}</code>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
        <div class="card-box" v-if="!exam || !classs">
            <div class="card">
                <div class="card-body">
                    <div class="padding-xl">
                        <h4 class="card-title">Please Select Exam & Class</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="card-box">
            <div class="tl-header">
                <span class="font-20">Rating Criteria</span>
                <a href="javascript:" class="col-md-offset-3 prl btn-link"><strong>+Add New </strong></a>
            </div>
            <ul class="single-row eq">
                <li>
                    <input type="radio" id="res-2" name="rating" class="custom-control-input">
                    <label class="custom-control-label" for="res-2" >Select</label>
                </li>
                <li>Bbbb bbb bbb</li>
                <li>Cccc ccc ccc</li>
                <li>Dddd ddd ddd</li>
                <li><p><span class="text-soft">Started On</span> Oct 12, 2018</p></li>
                <li>Ffff fff fff</li>
                <li>Hhhh hhh hhh</li>
                <li>Iiii iii iii</li>
            </ul>
            <ul class="single-row eq">
                <li>
                    <input type="radio" name="rating"  id="res-3" class="custom-control-input">
                    <label class="custom-control-label" for="res-3">Select</label>
                </li>
                <li><p><span class="text-soft">EE - Exceeds Expectation</span> 100%- 90%</p></li>
                <li><p><span class="text-soft">ME - Meets Expectation</span>89% - 70%</p></li>
                <li><p><span class="text-soft">AE - Approaching Expectation</span> 69% - 40%</p></li>
                <li><p><span class="text-soft">BE - Below Expectation</span> 39 %- 0%</p></li>
            </ul>
        </div>

        <div class="card-box" v-if="exam && classs">
            <h3 class="m-t-0 m-b-10 text-uppercase">Exam: End of Term 2, July 2019</h3>
            <form role="form" action="#" method="POST" class="form-horizontal form-main">
                <div class="form-group m-b-0">
                    <div class="col-lg-6">
                        <div class="element-wrapper">
                            <h6 class="element-header">
                                Assessment Settings
                            </h6>
                            <ul class="unstyled centered">
                                <li>
                                    <input class="sck" id="sck-1" type="checkbox" value="tasks">
                                    <label for="sck-1">Enable Tasks under Substrands</label>
                                </li>
                            </ul>
                            <hr>
                            <div class="card-inner-group">
                                <div class="card-inner">
                                    <div class="d-flex">
                                        <div class="st-text">
                                            <h6>LISTENING AND SPEAKING</h6>
                                            <p>&nbsp;</p>
                                        </div>
                                        <div class="st-rt">
                                            <button class="btn btn-primary btn-sm">web</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-inner">
                                    <div class="d-flex">
                                        <div class="st-text">
                                            <h6>LANGUAGE STRUCTURES AND FUNCTIONS</h6>
                                            <p>&nbsp;</p>
                                        </div>
                                        <div class="st-rt">
                                            <button class="btn btn-primary btn-sm pull-right">web</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            -------------------------------
                            <div class="pb">
                                <div class="tl-header">
                                    <h4>Ratings</h4>
                                    <a href="javascript:" class="pull-right prl btn-link"><strong>+Add Tasks </strong></a>
                                </div>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td width="70%">Listen attentively during a conversation</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="javascript:" class="btn btn-primary btn-sm"><span>Edit</span></a>
                                                    <a href="http://x.com/sms-ke/admin/cbc/remove_task/1/3" onclick="return confirm('Are you sure You Want to delete this record?')" class="btn btn-danger btn-sm"><span>Delete</span></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td width="70%">Respond to simple specific one- directional instructions in oral communication</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="javascript:" class="btn btn-primary btn-sm"><span>Edit</span></a>
                                                    <a href="http://x.com/sms-ke/admin/cbc/remove_task/2/3" onclick="return confirm('Are you sure You Want to delete this record?')" class="btn btn-danger btn-sm"><span>Delete</span></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3.</td>
                                            <td width="70%">Appreciate the importance of listening attentively for effective communication</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="javascript:" class="btn btn-primary btn-sm"><span>Edit</span></a>
                                                    <a href="http://x.com/sms-ke/admin/cbc/remove_task/3/3" onclick="return confirm('Are you sure You Want to delete this record?')" class="btn btn-danger btn-sm"><span>Delete</span></a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="element-wrapper">
                            <h5 class="element-header underline">
                                Assessment Form Preview
                            </h5>
                            <div class="element-box">
                                xxxxxxxxx
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-6">
            <div class="d-flex">
                <div class="pl-3">
                    <a href="javascript:;" class="btn btn-danger ant-popover-open btn-sm rounded" @click.self="confirm()"><i class="ft-x-circle"></i> Delete
                        <div class="ant-popover ant-popover-placement-top" v-if="del">
                            <div class="ant-popover-content">
                                <div class="ant-popover-arrow"></div>
                                <div role="tooltip" class="ant-popover-inner">
                                    <div class="ant-popover-inner-content">
                                        <div class="ant-popover-message d-flex mt-2">                                                   
                                            <i class="ft-alert-octagon f-18 f-alert"></i>
                                            <div class="ant-popover-message-title">Are you sure?</div>
                                        </div>
                                        <div class="ant-popover-buttons">
                                            <button type="button" class="btn btn-sm btn-light" @click.prevent="del=false;">
                                                <span><i class="ft-x"></i>  No</span>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm"  @click.prevent="proceed">
                                                <span><i class="ft-check"></i>  Yes</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div> 
    </div>
</div>

<style>
    .card-inner-group .card-inner:not(:last-child){border-bottom:1px solid #dbdfea;}
    @media (min-width: 576px){
        .flex-sm-nowrap{flex-wrap:nowrap!important;}
    }
    @media (min-width: 768px){
        .flex-md-nowrap{flex-wrap:nowrap!important;}
    }
    @media (min-width: 768px){
        h6{font-size:14px;}
    }
</style>
<style>
    .d-flex{display: flex;}
    ul.single-row {border: 1px solid #dbdfea;  border-radius: 5px; display: flex; flex-wrap: nowrap; justify-content: flex-start; margin: 1em 0px; padding: 10px; list-style: none; }
    ul.single-row li:not(:first-child) {line-height: 1.5; position: relative; font-weight: 600; margin-right: 1.4em; border-right: 1px solid #dbdfea;}
    ul.single-row.eq li:not(:first-child) { flex-grow: 1; padding: 2px 8px; margin-right: 0; margin-left: 0; }
    ul.single-row li:last-child { border-right:none !important; }
    ul.single-row li p:last-child { margin-bottom: 0; }
    ul.single-row li p > span { font-weight: 400; display: block;}
    ul.single-row li:first-child{width: 120px !important;border-right: 1px solid #dbdfea;}

    .underline{text-decoration: underline;}
    .sck {
        position: absolute;
        opacity: 0;
    }
    .sck + label {
        position: relative;
        cursor: pointer;
        padding: 0;
    }
    .sck + label:before {
        content: "";
        margin-right: 10px;
        display: inline-block;
        vertical-align: text-top;
        width: 20px;
        height: 20px;        
        border: 1px solid #2aa1c0;
        background: white;
    }
    .sck:hover + label:before {background: #2aa1c0;}
    .sck:checked + label:before {background: #2aa1c0;    }
    .sck:checked + label:after {content: "";position: absolute;left: 5px;top: 9px;background: white;width: 2px;height: 2px;box-shadow: 2px 0 0 white, 4px 0 0 white, 4px -2px 0 white, 4px -4px 0 white, 4px -6px 0 white, 4px -8px 0 white;transform: rotate(45deg);
    }
</style>
<style>
    .padding-xl 
    {
        text-align: center;
        margin: 20px auto;
        width: 60%;
    }
    .f-alert
    {
        color: #f00;
        background: yellow;
        border-radius: 13px;
    }
    .ant-popover-open
    {
        display: inline-block;
        line-height: 30px;
        position: relative;
    }
    .ant-popover{color:rgba(0,0,0,.65);font-size:14px;line-height:1.5; left: 50%;
                 top: auto;
                 transform: translateX(-50%); bottom: 24px;position:absolute;z-index:1030;font-weight:400;}
    .ant-popover:after{position:absolute;background:hsla(0,0%,100%,.01);content:"";}
    .ant-popover-placement-top{padding-bottom:10px;}
    .ant-popover-inner{background-color:#fff;background-clip:padding-box;border-radius:4px;box-shadow:0 2px 8px rgba(0,0,0,.15);box-shadow:0 0 8px rgba(0,0,0,.15)\9;}
    @media (-ms-high-contrast:none),screen and (-ms-high-contrast:active){
        .ant-popover-inner{box-shadow:0 2px 8px rgba(0,0,0,.15);}
    }
    .ant-popover-inner-content{padding:12px 16px;color:rgba(0,0,0,.65);}
    .ant-popover-message{position:relative;padding:4px 0 12px;color:rgba(0,0,0,.65);font-size:14px;}
    .ant-popover-message>.anticon{position:absolute;top:8px;color:#faad14;font-size:14px;}
    .ant-popover-message-title{padding-left:22px;}
    .ant-popover-buttons{margin-bottom:4px;text-align:right;}
    .ant-popover-buttons button{margin-left:8px;}
    .ant-popover-arrow{position:absolute;display:block;width:8.48528137px;height:8.48528137px;background:transparent;border-style:solid;border-width:4.24264069px;transform:rotate(45deg);}
    .ant-popover-placement-top>.ant-popover-content>.ant-popover-arrow{bottom:6.2px;border-color:transparent #fff #fff transparent;box-shadow:3px 3px 7px rgba(0,0,0,.07);}
    .ant-popover-placement-top>.ant-popover-content>.ant-popover-arrow{left:50%;transform:translateX(-50%) rotate(45deg);}
</style>
<script>
    //Vue.component('multiselect', window.VueMultiselect.default);
    const tsk = new Vue({
        el: '#setup',
        data: {
            del: false,
            exam: '',
            classs: '',
            classes: [
                {id: 1, text: 'GRADE 1 BLUE'},
                {id: 2, text: 'GRADE 1 YELLOW'},
                {id: 3, text: 'PP1 RED'},
                {id: 4, text: 'PP2 YELLOW'}
            ],
            exams: [
                {id: 1, text: 'Term 1 OPENER EXAM'},
                {id: 2, text: 'Term 1 MID TERM EXAM'},
                {id: 3, text: 'DEC 2020 EXAM'}
            ]
        },
        components: {
            multiselect: VueMultiselect.default
        },
        methods: {
            confirm(state)
            {
                this.del = true;
            },
            proceed()
            {
                this.del = false;
            },
            update(e)
            {
                console.log(e.id + " - " + e.text);
            },
            DeleteUser: function (id, index)
            {
                if (confirm("Do you really want to delete?")) {

                    axios.delete('/api/artist/' + id)
                            .then(resp => {
                                this.artists.data.splice(index, 1);
                            })
                            .catch(error => {
                                console.log(error);
                            });
                }
            }
        }
    });
</script>