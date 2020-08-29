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
		<div class="col-md-4">
            <div class="card">
                <form method="post" action="<?= base_url('manufacturer/save') ?>">
                    <div class="card-block">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name <span class="-req">*</span></label>
                                <input name="name" type="text" class="form-control" value="<?= set_value('name'); ?>" placeholder="Name" autocomplete="off">
                                <?= form_error('name') ?>
                            </div>
                        </div>               
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-success btn-mini">
                            <i class="fa fa-plus"></i> Add
                        </button>
                    </div>
                </form>
            </div>
        </div>
		<div class="col-md-8">
			<div class="card">
		        <div class="card-block dt-responsive table-responsive">
		            <table class="table table-striped table-bordered table-mini table-ndt" id="dtAjax">
		                <thead>
		                    <tr>
		                        <th>Name</th>
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
			"order": [[0, "desc" ]],
			"ajax":{
				url :  "<?= base_url('manufacturer/datatable') ?>",
				type : 'POST'
			},
			"columnDefs": [
				{
			       "className": "text-center", "targets": [1]
			    },
			    { "targets": [1], "searchable": false, "orderable": false, "visible": true }
		    ]
		  });
	})
</script>