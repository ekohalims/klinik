 <!-- Page Content Ends -->
            <!-- ================== -->

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
            var urlDetailOrder = "<?php echo base_url('bahan_masuk/detailOrder'); ?>";
            var urlInvoiceReceive = "<?php echo base_url('bahan_masuk/invoiceReceive'); ?>";
            var urlRiwayatPenerimaan = "<?php echo base_url('bahan_masuk/riwayatPenerimaan'); ?>";

            $(document).ready(function(){
                var nopo = "<?php echo $_GET['no_po']; ?>";

                $('#detailOrder').load(urlDetailOrder,{noPo : nopo});
                $('#invoiceReceive').load(urlInvoiceReceive,{noPo : nopo});
                $('#riwayatPenerimaan').load(urlRiwayatPenerimaan,{noPo : nopo});
            });

            // Select2
            jQuery(".select2").select2({
                width: '100%'
            });

            jQuery('.datepicker').datepicker({
                format: "yyyy-mm-dd",
                autoclose : true
            });

            $('#user_form').on("submit",function(){
                event.preventDefault();

                var noPo = $('#noPo').val();
                var form_data = $(this).serialize();

                if(diterimaOleh=='' || diperiksaOleh=='' || diterimaDi==''){
                    if(diterimaOleh==''){
                        $('#diterimaAlert').text("**Harap Isi Form Berikut");
                    }

                    if(diperiksaOleh==''){
                        $('#diperiksaAlert').text("**Harap Isi Form Berikut");
                    }

                    if(diterimaDi==''){
                        $('#diterimaDiAlert').text("**Harap Pilih Salah Satu");
                    }
                } else {
                    $.ajax({
                        method  : "POST",
                        url     : "<?php echo base_url('bahan_masuk/prosesReceiveItem'); ?>",
                        data    : form_data,
                        beforeSend : function(){
                            $('#submitPenerimaan').text('Harap Tunggu...');
                            $('#submitPenerimaan').prop('disabled',true);
                        },
                        success : function(response){
                            $('#detailOrder').load(urlDetailOrder,{noPo : noPo});
                            $('#invoiceReceive').load(urlInvoiceReceive,{noPo : noPo});
                            $('#riwayatPenerimaan').load(urlRiwayatPenerimaan,{noPo : noPo});

                            $('#submitPenerimaan').text('Submit');
                            $('#submitPenerimaan').prop('disabled',false);

                            $('.qtyAjax').val('');
                            $('#diterimaOleh').val('');
                            $('#diperiksaOleh').val('');
                            $('#diterimaDi').select2("val","");

                            var urlRedirect = "<?php echo base_url('bahan_masuk/invoice_receive?no_receive='); ?>"+response;
                            window.open(urlRedirect,"_blank");
                        },
                    });
                }
            });
            
            $('.qtyAjax').on("change",function(){
                var urlCekPenerimaan = "<?php echo base_url('bahan_masuk/qtyReceived'); ?>";
                var noPo = "<?php echo $_GET['no_po']; ?>";
                var idProduk = $(this).data('id');
                var max = $(this).data('max');
                var qty = $(this).val();
                var urut = $(this).data('urut');

                //cek penerimaan
                $.ajax({
                    method : "POST",
                    url : urlCekPenerimaan,
                    data : {idProduk : idProduk, noPo : noPo},
                    success : function(response){
                        var orderAllow = max-response;
                        if(qty > orderAllow){
                            $('#qtyProduk'+urut).val(0);
                            $.Notification.notify('error','top right', 'Ditolak', 'Nilai yang diinput melebihi jumlah order'); 
                        }
                    }
                });
            });
        </script>
    </body>
</html>
