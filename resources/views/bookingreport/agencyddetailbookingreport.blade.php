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
						<div class="col-xl-12 order-2 order-xl-1">
							<div class="form-group m-form__group row align-items-center">
								
								
								<div class="col-md-3">
									<div class="m-input-icon m-input-icon--left">
										<input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch" value="">
										<span class="m-input-icon__icon m-input-icon__icon--left">
											<span>
												<i class="la la-search"></i>
											</span>
										</span>
									</div>
								</div>
                                <div class="col-md-2">
										<!--<input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch" value="">-->
                                        
                                        <button class="btn btn-success form-control m-input" id="btnExport">Export</button>
										<!--<span class="m-input-icon__icon m-input-icon__icon--left">
											<span>
												<i class="la la-search"></i>
											</span>
										</span>-->
								
								</div>
							</div>
						</div>
						
					</div>
				</div>
                
                
                
                <table class="m-datatables m-datatable_s_no" id="html_table" width="100%">
					<thead>
						<tr>
							<th title="S no">
								S No
							</th>
                           
                            
                            
                            <th title="Booking Ref #">
								Agency ID
							</th>
                            
							<th title="Name">
							    Agency Name
							</th>
							<th title="Email">
								Agency Manger 
							</th>
							
							<th title="Leader Name">
								Email
							</th>
                            <th title="Agency Name">
								Credit Limit
							</th>
                            <th title="Agency Id">
							    Remaining Limit
							</th>
                           
							
							
						</tr>
					</thead>
					<tbody>
         
         
                    <? $sno = 1; if($agency) { foreach($agency as $agencyarrayList) {  
					
					if(!empty($agencyarrayList->aname) && !empty($agencyarrayList->name) && !empty($agencyarrayList->current_credit_limit)){ 
				
					
					 ?>
         
						<tr>
                           <td>{{$sno}}</td>
                  
                             <td>AGN1001{{$agencyarrayList->id}}</td>
                             <td>{{$agencyarrayList->aname}}</td>
						 <td><a href="{{route('admininvoicebooking')}}?id=<?php echo base64_encode($agencyarrayList->id); ?>"> <button class="btn btn-link"  id="">{{$agencyarrayList->name}} </button></a></td>
                            <td>{{$agencyarrayList->email}}</td>
                      <td>
                      {{$agencyarrayList->creditLimit}}
                     </td>
                            
							
			             <td>
                      
                        {{$agencyarrayList->current_credit_limit}}
                      
						</td>
                    
						
                        </tr>  
                        	<?php  ++$sno; } } } ?>	
								
							</tbody>
						</table>
                
                
                
                
                
                
                
                
                
						
					</div>
				</div>
				<!--end: Search Form -->
				<!--begin: Datatable -->
				
						<!--end: Datatable -->
					</div>
				</div>      
				
				
			</div>

			
		</div>
		
		
@endsection

<style>
    #exportButton {
        border-radius: 0;
    }
