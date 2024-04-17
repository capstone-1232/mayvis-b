<x-layout>
    <div class="content">
       <div class="container my-5">
          <div class="row">
             <div class="col-md-12 py-4">
                <div class="my-4">
                   <div class="d-flex justify-content-between align-items-center">
                      <h2 class="display-6 py-2 fw-bold">
                         <i class="bi bi-bar-chart me-3"></i>Reports
                      </h2>
                   </div>
                </div>
                <div id="proposalsChart" class="p-3 border"></div>
             </div>
          </div>
       </div>
    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
       google.charts.load('current', {'packages':['bar']});
       google.charts.setOnLoadCallback(drawChart);
       
       function drawChart() {
           var data = google.visualization.arrayToDataTable([
               ['Period', 'Approved Proposals', 'Denied Proposals'],
               @foreach ($proposalsData as $data)
                   ['{{ $data->label }}', {{ $data->total_approved_price }}, {{ $data->total_denied_price }}],
               @endforeach
           ]);
       
           var options = {
               backgroundColor: 'transparent',
               chart: {
               title: 'Proposal Performance',
               subtitle: 'Approved vs. Denied Proposals',
               titleTextStyle: {
                   color: '#333',
                   fontName: 'Arial',
                   fontSize: 20,
                   bold: true,
                   italic: false
               },
               subtitleTextStyle: {
                   color: '#666',
                   fontName: 'Arial',
                   fontSize: 14
               }
           },
               bars: 'vertical',
               vAxis: {
                   format: 'currency',
                   title: 'Total Proposal Price',
                   titleTextStyle: {
                       color: '#333',
                       fontName: 'Arial',
                       fontSize: 16,
                       bold: true
                   },
                   minValue: 0,
                   textStyle: {
                       color: '#333',
                       fontName: 'Arial',
                       fontSize: 12
                   },
                   gridlines: {
                       color: '#ccc',
                       count: -1
                   },
               },
               hAxis: {
                   title: 'Period',
                   titleTextStyle: {
                       color: '#333',
                       fontName: 'Arial',
                       fontSize: 16,
                       bold: true
                   },
                   textStyle: {
                       color: '#333',
                       fontName: 'Arial',
                       fontSize: 12
                   },
                   slantedText: true,
                   slantedTextAngle: 45
               },
               legend: {
                   position: 'top',
                   alignment: 'center',
                   textStyle: {
                       color: '#333',
                       fontName: 'Arial',
                       fontSize: 12
                   }
               },
               colors: ['#4CAF50', '#F44336'],
               height: 500,
               chartArea: {
                   backgroundColor: 'transparent',
               },
           };
       
           var chart = new google.charts.Bar(document.getElementById('proposalsChart'));
           chart.draw(data, google.charts.Bar.convertOptions(options));
       }
       
    </script>
 </x-layout>