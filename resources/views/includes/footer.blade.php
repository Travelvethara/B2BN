<footer class="m-grid__item		m-footer ">
				<div class="m-container m-container--fluid m-container--full-height m-page__container">
					<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
						<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
							<span class="m-footer__copyright">
								2017 &copy; Metronic theme by
								<a href="https://keenthemes.com" class="m-link">
									Keenthemes
								</a>
							</span>
						</div>
					</div>
				</div>
			</footer>
				<!-- end::Footer -->
		</div>
		<!-- end:: Page -->
    	 <!-- begin::Quick Sidebar -->
		
		<!-- end::Quick Sidebar -->		    
	    <!-- begin::Scroll Top -->
		<div id="m_scroll_top" class="m-scroll-top">
			<i class="la la-arrow-up"></i>
		</div>
        
        <div class="modal modalviewmore fade show modelshow updatepopup"  id="m_modal_6 popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="padding-right: 17px; display: none; z-index: 99999999999999;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content loadingcontent">
    <!--  <div class="modal-header">
     <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>-->
            
      
       <div class="modal-body">
          <div class="poilcydetail"><h5 style="">Loading...</h5></div>
      </div>
      
      

       
    </div>
  </div>
</div>
        
		<!-- end::Scroll Top -->		    
		<!-- begin::Quick Nav -->
		
		<!-- begin::Quick Nav -->	
    	<!--begin::Base Scripts -->
		
        
		<script src="{{asset('/js/vendors.bundle.js')}}" type="text/javascript"></script>
		<script src="{{asset('/js/scripts.bundle.js')}}" type="text/javascript"></script>
        <script src="{{asset('/js/ion-range-slider.js')}}" type="text/javascript"></script>
        
     <!--   <script src="{{asset('js/jssor.slider.min.js')}}"></script>-->
        
        
        <script src="{{asset('js/dashboard.js')}}"></script>

        <script src="{{asset('js/slder.js')}}"></script>
        
         <script src="{{asset('/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>


		@if(Route::currentRouteName()=='apiprofiledata'  || Route::currentRouteName()=='agentbookingwise' || Route::currentRouteName()=='agentbooking' || Route::currentRouteName()=='admininvoicebooking' || Route::currentRouteName()=='agentinvoicebooking' || Route::currentRouteName()=='agencyddetailbookingreport')
		
		<script src="{{asset('/js/html-table-agent.js')}}" type="text/javascript"></script>
        @else
        <script src="{{asset('/js/html-table.js')}}" type="text/javascript"></script>
        @endif
        
        
        
<script src="https://www.jqueryscript.net/demo/Export-Html-Table-To-Excel-Spreadsheet-using-jQuery-table2excel/src/jquery.table2excel.js"></script>
		<script>
	var whologin = "{{ URL::to('/whologin')}}";	
		//Autocomplete Detapicker start
