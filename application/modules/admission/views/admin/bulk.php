<?php
$students = $this->ion_auth->students_full_details();
?>
<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Bulk Edit Students  </h2>
    <div class="right">  
        <?php echo anchor('admin/admission', '<i class="glyphicon glyphicon-list"></i> ' . lang('web_list_all', array(':name' => 'Students')), 'class="btn btn-primary"'); ?>
    </div>
</div>

<div class="block-fluid" id="bulk" v-cloak>
    <div class="row">
        <div class="col-md-4">
            <div class="dataTables_length" id="adm_table_length">
                <label>
                    Show 
                    <select name="per_page" aria-controls="adm_table" v-model="filters.per_page" @change="getPending">
                        <option v-for="option in options" v-bind:value="option.value">
                            {{ option.text }}
                        </option>
                    </select>
                    entries
                </label>
            </div>
        </div>
        <div class="col-md-3">
            <multiselect placeholder="Filter Class" v-model="filters.class" @input="getPending" :options="classes" track-by="id" label="name" :allowEmpty="true" :searchable="true" :reset-after="false"></multiselect>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control m-b-1" placeholder="Search" v-model="filters.search" @input="search" style="margin-top:2px;"/>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead class="tb-odr-head">
                <tr class="tb-odr-item">
                    <th width="4%">#</th>
                    <th width="8%">ADM. </th>
                    <th width="39%">Name</th>
                    <th width="16%">House</th>
                    <th>Sibling(s)</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(p, index) in pending">
                    <td :class="p.class">{{(index+1)+offset}}.</td>
                    <td>
                        {{ p.admission_number }}
                        <p v-if="p.id==current"><img :src="loader_path()" v-if="loading"></p>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-lg" :id="'first_'+p.id" v-model="p.first_name" placeholder="First">
                                <label class="form-label" :for="'first_'+p.id">First name</label>
                            </div>
                            <div class="col-md-4">
                                <input type="email" class="form-control form-control-lg" :id="'mid_'+p.id" v-model="p.middle_name" placeholder="Middle">
                                <label class="form-label" :for="'mid_'+p.id">Middle</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-lg" :id="'last_'+p.id" v-model="p.last_name" placeholder="Last">
                                <label class="form-label" :for="'last_'+p.id">Last name <button type="button" class="btn btn-dim btn-sm btn-primary pull-right" style="margin-left:20px;" @click="post(p)" :disabled="loading"> Save </button></label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div>
                                <multiselect placeholder="House" v-model="p.house" :options="houses" track-by="id" label="name" :allowEmpty="true" :searchable="true" :reset-after="false"></multiselect>
                                <button type="button" class="btn-link pull-right" @click="post_house(p)" :disabled="loading"> Save</button>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row border-1" v-if="p.show">
                            <div>
                                <multiselect placeholder="-- Select Sibling --" v-model="sibling" :options="students" track-by="id" label="name" :allowEmpty="true" :searchable="true" :reset-after="false"></multiselect>
                                <button type="button" class="btn-link pull-right" @click="p.show=false;edit=false; sibling='' " :disabled="loading"> Cancel</button>
                                <button type="button" class="btn-link pull-right" @click="post_sb(p.id, p.parent_id)" :disabled="loading"> Save</button>
                            </div>
                        </div>
                        <div class="nk-tb-list is-compact">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col">
                                    <button type="button" class="btn btn-info btn-sm" @click="p.show=true;edit=true" v-if="!p.show && edit==false" :disabled="loading">Add</button>
                                </div>
                                <div class="nk-tb-col text-right"><span>&nbsp;</span></div>
                            </div>
                            <div class="nk-tb-item" v-for="(s,ix) in p.sibs">
                                <div class="nk-tb-col">
                                    {{ ix+1 }}. <span class="tb-sub"><span>{{ s.name }} - <small>{{ s.class }}</small></span></span>
                                </div>
                                <div class="nk-tb-col text-right">
                                    <span class="tb-sub tb-amount">
                                        <button class="btn btn-danger btn-sm" title="Delete" @click="remove(s.id,s.name)"> X</button>
                                    </span>
                                </div>
                            </div>
                        </div>
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
                :click-handler="getPending">
            </paginate>
        </div>
        <div class="col-md-4">
            <div class="float-right" v-if="count"> per page
                <select name="per_page" class="form-control" v-model="filters.per_page" @change="getPending">
                    <option v-for="option in options" v-bind:value="option.value">
                        {{ option.text }}
                    </option>
                </select>
            </div>
        </div>
    </div>
</div>
<?php
$roster = [];
foreach ($students as $k => $s)
{
    $roster[] = ['id' => $k, 'name' => $s];
}
$hses = [];
foreach ($houses as $kk => $vv)
{
    $hses[] = ['id' => $kk, 'name' => $vv];
}

