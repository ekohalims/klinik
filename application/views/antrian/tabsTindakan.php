<div class="row">
	<div class="col-md-12" style="text-align: right;">
		<a class="btn btn-primary btn-rounded" href='#myModal' data-toggle="modal" id="loadItem"><i class="fa fa-cart-plus"></i> Tambah Tindakan</a>
	</div>
</div>

<div class="row" style="margin-top: 10px;">
	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr>
					<td style="font-weight: bold;" width="5%">No</td>
                    <td style="font-weight: bold;">Tindakan</td>
                    <td style="font-weight: bold;">Keterangan</td>
                    <td style="font-weight: bold;">Harga</td>
					<td width="5%"></td>
				</tr>
			</thead>

			<tbody id="daftarOrder">

			</tbody>
		</table>
	</div>
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Tindakan</h4>
            </div>
            <div class="modal-body" style="max-height: 500px;">
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

            var urlHapusTindakan = "<?php echo base_url('antrian/hapusTindakan'); ?>";

            $.ajax({
                method : "POST",
                url : urlHapusTindakan,
                data : {idTindakan : idTindakan, noPendaftaran : noPendaftaran},
                success : function(){
                    swal("Deleted!", "Berhasil menghapus data", "success"); 
                    tampilkanCart();
                }
            });
        });
    });

    function tampilkanCart(){
    	var urlTampilkanCart = "<?php echo base_url('antrian/tampilkanCartTindakan'); ?>";

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
        var urlTampilkanDaftarTindakan = "<?php echo base_url('antrian/tampilkanDaftarTindakan'); ?>";

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

    function addTindakan(idTindakan,catatan){
        var urlAddTindakan = "<?php echo base_url('antrian/addTindakanSQL'); ?>";

        $.ajax({
            method : "POST",
            url : urlAddTindakan,
            data : {idTindakan : idTindakan, noPendaftaran : noPendaftaran, catatan : catatan},
            success : function(){
                $('#myModal').modal('hide');
                tampilkanCart();    
                $.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Data berhasil ditambahkan');
            }
        });
    }

    function tampilkanKeteranganTindakan(id){
        var urlCatatan = "<?php echo base_url('antrian/keteranganTindakan'); ?>";

        $('.modal-body').load(urlCatatan,{id : id});
    }
</script>
