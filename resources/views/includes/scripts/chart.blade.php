<!--pie and doughnut chat js-->
<script>
  var baseUrl = "{{ route('task') }}"
  $(document).ready(function() {

    var chartval = "";
    $(".chartcalc").each(function(index) {
      var actval = $(this).hasClass('active');
      if (actval == true) {
        chartval = $(this).attr('data-value');
        return false;
      }
    });

    var url = "{{route('chart_data')}}"
    // var window_url = window.location.href
    // if (window_url == "{{env('APP_URL')}}/manager/teams/department_details/" + window_url.split('/').pop()) {
    //   url += '?department_id=' + window_url.split('/').pop()
    // }
    // if (window_url == "{{env('APP_URL')}}/manager/teams/user_profile/" + window_url.split('/').pop()) {
    //   url += '?user_id=' + window_url.split('/').pop()
    // }
    // if (window_url == "{{env('APP_URL')}}/manager/clients/viewclientdetails/" + window_url.split('/').pop()) {
    //      url+='?client_id='+window_url.split('/').pop()
    // }
    // if (window_url == "{{env('APP_URL')}}/" + window_url.split('/').pop()) {
    //      url+='?chartval='+chartval;
    // }


    var overlay = $(".overlay").css("display", "none");
    var overlay1 = $(".overlay1").css("display", "none");
    var start_year = null;
    var start_period = null;
    if($("#chartyear").length){
      start_year = $("#chartyear").children("option:selected").val()
      start_period = $(".chartcalc.active").attr('data-value')
    }

    chart_loading(start_year, start_period);

    $(".chartcalc").click(function() {
      var url = "{{route('chart_data')}}"
      var window_url = window.location.href
      var chartval = $(this).attr('data-value');
      var selectedyear = $("#chartyear").children("option:selected").val();
      url = url + '?chartval=' + chartval + '&chartyear=' + selectedyear;
      var overlay = $(".overlay").css("display", "none");
      var overlay1 = $(".overlay1").css("display", "none");
      chart_loading(selectedyear, chartval)
    });

    $("#chartyear").change(function() {
      var year = $(this).val();
      var url = "{{route('chart_data')}}"
      var window_url = window.location.href
      $("#myChart1").css("display", "block");
      var overlay = $(".overlay").css("display", "none");
      $("#myChart3").css("display", "block");
      var overlay1 = $(".overlay1").css("display", "none");

      var chartval = "";
      $(".chartcalc").each(function(index) {
        var actval = $(this).hasClass('active');
        if (actval == true) {
          chartval = $(this).attr('data-value');
          return false;
        }
      });
      chart_loading(year, chartval)
    });

    function chart_loading(year, period) {
      var url = "{{route('chart_data')}}?"
      var redirect_url = baseUrl + '?';
      if(year && period){
        redirect_url = redirect_url + "year=" + year + "&period=" + period + "&"
        url = url + "year=" + year + "&period=" + period
      }
      if ($('#chart-department-id').length > 0) {
        var dpt = $('#chart-department-id').attr('data-id');
        var dpt_name = $('#department-name').text()
        url = url + "&department_id=" + dpt
        redirect_url = redirect_url+'department_filter=' + dpt + '&department=' + dpt_name
      }
      if($('#user_profile_id').length){
        var uid = $('#user_profile_id').attr('data-value')
        url = url + "&user_id=" + uid
        redirect_url = redirect_url+'user_id=' + uid
      }
      if($('#client_id').length){
        var cid = $('#client_id').val()
        url = url + "&client_id=" + cid
        redirect_url = redirect_url+'client_id='+cid
      }
      $.ajax({
        "url": url,
        "method": "get",
        "success": function(res) {
          console.log(res)
          if (res["data"]["total_task"] == 0) {
            $("#myChart1").css("display", "none");
            var overlay = $(".overlay").css("display", "block");
          }
          if (res["issues_data"]["total_issues"] == 0) {
            $("#myChart3").css("display", "none");
            var overlay1 = $(".overlay1").css("display", "block");
          }

          $.each(res.data, function(index, value) {
            $('#' + index).text(value)
          })
          if ($('#myChart1')) {
            var ctx1 = document.getElementById('myChart1');
            ctx1.height = 400;
            data = {
              labels: ['Satisfactory Completion', 'Completion with challenge', 'Not Completed'],
              datasets: [{
                borderWidth: 0,
                hoverBorderWidth: -20,
                hoverBorderColor: ['#96ceff', '#424348', '#91ee7c'],
                data: res.chart_data,
                backgroundColor: ['rgb(44, 130, 190)', 'rgb(247, 163, 7)', 'rgb(213, 87, 66)'],
                options: {
                  responsive: true,
                  fontColor: '#fff'
                }
              }],
              // These labels appear in the legend and in the tooltips when hovering different arcs
            }
            var taskChart = new Chart(ctx1, {
              type: 'doughnut',
              data: data,
              radius: "90%",
              innerRadius: "70%",
              options: {
                datalabels: true,
                legend: {
                  position: 'bottom',
                  align: "start",
                  fullwidth: 300,
                  labels: {
                    usePointStyle: true,
                    boxWidth: 6,
                    fontSize: 9
                  },
                },
                responsive: true,
                cutoutPercentage: 60,
                tooltips: {
                  enabled: false
                },
                plugins: {
                  labels: {
                    render: 'value',
                    fontSize: 12,
                    fontColor: ['white', 'white', 'white', 'white', 'white'],
                    position: "bottom"
                  }

                },

                ...this.options,

                onHover: function(evt, elements) {
                  if (elements && elements.length) {
                    segment = elements[0];
                    this.chart.update();
                    selectedIndex = segment["_index"];
                    segment._model.outerRadius += 10;
                  } else {
                    if (segment) {
                      segment._model.outerRadius -= 10;
                    }
                    segment = null;
                  }
                },
                layout: {
                  padding: {
                    top: 10,
                    left: 40,
                    right: 20,
                    center: 10
                  }
                }
              }
            });

            ctx1.onclick = function(evt) {
              var activePoints = taskChart.getElementsAtEvent(evt);
              if (activePoints[0]) {
                var chartData = activePoints[0]['_chart'].config.data;
                var idx = activePoints[0]['_index'];

                var label = chartData.labels[idx];
                var value = chartData.datasets[0].data[idx];
                var type = "{{base64_encode(strtolower('task'))}}"
                var status_code,challenge_status;
                if(label == 'Satisfactory Completion'){
                  status_code = "{{base64_encode(strtolower(1))}}";
                  challenge_status = "{{base64_encode(strtolower(0))}}";
                }
                if(label == 'Not Completed'){
                  status_code = "{{base64_encode(strtolower(0))}}";
                  challenge_status = "{{base64_encode(strtolower(null))}}";
                }
                if(label == 'Completion with challenge'){
                  status_code = "{{base64_encode(strtolower(1))}}";
                  challenge_status = "{{base64_encode(strtolower(1))}}";
                }
                redirect_url = redirect_url + "&type="+type+"&label=" + label + "&challenge_status=" + challenge_status;
                window.location.href = redirect_url;
              }
            };
          }

          if ($('#mychart3')) {
            var ctx2 = document.getElementById('myChart3');
            ctx2.height = 420;
            data = {
              labels: res.chart_issues_data,
              datasets: [{

                borderWidth: 0,
                hoverBorderWidth: -20,
                cutoutPercentage: 0,
                hoverBorderColor: ['#96ceff', '#424348', '#91ee7c', '#44BA88', '#F38714'],
                data: res.issues_data,
                backgroundColor: ['rgb(68, 186, 136)', 'rgb(247, 163, 7)', 'rgb(243, 135, 20)', 'rgb(44, 130, 190)', 'rgb(213, 87, 66)'],
                options: {
                  responsive: false,
                  fontColor: '#fff'
                }
              }]
              // These labels appear in the legend and in the tooltips when hovering different arcs
            }
            //var fontfamilyval='Open Sans', sans-serif;
            var issueChart = new Chart(ctx2, {
              type: 'doughnut',
              data: data,
              radius: "90%",
              innerRadius: "70%",
              options: {
                datalabels: true,
                legend: {
                  position: 'bottom',
                  align: "start",
                  fullwidth: 800,
                  labels: {
                    usePointStyle: true,
                    boxWidth: 6,
                    fontSize: 9
                  },
                },
                responsive: true,
                cutoutPercentage: 60,
                tooltips: {
                  enabled: false
                },
                plugins: {
                  labels: {
                    render: 'value',
                    fontSize: 12,
                    fontColor: ['white', 'white', 'white', 'white', 'white'],
                    position: "bottom",
                  }
                },
                ...this.options,

                onHover: function(evt, elements) {
                  if (elements && elements.length) {
                    segment = elements[0];
                    this.chart.update();
                    selectedIndex = segment["_index"];
                    segment._model.outerRadius += 10;
                  } else {
                    if (segment) {
                      segment._model.outerRadius -= 10;
                    }
                    segment = null;
                  }
                },
                layout: {
                  padding: {
                    top: 10,
                    left: 60,
                    right: 30,
                    bottom: 0
                  }
                }
              }
            });

            ctx2.onclick = function(evt) {
              var activePoints = issueChart.getElementsAtEvent(evt);
              if (activePoints[0]) {
                var chartData = activePoints[0]['_chart'].config.data;
                var idx = activePoints[0]['_index'];

                var label = chartData.labels[idx];
                var value = chartData.datasets[0].data[idx];
                var type = "{{base64_encode(strtolower('issue'))}}"
                redirect_url = redirect_url + "&type="+type+"&label=" + label;
                window.location.href = redirect_url;
              }
            };
          }
          if ($('#myChart')) {
            var ctx = document.getElementById('myChart');
            var max = Math.max(...res.issue_chart.issue_data);
            var limit = Math.ceil(max / 100) * 100;
            var stepValue = limit / 5;
            console.log('max ===>' + max);
            console.log('stepValue ===>' + stepValue);
            console.log('limit ===>' + limit);
            ctx.height = 150;
            var issueBarChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                  hoverBorderWidth: '10px',
                  data: res.issue_chart.issue_data,
                  backgroundColor: [
                    'rgb(25, 144, 234,0.8)',
                    'rgb(25, 144, 234,0.8)',
                    'rgb(25, 144, 234,0.8)',
                    'rgb(25, 144, 234,0.8)',
                    'rgb(25, 144, 234,0.8)',
                    'rgb(25, 144, 234,0.8)',
                    'rgb(25, 144, 234,0.8)',
                    'rgb(25, 144, 234,0.8)',
                    'rgb(25, 144, 234,0.8)',
                    'rgb(25, 144, 234,0.8)',
                    'rgb(25, 144, 234,0.8)',
                    'rgb(25, 144, 234,0.8)'
                  ],
                  borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)'
                  ],
                  borderWidth: 1
                }]
              },
              options: {
                plugins: {
                  labels: {
                    render: () => {}
                  }
                },
                legend: {
                  display: false
                },
                scales: {
                  xAxes: [{
                    gridLines: {
                      display: false
                    }
                  }],
                  yAxes: [{
                    gridLines: {
                      display: true
                    },
                    ticks: {
                      beginAtZero: true,
                      stepSize: stepValue,
                      min: 0,
                      max: limit
                    }
                  }]
                }
              }
            });

            ctx.onclick = function(evt) {
              var activePoints = issueBarChart.getElementsAtEvent(evt);
              if (activePoints[0]) {
                var chartData = activePoints[0]['_chart'].config.data;
                var idx = activePoints[0]['_index'];

                var label = chartData.labels[idx];
                var value = chartData.datasets[0].data[idx];
                var type = "{{base64_encode(strtolower('issue'))}}"
                redirect_url = redirect_url + "&type="+type+"&month=" + label;
                window.location.href = redirect_url;
              }
            };
          }
        }
      });
    }
  });
</script>