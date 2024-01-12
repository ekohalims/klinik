<table class="table">
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th style="width:20%;">Tanggal</th>
            <th>Poliklinik</th>
            <th>Dokter</th>
            <th>Diagnosa</th>
        </tr>
    </thead>

    <tbody id="dataRiwayatBerobat">
    <tbody>
</table>

<script type="text/javascript">
    loadRiwayatBerobat();

    function loadRiwayatBerobat(){
        var urlRiwayatBerobat = "<?php echo base_url('inputTindakanRajal/dataRiwayatBerobat'); ?>";

        $.ajax({
            method : "POST",
            url : urlRiwayatBerobat,
            data : {noPendaftaran : noPendaftaran},
            success : function(response){
                $('#dataRiwayatBerobat').html(response);
            }
        });
    }
</script>