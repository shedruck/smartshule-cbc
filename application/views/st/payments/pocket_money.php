<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">  
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                           <div class="col-md-6">					  
                                <h4 class="m-b-10"> Pocket Money </h4>
                            </div>
                            <div class="col-md-6">
                                <div class="pull-right">
								 
                 <a href="" onClick="window.print();
                    return false" class="btn btn-success"><i class="icos-printer"></i> Print</a>
				
				<?php echo anchor( 'st#finance' , '<i class="fa fa-home">
                </i> Exit', 'class="btn btn-sm btn-danger"');?> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<hr>


<div class="pm-list">

    <div class="current-balance">
	       <div class=" text-center " >
                                    <?php
									if (!empty($student->photo)):
									
									$passport = $this->portal_m->student_passport($student->photo);
									
											if ($passport)
											{
													?> 
													<image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>"  class="text-center img-circle" width="100" height="100" >
									 <?php } ?>	

									<?php else: ?>   
											<?php echo theme_image("thumb.png", array('class' => "text-center img-radius","width"=>"100","height"=>"100")); ?>
									<?php endif; ?>     
                                </div>
								
        <h3><span><?php echo ucwords($student->first_name . ' ' . $student->middle_name. ' ' . $student->last_name); ?> - <?php echo $student->cl->name; ?></span></h3>
        <h3><?php echo number_format($bal->balance, 2); ?><span>Pocket Money Balance</span></h3>
		
    </div>
    <div class="pmst">
	<br>
	<br>
        <table class=" table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th class="rttx">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($post as $p)
                {
                        $class = $p->tx_type == 1 ? 'add' : ' ';
                        $sig = $p->tx_type == 1 ? '+' : '-';
                        ?>
                        <tr>
                            <td><?php echo date('d M Y', $p->tx_date); ?></td>
                            <td><?php echo date('H:i', $p->created_on); ?></td>
                            <td><?php echo $p->tx_type == 1 ? 'Topup' : 'Withdraw'; ?></td>
                            <td><?php echo $p->description; ?></td>
                            <td class="rttb <?php echo $class; ?>"> <?php echo $sig; ?> <?php echo number_format($p->amount, 2) ?></td>
                        </tr>
                <?php } ?>
				<tr>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td><b>Balance</b></td>
				 <td > <span class="pull-right" style="border-bottom:double" ><b><?php echo number_format($bal->balance, 2); ?></b></span> </td>
				</tr>
            </tbody>
        </table>
    </div>
</div>

<style>
    * {
        box-sizing: border-box;
    }
    .pm-list {
        display: block;
        margin: 0 auto;
        max-width: 67%;
        padding: 2rem 1rem;
        width: 100%;
    }
    .pm-list .current-balance {
        background: #36a06f;
        border-radius: 10px;
        color: #fff;
        display: block;
        margin: 0 auto;
        padding: 5px;
        position: relative;
        width: 80%;
        z-index: 1;
    }
    .pm-list .current-balance h2 {
        text-align: center;
        font-size: 22px;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.4);
    }
    .pm-list .current-balance h3 {
        font-size: 14px;
        text-align: center;
        margin-top: 8px;
    }
    .pm-list .current-balance h2 span {
        display: block;
        font-size: 12px;
        letter-spacing: 1px;
        margin-top: 0.5rem;
        opacity: 0.6;
        text-transform: uppercase;
    }
    .pmst {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        margin-top: -60px;
        padding: 5.5rem 2rem 2rem 2rem;
        position: relative;
        width: 100%;
        z-index: 0;
    }
    .pmst .purchase-history {
        border: 1px solid rgba(0,0,0,0.2);
        border-collapse: collapse;
        border-radius: 10px;
        padding: 1rem;
        width: 100%;
    }
    .pmst .purchase-history td {
        padding: 1rem 1rem;
    }

    .pmst .purchase-history td:first-child {
        border-radius: 10px 0 0 10px;
    }
    .pmst .purchase-history td:last-child {
        border-radius: 0 10px 10px 0;
    }
    .pmst .purchase-history td.add {
        color: #7986cb;
        font-weight: 600;
    }
    .pmst .purchase-history thead tr {
        background: #e8eaf6;
    }
    .pmst .purchase-history thead td {
        color: #7986cb;
        font-weight: bold;
    }
    .pmst .purchase-history tbody tr:nth-child(even) {
        background: rgba(0,0,0,0.03);
    }
    @media (max-width: 600px)
    {
        body {
            font-size: 14px;
        }
        .pm-list {
            padding: 0.5rem;
            max-width: 100%;
            width: 100%;
        }
        .pm-list .current-balance 
        {
            border-radius: 5px;
            box-shadow: none;
            width: 100%;
        }
        .pmst {
            border-radius: 0;
            box-shadow: none;
            margin-top: 0;
            padding: 1rem;
        }
        .pmst .purchase-history 
        {
            border-radius: 5px;
        }

    }

</style>
