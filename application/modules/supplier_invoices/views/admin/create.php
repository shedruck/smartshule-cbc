

<div id="setup" v-cloak>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header row">
                <div class="col-md-11">
                    <h3 class="">Supplier Invoices</h3>
                </div>
                <div class="col-md-1">
                    <a href="<?php echo base_url('admin/supplier_invoices'); ?>" class="pull-right btn btn-primary"><i class="glyphicon glyphicon-arrow-left"></i> List All</a>
                </div>
            </div>
        </div>
        <div class="card-box">
            <h4 class="m-t-0 m-b-10 header-title text-center">&nbsp;</h4>
            <form role="form" action="#" class="form-horizontal form-main">
                <div class="form-group center">
                    <div class="col-md-2"></div>
                    <div class="col-sm-6">
                        <label class="col-sm-3 control-label">Expense Category</label>
                        <div class="col-sm-9 rows">
                            <multiselect placeholder="Select Category" v-model="category" :options="categories" track-by="id" class="form-control" label="text" :searchable="true" :reset-after="false"></multiselect>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label class="col-sm-4 control-label">Supplier Name</label>
                        <div class="col-sm-8 rows">
                            <input type="text" name="supplier_name" v-model="supplier" placeholder="Supplier Name" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="col-sm-4 control-label">Supplier Email</label>
                        <div class="col-sm-8 rows">
                            <input type="text" name="supplier_email" v-model="email" placeholder="Supplier Email Address">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="col-sm-4 control-label">Supplier Tel</label>
                        <div class="col-sm-8 rows">
                            <input type="text" name="supplier_phone" v-model="phone" placeholder="Supplier Phone Number">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="clearfix"></div>
        <div class="card-box">
            <p class="error p-10" v-if="post_error.length">{{post_error }}</p>
            <table class="striped highlight table">
                <thead>
                    <tr>
                        <th width="8%">#</th>
                        <th>Item</th>
                        <th width="10%">Unit Price</th>
                        <th width="10%">Quantity</th>
                        <th width="10%">Sub Total</th>
                        <th width="10%" class="hide-print">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(line, index) in items">
                        <td>{{index+1 }}.</td>
                        <td>
                <input type="text" v-model="line.item" placeholder="Item">
                </td>
                 
                <td>
                    <input type="number" class="form-control" min="0" v-model="line.price" />
                </td>
                <td>
                    <input type="number" class="form-control" min="0" v-model="line.qty" />
                </td>
                <td> {{ format_amount(line.price * line.qty) }}</td>
                <td class="hide-print"><button type="button" class="btn-floating btn-danger" @click="remove_item(index)">X</button></td>
                </tr>
                </tbody>
            </table>
            <div class="section hidden-print">
                <button type="button" class="btn btn-primary" @click="add_item">Add item</button>
            </div>
            <h4 class="pull-right p-10">Total: Ksh. <strong>{{format_total()}}</strong></h4>
            <div class="clearfix"></div>
            <div class="block">
                <div class="col-md-offset-3 col-md-6 right">
                    <button type="button" @click="post()" class="btn btn-success btn-lg">Submit </button>
                </div>
            </div>
        </div>
        <!-- <pre>{{items}}</pre> -->
    </div>
</div>

<script>

 
    let exp_list = <?php echo json_encode($expens_cats); ?>;
    const tsk = new Vue({
        el: '#setup',

        data: {
            post_error: '',
            category: '',
            categories: exp_list,
            supplier: '',
            phone:'',
            email: '',
            date: '',          
            items: [
                {
                    item: '',
                    qty: 0,
                    price: 0,
                    total: 0
                }
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
            updateDate: function (date)
            {
                this.date = date;
            },
            proceed()
            {
                this.del = false;
            },
            post(e)
            {
                this.post_error = '';
                if (this.isEmpty(this.category.id))
                {
                    this.post_error = 'Please Select category';
                    return false;
                }
                if (this.isEmpty(this.phone))
                {
                    this.post_error = 'Please enter Phone Number';
                    return false;
                }
                if (this.isEmpty(this.items[0].item))
                {
                    this.post_error = 'Please Select Item';
                    return false;
                }
                axios.post(BASE_URL + 'admin/supplier_invoices/create_custom_receipt',
                        {
                            category: this.category,
                            supplier: this.supplier,
                            phone:this.phone,
                            email:this.email,
                            items: this.items,
                            total: this.calc_total()
                        })
                        .then(function (response)
                        {
                            notify('Success', "Saved Successfully");
                            window.location.href = BASE_URL + 'admin/supplier_invoices';
                        })
                        .catch(function (error)
                        {
                            console.log(error);
                        });
            },
            isEmpty: (str) => {
                return (!str || 0 === str.length);
            },
            update(e)
            {
                //console.log(e.id + " - " + e.text);
            },
            add_item: function ()
            {
                this.items.push({
                    item: '',
                    qty: 0,
                    price: 0,
                    total: 0
                });
            },
            remove_item: function (index)
            {
                this.items.splice(index, 1);
            },
            calc_total: function ()
            {
                var total = 0;
                this.items.forEach(function (item)
                {
                    total += (item.qty * item.price);
                });

                return total;
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
