<div class="head">
	<div class="icon"><span class="icosg-target1"></span> </div>
	<h2> Supplier Invoices </h2>
	<div class="right">
		<a href="<?php echo base_url() ?>admin/supplier_invoices/statement" class="btn btn-primary"><i class="glyphicon glyphicon-file"></i>Statements</a>
		<a href="<?php echo base_url() ?>admin/supplier_invoices/aging" class="btn btn-info"><i class="glyphicon glyphicon-calendar"></i>Aging Summary</a>
		<a href="<?php echo base_url('admin/supplier_invoices/paid_invoices') ?>" class="btn btn-warning"><i class="glyphicon glyphicon-list"></i> Payment Vouchers </a>
		<?php echo anchor('admin/supplier_invoices/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Invoice')), 'class="btn btn-primary"'); ?>

		<?php echo anchor('admin/supplier_invoices', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Invoices')), 'class="btn btn-primary"'); ?>

	</div>
</div>


<?php if ($supplier_invoices) : ?>
	<div class="block-fluid">
		<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<th>#</th>
				<th>Supplier</th>
				<th>Supplier Email</th>
				<th>Supplier Phone</th>
				<th>Total</th>
				<th>Paid</th>
				<th>Balance</th>
				<th><?php echo lang('web_options'); ?></th>
			</thead>
			<tbody>
				<?php
				$i = 0;
				if ($this->uri->segment(4) && ((int) $this->uri->segment(4) > 0)) {
					$i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
				}

				foreach ($supplier_invoices as $p) :
					$i++;
				?>
					<tr>
						<td><?php echo $i . '.'; ?></td>
						<td><?php echo $p->supplier; ?></td>
						<td><?php echo $p->supplier_email; ?></td>
						<td><?php echo $p->supplier_phone; ?></td>
						<td><?php echo number_format($p->total, 2) ?></td>
						<td><?php echo number_format($p->paid, 2) ?></td>
						<td><?php echo number_format($p->balance, 2) ?></td>


						<td width='30'>
							<a class="btn  btn-success" href='<?php echo base_url() ?>admin/supplier_invoices/view/<?php echo $p->id ?>'>View </a>
							<?php
							if($p->balance > 0){
							 ?>
							<a class="btn btn-primary" href='<?php echo base_url() ?>admin/supplier_invoices/pay/<?php echo $p->id ?>'>Pay</a>

							<?php }?>

						</td>
					</tr>
				<?php endforeach ?>
			</tbody>

		</table>


	</div>

<?php else : ?>
	<p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif ?>