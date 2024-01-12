
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
        var url = "<?php echo base_url('item/formEdit'); ?>";

        $('#myModalLabel').text("Edit Item");
        $('.modal-body').load(url,{id : id});
        $('#myModal').modal('show');
    });

    $(document).on("click",".hapus",function(){
        var id = this.id;
        var url = "<?php echo base_url('item/hapusSQL'); ?>";

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
                    data : {id : id},
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

    $(document).on("change","#kode",function(){
        var kode = $(this).val();
        var url = "<?php echo base_url('item/cekKodeExist'); ?>";

        $.ajax({
            method : "POST",
            data : {kode : kode},
            url : url,
            success : function(response){
                if(response==0){
                    $('#kode').val('');

                    $('#kode').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                    $('#labelKode').text("**Kode telah terpakai");
                    setTimeout(function(){
                        $('#kode').css({"box-shadow" : "","border" : ""});
                        $('#labelKode').empty();
                    },4000);
                }
            }
        });
    })

    $('#simpan').on("click",function(){
       var idProduk = $('#kode').val();
       var namaItem = $('#namaItem').val();
       var kategori = $('#kategori').val();
       var satuan = $('#satuan').val();
       var stokMinimal = $('#stokMinimal').val();
       var hargaBeli = $('#hargaBeli').val();
       var hargaJual = $('#hargaBeli').val();
       var jenis = $('#jenis').val();

       if(jenis=='edit'){
        editSQL(idProduk,namaItem,kategori,satuan,stokMinimal,hargaBeli,hargaJual);
       } else {
        simpanSQL(idProduk,namaItem,kategori,satuan,stokMinimal,hargaBeli,hargaJual);
       }
    });

    $('#tambah').on("click",function(){
        $('#myModalLabel').text("Tambah Item");
        var url = "<?php echo base_url('item/formTambah'); ?>";
        $('.modal-body').load(url);
        $('#myModal').modal('show');
    });
        
    function loadData(){
        var url = "<?php echo base_url('item/viewItem'); ?>";
        $('#loadDatatables').load(url);
    }

    function editSQL(idProduk,namaItem,kategori,satuan,stokMinimal,hargaBeli,hargaJual){
        var url = "<?php echo base_url('item/editSQL'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {
                idProduk : idProduk,
                namaItem : namaItem, 
                kategori : kategori,
                satuan : satuan,
                stokMinimal : stokMinimal,
                hargaBeli : hargaBeli, 
                hargaJual : hargaJual
            },
            beforeSend : function(){
                $('#simpan').prop("disabled",true);
            },
            success : function(){
                $('#simpan').prop("disabled",false);
                $('#myModal').modal('hide');
                $.Notification.autoHideNotify('success','top right', 'Berhasil', 'Berhasil mengubah item'); 
                loadData();
            },
            error : function(){
                $.Notification.autoHideNotify('error','top right', 'Gagal', 'Harap coba kembali atau hubungi administrator'); 
            }
        });
    }

    function simpanSQL(idProduk,namaItem,kategori,satuan,stokMinimal,hargaBeli,hargaJual){
        var url = "<?php echo base_url('item/tambahSQL'); ?>";

        if(idProduk=='' || kategori=='' || satuan==''){
            if(idProduk==''){
                $('#kode').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                $('#labelKode').text("**Wajib di isi");
                setTimeout(function(){
                    $('#kode').css({"box-shadow" : "","border" : ""});
                    $('#labelKode').empty();
                },4000);
            }

            if(kategori==''){
                $('#kategori').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                $('#labelKategori').text("**Pilih salah satu");
                setTimeout(function(){
                    $('#kategori').css({"box-shadow" : "","border" : ""});
                    $('#labelKategori').empty();
                },4000);
            }


            if(satuan==''){
                $('#satuan').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                $('#labelSatuan').text("**Pilih salah satu");
                setTimeout(function(){
                    $('#satuan').css({"box-shadow" : "","border" : ""});
                    $('#labelSatuan').empty();
                },4000);
            }
        } else {
            $.ajax({
                method : "POST",
                url : url,
                data : {
                    idProduk : idProduk,
                    namaItem : namaItem, 
                    kategori : kategori,
                    satuan : satuan,
                    stokMinimal : stokMinimal,
                    hargaBeli : hargaBeli, 
                    hargaJual : hargaJual
                },
                beforeSend : function(){
                    $('#simpan').prop("disabled",true);
                },
                success : function(){
                    $('#simpan').prop("disabled",false);
                    $('#myModal').modal('hide');
                    $.Notification.autoHideNotify('success','top right', 'Berhasil', 'Berhasil menambah item'); 
                    loadData();
                },
                error : function(){
                    $.Notification.autoHideNotify('error','top right', 'Gagal', 'Harap coba kembali atau hubungi administrator'); 
                }
            });
            }
    }
</script>
</body>
</html>
