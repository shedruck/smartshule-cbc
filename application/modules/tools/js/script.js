$(document).ready(function() {
	//for Caching
	var $content = $('#content');
	
	$content.find('.editable').editable(SITE_URL+'admin/contractors/suppliers/edit', { 
         id: 'supplier_id',
		 name: 'supplier_name',
    });
	
	$content.find('.delete').click(function(e) {
		var $this = $(this);
		var id = $this.attr('id').split("delete-")[1];
		$.ajax({
			url: SITE_URL+'admin/contractors/suppliers/delete',
			data: {supplier_id: id},
			type: "POST",
			success: function(msg) 
			{ 
			if(msg === 'success');
				$this.parent().parent().fadeOut();
			}
		});
		e.preventDefault();
	});
	
	
	if($content.find('#add_suppliers').length)
	{
	 //$content.find('#submit_add_suppliers').parent().parent().ajaxContractors('suppliers', {method: 'add'});
	}
	
	
});
		