<script type="text/javascript">
	$(function () {
		$(document).on('click','.btn-delete', function(){
			if(confirm('Are you sure you want to delete this?')){
				return true;
			}
			return false;
		})

		$('.table-dt').DataTable({
            "dom": "<'row'<'col-md-6'l><'col-md-6'f>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
            order : [],
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            
        });

        $('.select2').select2();












        $(document).on('change','.quotation-manufacturer', function(){
        	myval = $(this).val();
        	id = $(this).attr('id').replace("manu",'');
        	$('#part'+id).val('');
        	$('#price'+id).val("");
            $('#discount'+id).val("");
            $('#udate'+id).val("");
            $('#productId'+id).val("");
        	if(myval != ""){
        		$('#part'+id).removeAttr('readonly');
        	}else{
        		$('#part'+id).attr('readonly',true);
        	}
        	totalQuote();
        });

        var countTr = 1;
        $('.add-row').click(function(event) {
        	countTr++;
        	str = '<tr id="tr'+countTr+'">';
        		str += '<td>';
        			str += '<select class="form-control manufacturer-select2 quotation-manufacturer" name="manufacturer[]" id="manu'+countTr+'" required>';
                       	str += '<option value="">-- Select Manufacturer --</option>';
                    str += '</select>';
        		str += '</td>';
        		str += '<td>';
        			str += '<input type="text" name="prod[]" id="part'+countTr+'" class="form-control form-control-sm part-autocomplete" placeholder="Part No./Description" readonly required autocomplete="off">';
        			str += '<input type="hidden" name="product[]" id="productId'+countTr+'">';
        		str += '</td>';
        		str += '<td>';
        			str += '<input type="text" name="price[]" id="price'+countTr+'" onkeyup="totalQuote();" class="form-control form-control-sm decimal-num" placeholder="Price" required autocomplete="off"> ';
        		str += '</td>';
        		str += '<td>';
        			str += '<input type="text" name="discount[]" id="discount'+countTr+'" onkeyup="totalQuote();" class="form-control form-control-sm decimal-num" placeholder="Discount" autocomplete="off">';
        		str += '</td>';
        		str += '<td>';
        			str += '<input type="text" name="margin[]" id="margin'+countTr+'" onkeyup="totalQuote();" class="form-control form-control-sm decimal-num" placeholder="Margin" autocomplete="off"> ';
        		str += '</td>';
        		str += '<td>';
        			str += '<input type="text" name="unitPrice[]" id="unitPrice'+countTr+'" onkeyup="totalQuote();" class="form-control form-control-sm" placeholder="Unit Price" readonly> ';
        		str += '</td>';
        		str += '<td>';
        			str += '<input type="text" name="qty[]" id="qty'+countTr+'" onkeyup="totalQuote();" class="form-control form-control-sm decimal-num" placeholder="Qty" autocomplete="off" required> ';
        		str += '</td>';
        		str += '<td>';
        			str += '<input type="text" name="total[]" id="total'+countTr+'" onkeyup="totalQuote();" class="form-control form-control-sm" placeholder="Total" readonly> ';
        		str += '</td>';
        		str += '<td>';
        			str += '<input type="text" name="udate[]" id="udate'+countTr+'" onkeyup="totalQuote();" class="form-control form-control-sm" placeholder="Updated At" readonly> ';
        		str += '</td>';
        		str += '<td class="text-center">';
        			str += '<button class="btn btn-danger btn-mini btn-remove-row" title="Remove row" type="button"><i class="fa fa-trash"></i></button>';
        		str += '</td>';
        	str += '</tr>';


        	$('#quoteTbody').append(str);

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
	                }
	                totalQuote();
	            }
	        });
        });


        $('.btn-remove-row').click(function(event) {
        	$(this).closest('tr').remove();
        });
	})


	function totalQuote () {
		$('#quoteTbody tr').each(function() { 
		   	id = $(this).attr('id').replace('tr','');
		   	price = $('#price'+id).val(); if(price != ""){ price = parseFloat(price); }else{ price = 0.00; }
		   	discount = $('#discount'+id).val(); if(discount != ""){ discount = parseFloat(discount); }else{ discount = 0.00; }
		   	margin = $('#margin'+id).val(); if(margin != ""){ margin = parseFloat(margin); }else{ margin = 0.00; }
		   	qty = $('#qty'+id).val(); if(qty != ""){ qty = parseFloat(qty); }else{ qty = 0.00; }

		   	unitprice = price - (price * discount / 100);
		   	marginPer = (100 - margin);
		   	unitprice = unitprice /  (marginPer / 100);
		   	$('#unitPrice'+id).val(unitprice.toFixed(2));
		   	total = unitprice * qty;
		   	$('#total'+id).val(total.toFixed(2));

		});
	}
	

</script>