<div class="col-md-12">
    <label>Kategori Ruangan / Ruangan</label>
</div>

<?php 
    foreach($ruangan as $row){
        $ruangTersedia = $this->modelPendaftaranRanap->ruanganTersedia($row->kodeRuang);
?>
<div class="col-md-3" style="min-height:50px;padding:0px 1px 1px 1px;">
    <div style="border:solid 1px #ddd;padding:5px;">
        <a class="pilihRuangan" id="<?php echo $row->kodeRuang; ?>">
            <p style="font-weight:bold;font-size:12px;"><?php echo $row->namaRuang; ?></p>
            <table width='100%'>
                <tr>
                    <td><i class="fa fa-users"></i> Tersedia</td>
                    <td style="text-align:right;"><?php echo $ruangTersedia; ?> Bed</td>
                </tr>
            </table>
        </a>
    </div>
</div>
<?php } ?>

<script type="text/javascript">
    var ruangAsal = "<?php echo $ruangAsal; ?>";

    $('.pilihRuangan').on("click",function(){
        var idRuangan = this.id;
        var url = "<?php echo base_url('inputTindakanRanap/cekRuangAvailable'); ?>";
        
        $.ajax({
            method : "POST",
            url : url,
            data : {idRuangan : idRuangan},
            success : function(response){
                if(response!='Penuh'){
                    tambahkanRuang(idRuangan,noPendaftaran);
                } else {
                    $.Notification.autoHideNotify('error','top right', 'Gagal!', 'Ruang inap penuh, pilih ruangan lain'); 
                }
            }
        });
    });

    function tambahkanRuang(kodeRuangan,noPendaftaran){
        var url = "<?php echo base_url('inputTindakanRanap/pindahKamar'); ?>";

        $.ajax({
           method : "POST",
           url : url,
           data : {kodeRuangTujuan : kodeRuangan, kodeRuangAsal : ruangAsal, noPendaftaran : noPendaftaran},
           success : function(response){
                $('#myModal').modal('hide');
                loadDataKamar();
                $.Notification.autoHideNotify('success','top right', 'Berhasil!', 'Berhasil Pindah Kamar'); 
           },
           error : function(){
               alert("Error");
           } 
        });
    }
</script>
