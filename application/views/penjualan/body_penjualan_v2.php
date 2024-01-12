<div id="CssLoader" style="display: none;">
    <div class='spinftw'></div>
</div>

<div class="wraper container-fluid" style="height: 100%;">
    <!--<div class="portlet">
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-6" align="left">
                            <a href="<?php echo base_url('penjualan/data_penjualan'); ?>"> <i class="fa fa-book"></i> Data Penjualan </a> | <!--<a href="<?php echo base_url('penjualan/reservasi'); ?>"> <i class="fa fa-history"></i> Reservasi </a> | <a href="<?php echo base_url('penjualan/pendingList'); ?>"> <i class="fa fa-clock-o"></i> Daftar Pending </a> | <a href="<?php echo base_url('penjualan/retur'); ?>"> <i class="fa fa-cog"></i> Retur </a>
                    </div>
        
                    <div class="col-md-6" style="text-align: right;">
                        <button id="button-submit" class="btn btn-icon btn-primary btn-rounded m-b-5"> <i class=" fa fa-check-square-o"></i> Submit</button>
                        <button id="pendingTrx" class="btn btn-con btn-success btn-rounded m-b-5"><i class="fa fa-clock-o"></i> Pending</button>                            
                        <a class="btn btn-con btn-danger btn-rounded m-b-5" href="<?php echo base_url('penjualan/cancelTrx'); ?>"><i class="fa fa-times"></i> Batal</a>
                    </div>
                </div>  
            </div>
        </div>
    </div> --> 

    <div class="row" style="min-height: 100%;">
        <div class="col-md-2">
            <div class="portlet"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12 niceScrollOk" style="font-size: 14px;">

                                <div class="form-group">
                                    <form role="search" class="app-search" style="width: 100%;">
                                      <input type="text" placeholder="Search..." class="form-control" id="searchMenu">
                                        <a href=""><i class="fa fa-search"></i></a>
                                    </form>
                                </div>

                                <div class="form-group" style="margin-top: 5px;">
                                    <?php
                                        foreach($kategori as $row){
                                            echo "<a class='kategoriProduk' id='".$row->id_kategori."'><p style='background:#12a89d;padding:10px;color:white;font-size:12px;'>".$row->kategori."</p></a>";
                                        }
                                    ?> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="row" id="viewMenu">

            </div>
        </div> 

        <div class="col-md-3">
            <div class="portlet"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <a href="#submitModal" data-toggle="modal" id="submitPenjualan" class="btn btn-success btn-rounded btn-sm"> Checkout </a> <a class="btn btn-warning btn-rounded btn-sm" id="pendingTrx"> Hold </a> <a class="btn btn-danger btn-rounded btn-sm" id="cancelTrx"> Cancel </a>
                            </div>
                        </div>

                        <div class="row" style="padding: 5px;background: #cdcdcd;color: black;border-top-left-radius: 10px;border-top-right-radius: 10px;margin-top: 10px;">
                            <div class="col-md-6" style="font-size: 12px;border-right: 1px solid #000">
                                <a href="#modalPilihCustomer" data-toggle="modal" id="customerTerpilih"><i class="fa fa-user"></i> Customer</a> <a class="deleteCustomerButton"></a>
                                <input type="hidden" id="idCustomer">
                            </div>

                            <div class="col-md-6" style="font-size: 12px;text-align: right;">
                                <a href="#opsiPengirimanModal" data-toggle="modal" id="pengirimanUrl"><i class="fa fa-car"></i> Pengiriman</a> <a id="buttonPengiriman"></a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12" style="text-align: right;font-weight: bold;font-size: 13px;background: #12a89d;color: white;border-bottom-right-radius: 10px;border-bottom-left-radius: 10px;">
                                <table width="100%">
                                    <tr>
                                        <td width="60%">Subtotal</td>
                                        <td id="subtotal"></td>
                                    </tr>

                                    <tr>
                                        <td>Diskon</td>
                                        <td id="diskon"></td>
                                    </tr>

                                    <tr>
                                        <td>Ongkir</td>
                                        <td id="ongkirLabel"></td>
                                    </tr>

                                    <tr>
                                        <td>Poin Reimburs</td>
                                        <td id="poinReimbursLabel"></td>
                                    </tr>

                                    <tr style="font-weight: bold;font-size: 14px;border-top: solid 1px #fff;">
                                        <td>Total</td>
                                        <td id="grandTotal"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 5px;">
                            <div class="col-md-12" id="data-input" style="height: 63vh;background: #ebebeb;border-radius: 10px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

    </div>	
</div>

