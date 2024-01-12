
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
	loadDataNotPayment(filter='');

	$('#cari').on("click",function(){
		var query = $('#query').val();
		var cariBerdasarkan = $('#cariBerdasarkan').val();

		var urlCari = "<?php echo base_url('kasir/cariTagihan'); ?>";

		$.ajax({
			method : "POST",
			url : urlCari,
			data : {query : query, cariBerdasarkan : cariBerdasarkan},
			beforeSend : function(){
				$('#content').text('Harap Tunggu...');
			},
			success : function(response){
				$('#content').html(response);
			}
		});
	});

	$(".filter").on("click",function(){
		var filter = this.id;
		loadDataNotPayment(filter);
	});

	function loadDataNotPayment(filter){
		var urlDataNotPayment = "<?php echo base_url('kasir/viewDataNotPayment'); ?>";
		var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";

		$.ajax({
			method : "POST",
			url : urlDataNotPayment,
			data : {filter : filter},
			beforeSend : function(){
				$('#content').html("<table width='100%'><tr><td align='center'><img src='"+imageUrl+"'/?</td></tr></table>");
			},
			success : function(response){
				$('#content').html(response);
			}
		});
	}
</script>

</body>
</html>
