                        <table class="table table-stiped" id="datatables">
            				<thead>
            					<tr style="font-weight: bold;">
            						<th width="5%">No</th>
            						<th>Nama Dokter</th>
                                    <th>NO HP</th>
                                    <th>Sex</th>
            						<th>No Izin</th>
            						<th>Alamat</th>
            						<th>Poliklinik</th>
                                    <th>Status</th>
                                    <th style="width:5%;text-align:right;"></th>
            					</tr>
            				</thead>

            				<tbody>
                                <?php
                                    $i = 1;
                                    foreach($dokter as $row){
                                ?>
            					<tr>
            						<td><?php echo $i; ?></td>
            						<td><?php echo $row->nama; ?></td>
                                    <td><?php echo $row->noHP; ?></td>
                                    <td><?php echo $row->jenisKelamin; ?></td>
            						<td><?php echo $row->noIzinPraktek; ?></td>
            						<td><?php echo $row->alamat; ?></td>
            						<td><?php echo $row->poliklinik; ?></td>
                                    <td>
                                        <?php 
                                            if($row->status==1){
                                                echo "<span class='label label-success'>Aktif</span>";
                                            } else {
                                                echo "<span class='label label-danger'>Non-Aktif</span>";
                                            }
                                        ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php
                                            $idDokter = $this->encryption->encrypt($row->id_dokter);
                                            $encoded = strtr($idDokter,array('+' => '.', '=' => '-', '/' => '~'));
                                        ?>
                                        <a href="<?php echo base_url('dokter/editDokter?idDokter='.$encoded); ?>"><i class="fa fa-edit"></i></a> |
                                        <a class="hapusDokter" id="<?php echo $encoded; ?>"><i class="fa fa-trash"></i></a>
                                    </td>
            					</tr>
                                <?php $i++; } ?>
            				</tbody>
            			</table>

                        <script type="text/javascript">
                            $('#datatables').dataTable();
                        </script>