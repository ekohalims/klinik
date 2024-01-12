 <!-- Page Content Ends -->
            <!-- ================== -->

            <!-- Footer Start -->
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
        <!-- Chat -->
        <script src="<?php echo base_url('assets'); ?>/js/jquery.chat.js"></script>
        <!-- Dashboard -->
        <script src="<?php echo base_url('assets'); ?>/js/jquery.dashboard.js"></script>

        <!-- Todo -->
        <script src="<?php echo base_url('assets'); ?>/js/jquery.todo.js"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/select2/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/timepicker/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            var tahun = '';
            tampilkanLaporanStockOpname(tahun);

            jQuery('.datepicker').datepicker({
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years",
                autoclose : true
            });

            $('#viewReport').on("click",function(){
                var tahun = $('#tahun').val();
                tampilkanLaporanStockOpname(tahun);
            });

            function tampilkanLaporanStockOpname(tahun){
                var urlViewReport = "<?php echo base_url('laporan/viewLaporanStockOpname'); ?>";

                $.ajax({
                    method : "POST",
                    url : urlViewReport,
                    data : {tahun : tahun},
                    beforeSend : function(){
                        var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";
                        $('#viewReportData').html("<table width='100%'><tr><td align='center'><img src='"+imageUrl+"'/?</td></tr></table>");
                    },
                    success : function(response){
                        var urlButton = "<?php echo base_url('laporan/buttonExport'); ?>";
                        $('#viewReportData').html(response);
                    }
                });
              
            }
        </script>
    </body>
</html>
