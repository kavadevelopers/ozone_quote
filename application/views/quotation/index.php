<div class="page-header">
    <div class="row align-items-end">
        <div class="col-md-6">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4><?= $_title ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-right">
            <a href="quotation/add" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Add 
            </a>
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
		                        <th class="text-center">Quotation No.</th>
		                        <th>Client Name</th>
		                        <th class="text-center">Quotation Date</th>
		                        <th class="text-center">Action</th>
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
				url :  "<?= base_url('quotation/datatable') ?>",
				type : 'POST'
			},
			"columnDefs": [
				{
			       "className": "text-center", "targets": [0,2,3]
			    },
		    ]
		  });
	})
</script>