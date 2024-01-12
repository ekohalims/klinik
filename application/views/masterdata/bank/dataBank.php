<table class="table table-stripped" id="datatable">
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th style="width:10%;">Kode Akun</th>
            <th>Nama Bank</th>
            <th>Cabang</th>
            <th>No Rekening</th>
            <th>Atas Nama</th>
            <th>Status</th>
            <th style="width:5%;"></th>
        </tr>
    </thead>

    <tbody>
        <?php
            $i = 1;
            foreach($viewBank as $row){
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row->kodeBank; ?></td>
            <td><?php echo $row->bank; ?></td>
            <td><?php echo $row->cabang; ?></td>
            <td><?php echo $row->noRekening; ?></td>
            <td><?php echo $row->atasNama; ?></td>
            <td>
                <?php  
                    $status = $row->status;

                    if($status==1){
                        echo "<span class='label label-success'>Aktif</span>";
                    } else {
                        echo "<span class='label label-danger'>Non-Aktif</span>";
                    }
                ?>
            </td>
            <td style="text-align:right;">
                <?php
                    $nilai = $this->encryption->encrypt($row->kodeBank);
                    $encoded = strtr($nilai,array('+' => '.', '=' => '-', '/' => '~'));
                ?>
                <a href='#myModal' data-toggle="modal" class='editBank' id="<?php echo $row->kodeBank; ?>"><i class='fa fa-edit'></i></a>
                | <a class='hapusBank' id='<?php echo $encoded; ?>'><i class='fa fa-trash'></i></a>
            </td>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>

<script type="text/javascript">
	$('#datatable').dataTable();
</script>