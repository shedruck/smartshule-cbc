<div class="col-md-12 ng-cloak" ng-controller="calcctr" ng-cloak>
    <script>
            window.rx = <?php echo json_encode($messages); ?>;
            window.apx = <?php echo json_encode($appr); ?>;
            window.rjx = <?php echo json_encode($rejt); ?>;
            window.pdx = <?php echo json_encode($pend); ?>;
    </script>
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2> Expense Requisitions </h2>
        <div class="right">
            <?php
            if ($this->acl->is_allowed(array('admin', 'expenses', 'create_req'), 1))
            {
                    ?>
                    <?php echo anchor('admin/expenses/create_req', '<i class="glyphicon glyphicon-plus"> </i>' . lang('web_add_t', array(':name' => 'Requisitions')), 'class="btn btn-primary"'); ?>
                    <?php echo anchor('admin/expenses/requisitions', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>              
            <?php } ?>
        </div>
    </div>
    <div class="slip">
        <?php
        $user = $this->ion_auth->user($req->created_by)->row();
        ?>
        <div class="invoicelist-footer">
            <table class='fttb'>
                <tr class="taxrelated">
                    <td>#</td>
                    <td>Req<?php echo str_pad($req->id, 4, '0', 0) ?></td>
                </tr>
                <tr>
                    <td><strong>Requisition Date:</strong></td>
                    <td><?php echo date('d M Y', $req->created_on); ?></td>
                </tr>
                <tr>
                    <td><strong>Created by:</strong></td>
                    <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                </tr>
            </table>
        </div>
        <br/>
        <div class="invoicelist-body">
            <table class="stable">
                <thead contenteditable>
                    <tr>
                        <th class="text-center">#</th>
                        <th width="50%">Item</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th align="right">Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody> 
                    <tr><td colspan="6"><span class="tdt">Pending Items({{rst.pending.length}})</span></td></tr>
                    <tr ng-repeat="p in rst.pending">
                        <td>{{$index + 1}}.</td>
                        <td>{{p.descr}}</td>
                        <td>{{p.qty|number:0}}</td>
                        <td>{{p.price|number:2}}</td>
                        <td class="sum" align="right">{{p.sub|number:2}}</td>
                        <td>
                            <button class="btn btn-primary" ng-click="sett(p.id, 1, <?php echo $req->id; ?>)" title="Approve"><i class="glyphicon glyphicon-ok"></i></button> 
                            <button class="btn btn-warning" ng-click="sett(p.id, 0, <?php echo $req->id; ?>)" title="Reject"><i class="glyphicon glyphicon-remove"></i></button> 
                        </td>
                    </tr>
                    <tr><td colspan="6"><span class="tdt">Approved Items({{rst.approved.length}})</span></td></tr>
                    <tr ng-repeat="p in rst.approved">
                        <td>{{rst.pending.length + ($index + 1)}}.</td>
                        <td>{{p.descr}}</td>
                        <td>{{p.qty|number:0}}</td>
                        <td>{{p.price|number:2}}</td>
                        <td class="sum" align="right">{{p.sub|number:2}}</td>
                        <td>
                            <button class="btn btn-primary" ng-click="sett(p.id, 1, <?php echo $req->id; ?>)" title="Approve"><i class="glyphicon glyphicon-ok"></i></button> 
                            <button class="btn btn-warning" ng-click="sett(p.id, 0, <?php echo $req->id; ?>)" title="Reject"><i class="glyphicon glyphicon-remove"></i></button> 
                        </td>
                    </tr>
                    <tr><td colspan="6"> <span class="tdt">Rejected Items({{rst.rejected.length}})</span></td></tr>
                    <tr ng-repeat="p in rst.rejected">
                        <td>{{rst.pending.length + rst.approved.length + ($index + 1)}}.</td>
                        <td>{{p.descr}}</td>
                        <td>{{p.qty|number:0}}</td>
                        <td>{{p.price|number:2}}</td>
                        <td class="sum" align="right">{{p.sub|number:2}}</td>
                        <td>
                            <button class="btn btn-primary" ng-click="sett(p.id, 1, <?php echo $req->id; ?>)" title="Approve"><i class="glyphicon glyphicon-ok"></i></button> 
                            <button class="btn btn-warning" ng-click="sett(p.id, 0, <?php echo $req->id; ?>)" title="Reject"><i class="glyphicon glyphicon-remove"></i></button> 
                        </td>
                    </tr>
                </tbody>
            </table>
        </div><!--.invoice-body-->
        <div class="invoicelist-footer">
            <table>
                <tr class="taxrelated">
                    <td></td>
                    <td id="total_tax">&nbsp;</td>
                </tr>
                <tr>
                    <td><strong>Total:</strong></td>
                    <td id="total_price"><?php echo number_format($req->total, 2); ?></td>
                </tr>
            </table>
                   </div>
        <div class="clearfix"></div>

    </div>
    <div class="conm">        
        <div class="col-md-6 offset-md-3" style="margin-top:2em;">
            <div class="card paper">
                <ul id="lastComment" class="list-group">
                    <li class="list-group-item" ng-repeat="c in chat">
                        <span class="circle">
                            <img src="<?php echo base_url(); ?>assets/themes/default/img/avatar/{{c.by}}/50.png" alt="user">
                        </span>
                        <span class="title">
                            <a href="">{{c.name}} </a> <time> {{c.ts}}</time> 
                            <p>{{c.message}}</p>
                        </span>
                        <ul class="list-inline actions" href="">
                            <li><a href="" title="Delete" ng-click="rm()"><i class="glyphicon glyphicon-remove"></i></a></li>
                        </ul>
                    </li>
                </ul>
                <form>
                    <fieldset class="form-groupp">
                        <input type="text" class="form-controll" ng-model="comm" placeholder="Add a comment">
                    </fieldset>
                    <button type="button" class="btn btn-sm btn-success" ng-click="post(<?php echo $id; ?>);">Post</button>
                </form>	
            </div>
        </div> 
    </div>
</div>
<style>
    .tdt{color:#b94a48;}
    .list-group-item p a {
        font-weight: 500;
        color: rgba(3, 161, 241, 1);
        text-decoration: underline!important;
    }
    .list-group-item p a:hover {
        font-weight: 500;
        color: rgba(3, 161, 241, 0.8);
        text-decoration: underline!important;
    }
    .card{
        border: none !important;
        background-color: #fff;
        overflow: hidden;
    }
    .paper {
        -webkit-box-shadow: 0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);
        box-shadow: 0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);
    }
    summary{
        outline: 0;
        cursor: pointer;
        color: rgba(0,0,0,.8);
        font-size: 14px;
    }
    .title{
        display: inline-block;
        margin-left: 5em;
    }
    .title a {
        font-weight: 500 !important;
        color: rgba(0,0,0,.8) ;
        text-decoration: none !important;
    }
    .title a:hover {
        color: rgba(0,0,0,.7);
    }
    .title time {
        font-size: 12px;
        color: rgba(0,0,0,.5)!important;
        font-weight: 400;
        margin-left: 6px;
    }
    .title p {
        margin-bottom: 0;
        white-space: normal;
        color: rgba(0,0,0,.8);
        font-size: 14px;
        margin-top: 0.215em;
    }
    .circle {
        position: absolute;
        width: 42px;
        height: 42px;
        overflow: hidden;
        left: 15px;
        display: inline-block;
        vertical-align: middle;
        border-radius: 50%;
    }
    .circle img{
        width: 100%;
    }
    ul.actions {
        position: absolute;
        right: 1em;
        top: 1.2em;
        display: none;
        font-size: 12px;
    }
    ul.actions a{
        text-decoration:none !important;
        color: rgba(0,0,0, 0.6);
        font-size: 11px;
    }
    .list-group-item{
        background-color:transparent !important;
    }
    .list-group-item{
        border: none !important;
        border-radius: 0 !important;
    }
    .list-group-item:hover{
        background-color:rgba(0,0,0, 0.03) !important;
        border-radius: 0 !important;
    }
    .list-group .list-group-item ul.actions{
        display: none ;
    }

    .list-group .list-group-item:hover ul.actions{
        display:inherit;
        list-style: none;
    }
    summary::-webkit-details-marker {
        display: none;
    }
    #lastComment{
        background-color: #f4f4f4;
    }
    .form-controll {
        display: block;
        width: 100% ;
        padding: 0.375rem 0.1rem !important;
        font-size: 14px !important;
        font-weight: 400 !important;
        line-height: 1.5 !important;
        color: #55595c !important;
        background-color: transparent !important;
        background-image: none !important;
        border: none !important;
        border-radius: 0 !important;
        border-bottom: 1px solid #ccc !important;
    }

    .form-controll:focus{
        outline: 0 !important;
        border-color: rgba(3, 161, 241, 1) !important;
    }
    .conm fieldset{margin-bottom: 5px}
    .conm .list-group{margin-bottom: 5px}
    .conm form{padding:  5px}
</style>