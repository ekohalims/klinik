<table width="100%">
    <tr style="border-bottom:solid 1px #ccc;">
        <td with="60%" style="font-size:14px;">
            <?php 
                echo "<b>".$header->namaKlinik."</b><br>";
                echo $header->alamat."<br>";
                echo "Telepon ".$header->telepon;
            ?>
        </td>
        <td style="text-align:right;vertical-align:bottom;font-weight:bold;">
            NERACA<br>
            <?php echo $periode; ?>
        </td>
    </tr>
</table>
<br>
<table width="100%" style="border:solid 1px #ccc;">
	<tr>
		<td width="50%" style="vertical-align:top;padding:10px;">
			<table width="100%">
				<tr>
					<td style='font-weight:bold;'>Harta</td>
				</tr>
				<tr>
					<td style="padding-left:30px;font-weight:bold;">Aset Lancar</td>
				</tr>
				<tr>
					<td>
						<table width="100%">
							<?php
                                $totalAsetLancar = 0;
                                foreach($hartaLancar as $row){
                            ?>
							<tr>
								<td style="padding-left:35px;">
									<?php echo $row->namaSubAkun; ?>
								</td>
								<td style="text-align:right;">
									<?php 
                                        echo number_format($row->debit-$row->kredit,'0',',','.');
                                    ?>
								</td>
							</tr>
							<?php $totalAsetLancar = $totalAsetLancar+($row->debit-$row->kredit); } ?>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td width="50%" style="vertical-align:top;padding:10px;">
			<table width="100%">
				<tr>
					<td style='font-weight:bold;'>Kewajiban dan Modal</td>
				</tr>
				<tr>
					<td style="padding-left:30px;font-weight:bold;">Kewajiban</td>
				</tr>
				<tr>
					<td>
						<table width="100%">
							<?php
                                $totalKewajiban = 0;
                                foreach($kewajiban as $kw){
                            ?>
							<tr>
								<td style="padding-left:35px;">
									<?php echo $kw->namaSubAkun; ?>
								</td>
								<td style="text-align:right;">
									<?php 
                                        $hutangUsaha = $kw->kredit-$kw->debit;
                                        echo number_format($hutangUsaha,'0',',','.');
                                    ?>
								</td>
							</tr>
							<?php $totalKewajiban = $totalKewajiban+$hutangUsaha; } ?>
						</table>
					</td>
				</tr>
				<tr>
					<td style="padding-left:30px;font-weight:bold;">Modal</td>
				</tr>
				<tr>
					<td>
						<table width="100%">
							<tr>
								<td style="padding-left:35px;">Modal Akhir</td>
								<td style="text-align:right;">
									<?php 
                                        echo number_format($modalAkhir,'0',',','.'); 
                                    ?>
								</td>
							</tr>
							<tr>
								<td style="padding-left:35px;">Historical Balancing</td>
								<td style="text-align:right;">
									<?php
                                        echo number_format($historicalBalancing,'0',',','.');
                                    ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
    
    <tr>
        <td style="padding:10px;">
            <table width="100%">
                <tr style='border-top:solid 1px #ccc;'>
                    <td style="font-weight:bold;">TOTAL ASET LANCAR</td>
                    <td style="font-weight:bold;text-align:right;"><?php echo number_format($totalAsetLancar,'0',',','.'); ?></td>
                </tr>
            </table>
        </td>

        <td style="padding:10px;">
            <table width="100%">
                <tr style='border-top:solid 1px #ccc;'>
                    <td style="font-weight:bold;">TOTAL KEWAJIBAN DAN MODAL</td>
                    <td style="font-weight:bold;text-align:right;"><?php echo number_format($modalAkhir+$totalKewajiban+$historicalBalancing,'0',',','.'); ?></td>
                </tr>                  
            </table>
        </td>
    </tr>
</table>
                        