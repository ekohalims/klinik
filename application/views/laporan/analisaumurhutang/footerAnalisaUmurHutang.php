 <!-- Page Content Ends -->
            <!-- ================== -->

            <!-- Footer Start -->
            <footer class="footer">
               <?php echo $footer; ?>
            </footer>
            <!-- Footer Ends -->
        </section>
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
        	var urlHutang = "<?php echo base_url('laporan/dataAnalisaUmurHutang'); ?>";

        	$(document).ready(function(){
        		$.ajax({
        			method : "GET",
        			url : urlHutang,
        			beforeSend : function(){
        				$('#content').html("<tr><td colspan='10'>Harap Tunggu...</td></tr>");
        			},
        			success : function(data){
        				$('#content').html(data);
        			}
        		});
        	});

            jQuery(".select2").select2({
                width: '100%'
            });

            jQuery('.datepicker').datepicker({
                format: "yyyy-mm-dd",
                autoclose : true
            });

            $('#filterHutang').on("click",function(){
            	var supplier = $('#supplier').val();
            	var url = "<?php echo base_url('laporan/dataAnalisaUmurHutang'); ?>";

            	$.ajax({
            	    method : "POST",
            		url : url,
            		data : {supplier : supplier},
            		beforeSend : function(){
        				$('#content').html("<tr><td colspan='10'>Harap Tunggu...</td></tr>");
        			},
        			success : function(data){
        				$('#content').html(data);
        				$('#myModal').modal('hide');
        			}
            	});
            });
        </script>
    </body>
</html>
