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

    <!-- Your html goes here -->
    <div class='panel panel-default'>
        <div class='panel-heading'"><strong><i class="fa fa-users"></i> Client Details: "{{$client->name}}" </strong></div>

        <div class="panel-body" style="padding:20px 0px 0px 0px">

            <div class="box-body" id="parent-form-area">
            </div>
        </div>
    </div>

    <div class='panel panel-default'>
        <div class='panel-heading ' style="color:#00a65a;"><strong><i class="fa fa-pencil-square-o text-normal"></i> Closed Quotes </strong></div>

        <div class="panel-body" style="padding:20px 0px 0px 0px">

                <div class="box-body" id="parent-form-area">

                    <style type="text/css">
                        #table-detail tr td:first-child {
                            font-weight: bold;
                            width: 25%;
                        }
                    </style>

                    <div class="table-responsive">

                        <table class='table table-striped table-bordered'>
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Budget</th>
                                <th>Creation Date</th>
                                <th>Financing</th>
                                <th>Total</th>
                                <th style="text-align: center;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($quotes_closed as $quote)
                                <tr>
                                    <td>{{$quote->id}}</td>
                                    <td>{{$quote->budget}}</td>
                                    <td>{{$quote->created_at}}</td>
                                    <td>{{$quote->need_financing}}</td>
                                    <td>{{$quote->total}}</td>
                                    <td style="text-align: center;">
                                        <!-- To make sure we have read access, wee need to validate the privilege -->
                                        @if(CRUDBooster::isUpdate() && $button_edit)
                                            <a class='btn btn-warning btn-sm' href='{{CRUDBooster::mainpath("change-quotes/$quote->id")}}'>Open Quote</a>
                                            <a class='btn btn-primary btn-sm' href='{{CRUDBooster::mainpath("create-invoice/$quote->id")}}'>Invoice</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


                    </div>
                </div><!-- /.box-body -->
        </div>

    </div>


    <div class='panel panel-default'>
        <div class='panel-heading' style="color:#e08e0b;"><strong><i class="fa fa-pencil-square-o text-normal"></i> Open Quotes </strong></div>

        <div class="panel-body" style="padding:20px 0px 0px 0px">

            <div class="box-body" id="parent-form-area">

                <style type="text/css">
                    #table-detail tr td:first-child {
                        font-weight: bold;
                        width: 25%;
                    }
                </style>

                <div class="table-responsive">

                    <table class='table table-striped table-bordered'>
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Budget</th>
                            <th>Creation Date</th>
                            <th>Financing</th>
                            <th>Total</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($quotes_opened as $quote)
                            <tr>
                                <td>{{$quote->id}}</td>
                                <td>{{$quote->budget}}</td>
                                <td>{{$quote->created_at}}</td>
                                <td>{{$quote->need_financing}}</td>
                                <td>{{$quote->total}}</td>
                                <td style="text-align: center;">
                                    <!-- To make sure we have read access, wee need to validate the privilege -->
                                    @if(CRUDBooster::isUpdate() && $button_edit)
                                        <a class='btn btn-success btn-sm' href='{{CRUDBooster::mainpath("change-quotes/$quote->id")}}'>Close Quote</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                </div>
            </div><!-- /.box-body -->
        </div>

    </div>
@endsection