$( function() {
    var dateFormat = "YY-mm-dd",
      from = $( "#checkins" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1,
		  onClose: function(selectedDate, test) {
			  $('#checkouts').focus();
		  },
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#checkouts" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
		</script>
	
       
        
		
		<!--end::Page Snippets -->
         
	</body>
	<!-- end::Body -->
	<!-- end::Body -->
	
	<script>
		$(document).ready(function(){

			
			var updateajx = "{{ URL::to('/updateajx')}}";
		
			
			$(document).on('click', '.updateinfo', function(){
				
				$('.loadingcontent').html('');
				$('.loadingcontent').html('<div class="poilcydetail"><h5 style="">Loading...</h5></div>');
				$('.updatepopup').show();
				$('.m-dropdown__wrappernotofialter').hide();
				
				var id = $(this).data('id');
				var role = $(this).data('role');
				var updateajxajaxurl = 'id='+id+'&role='+role; 
		
		     $.ajax({
			type: "GET",
			url: updateajx,
			data: updateajxajaxurl,
			cache: false,
			success: function(data){
				
				$('.loadingcontent').html('<div class="modal-body"><h5> Update Informations</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="closeurlinfo">×</span></button></div><div class="modalviewmorebody">'+data+'</div>');
				
				
				
				}
		});
				
				
			});
			
			
			$(document).on('click', '.closeurlinfo', function(){
				
				$('.updatepopup').hide();
				$('.m-dropdown__wrappernotofialter').show();
				$( "#foo" ).trigger( "click" );
				
			});
			
			
			
			
			
			
			$(document).on('click', '.logoutc', function(){
	 
    $.ajax({
        type: "POST",
        url: whologin,
        data: $('#logoutformnew').serialize(),
        success: function(msg) {
			
			if(msg == 1){
				var logout_url = $("#logout_url").val();
			 $.ajax({
        type: "POST",
        url: logout_url,
        data: $('#logout-form').serialize(),
        success: function(msg) {
			
			
			window.location.href= $('#home_url').val();
		
       
        }
    });
			
			
			}
       
        }
    });
			
			});
			
			
			$(document).on('click', '.burgerbarclass', function(){
				
				
				
				if($(this).hasClass('burgerbarclassmax')){
					$('.m-wrapper').removeClass('resmarcls');
					$(this).removeClass('burgerbarclassmax');
					$('.m-header--fixed').removeClass('m-aside-left--minimize');
					$('.welcome').removeClass('welcome_click');
					$('.middletool').removeClass('texxtcne');
					
					$('.menuname').show();
					
					$('.signouticon').hide();
					$('.logoutc').show();
					$('.username-content').show();
					$('.m-brand__logo').show();
					$('#imagename').show();
				}else{
					$(this).addClass('burgerbarclassmax');
					$('.m-wrapper').addClass('resmarcls');
					$('.m-header--fixed').addClass('m-aside-left--minimize');
					$('.welcome').addClass('welcome_click');
					
					$('.middletool').addClass('texxtcne');
					$('.menuname').hide();
					$('.m-brand__logo').hide();
					
					$('#imagename').hide();
					$('.signouticon').show();
					$('.logoutc').hide();
					$('.username-content').hide();
					
				}
				
				
			});
			
		$(document).on('click', '.choosemenu', function(){
		
		     //alert('hi');
			 
			 var url = $(this).data('href');
		  window.location.href=url;
		
		
		});
			
		<?php /*?>var winheight = $(window).innerHeight();
		var abovelist = $(".list-lists").offset().top;
		
		var fin_height = winheight - abovelist;
		
      	
        $(".list-lists, .list-filters, .Hotel-detail-lists").css("height",fin_height);
		 
		
		if ( $('.m-content').hasClass('list-page')) {
			
			$(".m-wrapper").css("margin-bottom",0);
			$(".m-content").css("padding-bottom",0);
			$(".m-content").css("padding-left",15);
			$(".m-content").css("padding-right",15);
		}<?php */?>
		
		  $(".list-filters").slimScroll({
       alwaysVisible: true
          });
		
		
    });
</script>
<script>
		<?php /*?>$(document).ready(function(){
			
			var winheight = $(window).innerHeight();
			var abovedetaillist = $(".Hotel-detail-lists").offset().top;
			var fin_heightdetail = winheight - abovedetaillist;
			$(".Hotel-detail-lists, .list-filters").css("height",fin_heightdetail);
			 });
			 
			 if ( $('.m-content').hasClass('list-page')) {
			
			$(".m-wrapper").css("margin-bottom",0);
			$(".m-content").css("padding-bottom",0);
			$(".m-content").css("padding-left",15);
			$(".m-content").css("padding-right",15);<?php */?>
		
</script>

<!--<$(document).ready(function(){
	
//var winheight = $(window).innerHeight();
//var abovelist = $(".data-table-block").offset().top;
//var fin_height = winheight - abovelist;

//$(".data-table-block").css("max-height",fin_height);

//if ( $('.m-content').hasClass('agencies_list')) {
			
	//		$(".m-wrapper").css("margin-bottom",0);
	//		$(".m-content").css("padding-bottom",15);
	//		$(".m-content").css("padding-left",15);
	//	$(".m-content").css("padding-right",15);
	//	}

 // });-->
  <script language="javascript">
/*document.onmousedown=disableclick;
status="Right Click Disabled";
function disableclick(event)
{
  if(event.button==2)
   {
     alert(status);
     return false;    
   }
}
document.onkeydown = function(e) {
  if(event.keyCode == 123) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
     return false;
  }
}
*/

</script>


    
<script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>           
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />  
    
 <script>
  $(document).ready(function(){
             $('.slider').bxSlider();
  });
 </script>

	
</html>