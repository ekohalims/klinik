<?php
    $tarif = 0;
    foreach($dataKamar as $row){
        $tanggalMasuk = $row->tanggalMasuk;

        if($row->status==1){
            $tanggalKeluar = $row->tanggalKeluar;
        } else {
            $tanggalKeluar = date('Y-m-d');
        }
?>
<tr>
    <td style="vertical-align:middle;"><?php echo $row->namaRuang; ?></td>
    <td style="vertical-align:middle;"><?php echo nice_date($tanggalMasuk,'d/m/Y'); ?></td>
    <td style="vertical-align:middle;">
        <?php
            if($row->status==1){
                echo nice_date($tanggalKeluar,'d/m/Y'); 
            } 
        ?>
    </td>
    <td style="vertical-align:middle;">
        <?php
            $start_date = new DateTime($tanggalMasuk);
            $end_date = new DateTime($tanggalKeluar);
            $interval = $start_date->diff($end_date);
            $lamaHari = $interval->days;
            echo $lamaHari. " hari "; 
        ?>
    </td>
    <td style="vertical-align:middle;">
        <?php
            echo number_format($row->tarif*($lamaHari),'0',',','.'); 
        ?>
    </td>
    <td style="vertical-align:middle;">
        <?php
            if($row->status==0){
                echo "<span class='label label-success'>Menginap</span>";
            } else {
                echo "<span class='label label-warning'>Keluar</span>";
            }
        ?>
    </td>
    <td style="text-align:right;vertical-align:middle;">
        <?php
            if($row->status==0){
        ?>
        <a class='btn btn-info btn-rounded btn-sm launchModal' data-kode_ruang="<?php echo $row->kodeRuang; ?>" title="Pindah Kamar"><i class='fa fa-sign-out'></i></a>
        <?php } ?>
    </td>
</tr>
<?php 
        $tarif = $tarif + ($row->tarif*$lamaHari);
    } 

?>

<tr>
    <td colspan="4"><B>TOTAL TARIF</B></td>
    <td colspan="3">
        <?php
            echo number_format($tarif,0,',','.'); 
        ?>
    </td>
</tr>

<input type="hidden" id="totalKamar" value="<?php echo $row->tarif; ?>"/>