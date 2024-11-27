@extends('template.master')


@section('content')
<!-- awal isi halaman -->
<div class="app-title">
  <div>
    <h1><i class="bi bi-speedometer"></i> Dashboard</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
  </ul>
</div>
<div class="row">
  <div class="col-md-6 col-lg-3">
    <div class="widget-small primary coloured-icon">
      <i class="icon bi bi-people fs-1"></i>
      <div class="info">
        <h4>Pasien</h4>
        <p><b>{{$c_patients}}</b></p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <div class="widget-small info coloured-icon">
      <i class="icon bi bi-clipboard2-pulse fs-1"></i>
      <div class="info">
        <h4>Rekam Medis</h4>
        <p><b>{{$c_records}}</b></p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <div class="widget-small warning coloured-icon">
      <i class="icon bi bi-graph-up-arrow fs-1"></i>
      <div class="info">
        <h4>Appointment</h4>
        <p><b>{{$c_appointments}}</b></p>
      </div>
    </div>
  </div>
</div>

<!-- end awal isi halaman -->
@endsection
@section('custom_script')
<script type="text/javascript" src="{{asset('assets/plugins/chartjs/chart.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<script>
  
$(function() {
    var ctx = document.getElementById("dashboard-area-chart");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        datasets: [{
          label: "Penjualan",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: <?=$chart;?>,
          }],
      },
    options: {
        maintainAspectRatio: false,
        layout: {
        padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
        }
        },
        scales: {
        xAxes: [{
            time: {
            unit: 'date'
            },
            gridLines: {
            display: false,
            drawBorder: false
            },
            ticks: {
            maxTicksLimit: 12
            }
        }],
        yAxes: [{
            ticks: {
            maxTicksLimit: 10,
            padding: 10,
            // Include a dollar sign in the ticks
            callback: function(value, index, values) {
                return 'Rp. '+ number_format(value);
            }
            },
            gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
            }
        }],
        },
        legend: {
        display: false
        },
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          intersect: false,
          mode: 'index',
          caretPadding: 10,
          callbacks: {
              label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel + ': Rp. ' + number_format(tooltipItem.yLabel) + '';
              }
          }
        }
    }
    });
})
</script>
@endsection