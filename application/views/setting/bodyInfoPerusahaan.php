<div class="wraper container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="page-title"> 
              <h3 class="title"><i class="fa fa-building"></i> Info Klinik</h3> 
            </div>

            <div class="portlet"><!-- /primary heading -->
                  <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <?php
                            echo $this->session->userdata("message");
                        ?>
                        <table width="100%">
                            <tr style="height:40px;">
                                <td width="30%">Nama Perusahaan</td>
                                <td><input type="text" value="<?php echo $klinfo->namaKlinik; ?>" id="companyName" class="form-control"/></td>
                            </tr>

                            <tr style="height:40px;">
                                <td width="30%">No Telp</td>
                                <td><input type="text" value="<?php echo $klinfo->telepon; ?>" id="kontak" class="form-control"/></td>
                            </tr>

                            <tr style="height:40px;">
                                <td width="30%">Alamat</td>
                                <td><input type="text" value="<?php echo $klinfo->alamat; ?>" id="address" class="form-control"/></td>
                            </tr>

                            <tr style="height:48px;">
                                <td width="30%">Provinsi</td>
                                <td>
                                    <select class="select2" id="provinsi">
                                        <option value="">--Pilih Provinsi--</option>
                                        <?php
                                            foreach($provinsi as $row){
                                        ?>
                                        <option value="<?php echo $row->id_provinsi; ?>" <?php if($row->id_provinsi==$klinfo->provinsi){echo "selected";} ?>><?php echo $row->nama_provinsi; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>

                            <tr style="height:48px;">
                                <td width="30%">Kabupaten</td>
                                <td>
                                    <select class="select2" id="list-kabupaten">
                                        <option value="">--Pilih Kabupaten--</option>
                                        <?php
                                            foreach($kabupaten as $kb){
                                        ?>
                                        <option value="<?php echo $kb->kabupaten_id; ?>" <?php if($kb->kabupaten_id==$klinfo->kabupaten) {echo "selected"; } ?>><?php echo $kb->nama_kabupaten; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>

                            <tr style="height:48px;">
                                <td width="30%">Kecamatan</td>
                                <td>
                                    <select class="select2" id="list-kecamatan">
                                        <option value="">--Pilih Kecamatan--</option>
                                        <?php
                                            foreach($kecamatan as $kc){
                                        ?>
                                        <option value="<?php echo $kc->id_kecamatan; ?>" <?php if($kc->id_kecamatan==$klinfo->kecamatan) {echo "selected"; } ?>><?php echo $kc->kecamatan; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>

                            <tr style="height: 50px;">
                                <td colspan="2" align="right"><button class="btn btn-success btn-rounded" id="simpanInfo"><i class="fa fa-save"></i> Simpan</button></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div> <!-- /Portlet -->    
        </div>
    </div>  
</div>

