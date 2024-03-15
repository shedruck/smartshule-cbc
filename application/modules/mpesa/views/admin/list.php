<div class="head">
	<div class="icon"><span class="icosg-target1"></span> </div>
	<h2> MPESA PAYMENTS </h2>
	<div class="right">



	</div>
</div>




<div class="block-fluid">
	<?php echo form_open(base_url('admin/kcb_payments/freeze_kcb'), ['id' => 'freezer']) ?>
	<table class="" cellpadding="0" cellspacing="0" width="100%" id="pays">
		<thead>
			<th>#</th>
			<th width="10%">Transaction Date</th>
			<th>Transaction Reference</th>
			<th>Paid By</th>
			<th>Phone</th>
			<th>Amount</th>
			<th>Reference</th>
			<th>..</th>
		</thead>

	</table>

	<hr>
	<br>


	<?php echo form_close() ?>


</div>
<?php
$students = $this->ion_auth->students_full_details();


?>
<div class="modal" id="processs">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div id="std_name">Process Payment</div>

				<button type="button" class="close" onclick="close_modal()" aria-hidden="true">×</button>
			</div>

			<div class="modal-body">
				<?php echo form_open(base_url('admin/mpesa/post_payment'), ['id' => 'proc_form']) ?>
				<input type="hidden" name="payment" id="paymentt">

				<div class="clone">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Student</th>
								<th>Amount</th>
							</tr>
						</thead>

						<tbody id="tableBody">
							<tr>
								<td>
									<?php echo form_dropdown('student[]', ['' => ''] + $students, $this->input->post('student'), 'class="select select2"') ?>
								</td>

								<td>
									<input type="number" min="1" name="amount[]" id="amountr" class="form-control">
								</td>
							</tr>
						</tbody>
					</table>

				</div>


				<button class="btn btn-primary btn-sm" id="addRow" role="button">Add New Line</button>
				<button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')" id="removeRow" role="button">Remove</button>

				<br>
				<!-- <hr> -->
				<button class="btn btn-success btn-lg right" onclick="return confirm('Are you sure?')"><span class="glyphicon glyphicon-arrow-right"></span>Process</button>
				<br>
				<br>
				<?php echo form_close() ?>
				<!-- <div id="recent"></div> -->
			</div>
			<div class="modal-footer">
				<a href="#" onclick="close_modal()" class="btn">Close</a>
			</div>
		</div>
	</div>
</div>
</div>





