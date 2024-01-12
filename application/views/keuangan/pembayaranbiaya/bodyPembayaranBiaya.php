<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-copy"></i> Pembayaran Biaya</h3> 
	</div>

    <div class="row">
        <div class="col-md-7">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <table class="table table-hover">
                            <tr>
                                <td width="20%">Akun**</td>
                                <td width="2%">:</td>
                                <td>
                                    <select class="select2" id="kodeAkun">
                                        <option value="">--Pilih Akun--</option>

                                        <?php
                                            foreach($biayaAktif as $row){
                                        ?>
                                        <option value="<?php echo $row->kodeSubAkun; ?>"><?php echo $row->namaSubAkun; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td style="vertical-align:middle;">Jenis Bayar**</td>
                                <td style="vertical-align:middle;">:</td>
                                <td>
                                    <select class="form-control" id="jenisBayar">
                                        <option value="">--Pilih Jenis Bayar--</option>
                                        <option value="1">Cash</option>
                                        <option value="2">Transfer</option>
                                    </select>
                                </td>
                            </tr>
                            
                            <tr id="akunForm">
                            </tr>

                            <tr>
                                <td style="vertical-align:middle;">Jumlah Bayar**</td>
                                <td style="vertical-align:middle;">:</td>
                                <td>
                                    <input type="text" class="form-control" id="jumlahBayar"/>
                                </td>
                            </tr>

                            <tr>
                                <td style="vertical-align:middle;">Terbilang</td>
                                <td style="vertical-align:middle;">:</td>
                                <td id="terbilang"></td>
                            </tr>

                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td><textarea class="form-control" id="keterangan"></textarea></td>
                            </tr>

                            <tr>
                                <td colspan="3" style="text-align:right;"><a class="btn btn-success btn-rounded" id="simpanPembayaran">Simpan</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>

