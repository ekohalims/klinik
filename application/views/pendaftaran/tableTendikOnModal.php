<table class="table" id="datatableTendik">
    <thead>
        <tr>
            <th style="width:4%;">No</th>
            <th>Tambah</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <!-- <th>Alamat</th> -->
             <th>HP</th> 
            <!-- <th>Email</th> -->
            <!-- <th>Tmp Lahir</th>
            <th>Tgl Lahir</th>
            <th>Agama</th>
            <th>Status</th> -->
            <th>Status SMT</th> 
            <th>Unit</th>
            <!-- <th>KU</th>
            <th>NIK</th> -->
        </tr>
    </thead>
</table>

<script type="text/javascript">
    $("#datatableTendik").DataTable({
        ordering: false,
        processing: false,
        serverSide: true,
        ajax: {
           	url: "<?php echo base_url($uri.'/datatableTendik'); ?>",
           	type:'POST'
        }
    });
</script>