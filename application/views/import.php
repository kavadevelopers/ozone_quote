<div class="page-header">
    <div class="row align-items-end">
        <div class="col-md-12">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4><?= $_title ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>


<?php if($this->session->flashdata('error') && !empty($this->session->flashdata('error'))){ ?>
<div class="page-body">
    <div class="row">
        <div class="col-md-6">
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error') ?>         
            </div>      
        </div>
    </div>
</div>
<?php } ?>

<?php if($this->session->flashdata('msg') && !empty($this->session->flashdata('msg'))){ ?>
<div class="page-body">
    <div class="row">
        <div class="col-md-6">
            <div class="alert alert-success">
                <?= $this->session->flashdata('msg') ?>         
            </div>      
        </div>
    </div>
</div>
<?php } ?>

<div class="page-body">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <form method="post" action="<?= base_url('import/read') ?>" enctype="multipart/form-data">
                    <div class="card-block">
                        <div class="row">

                        	<div class="col-md-4">
                                <div class="form-group">
                                    <label>Manufacturer <span class="-req">*</span></label>
                                    <select class="form-control manufacturer-select2" name="manufacturer" required>
                                        <option value="">-- Select Manufacturer --</option>
                                    </select>
                                </div>
                            </div> 

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select File (.xlsx)<span class="-req">*</span></label> 
                                    <input type="file" name="file" class="form-control" onchange="excelAlowed(this)" required>
                                </div>
                            </div>

                            <div class="col-md-2 text-center">
                                <a href="<?= base_url() ?>asset/template.xlsx" class="btn btn-mini btn-primary" style="margin-top: 36px;"><i class="fa fa-download"></i> Download Template</a>        
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-mini btn-success"><i class="fa fa-upload"></i> Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(function(){
		$('.manufacturer-select2').select2({
	        ajax: { 
	           	url: '<?= base_url('import/getManufacturer') ?>',
	           	type: "post",
	           	dataType: 'json',
	           	delay: 250,
	           	data: function (params) {
	              	return {
	                	searchTerm: params.term // search term
	              	};
	           	},
	           	processResults: function (response) {
	              	return {
	                 	results: response
	              	};
	           	},
	           	cache: true
	        }
	    });
	})
</script>