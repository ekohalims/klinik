
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
	tampilkanData();

    function formatAngka(angka) {
        if (typeof(angka) != 'string') angka = angka.toString();
        var reg = new RegExp('([0-9]+)([0-9]{3})');
        while(reg.test(angka)) angka = angka.replace(reg, '$1.$2');
        return angka;
    }

	function tampilkanData(){
		var urlContent = "<?php echo base_url('asalRujukan/viewTableAsalRujukan'); ?>";
		$.ajax({
			method : "GET",
			url : urlContent,
			beforeSend : function(){
				$('#content').text("Harap Tunggu...");
			},
			success : function(response){
				$('#content').html(response);
			}
		});
	}

    $('#tambahData').on("click",function(){
        $('.modal-title').text('Tambah Asal Rujukan');
        $('.modal-body').load("<?php echo base_url('asalRujukan/formTambahData'); ?>");
    });

    $(document).on("click",".edit",function(){
        var id = this.id;
        var url = "<?php echo base_url('asalRujukan/formEdit'); ?>";

        $('.modal-title').text("Edit Asal Rujukan");
        $('.modal-body').load(url,{id : id});
    });

    $('#buttonSave').on("click",function(){
        var jenis = $('#jenis').val();

        if(jenis=='tambah'){
            tambahDataSQL();
        } else {
            editDataSQL();
        }
    });

    $(document).on("click",".hapus",function(){
        var id = this.id;
        var url = "<?php echo base_url('asalRujukan/hapusAsalRujukan'); ?>";

        swal({   
            title: "Anda Yakin?",   
            text: "Data akan hilang setelah dihapus",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yes, delete it!",   
            cancelButtonText: "No, cancel plx!",   
            closeOnConfirm: false,   
            closeOnCancel: false 
        }, function(isConfirm){   
            if (isConfirm) {     
                $.ajax({
                    method : "POST",
                    url : url,
                    data : {id : id},
                    success : function(){
                        tampilkanData();   
                        swal("Deleted!", "Data telah terhapus.", "success"); 
                    }
                });   
            } else {     
                swal("Cancelled", "Membatalkan penghapusan data", "error");   
            } 
        });
    });

    function tambahDataSQL(){
        var namaRujukan = $("#namaRujukan").val();
        var jenisRujukan = $("#jenisRujukan").val();
        var keterangan = $('#keterangan').val();

        if(namaRujukan==''){
            if(namaRujukan==''){
                $('#namaRujukan').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){
                    $('#namaRujukan').css({"box-shadow" : "","border" : ""});
                }, 4000);
            }

        } else {
            var urlSimpan = "<?php echo base_url('asalRujukan/simpanAsalRujukanSQL'); ?>";

            $.ajax({
                method : "POST",
                url : urlSimpan,
                data : {namaRujukan : namaRujukan, jenisRujukan : jenisRujukan, keterangan : keterangan},
                beforeSend : function(){
                    $('#buttonSave').prop("disabled",true);
                },
                success : function(){
                    $('#buttonSave').prop("disabled",false);
                    $('#myModal').modal('hide');
                    $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Berhasil menambah asal rujukan'); 
                    tampilkanData();
                }
            });
        }
    }

    function editDataSQL(){
        var namaRujukan = $("#namaRujukan").val();
        var jenisRujukan = $("#jenisRujukan").val();
        var keterangan = $('#keterangan').val();
        var id = $('#id').val();

        if(namaRujukan==''){
            if(namaRujukan==''){
                $('#namaRujukan').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){
                    $('#namaRujukan').css({"box-shadow" : "","border" : ""});
                }, 4000);
            }
        } else {
            var urlEditTindakan = "<?php echo base_url('asalRujukan/editDataSQL'); ?>";

            $.ajax({
                method : "POST",
                url : urlEditTindakan,
                data : {namaRujukan : namaRujukan, jenisRujukan : jenisRujukan, keterangan : keterangan, id : id},
                beforeSend : function(){
                    $('#buttonSave').prop("disabled",true);
                },
                success : function(){
                    $('#buttonSave').prop("disabled",false);
                    $('#myModal').modal('hide');
                    $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Berhasil mengubah asal rujukan'); 
                    tampilkanData();
                }
            });
        }
    }
</script>

</body>
</html>
