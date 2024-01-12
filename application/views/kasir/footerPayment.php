
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
	var noPendaftaran = "<?php echo $this->uri->segment(3); ?>";

	jQuery('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        autoclose : true
    });

	$('.typeBayar').on("click",function(){
		var idPayment = this.id;

		$('#idPaymentValue').val(idPayment);

		if(idPayment==1){
			var urlCash = "<?php echo base_url('kasir/formInputCash'); ?>";
			$('#inputPaymentType').load(urlCash,{noPendaftaran : noPendaftaran});

			$('#subPaymentValue').val('');
			addClasses(idPayment);
		} else if(idPayment==2 || idPayment==3 || idPayment==4){
			var urlCard = "<?php echo base_url('kasir/formInputCard'); ?>";

			$('#inputPaymentType').load(urlCard,{noPendaftaran : noPendaftaran, idPayment : idPayment	});
			addClasses(idPayment);
		} else if(idPayment==4){
			addClasses(idPayment);
			var urlTransfer = "<?php echo base_url('kasir/formInputTransfer'); ?>";
			$('#inputPaymentType').load(urlTransfer,{noPendaftaran : noPendaftaran});

			$('#subPaymentValue').val('');
		} else if(idPayment==5){
			var urlHutang = "<?php echo base_url('kasir/formInputHutang'); ?>";
			$('#inputPaymentType').load(urlHutang,{noPendaftaran : noPendaftaran});
			addClasses(idPayment);
		}
	});

	$('#payment_total_notif').on("click",function(){
		$('#payment_total_notif').css("display","none");
	});

	function addClasses(idPayment){
		$('.btn-success').prop("disabled",false);	
		$('.btn-success').removeAttr('style');

		$('.button'+idPayment).prop("disabled",true);
		$('.button'+idPayment).css("background","#262727");
		$('.button'+idPayment).css("border","solid 1px #262727");
	}

	function formatAngka(angka) {
        if (typeof(angka) != 'string') angka = angka.toString();
        var reg = new RegExp('([0-9]+)([0-9]{3})');
        while(reg.test(angka)) angka = angka.replace(reg, '$1.$2');
        return angka;
    }

</script>

</body>
</html>
