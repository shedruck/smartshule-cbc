<?php $avt = strtolower(substr($this->user->first_name, 0, 1)); ?>
<div id="assess" v-cloak>
    <div class="row hidden-print">
        <div class="col-md-11 hidden-print">

        </div>
        <div class="col-md-1 hidden-print">

        </div>
    </div>
    <div class="row hidden-print m-b-30">
        <div class="card card-bordered card-full">
            <div class="card-inner-group">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h4 class="text-uppercase">  &nbsp; &nbsp; <?php echo $class->name ?></h4>
                        </div>
                        <div class="card-tools">
                            <a href="<?php echo base_url('trs/cbc'); ?>" class="pull-right btn btn-primary"><i class="mdi mdi-reply"></i> Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-inner card-inner-md hidden-print">
                    <div class="row m-b-0">
                        <div class="col-md-4">
                            <div class="rows">Student:
                                <multiselect placeholder="Student" v-model="rec.student" :options="students" track-by="id" label="name" :searchable="true" :reset-after="false" @input="pop_assess()"></multiselect>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="rows">Term:
                                <multiselect placeholder="Term" v-model="term" :options="terms" track-by="id" label="text" :searchable="true" :reset-after="false" @input="pop_assess()"></multiselect>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="rows">Year:
                                <multiselect placeholder="Year" v-model="year" :options="years" track-by="id" label="text" :searchable="true" :reset-after="false" @input="pop_assess()"></multiselect>
                            </div>
                        </div>
                    </div>
                    <template v-if="rec.student && term && year">
                        <hr >
                        <div class="row">
                            <div class="col-md-4">
                                <div class="rows">Learning Area:
                                    <multiselect placeholder="Subject" v-model="subject" :options="subjects" track-by="id" label="text" :searchable="true" :reset-after="false" @input="update_assess($event)"></multiselect>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="rows">Strand:
                                    <multiselect placeholder="Strand" v-model="strand" :options="strands" track-by="id" label="name" :searchable="true" :reset-after="false" @input="update_subs($event)"></multiselect>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="rows">Sub Strand:
                                    <multiselect placeholder="Sub Strand" v-model="sub_strand" :options="sub_strands" track-by="id" label="name" :searchable="true" :reset-after="false" @input="filter_sub($event)"></multiselect>
                                </div>
                            </div>
                            <div class="col-md-2 p-t-10"> <img :src="loader_path()" v-if="loading"></div>
                        </div>
                    </template>                    
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="clearfix"></div>

        <div v-if='tab==1'>
            <div class="clearfix"></div>
            <div class="card-box" v-if="!subject || !term || !year || !rec.student">
                <div class="card">
                    <div class="card-body">
                        <div class="padding-xl">
                            <h4 class="card-title text-danger"> Please Select Term, Year & Subject</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <hr>
            <div class="row" v-if="assess.length">
                <div class="accordion">
                    <div class="panel panel-default">
                        <template>
                            <div class="rt-">
                                <div class="col-sm-5 col-md-5  col-xs-5">
                                    <h3 class="text-uppercase">NAME:  {{ rec.student.name }} </h3>
                                    <h3 class="text-uppercase"><?php echo $class->name ?> </h3>
                                </div>                   
                                <div class="col-sm-6 col-md-6  col-xs-6">
                                    <h3 class="text-uppercase">{{ subject.text }} <br>{{ term.text }} - {{ year.text }}</h3>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                            <div class="">
                                <center><img src="<?php echo base_url('/uploads/files/key.png'); ?>"></center>
                            </div>
                        </template>
                        <div class="panel-body pa-15" style="position:relative;">
                            <div class="loader" v-if="loading"></div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td width='5%'> #</td>
                                        <td width='50%'> &nbsp;</td>
                                        <td> <strong>EE</strong> - 4</td>
                                        <td> <strong>ME</strong> - 3</td>
                                        <td> <strong>AE</strong> - 2</td>
                                        <td> <strong>BE</strong> - 1</td>
                                        <td width='24%'> <strong>Teacher Comments</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fbg"> </td>
                                        <td class="fbg"><strong>{{ strand.name }} </strong></td>
                                        <td class="fbg">
                                            <span class="d-flex" title="4">
                                                <input class="m-control" :id="'r_4'+strand.id" :name="'rs_'+strand.id" v-model='st_rating' type="radio" value="4">
                                                <label class="m-label" :for="'r_4'+strand.id">
                                                    <span class="pm-name">&nbsp;</span>
                                                    <span class="pm-icon"> </span>
                                                </label>
                                            </span>
                                        </td>
                                        <td class="fbg">
                                            <span class="d-flex" title="3">
                                                <input class="m-control" :id="'r_3'+strand.id" :name="'rs_'+strand.id" v-model='st_rating' type="radio" value="3">
                                                <label class="m-label" :for="'r_3'+strand.id">
                                                    <span class="pm-name">&nbsp;</span>
                                                    <span class="pm-icon"> </span>
                                                </label>
                                            </span>
                                        </td>
                                        <td class="fbg">
                                            <span class="d-flex" title="2">
                                                <input class="m-control" :id="'r_2'+strand.id" :name="'rs_'+strand.id" v-model='st_rating' type="radio" value="2">
                                                <label class="m-label" :for="'r_2'+strand.id">
                                                    <span class="pm-name">&nbsp;</span>
                                                    <span class="pm-icon"> </span>
                                                </label>
                                            </span>
                                        </td>
                                        <td class="fbg">
                                            <span class="d-flex" title="1">
                                                <input class="m-control" :id="'r_1'+strand.id" :name="'rs_'+strand.id" v-model='st_rating' type="radio" value="1">
                                                <label class="m-label" :for="'r_1'+strand.id">
                                                    <span class="pm-name">&nbsp;</span>
                                                    <span class="pm-icon"> </span>
                                                </label>
                                            </span>
                                        </td>                                            
                                        <td class="fbg"></td>                                         
                                    </tr>
                                <template v-for="(sub, sx) in assess">
                                    <tr>
                                        <td :class="{ 'fbg': sub.tasks.length}"> {{ sx+1 }}.</td>
                                        <td :class="{ 'fbg': sub.tasks.length}"><strong>{{ sub.name }} </strong></td>
                                        <td :class="{ 'fbg': sub.tasks.length}">
                                            <span class="d-flex" title="4">
                                                <input class="m-control" :id="'s_4'+sub.id" :name="'sb_'+sub.id" v-model='sub.rate' type="radio" value="4">
                                                <label class="m-label" :for="'s_4'+sub.id">
                                                    <span class="pm-name">&nbsp;</span>
                                                    <span class="pm-icon"> </span>
                                                </label>
                                            </span>
                                        </td>
                                        <td :class="{ 'fbg': sub.tasks.length}">
                                            <span class="d-flex" title="3">
                                                <input class="m-control" :id="'s_3'+sub.id" :name="'sb_'+sub.id" v-model='sub.rate' type="radio" value="3">
                                                <label class="m-label" :for="'s_3'+sub.id">
                                                    <span class="pm-name">&nbsp;</span>
                                                    <span class="pm-icon"> </span>
                                                </label>
                                            </span>
                                        </td>
                                        <td :class="{ 'fbg': sub.tasks.length}">
                                            <span class="d-flex" title="2">
                                                <input class="m-control" :id="'s_2'+sub.id" :name="'sb_'+sub.id" v-model='sub.rate' type="radio" value="2">
                                                <label class="m-label" :for="'s_2'+sub.id">
                                                    <span class="pm-name">&nbsp;</span>
                                                    <span class="pm-icon"> </span>
                                                </label>
                                            </span>
                                        </td>
                                        <td :class="{ 'fbg': sub.tasks.length}">
                                            <span class="d-flex" title="1">
                                                <input class="m-control" :id="'s_1'+sub.id" :name="'sb_'+sub.id" v-model='sub.rate' type="radio" value="1">
                                                <label class="m-label" :for="'s_1'+sub.id">
                                                    <span class="pm-name">&nbsp;</span>
                                                    <span class="pm-icon"> </span>
                                                </label>
                                            </span>
                                        </td>                                            
                                        <td :class="{ 'fbg': sub.tasks.length}" v-if="sx!=0"></td>
                                        <td v-if="sx==0" :rowspan="((sub.tasks.length)+1)">
                                    <quick-edit type="textarea" :classes='classes' v-model='sub.remarks' @input='remark($event, sub.id)'></quick-edit>
                                    </td>
                                    </tr>
                                    <tr v-for="(t, tx) in sub.tasks" v-if="t.check">
                                        <td> </td>
                                        <td>{{ t.name }}</td>
                                    <template v-if="sx==0">
                                        <td :class="{ 'fbg': sub.tasks.length}">
                                            <span class="d-flex" title="4">
                                                <input class="m-control" :id="'t_4'+t.id" :name="'ts_'+t.id" v-model='t.rate' type="radio" value="4">
                                                <label class="m-label" :for="'t_4'+t.id">
                                                    <span class="pm-name">&nbsp;</span>
                                                    <span class="pm-icon"> </span>
                                                </label>
                                            </span>
                                        </td>
                                        <td :class="{ 'fbg': sub.tasks.length}">
                                            <span class="d-flex" title="3">
                                                <input class="m-control" :id="'t_3'+t.id" :name="'ts_'+t.id" v-model='t.rate' type="radio" value="3">
                                                <label class="m-label" :for="'t_3'+t.id">
                                                    <span class="pm-name">&nbsp;</span>
                                                    <span class="pm-icon"> </span>
                                                </label>
                                            </span>
                                        </td>
                                        <td :class="{ 'fbg': sub.tasks.length}">
                                            <span class="d-flex" title="2">
                                                <input class="m-control" :id="'t_2'+t.id" :name="'ts_'+t.id" v-model='t.rate' type="radio" value="2">
                                                <label class="m-label" :for="'t_2'+t.id">
                                                    <span class="pm-name">&nbsp;</span>
                                                    <span class="pm-icon"> </span>
                                                </label>
                                            </span>
                                        </td>
                                        <td :class="{ 'fbg': sub.tasks.length}">
                                            <span class="d-flex" title="1">
                                                <input class="m-control" :id="'t_1'+t.id" :name="'ts_'+t.id" v-model='t.rate' type="radio" value="1">
                                                <label class="m-label" :for="'t_1'+t.id">
                                                    <span class="pm-name">&nbsp;</span>
                                                    <span class="pm-icon"> </span>
                                                </label>
                                            </span>
                                        </td>
                                    </template>
                                    <template v-if="sx!=0">
                                        <td :class="{ 'fbg': sub.tasks.length}">
                                            <span class="d-flex" title="4">
                                                <input class="m-control" :id="'t_4'+t.id" :name="'ts_'+t.id" v-model='t.rate' type="radio" value="4">
                                                <label class="m-label" :for="'t_4'+t.id">
                                                    <span class="pm-name">&nbsp;</span>
                                                    <span class="pm-icon"> </span>
                                                </label>
                                            </span>
                                        </td>
                                        <td :class="{ 'fbg': sub.tasks.length}">
                                            <span class="d-flex" title="3">
                                                <input class="m-control" :id="'t_3'+t.id" :name="'ts_'+t.id" v-model='t.rate' type="radio" value="3">
                                                <label class="m-label" :for="'t_3'+t.id">
                                                    <span class="pm-name">&nbsp;</span>
                                                    <span class="pm-icon"> </span>
                                                </label>
                                            </span>
                                        </td>
                                        <td :class="{ 'fbg': sub.tasks.length}">
                                            <span class="d-flex" title="2">
                                                <input class="m-control" :id="'t_2'+t.id" :name="'ts_'+t.id" v-model='t.rate' type="radio" value="2">
                                                <label class="m-label" :for="'t_2'+t.id">
                                                    <span class="pm-name">&nbsp;</span>
                                                    <span class="pm-icon"> </span>
                                                </label>
                                            </span>
                                        </td>
                                        <td :class="{ 'fbg': sub.tasks.length}">
                                            <span class="d-flex" title="1">
                                                <input class="m-control" :id="'t_1'+t.id" :name="'ts_'+t.id" v-model='t.rate' type="radio" value="1">
                                                <label class="m-label" :for="'t_1'+t.id">
                                                    <span class="pm-name">&nbsp;</span>
                                                    <span class="pm-icon"> </span>
                                                </label>
                                            </span>
                                        </td>
                                    </template>                                    
                                    <td v-if="sx!=0 && tx==0" :rowspan="(sub.tasks.length)">
                                    <quick-edit type="textarea" :classes='classes' v-model='sub.remarks' @input='remark($event, sub.id)'></quick-edit>
                                    </td>
                                    </tr>
                                </template>

                                </tbody>
                            </table>
                            <div class="v-actions text-center">
                                <button type="button" class="btn btn-primary btn-lg" @click="post_rubric()"> <span>Save Assessment</span> <em class="mdi mdi-arrow-right"></em></button> <img :src="loader_path()" v-if="loading">
                            </div>
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
foreach ($subjects as $s)
{
    $res[] = ['id' => $s->subject, 'text' => $s->name];
}
$st = [];
foreach ($students as $key => $name)
{
    $st[] = ['id' => $key, 'name' => $name];
}
?>
<script>
    var students = <?php echo json_encode($st); ?>;
    var subjects = <?php echo json_encode($res); ?>;
    var years = <?php echo json_encode($y_opt); ?>;
    var class_ = <?php echo $class->id; ?>;
    Vue.use(VueToast, {position: 'bottom-right', pauseOnHover: true, duration: 6000});
    const tsk = new Vue({
        el: '#assess',
        data: {
            del: false,
            url: BASE_URL,
            loading: false,
            toggl: true,
            show: false,
            tab: 1,
            class_: class_,
            rb: {},
            subject: '',
            year: '',
            term: '',
            rec: {student: ''},
            summ: {report: [], student: '', term: '', year: '', gen_remarks: '', tr_remarks: ''},
            subjects: subjects,
            students: students,
            years: years,
            terms: [{id: 1, text: 'Term 1'}, {id: 2, text: 'Term 2'}, {id: 3, text: 'Term 3'}],
            st_rating: '',
            strand: '',
            strands: [],
            sub_strand: '',
            sub_strands: [],
            tasks: [],
            saved: {strands: [], subs: [], tasks: [], comments: []},
            sel_subs: [],
            sel_tasks: [],
            assess: [],
            rates: {},
            comments: {},
            sub_index: null,
            ratings: [
                {id: 1, text: 'Default'}
            ],
            classes: {buttonOk: 'vue-quick-edit__button--ok btn btn-custom btn-xs', buttonCancel: 'vue-quick-edit__button--cancel btn btn-danger btn-xs', input: 'vue-quick-edit__input form-control'}
        },
        components: {multiselect: VueMultiselect.default, 'quick-edit': QuickEdit.default},
        mounted()
        {

        },
        methods: {
            confirm(state)
            {
                this.del = true;
            },
            filter_sub(e)
            {
                this.pop_assess();
            },
            pop_assess()
            {
                if (this.rec.student && this.term && this.year && this.subject)
                {
                    this.loading = true;
                    let $vm = this;
                    let s_id = 0;

                    if (this.sub_strand != null && typeof this.sub_strand.id != 'undefined')
                    {
                        s_id = this.sub_strand.id;
                    }
                    axios.post(BASE_URL + 'trs/cbc/get_assess' + '/' + s_id, {class: this.class_, student: this.rec.student.id, term: this.term.id, year: this.year.id, subject: this.subject.id, strand: this.strand})
                            .then(resp => {
                                $vm.saved = resp.data.results;
                                $vm.assess = resp.data.subjects;
                                $vm.st_rating = resp.data.strand.rating;

                                this.loading = false;
                            })
                            .catch(error => {
                                console.log(error);
                                this.loading = false;
                            });
                }
            },
            update_assess(e)
            {
                this.loading = true;
                this.assess = [];
                this.strands = [];
                this.sub_strands = [];
                this.tasks = [];

                this.strand = '';
                this.sub_strand = '';

                this.show = false;
                axios.get(BASE_URL + 'trs/cbc/list_strands/' + e.id)
                        .then(resp => {
                            this.strands = resp.data.strands;
                            this.loading = false;
                        })
                        .catch(error => {
                            console.log(error);
                            this.loading = false;
                        });
            },
            update_subs(e)
            {
                this.loading = true;
                this.assess = [];
                this.sub_strands = [];
                this.tasks = [];
                this.sub_strand = '';

                this.show = false;
                axios.get(BASE_URL + 'trs/cbc/list_sub_strands/' + e.id)
                        .then(resp => {
                            this.sub_strands = resp.data.subs;
                            this.pop_assess();
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
            },
            post_strands(rating, id)
            {
                axios.post(BASE_URL + 'trs/cbc/post_ratings', {class: this.class_, student: this.rec.student, subject: this.subject, term: this.term, year: this.year, strand: id, rating: rating})
                        .then(resp => {

                        })
                        .catch(error => {
                            console.log(error.response.data);
                            console.log(error.response.status);
                        });
            },
            remark(rating, sub)
            {
                return this.post_subs(rating, sub);
            },
            post_subs(rating, sub)
            {
                axios.post(BASE_URL + 'trs/cbc/post_subs', {class: this.class_, student: this.rec.student.id, subject: this.subject.id, term: this.term.id, year: this.year.id, strand: this.strand.id, sub: sub, rating: rating})
                        .then(resp => {
                            this.$toast.success('Remarks saved successfully!');
                        })
                        .catch(error => {
                            console.log(error.response);
                            this.$toast.error('Error saving Remarks!');
                        });
            },
            post_rubric()
            {
                this.loading = true;
                axios.post(BASE_URL + 'trs/cbc/post_rubric', {class: this.class_, student: this.rec.student.id, subject: this.subject.id, term: this.term.id, year: this.year.id, strand: this.strand.id, rating: this.st_rating, assess: this.assess})
                        .then(resp => {
                            this.$toast.success('Saved successfully!');
                            this.loading = false;
                        })
                        .catch(error => {
                            console.log(error.response.data);
                            console.log(error.response.status);
                            this.loading = false;
                        });
            },
            post_summ(rating, subject, exam)
            {
                axios.post(BASE_URL + 'trs/cbc/post_summ', {class: this.class_, student: this.summ.student, term: this.summ.term, year: this.summ.year, subject: subject, exam: exam, rating: rating})
                        .then(resp => {
                            //logged_in check
                            if (!resp.data.hasOwnProperty('message'))
                            {
                                window.location.reload();
                            }
                        })
                        .catch(error => {
                            console.log(error.response);
                        });
            },
            post_rmk(remarks, cat)
            {
                this.loading = true;
                axios.post(BASE_URL + 'trs/cbc/post_summ_remarks', {class: this.class_, student: this.summ.student, term: this.summ.term, year: this.summ.year, remarks: remarks, cat: cat})
                        .then(resp => {
                            //logged_in check
                            if (!resp.data.hasOwnProperty('message'))
                            {
                                window.location.reload();
                            }
                            notify('Report', 'Saved Successfully');
                            this.loading = false;
                        })
                        .catch(error => {
                            console.log(error.response.data);
                            console.log(error.response.status);
                        });
            },
            post_tasks(rating, index, s_index, t_index)
            {
                axios.post(BASE_URL + 'trs/cbc/post_tasks', {class: this.class_, student: this.rec.student.id, subject: this.subject.id, term: this.term.id, year: this.year.id, strand: index, sub: s_index, task: t_index, rating: rating})
                        .then(resp => {

                        })
                        .catch(error => {
                            console.log(error.response.data);
                            console.log(error.response.status);
                        });
            },
            delete: function (id, index)
            {

                if (confirm("Do you really want to delete?"))
                {
                    axios.delete('/api/' + id)
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
<style scoped>
    .form-label{font-size:0.875rem;font-weight:500;color:#344357;margin-bottom:.5rem;}
    .form-label-group{display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem;}
    .form-label-group .form-label{margin-bottom:0;}
    .form-group{position:relative;margin-bottom:1.25rem;}
    label{cursor:pointer;}
    input[type="radio"]:checked ~ label{cursor:default;}
    .mt{font-family:"Material Design Icons"!important;speak:none;font-style:normal;font-weight:normal;font-variant:normal;text-transform:none;line-height:1;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;}
    .m-list{border:1px solid #dbdfea;background:#fff;border-radius:4px;}
    .m-item{position:relative;}
    .m-item:not(:last-child){border-bottom:1px solid #e5e9f2;}
    .m-label{position:relative;display:flex;align-items:center;justify-content:space-between;margin-bottom:0;padding:6px 10px 6px 20px;cursor:pointer;}
    .m-label:before,.m-label:after{position:absolute;top:50%;left:8px;transform:translateY(-50%);height:24px;width:24px;border-radius:50%;}
    .m-label:before{content:'';border:2px solid #dbdfea;}
    .m-label:after{font-family: "Material Design Icons"; content: "\F12C"; display:inline-flex;align-items:center;justify-content:center;color:#fff;background:#6576ff;transition:opacity .3s;opacity:0;}
    .m-label .pm-name{font-size:14px;color:#364a63;}
    .m-label .pm-icon{display:inline-flex;font-size:24px;color:#8094ae;}
    .m-control{height:1px;width:1px;opacity:0;}
    .m-control:checked ~ .m-label{cursor:default;}
    .m-control:checked ~ .m-label:after{opacity:1;}
    .v-actions .btn-primary {color: #fff; background-color: #6576ff!important; border-color: #6576ff!important;}
</style>
<style>
    table.table-bordered th:last-child, table.table-bordered td:last-child { border-right-width: 1px;}
    .card{position:relative;display:flex;flex-direction:column;min-width:0;word-wrap:break-word;background-color:#fff;background-clip:border-box;border:0 solid rgba(0, 0, 0, 0.125);border-radius:4px;}
    .card-title{margin-bottom:0.75rem;}
    .no-bdr{border:0!important;}
    .mr-n1{margin-right:-0.375rem!important;}
    .text-darr{color: #364a63; }
    .bg-primary-dim{background-color:#ebedff!important;}
    .btn .icon{font-size:1.4em;line-height:inherit;}
    .btn-icon:not([class*="btn-icon-break"]){padding-left:0;padding-right:0;}
    .btn-icon .icon{width:2.125rem;} 
    .card-bordered{border:1px solid #dbdfea;}
    .card-inner{padding:1.25rem;}
    .card-inner-group .card-inner:not(:last-child){border-bottom:1px solid #dbdfea;}
    .card-title-group{display:flex;align-items:center;justify-content:space-between;position:relative;}
    .card-title-group .card-title{margin-bottom:0;}
    .card-title-group:only-child{margin-top:-.25rem;margin-bottom:-.25rem;}
    .lead-text{font-size:0.875rem;font-weight:700;color:#364a63;display:block;}
    .lead-text + .sub-text{font-size:12px;}
    .sub-text{display:block;font-size:13px;color:#8094ae;}
    .user-avatar,[class^="user-avatar"]{border-radius:50%;height:40px;width:40px;display:flex;justify-content:center;align-items:center;color:#fff;background:#798bff;font-size:14px;font-weight:500;letter-spacing:0.06em;flex-shrink:0;}
    .user-avatar + .user-info,[class^="user-avatar"] + .user-info{margin-left:1rem;}
    .user-avatar[class*="-primary-dim"]{color:#6576ff;}
    .user-card{display:flex;align-items:center;}
    .user-card .user-info{color:#8094ae;}
</style>
<style>
    .img-container
    {
        text-align: center;
        display: block;
    } 

    .btn-xs{margin-top: 3px;}
    .user-action{padding: 5px; background:#f5f6fa; cursor: pointer; }
    .fbg{background: #f5f6fa; font-weight: bold;}
    .inbox-widget .inbox-item {cursor: pointer;    display: flex;}
    .panel .panel-body p { line-height: 14px;}
    p.inbox-item-author label{ cursor: pointer;}

    .card-inner-group .card-inner:not(:last-child){border-bottom:1px solid #dbdfea;}
    .card-title-group{display:flex;align-items:center;justify-content:space-between;position:relative;}
    .card-title-group .card-title{margin-bottom:0;}
    .card-title-group:only-child{margin-top:-.25rem;margin-bottom:-.25rem;}
    @media (min-width: 576px){
        .card-inner{padding:1.5rem;}
        .card-inner-md{padding-top:1rem;padding-bottom:1rem;}
    }
    .user-card{display:flex;align-items:center;}
    .user-action{margin-left:auto;font-size:20px;color:#8094ae;}
    .empty-state{margin: 15% 10px; text-align: center;}
    .empty-state i {color: #0097CD; font-size: 52px;}
    .results{float:left;border-radius:4px;margin-right:16px;margin-left:0;margin-top:1em;box-shadow:0 2px 4px 0 rgba(0, 0, 0, 0.2);background:#fff;
             position:relative; width:100%;overflow:auto;padding:1em; border: 1px solid rgba(0, 0, 0, 0.125);}
    .results div.subs{padding:0.75em 0.75em;margin-top: 45px; border-bottom:1px solid #efefef;}
    .d-flex{display: flex;}
    .p-10 {padding: 10px !important;}
    .mb-0{margin-bottom: 0;}
    .mb-2{margin-bottom: 5px;}
    ul.single-row {border: 1px solid #dbdfea;  border-radius: 5px; display: flex; flex-wrap: nowrap; justify-content: flex-start; margin: 1em 0px; padding: 10px; list-style: none; }
    ul.single-row li:not(:first-child) {line-height: 1.5; position: relative; font-weight: 600; margin-right: 1.4em; border-right: 1px solid #dbdfea;}
    ul.single-row.eq li:not(:first-child) { flex-grow: 1; padding: 2px 8px; margin-right: 0; margin-left: 0; }
    ul.single-row li:last-child { border-right:none !important; }
    ul.single-row li p:last-child { margin-bottom: 0; }
    ul.single-row li p > span { font-weight: 400; display: block;}
    ul.single-row li:first-child{width:120px !important;border-right: 1px solid #dbdfea;}

    .underline{text-decoration: underline;}
    ul.unstyled{list-style-type: none;}
</style>
<style>
    hr{border-top: 1px solid #ddd !important;}
    .padding-xl 
    {
        text-align: center;
        margin: 20px auto;
        width: 60%;
    }
</style>