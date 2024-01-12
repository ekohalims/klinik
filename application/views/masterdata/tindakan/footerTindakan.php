
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
	//tampilkanDataTindakan();

    function formatAngka(angka) {
        if (typeof(angka) != 'string') angka = angka.toString();
        var reg = new RegExp('([0-9]+)([0-9]{3})');
        while(reg.test(angka)) angka = angka.replace(reg, '$1.$2');
        return angka;
    }

	function tampilkanDataTindakan(){
		var urlContent = "<?php echo base_url('tindakan/viewTableTindakan'); ?>";
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

    $('#tambahTindakan').on("click",function(){
        $('.modal-title').text('Tambah Tindakan');
        $('.modal-body').load("<?php echo base_url('tindakan/formTambahTindakan'); ?>");
    });

    $(document).on("click",".editTindakan",function(){
        var idTindakan = this.id;
        var urlFormEditTindakan = "<?php echo base_url('tindakan/formEditTindakan'); ?>";

        $('.modal-title').text("Edit Tindakan");
        $('.modal-body').load(urlFormEditTindakan,{idTindakan : idTindakan});
    });

    $('#buttonPoli').on("click",function(){
        var jenis = $('#jenis').val();

        if(jenis=='tambah'){
            tambahTindakanSQL();
        } else {
            editTindakanSQL();
        }
    });

    $(document).on("click",".hapusTindakan",function(){
        var idTindakan = this.id;
        var urlHapusTindakan = "<?php echo base_url('tindakan/hapusTindakan'); ?>";

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
                    url : urlHapusTindakan,
                    data : {idTindakan : idTindakan},
                    success : function(){
                        tampilkanDataTindakan();   
                        swal("Deleted!", "Data telah terhapus.", "success"); 
                    }
                });   
            } else {     
                swal("Cancelled", "Membatalkan penghapusan data", "error");   
            } 
        });
    });

    function tambahTindakanSQL(){
        var namaTindakan = $("#namaTindakan").val();
        var tarif = $('#tarif').val();
        var komisi = $('#komisi').val();
        var keterangan = $('#keterangan').val();

        if(namaTindakan=='' || tarif=='' || komisi==''){
            if(namaTindakan==''){
                $('#namaTindakan').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){
                    $('#namaTindakan').css({"box-shadow" : "","border" : ""});
                }, 4000);
            }

            if(tarif==''){
                $('#tarif').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){
                    $('#tarif').css({"box-shadow" : "","border" : ""});
                }, 4000);
            }

            if(komisi==''){
                $('#komisi').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){
                    $('#tarif').css({"box-shadow" : "","border" : ""});
                }, 4000);
            }
        } else {
            var urlSimpanTindakan = "<?php echo base_url('tindakan/simpanTindakanSQL'); ?>";

            $.ajax({
                method : "POST",
                url : urlSimpanTindakan,
                data : {namaTindakan : namaTindakan, tarif : tarif, komisi : komisi,keterangan : keterangan},
                beforeSend : function(){
                    $('#buttonPoli').prop("disabled",true);
                },
                success : function(){
                    $('#buttonPoli').prop("disabled",false);
                    $('#myModal').modal('hide');
                    $.Notification.notify('success','top right', 'Berhasil!', 'Berhasil menambah tindakan'); 
                    tampilkanDataTindakan();
                }
            });
        }
    }

    function editTindakanSQL(){
        var namaTindakan = $("#namaTindakan").val();
        var tarif = $('#tarif').val();
        var komisi = $('#komisi').val();
        var keterangan = $('#keterangan').val();
        var status = $('#status').val();
        var idTindakan = $('#idTindakan').val();

        if(namaTindakan=='' || tarif==''){
            if(namaTindakan==''){
                $('#namaTindakan').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){
                    $('#namaTindakan').css({"box-shadow" : "","border" : ""});
                }, 4000);
            }

            if(tarif==''){
                $('#tarif').css({"box-shadow" : "1px 1px 10px red","border" : "solid 1px red"});
                setTimeout( function(){
                    $('#tarif').css({"box-shadow" : "","border" : ""});
                }, 4000);
            }
        } else {
            var urlEditTindakan = "<?php echo base_url('tindakan/editTindakanSQL'); ?>";

            $.ajax({
                method : "POST",
                url : urlEditTindakan,
                data : {namaTindakan : namaTindakan, tarif : tarif, komisi : komisi,keterangan : keterangan, status : status,idTindakan : idTindakan},
                beforeSend : function(){
                    $('#buttonPoli').prop("disabled",true);
                },
                success : function(){
                    $('#buttonPoli').prop("disabled",false);
                    $('#myModal').modal('hide');
                    $.Notification.notify('success','top right', 'Berhasil!', 'Berhasil menambah tindakan'); 
                    tampilkanDataTindakan();
                }
            });
        }
    }
</script>

</body>
</html>
