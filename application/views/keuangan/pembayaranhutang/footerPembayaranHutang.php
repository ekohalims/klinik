
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
    var noTagihan = "<?php echo $this->uri->segment(3); ?>";

    loadHeaderTagihan();
    loadDataTagihan();
    loadFormPembayaranHutang();
    loadInformasiSupplier();
    loadRiwayatPembayaran();
    loadRiwayatPenerimaan();
    loadButtonTrx();

    $("#datatable").DataTable({
        ordering: false,
        processing: false,
        serverSide: true,
        ajax: {
           	url: "<?php echo base_url('pembayaranHutangPO/listHutangDatatables'); ?>",
           	type:'POST'
        }
    });

    $(document).on("click","#trxSelesai",function(){

            swal({   
                title: "Apa anda yakin?",   
                text: "Pastikan transaksi telah selesai dan pembayaran telah lunas",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#12a89d",   
                confirmButtonText: "Yes!",   
                closeOnConfirm: false 
            }, function(){   
                swal("Berhasil!", "Status transaksi telah berubah", "success"); 
                var urlTrxSelesai = "<?php echo base_url('pembayaranHutangPO/updateTrxSelesai'); ?>";
        
                $.ajax({
                    method : "POST",
                    url : urlTrxSelesai,
                    data : {noTagihan : noTagihan},
                    beforeSend : function(){
                        $('#trxSelesai').text("Harap tunggu...");
                        $('#trxSelesai').prop("disabled",true);
                    },
                    success : function(){
                        loadHeaderTagihan();
                        loadDataTagihan();
                        loadFormPembayaranHutang();
                        loadInformasiSupplier();
                        loadRiwayatPembayaran();
                        loadRiwayatPenerimaan();
                        loadButtonTrx();
                    }
                });
            });
   

        
    });
    
    function loadHeaderTagihan(){
        var urlHeaderTagihan = "<?php echo base_url('pembayaranHutangPO/headerTagihan'); ?>";

        $.ajax({
            method : "POST",
            url : urlHeaderTagihan,
            data : {noTagihan : noTagihan},
            success : function(response){
                $('#headerTagihan').html(response);
            }
        });
    }

    function loadDataTagihan(){
        var urlTagihan = "<?php echo base_url('pembayaranHutangPO/dataTagihan'); ?>";

        $.ajax({
            method : "POST",
            url : urlTagihan,
            data : {noTagihan : noTagihan},
            success : function(response){
                $('#dataTagihan').html(response);
            }
        });
    }

    function loadFormPembayaranHutang(){
        var url = "<?php echo base_url('pembayaranHutangPO/formPembayaranHutang'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {noTagihan : noTagihan},
            success : function(response){
                $('#formPembayaranHutang').html(response);
            }
        });
    }

    function loadInformasiSupplier(){
        var url = "<?php echo base_url('pembayaranHutangPO/informasiSupplier'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {noTagihan : noTagihan},
            success : function(response){
                $('#informasiSupplier').html(response);
            }
        });
    }

    function loadRiwayatPembayaran(){
        var url = "<?php echo base_url('pembayaranHutangPO/riwayatPembayaran'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {noTagihan : noTagihan},
            success : function(response){
                $('#riwayatPembayaran').html(response);
            }
        });
    }

    function loadRiwayatPenerimaan(){
        var url = "<?php echo base_url('pembayaranHutangPO/riwayatPenerimaan'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {noTagihan : noTagihan},
            success : function(response){
                $('#riwayatPenerimaan').html(response);
            }
        });
    }

    function loadButtonTrx(){
        var url = "<?php echo base_url('pembayaranHutangPO/buttonTrx'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {noTagihan : noTagihan},
            success : function(response){
                $('#buttonTransaksi').html(response);
            }
        });
    }
</script>

</body>
</html>
