<?php 
include 'inc/globals.php';
if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Appointment Request</h3>
		<div class="card-tools">
			<a href="?page=deposits/record_income" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<col width="10%">
					<col width="25%">
					<col width="30%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>deposit date</th>
						<th>member</th>
						<th>amount</th>
						<th>Deposit for</th>
						<th>Description</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * from `deposits`  WHERE active=1");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("M d,Y",strtotime($row['deposit_date'])) ?></td>
							<td><?php echo $row['member_id'] ?></td>
							<td>
								<?php echo number_format($row['amount']) ?><br>
								
							</td>
							<td><?php echo $deposit_types[$row['type']] ?? 'Not set' ?><br></td>	
							<td>
								<p class="m-0 truncate"><?php echo $row['description'] ?></p>
							</td>
							<td class="text-center">
								<?php if($row['active'] == 1): ?>
									<span class="badge badge-success">Active</span>
								<?php elseif($row['active'] == 0): ?>
									<span class="badge badge-danger">Voided</span>
								<?php else: ?>
									<span class="badge badge-primary">Pending</span>
								<?php endif; ?>
							</td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Appointment Request permanently?","delete_appointment_request",[$(this).attr('data-id')])
		})
		$('.edit_data').click(function(){
			uni_modal("Manage Appointment Request","appointment/manage_appointment.php?id="+$(this).attr('data-id'),'mid-large')
		})
		$('.table th, .table td').addClass("py-1 px-1 align-middle");
		$('.table').dataTable();
	})
	function delete_appointment_request($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_appointment_request",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>