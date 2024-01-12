<table class="table" id="datatable">
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th>Nama Tarif</th>
            <?php
                if($table=='kl_tarifranap') {
                    echo "<th>Kelas</th>";
                }
            ?>
            <th>Jenis</th>
            <th>Tarif</th>
            <th>Sarana</th>
            <th>Dokter</th>
            <th>BHP</th>
            <th>Alat</th>
            <th style="width:5%;"></th>
        </tr>
    </thead>
</table>

<script type='text/javascript'>
    var table = "<?php echo $tableName; ?>";

    $("#datatable").DataTable({
        ordering: false,
        processing: false,
        serverSide: true,
        ajax: {
           	url: "<?php echo base_url('tindakan/datatableTarif'); ?>",
           	type:'POST',
            data : {
                table : table
            }
        }
    });
</script>