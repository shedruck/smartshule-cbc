<?php $avt = strtolower(substr($this->user->first_name, 0, 1)); ?>
<div id="assess" v-cloak>
    <div class="row hidden-print m-b-30">
        <div class="card card-bordered card-full">
            <div class="card-inner-group">
                <div class="card-inner border-bottom border-info">
                    <div class="card-title-group row">

                        <div class="col-md-6">
                            <h4 class="text-uppercase"> &nbsp; &nbsp; <?php echo $class->name ?></h4>
                        </div>
                        <div class="col-md-6">
                            <a href="<?php echo base_url('trs/cbc'); ?>" class="pull-right btn btn-primary"><i class="mdi mdi-reply"></i> Back</a>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="card-inner card-inner-md hidden-print">
                    <div class="row m-b-0">
                        <div class="col-md-4">
                            <div class="rows">Student:
                                <multiselect placeholder="Student" v-model="summ.student" :options="students" track-by="id" label="name" :searchable="true" :reset-after="false" @input="load_res()"></multiselect>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="rows">Term:
                                <multiselect placeholder="Term" v-model="summ.term" :options="terms" track-by="id" label="text" :searchable="true" :reset-after="false" @input="load_res()"></multiselect>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="rows">Year:
                                <multiselect placeholder="Year" v-model="summ.year" :options="years" track-by="id" label="text" :searchable="true" :reset-after="false" @input="load_res()"></multiselect>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="rows">Exam:
                                <multiselect placeholder="Exam" v-model="summ.exam" :options="exams" track-by="id" label="name" :searchable="true" :reset-after="false" @input="load_res()"></multiselect>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center"><img :src="loader_path()" v-if="loading"></div>
    <hr>
    <div class="clearfix"></div>
    <div class="card-box" v-if="!summ.student || !summ.term || !summ.year || !summ.exam">
        <div class="card">
            <div class="card-body">
                <div class="padding-xl">
                    <h4 class="card-title text-pink"> Please Select Term, Year, Exam & Student</h4>
                </div>
            </div>
        </div>
    </div>
    <template v-if="summ.student && summ.term && summ.year && summ.year && summ.exam">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="text-uppercase"><ins>NAME:</ins> {{ summ.student.name }} &nbsp;&nbsp;&nbsp;<ins>ADM.</ins> &nbsp;&nbsp;&nbsp; {{ summ.student.adm }} &nbsp;&nbsp;&nbsp; <ins>Age:</ins> {{ summ.student.age }}</h4>
            </div>
            <div class="col-sm-12">
                <h4 class="text-uppercase"><?php echo $class->name ?> &nbsp;&nbsp;&nbsp; {{ summ.term.text }} - {{ summ.year.text }}</h4>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <table class="table table-bordered">
            <tbody>
                <tr class="fbg">
                    <td colspan="2"></td>
                    <td colspan="5" class="text-uppercase text-center">{{ summ.exam.name }}</td>
                </tr>

                <tr class="fbg">
                    <td colspan="2"></td>
                    <td colspan="4" class="text-uppercase text-center"> Rate</td>
                </tr>
                <tr class="fbg">
                    <td>#</td>
                    <td class="text-uppercase">Learning Area</td>
                    <td> <strong>EE</strong> - 4</td>
                    <td> <strong>ME</strong> - 3</td>
                    <td> <strong>AE</strong> - 2</td>
                    <td> <strong>BE</strong> - 1</td>
                </tr>
                <tr v-for="(s, index) in assess">
                    <td>{{ index+1 }}</td>
                    <td> {{ s.name }}</td>
                    <td class="fbg">
                        <span class="d-flex" title="4">
                            <input class="m-control" :id="'s_4'+s.id" :name="'ts_'+s.id" v-model='s.rate' type="radio" value="4">
                            <label class="m-label" :for="'s_4'+s.id">
                                <span class="pm-name">&nbsp;</span>
                                <span class="pm-icon"> </span>
                            </label>
                        </span>
                    </td>
                    <td class="fbg">
                        <span class="d-flex" title="3">
                            <input class="m-control" :id="'s_3'+s.id" :name="'ts_'+s.id" v-model='s.rate' type="radio" value="3">
                            <label class="m-label" :for="'s_3'+s.id">
                                <span class="pm-name">&nbsp;</span>
                                <span class="pm-icon"> </span>
                            </label>
                        </span>
                    </td>
                    <td class="fbg">
                        <span class="d-flex" title="2">
                            <input class="m-control" :id="'s_2'+s.id" :name="'ts_'+s.id" v-model='s.rate' type="radio" value="2">
                            <label class="m-label" :for="'s_2'+s.id">
                                <span class="pm-name">&nbsp;</span>
                                <span class="pm-icon"> </span>
                            </label>
                        </span>
                    </td>
                    <td class="fbg">
                        <span class="d-flex" title="1">
                            <input class="m-control" :id="'s_1'+s.id" :name="'ts_'+s.id" v-model='s.rate' type="radio" value="1">
                            <label class="m-label" :for="'s_1'+s.id">
                                <span class="pm-name">&nbsp;</span>
                                <span class="pm-icon"> </span>
                            </label>
                        </span>
                    </td>

                </tr>
            </tbody>
        </table>
        <div class="v-actions text-center">
            <button type="button" class="btn btn-primary btn-lg" @click="post_summ()"> <span>Save Assessment</span> <em class="mdi mdi-arrow-right"></em></button> <img :src="loader_path()" v-if="loading">
        </div>
        <div class="">
            <hr>
            <div class="form-group">
                <label>GENERAL REMARKS ON SUMMATIVE ASSESMENT</label>
                <quick-edit type="textarea" :classes='classes' v-model="summ.gen_remarks" @input='post_rmk($event,1)'></quick-edit>
            </div>
            <hr>
            <div class="form-group">
                <label>Class teacher’s comments:</label>
                <quick-edit type="textarea" :classes='classes' v-model="summ.tr_remarks" @input='post_rmk($event,2)'></quick-edit>
            </div>
            <hr>
            <table class="table m_0">
                <tbody>
                    <tr>
                        <th>&nbsp;</th>
                        <td>
                            <div class="row">
                                <div class="col-md-6"><span class="pull-right">Closing Date:</span></div>
                                <div class="col-md-6"><quick-edit type="text" :classes='classes' v-model="summ.closing" @input='post_rmk($event,3)'></quick-edit></div>
                            </div>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-md-6"><span class="pull-right">Opening Date:</span></div>
                                <div class="col-md-6"><quick-edit type="text" :classes='classes' v-model="summ.opening" @input='post_rmk($event,4)'></quick-edit></div>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </template>
