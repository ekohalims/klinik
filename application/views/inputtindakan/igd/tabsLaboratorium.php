<div class="row">
	<div class="col-md-12" style="text-align: right;">
		<a class="btn btn-primary" href='#myModal' data-toggle="modal" id="loadItem"><i class="fa fa-cart-plus"></i> Order Laboratorium</a>
	</div>
</div>

<div class="row" style="margin-top: 10px;">
	<div class="col-md-12" id="content">
		<table class="table">
			<thead>
				<tr>
					<th style="font-weight: bold;" width="5%">No</th>
                    <th style="font-weight: bold;">Nama Laboratorium</th>
					<th style="font-weight: bold;">Catatan</th>
					<th style="font-weight: bold;text-align: right;" width="30%">Harga</th>
					<th width="5%"></th>
				</tr>
			</thead>

			<tbody id="daftarOrder">

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

<script type="text/javascript">
	tampilkanCartLab();

	$('#loadItem').on("click",function(){
        loadItem();
    });

    $(document).on("click",".hapusCartLab",function(){
    	var idLab = this.id;
    	var urlHapus = "<?php echo base_url('inputTindakanIGD/hapusCartLab'); ?>";

    	$.post(urlHapus,{idLab : idLab, noPendaftaran : noPendaftaran},function(){
    		tampilkanCartLab();
            loadDaftarBiaya(noPendaftaran);
    	});
    });

    $(document).on("click",".orderLab",function(){
    	var id = this.id;
        tampilkanCatatanLab(id);
    });

    function tampilkanCartLab(){
    	var urlTampilkanCart = "<?php echo base_url('inputTindakanIGD/tampilkanCartLab'); ?>";

    	$.ajax({
    		method : "POST",
    		url : urlTampilkanCart,
    		data : {noPendaftaran : noPendaftaran},
    		success : function(response){
    			$('#daftarOrder').html(response);
    		}
    	});
    }

    function tampilkanCatatanLab(id){
        var urlCatatan = "<?php echo base_url('inputTindakanIGD/catatanLab'); ?>";

        $('.modal-body').load(urlCatatan,{id : id});
    }

    function orderLab(id,catatan){
        var urlOrderLab = "<?php echo base_url('inputTindakanIGD/orderLab'); ?>";

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
        var urlItem = "<?php echo base_url('inputTindakanIGD/datatableLab'); ?>";

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
