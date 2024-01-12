<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-print"></i> Cetak Resep</h3> 
            </div>
        </div>

        <div class="col-md-6" style="text-align:right;">
            <a class="btn btn-success" onclick="printContent('print-area')"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body" id="print-area">
                        <div class="row">
                            <div class="col-md-12">
                                <table width="100%">
                                    <tr>
                                        <td style="vertical-align:top;" width="10%"><img src="<?php echo base_url('assets/'.$header->image); ?>" height="80px"/></td>
                                        <td style="vertical-align:middle;text-align:center;">
                                            <span style="font-weight:bold;font-size:15px;"><?php echo $header->namaKlinik; ?></span>
                                            <p>
                                                <?php echo $header->alamat; ?> <br>
                                                Provinsi <?php echo $header->nama_provinsi; ?> Telp. <?php echo $header->telepon; ?>
                                            </p>
                                            <p style="font-size:15px;"><b>RESEP</b></p>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Qty</th>
                                            <th>Satuan</th>
                                            <th>Aturan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($cart->result() as $row){
                                        ?>
                                        <tr>
                                            <td><?php echo $row->nama_produk; ?></td>
                                            <td><?php echo $row->jumlah; ?></td>
                                            <td><?php echo $row->satuan; ?></td>
                                            <td><?php echo $row->aturan; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /Portlet -->	
        </div>
    </div>
</div>
