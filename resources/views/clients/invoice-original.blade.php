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

    <div class='panel panel-default'>
        <div class='panel-heading'"><strong><i class="fa fa-users"></i> BILL Information </strong>
    </div>

    <div class="panel-body" style="padding:20px 0px 0px 0px">

        <div class="box-body" id="parent-form-area">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact Name</label>
                        <input class="form-control imput" disabled="disabled" style="width: 100%;" value="{{$customer_information->name.' '.$customer_information->lastname}}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Addres</label>
                        <input class="form-control imput" disabled="disabled" style="width: 100%;" value="{{$customer_information->address}}"/>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>


    <div class='panel panel-default'>
        <div class='panel-heading'"><strong><i class="fa fa-users"></i> SHIP Information </strong>
    </div>

    <div class="panel-body" style="padding:20px 0px 0px 0px">

        <div class="box-body" id="parent-form-area">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact Name</label>
                        <input class="form-control imput" disabled="disabled" style="width: 100%;" value="{{$customer_information->name.' '.$customer_information->lastname}}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Addres</label>
                        <input class="form-control imput" disabled="disabled" style="width: 100%;" value="{{$customer_information->address}}"/>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>


    <div class='panel panel-default'>
        <div class='panel-heading'"><strong><i class="fa fa-users"></i> List of Products </strong>
    </div>

    <div class="panel-body" style="padding:20px 0px 0px 0px">

        <div class="box-body" id="parent-form-area">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact Name</label>
                        <input class="form-control imput" disabled="disabled" style="width: 100%;" value="{{$customer_information->name.' '.$customer_information->lastname}}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Addres</label>
                        <input class="form-control imput" disabled="disabled" style="width: 100%;" value="{{$customer_information->address}}"/>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>



    <!-- Your html goes here -->
    <div class='panel panel-default'>
        <div class='panel-heading'"><strong><i class="fa fa-users"></i> Invoice details: "{{$invoice->business_name}}" </strong></div>

        <div class="panel-body" style="padding:20px 0px 0px 0px">

            <div class="box-body" id="parent-form-area">
                <section class="invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-globe"></i> {{ $settings->name }}
                                <small class="pull-right">Date: {{ $invoice->created_at  }}</small>
                            </h2>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            From
                            <address>
                                <strong>{{ $settings->name }}</strong><br>
                                {{ $settings->address }}<br>
                                Phone: {{ $settings->phone }}<br>
                                Email: {{ $settings->email }}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            Client
                            <address>
                                <strong>{{ $invoice->name }}</strong><br>
                                {{ $invoice->address }}<br>
                                Phone: {{ $invoice->phone }}<br>
                                Email: {{ $invoice->email }}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b>Invoice #007612</b><br>
                            <br>
                            <b>Order ID:</b> {{ $invoice->order_number }}<br>
                            <b>Payment Due:</b> {{ $invoice->updated_at }}<br>
                            <b>Account:</b> <strong style="color: red;">657783</strong>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Qty</th>
                                    <th>Product</th>
                                    <th>Description</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Producto A</td>
                                    <td>El snort testosterone trophy driving gloves handsome</td>
                                    <td>$64.50</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-xs-6">
                            <p class="lead">Payment Methods:</p>
                            <img src="<?php echo e(asset('assets/images/visa.png')); ?>" alt="Visa">
                            <img src="<?php echo e(asset('assets/images/mastercard.png')); ?>" alt="Mastercard">
                            <img src="<?php echo e(asset('assets/images/american-express.png')); ?>" alt="American Express">
                            <img src="<?php echo e(asset('assets/images/paypal2.png')); ?>" alt="Paypal">

                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                Disponemos de diferentes métodos de pago que disponemos para realizar el mismo.
                            </p>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-6">
                            <p class="lead">Amount Due 2/22/2014</p>

                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>${{ $invoice->total  }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tax (9.3%)</th>
                                        <td>${{ $invoice->tax  }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping:</th>
                                        <td>$5.80</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td>${{ $invoice->grand_total  }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12">
                            <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                            <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
                            </button>
                            <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                                <i class="fa fa-download"></i> Generate PDF
                            </button>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
                <div class="clearfix"></div>
            </div>
            </div>
        </div>
    </div>




@endsection