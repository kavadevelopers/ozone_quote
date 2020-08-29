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
            <form method="post" action="<?= base_url('quotation/update') ?>" id="quotationSubmit">
            <div class="card">
                <div class="card-block">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Client Name <span class="-req">*</span></label>
                                <input type="text" name="client" class="form-control form-control-sm" placeholder="Client Name" value="<?= $quotation['name'] ?>" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date <span class="-req">*</span></label> 
                                <input name="date" type="text" placeholder="Date" class="form-control form-control-sm datepicker" autocomplete="off" value="<?= set_value('date',vd($quotation['date'])); ?>" required>
                                <?= form_error('date') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-mini table-bordered table-ndt">
                                <thead>
                                    <tr>
                                        <th>Manufacturer</th>
                                        <th>Part No./Description</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Margin</th>
                                        <th>Unit Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>Price Updated At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="quoteTbody"> 
                                	<?php foreach ($quotation_detail as $key => $value) { 
                                	$product = $this->db->get_where('products',['id' => $value['product']])->row_array(); ?>
                                    <tr id="tr<?= $key + 1 ?>">
                                        <td>
                                            <select class="form-control select2 quotation-manufacturer" name="manufacturer[]" id="manu<?= $key + 1 ?>" required>
                                                <option value="">-- Select Manufacturer --</option>
                                                <?php foreach ($this->general_model->list_manufacturer() as $mkey => $mvalue) { ?>
                                                    <option value="<?= $mvalue['id'] ?>" <?= $mvalue['id'] == $value['manufacturer']?'selected':'' ?>><?= $mvalue['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="prod[]" id="part<?= $key + 1 ?>" class="form-control form-control-sm part-autocomplete" placeholder="Part No./Description" value="<?= $product['part_no'] .' | '.$product['description'] ?>" required autocomplete="off"> 
                                            <input type="hidden" name="product[]" id="productId<?= $key + 1 ?>" value="<?= $value['product'] ?>">
                                        </td>
                                        <td>
                                            <input type="text" name="price[]" id="price<?= $key + 1 ?>" onkeyup="totalQuote();" class="form-control form-control-sm decimal-num" placeholder="Price" value="<?= $value['price'] ?>" required autocomplete="off"> 
                                        </td>
                                        <td>
                                            <input type="text" name="discount[]" id="discount<?= $key + 1 ?>" onkeyup="totalQuote();" class="form-control form-control-sm decimal-num" placeholder="Discount" value="<?= $value['discount'] ?>" autocomplete="off"> 
                                        </td>
                                        <td>
                                            <input type="text" name="margin[]" id="margin<?= $key + 1 ?>" onkeyup="totalQuote();" class="form-control form-control-sm decimal-num" placeholder="Margin" value="<?= $value['margin'] ?>" autocomplete="off"> 
                                        </td>
                                        <td>
                                            <input type="text" name="unitPrice[]" id="unitPrice<?= $key + 1 ?>" onkeyup="totalQuote();" class="form-control form-control-sm" placeholder="Unit Price" value="<?= $value['unit_price'] ?>" readonly> 
                                        </td>
                                        <td>
                                            <input type="text" name="qty[]" id="qty<?= $key + 1 ?>" onkeyup="totalQuote();" class="form-control form-control-sm decimal-num" placeholder="Qty" value="<?= $value['qty'] ?>" autocomplete="off" required> 
                                        </td>
                                        <td>
                                            <input type="text" name="total[]" id="total<?= $key + 1 ?>" onkeyup="totalQuote();" class="form-control form-control-sm" placeholder="Total" value="<?= $value['price'] ?>" readonly> 
                                        </td>
                                        <td>
                                            <input type="text" name="udate[]" id="udate<?= $key + 1 ?>" onkeyup="totalQuote();" class="form-control form-control-sm" placeholder="Updated At" value="<?= vd($value['udate']) ?>" readonly> 
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-mini btn-remove-row" title="Remove row" type="button"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="10" class="text-right">
                                            <button class="btn btn-primary btn-mini add-row" type="button"><i class="fa fa-plus"></i> Add rows</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-right">
                    <a href="<?= base_url('quotation') ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
                    <input type="hidden" name="id" value="<?= $quotation['id'] ?>">
                    <button class="btn btn-success" type="submit">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        // $('.manufacturer-select2').select2({
        //     ajax: { 
        //         url: '<?= base_url('import/getManufacturer') ?>',
        //         type: "post",
        //         dataType: 'json',
        //         delay: 250,
        //         data: function (params) {
        //             return {
        //                 searchTerm: params.term // search term
        //             };
        //         },
        //         processResults: function (response) {
        //             return {
        //                 results: response
        //             };
        //         },
        //         cache: true
        //     }
        // });

        $( ".part-autocomplete" ).autocomplete({
            source: function( request, response ) {
                elementID = this.element[0].id;
                ID = elementID.replace("part",'');
                $.ajax({
                    url: "<?= base_url('quotation/product_autocomplete') ?>",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term,
                        manufacturer  : $('#manu'+elementID.replace("part",'')).val()
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#price'+ID).val(ui.item.price);
                $('#discount'+ID).val(ui.item.discount);
                $('#udate'+ID).val(ui.item.date);
                $('#productId'+ID).val(ui.item.id);
                totalQuote();
            },
            change: function(event, ui) {
                if(!ui.item) {
                    $(this).val("");
                    $('#price'+ID).val("");
                    $('#discount'+ID).val("");
                    $('#udate'+ID).val("");
                    $('#productId'+ID).val("");
                    totalQuote();
                }
            }
        });


        $('#quotationSubmit').submit(function(event) {
            if($('#quoteTbody tr').length == 0){
                alert('Please Add products to continue.');
                return false;
            }
        });
    })
</script>