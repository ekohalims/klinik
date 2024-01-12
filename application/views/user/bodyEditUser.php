<div class="wraper container-fluid">
  <div class="page-title"> 
      <h3 class="title">Edit User</h3> 
    </div>
 
  <div class="row">
    <div class="col-md-6">
      <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
            <div id="portlet2" class="panel-collapse collapse in">
                <div class="portlet-body">
                  <form class="form-horizontal" action="#">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="inputEmail3" class="col-sm-2 control-label">Nama Depan</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="namaDepan" value="<?php echo $user->first_name; ?>">
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="inputEmail3" class="col-sm-2 control-label">Nama Belakang</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo $user->last_name; ?>" id="namaBelakang">
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="inputEmail3" class="col-sm-2 control-label">No HP</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo $user->phone; ?>" id="noHP">
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                              <div class="col-sm-10">
                                <input type="Email" class="form-control" value="<?php echo $user->email; ?>" id="email">
                              </div>
                          </div>

                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Hak Akses</label>
                            <div class="col-sm-10">
                              <select class="form-control" id="hakAkses">
                                <option value="">--Pilih Hak Akses--</option>
                                <?php 
                                  foreach($akses as $row){
                                ?>
                                <option value="<?php echo $row->id; ?>" <?php if($user->hakAkses==$row->id){echo "selected";} ?>><?php echo $row->groups; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                        </div>

                          <div class="form-group">
                              <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo $user->username; ?>" id="username">
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="inputEmail3" class="col-sm-2 control-label">Password</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="password" placeholder="Kosongkan Jika Tidak Ingin Mengganti Password">
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="inputEmail3" class="col-sm-2 control-label">Status</label>
                              <div class="col-sm-10">
                                <select class="form-control" id="status">
                                  <option value="1" <?php if($user->active=='1') {echo "selected"; } ?>>Aktif</option>
                                  <option value="0" <?php if($user->active=='0') {echo "selected"; } ?>>Non Aktif</option>
                                </select>
                              </div>
                          </div>

                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"></label>
                              <div class="col-sm-10">
                                <a class="btn btn-primary editUser"><i class="fa fa-save"></i> Submit</a>
                              </div>
                          </div>
                      </div>

                      <!-- <div class="col-md-6">
                        <?php
                          $permitAccess = json_decode($user->menu);
                          $permitAccessSub = json_decode($user->sub_menu);

                          foreach($navigation as $row){

                            $accessMenu = in_array($row->id,$permitAccess);

                            $checked = $accessMenu > 0 ? "checked" : "";

                            echo "<input type='checkbox' data-id='".$row->id."' id='menu' $checked/>".$row->menu."<br>";

            
                            $submenu = $this->model1->submenu($row->id);
                            foreach($submenu as $dt){
                              $accessSubMenu = in_array($dt->idSub,$permitAccessSub);

                              $checkedSub = $accessSubMenu > 0 ? "checked" : "";
                              echo "&nbsp &nbsp &nbsp <input type='checkbox' data-id='".$dt->idSub."' id='submenu' $checkedSub/>".$dt->menu."<br>";
                            }
                          }
                        ?>
                      </div> -->

                    </div>  
                  </form>          		               
                </div>
            </div>
        </div> <!-- /Portlet -->	
      </div>
      </div>
</div>