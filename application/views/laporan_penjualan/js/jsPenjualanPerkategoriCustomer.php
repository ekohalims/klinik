<script type="text/javascript">
    jQuery('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        autoclose : true
    }); 
    
    // Select2
    jQuery(".select2").select2({
        width: '100%'
    });

    $('#viewReport').on("click",function(){
    	var dateStart 		= $('#dateStart').val();
    	var dateEnd 	 	= $('#dateEnd').val();
    	var kategoriCustomer= $('#id_kategori').val();
        var idToko          = $('#id_toko').val();

    	var url = "<?php echo base_url('laporan/penjualanPerkategoriCustomerReport'); ?>";
        
        $.ajax({
                    method : "POST",
                    url : "<?php echo base_url('laporan/cekUserAccess'); ?>",
                    data : {idToko : idToko},
                    success : function(status){
                                if(status==0){
                                    $.Notification.notify('error','top right', 'Akses Ditolak', 'Anda Tidak Mempunyai Akses Ke Toko Ini, Silahkan Hubungi Admin');
                                } else {
                                    $.ajax({
                                        method      : "POST",
                                        data        : {dateStart : dateStart, dateEnd : dateEnd,kategoriCustomer : kategoriCustomer, idToko : idToko},
                                        url         : url,
                                        beforeSend  : function(){
                                                        var imageUrl = "<?php echo base_url('assets/loading.gif'); ?>";
                                                        $('#dataReport').html("<table width='100%'><tr><td colspan='12' align='center'><img src='"+imageUrl+"'/></td></tr></table>");
                                                      },
                                        success     : function(data){
                                                        $('#dataReport').html(data);
                                                      }
                            });
                                }
                    }
                });
    });
</script>