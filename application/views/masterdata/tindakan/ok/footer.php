
<footer class="footer">
    <?php echo $footer; ?>
</footer>

</section>
<script src="<?php echo base_url('assets'); ?>/js/jquery.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/modernizr.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/pace.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/wow.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets'); ?>/js/waypoints.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets'); ?>/js/jquery.counterup.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets'); ?>/assets/sweet-alert/sweet-alert.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/sweet-alert/sweet-alert.init.js"></script>
<script src="<?php echo base_url('assets'); ?>/js/jquery.app.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/notifications/notify.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/notifications/notify-metro.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/notifications/notifications.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/select2/select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets'); ?>/assets/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url('assets'); ?>/assets/timepicker/bootstrap-datepicker.js"></script>
                
<script type="text/javascript">
    loadData();
    
    $(document).on("click",".edit",function(){
        var id = this.id;
        var url = "<?php echo base_url('tindakan/formEditOK'); ?>";

        $('#myModalLabel').text("Edit Tarif");
        $('.modal-body').load(url,{id : id});
        $('#myModal').modal('show');
    });

    $(document).on("click",".hapusOKRinci",function(){
        var row = this.id;
        var kode = $(this).data('kode_tarif');
        var url = "<?php echo base_url('tindakan/hapusOKRinci'); ?>";

        swal({
            title: "Anda Yakin?",
            text: "Data akan hilang setelah dihapus",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No!",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    method : "POST",
                    url : url,
                    data : {kode : kode},
                    success : function(){
                        $('#row'+row).remove();
                        loadData();
                        swal("Deleted!", "Data telah terhapus.", "success");
                    }
                });
            } else {
                swal("Cancelled", "Membatalkan penghapusan data", "error");
            }
        });
    });

    $(document).on("click",".hapus",function(){
        var kode = this.id;
        var url = "<?php echo base_url('tindakan/hapusOK'); ?>";

        swal({
            title: "Anda Yakin?",
            text: "Data akan hilang setelah dihapus",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No!",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    method : "POST",
                    url : url,
                    data : {kode : kode},
                    success : function(){
                        loadData();
                        swal("Deleted!", "Data telah terhapus.", "success");
                    }
                });
            } else {
                swal("Cancelled", "Membatalkan penghapusan data", "error");
            }
        });
    });

    $('#tambah').on("click",function(){
        $('#myModalLabel').text("Tambah Tarif");
        var url = "<?php echo base_url('tindakan/formTambahOK'); ?>";
        $('.modal-body').load(url);
        $('#myModal').modal('show');
    });
    
    $('#userForm').on("submit",function(){
        event.preventDefault();
        var url = "<?php echo base_url('tindakan/simpanOK'); ?>";
        var form_data = $(this).serialize();

        $.ajax({
            method : "POST",
            url : url,
            data : form_data,
            beforeSend : function(){
                $('#tombol').prop("disabled",true);
            },
            success : function(){
                $('#tombol').prop("disabled",false);
                $('#myModal').modal('hide');
                $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Menambah / Mengubah Data');
                loadData(); 
            }
        });
    });

    function loadData(){
        var url = "<?php echo base_url('tindakan/loadTarifOK'); ?>";
        $('#loadDatatables').load(url);
    }
</script>
</body>
</html>
