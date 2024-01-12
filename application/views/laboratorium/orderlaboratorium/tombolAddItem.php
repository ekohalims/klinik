<?php
	if($status==1) {
?>
<a href='#modalLab' data-toggle="modal" class="btn btn-success btn-rounded"  id="loadItem"><i class="fa fa-plus"></i> Tambah Item</a>
<?php } ?>

<script type="text/javascript">
	$('#loadItem').on("click",function(){
        loadItem();
    });

    $(document).on("click",".orderLab",function(){
    	var id = this.id;
        tampilkanCatatanLab(id);
    });

    function tampilkanCatatanLab(id){
        var urlCatatan = "<?php echo base_url('orderLaboratorium/catatanLab'); ?>";

        $('#isiContent').load(urlCatatan,{id : id});
    }

    function loadItem(){
        var urlItem = "<?php echo base_url('orderLaboratorium/datatableLab'); ?>";

        $.ajax({
            method : "GET",
            url : urlItem,
            beforeSend : function(){
                $('#isiContent').text("Memuat data...");
            },
            success : function(response){
                $('#isiContent').html(response);
            }
        });
    }

    function orderLab(id,catatan){
        var urlOrderLab = "<?php echo base_url('orderLaboratorium/addLabItem'); ?>";

        $.ajax({
            method : "POST",
            url : urlOrderLab,
            data : {id : id,noPendaftaran : noPendaftaran, catatan : catatan},
            success : function(){
                $('#modalLab').modal('hide');
                tampilkanDataOrder();
            }
        });
    }
</script>
