var IONRangeSlider={init:function(){$("#m_slider_3").ionRangeSlider({type:"double",grid:!0,min:0,max:10000,from:0,to:10000,prefix:"$",onFinish: function ( data ) { var min = data.from; var max = data.to; console.log(min); $('#pricerangemin').val(min); $('#pricerangemax').val(max);$('.loader-fixed').show(); setTimeout(function(){  ajaxjsonhoteljquery_values(); }, 3000);}})}};jQuery(document).ready(function(){IONRangeSlider.init()});