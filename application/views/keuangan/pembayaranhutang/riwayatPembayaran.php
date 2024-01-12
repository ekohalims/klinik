<table class="table table-striped">
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th style="width:25%;">No Pembayaran</th>
            <th>PIC</th>
            <th>Tipe Bayar</th>
            <th>Tanggal</th>
            <th style="text-align:right;">Nilai Bayar</th>
        </tr>
    </thead>

    <tbody>
        <?php
            $i = 1;
            $numRows = $riwayatPembayaran->num_rows();

            if($numRows > 0){

            foreach($riwayatPembayaran->result() as $row){
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row->no_payment; ?></td>
            <td><?php echo $row->first_name; ?></td>
            <td><?php echo $row->paymentType; ?></td>
            <td><?php echo date_format(date_create($row->tanggal_pembayaran),'d/m/y H:i'); ?></td>
            <td style="text-align:right;"><?php echo number_format($row->pembayaran,'0',',','.'); ?></td>
        </tr>
        <?php $i++; } } else { ?>
        <tr>
            <td colspan="6">--Belum ada data--</td>
        </tr>
        <?php } ?>
    </tbody>
</table>