$sslist = [];
foreach ($this->classlist as $ssid => $s)
{
    $sslist[] = ['id' => $ssid, 'name' => $s['name']];
}
?>
<script>
    var houses = <?php echo json_encode($hses); ?>;
    var classes = <?php echo json_encode($sslist); ?>;
    var students = <?php echo json_encode($roster); ?>;
    var user_id = <?php echo isset($this->user->id) ? $this->user->id : 0; ?>;
    Vue.use(VueToast, {position: 'top', pauseOnHover: true, duration: 6000});
    const tsk = new Vue({
        el: '#bulk',
        data: {
            post_error: '',
            pending: {},
            sibling: '',
            houses: houses,
            classes: classes,
            students: students,
            rows: 0,
            user_id: user_id,
            pcount: 0,
            page: 1,
            tab: 1,
            current: 0,
            count: 0,
            offset: 0,
            loading: false,
            edit: false,
            ask: false,
            filters: {
                sortBy: 'id',
                search: '',
                class: '',
                order: 'desc',
                status: '',
                per_page: 3
            },
            options: [
                {text: '3', value: 3},
                {text: '10', value: 10},
                {text: '20', value: 20},
                {text: '50', value: 50},
                {text: '100', value: 100}
            ]
        },
        mounted()
        {
            this.getPending(0);
        },
        components: {multiselect: VueMultiselect.default, paginate: VuejsPaginate},
        methods: {
            getPending(page)
            {
                this.loading = true;
                if (typeof page === 'undefined' || typeof page !== 'number')
                {
                    var page = 0;
                }

                let url = this.getFilterURL(this.filters);
                axios.get(BASE_URL + 'admin/admission/get_pending_edit?tab=' + this.tab + '&page=' + page + url)
                        .then(response => {
                            var ret = response.data;
                            this.pending = ret.result;
                            this.count = this.pending.length;
                            this.rows = parseFloat(ret.total);
                            this.pcount = Math.ceil(this.rows / this.filters.per_page);
                            this.offset = page ? parseInt((page - 1) * this.filters.per_page) : 0;
                            this.loading = false;
                        })
                        .catch(response => {
                            this.loading = false;
                        });
            },
            post_sb(id, parent_id)
            {
                this.loading = true;
                this.current = id;
                if (this.sibling == '')
                {
                    Vue.$toast.error(' Please Select Sibling');
                    return false;
                }

                var $vm = this;
                axios.post(BASE_URL + 'admin/admission/assign_parent', {parent: parent_id, student: this.sibling.id, id: id})
                        .then(function (response)
                        {
                            if (response.data.status = 200)
                            {
                                $vm.$toast.success(response.data.message);
                                this.loading = false;
                            }
                            else
                            {
                                $vm.$toast.error(response.data.message);
                                this.loading = false;
                            }

                            $vm.edit = false;
                            $vm.sibling = '';
                            $vm.getPending(0);
                        })
                        .catch(function (error)
                        {
                            console.log(error);
                        });
            },
            remove(id, name)
            {
                if (confirm('Confirm remove sibling:' + name))
                {
                    this.loading = true;
                    var $vm = this;
                    axios.post(BASE_URL + 'admin/admission/remove_assign_parent', {id: id})
                            .then(function (response)
                            {
                                if (response.data.status = 200)
                                {
                                    $vm.$toast.success(response.data.message);
                                    this.loading = false;
                                }
                                else
                                {
                                    $vm.$toast.error(response.data.message);
                                    this.loading = false;
                                }

                                $vm.getPending(0);
                            })
                            .catch(function (error)
                            {
                                console.log(error);
                            });
                }
            },
            post(p)
            {
                this.loading = true;
                this.current = p.id;
                this.post_error = '';
                if (!p.first_name.length || !p.last_name.length)
                {
                    Vue.$toast.error(' Please Enter Firstname & Last name');
                    return false;
                }
                var $vm = this;
                axios.post(BASE_URL + 'admin/admission/update_student' + '/' + p.id, {first_name: p.first_name, middle_name: p.middle_name, last_name: p.last_name})
                        .then(function (response)
                        {
                            if (response.data.status = 200)
                            {
                                $vm.$toast.success(response.data.message);
                                this.loading = false;
                            }
                            else
                            {
                                $vm.$toast.error(response.data.message);
                                this.loading = false;
                            }

                            $vm.ask = false;
                            $vm.getPending(0);
                        })
                        .catch(function (error)
                        {
                            console.log(error);
                        });
            },
            post_house(p)
            {
                this.loading = true;
                this.current = p.id;
                if (!p.house)
                {
                    Vue.$toast.error(' Please Select House');
                    this.loading = false;
                    return false;
                }
                var $vm = this;
                axios.post(BASE_URL + 'admin/admission/update_student' + '/' + p.id + '/1', {house: p.house.id})
                        .then(function (response)
                        {
                            if (response.data.status = 200)
                            {
                                $vm.$toast.success(response.data.message);
                                this.loading = false;
                            }
                            else
                            {
                                $vm.$toast.error(response.data.message);
                                this.loading = false;
                            }

                            $vm.ask = false;
                            $vm.getPending(0);
                        })
                        .catch(function (error)
                        {
                            console.log(error);
                        });
            },
            search()
            {
                if (this.filters.search.length > 2)
                {
                    this.getPending(0);
                }
                if (this.filters.search.length == 0)
                {
                    this.getPending(0);
                }
            },
            isEmpty: (str) => {
                return (!str || 0 === str.length);
            },
            getFilterURL(data)
            {
                let url = '';
                $.each(data, function (key, value) {
                    if (key == 'class')
                    {
                        url += (value) ? '&' + key + '=' + encodeURI(value.id) : '';
                    }
                    else
                    {
                        url += (value) ? '&' + key + '=' + encodeURI(value) : '';
                    }

                });
                return url;
            },
            loader_path()
            {
                return BASE_URL + 'assets/ico/loader.gif';
            },
            format_total: function ()
            {
                var ft = this.calc_total().toFixed(2);

                return ft > 0 ? ft.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') : '0.00';
            },
            format_amount: function (amount)
            {
                return parseFloat(amount).toLocaleString();
            }
        }
    });
