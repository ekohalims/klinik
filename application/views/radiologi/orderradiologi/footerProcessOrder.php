
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
	tampilkanDataOrder();
	tampilkanTombolProses();
	tampilkanStatusOrder();
	tampilkanFormDokterPemeriksa();

	$(document).on("click",".hasilLab",function(){
		var id = this.id;
		var urlHasilLab = "<?php echo base_url('orderRadiologi/formHasilLab'); ?>";

		$.ajax({
			method : "POST",
			url : urlHasilLab,
			data : {id : id, noPendaftaran : noPendaftaran},
			beforeSend : function(){
				$(".modal-body").text("Memuat data...");
			},
			success : function(response){
				$(".modal-body").html(response);
			}
		});

		$('#myModal').modal('show');
	});

	$('#saveHasil').on("click",function(){
		var hasil = CKEDITOR.instances['editor1'].getData();
		var id = $('#id').val();
		var urlSaveHasil = "<?php echo base_url('orderRadiologi/saveHasilOrder'); ?>";

		$.ajax({
			method : "POST",
			url : urlSaveHasil,
			data : {hasil : hasil, id : id, noPendaftaran : noPendaftaran},
			success : function(){
				$('#myModal').modal('hide');
			}
		});
	});

	function tampilkanDataOrder(){
		var urlDataOrder = "<?php echo base_url('orderRadiologi/dataOrderTable'); ?>";

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
		var urlTombolProses = "<?php echo base_url('orderRadiologi/tombolProses'); ?>";

		$.ajax({
			method : "POST",
			url : urlTombolProses,
			data : {noPendaftaran : noPendaftaran},
			success : function(response){
				$('#tombolProses').html(response)
			}
		});

		var urlTombolAddItem = "<?php echo base_url('orderRadiologi/tombolAddItem'); ?>";
	
		$.ajax({
			method : "POST",
			url : urlTombolAddItem,
			data : {noPendaftaran : noPendaftaran},
			success : function(response){
				$('#tombolAddItem').html(response)
			}
		});
	}

	function tampilkanStatusOrder(){
		var urlTampilkanStatus = "<?php echo base_url('orderRadiologi/statusOrderLab'); ?>";

		$.ajax({
			method : "POST",
			url : urlTampilkanStatus,
			data : {noPendaftaran : noPendaftaran},
			success : function(response){
				$('#statusOrder').html(response)
			}
		});
	}

	function tampilkanFormDokterPemeriksa(){
		var urlTampilkanDokterPemeriksa = "<?php echo base_url('orderRadiologi/tampilkanDokterPemeriksa'); ?>";

		$.ajax({
			method : "POST",
			url : urlTampilkanDokterPemeriksa,
			data : {noPendaftaran : noPendaftaran},
			success : function(response){
				$('#dokterPemeriksaForm').html(response);
			}
		});
	}
</script>

</body>
</html>
