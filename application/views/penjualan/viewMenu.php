<div class="row" id="pagination">
	<div class="col-md-6">
		<button id="previous" class="btn btn-default"><img src="<?php echo base_url('assets/btnleft.png'); ?>" height="20px"/> Previous </button>
	</div>

	<div class="col-md-6" style="text-align: right;">
		<button id="next" class="btn btn-default">Next <img src="<?php echo base_url('assets/btn.png'); ?>" height="20px"/></button>
		<input type="hidden" id="currentPage" value="1"/>
		<input type="hidden" id="idKategori">
	</div>
</div>

<div class="row" style="margin-top: 2px;" id="daftarMenu">
	<?php
		foreach($viewMenu->result() as $row){
	?>
	<div class="col-md-3">
		<div class="portlet"><!-- /primary heading -->
		    <div id="portlet2" class="panel-collapse collapse in">
		     	<div class="portlet-body">
		     		<div class="row">
		     			<div class="col-md-12">
							<a style="color:#12a89d;" class="produkAjax" id="<?php echo $row->id_produk; ?>">
							    <div style="text-align: center;"> 
							    	<?php
							    		if($row->image==''){
							    			$image = 'no_img.png';
							    		} else {
							    			$image = $row->image;
							    		}
							    	?>
							        <img src="<?php echo base_url('assets/produk/'.$image); ?>" alt="Product Image" style="width: 100%;">
							    </div>

							    <div>     
							        Rp. <?php echo number_format($row->harga,'0',',','.'); ?> <br> 
							        <?php 
							        	$jumlahKarakter = strlen($row->nama_produk);

							        	if($jumlahKarakter > 14){
							        		echo substr($row->nama_produk,0,14)."..."; 
							        	} else {
							        		echo $row->nama_produk;
							        	}
							        ?>
							    </div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>

<script type="text/javascript">
	var numRows = "<?php echo $numRows; ?>";
	var jumlahHalaman = "<?php echo $jumlahHalaman; ?>";

	if(numRows <= 12){
		$('#pagination').hide();
	} else {
		$("#pagination").show();
	}

	//jika halaman nilainya 1 maka disabled tombol previous
	var currentPage = $('#currentPage').val();
	buttonPagination(currentPage);

    $('#next').on("click",function(){
    	var hiddenValueCurrentPage = $('#currentPage').val();
    	var idKategori = $('#idKategori').val();

    	limitStart = parseInt(hiddenValueCurrentPage)+parseInt(1);

    	$.ajax({
    				method : "POST",
    				data : {limitStart : limitStart, idKategori : idKategori},
    				url : "<?php echo base_url('penjualan/viewMenu'); ?>",
    				beforeSend : function(){
    					$('#daftarMenu').toggle('slide',{direction : 'left'},500);
    				},
    				success : function(data){
    					$('#viewMenu').html(data);

    					$('#currentPage').val(limitStart);
    					buttonPagination(limitStart);

    				}
    	});
    });

    $('#previous').on("click",function(){
    	var hiddenValueCurrentPage = $('#currentPage').val();
    	var idKategori = $('#idKategori').val();
    	limitStart = parseInt(hiddenValueCurrentPage)-parseInt(1);

    	$.ajax({
    				method : "POST",
    				data : {limitStart : limitStart, idKategori : idKategori},
    				beforeSend : function(){
    					$('#daftarMenu').toggle('slide',{direction : 'right'},500);
    				},
    				url : "<?php echo base_url('penjualan/viewMenu'); ?>",
    				success : function(data){
    					$('#viewMenu').html(data);
    					$('#currentPage').val(limitStart);
    					buttonPagination(limitStart);
    				}
    	});
    });

    function buttonPagination(currentPage){
    	if(currentPage==1){
	       	$('#previous').prop("disabled",true);
	    } else {
	    	$('#previous').prop("disabled",false);
	    }

	    if(currentPage==jumlahHalaman){
	    	$('#next').prop("disabled",true);
	    } else {
	    	$('#next').prop("disabled",false);
	    }
    }
</script>

