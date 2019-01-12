@extends('./layouts.app')

@section('content')

<?php

$route = 'agencylist.agencydetails';

$data ='';

?>

<!-- END: Left Aside -->

	<!-- BEGIN: Subheader -->
	
	<!-- END: Subheader -->
	<div class="m-content agencies_list">
		
		<div class="m-portlet m-portlet--mobile">
			
			<div class="m-portlet__body">
				<!--begin: Search Form -->
				<div class="m-form m-form--label-align-right">
					<div class="row align-items-center">
						<div class="col-xl-8 order-2 order-xl-1">
							<div class="form-group m-form__group row align-items-center">
								
								
								<div class="col-md-4">
									<div class="m-input-icon m-input-icon--left">
										<input type="text" class="form-control m-input" placeholder="Serach by name ,email etc" id="generalSearch">
										<span class="m-input-icon__icon m-input-icon__icon--left">
											<span>
												<i class="la la-search"></i>
											</span>
										</span>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				<!--end: Search Form -->
				<!--begin: Datatable -->
				<table class="m-datatable" id="html_table" width="100%">
					<thead>
						<tr>
							<th title="S no">
								S No
							</th>
							<th title="Agency Name">
								Agency Name
							</th>
							<th title="Type">
								Type
							</th>
							<th title="Login Email ID ">
								Login Email ID 
							</th>
							<th title="City">
								City 
							</th>
							<th title="Country">
								Country
							</th>
							<th title="Current Status">
								Current Status
							</th>
							<th title="Action">
								Action
							</th>
							
							
						</tr>
					</thead>
					<tbody>
						<?php $i =1; ?>
						@if($products)
						@foreach ($products as $details)
						<tr>
							<td>{{ $i }}</td>
							<td>{{ $details->aname}}</td>
							<td><?php if(isset($details->parentagencyid) && ($details->parentagencyid < 1)) { ?>1<?php
							} else { ?> 2 <?php } ?></td>
							<td>{{ $details->email }}</td>
							<td>{{ $details->city }}</td>
							<td>{{ $details->country }}</td>
							<td><?php if(isset($details->activestatus) && ($details->activestatus != 0)) { ?> <span class="m-badge  m-badge--success m-badge--wide">Active</span> <?php
						} else { ?> <span class="m-badge  m-badge--metal m-badge--wide">Locked</span> <?php } ?> </td>

						<td>
							<a href="{{route('agency.viewagency')}}?id={{Crypt::encrypt(base64_encode($details->id))}}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" ><i class="fas fa-eye" data-id="1"></i></a>
							<a href="{{route('agency')}}?id={{Crypt::encrypt(base64_encode($details->id))}}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" ><i class="la la-edit"></i></a>
							<a href="javascript:void(0)" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill">
								<i class="far fa-trash-alt DeleteRole" data-id="{{$details->id}}"></i>
							</a>
						</td>
					</tr>    
					<?php $i++; ?>
					@endforeach
					@endif
					
					
					
				</tbody>
			</table>
			<!--end: Datatable -->
		</div>
	</div>      
	
	
</div>
<input type="hidden" id="autoincrementid" value="<?php echo $i; ?>"/>
<input type="hidden" id="offset" value="10" />

</div>




<form id="rolelistform" action="{{route('agency.agencyDelete')}}" method="POST" style="display: none;">
	<input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
	<div class="deleteagency">
		
	</div>
</form>


<!-- end:: Body -->
<!-- begin::Footer -->



<?php if(isset($_GET['datas'])) {?>
	<div class="modal fade show modelshow" id="m_modal_6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: block; padding-right: 17px;">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
    <!--  <div class="modal-header">
     <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
    </div>-->
    <div class="modal-body">
    	The data was added successfully.
    </div>
    <div class="modal-close-btn">
    	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    		<span aria-hidden="true" class="closeurl">×</span>
    	</button>
    </div>
    <div class="modal-footer">
    	<!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
    	<button type="button" class="btn btn-primary closeurl">Ok</button>
    </div>
</div>
</div>
</div>
<?php } ?>



<?php if(isset($_GET['datas1'])) {?>
	<div class="modal fade show modelshow" id="m_modal_6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: block; padding-right: 17px;">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
    <!--  <div class="modal-header">
     <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
    </div>-->
    <div class="modal-body">
    	The data was deleted successfully.
    </div>
    <div class="modal-close-btn">
    	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    		<span aria-hidden="true" class="closeurl">×</span>
    	</button>
    </div>
    <div class="modal-footer">
    	<!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
    	<button type="button" class="btn btn-primary closeurl">Ok</button>
    </div>
</div>
</div>
</div>
<?php } ?>  
<?php if(isset($_GET['id']) && !empty($_GET['id'])){?>           
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/agencyList?id=".$_GET['id']);?>"/>
<?php }else{ ?>
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/agencyList");?>"/>
<?php } ?>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

	$(document).ready(function () {
		$(document).on('click', '.closeurl', function(){

			$('.modelshow').hide();

			var url = $('#homeurl').val();
			window.history.pushState('', '', url);

		});

		$(document).on('click', '.DeleteRole', function(){
			
			var id = $(this).data('id');
			
			var r = confirm("Are you sure you want to Delete now?");
       //cancel clicked : stop button default action 
       if (r === false) {
       	return false;
       }
       
       else if(r === true){
       	
       	var storehidden = '<input type="hidden" value="'+id+'" name="id"/>';
       	$('.deleteagency').append(storehidden);
       	
       	$('#rolelistform').submit();
       	
       	
       }
        //action continues, saves in database, no need for more code


    });
		

		
		



		function checkParentCheckboxValue() {
			var parentagency ='';
			
			if($("#parentagency").is(':checked')){
				parentagency = 1;
			} else {
				parentagency = 0;
			}
			return parentagency;	
		}
		
		function checkSubCheckboxValue() {
			var subagency ='';
			if($("#subagency").is(':checked')){
				subagency = 1;
			} else {
				subagency = 0;
			}	
			return subagency;	
		}
		
		function append_data(d) {}
		
		function AjaxCall(offset, parentagency, subagency){

			$.ajax
			({
				type: "GET",
				url: "agencylistLoadMoreAjax",
				data: {'offset': offset, 'parentagency': parentagency, 'subagency':subagency },
				success: function(data)
				{
					data= JSON.parse(data);
					var result = append_data(data);
					$("#moreresults").append(result);
				}
			});
		}
		
		$(document).on('click', '#parentagency', function(){
			$("#autoincrementid").val('1');
			var offset = 0;
			$('#offset').val('10'); 
			parentagency = checkParentCheckboxValue();
			subagency = checkSubCheckboxValue();
			$("#tablebody").html('');
			AjaxCall(offset, parentagency, subagency);
		});


		$(document).on('click', '#subagency', function(){
			$("#autoincrementid").val('1');
			var offset = 0;
			$('#offset').val('10'); 
			parentagency = checkParentCheckboxValue();
			subagency = checkSubCheckboxValue();
			$("#tablebody").html('')
			AjaxCall(offset, parentagency, subagency);
		});


		$(document).on('click', '#loadMore', function(){
			
			var offset = '';
			offset = $("#offset").val();
			
			var newoffset = '';
			newoffset = parseInt(offset) + parseInt(10);

			$('#offset').val(newoffset); 

			var parentagency = subagency = '';

			parentagency = checkParentCheckboxValue();
			subagency = checkSubCheckboxValue();
			AjaxCall(offset, parentagency, subagency);
			
		});
		
	});

	$(document).on('click', '.fa-eye', function(){

	});
</script>

