<?php
    $numRows = $viewItem->num_rows();

    if($numRows > 0){
        $i = $urutanNo > 0 ? ($urutanNo*12)-12+1 : 1;
        foreach($viewItem->result() as $row){
?>
<tr>
    <td><?php echo $i; ?></td>
    <td><?php echo $row->id_produk; ?></td>
    <td><?php echo $row->nama_produk; ?></td>
    <td><?php echo $row->satuan; ?></td>
    <td><?php echo $row->kategori; ?></td>
    <td style="text-align:right;"><a class="addResep" id="<?php echo $row->id_produk; ?>"><span class="label label-success"><i class="fa fa-plus"></i></span></a></td>
</tr>
<?php $i++; } } else { ?>
<tr>
    <td colspan="6">--Belum ada data--</td>
</tr>
<?php } ?>

<script type="text/javascript">
    var numRows = "<?php echo $numRowsTotal; ?>";
	var jumlahHalaman = "<?php echo $jumlahHalaman; ?>";
    var currentPage = $('#currentPage').val();

    tampilkanJumlahData(numRows);

    function tampilkanJumlahData(numRows){
        $('#jumlahData').text("Total "+numRows+" baris data");
    }

	if(numRows <= 12){
		$('#pagination').hide();
	} else {
		$("#pagination").show();
	}

	//jika halaman nilainya 1 maka disabled tombol previous
	buttonPagination(currentPage);
	
	$('.addResep').on("click",function(){
		var idProduk = this.id;
		var url = "<?php echo base_url('antrianFarmasi/tambahItemResep'); ?>";

		$.ajax({
			method : "POST",
			url : url,
			data : {idProduk : idProduk, noPendaftaran : noPendaftaran},
			success : function(){
				$.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Berhasil menambahkan item');
				tampilkanDataOrder();
			}
		});
	});

    $('#next').on("click",function(){
    	var hiddenValueCurrentPage = $('#currentPage').val();
    	var idKategori = $('#kategori').val();
        var search = $('#pencarian').val();

    	limitStart = parseInt(hiddenValueCurrentPage)+parseInt(1);

    	$.ajax({
    				method : "POST",
    				data : {search : search, limitStart : limitStart, idKategori : idKategori},
    				url : "<?php echo base_url('antrianFarmasi/tampilkanItemObat'); ?>",
    				beforeSend : function(){
    					$('#viewItem').html("<tr><td colspan='6'>Memuat data...</td></tr>");
    				},
    				success : function(data){
    					$('#viewItem').html(data);

    					$('#currentPage').val(limitStart);
    					buttonPagination(limitStart);

    				}
    	});
    });

    $('#previous').on("click",function(){
    	var hiddenValueCurrentPage = $('#currentPage').val();
    	var idKategori = $('#kategori').val();
        var search = $('#pencarian').val();
    	limitStart = parseInt(hiddenValueCurrentPage)-parseInt(1);

    	$.ajax({
    				method : "POST",
    				data : {search : search, limitStart : limitStart, idKategori : idKategori},
    				beforeSend : function(){
    					$('#viewItem').html("<tr><td colspan='6'>Memuat data...</td></tr>");
    				},
    				url : "<?php echo base_url('antrianFarmasi/tampilkanItemObat'); ?>",
    				success : function(data){
    					$('#viewItem').html(data);
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