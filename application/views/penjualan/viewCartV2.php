<div class="row" style="margin-top: 10px;">
	<div class="col-md-12 cartMenu" style="height: 60vh;">
		<table width="100%">
			<?php
				$total = 0;
				foreach($dataCart as $row){
			?>	
			<tr style="border-bottom: solid 1px #fff;">
				<td>
					<a href="#editQtyModal" class="editQty qty<?php echo $row->id; ?>" id="<?php echo $row->id_produk; ?>" data-id_cart="<?php echo $row->id; ?>" data-toggle="modal" style="color: white;">
					<table width="100%" id="row<?php echo $row->id; ?>" style="font-size: 12px;">
						<tr>
							<td width="65%" style="color: black;">
								<?php 
									echo substr($row->nama_produk, 0,20); 
								?>			
							</td>
							<td style="text-align: right;font-size: 12px;color: black;" rowspan="2">
								<?php 

									$harga = $row->qty*$row->harga;
									$percentageDiskon =(($harga-($harga-$row->diskon))/$harga)*100;

									if($row->diskon==0){
										echo number_format($harga,'0',',','.'); 
									} else {
										echo  "<label class='label label-danger'>".number_format($percentageDiskon,'0',',','.')."%</label><strike>".number_format($harga,'0',',','.')."</strike>"."<br>";
										echo number_format($harga-$row->diskon,'0',',','.');
									}
								?>		
							</td>
						</tr>

						<tr style="height: 25px;color: black;">
							<td colspan="2">
								<label class="label label-success"><?php echo $row->qty; ?></label> x <?php echo number_format($row->harga,'0',',','.'); ?>
							</td>
						</tr>
					</table>
					</a>
				</td>	

				<td style="text-align: right;color: black;" width="7%"><a class="hapusCart" id="<?php echo $row->id_produk; ?>"><i class="fa fa-trash"></i></a></td>
			</tr>
			<?php } ?>
		</table>
	</div>
</div>


<div id="editQtyModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
           	<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="mySmallModalLabel">Edit Qty</h4>
            </div>

            <div class="modal-body modalEditQTY">
                                              
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	$('.cartMenu').niceScroll();

	$('.editQty').on("click",function(){
		var idProduk = this.id;

		var urlEdit = "<?php echo base_url('penjualan/editQtyModal'); ?>";
		$('.modalEditQTY').load(urlEdit,{idProduk : idProduk});
	});

	function updateQtyCart(idProduk,qty,id){
        var urlUpdate = "<?php echo base_url('penjualan/updateQtyCart'); ?>";

        $.ajax({
        			method : "POST",
        			url : urlUpdate,
        			dataType : 'json',
        			data : {qty : qty, idProduk : idProduk, id : id},
        			success : function(response){
        						$.each(response, function(x,obj){
					                var harga = obj.harga;
					        		var diskon = obj.diskon;

					        		var totalHarga = harga*qty;
					        		var grandTotal = (harga*qty)-diskon;

					        		$('#totalHarga'+id).text(formatAngka(totalHarga));
									$('#grandTotal'+id).text(formatAngka(grandTotal));
					                $('#diskon'+id).val(diskon);                       
					            });

					         	viewPricePanel();
        					  }
        });
    }

    function viewCartPerRow(id){
    	var urlCartPerRow = "<?php echo base_url('penjualan/viewCartPerRow'); ?>";

    	$('#row'+id).load(urlCartPerRow,{id : id});
    }

    $('.hapusCart').on("click",function(){
    	var id = this.id;

    	urlHapus = "<?php echo base_url('penjualan/hapusCart'); ?>";

    	$.ajax({
    				method 	: "POST",
    				url : urlHapus,
    				data : {idProduk : id},
    				success : function(){
    					var dataUrl = "<?php echo base_url('penjualan/viewCart'); ?>";
                		$('#data-input').load(dataUrl);
                		tampilkanDaftarHarga();
    				}
    	});
    });
</script>

