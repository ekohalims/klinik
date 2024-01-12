<?php
	if($status==1) {
?>
<a href='#modalRad' data-toggle="modal" class="btn btn-success btn-rounded"  id="loadItem"><i class="fa fa-plus"></i> Tambah Item</a>
<?php } ?>

<script type="text/javascript">
	$('#loadItem').on("click",function(){
        loadItem();
    });

    $(document).on("click",".orderRad",function(){
    	var id = this.id;
        tampilkanCatatanRad(id);
    });

    function tampilkanCatatanRad(id){
        var urlCatatan = "<?php echo base_url('orderRadiologi/catatanRad'); ?>";

        $('#isiContent').load(urlCatatan,{id : id});
    }

    function loadItem(){
        var urlItem = "<?php echo base_url('orderRadiologi/datatableRad'); ?>";

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

    function orderRad(id,catatan){
        var urlOrderLab = "<?php echo base_url('orderRadiologi/addRadItem'); ?>";

        $.ajax({
            method : "POST",
            url : urlOrderLab,
            data : {id : id,noPendaftaran : noPendaftaran, catatan : catatan},
            success : function(){
                $('#modalRad').modal('hide');
                tampilkanDataOrder();
            }
        });
    }
</script>
