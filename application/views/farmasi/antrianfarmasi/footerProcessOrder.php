
            <!-- Footer Start -->
<footer class="footer">
    <?php echo $footer; ?>
</footer>
            <!-- Footer Ends -->
</section>
        <!-- Main Content Ends -->

        <!-- js placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url('assets'); ?>/js/jquery.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/modernizr.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/pace.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/wow.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets'); ?>/assets/chat/moment-2.2.1.js"></script>

        <!-- Counter-up -->
<script src="<?php echo base_url('assets'); ?>/js/waypoints.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets'); ?>/js/jquery.counterup.min.js" type="text/javascript"></script>

        <!-- sweet alerts -->
<script src="<?php echo base_url('assets'); ?>/assets/sweet-alert/sweet-alert.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/sweet-alert/sweet-alert.init.js"></script>

<script src="<?php echo base_url('assets'); ?>/js/jquery.app.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/notifications/notify.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/notifications/notify-metro.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/notifications/notifications.js"></script>

        <!-- Todo -->
<script src="<?php echo base_url('assets'); ?>/assets/select2/select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets'); ?>/assets/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/timepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url('assets'); ?>/ckeditor/ckeditor.js"></script>  
                
<script type="text/javascript">
	var noPendaftaran = "<?php echo $this->uri->segment(3); ?>";
	var idKategori = '';
	var search = '';
	var limitStart = '';

	tampilkanDataOrder();
	tampilkanTombolProses();
	tampilkanStatusOrder();

	function tampilkanItemModal(idKategori,search,limitStart){
		var url = "<?php echo base_url('antrianFarmasi/tampilkanItemObat'); ?>";
		$.ajax({
			method : "POST",
			url : url,
			data : {noPendaftaran : noPendaftaran, idKategori : idKategori, search : search, limitStart : limitStart},
			beforeSend : function(){
				var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";
            	$('#viewItem').html("<table width='100%'><tr><td align='center'><img src='"+imageUrl+"'/?</td></tr></table>");
			},
			success : function(response){
				$('#viewItem').html(response);
			}
		});
	}

	$(document).on("click",".hapusObat",function(){
		var idProduk = this.id;
		swal({   
            title: "Are you sure?",   
            text: "Data pesanan akan terhapus!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yes, delete it!",   
            closeOnConfirm: false 
        }, function(){   
			var urlHapusPesanan = "<?php echo base_url('antrianFarmasi/hapusPesanan'); ?>";

			$.ajax({
				method : "POST",
				url : urlHapusPesanan,
				data : {idProduk : idProduk, noPendaftaran : noPendaftaran},
				success : function(){
					swal("Deleted!", "Your imaginary file has been deleted.", "success");
					tampilkanDataOrder();
				}
			}); 
        });
	});

	$(document).on("click",".changeExpiredDate",function(){
		var url = "<?php echo base_url('antrianFarmasi/formEditTanggalExpired'); ?>";
		var idProduk = this.id;
		var noPendaftaran = $(this).data('no_pendaftaran');

		$('#expiredDateContent').load(url,{idProduk : idProduk, noPendaftaran : noPendaftaran});
		$('#smallModal').modal('show');
	});

	$(document).on("click",".pilihNoBatch",function(){
		var url = "<?php echo base_url('antrianFarmasi/formPilihNoBatch'); ?>";
		var idProduk = this.id;
		var noPendaftaran = $(this).data('no_pendaftaran');

		$('#expiredDateContent').load(url,{idProduk : idProduk, noPendaftaran : noPendaftaran});
		$('#smallModal').modal('show');
	});

	$(document).on("click",".pilihBatch",function(){
		var noBatch = this.id;
		var idProduk = $(this).data('id_produk');
		var url = "<?php echo base_url('antrianFarmasi/pilihBatchSQL'); ?>";

		$.ajax({
			method : "POST",
			url : url,
			data : {
				noBatch : noBatch,
				idProduk : idProduk, 
				noPendaftaran : noPendaftaran
			},
			success : function(){
				tampilkanDataOrder();
				$('#smallModal').modal('hide');
			}
		});
	});

	function tampilkanDataOrder(){
		var urlDataOrder = "<?php echo base_url('antrianFarmasi/dataOrderTable'); ?>";

		$.ajax({
			method : "POST",
			url : urlDataOrder,
			data : {noPendaftaran : noPendaftaran},
			success : function(response){
				$('#dataOrder').html(response);
			}
		});
	}

	function tampilkanTombolProses(){
		var urlTombolProses = "<?php echo base_url('antrianFarmasi/tombolProses'); ?>";

		$.ajax({
			method : "POST",
			url : urlTombolProses,
			data : {noPendaftaran : noPendaftaran},
			success : function(response){
				$('#tombolProses').html(response)
			}
		});

		var urlTombolItem = "<?php echo base_url('antrianFarmasi/tombolAddItem'); ?>";
	
		$.ajax({
			method : "POST",
			url : urlTombolItem,
			data : {noPendaftaran : noPendaftaran},
			success : function(response){
				$('#addItemButton').html(response)
			}
		});
	}

	function tampilkanStatusOrder(){
		var urlTampilkanStatus = "<?php echo base_url('antrianFarmasi/statusOrder'); ?>";

		$.ajax({
			method : "POST",
			url : urlTampilkanStatus,
			data : {noPendaftaran : noPendaftaran},
			success : function(response){
				$('#statusOrder').html(response)
			}
		});
	}
</script>

</body>
</html>
