<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>List Countries</title>
	<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
</head>
<body>
	<div class="container">
		<div class="row mt-5">
			<div class="col-md-8 mb-2">
				<div class="card">
					<div class="card-header">
						List Countries
					</div>
					<div class="card-body">
						<table class="table table-hover table-sm" id="contries-table">
							<thead>
								<th>#</th>
								<th>Country Name</th>
								<th>Capital City</th>
								<th>Action</th>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card">
					<div class="card-header">
						Insert New Country
					</div>
					<div class="card-body">
						<form action="{{ route('add.country') }}" method="POST" id="add-country">
							@csrf
							<div class="form-group">
								<label for="country_name">Country Name</label>
								<input type="text" name="country_name" class="form-control">
								<span class="text-danger error-text country_name_error"></span>
							</div>
							<div class="form-group">
								<label for="capital_city">Capital Name</label>
								<input type="text" name="capital_city" class="form-control">
								<span class="text-danger error-text capital_city_error"></span>
							</div>
							<div class="form-group">
								<button class="btn btn-primary btn-block">Save</button>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('countries.edit-modal')

	<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
	<script src="{{ asset('toastr/toastr.min.js') }}"></script>

	<script>
		toastr.options.preventDuplicates = true;

		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$(function(){

			// Add Country
			$('#add-country').on('submit',function(e){
				e.preventDefault();

				var form = this;

				$.ajax({
					url:$(form).attr('action'),
					method:$(form).attr('method'),
					data:new FormData(form),
					processData:false,
					dataType:'json',
					contentType:false,
					beforeSend:function(){
						$(form).find('span.error-text').text('');
					},
					success:function(data){
						if (data.code == 0) {
							$.each(data.error,function(prefix,val){
								$(form).find('span.'+prefix+'_error').text(val[0]);
							});
						}else{
							$(form)[0].reset();
							$('#contries-table').DataTable().ajax.reload(null,false);
							toastr.success(data.msg);
						}
					},
					error:function(e){
						console.log(e);
					}
				});
			});

			// Get Countries
			$('#contries-table').DataTable({
				processing:true,
				info:true,
				ajax:"{{ route('get.contyies.list') }}",
				columns:[
					// {data:'id',name:'id'},
					{data:"DT_RowIndex",name:"DT_RowIndex"},// ระบุให้เรียงลำดับใหม่โดยไม่สนลำดับในฐานข้อมูล
					{data:"country_name",name:"country_name"},
					{data:"capital_city",name:"capital_city"},
					{data:"action",name:"action"}
				]
			});

			// Edit Country
			$(document).on('click','#editCountryBtn',function(){
				var id = $(this).data('id');
				$.post("<?= route('get.country.details')?>",{country_id:id},function(data){
					// alert(data.details.country_name);
					$('#edit-country').find('input[name="cid"]').val(data.details.id);
					$('#edit-country').find('input[name="country_name"]').val(data.details.country_name);
					$('#edit-country').find('input[name="capital_city"]').val(data.details.capital_city);
					$('#edit-country').modal('show');
				},'json');
			});

			//Update Country
			$('#frmUpdateCountry').on('submit',function(e){
				e.preventDefault();
				var form = this;
				$.ajax({
					url:$(form).attr('action'),
					method:$(form).attr('method'),
					data:new FormData(form),
					processData:false,
					dataType:'json',
					contentType:false,
					beforeSend:function(){
						$(form).find('span.error-text').text('');
					},
					success:function(data){
						if (data.code == 0) {
							$.each(data.error,function(prefix,val){
								$(form).find('span.'+prefix+'_error').text(val[0]);
							});
						}
						else{
							$('#contries-table').DataTable().ajax.reload(null,false);
							$('#edit-country').modal('hide');
							$('#edit-country').find('form')[0].reset();
							toastr.success(data.msg);
						}
					}
				});
			});

		});
	</script>

</body>
</html>