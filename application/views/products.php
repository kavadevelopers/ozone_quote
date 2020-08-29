<div class="page-header">
    <div class="row align-items-end">
        <div class="col-md-6">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4><?= $_title ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="page-body">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
		        <div class="card-block dt-responsive table-responsive">
		            <table class="table table-striped table-bordered table-mini table-ndt" id="dtAjax">
		                <thead>
		                    <tr>
		                        <th>Manufacturer</th>
		                        <th class="text-center">Part No.</th>
		                        <th>Description</th>
		                        <th class="text-right">Unit Price</th>
		                        <th class="text-right">Discount</th>
		                        <th class="text-center">Updated On</th>
		                    </tr>
		                </thead>
		                <tbody></tbody>
		            </table>
		        </div>
		    </div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		$('#dtAjax').DataTable({
			"pageLength" : 10,
			"serverSide": true,
			"language": {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
            }, 
            "dom": "<'row'<'col-md-6'l><'col-md-6'f>><'row'<'col-md-12'tr>><'row'<'col-md-6'i><'col-md-6'p>>",
			"order": [[0, "desc" ]],
			"ajax":{
				url :  "<?= base_url('products/datatable') ?>",
				type : 'POST'
			},
			"columnDefs": [
				{
			       "className": "text-center", "targets": [1,5]
			    },
			    {
			       "className": "text-right", "targets": [3,4]
			    },
			    { "targets": [1], "searchable": false, "orderable": false, "visible": true }
		    ]
		  });
	})
</script>