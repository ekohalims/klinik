<footer class="footer">
    <?php echo $footer; ?>
</footer>

</section>

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
	tampilkanKartuAtauButton();

    // Select2
    jQuery(".select2").select2({
        width: '100%'
    });

    $('#poliklinik').change(function(){
    	var idPoli = $(this).val();

    	var urlGetDokter = "<?php echo base_url('pasienBaru/dropdownDokterPoli'); ?>";

    	$('#dokter').load(urlGetDokter,{idPoli : idPoli});
    });

    $(document).on("click",'#submitPendaftaran',function(){
    	var idPoliklinik = $('#poliklinik').val();
    	var idDokter = $('#dokter').val();
    	var jenisLayanan = $("input[name='layanan']:checked").val();
    	var idPasien = $('#idPasien').val();

    	var urlSubmitPendaftaran = "<?php echo base_url('pasienBaru/submitPendaftaran'); ?>";

    	$.ajax({
    		method : "POST",
    		url : urlSubmitPendaftaran,
    		data : {idPoliklinik : idPoliklinik, idDokter : idDokter, jenisLayanan : jenisLayanan,idPasien : idPasien},
    		beforeSend : function(){
    			$('#submitPendaftaran').prop("disabled",true);
    			$('#submitPendaftaran').text("Harap Tunggu...");	
    		},
    		success : function(){
    			location.reload();
    		},
    		error : function(){
    			alert("Pendaftaran Gagal");
    		}
    	});
    });

    function tampilkanKartuAtauButton(){
    	var idPasien = $('#idPasien').val();

    	$.ajax({
    		method : "POST",
    		data : {idPasien : idPasien},
    		url : "<?php echo base_url('pasienBaru/kartuOrButton'); ?>",
    		success : function(response){
    			$('#kartuOrButton').html(response);
    		}
    	});
    }
</script>

</body>
</html>
