@extends('layouts.app')

@section('content')
<?php 
$route = 'role.roleinsert';
if (isset($rolelist) && !empty($rolelist)){ $route = 'role.roleupdate'; }


?>

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
														<input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
														<span class="m-input-icon__icon m-input-icon__icon--left">
															<span>
															<i class="fas fa-search"></i>
															</span>
														</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xl-4 order-1 order-xl-2 m--align-right">
											
											<div class="m-separator m-separator--dashed d-xl-none"></div>
										</div>
									</div>
								</div>
								<!--end: Search Form -->
		<!--begin: Datatable -->
								<table class="m-datatable" id="html_table" width="100%">
									<thead>
										<tr>
											<th title="Field #1">
												Role Name
											</th>
											<th title="Field #2">
												User
											</th>
											<th title="Field #3">
												Action
											</th>
											
										</tr>
									</thead>
									<tbody>
										<?php if(isset($rolelist) && !empty($rolelist)){
                                            foreach($rolelist as $rolelist_val){
										?>
										  <tr>
											<td>{{$rolelist_val->role_name}}</td>
											<td><?php if(isset($rolelistcount[$rolelist_val->id])){ echo count($rolelistcount[$rolelist_val->id]); } else{ echo '0';}?></td>
											<td>
										
										
											
                                            <a href="{{route('role')}}?id={{Crypt::encrypt(base64_encode($rolelist_val->id))}}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" target="_blank"><i class="la la-edit"></i></a>
                                            
                                            
                                            <a href="javascript:void(0)" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill">
									<i class="far fa-trash-alt DeleteRole" data-id="{{$rolelist_val->id}}"></i>
                                    </a>
											
                                            <form id="rolelistform{{$rolelist_val->id}}" action="{{route('role.RoleDelete')}}" method="POST" style="display: none;">
                                                                              <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
                                               <input type="hidden" value="{{$rolelist_val->id}}" name="id"/>
                                             </form>
											</td>
										  </tr>
										
											<?php } } ?>
										
										
									</tbody>
								</table>
								<!--end: Datatable -->
							</div>
						</div>
                        
                   </div>						
				</div>
                
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
                                <input type="hidden" id="homeurl" value="<?php echo URL::to("/rolelist?id=".$_GET['id']);?>"/>
                                 <?php }else{ ?>
                                <input type="hidden" id="homeurl" value="<?php echo URL::to("/rolelist");?>"/>
								<?php } ?>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(e) {
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
			
			$('#rolelistform'+id).submit();
		
		
		}
        //action continues, saves in database, no need for more code


   });

	
});
</script>