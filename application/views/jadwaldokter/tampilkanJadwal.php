<table class="table" id="datatableDokter">
    <thead>
        <tr style="font-weight: bold;">
            <th rowspan="2" style="text-align: center;vertical-align: middle;" width="5%">No</th>
            <th rowspan="2" style="vertical-align: middle;" width="20%">Dokter</th>
            <th rowspan="2" style="vertical-align: middle;">Poli</th>
            <th colspan="7" style="text-align: center;">Jadwal</th>
        </tr>

        <tr style="font-weight: bold;">
            <th style="text-align: center;" width="9%">Senin</th>
            <th style="text-align: center;" width="9%">Selasa</th>
            <th style="text-align: center;" width="9%">Rabu</th>
            <th style="text-align: center;" width="9%">Kamis</th>
            <th style="text-align: center;" width="9%">Jumat</th>
            <th style="text-align: center;" width="9%">Sabtu</th>
            <th style="text-align: center;" width="9%">Minggu</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    $("#datatableDokter").DataTable({
        ordering: false,
        processing: false,
        serverSide: true,
        ajax: {
            url: "<?php echo base_url('jadwalDokter/datatableJadwal'); ?>",
            type:'POST'
        }
    });
</script>