</div>
<?php
$range = range(date('Y') - 30, date('Y') + 1);
$yrs = array_combine($range, $range);
krsort($yrs);

$y_opt = [];
foreach ($yrs as $k => $v) {
    $y_opt[] = ['id' => $k, 'text' => $v];
}
$res = [];
foreach ($subjects as $s) {
    $res[] = ['id' => $s->subject, 'text' => $s->name];
}
$st = [];
foreach ($students as $key => $name) {
    $st[] = ['id' => $key, 'name' => $name];
}
?>
<script>
    var students = <?php echo json_encode($st); ?>;
    var subjects = <?php echo json_encode($res); ?>;
    var exams = <?php echo json_encode($exams); ?>;
    var years = <?php echo json_encode($y_opt); ?>;
    var class_ = <?php echo $class->id; ?>;
    Vue.use(VueToast, {
        position: 'bottom-right',
        pauseOnHover: true,
        duration: 6000
    });
    const tsk = new Vue({
        el: '#assess',
        data: {
            url: BASE_URL,
            loading: false,
            class_: class_,
            summ: {
                report: [],
                student: '',
                term: '',
                year: '',
                exam: '',
                gen_remarks: '',
                tr_remarks: ''
            },
            subjects: subjects,
            exams: exams,
            students: students,
            years: years,
            assess: [],
            terms: [{
                id: 1,
                text: 'Term 1'
            }, {
                id: 2,
                text: 'Term 2'
            }, {
                id: 3,
                text: 'Term 3'
            }],
            classes: {
                buttonOk: 'vue-quick-edit__button--ok btn btn-custom btn-xs',
                buttonCancel: 'vue-quick-edit__button--cancel btn btn-danger btn-xs',
                input: 'vue-quick-edit__input form-control'
            }
        },
        components: {
            multiselect: VueMultiselect.default,
            'quick-edit': QuickEdit.default
        },
        methods: {
            loader_path() {
                return BASE_URL + 'assets/ico/loader.gif';
            },
            load_res() {
                let $vm = this;
                if (this.summ.student && this.summ.term && this.summ.year && this.summ.exam) {
                    this.loading = true;
                    axios.post(BASE_URL + 'trs/cbc/get_summ', {
                            class: this.class_,
                            student: this.summ.student.id,
                            term: this.summ.term.id,
                            year: this.summ.year.id,
                            exam: this.summ.exam.id
                        })
                        .then(resp => {
                            this.assess = resp.data.results;
                            $vm.summ.gen_remarks = resp.data.gen_remarks;
                            $vm.summ.tr_remarks = resp.data.tr_remarks;
                            $vm.summ.opening = resp.data.opening;
                            $vm.summ.closing = resp.data.closing;
                            $vm.summ.student.adm = resp.data.student.adm;
                            $vm.summ.student.age = resp.data.student.age;
                            this.loading = false;
                        })
                        .catch(error => {
                            console.log(error.response);
                            this.loading = false;
                        });
                }
            },
            post_summ() {
                this.loading = true;
                axios.post(BASE_URL + 'trs/cbc/post_summ', {
                        class: this.class_,
                        student: this.summ.student.id,
                        term: this.summ.term.id,
                        year: this.summ.year.id,
                        exam: this.summ.exam.id,
                        assess: this.assess
                    })
                    .then(resp => {
                        //logged_in check
                        if (!resp.data.hasOwnProperty('message')) {
                            window.location.reload();
                        }
                        this.$toast.success('Saved successfully!'); //resp.message
                        this.loading = false;
                    })
                    .catch(error => {
                        console.log(error.response);
                        this.loading = false;
                    });
            },
            post_rmk(remarks, cat) {
                this.loading = true;
                axios.post(BASE_URL + 'trs/cbc/post_summ_remarks', {
                        class: this.class_,
                        student: this.summ.student,
                        term: this.summ.term,
                        year: this.summ.year,
                        remarks: remarks,
                        cat: cat
                    })
                    .then(resp => {
                        //logged_in check
                        if (!resp.data.hasOwnProperty('message')) {
                            window.location.reload();
                        }
                        this.$toast.success('Saved successfully!');
                        this.loading = false;
                    })
                    .catch(error => {
                        console.log(error.response.data);
                        console.log(error.response.status);
                    });
            },
        }
    });
