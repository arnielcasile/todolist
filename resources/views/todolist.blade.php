<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Todo List</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
<style>
body {
	color: #566787;
	background: #f5f5f5;
	font-family: 'Varela Round', sans-serif;
	font-size: 13px;
}
.table-wrapper {
	background: #fff;
	padding: 20px 25px;
	border-radius: 3px;
	min-width: 1000px;
	box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.table-title {        
	padding-bottom: 15px;
	background: #435d7d;
	color: #fff;
	padding: 16px 30px;
	min-width: 100%;
	margin: -20px -25px 10px;
	border-radius: 3px 3px 0 0;
}
.table-title .btn {
	color: #fff;
	float: right;
	font-size: 13px;
	border: none;
	min-width: 50px;
	border-radius: 2px;
	border: none;
	outline: none !important;
	margin-left: 10px;
}
table.table tr th, table.table tr td {
	border-color: #e9e9e9;
	padding: 12px 15px;
	vertical-align: middle;
}
table.table tr th:first-child {
	width: 60px;
}

/* Modal styles */
.modal .modal-dialog {
	max-width: 400px;
}
.modal .modal-header, .modal .modal-body, .modal .modal-footer {
	padding: 20px 30px;
}
.modal .modal-content {
	border-radius: 3px;
	font-size: 14px;
}
.modal .modal-footer {
	background: #ecf0f1;
	border-radius: 0 0 3px 3px;
}
.modal .modal-title {
	display: inline-block;
}
.modal .form-control {
	border-radius: 2px;
	box-shadow: none;
	border-color: #dddddd;
}
.modal .btn {
	border-radius: 2px;
	min-width: 100px;
}		
</style>
</head>
<body>
<div class="container-xl">
	<div class="table-responsive">
		<div class="alert alert-success success-block">
			<strong>Welcome {{ Auth::user()->name }}</strong>
			<br>
			<a  href="/main/logout"><i class="fa fa-sign-out"></i> Logout</a>
		</div>	
		<br>
		<div class="table-wrapper">
			
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Todo <b>List</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="#modal_add_todo" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i> Add New</a>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<label for=""><i class="fa fa-search"></i> Filter</label>
				<select class="form form-control" id="slc_todolist" onchange="TODOLIST.filter_todo()">
					<option value="0">Active</option>
					<option value="1">Completed</option>
				</select>
			</div><br>
			<table class="table table-striped table-hover" id="tbl_todolist">
				<thead>
					<tr>
						<th></th>
						<th>No.</th>
						<th>Name</th>
						<th>Completion Date</th>
						<th>Deadline</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>        
</div>
<!-- Edit Modal HTML -->
<div id="modal_add_todo" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="modal-header">						
                <h4 class="modal-title">Add Todo List</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">					
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="txt_name" required>
                </div>
                <div class="form-group">
                    <label>Deadline</label>
                    <input type="datetime-local" class="form-control" id="deadline" required>
                </div>				
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btn_cancel" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success" id="btn_submit" onclick="TODOLIST.store_todo()">Save</button>
            </div>
		</div>
	</div>
</div>
<!-- Edit Modal HTML -->
<div id="modal_update_todo" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
        <div class="modal-header">						
                <h4 class="modal-title">Update Todo List</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">					
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="txt_edit_name" required>
                </div>
				<div class="form-group">
                    <label>Completion Date</label>
                    <input type="datetime-local" class="form-control" id="edit_completion" required>
                </div>
                <div class="form-group">
                    <label>Deadline</label>
                    <input type="datetime-local" class="form-control" id="edit_due_date" required>
                </div>				
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btn_cancel_edit" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success" id="btn_submit_edit" onclick="TODOLIST.update_todo()">Update</button>
            </div>
		</div>
	</div>
</div>
<!-- Delete Modal HTML -->
<div id="modal_delete_todo" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header">						
					<h4 class="modal-title">Delete Todo</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<p>Are you sure you want to delete these Records?</p>
					<p class="text-warning"><small>This action cannot be undone.</small></p>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" id="btn_cancel_delete" data-dismiss="modal">Cancel</button>
                	<button class="btn btn-success" id="btn_submit_delete" onclick="TODOLIST.delete_todo()">Delete</button>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="../scripts/todolist.js"></script> 
</html>

