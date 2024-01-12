
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
    var uri = $('#uri').val();

	tampilkanDataTarif();

    $('.tambahTarif').on("click",function(){
        $('#myModal').modal('show');
        $('#myModalLabel').text("Tambah Tarif");

        var url = "<?php echo base_url('tindakan/formTambahTarif'); ?>";
        var id = this.id;
        $('.modal-body').load(url,{uri : uri,id : id});
    });

    $(document).on("click",".editTarif",function(){
        $('#myModal').modal('show');
        $('#myModalLabel').text("Edit Tarif");

        var kode = this.id;
        var url = "<?php echo base_url('tindakan/formEditTarif'); ?>";
        $('.modal-body').load(url,{table : uri, kode : kode});
    });

    $(document).on("click",".hapusTarif",function(){
        var kode = this.id;

        swal({
            title: "Anda yakin?",
            text: "Data akan terhapus",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#12a89d",
            confirmButtonText: "Yes!",
            closeOnConfirm: false
        }, function(){

            var url = "<?php echo base_url('tindakan/hapusTarif'); ?>";

            $.ajax({
                method : "POST",
                url : url,
                data : {kode : kode, table : uri},
                success : function(){
                    swal("Berhasil!", "Data telah terhapus", "success");
                    tampilkanDataTarif();
                }
            });


        });
    });

    $('#simpan').on("click",function(){
        var jenis = $('#jenis').val();

        if(jenis=='tambah'){
            simpan();
        } else {
            edit();
        }
    });

    function simpan(){
        var namaTarif = $('#namaTarif').val();
        var jenisTarif = $('#jenisTarif').val();
        var tarif = $('#tarif').val();
        var sarana = $('#sarana').val();
        var dokter = $('#dokter').val();
        var bhp = $('#bhp').val();
        var alat = $('#alat').val();
        var kelas = $('#kelas').val();

        if(namaTarif=='' || tarif==''){
            $.Notification.autoHideNotify('error','top right', 'Gagal!', 'Isi form nama tarif dan tarif'); 
        } else {
            var url = "<?php echo base_url('tindakan/simpanTarif'); ?>";

            $.ajax({
                method : "POST",
                url : url,
                data : {
                    table : uri,
                    namaTarif : namaTarif,
                    jenisTarif : jenisTarif,
                    tarif : tarif,
                    sarana : sarana,
                    dokter : dokter,
                    bhp : bhp,
                    alat : alat, 
                    kelas : kelas
                },
                success : function(){
                    $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Menambahkan Tarif Baru');
                    $('#myModal').modal('hide');
                    tampilkanDataTarif();
                }
            });
        }        
    }

    function edit(){
        var namaTarif = $('#namaTarif').val();
        var jenisTarif = $('#jenisTarif').val();
        var tarif = $('#tarif').val();
        var sarana = $('#sarana').val();
        var dokter = $('#dokter').val();
        var bhp = $('#bhp').val();
        var alat = $('#alat').val();
        var kode = $('#kode').val();
        var kelas = $('#kelas').val();

        if(namaTarif=='' || tarif==''){
            $.Notification.autoHideNotify('error','top right', 'Gagal!', 'Isi form nama tarif dan tarif'); 
        } else {
            var url = "<?php echo base_url('tindakan/editTarif'); ?>";

            $.ajax({
                method : "POST",
                url : url,
                data : {
                    table : uri,
                    namaTarif : namaTarif,
                    jenisTarif : jenisTarif,
                    tarif : tarif,
                    sarana : sarana,
                    dokter : dokter,
                    bhp : bhp,
                    alat : alat,
                    kode : kode,
                    kelas : kelas
                },
                success : function(){
                    $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Menambahkan Tarif Baru');
                    $('#myModal').modal('hide');
                    tampilkanDataTarif();
                }
            });
        }        
    }

    function tampilkanDataTarif(){
        var url = "<?php echo base_url('tindakan/dataRow'); ?>";
        $('#loadDatatables').load(url,{table : uri});
    }
</script>

</body>
</html>
