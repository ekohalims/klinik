<div class="row">
	<div class="col-md-12" style="text-align: right;">
		<a class="btn btn-primary" href='#myModal' data-toggle="modal" id="loadItem"><i class="fa fa-cart-plus"></i> Tambah Pelayanan</a>
	</div>
</div>

<div class="row" style="margin-top: 10px;">
	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr>
					<th style="font-weight: bold;" width="5%">No</<th>
                    <th style="font-weight: bold;">Pelayanan</<th>
                    <th style="font-weight: bold;">Dokter</<th>
                    <th style="font-weight: bold;">Tanggal</<th>
                    <th style="font-weight: bold;text-align:right;">Tarif</<th>
                    <th style="font-weight: bold;text-align:right;width:15%;">Selisih</<th>
                    <th style="font-weight: bold;text-align:right;width:15%;">Qty</<th>
                    <th style="font-weight: bold;text-align:right;">Total</<th>
					<th width="5%"></<th>
				</tr>
			</thead>

			<tbody id="daftarOrder">

			</tbody>
		</table>
	</div>
</div>

<div id="myModal" class="modal fade bs-example-modal-lg"" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Pelayanan</h4>
            </div>
            <div class="modal-body">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	tampilkanCart();

	$('#loadItem').on("click",function(){
        tampilkanDaftarTindakan();
    });

    $(document).on("click",".addTindakan",function(){
        var idTindakan = this.id;

        tampilkanKeteranganTindakan(idTindakan);
    });

    $(document).on("click",".hapusTindakan",function(){
        var idTindakan = this.id;

        swal({   
            title: "Are you sure?",   
            text: "You will not be able to recover this imaginary file!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yes, delete it!",   
            closeOnConfirm: false 
        }, function(){   

            var urlHapusTindakan = "<?php echo base_url('inputTindakanRanap/hapusTindakan'); ?>";

            $.ajax({
                method : "POST",
                url : urlHapusTindakan,
                data : {idTindakan : idTindakan, noPendaftaran : noPendaftaran},
                success : function(){
                    swal("Deleted!", "Berhasil menghapus data", "success"); 
                    tampilkanCart();
                    loadDaftarBiaya(noPendaftaran);
                }
            });
        });
    });

    $(document).on("change","#selisih",function(){
        var selisih = $(this).val();
        var kode = $(this).data('id');

        var url = "<?php echo base_url('inputTindakanRanap/updateSelisih'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {
                selisih : selisih,
                kode : kode,
                noPendaftaran : noPendaftaran
            },
            success : function(){
                tampilkanCart();
                loadDaftarBiaya(noPendaftaran);
            }
        });
    });

    $(document).on("change","#qty",function(){
        var qty = $(this).val();
        var kode = $(this).data('id');

        var url = "<?php echo base_url('inputTindakanRanap/updateQty'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {
                qty : qty,
                kode : kode,
                noPendaftaran : noPendaftaran
            },
            success : function(){
                tampilkanCart();
                loadDaftarBiaya(noPendaftaran);
            }
        });
    });

    function tampilkanCart(){
    	var urlTampilkanCart = "<?php echo base_url('inputTindakanRanap/tampilkanCartTindakan'); ?>";

    	$.ajax({
    		method : "POST",
    		url : urlTampilkanCart,
    		data : {noPendaftaran : noPendaftaran},
    		success : function(response){
    			$('#daftarOrder').html(response);
    		}
    	});
    }

    function tampilkanDaftarTindakan(){
        var urlTampilkanDaftarTindakan = "<?php echo base_url('inputTindakanRanap/tampilkanDaftarTindakan'); ?>";

        $.ajax({
            method : "GET",
            url : urlTampilkanDaftarTindakan,
            beforeSend : function(){
                $('.modal-body').text("Harap tunggu...");
            },
            success : function(response){
                $('.modal-body').html(response);
            }
        });
    }

    function addTindakan(idTindakan,dokter){
        var urlAddTindakan = "<?php echo base_url('inputTindakanRanap/addTindakanSQL'); ?>";

        $.ajax({
            method : "POST",
            url : urlAddTindakan,
            data : {idTindakan : idTindakan, noPendaftaran : noPendaftaran, dokter : dokter},
            success : function(){
                $('#myModal').modal('hide');
                tampilkanCart();    
                $.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Data berhasil ditambahkan');
                loadDaftarBiaya(noPendaftaran);
            }
        });
    }

    function tampilkanKeteranganTindakan(id){
        var urlCatatan = "<?php echo base_url('inputTindakanRanap/keteranganTindakan'); ?>";

        $('.modal-body').load(urlCatatan,{id : id});
    }
</script>
