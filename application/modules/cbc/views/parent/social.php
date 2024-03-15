<?php
$avt = strtolower(substr($this->user->first_name, 0, 1));
$t1 = 'active';
$t2 = '';
if ($this->input->get('s'))
{
    $t1 = '';
    $t2 = 'active';
}
?>
<div id="assess" v-cloak>
    <div class="row">
        <div class="col-md-11 hidden-print">
            <h4 class="text-uppercase">Social Behavior Report: &nbsp; &nbsp; &nbsp; <?php echo $class->name ?></h4>
        </div>
        <div class="col-md-1 hidden-print">
            <a href="<?php echo base_url('trs/cbc'); ?>" class="pull-right btn btn-primary"><i class="mdi mdi-reply"></i> Back</a>
        </div>
        <div class="clearfix"></div>
        <hr class="hidden-print">
        <div class="row hidden-print">
            <div class="col-md-12">
                <ul class="ml-5 nav nav-tabs tabs-bordered" style='margin-bottom: 10px;'>
                    <li class="<?php echo $t1; ?>">
                        <a href="" @click.prevent='tab=1' data-toggle="tab" aria-expanded="true">
                            <span class=""><i class="mdi mdi-edit"></i></span>
                            <span class="">Create/Edit Report</span>
                        </a>
                    </li>
                    <li class="<?php echo $t2; ?>">
                        <a href="" @click.prevent='tab=2' data-toggle="tab" aria-expanded="false">
                            <span class="visible-xs"><i class="mdi mdi-printer"></i></span>
                            <span class="">Print Report </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div v-if='tab==1'>
            <div class="card-box hidden-print">
                <form role="form" action="#" class="form-horizontal form-main p-10">
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label class="col-sm-3 control-label">Student</label>
                            <div class="col-sm-9 rows">
                                <multiselect placeholder="Student" v-model="rec.student" :options="students" track-by="id" label="name" :searchable="true" :reset-after="false" @input="pop_assess()"></multiselect>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-sm-3 control-label">Term:</label>
                            <div class="col-sm-9 rows">
                                <multiselect placeholder="Term" v-model="term" :options="terms" track-by="id" label="text" :searchable="true" :reset-after="false" @input="pop_assess()"></multiselect>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-sm-3 control-label">Year:</label>
                            <div class="col-sm-9 rows">
                                <multiselect placeholder="Year" v-model="year" :options="years" track-by="id" label="text" :searchable="true" :reset-after="false" @input="pop_assess()"></multiselect>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="clearfix"></div>
            <div class="card-box" v-if="!term || !year || !rec.student">
                <div class="card">
                    <div class="card-body">
                        <div class="padding-xl">
                            <h4 class="card-title"> Please Select Student, Term & Year</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row" v-if="term && year && rec.student">
                <div class="accordion">
                    <div class="panel panel-default" >
                        <div class="row">
                            <div class="col-sm-3"> </div>
                            <div class="col-sm-5">
                                <h3 class="text-uppercase">SOCIAL BEHAVIOR REPORT</h3>
                                <h3 class="text-uppercase">{{ term.text }} - {{ year.text }}</h3>
                            </div>
                            <div class="col-sm-4">
                                <h3 class="text-uppercase">NAME:  {{ rec.student.name }} </h3>
                                <h3 class="text-uppercase"><?php echo $class->name ?> </h3>
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="">
                            <center><img src="<?php echo base_url('/uploads/files/s_key.png'); ?>"></center>
                        </div>
                        <div class="panel-body pa-15" style="position:relative;">

                            <div class="loader" v-if="loading"></div>

                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="fbg">
                                        <th width='30%'>PERSONAL SKILLS</th>
                                        <th>GRADE</th>
                                        <th width='30%'>WORK HABITS</th>
                                        <th>GRADE</th>
                                    </tr>
                                    <tr>
                                        <td >Consideration for Others</td>
                                        <td> <quick-edit v-model="social.cons" type="select" :options="options" :classes='classes' @input='post_social($event)'></quick-edit> </td>
                                <td >Works independently</td>
                                <td> <quick-edit v-model="social.ind" type="select" :options="options" :classes='classes' @input='post_social($event)'></quick-edit></td>
                                </tr>
                                <tr>
                                    <td >Organization </td>
                                    <td> <quick-edit v-model="social.org" type="select" :options="options" :classes='classes' @input='post_social($event)'></quick-edit> </td>
                                <td >Completes assignments at school</td>
                                <td><quick-edit v-model="social.school" type="select" :options="options" :classes='classes' @input='post_social($event)'></quick-edit></td>
                                </tr>
                                <tr>
                                    <td >Communication</td>
                                    <td><quick-edit v-model="social.comm" type="select" :options="options" :classes='classes' @input='post_social($event)'></quick-edit></td>
                                <td >Completes homework</td>
                                <td><quick-edit v-model="social.home" type="select" :options="options" :classes='classes' @input='post_social($event)'></quick-edit></td>
                                </tr>
                                <tr>
                                    <td>Respect for School Property</td>
                                    <td> <quick-edit v-model="social.property" type="select" :options="options" :classes='classes' @input='post_social($event)'></quick-edit></td>
                                <td>Contribution in Group Work</td>
                                <td><quick-edit v-model="social.groupw" type="select" :options="options" :classes='classes' @input='post_social($event)'></quick-edit></td>
                                </tr>
                                <tr>
                                    <td>Cooperation</td>
                                    <td><quick-edit v-model="social.coop" type="select" :options="options" :classes='classes' @input='post_social($event)'></quick-edit></td>
                                <td> Uses Time Wisely</td>
                                <td><quick-edit v-model="social.time_" type="select" :options="options" :classes='classes' @input='post_social($event)'></quick-edit></td>
                                </tr>
                                <tr>
                                    <td>Self Confidence</td>
                                    <td><quick-edit v-model="social.conf" type="select" :options="options" :classes='classes' @input='post_social($event)'></quick-edit></td>
                                <td>Class Concentration</td>
                                <td><quick-edit v-model="social.conce" type="select" :options="options" :classes='classes' @input='post_social($event)'></quick-edit></td>
                                </tr>
                                <tr>
                                    <td>Accepts responsibility</td>
                                    <td><quick-edit v-model="social.accept" type="select" :options="options" :classes='classes' @input='post_social($event)'></quick-edit></td>
                                <td>Punctuality</td>
                                <td><quick-edit v-model="social.punctual" type="select" :options="options" :classes='classes' @input='post_social($event)'></quick-edit></td>
                                </tr>
                                <tr>
                                    <td >Self Motivation</td>
                                    <td><quick-edit v-model="social.motivation" type="select" :options="options" :classes='classes' @input='post_social($event)'></quick-edit></td>
                                <td> </td>
                                <td></td>
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr class="fbg">
                                    <td class="text-uppercase">English Reading Progress</td>
                                    <td> </td>
                                    <td class="text-uppercase"> Maendeleo na Masomo</td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td>Read Fluently</td>
                                    <td><quick-edit v-model="social.fluent" type="select" :options="options" :classes='classes' @input="post_social($event)"></quick-edit></td>
                                <td> Kusoma kwa Mtiririko</td>
                                <td><quick-edit v-model="social.mtrr" type="select" :options="options" :classes='classes' @input="post_social($event)"></quick-edit></td>
                                </tr>
                                <tr>
                                    <td>Speed</td>
                                    <td><quick-edit v-model="social.speed" type="select" :options="options" :classes='classes' @input="post_social($event)"></quick-edit></td>
                                <td> Kusoma kwa Kasi</td>
                                <td><quick-edit v-model="social.kasi" type="select" :options="options" :classes='classes' @input="post_social($event)"></quick-edit></td>
                                </tr>
                                <tr>
                                    <td>Can Comprehend</td>
                                    <td><quick-edit v-model="social.compr" type="select" :options="options" :classes='classes' @input="post_social($event)"></quick-edit></td>
                                <td> Kusoma na kuelewa</td>
                                <td><quick-edit v-model="social.klw" type="select" :options="options" :classes='classes' @input="post_social($event)"></quick-edit></td>
                                </tr>
                                <tr>
                                    <td>Extensive Reading</td>
                                    <td><quick-edit v-model="social.exte" type="select" :options="options" :classes='classes' @input="post_social($event)"></quick-edit></td>
                                <td> Kusoma kwa Ziada</td>
                                <td><quick-edit v-model="social.ziada" type="select" :options="options" :classes='classes' @input="post_social($event)"></quick-edit></td>
                                </tr>
                                <tr>
                                    <td>Use of Tone Variation</td>
                                    <td><quick-edit v-model="social.tone" type="select" :options="options" :classes='classes' @input="post_social($event)"></quick-edit></td>
                                <td>Mawimbi ya Sauti</td>
                                <td><quick-edit v-model="social.sauti" type="select" :options="options" :classes='classes' @input="post_social($event)"></quick-edit></td>
                                </tr>
                                <tr>
                                    <td>Spellings</td>
                                    <td><quick-edit v-model="social.spell" type="select" :options="options" :classes='classes' @input="post_social($event)"></quick-edit></td>
                                <td>Hijai</td>
                                <td><quick-edit v-model="social.hj" type="select" :options="options" :classes='classes' @input="post_social($event)"></quick-edit></td>
                                </tr>
                                </tbody>
                            </table>
                            <hr>
                            <div class="form-group">
                                <div class="col-md-3" for="title">Student's General Conduct </div>
                                <div class="col-md-6">
                                    <quick-edit v-model="social.remarks" type="textarea" :options="options" :classes='classes' @input="post_social($event)"></quick-edit>       
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if='tab==2'>
            <div class="card-x">
                <h3 class="m-t-0 header-title text-custom text-center hidden-print"><ins>PRINT REPORT</ins></h3>
                <form class="form-horizontal form-main p-10 hidden-print">
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label class="col-sm-3 control-label">Class</label>
                            <div class="col-sm-9 rows">
                                <multiselect placeholder="Select Class" v-model="pr.class" :options="assigned" track-by="id" label="text" :searchable="true" :reset-after="false"></multiselect>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label class="col-sm-3 control-label">Term:</label>
                            <div class="col-sm-9 rows">
                                <multiselect placeholder="Term" v-model="pr.term" :options="terms" track-by="id" label="text" :searchable="true" :reset-after="false"></multiselect>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label class="col-sm-3 control-label">Year:</label>
                            <div class="col-sm-9 rows">
                                <multiselect placeholder="Year" v-model="pr.year" :options="years" track-by="id" label="text" :searchable="true" :reset-after="false"></multiselect>
                            </div>
                        </div>                    
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-info btn-lg" :disabled="!pr.class || !pr.term || !pr.year" @click='show_report()'><i class="mdi mdi-check"></i> Submit</button>
                            <a class="btn btn-info btn-lg" v-if="sub" @click="window.print(); return false"><i class="mdi mdi-printer"></i> Print</a>
                        </div>                    
                    </div>
                </form>
                <div class="clearfix"></div>
                <div class="card-box" v-if="!pr.class || !pr.term || !pr.year">
                    <div class="card">
                        <div class="card-body">
                            <div class="padding-xl">
                                <h4 class="card-title text-pink"> Please Select Term, Year & Class</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" page-break" v-for="r in report">
                    <div class="img-container">
                        <img src="<?php echo base_url('uploads/r-header.png'); ?>" style="width:358px;" alt="header">
                    </div>
                    <div class="text-center">
                        <h4><strong>SOCIAL BEHAVIOR REPORT</strong></h4>
                        <h4 class="text-uppercase"><ins>NAME:</ins>  {{ r.name }}  &nbsp;&nbsp;&nbsp;<ins>ADM.</ins> &nbsp;&nbsp;&nbsp; {{ r.adm }} &nbsp;&nbsp;&nbsp; <ins>Age:</ins> {{ r.age }}</h4>
                        <p>
                            <span class="text-uppercase"><?php echo $class->name ?> {{ pr.term.text }} - {{ pr.year.text }}</span>
                        </p>
                    </div>

                    <div class="clearfix"></div>
                    <hr>
                    <div class="">
                        <center><img src="<?php echo base_url('/uploads/files/s_key.png'); ?>"></center>
                    </div>
                    <div>
                        <div class="loader" v-if="loading"></div>
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="fbg">
                                    <th width='40%'>PERSONAL SKILLS</th>
                                    <th width='10%'>GRADE</th>
                                    <th width='40%'>WORK HABITS</th>
                                    <th width='10%'>GRADE</th>
                                </tr>
                                <tr>
                                    <td >Consideration for Others</td>
                                    <td> {{ r.cons }} </td>
                                    <td >Works independently</td>
                                    <td>{{ r.ind }} </td>
                                </tr>
                                <tr>
                                    <td >Organization </td>
                                    <td> {{ r.org }}</td>
                                    <td >Completes assignments at school</td>
                                    <td>{{ r.school }}</td>
                                </tr>
                                <tr>
                                    <td >Communication</td>
                                    <td>{{ r.comm }}</td>
                                    <td >Completes homework</td>
                                    <td>{{ r.home }}</td>
                                </tr>
                                <tr>
                                    <td>Respect for School Property</td>
                                    <td>{{ r.property }}</td>
                                    <td>Contribution in Group Work</td>
                                    <td>{{ r.groupw }}</td>
                                </tr>
                                <tr>
                                    <td>Cooperation</td>
                                    <td>{{ r.coop }}</td>
                                    <td> Uses Time Wisely</td>
                                    <td>{{ r.time_ }}</td>
                                </tr>
                                <tr>
                                    <td>Self Confidence</td>
                                    <td>{{ r.conf }}</td>
                                    <td>Class Concentration</td>
                                    <td>{{ r.conce }}</td>
                                </tr>
                                <tr>
                                    <td>Accepts responsibility</td>
                                    <td>{{ r.accept }}</td>
                                    <td>Punctuality</td>
                                    <td>{{ r.punctual }}</td>
                                </tr>
                                <tr>
                                    <td >Self Motivation</td>
                                    <td>{{ r.motivation }}</td>
                                    <td> </td>
                                    <td></td>
                                </tr>

                                <tr class="fbg">
                                    <td class="text-uppercase">English Reading Progress</td>
                                    <td> </td>
                                    <td class="text-uppercase"> Maendeleo na Masomo</td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td>Read Fluently</td>
                                    <td>{{ r.fluent }}</td>
                                    <td> Kusoma kwa Mtiririko</td>
                                    <td>{{ r.mtrr }}</td>
                                </tr>
                                <tr>
                                    <td>Speed</td>
                                    <td>{{ r.speed }}</td>
                                    <td> Kusoma kwa Kasi</td>
                                    <td>{{ r.kasi }}</td>
                                </tr>
                                <tr>
                                    <td>Can Comprehend</td>
                                    <td>{{ r.compr }}</td>
                                    <td> Kusoma na kuelewa</td>
                                    <td>{{ r.klw }}</td>
                                </tr>
                                <tr>
                                    <td>Extensive Reading</td>
                                    <td>{{ r.exte }}</td>
                                    <td> Kusoma kwa Ziada</td>
                                    <td>{{ r.ziada }}</td>
                                </tr>
                                <tr>
                                    <td>Use of Tone Variation</td>
                                    <td>{{ r.tone }}</td>
                                    <td>Mawimbi ya Sauti</td>
                                    <td>{{ r.sauti }}</td>
                                </tr>
                                <tr>
                                    <td>Spellings</td>
                                    <td>{{ r.spell }}</td>
                                    <td>Hijai</td>
                                    <td>{{ r.hj }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <div class="form-group">
                            <div class="col-md-3" for="title">Student's General Conduct </div>
                            <div class="col-md-6">
                                {{ r.remarks }}       
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="foo col-sm-12">
                            <strong><span style="text-decoration:underline; font-size:15px;">Head Teacher's Signature:</span></strong><br>
                            <span class="editable ht254 editable-wrap editable-pre-wrapped editable-click" e-style="width:100%">
                                <img class="pull-right" src="<?php echo base_url('uploads/files/headteacher-signature.jpg'); ?>" width="200" height="80">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
$range = range(date('Y') - 30, date('Y') + 1);
$yrs = array_combine($range, $range);
krsort($yrs);

$y_opt = [];
foreach ($yrs as $k => $v)
{
    $y_opt[] = ['id' => $k, 'text' => $v];
}
$res = [];
foreach ($classes as $s)
{
    $res[] = ['id' => $s->id, 'text' => $s->name];
}
$st = [];
foreach ($students as $key => $name)
{
    $st[] = ['id' => $key, 'name' => $name];
}
$tab = 1;
if ($this->input->get('s'))
{
    $tab = 2;
}
?>
<script>
    var students = <?php echo json_encode($st); ?>;
    var years = <?php echo json_encode($y_opt); ?>;
    var classes = <?php echo json_encode($res); ?>;
    var class_ = <?php echo $class->id; ?>;
    var tabb = <?php echo $tab; ?>;
    const scl = new Vue({
        el: '#assess',
        data: {
            loading: false,
            sub: false,
            tab: tabb,
            class_: class_,
            assigned: classes,
            year: '',
            term: '',
            social: {cons: '', org: '', comm: '', accept: '', ind: '', others: '', school: '', home: '', cs: '', time: '', rev: '',
                property: '',
                groupw: '',
                coop: '',
                time_: '',
                conf: '',
                conce: '',
                punctual: '',
                motivation: '',
                fluent: '',
                mtrr: '',
                speed: '',
                kasi: '',
                compr: '',
                klw: '',
                exte: '',
                ziada: '',
                tone: '',
                sauti: '',
                spell: '',
                hj: '',
                remarks: ''
            },
            options: [{text: 'Exceptional', value: 'A'}, {text: 'Very Good', value: 'B'}, {text: 'Satisfactory', value: 'C'}, {text: 'Needs Improvement', value: 'D'}],
            rec: {student: ''},
            print: {student: ''},
            report: {},
            students: students,
            years: years,
            terms: [{id: 1, text: 'Term 1'}, {id: 2, text: 'Term 2'}, {id: 3, text: 'Term 3'}],
            saved: {strands: [], subs: [], tasks: [], comments: []},
            comments: {},
            pr: {},
            classes: {buttonOk: 'vue-quick-edit__button--ok btn btn-custom btn-xs', buttonCancel: 'vue-quick-edit__button--cancel btn btn-danger btn-xs', input: 'vue-quick-edit__input form-control'}
        },
        components: {multiselect: VueMultiselect.default, 'quick-edit': QuickEdit.default},
        methods: {
            reset()
            {
                this.social = {cons: '', org: '', accept: '', ind: '', others: '', school: '', home: '', cs: '', time: '', rev: ''};
            },
            post_social(e)
            {
                axios.post(BASE_URL + 'trs/cbc/post_social', {class: this.class_, student: this.rec.student, term: this.term, year: this.year, social: this.social})
                        .then(resp => {
                            //this.reset();
                            notify('Report', 'Saved Successfully ');
                        })
                        .catch(error => {
                            console.log(error.response.data);
                            console.log(error.response.status);
                        });
            },
            show_report()
            {
                this.loading = true;
                this.sub = true;
                let $vm = this;
                axios.post(BASE_URL + 'trs/cbc/get_social_report', {class: this.pr.class.id, term: this.pr.term.id, year: this.pr.year.id})
                        .then(resp => {
                            $vm.report = resp.data.results;
                            this.loading = false;
                        })
                        .catch(error => {
                            console.log(error);
                            this.loading = false;
                        });

            },
            pop_assess()
            {
                if (this.rec.student && this.term && this.year)
                {
                    this.loading = true;
                    this.reset();
                    let $vm = this;
                    axios.post(BASE_URL + 'trs/cbc/get_social', {class: this.class_, student: this.rec.student.id, term: this.term.id, year: this.year.id})
                            .then(resp => {
                                $vm.social = resp.data.results;
                                this.loading = false;
                            })
                            .catch(error => {
                                console.log(error);
                                this.loading = false;
                            });
                }
            }
        }
    });
</script>
<style>
    .img-container
    {
        text-align: center;
        display: block;
    }
    .tabs-bordered li.active a, .tabs-bordered li.active a:hover, .tabs-bordered li.active a:focus
    {
        border-bottom: 2px solid #188ae2 !important;
        background: #488ae2 !important;
        margin-bottom: -1px;
        color: #fff;
    }
    .tabs-bordered li a:not(.active)
    {
        border: 2px solid #f3f3f3 !important;
    }
    .loader{
        position: absolute;
        top:0px;
        right:0px;
        width:100%;
        height:100%;
        background-color:#eceaea;
        background-image:url('<?php echo base_url('/assets/ico/loader.gif'); ?>');
        background-size: 50px;
        background-repeat:no-repeat;
        background-position:center;
        z-index:10000000;
        opacity: 0.6;
        filter: alpha(opacity=60);
    }
    .btn-xs{margin-top: 3px;}
    .fbg{background: #f5f6fa; font-weight: bold;}
    .panel .panel-body p { line-height: 14px;}
    .p-10 {padding: 10px !important;}
    .mb-0{margin-bottom: 0;}
    .mb-2{margin-bottom: 5px;}
    .underline{text-decoration: underline;}
    hr {
        margin-top: 2px !important;
        margin-bottom: 2px !important;
    }
    @media print{
        .page-break{page-break-after: always; }
        .page-break:last-child {  page-break-after: avoid; }
    }
</style>