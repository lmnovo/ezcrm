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
    <script src="{{ asset('vendor/jqvmap/dist/jquery.vmap.js') }}"></script>
    <script src="{{ asset('vendor/jqvmap/dist/maps/jquery.vmap.usa.js') }}"></script>

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

<div class="row">

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title" style="text-align: center;">
                <h4>{{trans("crudbooster.chart_1")}}<small> {{trans("crudbooster.by_months")}}</small></h4>
            </div>
            <div class="x_content">
                <canvas id="chart-legend-normal"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title" style="text-align: center;">
                <h4>{{trans("crudbooster.chart_2")}}<small> {{trans("crudbooster.all_times")}}</small></h4>
            </div>
            <div class="x_content">
                <canvas id="chart-legend-pointstyle_2"></canvas>
            </div>
        </div>
    </div>
</div>

<br>
<br>

<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title" style="text-align: center;">
                <h4>{{trans("crudbooster.chart_3")}}<small> {{trans("crudbooster.all_times")}}</small></h4>
            </div>
            <div class="x_content">
                <canvas id="chart-legend-pointstyle"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title" style="text-align: center;">
                <h4>{{trans("crudbooster.chart_4")}}<small> {{trans("crudbooster.by_months")}} (2018)</small></h4>
            </div>
            <div class="x_content">
                <canvas id="chart-legend-normal-bar"></canvas>
            </div>
        </div>
    </div>
</div>

<br>
<br>

<div class="row">

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title" style="text-align: center;">
                <h4>{{trans("crudbooster.chart_5")}}<small> {{trans("crudbooster.all_times")}}</small></h4>
            </div>
            <div class="x_content">
                <div class="legenda">
                    <!--<img src="<?php echo e(asset('assets/images/grafica.png')); ?>" class="img-responsive"/>-->
                </div>
                <div id="vmap" style="width: auto; height: 400px;"></div>
            </div>
        </div>
    </div>

</div>



