<div class="row">
	<div class="col-md-12" style="text-align: right;">
		<a class="btn btn-primary" href='#myModal' data-toggle="modal" id="loadItem"><i class="fa fa-cart-plus"></i> Order Laboratorium</a>
		<a class="btn btn-success" id="kirimOrder"><i class="fa fa-envelope"></i> Kirim</a>
	</div>
</div>

<div class="row" style="margin-top: 10px;">
	<div class="col-md-12" id="content">
		<table class="table">
			<thead>
				<tr>
					<td style="font-weight: bold;" width="5%">No</td>
                    <td style="font-weight: bold;">Nama Laboratorium</td>
					<td style="font-weight: bold;">Catatan</td>
					<td style="font-weight: bold;text-align: right;" width="30%">Harga</td>
					<td width="5%"></td>
				</tr>
			</thead>

			<tbody id="daftarOrder">

			</tbody>
		</table>
	</div>
</div>

<div class="row" style="margin-top:10px;">
    <div class="col-md-12">
        <div style="border-top:solid 3px #ddd;">
        </div>

        <br>
        <label>Riwayat Permintaan</label>
        <table class="table">
            <thead>
                <tr>
                    <th style="width:5%;">No</th>
                    <th>No Permintaan</th>
                    <th>Tanggal</th>
                    <th>Operator</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody id="riwayatPermintaan">
            </tbody>
        </table>
    </div>
</div>

<div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Order Lab</h4>
            </div>
            <div class="modal-body">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modalRincian" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Daftar Permintaan Laboratorium</h4>
            </div>
            <div class="modal-body" id="contentRiwayat">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	tampilkanCartLab();
    tampilkanRiwayatPermintaan();

	$('#loadItem').on("click",function(){
        loadItem();
    });

    $(document).on("click",".hapusCartLab",function(){
    	var idLab = this.id;
    	var urlHapus = "<?php echo base_url('inputTindakanRanap/hapusCartLab'); ?>";

    	$.post(urlHapus,{idLab : idLab, noPendaftaran : noPendaftaran},function(){
    		tampilkanCartLab();
            loadDaftarBiaya(noPendaftaran);
    	});
    });

    $(document).on("click",".orderLab",function(){
    	var id = this.id;
        tampilkanCatatanLab(id);
    });

    $(document).on("click",".rincianPermintaan",function(){
        var noPermintaan = this.id;
        var url = "<?php echo base_url('inputTindakanRanap/dataOrderLab'); ?>";

        $('#modalRincian').modal('show');
        $('#contentRiwayat').load(url,{noPermintaan : noPermintaan});
    });

    $('#kirimOrder').on("click",function(){
        var url = "<?php echo base_url('inputTindakanRanap/kirimPermintaanLab'); ?>";

        swal({   
            title: "Kirim Permintaan?",   
            text: "Permintaan akan di kirim ke laboratorium!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#12a89d",   
            confirmButtonText: "Kirim!",   
            closeOnConfirm: false 
        }, function(){   
            swal("Sukses!", "Permintaan terkirim.", "success"); 
            $.ajax({
                method : "POST",
                url : url,
                data : {noPendaftaran : noPendaftaran},
                beforeSend : function(){
                    $('#kirimOrder').prop('disabled',true);
                },
                success : function(){
                    $('#kirimOrder').prop('disabled',false);
                    $.Notification.notify('success','top right', 'Success!', 'Berhasil mengirim permintaan');
                    tampilkanCartLab();
                    tampilkanRiwayatPermintaan();
                },
                error : function(){
                    alert("Error, coba lagi...");   
                }
            });
        });
    });

    function tampilkanCartLab(){
    	var urlTampilkanCart = "<?php echo base_url('inputTindakanRanap/tampilkanCartLab'); ?>";

    	$.ajax({
    		method : "POST",
    		url : urlTampilkanCart,
    		data : {noPendaftaran : noPendaftaran},
    		success : function(response){
    			$('#daftarOrder').html(response);
    		}
    	});
    }

    function tampilkanRiwayatPermintaan(){
        var url = "<?php echo base_url('inputTindakanRanap/tampilkanRiwayatPermintaanLab'); ?>";

    	$.ajax({
    		method : "POST",
    		url : url,
    		data : {noPendaftaran : noPendaftaran},
    		success : function(response){
    			$('#riwayatPermintaan').html(response);
    		}
    	});
    }

    function tampilkanCatatanLab(id){
        var urlCatatan = "<?php echo base_url('inputTindakanRanap/catatanLab'); ?>";

        $('.modal-body').load(urlCatatan,{id : id});
    }

    function orderLab(id,catatan){
        var urlOrderLab = "<?php echo base_url('inputTindakanRanap/orderLab'); ?>";

        $.ajax({
            method : "POST",
            url : urlOrderLab,
            data : {id : id,noPendaftaran : noPendaftaran, catatan : catatan},
            success : function(){
                $('#myModal').modal('hide');
                tampilkanCartLab();
                loadDaftarBiaya(noPendaftaran);
            }
        });
    }

    function loadItem(){
        var urlItem = "<?php echo base_url('inputTindakanRanap/datatableLab'); ?>";

        $.ajax({
            method : "GET",
            url : urlItem,
            beforeSend : function(){
                $('.modal-body').text("Memuat data...");
            },
            success : function(response){
                $('.modal-body').html(response);
            }
        });
    }
</script>
