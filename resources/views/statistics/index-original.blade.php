<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')

    @if($index_statistic)
        <div id='box-statistic' class='row'>
            @foreach($index_statistic as $stat)
                <div  class="{{ ($stat['width'])?:'col-sm-3' }}">
                    <div class="small-box bg-{{ $stat['color']?:'red' }}">
                        <div class="inner">
                            <h3>{{ $stat['count'] }}</h3>
                            <p>{{ $stat['label'] }}</p>
                        </div>
                        <div class="icon">
                            <i class="{{ $stat['icon'] }}"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if(!is_null($pre_index_html) && !empty($pre_index_html))
        {!! $pre_index_html !!}
    @endif


    @if(g('return_url'))
        <p><a href='{{g("return_url")}}'><i class='fa fa-chevron-circle-{{ trans('crudbooster.left') }}'></i> &nbsp; {{trans('crudbooster.form_back_to_list',['module'=>ucwords(str_replace('_',' ',g('parent_table')))])}}</a></p>
    @endif



<html>

<head>
    <title>Pie Chart</title>
    <script src="{{ asset('assets/chartjs/Chart.bundle.js') }}"></script>
    <script src="{{ asset('assets/chartjs/utils.js') }}"></script>

    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
        .chart-container {
            width: 75%;
            margin-left: 40px;
            margin-right: 40px;
        }
        .container {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
        }
    </style>
</head>

<body>


<div id="aviso-movil-horizontal">
    <div style='text-align: center; color: red; padding-bottom: 20px;'><i class='fa fa-warning'></i>
        {{ trans('crudbooster.movil_message') }}
    </div>
</div>

<div class="container">
    <div class="chart-container">
        <canvas id="chart-legend-normal"></canvas>
    </div>
</div>

<div class="row" style="padding-top: 50px;">
    <div class="col-xs-6">
        <canvas id="chart-legend-pointstyle"></canvas>
    </div>
    <!-- /.col -->
    <div class="col-xs-6">
        <canvas id="chart-legend-pointstyle_2"></canvas>
    </div>
</div>

<div class="row" style="padding-top: 50px;">
    <div class="col-xs-12">
        <div class="container">
            <div class="chart-container">
                <canvas id="chart-legend-normal-bar"></canvas>
            </div>
        </div>
    </div>
</div>





<script>
    var color = Chart.helpers.color;
    function createConfig(colorName) {
        return {
            type: 'line',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                datasets: [{
                    label: "Quotes 2017",
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    data: [
                        {{ $data['quotes_2017'] }}
                    ],
                    fill: false,
                }, {
                    label: "Quotes 2018",
                    fill: false,
                    backgroundColor: window.chartColors.green,
                    borderColor: window.chartColors.green,
                    data: [
                        {{ $data['quotes_2018'] }}
                    ],
                }, {
                    label: "Sales 2017",
                    fill: false,
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: [
                        {{ $data['sales_2017'] }}
                    ],
                }, {
                    label: "Sales 2018",
                    fill: false,
                    backgroundColor: window.chartColors.yellow,
                    borderColor: window.chartColors.yellow,
                    data: [
                        {{ $data['sales_2018'] }}
                    ],
                }]
            },
            options: {
                responsive: true,
                title:{
                    display:true,
                    text:'QUOTES VS SALES BY MONTH'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                }
            }
        };
    }

    function createPointStyleConfig(colorName) {
        var config = createConfig(colorName);
        config.options.legend.labels.usePointStyle = true;
        config.options.title.text = 'Point Style Legend';
        return config;
    }

    function createPieTypeLeadConfig(colorName) {
        var config = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        {{ $data['customer_type_data'] }}
                    ],
                    backgroundColor: [
                        window.chartColors.blue,
                        window.chartColors.yellow,
                        window.chartColors.red,
                        window.chartColors.black,
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    "Normal",
                    "Favorite",
                    "Junks",
                    "Lost"
                ]
            },
            options: {
                responsive: true,
                title:{
                    display:true,
                    text:'TYPE OF LEADS'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
            }
        };
        return config;
    }

    function createPieQuoteTypeConfig(colorName) {
        var config = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        {{ $data['quote_type_data'] }}
                    ],
                    backgroundColor: [
                        window.chartColors.purple,
                        window.chartColors.grey,
                        window.chartColors.green,
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    "Truck",
                    "Trailer",
                    "Cart"
                ]
            },
            options: {
                responsive: true,
                title:{
                    display:true,
                    text:'QUOTES BY TYPES'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
            }
        };
        return config;
    }

    function createBarQuoteSellerConfig(colorName) {
        return {
            type: 'bar',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                datasets: [{
                    label: "Quotes 2017",
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    data: [
                        {{ $data['quotes_2017'] }}
                    ],
                    fill: false,
                }, {
                    label: "Quotes 2018",
                    fill: false,
                    backgroundColor: window.chartColors.green,
                    borderColor: window.chartColors.green,
                    data: [
                        {{ $data['quotes_2018'] }}
                    ],
                }, {
                    label: "Sales 2017",
                    fill: false,
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: [
                        {{ $data['sales_2017'] }}
                    ],
                }, {
                    label: "Sales 2018",
                    fill: false,
                    backgroundColor: window.chartColors.yellow,
                    borderColor: window.chartColors.yellow,
                    data: [
                        {{ $data['sales_2018'] }}
                    ],
                }]
            },
            options: {
                responsive: true,
                title:{
                    display:true,
                    text:'QUOTES VS SALES BY MONTH'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                }
            }
        };
    }

    window.onload = function() {
        [{
            id: 'chart-legend-normal',
            config: createConfig('red')
        }, {
            id: 'chart-legend-pointstyle',
            config: createPieTypeLeadConfig('blue')
        }, {
            id: 'chart-legend-pointstyle_2',
            config: createPieQuoteTypeConfig('blue')
        /*}, {
            id: 'chart-legend-normal-bar',
            config: createBarQuoteSellerConfig('blue')*/

        }].forEach(function(details) {
            var ctx = document.getElementById(details.id).getContext('2d');
            new Chart(ctx, details.config)
        })
    };
</script>

</body>

</html>

@endsection