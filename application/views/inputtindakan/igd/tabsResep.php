<div class="row">
	<div class="col-md-12" style="text-align: right;">
		<a class="btn btn-primary" href='#myModal' data-toggle="modal" id="loadItem"><i class="fa fa-cart-plus"></i> Tambah Resep</a>
	</div>
</div>

<div class="row" style="margin-top: 10px;">
	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr>
					<td style="font-weight: bold;" width="5%">No</td>
                    <td style="font-weight: bold;">SKU</td>
                    <td style="font-weight: bold;">Nama</td>
                    <td style="font-weight: bold;">Kategori</td>
                    <td style="font-weight: bold;">Harga</td>
					<td style="font-weight: bold;width:10%;">Quantity</td>
					<td style="font-weight: bold;">Satuan</td>
                    <td style="font-weight: bold;">Aturan</td>
				</tr>
			</thead>

			<tbody id="daftarOrder">

			</tbody>
		</table>
	</div>
</div>

<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Item</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group" style="width:250px;">
                            <span class="input-group-addon"><i class="fa fa-list"></i></span>
                            <select class="form-control" id="kategori">
                                <option value="">--Kategori--</option>
                                
                                <?php
                                    $kategori = $this->db->get("ap_kategori")->result();
                                    foreach($kategori as $kg){
                                ?>
                                <option value="<?php echo $kg->id_kategori; ?>"><?php echo $kg->kategori; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group pull-right" style="width:250px;">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" id="pencarian" placeholder="Pencarian..."/>
                        </div>
                    </div>
                </div>                        
                
                <div class="row" style="margin-top:20px;">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:5%;">No</th>
                                    <th>Kode Item</th>
                                    <th>Nama Item</th>
                                    <th>Satuan</th>
                                    <th>Kategori</th>
                                    <th style="width:1%;"></th>
                                </tr>
                            </thead>

                            <tbody id="viewItem">
                            </tbody>
                        </table>
                    </div>
                </div>

                <br>

                <div class="row" id="pagination">
                    <div class="col-md-6">
                        <button id="previous" class="btn btn-default"><img src="<?php echo base_url('assets/btnleft.png'); ?>" height="20px"/> Previous </button>
                        <span id="jumlahData"></span>
                    </div>

                    <div class="col-md-6" style="text-align: right;">
                        <button id="next" class="btn btn-default">Next <img src="<?php echo base_url('assets/btn.png'); ?>" height="20px"/></button>
                        <input type="hidden" id="currentPage" value="1"/>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var idKategori = '';
	var search = '';
	var limitStart = '';

    $('#kategori').on("change",function(){
		//reset current page
		$('#currentPage').val(1);

		var limitStart = $('#currentPage').val();
		var idKategori = $('#kategori').val();
		var search = $('#pencarian').val();
		
		tampilkanItemModal(idKategori,search,limitStart);
	});

	$('#pencarian').on("keydown",function(){
		//reset current page
		$('#currentPage').val(1);

		var limitStart = $('#currentPage').val();
		var idKategori = $('#kategori').val();
		var search = $('#pencarian').val();

		tampilkanItemModal(idKategori,search,limitStart);
	});

	tampilkanCart();

	$('#loadItem').on("click",function(){
        tampilkanItemModal(idKategori,search,limitStart);
    });

    function tampilkanItemModal(idKategori,search,limitStart){
		var url = "<?php echo base_url('inputTindakanIGD/tampilkanItemObat'); ?>";
		$.ajax({
			method : "POST",
			url : url,
			data : {noPendaftaran : noPendaftaran, idKategori : idKategori, search : search, limitStart : limitStart},
			beforeSend : function(){
				var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";
            	$('#viewItem').html("<table width='100%'><tr><td align='center'><img src='"+imageUrl+"'/?</td></tr></table>");
			},
			success : function(response){
				$('#viewItem').html(response);
			}
		});
	}


    $(document).on("click",".hapusResep",function(){
        var idProduk = this.id;

        var urlHapusResep = "<?php echo base_url('inputTindakanIGD/hapusResep'); ?>";

        $.ajax({
            method : "POST",
            url : urlHapusResep,
            data : {idProduk : idProduk,noPendaftaran : noPendaftaran},
            success : function(){
                tampilkanCart();
                loadDaftarBiaya(noPendaftaran);
            }
        });
    });

    function tampilkanCart(){
    	var urlTampilkanCart = "<?php echo base_url('inputTindakanIGD/tampilkanCartResep'); ?>";

    	$.ajax({
    		method : "POST",
    		url : urlTampilkanCart,
    		data : {noPendaftaran : noPendaftaran},
    		success : function(response){
    			$('#daftarOrder').html(response);
    		}
    	});
    }
</script>
