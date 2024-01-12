<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-book"></i> Tutup Buku</h3> 
            </div>
        </div>

        <div class="col-md-6" style="font-size:20px;text-align:right;">
            Periode <?php echo $periode; ?>
        </div>
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="col-md-12" style="text-align:right;">
                    <button class='btn btn-warning btn-rounded' id="prosesTutupBuku"><i class='fa fa-book'></i> Proses Tutup Buku</a>
                </div>

                <div class="col-md-12" style="margin-top:20px;"> 
                    <div class="form-group">
                            <label>Penyusutan Perlengkapan</label>
                            <input type="text" class="form-control" id="nominalPenyusutanPerlengkapan" style="width:300px;"/>
                    </div>
                </div>

                <div class="row" style="margin-top:20px;">
                    <div class="col-md-12">
                        <?php 
                            if($SOGudang < 1){
                        ?>

                            <div class="alert alert-danger">
                                Saat ini anda belum melakukan stock opname gudang, apakah anda yakin ingin tutup buku ? Persediaan akan diambil berdasarkan stok yang tercatat di sistem
                            </div>
                        
                        <?php
                            }
                        ?>

                        <?php
                            if($piutangMelebihiTempo > 0){
                        ?>
                            
                            <div class="alert alert-danger">
                                Terdapat <b><?php echo $piutangMelebihiTempo; ?></b> piutang melebihi tempo, apakah anda ingin memindahkan piutang ini ke akun cadangan piutang tak tertagih ? 
                            </div>
                            <table class='table table-striped table-bordered'>
                                <thead>
                                    <tr>
                                        <th style="width:5%;"></th>
                                        <th>No Pendaftaran</th>
                                        <th>Jatuh Tempo</th>
                                        <th style='text-align:right;width:15%;'>Total Piutang</th>
                                        <th style='text-align:right;width:15%;'style='text-align:right;'>Terbayar</th>
                                        <th style='text-align:right;width:15%;'>Sisa Piutang</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        foreach($dataPiutangMelebihiTempo as $row){
                                            $hutangTerbayar = $this->modelPublic->hutangTerbayar($row->noPendaftaran);
                                    ?>
                                    <tr>
                                        <td style="text-align:center;"><input type="checkbox" name='piutang' value="<?php echo $row->noPendaftaran; ?>"/></td>
                                        <td><?php echo $row->noPendaftaran; ?></td>
                                        <td><?php echo date_format(date_create($row->jatuhTempo),'d/m/Y'); ?></td>
                                        <td style='text-align:right;'><?php echo number_format($row->grandTotal,'0',',','.'); ?></td>
                                        <td style='text-align:right;'><?php echo number_format($hutangTerbayar,'0',',','.'); ?></td>
                                        <td style='text-align:right;'><?php echo number_format($row->grandTotal-$hutangTerbayar,'0',',','.'); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php
                            }
                        ?>
                    </div>

                    <div class="col-md-12" style="margin-top:20px;"> 
                        <label>Neraca Saldo Sebelum Penutupan</label>
                        <table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th style="width:10%">Kode</th>
                                    <th>Akun</th>
                                    <th style="width:20%;text-align:center;">Debit</th>
                                    <th style="width:20%;text-align:center;">Kredit</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $totalDebit = 0;
                                    $totalKredit = 0;
                                    foreach($akun as $row){
                                ?>
                                <tr>
                                    <td><?php echo $row->kodeAkun; ?></td>
                                    <td><?php echo $row->namaSubAkun; ?></td>
                                    <td style="text-align:right;">
                                        <?php 
                                            $debit = $row->debit-$row->kredit;

                                            if($debit > 0){
                                                echo number_format($debit,'0',',','.'); 
                                            }
                                        ?>
                                        </td>
                                    <td style="text-align:right;">
                                        <?php 
                                            $kredit = $row->kredit-$row->debit;
                                            if($kredit > 0){
                                                echo number_format($kredit,'0',',','.'); 
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <?php 
                                        if($debit > 0){
                                            $totalDebit = $totalDebit+$debit;
                                        }

                                        if($kredit > 0){
                                            $totalKredit = $totalKredit+$kredit;
                                        }
                                    } 
                                ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="2" style="text-align:center;font-weight:bold;">TOTAL</td>
                                    <td style='text-align:right;font-weight:bold;'><?php echo number_format($totalDebit,'0',',','.'); ?></td>
                                    <td style='text-align:right;font-weight:bold;'><?php echo number_format($totalKredit,'0',',','.'); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>

