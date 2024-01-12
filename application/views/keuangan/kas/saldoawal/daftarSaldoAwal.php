<table class="table table-striped">
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th>Kode Akun</th>
            <th>Nama Akun</th>
            <th>Tgl Input Saldo</th>
            <th style="width:15%;text-align:right;">Saldo</th>
            <th style="width:5%;text-align:right;"></th>
        </tr>
    </thead>

    <tbody>
        <?php
            $i = 1;
            foreach($viewAkun as $row){
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row->kodeSubAkun; ?></td>
            <td><?php echo $row->namaSubAkun; ?></td>
            <td>
                <?php 
                    if($row->tglSaldoAwal != ''){
                        echo date_format(date_create($row->tglSaldoAwal),'d M Y');
                    }
                ?>
            </td>
            <td style="text-align:right;"><?php echo number_format($row->saldo,'0',',','.'); ?></td>
            <td style="text-align:right;"><a class='saldoAwal' id="<?php echo $row->kodeSubAkun; ?>"><i class="fa fa-plus"></i></a></td>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>

