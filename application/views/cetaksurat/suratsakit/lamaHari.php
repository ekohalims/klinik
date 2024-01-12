<a class="btn btn-danger btn-rounded" id="back"><i class="fa fa-chevron-left"></i> Back</a> <br><br>

<label>Lama Beristirahat (Hari)</label>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input type="text" class="form-control" id="lamaIstirahat">
    </div>
</div>

<div class="form-group" style="text-align:right;">
    <a class="btn btn-success btn-rounded" id="submitSurat"><i class="fa fa-search"></i> Preview</a>
</div>

<script type="text/javascript">
    $('#back').on("click",function(){
        var idPasien = "<?php echo $idPasien; ?>";
        loadPilihTanggalPeriksa(idPasien);
    });

    $('#submitSurat').on("click",function(){
        var noPendaftaran = "<?php echo $noPendaftaran; ?>";
        var lamaHari = $('#lamaIstirahat').val();
        var url = "<?php echo base_url('suratSakit/previewSurat'); ?>";

        $.ajax({
            method : "POST",
            url : url,
            data : {noPendaftaran : noPendaftaran, lamaHari : lamaHari},
            beforeSend : function(){
                var imageUrl = "<?php echo base_url('assets/Ellipsis-2s-80px.gif'); ?>";
                $('#viewContent').html("<table width='100%'><tr><td align='center'><img src='"+imageUrl+"'/?</td></tr></table>");
            },
            success : function(response){
                $('#viewContent').html(response);
            },
        });
    });
</script>