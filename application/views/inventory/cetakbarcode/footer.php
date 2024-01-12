
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
<script src="<?php echo base_url('assets'); ?>/assets/printjs/print.min.js"></script>
                
<script type="text/javascript">
	loadCetak();

	$('#cetakForm').on("click",function(){
        printJS({
            printable : 'print-area',
            type : 'html',
            scanStyles : true,
            targetStyle : ['text-align','font-size','background','font-weight','vertical-align','margin-top','border','font-size','height','padding','border-width','border-collapse']
        });
    });

	$('#pilihItem').on("click",function(){
		var url = "<?php echo base_url('cetakBarcode/formProduk'); ?>";

		$('.modal-body').load(url);
	});

	$(document).on("click",".simpanBarcode",function(){
		var id = this.id;
		var qty = $('#idProduk'+id).val();
		var url = "<?php echo base_url('cetakBarcode/simpanBarcode'); ?>";

		if(qty < 1 || qty==''){
			$.Notification.autoHideNotify('error','top right', 'Error', 'Isi qty cetak dahulu'); 
		} else {

			$.ajax({
				method : "POST",
				url : url,
				data : {
					idProduk : id,
					qty : qty
				},
				success : function(){
					$.Notification.autoHideNotify('success','top right', 'Berhasil', 'Produk terpilih'); 
					loadCetak();
				}
			});
		}
	});

	$('#hapus').on("click",function(){
		var url = "<?php echo base_url('cetakBarcode/hapus'); ?>";

		$.ajax({
			method : "POST",
			url : url,
			success : function(){
				loadCetak();
			}
		});
	});

	function loadCetak(){
		var url = "<?php echo base_url('cetakBarcode/dataCetak'); ?>";
		$('#print-area').load(url);
	}
</script>

</body>
</html>