</style>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
   
    var paymentinserturl = "{{ URL::to('invoicepayment')}}";
	
	
	var paybookingurl = "{{ URL::to('paybookingurl')}}";

    var Bookmailsenturl = "{{ URL::to('invoicepaymentemail')}}";
	
	var voucherpaymentemail = "{{ URL::to('voucherpaymentemail')}}";
	
	var voucherpaymentinserturl = "{{ URL::to('voucherpayment')}}";
	
	
	var ajaxbookingcheckurl = "{{ URL::to('ajaxbookingcheck')}}";
	
	
	var vouchertemplate = "{{ URL::to('vouchertemplate')}}";
	
	

	$(document).ready(function () {
	
	
	//close
	
	
	$(document).on('click', '.closeurl', function(){

$('.modelshow').hide();

var url = $('#homeurl').val();
window.history.pushState('', '', url);

});
	
	
	//ajax check
	
	
	
	$(document).on('click', '.bookingpay', function(){
		
		
		
		 var bookingid = $(this).data('bookingid');
         $.ajax({
         type:"POST",
         url:paybookingurl,
         data:$('#paymentsummit'+bookingid).serialize(),
         success: function(data){
			 
			 
			 
			 var obj = $.parseJSON( data);
	
			 
			 if(obj.bookingConfirm == '1'){
				 
				 
				 window.location.href = obj.URL;
				 
			 }
			 
			 
			 
			 },
         error: function(data){





                               }
                  });
		
		
		
	});
	
	
	$(document).on('click', '.bchecked', function(){
		$('.booingdetail').html('');
	var bookingid = $(this).data('id');
	var thehref = 'bookingid='+bookingid;
	$('.optionidshow').show();
	 $.ajax({
         type:"GET",
         url:ajaxbookingcheckurl,
         data:thehref,
         success: function(data){
			 
			 $('.booingdetail').html(data);
			 },
         error: function(data){

                               }
                  });
	
	});
		
		
		 $(document).on('click', '.exportButton', function(){
			
		 var bookingid = $(this).data('bookingid');
         $.ajax({
         type:"POST",
         url:paymentinserturl,
         data:$('#paymentsummit'+bookingid).serialize(),
         success: function(data){
         var link = document.createElement('a');
         link.href = data.value;
         link.download=data.name+".pdf";
         link.click();
         },
         error: function(data){




                               }
                  });
		
         });
		
		

		
		
		
	    $(document).on('click', '.mailsendButton', function(){
		var bookingid = $(this).data('bookingid');
        $.ajax({
        type:"POST",
        url:Bookmailsenturl,
        data:$('#paymentsummit'+bookingid).serialize(),
        success: function(data){
	    $('.mailmsgpopup').show();
      
           },
        error: function(data){

                       }
       
                });
		});
		
		
		
		//voucher

		
		$(document).on('click', '.mailsendButtonvocher', function(){
		var bookingid = $(this).data('bookingid');
        $.ajax({
        type:"POST",
        url:voucherpaymentemail,
        data:$('#paymentsummit'+bookingid).serialize(),
        success: function(data){
	    $('.mailmsgpopup').show();
      
           },
        error: function(data){

                       }
       
                });
		});
		
		
		
		
		$(document).on('click', '.exportButtonvocherpop', function(){
			
		 var bookingid = $(this).data('bookingid');
            $('.optionidshownew'+bookingid).show();
			
		 var bookingid = $(this).data('bookingid');
            $('.optionidshownew'+bookingid).show();
			
			///$('.optionid'+bookingid).hide();
			
			 $.ajax({
              type:"POST",
              url:vouchertemplate,
              data:$('#paymentsummit'+bookingid).serialize(),
              success: function(data){
				  $('.Mailtemplate').html(data);
				  },
              error: function(data){
				  

                       }
       
                });
		
         	
			
		
         });
		 
		 
		 
		 $(document).on('click', '.closevocher', function(){
			
		 var bookingid = $(this).data('bookingid');
            $('.optionidshownew'+bookingid).hide();
		
         });
		 
		 
		
		
		
		
		
		    $(document).on('click', '.closeurl', function(){

            $('.modelshow').hide();

           // var url = $('#homeurl').val();
           // window.history.pushState('', '', url);
           });
		   
           $(document).on('click', '#popup', function(){

           var id = $(this).data('id');
           $('.optionid'+id).show();
            });
			
			
		 $(document).on('click', '#popupcancel', function(){

           var id = $(this).data('id');
           $('.optioniddata'+id).show();
            });
			
			
			
			
			//$(document).on('click', '#popupcancel', function(){
//						if(confirm('Are you sure want to Cancelled Booking?')) {
//							console.log('Delete');
//							
//							
//							} else {
//								return false;
//								}
//						});	

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

<script>

	$(function() {
    $("#btnExport").click(function(){
    $(".m-datatable").table2excel({
    exclude: ".noExl",
    name: "Excel Document Name"
    }); 
	});
	});
</script>