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

<div id="assess" class="card-block card-x" v-cloak>
    <div class="row">

        <div class="col-md-11 hidden-print">
            <h4 class="text-uppercase">Assessment Report: &nbsp; &nbsp; &nbsp; <?php echo $class->name ?></h4>

        </div>
        <div class="col-md-1 hidden-print">
            <a href="<?php echo base_url('trs/cbc'); ?>" class="pull-right btn btn-primary"><i class="mdi mdi-reply"></i> Back</a>
        </div>

        <hr class="hidden-print">
        <div class="col-md-1"></div>
        <div class="card-x col-md-10">

            <h3 class="m-t-0 header-title text-custom text-center hidden-print"><ins>PRINT REPORT</ins></h3>
            <form class="form-horizontal form-main p-10 hidden-print">
                <div class="form-group row">
                    <div class="col-sm-3">
                        Class: <br>
                        <div>
                            <multiselect placeholder="Select Class" v-model="pr.class" :options="assigned" track-by="id" label="text" :searchable="true" :reset-after="false"></multiselect>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        Learning Area: <br>
                        <div>
                            <multiselect placeholder="Select" v-model="pr.subject" :options="subjects" track-by="id" label="text" :searchable="true" :reset-after="false"></multiselect>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        Term:<br>
                        <div>
                            <multiselect placeholder="Term" v-model="pr.term" :options="terms" track-by="id" label="text" :searchable="true" :reset-after="false"></multiselect>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        Year:<br>
                        <div>
                            <multiselect placeholder="Year" v-model="pr.year" :options="years" track-by="id" label="text" :searchable="true" :reset-after="false"></multiselect>
                        </div>
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

                    <div class="col-md-3"> <img :src="loader_path()" v-if="loading"></div>
                </div>
                <div class="form-group row">
                    <div class="offset-md-3 col-sm-4">
                        &nbsp;
                    </div>
                    <div class="offset-md-3 col-sm-4">
                        <br>
                        <button type="button" class="btn btn-info btn-lg" :disabled="!pr.class || !pr.subject || !pr.term || !pr.year" @click='show_report()'><i class="mdi mdi-check"></i> Submit</button>
                        <a class="btn btn-info btn-lg" v-if="sub" @click="window.print(); return false"><i class="mdi mdi-printer"></i> Print</a>

                    </div>
                </div>
            </form>

            <div class="clearfix"></div>
            <div class="card-box" v-if="!pr.class || !pr.subject || !pr.term || !pr.year">
                <div class="card">
                    <div class="card-body">
                        <div class="padding-xl">
                            <h4 class="card-title text-pink"> Please Select Subject, Term, Year & Class</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row page-break" v-for="r in assess">
                <div class="img-container">
                    <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" style="width:128px;" alt="header">
                </div>
                <div class="text-center">
                    <h4><strong>ASSESSMENT REPORT</strong></h4>
                    <h4 class="text-uppercase"><ins>NAME:</ins>  {{ r.student }}  &nbsp;&nbsp;&nbsp;<ins>ADM.</ins> &nbsp;&nbsp;&nbsp; {{ r.adm }} &nbsp;&nbsp;&nbsp; <ins>Age:</ins> {{ r.age }}</h4>
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
                        <template v-for="(strand, index) in r.strands">
                            <tr class="fbg">
                                <td>{{ index+1 }}.0 </td>
                                <td class="text-uppercase">{{ strand.name }}</td>
                                <td width="8%" class="text-center"><strong>{{ strand.rating }}</strong></td>
                                <td width='30%'><span v-if="index==0">Teacher Comments</span></td>
                            </tr>
                            <template v-for="(sub, sx) in strand.subs">
                                <tr>
                                    <td :class="{ 'fbg': sub.tasks.length}">{{ index+1 }}.{{ sx+1 }}</td>
                                    <td :class="{ 'fbg': sub.tasks.length}"><strong>{{ sub.name }} </strong></td>
                                    <td :class="{ 'fbg': sub.tasks.length}" class="text-center">
                                        {{ sub.rating }}
                                    </td>
                                    <td :class="{ 'fbg': sub.tasks.length}" v-if="sx!=0"></td>
                                    <td v-if="sx==0" :rowspan="((sub.tasks.length)+1)"> {{ sub.remarks }}</td>
                                </tr>
                                <tr v-for="(t, tx) in sub.tasks" >
                                    <td> </td>
                                    <td>{{ t.task }}</td>
                                    <td v-if="sx==0" class="text-center">{{ t.rating }}</td>
                                    <td v-if="sx!=0" class="text-center">{{ t.rating }}</td>
                                    <td v-if="sx!=0 && tx==0" :rowspan="(sub.tasks.length)">
                                        {{ sub.remarks }}
                                    </td>
                                </tr>
                            </template>
                        </template>
                        </tbody>
                    </table>
                    <hr>
                    <div class="foo col-sm-12">
                        <strong><span style="text-decoration:underline; font-size:15px;">Head Teacher's Comment:</span></strong><br>
                        <span class="editable ht254 editable-wrap editable-pre-wrapped editable-click" e-style="width:100%">
                            <img class="pull-right" src="<?php echo base_url('uploads/headteacher-signature.png'); ?>" width="200" height="80">
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-1"></div>

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
$la_s = [];
foreach ($subjects as $s)
{
    $la_s[] = ['id' => $s->subject, 'text' => $s->name];
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
    var subjects = <?php echo json_encode($la_s); ?>;
    var class_ = <?php echo json_encode(['id' => $class->id, 'text' => $class->name]); ?>;
    const scl = new Vue({
        el: '#assess',
        data: {
            loading: false,
            sub: false,
            assigned: classes,
            subjects: subjects,
            year: '',
            term: '',
            assess: [],
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
                let $vm = this;
                axios.post(BASE_URL + 'trs/cbc/get_assess_report', {class: this.pr.class.id, subject: this.pr.subject.id, term: this.pr.term.id, year: this.pr.year.id, option: this.pr.option})
                        .then(response => {
                            $vm.assess = response.data.results;
                            this.loading = false;
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
    @media print{
        .page-break{page-break-after: always; }
        .page-break:last-child {  page-break-after: avoid; }
    }
    table.table-bordered th:last-child, table.table-bordered td:last-child { border-right-width: 1px;}
</style>