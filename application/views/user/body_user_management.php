<div class="wraper container-fluid">
    <div class="page-title"> 
      <h3 class="title"><i class="fa fa-users"></i> User</h3> 
    </div>

	<div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
            	<div class="row">
            		<div class="col-md-12">
	            		<div class="form-inline" style="text-align: right;">
	            			<div class="form-group">
	            				<a href="<?php echo base_url('user/tambah_user'); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i> Tambah User</a>
	            				<a href="<?php echo base_url('user/logUser'); ?>" class="btn btn-default btn-rounded"><i class="fa fa-filter"></i> Log User</a>
	            			</div>
	            		</div>
            		</div>
            	</div>

            	<div class="row" style="margin-top: 20px;">
            		<div class="col-md-12 table-borderedsponsive">
            			<table class="table" id="myTable" style="font-size:12px;">
            				<thead>
	            				<tr style="font-weight: bold;">
							        <th width="5%" style="text-align: center;">No</th>
							        <th width="25%">Nama User</th>
							        <th>Kontak</th>
							        <th>Email</th>
							        <th>Status</th>
							        <th width="6%"></th>
							   	</tr>
						   </thead>

						   <tbody>
							   	<?php 
							   		$i=1;
							   		foreach($user->result() as $row){
							   	?>
							   	<tr>
							   		<td style="text-align: center; "><?php echo $i; ?></td>
							   		<td><?php echo $row->first_name." ".$row->last_name; ?></td>
							   		<td><?php echo $row->phone; ?></td>
							   		<td><?php echo $row->email; ?></td>
							   		<td><?php if($row->active==1){echo"Aktif";} else {echo "Non Aktif";} ?></td>
							   		<td style="text-align: center;"><a href="<?php echo base_url('user/editUser?id_user='.$row->id); ?>"><i class="fa fa-edit"></i></a></td>
							   	</tr>
							   	<?php $i++; } ?>
						   </tbody>
            			</table>
            		</div>
            	</div>               
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>