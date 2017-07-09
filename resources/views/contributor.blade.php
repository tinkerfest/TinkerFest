<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    @include('includes.head')
</head>
    <body class="@if(Auth::check()) fixed-sn @else hidden-sn @endif white-skin">
        
    <header>
        @include('includes.sidebar')
        @include('includes.navbar')
    </header>

    <main>
        <div class="container-fluid">
            <div class="row">
            @for ($i = (count($contributors))-1; $i >= 0; $i--)
                <div class="contributor-card col-sm-6 githubCard row">
                    <div class="col-sm-5 githubProfile">
                        <div class="githubProfileCard card testimonial-card">
                            <div class="github avatar">
                                <a href="{{ $contributors[$i]['author']['html_url'] }}" target="_blank">
                                    <img src="{{ $contributors[$i]['author']['avatar_url'] }}" class="rounded-circle img-responsive">
                                </a>
                            </div>
                            <div class="card-block">
                                <h5 class="card-title">
                                    <a href="{{ $contributors[$i]['author']['html_url'] }}" target="_blank">
                                        {{ $contributors[$i]['author']['login'] }}
                                    </a>
                                </h5>
                                <hr>
                                <p class="text-center" style="margin-bottom: 0px;">{{ $contributors[$i]['total'] }} Commits</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7 githubGraph">
                        <div class="githubProfileCard card testimonial-card">
                            
                            @if ($i == 3)
                                <div id="chart_div-3" class="githubGoogleChart"></div>
                            @elseif ($i == 2)
                                <div id="chart_div-2" class="githubGoogleChart"></div>
                            @elseif ($i == 1)
                                <div id="chart_div-1" class="githubGoogleChart"></div>
                            @elseif ($i == 0)
                                <div id="chart_div-0" class="githubGoogleChart"></div>
                            @endif
        
                        </div>
                   </div>
                </div>
            @endfor
            </div>
        </div>
    </main>


    @if( Auth::check() )
    <div class="fx-action-btn">
        <a href="{{ route('createLog') }}" data-toggle="tooltip" data-placement="left" title="Add new log" class="btn-floating btn-large red">
            <i class="fa fa-pencil"></i>
        </a>
    </div> 
    @endif 
    @include('includes.footerscripts')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = []; 
        for (var i = 3; i >= 0; i--) {

                var options = {
                  title: 'Contribution',
                  // hAxis: {title: 'Weeks'},
                  vAxis: {minValue: 0}
                };
                if (i == 3) {
                    data[i] = google.visualization.arrayToDataTable([
                        ['Week', 'Commits'],
                        ['Week-1',  parseInt({{$commit[3][0]}})],
                        ['Week-2',  parseInt({{$commit[3][1]}})],
                        ['Week-3',  parseInt({{$commit[3][2]}})]
                    ]);
                    var chart = new google.visualization.AreaChart(document.getElementById('chart_div-3'));
                    chart.draw(data[i], options);
                }
                else if (i == 2) {
                    data[i] = google.visualization.arrayToDataTable([
                        ['Week', 'Commits'],
                        ['Week-1',  parseInt({{$commit[2][0]}})],
                        ['Week-2',  parseInt({{$commit[2][1]}})],
                        ['Week-3',  parseInt({{$commit[2][2]}})]
                    ]);
                    var chart = new google.visualization.AreaChart(document.getElementById('chart_div-2'));
                    chart.draw(data[i], options);
                }
                else if (i == 1) {
                    data[i] = google.visualization.arrayToDataTable([
                        ['Week', 'Commits'],
                        ['Week-1',  parseInt({{$commit[1][0]}})],
                        ['Week-2',  parseInt({{$commit[1][1]}})],
                        ['Week-3',  parseInt({{$commit[1][2]}})]
                    ]);
                    var chart = new google.visualization.AreaChart(document.getElementById('chart_div-1'));
                    chart.draw(data[i], options);
                }
                else if (i == 0) {
                    data[i] = google.visualization.arrayToDataTable([
                        ['Week', 'Commits'],
                        ['Week-1',  parseInt({{$commit[0][0]}})],
                        ['Week-2',  parseInt({{$commit[0][1]}})],
                        ['Week-3',  parseInt({{$commit[0][2]}})]
                    ]);
                    var chart = new google.visualization.AreaChart(document.getElementById('chart_div-0'));
                    chart.draw(data[i], options);
                }

        }
    }
    </script>
</body>

</html>