<table class="table" id="datatablePasien">
    <thead>
        <tr>
            <th style="width:4%;">No</th>
            <th>No RM</th>
            <th>Nama</th>
            <th>Tanggal Lahir</th>
            <th>Sex</th>
            <th>Alamat</th>
            <th>No HP</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    $("#datatablePasien").DataTable({
        ordering: false,
        processing: false,
        serverSide: true,
        ajax: {
           	url: "<?php echo base_url($uri.'/datatablePasien'); ?>",
           	type:'POST'
        }
    });
</script>