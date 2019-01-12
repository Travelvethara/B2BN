var BootstrapDatepicker={
init:function(){

$("#m_datepicker_2, #m_datepicker_2_validate").datepicker({dateFormat: 'YY-mm-dd',todayHighlight:!0,autoclose: true,startDate: '0',orientation:"bottom left",templates:{leftArrow:'<i class="la la-angle-left"></i>',rightArrow:'<i class="la la-angle-right"></i>'}})}};










jQuery(document).ready(function(){
	
	
	
	
var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
	
	
var checkin = $("#m_datepicker_1, #m_datepicker_1_validate").datepicker({autoclose: true}).on("changeDate", function(e) {
    var checkInDate = e.date, $checkOut = $("#m_datepicker_2");    
    checkInDate.setDate(checkInDate.getDate() + 1);
    $checkOut.datepicker("setStartDate", checkInDate);
    $checkOut.datepicker("setDate", checkInDate).focus();
  });



var nowTemps = $('#m_datepicker_1').val();

$("#m_datepicker_2").datepicker({
	dateFormat: 'YY-mm-dd',
	todayBtn: true,
    autoclose: true,
	beforeShowDay: function(date) {
 
	
  }
	})
	
	});