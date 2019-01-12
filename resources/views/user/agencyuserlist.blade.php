@extends('layouts.app')

@section('content')
<?php
$getid = ''; 
if(isset($_GET['agencyid'])) {
	$getid = $_GET['agencyid'];
} else {
	$getid =  '';
}

$route = 'userinsert';
if (isset($userlist) && !empty($userlist)){ $route = 'userupdate'; }
?>
<!-- END: Left Aside -->

	<!-- BEGIN: Subheader -->
	
	<!-- END: Subheader -->
	
	
	<div class="m-content agencies_list">
		<div class="row" >
			<div class="col-md-6">
				<div class="form-group m-form__group">
					<form>
						<select id= "agency" class="form-control m-input m-input--square agent" onchange="this.form.submit()" name="agencyid">                                                   <option value="0"> -- Select Agency Name -- </option>
							@foreach ($agency as $row)
							<option value="<?php echo $row->id; ?>" <?php if($row->id == $getid) { ?> selected="selected" <?php } ?>><?php echo $row->name ?></option>                                                    @endforeach          
						</select>
					</form>
				</div>
			</div>
		</div>
		<div class="m-portlet m-portlet-padding agency-info-tab">
			
			<div class="data-table-block">
				<table class="table table-striped table">
					<thead>
						<tr> <th>S No</th>
							<th>User Name 
								<i class="fas fa-sort-down datatable-down-ar"></i>
								<i class="fas fa-sort-up datatable-up-ar"></i>
							</th>
							<th>User Role
								<i class="fas fa-sort-down datatable-down-ar"></i>
								<i class="fas fa-sort-up datatable-up-ar"></i>
							</th>
							<th>User ID
								
							</th>
							<th>Status

							</th>
							<th>Action
								
							</th>
						</tr>
					</thead>
					<tbody>
						
						
						
						<?php $i =1; ?>
						<?php if($products != 'No_Users_Found') { ?>
							@foreach ($products as $details)
							<tr>
								<td>{{ $i }}</td>
								<td>{{ $details->name}}</td>
								
								<td>{{ $details->role_name }}</td>
								<td>{{ $details->userid }}</td>
								
								<td><?php if(isset($details->activestatus) && ($details->activestatus == 1)) { ?> Active <?php
								} else { ?> Locked <?php } ?> </td>
								<td>
									
									<a href="{{route('userupdate')}}?id={{$details->id}}" ><i class="fas fa-edit"></i></a>
									
									
									<a href="{{route('userupdate')}}?id={{$details->id}}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" ><i class="la la-edit"></i></a>
									<a href="javascript:void(0)" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill">
										<i class="far fa-trash-alt DeleteRole" data-id="{{$details->id}}"></i>
									</a>
									
									
									<form id="userlistform{{$details->id}}" action="{{route('userdelete')}}" method="POST" style="display: none;">
										
										<input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
										<input type="hidden" value="{{$details->id}}" name="id"/>
									</form>
								</td>
							</tr>    
							<?php $i++; ?>
							@endforeach
						<?php } ?>
						
					</tbody>
				</table>
				@if($i == 1) 
				Sorry. No users has been found.
				@endif	
			</div>
		</div>
	</div>						
</div>
</div>

<!-- end:: Body -->

@endsection

<!-- end:: Footer -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>




//Detelt details



$(document).ready(function(e) {

	$(".DeleteUser").click(function(e){
		var id = $(this).data('id');
		
		var view = confirm("Are you sure you want to Delete now?");
		
		if (view === false) {
			return false;
		}
		
		else if(view === true){
			
			$('#userlistform'+id).submit();
			
			
		}
		

	});
	
	
	$(document).on('click', '.agent', function(){
		
		var agency = $("#agency").val();
		$.ajax
		({
			type: "GET",
			url: "agencyuserlistAjax",
			data: {'agency': agency},
			success: function(data)
			{
				data= JSON.parse(data);
				var result = append_data(data);
				$("#moreresults").append(result);
			}
		});
		
		
		
		$("#agency").click(function(){
  // action goes here!!
  
		//agency = 1;
		//alert(agency);
		$("#table").show();
	} else {
				//agency = 0;
		//alert(agency);
		$("#table").hide();
		
	});
	});

	
});

</script>