</script>
<style scoped>
    .fbg {
        background: #f5f6fa;
        font-weight: bold;
    }

    .form-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #344357;
        margin-bottom: .5rem;
    }

    .form-label-group {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .5rem;
    }

    .form-label-group .form-label {
        margin-bottom: 0;
    }

    .form-group {
        position: relative;
        margin-bottom: 1.25rem;
    }

    label {
        cursor: pointer;
    }

    input[type="radio"]:checked~label {
        cursor: default;
    }

    .mt {
        font-family: "Material Design Icons" !important;
        speak: none;
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .m-list {
        border: 1px solid #dbdfea;
        background: #fff;
        border-radius: 4px;
    }

    .m-item {
        position: relative;
    }

    .m-item:not(:last-child) {
        border-bottom: 1px solid #e5e9f2;
    }

    .m-label {
        position: relative;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0;
        padding: 6px 10px 6px 20px;
        cursor: pointer;
    }

    .m-label:before,
    .m-label:after {
        position: absolute;
        top: 50%;
        left: 8px;
        transform: translateY(-50%);
        height: 24px;
        width: 24px;
        border-radius: 50%;
    }

    .m-label:before {
        content: '';
        border: 2px solid #dbdfea;
    }

    .m-label:after {
        font-family: "Material Design Icons";
        content: "\F12C";
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: #6576ff;
        transition: opacity .3s;
        opacity: 0;
    }

    .m-label .pm-name {
        font-size: 14px;
        color: #364a63;
    }

    .m-label .pm-icon {
        display: inline-flex;
        font-size: 24px;
        color: #8094ae;
    }

    .m-control {
        height: 1px;
        width: 1px;
        opacity: 0;
    }

    .m-control:checked~.m-label {
        cursor: default;
    }

    .m-control:checked~.m-label:after {
        opacity: 1;
    }

    .v-actions .btn-primary {
        color: #fff;
        background-color: #6576ff !important;
        border-color: #6576ff !important;
    }
</style>