var Dashboard = function() {
    var a = function(e, t, a, r) {},
        r = function() {};
    return {
        init: function() {
            var e, t;
            ! function() {}(),
            function() {
				
				var id = $('#Ids').val();
				var role = $('#role').val();
				$.ajax({
							   type: "GET",
							   url: dashboardcharturl,
							   data: {id: id,role: role},
							   success: function(data)
							   {
								   var obj = jQuery.parseJSON( data );
								   console.log(obj);
								   var year2018 = 0;
								   if(obj[1]){
								   var year2018 = obj[1];
								   
								   }
								   
								   var year2019 = 0;
								   if(obj[2]){
								   var year2019 = obj[2];
								   
								   }
								   var year2020 = 0;
								   if(obj[3]){
								   var year2020 = obj[3];
								   
								   }
								 
								var year2021 = 0;
								   if(obj[4]){
								   var year2021 = obj[4];
								   
								   }  
								   
								   var totalprofit =   parseInt(year2018) + parseInt(year2019) + parseInt(year2020)+ parseInt(year2021);
								   $('.counterup').html(totalprofit);
								   
								   $('.totalagent').html(obj['agent']);
								   
								   $('.totalbooking').html(obj['totalpayment']);
								   
								   $('.totaluser').html(obj['userinformation']);
								   $('.agencycounterup').html(obj['CurrentCreditLimit']);
								   
							   

                if (0 != $("#m_chart_trends_stats").length) {
                    var e = document.getElementById("m_chart_trends_stats").getContext("2d"),
                        t = e.createLinearGradient(0, 0, 0, 240);
                    t.addColorStop(0, Chart.helpers.color("#00c5dc").alpha(.7).rgbString()), t.addColorStop(1, Chart.helpers.color("#f2feff").alpha(0).rgbString());
                    var a = {
                        type: "line",
                        data: {
                            labels: ["2018", "2019", "2020", "2021"],
                            datasets: [{
                                label: "Booking Profit ($)",
                                backgroundColor: t,
                                borderColor: "#0dc8de",
                                pointBackgroundColor: Chart.helpers.color("#ffffff").alpha(0).rgbString(),
                                pointBorderColor: Chart.helpers.color("#ffffff").alpha(0).rgbString(),
                                pointHoverBackgroundColor: mApp.getColor("danger"),
                                pointHoverBorderColor: Chart.helpers.color("#000000").alpha(.2).rgbString(),
                                data: [year2018, year2019, year2020, year2021]
                            }]
                        },




                        options: {
                            title: {
                                display: !1
                            },
                            tooltips: {
                                intersect: !1,
                                mode: "nearest",
                                xPadding: 10,
                                yPadding: 10,
                                caretPadding: 10
                            },
                            legend: {
                                display: !1
                            },
                            responsive: !0,
                            maintainAspectRatio: !1,
                            hover: {
                                mode: "index"
                            },
                            scales: {
                                xAxes: [{
                                    display: !1,
                                    gridLines: !1,
                                    scaleLabel: {
                                        display: !0,
                                        labelString: "Month"
                                    }
                                }],
                                yAxes: [{
                                    display: !1,
                                    gridLines: !1,
                                    scaleLabel: {
                                        display: !0,
                                        labelString: "Value"
                                    },
                                    ticks: {
                                        beginAtZero: !0
                                    }
                                }]
                            },
                            elements: {
                                line: {
                                    tension: .19
                                },
                                point: {
                                    radius: 4,
                                    borderWidth: 12
                                }
                            },
                            layout: {
                                padding: {
                                    left: 0,
                                    right: 0,
                                    top: 5,
                                    bottom: 0
                                }
                            }
                        }
                    };
                    new Chart(e, a)
                }
							   
							   }});
							   
							   
							   
							   }(),
            function() {}(),




            $(document).on("click", ".carousel", function() {})
        }
    }
}();
jQuery(document).ready(function() {
    Dashboard.init()
});