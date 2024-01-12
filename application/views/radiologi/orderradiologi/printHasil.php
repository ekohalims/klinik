<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
            	<h3 class="title"><i class="fa fa-file-word-o"></i> Hasil Radiologi</h3> 
        	    <h6> <a href="<?php echo base_url('orderRadiologi'); ?>">Order Radiologi</a> / <a href="<?php echo base_url('orderRadiologi/processOrder/'.$this->uri->segment(3)); ?>"> Proses Permintaan</a> / Cetak Hasil</h6>
            </div>
        </div>

        <div class="col-md-6" style="text-align: right;">
            <a class="btn btn-success btn-rounded" onclick="printContent('area-print')"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body" id="area-print">
                <div class="row">
                    <div class="col-md-12">
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
                                    HASIL RADIOLOGI<br>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row" style="margin-top:5px;">
                    <div class="col-md-6 col-xs-6">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:40%;">No Pendaftaran</td>
                                <td width="2%">:</td>
                                <td><?php echo $dataOrderRow->noPendaftaran; ?></td>
                            </tr>

                            <tr>
                                <td>No Pasien</td>
                                <td>:</td>
                                <td><?php echo $dataOrderRow->noPasien; ?></td>
                            </tr>

                            <tr>
                                <td>Tanggal Daftar</td>
                                <td>:</td>
                                <td><?php echo date_format(date_create($dataOrderRow->tanggalDaftar),'d M Y H:i'); ?></td>
                            </tr>

                            <tr>
                                <td>Dokter Pengirim</td>
                                <td>:</td>
                                <td><?php echo $dataOrderRow->namaDokter; ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6 col-xs-6">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:40%;">Nama Pasien</td>
                                <td width="2%">:</td>
                                <td><?php echo $dataOrderRow->namaPasien; ?></td>
                            </tr>

                            <tr>
                                <td style="width:40%;">Dokter</td>
                                <td width="2%">:</td>
                                <td><?php echo $dokterPemeriksa; ?></td>
                            </tr>

                            <tr>
                                <td>Tanggal Lahir</td>
                                <td>:</td>
                                <td><?php echo date_format(date_create($dataOrderRow->tanggalLahir),'d M Y')." / ".$umur." Thn"; ?></td>
                            </tr>

                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td><?php echo $dataOrderRow->alamat; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div style="border-top:solid 1px #ccc;">
                        </div>
                        <?php
                            foreach($hasilLab as $dt){
                        ?>
                        <h6 style="font-weight:bold;">Pemeriksaan : <?php echo $dt->namaRadiologi; ?></h6>
                        <?php echo $dt->hasil; ?>
                        <?php echo "<br>"; } ?>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>

