@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:;">Dashboard</a>
                </li>
            </ol>
        </div>
        <div class="topbar-right">

        </div>
    </header>
@stop

@section('content')
    <section id="content" class="animated fadeIn">
        @include('errors._list')

        <div class="row p10">
            <div class="panel-heading">
                <span class="panel-title fs16"> Statistics</span>
            </div>
            <div class="panel-body bg-light dark pb30">
                <div class="col-md-6 pt20">
                    <p class="pie-title">Credentialing Process Status (total: {{ $generalStats['total'] }})</p>
                    <div id="credential-status-totals" class="pie"></div>
                </div>
                <div class="col-md-6 pt20">
                    <p class="pie-title">Approved Credential Status (total: {{ $approvedStats['total'] }})</p>
                    <div id="credential-approved-totals" class="pie"></div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('js-files')
    {!! Html::script($siteUrl . '/js/googlechart.loader.min.js') !!}

    <script>
        $(function(){
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawCharts);
        });

        function drawCharts()
        {
            // totals per status chart:
            var rows = [
                @foreach ($generalStats['rows'] as $item)
                    ["{{ $item->name }}", {{ $item->count }}],
                @endforeach
            ];
            drawChart(rows, 'credential-status-totals');

            // approved status chart:
            var rows = [
                ['Active',  {{ $approvedStats['active'] }}],
                ['Expired', {{ $approvedStats['expired'] }}],
            ];
            drawChart(rows, 'credential-approved-totals');
        }

        function drawChart(rows, id)
        {
            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Item');
            data.addColumn('number', 'value');
            data.addRows(rows);

            // Set chart options
            var options = {

                titleTextStyle: {
                    fontSize: 15,
                    bold    : false
                },
                pieHole: 0.4,
                width : '100%',
                chartArea: {
                    left  :10,
                    top   :10,
                    width :'75%',
                    height:'100%'
                },
                fontSize: 13,
                backgroundColor: 'transparent',
                legend: {
                    position: 'right',
                    textStyle: {
                        color: '#565656'
                    }

                },
                pieSliceText: 'value'
            };

            var chart = new google.visualization.PieChart(document.getElementById(id));
            chart.draw(data, options);
        }
    </script>
@stop
