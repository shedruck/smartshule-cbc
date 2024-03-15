<div id="transport">
    <div class="page-title-container mb-3">
        <div class="row">
            <div class="col mb-2">
                <h1 class="mb-2 pb-0 display-4" id="title"><?php echo $this->school->school; ?> TRANSPORT</h1>
                <div class="text-muted font-heading text-small">Check in & Checkout students in transport.</div>
            </div>

            <div class="col-12 col-sm-auto justify-content-end">
                <button  type="button" class="btn btn-quaternary w-md-auto" @click="show(1)"> Check in</button>
                <button type="button" class="btn btn-tertiary w-md-auto dropdown-toggle" @click="show(2)">
                    Check out
                </button> &nbsp;
            </div>
        </div>
    </div>

    <div class="row g-2">
        <div class="col-12 col-md-6 h-100">
            <h2 class="small-title">Term  <?php echo $this->school->term; ?> <?php echo $this->school->year; ?></h2>
            <div class="card hover-scale-up cursor-pointer mb-1">
                <div class="h-100 row g-0 p-4 align-items-center">
                    <div class="col-auto">
                        <div class="bg-gradient-2 sw-5 sh-5 rounded-xl d-flex justify-content-center align-items-center">
                            <em class="icon ni ni-map-pin text-white"></em>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p mb-0 sh-5 d-flex align-items-center lh-1-25 ps-3">Assigned Routes</div>
                    </div>
                    <div class="col-auto ps-3">
                        <div class="cta-2 text-primary"><?php echo number_format($total_r); ?></div>
                    </div>
                </div>
            </div>
            <div class="card hover-scale-up cursor-pointer mb-1">
                <div class="h-100 row g-0 p-4 align-items-center">
                    <div class="col-auto">
                        <div class="bg-gradient-2 sw-5 sh-5 rounded-xl d-flex justify-content-center align-items-center">
                            <em class="icon ni ni-users-fill text-white"></em>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p mb-0 sh-5 d-flex align-items-center lh-1-25 ps-3">Total Assigned Students</div>
                    </div>
                    <div class="col-auto ps-3">
                        <div class="cta-2 text-primary"><?php echo number_format($total_s); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3 h-100">
                <h2 class="small-title">My Routes</h2>
                <div class="scroll-out h-100">
                    <div class="scroll-by-count" data-count="4">
                        <?php
                        $i = 0;
                        foreach ($assigned as $ky => $v)
                        {
                            $i++;
                            ?>
                            <div class="card mb-1 hover-border-primary ">
                                <div class="row g-0 sh-9 pt-0 pb-0">
                                    <div class="col-2 d-flex align-items-center justify-content-center">
                                        <div class="p-1">
                                            <?php echo $i; ?>.
                                        </div>
                                    </div>
                                    <div class="col-10 d-flex flex-column justify-content-center">
                                        <p class="heading mb-0"><?php echo $ky; ?></p>
                                        <p class="text-small text-muted mb-0"><?php echo number_format($v); ?> students.</p>
                                    </div>
                                </div>
                            </div>                         
                        <?php } ?>               
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 min-h-100">
            <div class="col-12 mb-5">
                <div class="d-flex justify-content-between">
                    <h2 class="small-title">Recent Activity</h2>
                    <button class="btn btn-icon btn-icon-end btn-xs btn-background-alternate p-0 text-small" type="button">
                        <span class="align-bottom d-none">View More</span>
                        <em class="icon ni ni-chevron-right align-middle small"></em>
                    </button>
                </div>
                <div class="card mb-5">
                    <div class="card-body">
                        <template v-if="recent.length">
                            <div class="row g-0" v-for="t in recent">
                                <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                                    <div class="w-100 d-flex sh-1"></div>
                                    <div class="rounded-xl shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                                        <div class="bg-gradient-primary sw-1 sh-1 rounded-xl position-relative"></div>
                                    </div>
                                    <div class="w-100 d-flex h-100 justify-content-center position-relative">
                                        <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                                    </div>
                                </div>
                                <div class="col mb-4">
                                    <div class="h-100">
                                        <div class="d-flex flex-column justify-content-start">
                                            <div class="d-flex flex-column">
                                                <div class="text-primary">{{ t.timestamp }}</div>
                                                <div class="text-muted mt-1">
                                                    <span class="underline-link">{{ t.student }}</span> {{ t.message }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div class="empty-state" v-if="!recent.length">
                            <div class="empty-state__content">
                                <div class="empty-state__icon">
                                    <img :src="image('illustration/icon-phone.png')" alt="empty">
                                </div>
                                <div class="empty-state__message">No records added yet.</div>
                                <div class="text-center text-muted">
                                    You can <button type="button" class="btn btn-link mb-0">Checkin</button> 
                                    or <button type="button" class="btn btn-link mb-0">Checkout</button> students to create a new record.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade"
         :class="{ 'show': modalOpen}"
         :style="modalOpen? 'display: block': 'display: none'"
         role="dialog"
         tabindex="-1" 
         :aria-hidden="modalOpen? 'false' : 'true' "
         >
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded">
                <div class="modal-header p-3">
                    <h5 class="modal-title">TRANSPORT ATTENDANCE</h5>
                    <button type="button" class="btn-close" @click='toggle_show()'><em class="icon ni ni-cross"></em></button>
                </div>
                <div class="modal-body pt-3">
                    <ul class="nav nav-tabs">
                        <li class="nav-item" v-if="tab==1">
                            <a class="nav-link hover-border-primary cursor-pointer" :class="tab==1 ? 'active' : ' ' " @click='showTab(1)'><em class="sm-icon ni ni-curve-up-left"></em><span> Boarding</span></a>
                        </li>
                        <li class="nav-item" v-if="tab==2">
                            <a class="nav-link hover-border-primary cursor-pointer" :class="tab==2 ? 'active' : ' ' " @click='showTab(2)'><em class="sm-icon ni ni-curve-down-right"></em><span> Alighting</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <div class="card-body">
                                <div class="clearfix mb-2"></div>
                                <form class="">
                                    <div class="row gx-3 gy-2 align-items-center">
                                        <div class="col-sm-2">
                                            <label class="visually-hidden d-none" for="date">Date</label>
                                            <input type="text" class="form-control d-none" id="date" placeholder="Date">
                                        </div>

                                        <div class="col-sm-6">
                                            <label class="visually-hidden" for="rt">Route</label>
                                            <multiselect v-model="route" :options="routes" label="name" placeholder="-- Select Route --" @input="update_students()"></multiselect>
                                        </div>
                                        <div class="col-sm-3 text-muted">
                                            <img :src="show_loader()" alt="" v-if="loading"> 
                                            {{ students.length }} Students</div>
                                    </div>
                                </form>
                            </div>
                            <div class="row g-0 mt-3">
                                <div class="col-12 col-md-6 justify-content-start order-3 order-md-2" v-if="students.length">
                                    <input type="checkbox" @click="selectAll" v-model="all" class="form-check-input"> &nbsp;   All &nbsp; &nbsp; 
                                    <button class='btn btn-sm btn-primary' type="button" @click='bulk(1)' v-if="ids.length && tab==1">Present</button>
                                    <button class='btn btn-sm btn-danger' type="button" @click='bulk(0)' v-if="ids.length && tab==1">Absent</button>
                                    <button class='btn btn-sm btn-success' type="button" @click='bulk(2)' v-if="ids.length && tab==2">Alight</button>
                                </div>

                                <div class="col-12 col-md-6 col-lg d-flex align-items-start justify-content-end mb-2 mb-md-0 order-md-3">
                                    <div class="w-100 w-md-auto search-input-container border border-separator">
                                        <input class="form-control search" placeholder="Search" autocomplete="off" v-model="grid.search" @input="search">
                                        <span class="search-magnifier-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="cs-icon cs-icon-search"><circle cx="9" cy="9" r="7"></circle><path d="M14 14L17.5 17.5"></path></svg>
                                        </span>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body px-0 mb-n2 border-last-none h-100">
                                <div class="alert alert-info" role="alert" v-if="route && !students.length && tab==2">
                                    No Students Boarded / Check date
                                </div>
                                <div class="border-bottom border-separator-light mb-2" v-for='(s,index) in students'>
                                    <div class="row g-0 sh-6">
                                        <div class="col-auto">
                                            <input type="checkbox" v-model="ids" @click="select" :value="s.id" :id="'cc'+s.id" v-if="!s.att && tab==1" class="form-check-input">
                                            <input type="checkbox" v-model="ids" @click="select" :value="s.id" :id="'cc'+s.id" v-if="tab==2" class="form-check-input">
                                            <img :src="image('avatar/'+s.v+'/50.png')" class="card-img rounded-v smv" alt="thumb">
                                        </div>
                                        <div class="col">
                                            <div class="card-body d-flex flex-row pt-0 pb-0 ps-2 pe-0 h-100 justify-content-between">
                                                <div class="d-flex flex-column">
                                                    <div>{{ s.name }}</div>
                                                    <div class="text-sm text-muted">{{ s.class }} &nbsp;&nbsp; {{ s.adm }}</div>
                                                </div>
                                                <div class="">
                                                    <template v-if="!s.att">
                                                        <button class="btn btn-success btn-sm ms-1" type="button" @click="set_status(s.id,1, s.name)"><em class="sm-icon ni ni-check-thick"></em></button> 
                                                        <button class="btn btn-sm btn-danger" type="button" title="Absent" @click="set_status(s.id, 0,s.name)">
                                                            <em class="sm-icon ni ni-cross"></em> 
                                                        </button>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane d-none" >
                            <p>content </p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click='toggle_show()'>Close</button>
                </div>
            </div>
        </div>
    </div>
    <div v-if="modalOpen" class="modal-backdrop in"></div>
</div>

<script>
    var roster = <?php echo json_encode($roster); ?>;
    var routes = <?php echo json_encode($options); ?>;
    var years = <?php echo json_encode($years); ?>;
    var students = <?php echo json_encode($students); ?>;
    var route = <?php echo $route ? $route : 0; ?>;
    Vue.use(VueToast, {position: 'top', pauseOnHover: true, duration: 6000});
    const app = new Vue({
        el: '#root',
        components: {multiselect: VueMultiselect.default, paginate: VuejsPaginate},
        data() {
            return {
                url: BASE_URL,
                tab: 1,
                route: route == 0 ? '' : route,
                modalOpen: false,
                terms: [{id: 1, text: 'Term 1'}, {id: 2, text: 'Term 2'}, {id: 3, text: 'Term 3'}],
                years: years,
                routes: routes,
                roster: roster,
                students: students,
                loading: false,
                selected: [],
                recent: [],
                all: false,
                ids: [],
                grid: {
                    search: '',
                    per_page: 10,
                    group: 0,
                    class: 0
                }
            };
        },
        mounted()
        {
            this.get_recent();
        },
        methods: {
            show(tab)
            {
                this.tab = tab;
                this.modalOpen = true;
            },
            bulk(action)
            {
                this.loading = true;
                let arr = ["Absent", "Present", "Alight"];
                if (confirm('Are you sure?'))
                {
                    let $vm = this;
                    axios.post(BASE_URL + 'transport/bulk', {ids: this.ids, action: action, 'route': this.route.id})
                            .then(response => {
                                $vm.$toast.success(response.data.message);
                                this.ids = [];
                                this.getStudents(0);
                                this.loading = false;
                            })
                            .catch(response => {
                                $vm.$toast.error(response.data.message);
                                this.loading = false;
                            });
                }
            },
            getStudents(page)
            {
                this.loading = true;
                if (typeof this.route.id === 'undefined')
                {
                    this.$toast.error('Please Select Route First');
                    this.loading = false;
                    return false;
                }
                if (typeof page === 'undefined' || typeof page !== 'number')
                {
                    var page = 0;
                }
                let url = this.getFilterURL(this.grid);
                axios.get(BASE_URL + 'transport/list_students?tab=' + this.tab + '&route=' + this.route.id + '&page=' + page + url)
                        .then(response => {
                            var ret = response.data;
                            this.students = ret.students;
                            /*
                             this.count = this.paid.length;
                             this.rows = parseFloat(ret.total);
                             this.pcount = Math.ceil(this.rows / this.filters.per_page);
                             this.offset = page ? parseInt((page - 1) * this.filters.per_page) : 0;
                             */
                            this.loading = false;
                        })
                        .catch(response => {
                            this.loading = false;
                        });
            },
            set_status(id, status, name)
            {
                var $vm = this;
                let arr = ["Absent", "Present"];
                if (confirm('Are you sure? Mark ' + name + ' as ' + arr[status] + '?'))
                {
                    axios.post(BASE_URL + 'transport/update', {'id': id, 'status': status, 'route': this.route.id})
                            .then(response => {
                                $vm.getStudents(0);
                                $vm.$toast.success(response.data.message);
                            })
                            .catch(response => {
                                console.log(response.message);
                            });
                }
            },
            get_recent()
            {
                axios.get(BASE_URL + 'transport/recent')
                        .then(response => {
                            var ret = response.data;
                            this.recent = ret.recent;
                        })
                        .catch(response => {
                            console.log(response.message);
                        });

            },
            update_students()
            {
                this.getStudents(0);
            },
            search()
            {
                if (this.grid.search.length > 2 || (this.grid.search.length == 0))
                {
                    this.getStudents(0);
                }
            },
            toggle_show()
            {
                this.close();
            },
            selectAll: function ()
            {
                this.ids = [];
                this.all = !this.all;
                if (this.all)
                {
                    this.students.forEach((item, i) => {
                        if (this.tab == 1)
                        {
                            if (!item.att)
                            {
                                this.ids.push(item.id);
                            }
                        }
                        else
                        {
                            this.ids.push(item.id);
                        }

                    });
                }
                else
                {
                    this.ids = [];
                }
            },
            select: function ()
            {
                this.all = false;
            },
            confirm()
            {
                this.sel = true;
            },
            close()
            {
                this.modalOpen = false;
                this.all = false;
                this.students = [];
                this.ids = [];
                this.route = '';
            },
            showTab(tab)
            {
                this.tab = tab;
            },
            getFilterURL(data)
            {
                let url = '';
                $.each(data, function (key, value) {
                    url += (value) ? '&' + key + '=' + encodeURI(value) : '';
                });
                return url;
            },
            image(filename)
            {
                return BASE_URL + "assets/themes/transport/img/" + filename;
            },
            format_total: function ()
            {
                var ft = Number(this.calc_total()).toFixed(2);

                return ft.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
            },
            getFilterURL(data)
            {
                let url = '';
                $.each(data, function (key, value) {
                    url += (value) ? '&' + key + '=' + encodeURI(value) : '';
                });
                return url;
            },
            show_loader()
            {
                return BASE_URL + 'assets/ico/loader.gif';
            }
        }
    });
</script>

<script>
    /*  $(document).ready(
     function ()
     {
     $(".tsel").select2({'placeholder': 'Please Select', 'width': '100%'});
     });*/
</script>