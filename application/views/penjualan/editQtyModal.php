<div class="input-group" style="width:100%;">
    <div class="spinner-buttons input-group-btn">
        <button type="button" class="btn spinner-up btn-success">
            <i class="fa fa-plus"></i>
        </button>
    </div>
        
    <input type="text" class="spinner-input form-control" value="<?php echo $dataCart->quantity; ?>" readonly>
        
    <div class="spinner-buttons input-group-btn">
        <button type="button" class="btn spinner-down btn-success">
            <i class="fa fa-minus"></i>
        </button>
    </div>
</div>

<div class="form-group" style="margin-top: 10px;">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-money"></i></span>
        <input type="text" id="diskon<?php echo $dataCart->id; ?>" data-id_produk="<?php echo $dataCart->id_produk; ?>" data-id="<?php echo $dataCart->id; ?>" value="<?php echo $dataCart->diskon; ?>" class="form-control changeDiskon" placeholder="Diskon">
    </div>
</div>

<div class="form-group" style="margin-top: 10px;text-align: right;">
    <input type="submit" id="submitQty" class="btn btn-primary" placeholder="Simpan"/>
</div>


<script type="text/javascript">
  var id = "<?php echo $dataCart->id; ?>";
  var idProduk = "<?php echo $dataCart->id_produk; ?>";

	$('.spinner-down').on("click",function(){
		var qty = $('.spinner-input').val();

    $('#diskon'+id).val('');

		if(qty-1==0){
			alert("Miminal Input = 1");
		} else {
			$('.spinner-input').val(qty-1);

      qtyMin = qty-1;

      $.ajax({
                method : "POST",
                url : "<?php echo base_url('penjualan/updateQtyCart'); ?>",
                data : {idProduk : idProduk,qty : qtyMin, id : id},
                success : function(){
                            viewCartPerRow(id);
                          }
      });
		}
	});

    var successOptions = {
      autoHideDelay: 3000,
      showAnimation: "fadeIn",
      hideAnimation: "fadeOut",
      hideDuration: 700,
      arrowShow: false,
      className: "error",
  };


	$('.spinner-up').on("click",function(){
		var qty = $('.spinner-input').val();
		var id = "<?php echo $dataCart->id; ?>";
		var idProduk = "<?php echo $dataCart->id_produk; ?>";

    $('#diskon'+id).val('');  

		var urlCekStok = "<?php echo base_url('penjualan/cekStokPerStore'); ?>";

		$.post(urlCekStok,{sku : idProduk, qty : qty, id: id},function(response){
        	if(response!="StokEnough"){
        		$.notify("Stok tidak mencukupi", successOptions);              
        	} else {
                $('.spinner-input').val(parseInt(qty)+1);

                qtyPlus = parseInt(qty)+1;

                $.ajax({
                          method : "POST",
                          url : "<?php echo base_url('penjualan/updateQtyCart'); ?>",
                          data : {idProduk : idProduk,qty : qtyPlus, id : id},
                          success : function(){
                                      viewCartPerRow(id);
                                    }
                });
            }
        });		
	});

  $('.changeDiskon').on("change",function(){
    var idProduk = $(this).data('id_produk');
    var diskon   = $(this).val();
    var id = $(this).data('id');

    var updateDiskon = "<?php echo base_url('penjualan/updateDiskon'); ?>";

      
    $.ajax({
              method : "POST",
              url : updateDiskon,
              dataType : 'json',
              data : {idProduk : idProduk, diskon : diskon, id : id},
              success : function(){
                          viewCartPerRow(id);
                          tampilkanDaftarHarga();
                        }
    });
  });

  $('#submitQty').on("click",function(){
    $('#editQtyModal').modal('hide');
    viewCartPerRow(id);
    tampilkanDaftarHarga();
  });
</script>
