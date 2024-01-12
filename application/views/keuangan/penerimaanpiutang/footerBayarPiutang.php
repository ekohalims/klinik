
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
    loadDataTransaksi();
    loadRiwayatPembayaran();
    loadButtonTrx();
    loadStatusTrx();

    $('#jenisPembayaran').change(function(){
        var id = $(this).val();
        var url = "<?php echo base_url('penerimaanPiutang/subAccountForm'); ?>";
        
        if(id=='2' || id=='3' || id=='4'){
            $('#subAccountForm').load(url,{id : id});
        } else {
            $('#subAccountForm').html("<input type='hidden' value='' id='subAccount'>");
        }
    });

    $('#jumlahBayar').change(function(){
        var jumlahBayar = $(this).val();
        var urlCekMaxPay = "<?php echo base_url('penerimaanPiutang/maxPayPiutang'); ?>";

        $.ajax({
            method : "POST",
            url : urlCekMaxPay,
            data : {noPendaftaran : noPendaftaran, jumlahBayar : jumlahBayar},
            success : function(response){
                if(response=='MoreThanMax'){
                    $('#jumlahBayar').val('');
                    $.Notification.autoHideNotify('error', 'top right', 'Gagal','Nilai pembayaran melebihi sisa pembayaran');
                }
            }
        });
    });

    $('#prosesPembayaran').on("click",function(){
        var jumlahPembayaran = $('#jumlahBayar').val();
        var jenisPembayaran = $('#jenisPembayaran').val();
        var subAccount = $('#subAccount').val();
        var keterangan = $('#keterangan').val();

        var urlProsesPembayaran = "<?php echo base_url('penerimaanPiutang/prosesPembayaranPiutang'); ?>";

        if(jumlahPembayaran=='' || jenisPembayaran==''){
            $.Notification.autoHideNotify('error', 'top right', 'Gagal','Harap isi jumlah bayar dan jenis pembayaran');
        } else {
            $.ajax({
                method : "POST",
                url : urlProsesPembayaran,
                data : {noPendaftaran : noPendaftaran, jumlahPembayaran : jumlahPembayaran, jenisPembayaran : jenisPembayaran, subAccount : subAccount, keterangan : keterangan},
                beforeSend : function(){
                    $('#prosesPembayaran').prop("disabled",true);
                    $('#CssLoader').show();
                },
                success : function(){
                    $('#CssLoader').hide();
                    $.Notification.autoHideNotify('success', 'top right', 'Pembayaran Piutang Berhasil','Data telah tersimpan');
                    loadDataTransaksi();
                    loadRiwayatPembayaran();
                    loadButtonTrx();
                    loadStatusTrx();
                    $('#jumlahBayar').val('');
                    $('#keterangan').val('');
                }
            });
        }
    });

    $(document).on("click","#updateStatusTrx",function(){
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
                var url = "<?php echo base_url('penerimaanPiutang/updateStatusPiutang'); ?>";

                $.ajax({
                    method : "POST",
                    url : url,
                    data : {noPendaftaran : noPendaftaran},
                    success : function(){
                        loadButtonTrx();
                        loadStatusTrx();
                    }
                });
            });
    });

    function loadDataTransaksi(){
        var urlDataTransaksi = "<?php echo base_url('penerimaanPiutang/dataPembayaranPiutang'); ?>";

        $.ajax({
            method : "POST",
            url : urlDataTransaksi,
            dataType : "json",
            data : {noPendaftaran : noPendaftaran},
            success : function(response){
                $.each(response,function(x,obj){
                    $('#totalTransaksi').text(obj.totalTransaksi);
                    $('#terbayar').text(obj.terbayar);
                    $('#sisaPembayaran').text(obj.sisaPembayaran);
                });
            }
        });
    }

    function loadRiwayatPembayaran(){
        var urlRiwayatDataPembayaran = "<?php echo base_url('penerimaanPiutang/dataRiwayatPembayaran'); ?>";
  
        $.ajax({
            method : "POST",
            url : urlRiwayatDataPembayaran,
            data : {noPendaftaran : noPendaftaran},
            success : function(response){
                $('#riwayatPembayaran').html(response);
            }
        });
    }

    function loadButtonTrx(){
        var url = "<?php echo base_url('penerimaanPiutang/buttonPiutang'); ?>";

        $.ajax({
            method : "POST",
            data : {noPendaftaran : noPendaftaran},
            url : url,
            success : function(response){
                $('#buttonTrx').html(response);
            }
        });
    }

    function loadStatusTrx(){
        var url = "<?php echo base_url('penerimaanPiutang/statusPiutang'); ?>";

        $.ajax({
            method : "POST",
            data : {noPendaftaran : noPendaftaran},
            url : url,
            success : function(response){
                $('#statusPiutang').html(response);
            }
        });
    }
</script>

</body>
</html>
