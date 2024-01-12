<div class="wraper container-fluid">
    <div class="page-title"> 
        <h3 class="title">Retur Penjualan</h3> 
    </div>

    <div class="row">
        <div class="col-lg-12">
                        <!-- TODO -->
            <div class="portlet" id="todo-container"><!-- /primary heading -->
                <div id="portlet-5" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table width="100%">
                                    <tr>
                                        <td width="30%">No Invoice</td>
                                        <td width="1%">:</td>
                                        <td>
                                            <div class="input-group m-t-10" style="width: 50%;">
                                                <input type="text" id="example-input2-group2" class="form-control input-sm invoiceNo" placeholder="No Invoice">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-effect-ripple btn-primary btn-sm" id="noInvoiceSubmit"><i class="fa fa-search"></i></button>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Tanggal</td>
                                        <td>:</td>
                                        <td id="tanggal"></td>
                                    </tr>

                                    <tr>
                                        <td>Jenis Pembayaran</td>
                                        <td>:</td>
                                        <td id="jenisPembayaran"></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table width="100%">
                                    <tr>
                                        <td width="30%">Nama Customer</td>
                                        <td width="1%">:</td>
                                        <td id="namaCustomer"></td>
                                    </tr>

                                    <tr>
                                        <td>No Telp</td>
                                        <td>:</td>
                                        <td id="noHP"></td>
                                    </tr>

                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td id="alamat"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12" style="text-align: right;">
                                <a class="btn btn-success" id="submit-retur"><i class="fa fa-save"></i> Submit Retur </a>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr style="font-weight: bold;">
                                            <td width="5%">No</td>
                                            <td width="13%">SKU</td>
                                            <td>Nama Barang</td>
                                            <td width="10%" style="text-align: right;">Harga Jual</td>
                                            <td width="10%" style="text-align: center;">Qty Beli</td>
                                            <td width="10%" style="text-align: center;">Retur</td>
                                            <td width="10%" style="text-align: center;">Form Retur</td>
                                            <td width="10%" style="text-align: right;">Subtotal</td>
                                            <td width="10%" style="text-align: right;">Diskon</td>
                                            <td width="10%" style="text-align: right;">Total</td>
                                        </tr>
                                    </thead>

                                    <tbody id="dataRetur">
                                        <tr>
                                            <td colspan="10" id="loading" style="text-align: center;">--Belum ada data--</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        

                    </div>  
                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>

