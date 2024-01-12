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
            jQuery(".select2").select2({
                width: '100%'
            });

            jQuery('.datepicker').datepicker({
                format: "yyyy-mm-dd",
                autoclose : true
            });

            $('#poli').on("change",function(){
                var idPoli = $(this).varal();
                var urlPoli = "<?php echo base_url('laporan/dropdownDokter'); ?>"; 

                $('#dokterForm').load(urlPoli,{idPoliklinik : idPoli});
            });

            $('#dataPasien').select2({
                placeholder: "--Cari Pasien--",
                ajax: {
                    url         : '<?php echo base_url('laporan/select2Pasien'); ?>',
                    dataType    : 'json',
                    quietMillis : 500,
                    method      : "GET",
                    data: function (params) {
                        return {
                            term : params
                        };
                    },
                    results: function (data) {
                        var myResults = [];
                        $.each(data, function (index, item) {
                            myResults.push({    
                                'id': item.id,
                                'text': item.text,
                            });
                        });
                        return {
                            results: myResults
                        };
                    }
                },
                minimumInputLength: 3,
            });

            $('#viewReport').on("click",function(){
                var dateStart = $('#dateStart').val();
                var dateEnd = $('#dateEnd').val();
                var poli = $('#poli').val();
                var dokter = $('#dokter').val();
                var typeBayar = $('#typeBayar').val();
                var subAccount = $('#subAccountValue').val();
                var pasien = $('#dataPasien').val();
                var jenis = $('#jenisPasien').val();
                var urlViewReport = "<?php echo base_url('laporan/viewReportPendapatan'); ?>";

                var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";

                $.ajax({
                    method : "POST",
                    url : urlViewReport,
                    data : {dateStart : dateStart, dateEnd : dateEnd, poli : poli, dokter : dokter, pasien : pasien,typeBayar : typeBayar, subAccount : subAccount, jenis : jenis},
                    beforeSend : function(){
                        $('#viewReportData').html("<table width='100%'><tr><td align='center'><img src='"+imageUrl+"'/?</td></tr></table>");
                    },
                    success : function(response){
                        var urlButton = "<?php echo base_url('laporan/buttonExport'); ?>";
                        $('#viewReportData').html(response);
                        $('#buttonPrint').load(urlButton);
                    }
                });
            });

            $('#typeBayar').change(function(){
                var id = $(this).val();
                var urlAccount = "<?php echo base_url('laporan/subAccount'); ?>";

                if(id==2 || id==3 || id==4){
                    $('#subAccount').load(urlAccount,{id : id},function(){
                        $('#subAccountValue').select2({
                            width : '100%'
                        });
                    });
                }
            });
        </script>
    </body>
</html>