<div id="customerModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Customer</h4>
            </div>                             
            <div class="modal-body" id="customerFormAdd">
                <div class="row">
                    <div class="col-md-6"/>
                            <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-md-2 control-label">No Member</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="noMember" required>
                                    <label id="labelNoMember" style="color:red;"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Nama Customer</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="namaCustomer" required>
                                    <label id="labelNamaCust" style="color:red;"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Kontak</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="kontak" required>
                                    <label id="labelKontak" style="color:red;"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Email</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="email" required>
                                    <label id="labelEmail" style="color:red;"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Tanggal Lahir</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control datepicker" id="tanggalLahir" required readonly>
                                </div>
                            </div>


                                <div class="form-group">
                                        <label class="col-md-2 control-label">Kategori Customer</label>
                                        <div class="col-md-10">
                                            <select class="form-control" id="kategoriCustomer" required>
                                                <option value="">--Pilih Kategori--</option>
                                                <?php
                                                    foreach($group_customer->result() as $cs){
                                                ?>
                                                <option value="<?php echo $cs->id_group; ?>"><?php echo $cs->group_customer; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                            <div class="form-group">
                                <label class="col-md-2 control-label">Diskon Member</label>
                                <div class="col-md-10">
                                    <input type="number" id="diskon" class="form-control" min="0" max="100" required>
                                </div>
                            </div>

                            </form> 
                    </div>

                    <div class="col-md-6">
                        <form class="form-horizontal" role="form">
                         <div class="form-group">
                                <label class="col-md-2 control-label">Alamat</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" id="alamat" required></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Provinsi</label>
                                <div class="col-md-10">
                                    <select class="select2" id="provinsi" required>
                                        <option value="">--Pilih Provinsi--</option>
                                        <?php
                                            foreach($provinsi->result() as $pro){
                                        ?>
                                        <option value="<?php echo $pro->id_provinsi; ?>"><?php echo $pro->nama_provinsi; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Kabupaten</label>
                                <div class="col-md-10">
                                    <select class="select2" id="list-kabupaten" required>
                                        <option value="">--Pilih Kabupaten--</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Kecamatan</label>
                                <div class="col-md-10">
                                    <select class="select2" id="list-kecamatan" name="kecamatan" required>
                                        <option value="">--Pilih Kecamatan--</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" style="text-align: right;">
                                <div class="col-md-12">
                                    <a class="btn btn-primary" id="simpanMember">Simpan</a>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>                                 
            </div>                                    
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div id="opsiPengirimanModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-car"></i> Alamat Pengiriman</h4>
            </div>                             
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        Gunakan Alamat Customer Terpilih ? <input type="checkbox" id="alamatCustomer"/> 
                    </div>
                </div>

                <div class="row" id="alamatContent" style="margin-top: 10px;">
                    <div class="col-md-6">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Nama Penerima</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="namaPenerima" required>
                                    <label id="labelNamaCust" style="color:red;"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">No HP</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="kontakPenerima" required>
                                    <label id="labelKontak" style="color:red;"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Ekspedisi</label>
                                <div class="col-md-10">
                                    <select class="form-control" id="ekspedisi">
                                        <option value="">--Pilih Ekspedisi--</option>
                                        <?php
                                            foreach($ekspedisi as $eks){
                                        ?>
                                        <option value="<?php echo $eks->id_ekspedisi; ?>"><?php echo $eks->ekspedisi; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div> 

                            <div class="form-group">
                                <label class="col-md-2 control-label">Ongkir</label>
                                <div class="col-md-10">
                                    <input type="text" id="ongkir" name="ongkir" class="form-control" placeholder="Ongkir" value="<?php if($ongkir > 0){echo $ongkir;} ?>">
                                </div>
                            </div>
                        </form>                            
                    </div>

                    <div class="col-md-6">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Alamat</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" id="alamatPenerima" required></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Provinsi</label>
                                <div class="col-md-10">
                                    <select class="select2" id="provinsiPenerima">
                                        <option value="">--Pilih Provinsi--</option>
                                        <?php
                                            foreach($provinsi->result() as $prp){
                                        ?>
                                        <option value="<?php echo $prp->id_provinsi; ?>"><?php echo $prp->nama_provinsi; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Kabupaten</label>
                                <div class="col-md-10">
                                    <select class="select2" id="kabupatenPenerima">
                                        <option value="">--Pilih Kabupaten--</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Kecamatan</label>
                                <div class="col-md-10">
                                    <select class="select2" id="kecamatanPenerima">
                                        <option value="">--Pilih Kecamatan--</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>     
            </div>        
            <div class="modal-footer">
                <button class="btn btn-primary" id="hidePengiriman"><i class="fa fa-save"></i> Simpan</button>
            </div>                            
        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div>

<div id="modalPilihCustomer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Customer </h4>
            </div>                             
            <div class="modal-body">
                <table class="table table-bordered" id="datatableCustomer">
                    <thead>
                        <tr style="font-weight: bold;">
                            <td>ID Customer</td>
                            <td>Nama Customer</td>
                            <td>Alamat</td>
                            <td>Jumlah Poin</td>
                        </tr>
                    </thead>
                </table>
            </div>                            
        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div>


<div id="submitModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Checkout</h4>
            </div>                             
            <div class="modal-body" id="checkoutContent">
                
                
            </div>        

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="prosesPenjualan">Proses Penjualan</button>

            </div>                           
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
