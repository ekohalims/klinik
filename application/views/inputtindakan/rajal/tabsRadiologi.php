<div class="row">
	<div class="col-md-12" style="text-align: right;">
		<a class="btn btn-primary" href='#myModal' data-toggle="modal" id="loadItem"><i class="fa fa-cart-plus"></i> Order Radiologi</a>
	</div>
</div>

<div class="row" style="margin-top: 10px;">
	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr>
					<td style="font-weight: bold;" width="5%">No</td>
                    <td style="font-weight: bold;">Nama Radiologi</td>
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

<div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Order Radiologi</h4>
            </div>
            <div class="modal-body">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	tampilkanCartLab();

	$('#loadItem').on("click",function(){
        loadItem();
    });

    $(document).on("click",".hapusCartRad",function(){
    	var idRad = this.id;
    	var urlHapus = "<?php echo base_url('inputTindakanRajal/hapusCartRad'); ?>";

    	$.post(urlHapus,{idRad : idRad, noPendaftaran : noPendaftaran},function(){
    		tampilkanCartLab();
            loadDaftarBiaya(noPendaftaran);
    	});
    });

    $(document).on("click",".orderRad",function(){
    	var id = this.id;
        tampilkanCatatanRad(id);
        loadDaftarBiaya(noPendaftaran);
    });

    function tampilkanCartLab(){
    	var urlTampilkanCart = "<?php echo base_url('inputTindakanRajal/tampilkanCartRad'); ?>";

    	$.ajax({
    		method : "POST",
    		url : urlTampilkanCart,
    		data : {noPendaftaran : noPendaftaran},
    		success : function(response){
    			$('#daftarOrder').html(response);
    		}
    	});
    }

    function orderRad(id,catatan){
        var urlOrderLab = "<?php echo base_url('inputTindakanRajal/orderRad'); ?>";

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
        var urlItem = "<?php echo base_url('inputTindakanRajal/datatableRad'); ?>";

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

    function tampilkanCatatanRad(id){
        var urlCatatan = "<?php echo base_url('inputTindakanRajal/catatanRad'); ?>";

        $('.modal-body').load(urlCatatan,{id : id});
    }
</script>