</script>
<style>
    .nk-tb-list{
        display:table;
        width:100%;
        font-size:13px;
        color:#8094ae;
    }
    .nk-tb-list .tb-amount{
        font-weight:500;
        color:#364a63;
        display:block;
        line-height:1.4;
    }
    .nk-tb-list .tb-sub{
        font-size:.9em;
    }
    .nk-tb-list .tb-amount span{
        color:#526484;
        font-weight:400;
    }
    .nk-tb-item{
        transition:background-color .3s, box-shadow .3s;
        display:table-row;
    }
    .nk-tb-item:not(.nk-tb-head):hover{
        background:#f8f9fc;
        box-shadow:0 0 10px -4px rgba(54, 74, 99, 0.2);
    }
    .nk-tb-col{
        position:relative;
        display:table-cell;
        vertical-align:middle;
        padding:1rem .5rem;
    }
    .nk-tb-col:first-child{
        padding-left:1.25rem;
    }
    .nk-tb-col:last-child{
        padding-right:1.25rem;
    }
    .nk-tb-item:not(:last-child) .nk-tb-col{
        border-bottom:1px solid #dbdfea;
    }
    .nk-tb-head .nk-tb-col{
        padding-top:0.5rem;
        padding-bottom:0.5rem;
        color:#8094ae;
        font-size:.9em;
        border-bottom:1px solid #dbdfea;
    }
    .is-compact .nk-tb-item:not(.nk-tb-head) .nk-tb-col{
        padding-top:.5rem;
        padding-bottom:.5rem;
    }
</style>
<style>
    [class^="col-"]{
        padding: 4px;
    }
    .modd{
        border-left: 6px solid #24b314;
    }
    .border-1{
        border: 1px solid #aebde4;
        border-radius: 5px;
        padding: 5px;
    }
    label{
        font-size: 10px !important;
        color: #aba7aa;
        font-weight: 400;
    }
    .table{
        margin-bottom:1rem;
        color:#526484;
    }
    .table th,.table td{
        padding:0.5rem;
        vertical-align:top;
        border-top:1px solid #dbdfea;
    }
    .table thead th{
        vertical-align:bottom;
        border-bottom:2px solid #dbdfea;
    }
    .table thead tr:last-child th{
        border-bottom:1px solid #dbdfea;
    }
    .table td:first-child,.table th:first-child{
        padding-left:1.25rem;
    }
    .table td:last-child,.table th:last-child{
        padding-right:1.25rem;
    }
    .table th{
        line-height:1.1;
    }

    .tb-odr-item{
        font-size:14px;
    }
    .tb-odr-item td{
        padding:1rem .25rem;
        vertical-align:middle;
    }
    .tb-odr-item .tb-odr-total{
        color:#364a63;
    }

    .tb-odr-item .tb-odr-date{
        color:#8094ae;
    }

    .tb-odr-head{
        background:#f5f6fa;
    }
    .tb-odr-head th{
        font-size:12px;
        text-transform:uppercase;
        letter-spacing:0.12em;
        color:#8094ae;
        padding:0.625rem .25rem;
    }
</style>