<script type="text/javascript">
	$(document).ready(function() {
		$('#pays').DataTable({
			'processing': true,
			'serverSide': true,
			'serverMethod': 'get',
			'ajax': {
				'url': '<?php echo  base_url('admin/mpesa/get_logs') ?>',

			},
			dom: 'lBfrtip',
			'columns': [{
					data: 'index'
				},
				{
					data: 'transaction_date'
				},
				{
					data: 'transaction_no'
				},
				{
					data: 'by'
				},
				{
					data: 'phone'
				},
				{
					data: 'amount'
				},
				{
					data: 'reg_no'
				},
				// 


				{
					data: 'check'
				},

			],
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5'
			],
			columnDefs: [{
				targets: 'select2', // CSS class to target the column
				render: function(data, type, row) {
					if (type === 'display') {
						return '<select class="select2">' + data + '</select>';
					}
					return data;
				},
				// Initialize Select2 when the column is created
				createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
					if (colIndex === 8) { // Assuming 'dropdwn' column is the 9th (zero-based index)
						$(cell).find('.select2').select2();
					}
				}
			}]
		});


	});


	$('#addRow').on('click', function(event) {
		event.preventDefault();

		var clonedRow = $('#tableBody tr:last').clone();

		$('#amountr').val('');

		// Remove Select2 classes and destroy instances
		clonedRow.find('.select2-container').remove();
		clonedRow.find('select').select2({
			'width': '100%'
		}); // Reinitialize Select2
		clonedRow.find('input[name="amount[]"]').val('');

		$('#tableBody').append(clonedRow);
	});

	$('#removeRow').on('click', function(event) {
		event.preventDefault();
		if ($('#tableBody tr').length > 1) {
			$('#tableBody tr:last').remove();
		}
	});







	function process_payments(Rec) {

		$('#paymentt').val(Rec);

		$.ajax({
			url: "<?php echo base_url('admin/mpesa/get_payment') ?>",
			type: "POST",
			data: {
				'rec': Rec
			},

			success: function(data) {
				var res = $.parseJSON(data);

				$('#amountr').val(res.amount);

			}
		});
	}


	$("#proc_form").on('submit', (function(e) {
		e.preventDefault();
		$.ajax({
			url: "<?php echo base_url('admin/mpesa/post_payment') ?>",
			type: "POST",
			contentType: false,
			cache: false,
			processData: false,

			data: new FormData(this),

			success: function(data) {
				var res = $.parseJSON(data);
				notify('Info', res.Response);
				setTimeout(function() {
					location.reload();
				}, 2000);
			}
		})
	}))

	function close_modal() {
		$('#processs').modal('toggle');
		location.reload();
	}

	function get_details(id) {
		var banks = ['', 'Absa Bank', 'Kenya Commercial Bank', 'Equity Bank', 'Cooperative Bank'];

		$.ajax({
			url: "<?php echo base_url('admin/mpesa/get_kcb_payment') ?>",
			type: "POST",
			data: {
				'id': id
			},
			success: function(data) {
				var res = $.parseJSON(data);
				$('#date').text(timeConverter(res.date));
				$('#tx_id').text(res.transactionID);
				$('#amt').text(numberWithCommas(res.transactionAmt));
				$('#max').val(res.transactionAmt);
				$('#bal').text(numberWithCommas(res.transactionAmt));
				$('#nara').text(res.narration);
				$('#tt').html(`<h2> Student : ` + res.firstName + ' ' + res.middleName + ' ' + res.lastName + `</h2>`); //title
				$('#student').val(res.student.id);
				$("#student").prop("selected", true);

				//form
				$('#statement').val(res.id);
				$('#tx').val(res.transactionID);
				$('#p_date').val(res.date);
				$('#payment_date').val(form_date(res.date))
			}
		});
	}

	function timeConverter(UNIX_timestamp) {
		var a = new Date(UNIX_timestamp * 1000);
		var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		var year = a.getFullYear();
		var month = months[a.getMonth()];
		var date = a.getDate();
		var hour = a.getHours();
		var min = a.getMinutes();
		var sec = a.getSeconds();
		var time = month + ' ' + date + ',' + year;
		return time;
	}

	function form_date(UNIX_timestamp) {
		var a = new Date(UNIX_timestamp * 1000);
		var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		var year = a.getFullYear();
		var month = a.getMonth() + 1;
		var date = a.getDate();
		var hour = a.getHours();
		var min = a.getMinutes();
		var sec = a.getSeconds();
		var time = month + '/' + date + '/' + year;
		return time;
	}

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}


	// clone table
	$(function() {


		$('#btnAdd').click(function() {

			var num = $('.clonedInput').length,
				newNum = new Number(num + 1),
				newElem = $('#entry' + num).clone(true).attr('id', 'entry' + newNum).fadeIn('slow');
			newElem.find('.heading-reference').attr('id', 'reference').attr('name', 'reference').html(' ' + newNum);


			newElem.find('.amount').attr('id', 'ID' + newNum + '_amount').val('');
			newElem.find('.student').attr('id', 'ID' + newNum + '_student').val('');
			newElem.find('.description').attr('id', 'ID' + newNum + '_description').val('');
			newElem.find('.statement').attr('id', 'ID' + newNum + '_statement').val('');
			newElem.find('.siblings').attr('id', 'ID' + newNum + '_siblings').val('');




			$('#entry' + num).after(newElem);

			newElem.find('.select2-container').remove();
			newElem.find('select').select2({
				'width': '100%',
				'border': 'solid 5px red'
			});

			$('#btnDel').attr('disabled', false);

			if (newNum == 100)
				$('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
		});


		$('#btnDel').click(function() {
			if (confirm("Are you sure you wish to remove this section? This cannot be undone.")) {
				var num = $('.clonedInput').length;
				$('#entry' + num).slideUp('slow', function() {
					$(this).remove();
					if (num - 1 === 1)
						$('#btnDel').attr('disabled', true);
					$('#btnAdd').attr('disabled', false);
					$('#btnAdd').attr('disabled', false).prop('value', "add section");
					$('#sum').text(numberWithCommas(calcSum()));
				});
			}
			return false;

			$('#btnAdd').attr('disabled', false);
		});



		$('#btnDel').attr('disabled', true);

		$(".xsel").select2({
			'placeholder': 'Please Select',
			'width': '100%'
		});
		$(".xsel").on("change", function(e) {
			notify('Select', 'Value changed: ' + e.val);
		});
	});


	function validate_fee() {
		var max = $('#max').val();
		$('#sum').text(numberWithCommas(calcSum()));
		var bal = (Number(max) - calcSum());
		$('#bal').text(numberWithCommas(bal));

		// console.log(tot);
		// console.log(max);

		if (Number(calcSum()) > Number(max)) {
			notify('Exceeded Maximum amount of ' + numberWithCommas(max));
			$('#btnAdd').attr('disabled', true);
			$('#btnSave').attr('disabled', true);
		} else if (Number(calcSum()) == Number(max)) {
			notify('Used up ' + numberWithCommas(max));
			$('#btnAdd').attr('disabled', true);
			$('#btnSave').attr('disabled', false);
		} else if (Number(calcSum()) < Number(max)) {
			$('#btnSave').attr('disabled', true);
		} else {
			$('#btnAdd').attr('disabled', false);
			$('#btnSave').attr('disabled', false);
		}
	}

	function calcSum() {
		var tamount = 0;
		$('input[name="amount[]"]').each(function() {
			if ($('#payment_date').val() == '') {
				$('#btnSave').attr('disabled', true);
				notify(' Payment Date is required');
			} else {
				$('#btnSave').attr('disabled', false);
			}
			tamount += parseInt(($(this).val() ? $(this).val() : 0));
		});

		return tamount;
	}
</script>



<style>
	.tag {
		display: inline-block;

		width: auto;
		height: 38px;

		background-color: #008000;
		-webkit-border-radius: 3px 4px 4px 3px;
		-moz-border-radius: 3px 4px 4px 3px;
		border-radius: 3px 4px 4px 3px;

		border-left: 1px solid #008000;

		/* This makes room for the triangle */
		margin-left: 19px;

		position: relative;

		color: white;
		font-weight: 300;
		font-family: 'Source Sans Pro', sans-serif;
		font-size: 22px;
		line-height: 38px;

		padding: 0 10px 0 10px;
	}

	/* Makes the triangle */
	.tag:before {
		content: "";
		position: absolute;
		display: block;
		left: -19px;
		width: 0;
		height: 0;
		border-top: 19px solid transparent;
		border-bottom: 19px solid transparent;
		border-right: 19px solid #008000;
	}

	/* Makes the circle */
	.tag:after {
		content: "";
		background-color: white;
		border-radius: 50%;
		width: 4px;
		height: 4px;
		display: block;
		position: absolute;
		left: -9px;
		top: 17px;
	}

	#submit-btn {
		width: 100%;
		height: 30px;
		border: solid black .5px;
	}

	#submit-btn:disabled {
		background-color: gray;
	}

	.scroll {

		overflow-x: hidden;
		overflow-y: auto;
	}

	@media (min-width: 768px) {
		.modal-xl {
			width: 90%;
			max-width: 1500px;
		}
	}
</style>