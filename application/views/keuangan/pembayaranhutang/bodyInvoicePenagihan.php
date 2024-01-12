<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-file"></i> Data Tagihan</h3> 
                <h6><a href="<?php echo base_url('pembayaranHutangPO'); ?>">Pembayaran Hutang</a> / Data Tagihan</h6>
            </div>
        </div>

        <div class="col-md-6" style="text-align:right;" id="buttonTransaksi">

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row" id="headerTagihan">
                        </div>

                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-12">
                                <table class="table table-bordered" style="font-size:11px;">
                                    <thead>
                                        <th width="5%" style="text-align:center;">No</th>
                                        <th width="10%">Kode Item</th>
                                        <th>Nama Item</th>
                                        <th style="text-align:center;">Qty</th>
                                        <th style="text-align:center;">Diterima</th>
                                        <th style="text-align:center;">Sisa PO</th>
                                        <th style="text-align:center;">Retur</th>
                                        <th style="text-align:center;">Satuan</th>
                                        <th style="text-align:right;">Harga Satuan</th>
                                        <th style="text-align:right;"   >Subtotal</th>
                                    </thead>

                                    <tbody id="dataTagihan">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div>	
    </div>

    <div class="row" style="margin-top:5px;">
        <div class="col-md-6" id="formPembayaranHutang">
            
        </div>

        <div class="col-md-6" id="informasiSupplier">
            
        </div>
    </div>

    <div class="row" style="margin-top:5px;">
        <div class="col-md-6">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        Riwayat Pembayaran
                    </h3>
                </div>
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body" id="riwayatPembayaran">

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark">
                        Riwayat Penerimaan Barang
                    </h3>
                </div>

                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Penerimaan</th>
                                    <th>PIC</th>
                                    <th>Tanggal</th>
                                    <th>Tempat Penerimaan</th>
                                </tr>
                            </thead>
                            <tbody id="riwayatPenerimaan">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
