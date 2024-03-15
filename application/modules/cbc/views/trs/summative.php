<?php $avt = strtolower(substr($this->user->first_name, 0, 1)); ?>

<div id="assess" class="card-box bg-white" v-cloak>
    <div class="row">
        <div class="col-md-11 hidden-print">
            <h4 class="text-uppercase">Summative Report: &nbsp; &nbsp; &nbsp; <?php echo $class->name ?></h4>
        </div>
        <div class="col-md-1 hidden-print">
            <a href="<?php echo base_url('trs/cbc'); ?>" class="pull-right btn btn-primary"><i class="mdi mdi-reply"></i> Back</a>
        </div>
        <div class="clearfix"></div>

        <div class="card"> 
            <h3 class="m-t-0 header-title text-custom text-center hidden-print"><ins>PRINT REPORT</ins></h3>

            <form class="form-horizontal form-main p-10 hidden-print">
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label class="control-label">Class</label>
                        <multiselect placeholder="Select Class" v-model="pr.class" :options="assigned" track-by="id" label="text" :searchable="true" :reset-after="false"></multiselect>
                    </div>
                    <div class="col-sm-2">
                        <label class=" control-label">Term:</label>
                        <multiselect placeholder="Term" v-model="pr.term" :options="terms" track-by="id" label="text" :searchable="true" :reset-after="false"></multiselect>
                    </div>
                    <div class="col-sm-3">
                        <label class="control-label">Year:</label>
                        <multiselect placeholder="Year" v-model="pr.year" :options="years" track-by="id" label="text" :searchable="true" :reset-after="false"></multiselect>
                    </div>                    

                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Rating Option</label>
                            <div class="form-control row">
                                <div class="col-md-6">
                                    <input type="radio" id="mn" name="format" v-model="pr.option" value="1" class="custom-control-input">
                                    <label class="custom-control-label" for="mn">1 - 4</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" id="abbr" name="format" v-model="pr.option" value="2" class="custom-control-input">
                                    <label class="custom-control-label" for="abbr">EE, ME,AE ,BE </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3"><br>
                        <button type="button" class="btn btn-info btn-lg" :disabled="!pr.class || !pr.term || !pr.year" @click='show_report()'><i class="mdi mdi-check"></i> Submit</button>
                        <a class="btn btn-info btn-lg" v-if="sub" @click="window.print(); return false"><i class="mdi mdi-printer"></i> Print</a>
                    </div>  
                </div>
                <p class="text-center"> <img :src="loader_path()" v-if="loading"></p>
            </form>
            <div class="alert alert-danger alert-icon text-center" v-if="pos">
                <em class="mdi mdi-alert-octagon"></em> <strong>&nbsp;</strong>No data found. 
            </div>
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
            <div class="row page-break" v-for="r in report">
                <div class="img-container">
                    <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" style="width:128px;" alt="header">
                </div>
                <div class="text-center">
                    <h4><strong>SUMMATIVE REPORT</strong></h4>
                    <h4 class="text-uppercase"><ins>NAME:</ins>  {{ r.student }}  &nbsp;&nbsp;&nbsp;<ins>ADM.</ins> &nbsp;&nbsp;&nbsp; {{ r.meta.adm }} &nbsp;&nbsp;&nbsp; <ins>Age:</ins> {{ r.meta.age }}</h4>
                    <p>
                        <span class="text-uppercase"><?php echo $class->name ?> {{ pr.term.text }} - {{ pr.year.text }}</span>
                    </p>
                </div>

                <div class="clearfix"></div>
                <hr>
                <div class="">
                    <center><img src="<?php echo base_url('/uploads/files/key.png'); ?>"></center>
                </div>
                <div>
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="fbg">
                                <td>#</td>
                                <td class="text-uppercase">SUBJECT</td>
                                <td>Opener Exam </td>
                                <td> Mid Term</td>
                                <td>End of Term </td>
                                <td> Term Average</td>
                            </tr>                           
                            <tr v-for="(f, index) in r.assess">
                                <td>{{ index+1 }}.</td>
                                <td class="text-uppercase">{{ f.subject }}</td>
                                <td>{{ f.exams.exam_1 }} </td>
                                <td>{{ f.exams.exam_2 }} </td>
                                <td>{{ f.exams.exam_3 }} </td>
                                <td>{{ f.exams.exam_4 }} </td>
                            </tr>                           

                        </tbody>
                    </table>
                    <hr>
                    <div class="form-group fl">
                        <label>GENERAL REMARKS ON SUMMATIVE ASSESMENT</label>
                        {{ r.meta.gen_remarks }}
                    </div>
                    <hr>
                    <div class="form-group fl">
                        <label>Class teacher’s comments:</label>
                        {{  r.meta.tr_remarks }}
                    </div>
                    <hr>
                    <table class="table  m_0">
                        <tbody>
                            <tr>
                                <th>&nbsp;</th>
                                <td>Head teacher’s signature:</td>
                                <td>
                                    <span class="">
                                        <img src="<?php echo base_url('uploads/headteacher-signature.png'); ?>" width="100" height="80">
                                    </span>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6"><span class="pull-right">Closing Date:</span></div>
                                        <div class="col-md-6">{{ r.meta.closing }}</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <td>Parent’s signature:</td>
                                <td>&nbsp; </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6"><span class="pull-right">Opening Date:</span></div>
                                        <div class="col-md-6"> {{ r.meta.opening }}</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>                    
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
?>
<script>
    var students = <?php echo json_encode($st); ?>;
    var years = <?php echo json_encode($y_opt); ?>;
    var classes = <?php echo json_encode($res); ?>;
    var class_ = <?php echo json_encode(['id' => $class->id, 'text' => $class->name]); ?>;
    const scl = new Vue({
        el: '#assess',
        data: {
            loading: false,
            sub: false,
            pos: false,
            assigned: classes,
            year: '',
            term: '',
            report: {},
            students: students,
            years: years,
            terms: [{id: 1, text: 'Term 1'}, {id: 2, text: 'Term 2'}, {id: 3, text: 'Term 3'}],
            pr: {class: class_, option: 2}
        },
        components: {multiselect: VueMultiselect.default},
        methods: {
            show_report()
            {
                this.loading = true;
                this.sub = true;
                this.pos = false;
                let $vm = this;
                axios.post(BASE_URL + 'trs/cbc/get_summ_report', {class: this.pr.class.id, term: this.pr.term.id, year: this.pr.year.id, option: this.pr.option})
                        .then(resp => {
                            $vm.report = resp.data.results;
                            this.loading = false;
                            this.pos = (resp.data.results.length) ? false : true;

                        })
                        .catch(error => {
                            console.log(error);
                            this.loading = false;
                        });
            },
            loader_path()
            {
                return BASE_URL + 'assets/ico/loader.gif';
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
    .btn-xs{margin-top: 3px;}
    .fbg{background: #f5f6fa; font-weight: bold;}
    .panel .panel-body p { line-height: 14px;}
    .p-10 {padding: 10px !important;}
    .mb-0{margin-bottom: 0;}
    .mb-2{margin-bottom: 5px;}
    .underline{text-decoration: underline;}
    .fl{margin-left:8px;}
    @media print{
        .page-break{page-break-after: always; }
        .page-break:last-child {  page-break-after: avoid; }
    }

</style>