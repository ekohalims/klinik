<div class="row">
	<div class="col-md-12" style="text-align: right;">
		<a class="btn btn-primary" href='#myModal' data-toggle="modal" id="loadItem"><i class="fa fa-cart-plus"></i> Tambah Diagnosa</a>
	</div>
</div>

<div class="row" style="margin-top: 10px;">
	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr>
					<td style="font-weight: bold;" width="5%">No</td>
                    <td style="font-weight: bold;">Kode</td>
                    <td style="font-weight: bold;">ICD</td>
					<td style="font-weight: bold;">Diagnosa</td>
					<td style="font-weight: bold;" width="30%">Keterangan</td>
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
                <h4 class="modal-title" id="myModalLabel">Diagnosa</h4>
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

    $(document).on("click",".hapusCartDiag",function(){
    	var id = this.id;
    	var urlHapus = "<?php echo base_url('inputTindakanRanap/hapusCartDiag'); ?>";

    	$.post(urlHapus,{id : id, noPendaftaran : noPendaftaran},function(){
    		tampilkanCartLab();
    	});
    });

    $(document).on("click",".addDiagnosa",function(){
    	var id = this.id;
        tampilkanKeteranganDiagnosa(id);
    });

    function tampilkanCartLab(){
    	var urlTampilkanCart = "<?php echo base_url('inputTindakanRanap/tampilkanCartDiagnosa'); ?>";

    	$.ajax({
    		method : "POST",
    		url : urlTampilkanCart,
    		data : {noPendaftaran : noPendaftaran},
    		success : function(response){
    			$('#daftarOrder').html(response);
    		}
    	});
    }

    function loadItem(){
        var urlItem = "<?php echo base_url('inputTindakanRanap/datatableDiagnosa'); ?>";

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

    function addDiagnosa(id,keterangan){
        var urlOrderLab = "<?php echo base_url('inputTindakanRanap/addDiagnosaOnPasien'); ?>";

        $.ajax({
            method : "POST",
            url : urlOrderLab,
            data : {id : id,noPendaftaran : noPendaftaran, keterangan : keterangan},
            success : function(){
                $('#myModal').modal('hide');
                tampilkanCartLab();
            }
        });
    }

    function tampilkanKeteranganDiagnosa(id){
        var urlCatatan = "<?php echo base_url('inputTindakanRanap/keteranganDiagnosa'); ?>";

        $('.modal-body').load(urlCatatan,{id : id});
    }
</script>
