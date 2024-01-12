
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
                
<script type="text/javascript">
	$('#prosesTutupBuku').on("click",function(){
		var penyusutanPerlengkapan = $('#nominalPenyusutanPerlengkapan').val();
		var length = $('input[name=piutang]:checked').length;
		var nominalPerlengkapan = $('#nominalPenyusutanPerlengkapan').val();

		//cadangkan piutang tak tertagih
		if(length > 0){
			var dataPiutang = [];
			$.each($("input[name='piutang']:checked"), function(){
				item = {};
				item['noPendaftaran'] = $(this).val();
				dataPiutang.push(item);
			});
		} else {
			var dataPiutang = "";
		}

		swal({   
            title: "Anda Yakin?",   
            text: "Pastikan data telah terinput dengan benar sebelum melakukan proses tutup buku",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#12a89d",   
            confirmButtonText: "Yes",   
            closeOnConfirm: false 
        }, function(){   
			var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";

            $.ajax({
				method : 'POST',
				url : '<?php echo base_url('tutupBuku/prosesTutupBuku'); ?>',
				data : {dataPiutang : JSON.stringify(dataPiutang), penyusutanPerlengkapan : penyusutanPerlengkapan,nominalPerlengkapan : nominalPerlengkapan},
				beforeSend : function(response){
					$('.portlet-body').html("<table width='100%'><tr><td align='center'><img src='"+imageUrl+"'/?</td></tr></table>");
				},
				success : function(response){
					$('.portlet-body').html("<div class='alert alert-success'>Proses Tutup Buku Berhasil</div>");
					swal("Berhasil!", "Proses Tutup Buku Berhasil", "success"); 
				}
			});
        });
	});

</script>

</body>
</html>
