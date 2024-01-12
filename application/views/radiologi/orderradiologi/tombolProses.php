<?php
	if($status==0) {
?>
<button class="btn btn-warning btn-rounded proses" id="1"><i class="fa fa-rotate-right"></i> Proses</button>
<?php } elseif($status==1){ ?>
<button class="btn btn-info btn-rounded proses" id="2"><i class="fa fa-rotate-right"></i> Selesai</button>
<?php } ?>

<script type="text/javascript">
    var urlUpdateStatus = "<?php echo base_url('orderRadiologi/updateStatusOrder'); ?>";

	$('.proses').on("click",function(){
        var id = this.id;
        var idDokter = $('#dokter').val();

		if(id==2){
            if(idDokter==''){
                $.Notification.autoHideNotify('error', 'top right', 'Gagal!','Pilih dokter yang memeriksa')
            } else {
                updateDokterPemeriksa();
                swal({   
                    title: "Anda Yakin?",   
                    text: "Status permintaan akan berubah menjadi proses!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#12a89d",   
                    confirmButtonText: "Yes!",   
                    closeOnConfirm: false 
                }, function(){   
                    updateStatus(id);
                    swal("Berhasil!", "Stautus permintaan berubah", "success"); 
                });
            }
        } else {
            swal({   
                    title: "Anda Yakin?",   
                    text: "Status permintaan akan berubah menjadi proses!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#12a89d",   
                    confirmButtonText: "Yes!",   
                    closeOnConfirm: false 
                }, function(){   
                    updateStatus(id);
                    swal("Berhasil!", "Stautus permintaan berubah", "success"); 
                });
        }
	});

    function updateStatus(status){
        $.ajax({
            method : "POST",
            url : urlUpdateStatus,
            data : {noPendaftaran : noPendaftaran, status : status},
            beforeSend : function(){
                $('#proses').prop("disabled",true);
            },
            success : function(){
                tampilkanDataOrder();
                tampilkanTombolProses();
                tampilkanStatusOrder();
                tampilkanFormDokterPemeriksa();
            }
        });
    }

    function updateDokterPemeriksa(){
        var urlUpdateDokter = "<?php echo base_url('orderRadiologi/updateDokterPemeriksa'); ?>";
        var idDokter = $('#dokter').val();

        $.ajax({
            method : "POST",
            url : urlUpdateDokter,
            data : {noPendaftaran : noPendaftaran, idDokter : idDokter},
            success : function(){
                
            }
        });
    }
</script>