<script>

    //grafica de estados
    $.ajax({
        url: '../crm/orders/states/',
        type: 'get',
        dataType: 'json',
        success: function(data) {
            //console.log(data);
            var dataset="";
            var dato=[];
            for(var i=0;i<data.length;i++)
            {
                if(data[i].state==="" || data[i].state===null || isNaN(data[i].state)===false)
                    continue;

                dataset+= data[i].state.toLowerCase()+': "'+ data[i].color+'",';
                dato+="'"+data[i].state.toLowerCase()+"': '\u003clabel/\u003e "+data[i].cant+"\u003c/label\u003e',";
                //dato[data[i].state.toLowerCase()]=data[i].cant;
            }
            dataset='{'+dataset.substring(0, dataset.length-1)+'}';
            dato='{'+dato.substring(0, dato.length-1)+'}';
            //eval('var obj='+dataset);
            eval('var obj1='+dato);

            $('#vmap').vectorMap({
                map: 'usa_en',
                backgroundColor: '#a5bfdd',
                borderColor: '#818181',
                borderOpacity: 0.25,
                borderWidth: 0.25,
                enableZoom: true,
                hoverColor: '#c9dfaf',
                hoverOpacity: null,
                normalizeFunction: 'linear',
                scaleColors: ['#b6d6ff', '#005ace'],
                selectedRegions: null,
                showTooltip: true,
                showLabels: true,
                pins: obj1,
                pinMode: 'content',
                //colors:dataset,
                onRegionClick: function(element, code, region)
                {
                    event.preventDefault();
                },
                onLabelShow:function(event, label, code){
                    if(isNaN(dato[code]))
                        label.html('<div class="map-tooltip"><h5 class="header">'+code.toUpperCase()+': 0 </h5></div>');
                    else
                        label.html('<div class="map-tooltip"><h5 class="header">'+code.toUpperCase()+': '+dato[code]+'</h5></div>');
                }
            });
        }
    });

    $.ajax
    ({
        url: '../crm/orders/sellers/',
        type: 'get',
        dataType: 'json',
        success: function(data)
        {
            //console.log(data);
            if(data.length!==0){
                var dataset=[];
                for(var i=0;i<data.length;i++)
                {
                    dataset.push({
                        label: data[i]['label'],
                        backgroundColor: data[i]['color'],
                        data: data[i]['months']
                    });
                }

                var idA = 'chart-legend-normal-bar';
                var configA = createBarQuoteSellerConfig('blue', dataset);

                var ctx = document.getElementById(idA).getContext('2d');
                var mybarChart = new Chart(ctx, configA);
            }
        },complete: function(){


        }
    });


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
                    borderDash: [5, 5],
                    fill: false,
                    data: [
                        {{ $data['quotes_2017'] }}
                    ],
                }, {
                    label: "Quotes 2018",
                    backgroundColor: window.chartColors.green,
                    borderColor: window.chartColors.green,
                    borderDash: [5, 5],
                    fill: false,
                    data: [
                        {{ $data['quotes_2018'] }}
                    ],
                }, {
                    label: "Sales 2017",
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    fill: false,
                    data: [
                        {{ $data['sales_2017'] }}
                    ],
                }, {
                    label: "Sales 2018",
                    backgroundColor: window.chartColors.yellow,
                    borderColor: window.chartColors.yellow,
                    fill: false,
                    data: [
                        {{ $data['sales_2018'] }}
                    ],
                }]
            },
            options: {
                legend: {
                    display: true,
                    labels: {
                        fontColor: 'rgb(0, 0, 0)'
                    },
                    position: 'top'
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
                    "Junk",
                    "Lost"
                ]
            },
            options: {
                legend: {
                    display: true,
                    labels: {
                        fontColor: 'rgb(0, 0, 0)'
                    },
                    position: 'top'
                }
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
                legend: {
                    display: true,
                    labels: {
                        fontColor: 'rgb(0, 0, 0)'
                    },
                    position: 'top'
                }
            }
        };
        return config;
    }

    function createBarQuoteSellerConfig(colorName, data) {
        return {
            type: 'bar',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                datasets: data
            },
            options: {
                legend: {
                    display: true,
                    labels: {
                        fontColor: 'rgb(0, 0, 0)'
                    },
                    position: 'top'
                }
            }
        };
    }

    window.onload = function() {
        [/*{
            id: 'chart-legend-normal',
            config: createConfig('red')
        }, {
            id: 'chart-legend-pointstyle',
            config: createPieTypeLeadConfig('blue')
        },*/ {
            id: 'chart-legend-pointstyle_2',
            config: createPieQuoteTypeConfig('blue')
        }/*, {
            id: 'chart-legend-normal-bar',
            config: createBarQuoteSellerConfig('blue')

        }*/].forEach(function(details) {
            var ctx = document.getElementById(details.id).getContext('2d');
            new Chart(ctx, details.config)
        })
    };

    var cv1 = document.getElementById('chart-legend-pointstyle');
    var ctx1 = cv1.getContext('2d');
    var chart1 = new Chart(ctx1, createPieTypeLeadConfig('blue'));
    cv1.onclick = function(evt){
        var activePoint1 = chart1.getElementAtEvent(evt);
        var tipo = '';

        if ( activePoint1[0]._index == 0 ) {
            tipo = 'Normal';
        }
        if ( activePoint1[0]._index == 1 ) {
            tipo = 'Favorite';
        }
        if ( activePoint1[0]._index == 2 ) {
            tipo = 'Junk';
        }
        if ( activePoint1[0]._index == 3 ) {
            tipo = 'Lost';
        }

        window.location = 'http://ezcrm.us/crm/account?filter_column%5Baccount.id%5D%5Btype%5D=&filter_column%5Baccount.id%5D%5Bsorting%5D=&filter_column%5Baccount.telephone%5D%5Btype%5D=&filter_column%5Baccount.telephone%5D%5Bsorting%5D=&filter_column%5Bstates.abbreviation%5D%5Btype%5D=&filter_column%5Bstates.abbreviation%5D%5Bvalue%5D=&filter_column%5Baccount.email%5D%5Btype%5D=&filter_column%5Baccount.email%5D%5Bsorting%5D=&filter_column%5Baccount.date_created%5D%5Btype%5D=&filter_column%5Baccount.date_created%5D%5Bsorting%5D=&filter_column%5Bcustomer_type.name%5D%5Btype%5D=%3D&filter_column%5Bcustomer_type.name%5D%5Bvalue%5D='+tipo+'&filter_column%5Bcustomer_type.name%5D%5Bsorting%5D=&filter_column%5Baccount.quotes%5D%5Btype%5D=&filter_column%5Baccount.quotes%5D%5Bsorting%5D=&filter_column%5Baccount.id_usuario%5D%5Btype%5D=&filter_column%5Baccount.id_usuario%5D%5Bsorting%5D=&lasturl=http%3A%2F%2F127.0.0.1%3A8000%2Fcrm%2Faccount%3Fm%3D50';

    };


    var cv = document.getElementById('chart-legend-normal');
    var ctx = cv.getContext('2d');
    var chart = new Chart(ctx, createConfig('red'));
    cv.onclick = function(evt){
        var activePoint = chart.getElementAtEvent(evt);
        //var mes = chart.data.labels[activePoint[0]._index];
        var mes = (activePoint[0]._index) + 1;
        var anno = '';
        var url_link = '';

        if (mes < 10) {
            mes = '0'+mes;
        }

        if ( activePoint[0]._datasetIndex == 0 ) {
            anno = '2017';
            url_link = 'http://ezcrm.us/crm/orders?filter_column%5Buser_trucks.id%5D%5Btype%5D=&filter_column%5Buser_trucks.id%5D%5Bsorting%5D=&filter_column%5Bproducts_type.name%5D%5Btype%5D=&filter_column%5Bproducts_type.name%5D%5Bsorting%5D=&filter_column%5Buser_trucks.id_account%5D%5Btype%5D=&filter_column%5Buser_trucks.id_account%5D%5Bsorting%5D=&filter_column%5Buser_trucks.truck_date_created%5D%5Btype%5D=between&filter_column%5Buser_trucks.truck_date_created%5D%5Bvalue%5D%5B%5D='+anno+'-'+mes+'-01&filter_column%5Buser_trucks.truck_date_created%5D%5Bvalue%5D%5B%5D='+anno+'-'+mes+'-31&filter_column%5Buser_trucks.truck_date_created%5D%5Bsorting%5D=asc&filter_column%5Buser_trucks.truck_budget%5D%5Btype%5D=&filter_column%5Buser_trucks.truck_budget%5D%5Bsorting%5D=&filter_column%5Buser_trucks.id_account%5D%5Btype%5D=&filter_column%5Buser_trucks.id_account%5D%5Bvalue%5D=&filter_column%5Bsources.name%5D%5Btype%5D=&filter_column%5Bsources.name%5D%5Bvalue%5D=&filter_column%5Buser_trucks.truck_aprox_price%5D%5Btype%5D=&filter_column%5Buser_trucks.truck_aprox_price%5D%5Bsorting%5D=&lasturl=http%3A%2F%2F127.0.0.1%3A8000%2Fcrm%2Forders%3Fm%3D45';
        }
        if ( activePoint[0]._datasetIndex == 1 ) {
            anno = '2018';
            url_link = 'http://ezcrm.us/crm/orders?filter_column%5Buser_trucks.id%5D%5Btype%5D=&filter_column%5Buser_trucks.id%5D%5Bsorting%5D=&filter_column%5Bproducts_type.name%5D%5Btype%5D=&filter_column%5Bproducts_type.name%5D%5Bsorting%5D=&filter_column%5Buser_trucks.id_account%5D%5Btype%5D=&filter_column%5Buser_trucks.id_account%5D%5Bsorting%5D=&filter_column%5Buser_trucks.truck_date_created%5D%5Btype%5D=between&filter_column%5Buser_trucks.truck_date_created%5D%5Bvalue%5D%5B%5D='+anno+'-'+mes+'-01&filter_column%5Buser_trucks.truck_date_created%5D%5Bvalue%5D%5B%5D='+anno+'-'+mes+'-31&filter_column%5Buser_trucks.truck_date_created%5D%5Bsorting%5D=asc&filter_column%5Buser_trucks.truck_budget%5D%5Btype%5D=&filter_column%5Buser_trucks.truck_budget%5D%5Bsorting%5D=&filter_column%5Buser_trucks.id_account%5D%5Btype%5D=&filter_column%5Buser_trucks.id_account%5D%5Bvalue%5D=&filter_column%5Bsources.name%5D%5Btype%5D=&filter_column%5Bsources.name%5D%5Bvalue%5D=&filter_column%5Buser_trucks.truck_aprox_price%5D%5Btype%5D=&filter_column%5Buser_trucks.truck_aprox_price%5D%5Bsorting%5D=&lasturl=http%3A%2F%2F127.0.0.1%3A8000%2Fcrm%2Forders%3Fm%3D45';
        }
        if ( activePoint[0]._datasetIndex == 2 ) {
            anno = '2017';
            url_link = 'http://ezcrm.us/crm/invoice?filter_column%5Binvoice.contact_name%5D%5Btype%5D=&filter_column%5Binvoice.contact_name%5D%5Bsorting%5D=&filter_column%5Bstates.abbreviation%5D%5Btype%5D=&filter_column%5Bstates.abbreviation%5D%5Bvalue%5D=&filter_column%5Binvoice.city%5D%5Btype%5D=&filter_column%5Binvoice.city%5D%5Bsorting%5D=&filter_column%5Binvoice.invoice_date%5D%5Btype%5D=between&filter_column%5Binvoice.invoice_date%5D%5Bvalue%5D%5B%5D='+anno+'-'+mes+'-01&filter_column%5Binvoice.invoice_date%5D%5Bvalue%5D%5B%5D='+anno+'-'+mes+'-31&filter_column%5Binvoice.invoice_date%5D%5Bsorting%5D=&filter_column%5Binvoice.id_user%5D%5Btype%5D=&filter_column%5Binvoice.id_user%5D%5Bvalue%5D=&lasturl=http%3A%2F%2F127.0.0.1%3A8000%2Fcrm%2Finvoice%3Fm%3D68';
        }
        if ( activePoint[0]._datasetIndex == 3 ) {
            anno = '2018';
            url_link = 'http://ezcrm.us/crm/invoice?filter_column%5Binvoice.contact_name%5D%5Btype%5D=&filter_column%5Binvoice.contact_name%5D%5Bsorting%5D=&filter_column%5Bstates.abbreviation%5D%5Btype%5D=&filter_column%5Bstates.abbreviation%5D%5Bvalue%5D=&filter_column%5Binvoice.city%5D%5Btype%5D=&filter_column%5Binvoice.city%5D%5Bsorting%5D=&filter_column%5Binvoice.invoice_date%5D%5Btype%5D=between&filter_column%5Binvoice.invoice_date%5D%5Bvalue%5D%5B%5D='+anno+'-'+mes+'-01&filter_column%5Binvoice.invoice_date%5D%5Bvalue%5D%5B%5D='+anno+'-'+mes+'-31&filter_column%5Binvoice.invoice_date%5D%5Bsorting%5D=&filter_column%5Binvoice.id_user%5D%5Btype%5D=&filter_column%5Binvoice.id_user%5D%5Bvalue%5D=&lasturl=http%3A%2F%2F127.0.0.1%3A8000%2Fcrm%2Finvoice%3Fm%3D68';
        }

        //console.log('activePoint', activePoint[0]);
        //console.log('datos', activePoint[0]._datasetIndex);

        window.location = url_link;
    };

    /*document.getElementById("chart-legend-normal").onclick = function(evt){

        console.log(this);
    };*/

</script>

</body>

</html>

@endsection