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
        <!-- Chat -->
        <script src="<?php echo base_url('assets'); ?>/js/jquery.chat.js"></script>
        <!-- Dashboard -->
        <script src="<?php echo base_url('assets'); ?>/js/jquery.dashboard.js"></script>

        <!-- Todo -->
        <script src="<?php echo base_url('assets'); ?>/js/jquery.todo.js"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/select2/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/timepicker/bootstrap-datepicker.js"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/notifications/notify.min.js"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/notifications/notify-metro.js"></script>
        <script src="<?php echo base_url('assets'); ?>/assets/notifications/notifications.js"></script>

        <script type="text/javascript">
        	var urlInvoiceRetur = "<?php echo base_url('penjualan/invoiceRetur'); ?>";

            $('.invoiceNo').keypress(function (e) {
             var key = e.which;
             if(key == 13){
                cariInvoice();
              }
            }); 

            $('#noInvoiceSubmit').on("click",function(){
                cariInvoice();
            });

            function cariInvoice(){
                var noInvoice = $('.invoiceNo').val();

                var urlCariInvoice = "<?php echo base_url('penjualan/returSearch'); ?>";

                $.ajax({
                    method : "POST",
                    url : urlCariInvoice,
                    dataType : 'json',
                    data : {noInvoice : noInvoice},
                    beforeSend : function(){
                        $('#loading').html("<img src='<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>'>");
                    },
                    success : function(response){
                        $.each(response,function(x,obj){
                            $('#tanggal').text(obj.tanggal);
                            $('#jenisPembayaran').text(obj.jenisPembayaran);
                            $('#namaCustomer').text(obj.namaCustomer);
                            $('#noHP').text(obj.noHP);
                            $('#alamat').text(obj.alamat);
                        });

                        tampilkanDataItem(noInvoice);
                    }
                });
            }

            function tampilkanDataItem(noInvoice){
                var urlDataRetur = "<?php echo base_url('penjualan/dataRetur'); ?>";

                $.ajax({
                    method : "POST",
                    url : urlDataRetur,
                    data : {noInvoice : noInvoice},
                    success : function(response){
                        $('#dataRetur').html(response);
                    }
                });
            }


        	$('#submit-retur').on("click",function(){
        		jsonObj = [];

                var noInvoice = $('#noInvoice').val();

		    	$('input[id=produk]').each(function(){
		    		var idProduk = $(this).data('id_produk');
		    		var hargaJual = $(this).data('harga');
		    		var qty = $(this).val();
		    		var diskon = $(this).data('diskon');

		    		item = {};

		    		item['idProduk'] = idProduk;
		    		item['hargaJual']  = hargaJual;
		    		item['qty']   = qty;
		    		item['diskon']   = diskon;

		    		jsonObj.push(item);
		    	});

		    	$.ajax({
		    				method : "POST",
		    				url : "<?php echo base_url('penjualan/returPenjualanSQL'); ?>",
		    				data : {noInvoice : noInvoice, dataProduk : JSON.stringify(jsonObj)},
		    				beforeSend : function(){
		    								$('#submit-retur').prop('disabled',true);
		    								$('#submit-retur').text('Harap Tunggu...');
		    							 },
		    				success : function(response){
		    							$.Notification.notify('success', 'top right', 'Sukses', 'Data Berhasil Diretur');
		    							$('#submit-retur').prop('disabled',false);
		    							$('#submit-retur').text('Simpan');
                                        tampilkanDataItem(noInvoice);

                                        var urlRedirect = "<?php echo base_url('penjualan/printInvoiceRetur?noRetur='); ?>"+response;
                                        window.open(urlRedirect,"_blank");
		    						  }
		    	});
        	});

            $(document).on("change",'.jumlahRetur',function(){
                var qty = $(this).val();
                var noInvoice = $(this).data('no_invoice');
                var idProduk = $(this).data('id_produk');
                var maxRetur = $(this).data('max');

                if(parseInt(qty) > parseInt(maxRetur)){
                    $.Notification.notify('error','top right', 'Gagal', 'Melebihi jumlah retur saat ini');
                    $(this).val(0);
                }
            });
        </script>
    </body>
</html>
