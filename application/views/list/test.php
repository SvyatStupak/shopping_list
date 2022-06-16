<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>CodeIgniter Ajax CRUD using jQuery</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
	<script src="<?php echo base_url(); ?>jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	<h1 class="page-header text-center">CodeIgniter Ajax CRUD using jQuery</h1>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<button class="btn btn-primary" id="add"><span class="glyphicon glyphicon-plus"></span> Add New</button>
			<table class="table table-bordered table-striped" style="margin-top:20px;">
				<thead>
					<tr>
						<th>ID</th>
						<th>Email</th>
						<th>Password</th>
						<th>FullName</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="tbody">
				</tbody>
			</table>
		</div>
	</div>
	<?php echo $modal; ?>
 
<script type="text/javascript">
$(document).ready(function(){
	//create a global variable for our base url
	var url = '<?php echo base_url(); ?>';
 
	//fetch table data
	showTable();
 
	//show add modal
	$('#add').click(function(){
		$('#addnew').modal('show');
		$('#addForm')[0].reset();
	});
 
	//submit add form
	$('#addForm').submit(function(e){
		e.preventDefault();
		var user = $('#addForm').serialize();
			$.ajax({
				type: 'POST',
				url: url + 'user/insert',
				data: user,
				success:function(){
					$('#addnew').modal('hide');
					showTable();
				}
			});
	});
 
	//show edit modal
	$(document).on('click', '.edit', function(){
		var id = $(this).data('id');
		$.ajax({
			type: 'POST',
			url: url + 'user/getuser',
			dataType: 'json',
			data: {id: id},
			success:function(response){
				console.log(response);
				$('#email').val(response.email);
				$('#password').val(response.password);
				$('#fname').val(response.fname);
				$('#userid').val(response.id);
				$('#editmodal').modal('show');
			}
		});
	});
 
	//update selected user
	$('#editForm').submit(function(e){
		e.preventDefault();
		var user = $('#editForm').serialize();
		$.ajax({
			type: 'POST',
			url: url + 'user/update',
			data: user,
			success:function(){
				$('#editmodal').modal('hide');
				showTable();
			}
		});
	});
 
	//show delete modal
	$(document).on('click', '.delete', function(){
		var id = $(this).data('id');
		$.ajax({
			type: 'POST',
			url: url + 'user/getuser',
			dataType: 'json',
			data: {id: id},
			success:function(response){
				console.log(response);
				$('#delfname').html(response.fname);
				$('#delid').val(response.id);
				$('#delmodal').modal('show');
			}
		});
	});
 
	$('#delid').click(function(){
		var id = $(this).val();
		$.ajax({
			type: 'POST',
			url: url + 'user/delete',
			data: {id: id},
			success:function(){
				$('#delmodal').modal('hide');
				showTable();
			}
		});
	});
 
});
 
function showTable(){
	var url = '<?php echo base_url(); ?>';
	$.ajax({
		type: 'POST',
		url: url + 'user/show',
		success:function(response){
			$('#tbody').html(response);
		}
	});
}
</script>
</div>
</body>
</html>


<!-- Add New -->
<div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Add New Member</h4></center>
            </div>
            <div class="modal-body">
			<div class="container-fluid">
			<form id="addForm">
				<div class="row">
					<div class="col-md-3">
						<label class="control-label" style="position:relative; top:7px;">Email:</label>
					</div>
					<div class="col-md-9">
						<input type="email" class="form-control" name="email" required>
					</div>
				</div>
				<div style="height:10px;"></div>
				<div class="row">
					<div class="col-md-3">
						<label class="control-label" style="position:relative; top:7px;">Password:</label>
					</div>
					<div class="col-md-9">
						<input type="password" class="form-control" name="password" required>
					</div>
				</div>
				<div style="height:10px;"></div>
				<div class="row">
					<div class="col-md-3">
						<label class="control-label" style="position:relative; top:7px;">Full Name:</label>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" name="fname" required>
					</div>
				</div>
            </div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
			</form>
            </div>
 
        </div>
    </div>
</div>
 
<!-- Edit -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Edit Member</h4></center>
            </div>
            <div class="modal-body">
			<div class="container-fluid">
			<form id="editForm">
				<div class="row">
					<div class="col-md-3">
						<label class="control-label" style="position:relative; top:7px;">Email:</label>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" name="email" id="email">
					</div>
				</div>
				<div style="height:10px;"></div>
				<div class="row">
					<div class="col-md-3">
						<label class="control-label" style="position:relative; top:7px;">Password:</label>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" name="password" id="password">
					</div>
				</div>
				<div style="height:10px;"></div>
				<div class="row">
					<div class="col-md-3">
						<label class="control-label" style="position:relative; top:7px;">Full Name:</label>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" name="fname" id="fname">
					</div>
				</div>
				<input type="hidden" name="id" id="userid">
            </div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-check"></span> Update</a>
			</form>
            </div>
 
        </div>
    </div>
</div>
 
<!-- Delete -->
<div class="modal fade" id="delmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Delete Member</h4></center>
            </div>
            <div class="modal-body">
				<h4 class="text-center">Are you sure you want to delete</h4>
				<h2 id="delfname" class="text-center"></h2>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <button type="button" id="delid" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Yes</button>
            </div>
 
        </div>
    </div>
</div>

