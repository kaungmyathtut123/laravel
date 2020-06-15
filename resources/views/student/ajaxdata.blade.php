<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Datables Server Side Processing in laravel</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="{{ asset('css/custom.css') }}">   
	<style>
		th{
			text-align: center;
		  }
		tr{
			text-align: center;
		  }
		td{
			width:80px;
		 }
		.del_alert{
         display:block;
				 border-radius:5px;
				 margin-left:auto;
				 margin-right:auto;
				 width:50%;
				 background-color: cyan;
				 text-align: center;
				 padding:20px;
		          }
	</style>
</head>
<body>
	<div class="container">
		<br>
		<h3 align="center">Datatables Server Side Processing in Laravel</h3>
		<!-- <br>
		<div class="del_alert">
			<h4>Are You Sure You Want To Delete?</h4>
			<br>
			<a href="#" class="btn btn-danger">Yes</a>
			<a href="#" class="btn btn-primary">No</a>
		</div> -->
		<div align="right">
			<button type="button" name="add" id="add_data" class="btn btn-primary btn-sm">Add New</button>
		</div>
		<br>
		<table id="student_table" class="table table-bordered" style="margin-left:auto;margin-right:auto;width:100%;">
			<thead>
				<tr>
					<th>Id</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Actions</th>
				</tr>
			</thead>
		</table>
	</div>
	<div id="studentModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<form method="post"  id="student_form" style="display: block;background-color: white;">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Data</h4>
				</div>
				<div class="modal-body">
					@csrf
					<span style="margin-left:auto;margin-right:auto;" id="form_output"></span>
					<div class="form-group">
						<label >Enter First Name</label>
						<input type="text" name="first_name" id="first_name" class="form-control" required >
					</div>
					<div class="form-group">
						<label>Enter Last Name</label>
						<input type="text" name="last_name" id="last_name" class="form-control"  required >
					</div>
					<div class="active form-group">
						<label>Active</label>
						<input type="text" name="active" id="active" class="status form-control"   >
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="student_id" id="student_id" value="">
					<input type="hidden" name="button_action" id="button_action" value="insert">
					<input type="submit" name="submit" id="action" value="add" class="btn btn-info">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$('#student_table').DataTable({
				"processing":true,
				"serverSide":true,
				"ajax":"{{route('ajaxdata.getdata')}}",
				"columns":[
				{data:'id',name:'id'},
				{data:'first_name',name:'first_name'},
				{data:'last_name',name:'last_name'},
				{"data":"action",orderable:false,searchable:false}
				]
			});

			$('#add_data').click(function(){
				$('#studentModal').modal('show');
				$('#student_form')[0].reset();
				$('#form_output').html();		
				$('.active').hide();		
				$('button_action').val('insert');
				$('#action').val('Add');
			});

			$('#student_form').on('submit',function(event){
				event.preventDefault();
				var form_data=$(this).serialize();
				$.ajax({
					url:"{{route('ajaxdata.insertdata')}}",
					method:"post",
					data:form_data,
					dataType:"json",
					success:function(data){
						$('#form_output').html(data['success']);
						$('#student_form')[0].reset();
						$('#action').val('Add');
						$('.active').hide();
						$('.modal-title').text('Add Data');
						$('#button_action').val('insert');
						// $('#student_table').DataTable().ajax.reload();
						var oTable = $('#student_table').dataTable();
						oTable.fnDraw(false);
						}
					})
			    })
				$('#student_table').on('click','.edit',function(){
					var id=$(this).attr("id");
					$.ajax({
						url:"{{route('ajaxdata.fetchdata')}}",
						method:"get",
						data:{id:id},
						dataType:"json",
						success:function(data)
						{
								$('#first_name').val(data['first_name']);
								$('#last_name').val(data['last_name']);
								$('.active').show();
								$('#active').val(data['active']);
								$('#student_id').val(id);
								$('#studentModal').modal('show');
								$('#action').val('Edit');
								$('.modal-title').text('Edit Data');
								$('#button_action').val('update');
						}
					})
			   })
			$('#student_table').on('click','.delete',function(){
				var id=$(this).attr('id');
				if(confirm('Are You Sure You Want To Delete?')){
					$.ajax({
						url:"{{route('ajaxdata.removedata')}}",
						method:"get",
						data:{id:id},						
						success:function(data){							    
								alert(data);
								var oTable = $('#student_table').dataTable();
								oTable.fnDraw(false);
						}
					})
				}else{

				}
			})
		});
	</script>
	<!-- <script>
		$(document).ready(function(){			
			$('#action').click(function(){
				   $('.active').hide();
				   $('#action').val('Add');
			});
		});
	</script> -->
</body>
</html>
