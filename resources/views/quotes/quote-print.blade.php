<!-- First, extends to the CRUDBooster Layout -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $settings->name }} | Invoice</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('vendor/crudbooster/assets/adminlte/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset("vendor/crudbooster/assets/adminlte/font-awesome/css")}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset("vendor/crudbooster/ionic/css/ionicons.min.css")}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('vendor/crudbooster/assets/adminlte/dist/css/AdminLTE.min.css')}}">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> {{ $invoice->contact_name }}
                    <small class="pull-right">Date: {{ $invoice->invoice_date }}</small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col" style="padding-left: 70px;">
                <img style="width:40%" src="<?php echo e(asset('assets/images/logoa.png')); ?>" alt="ChefUnits">
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <address>
                    <p><strong>{{ $settings->name }}</strong><br></p>
                    <p>{{ $settings->address }}<br></p>
                    <p>{{ $settings->email }}<br></p>
                    <p>{{ $settings->phone }}<br></p>
                </address>
            </div>
            <!-- /.col -->
            <p class="col-sm-4 invoice-col">
                <br>
                <br>
                <b style="font-size: 18px;">INVOICE</b> <br>
                <p></p><b style="font-size: 16px;">Date: {{ $invoice->invoice_date }}</b> <br>
        </div>
            <!-- /.col -->
        <!-- /.row -->

        <div class="row invoice-info" style="padding-right: 30px; padding-left: 30px;">
            <table class="table table-bordered table-striped table-condensed">
                <tr>
                    <th>BILL TO:</th>
                    <th>SHIP TO:</th>
                </tr>
                <tr>
                    <td>{{$invoice->bill_name}}</td>
                    <td>{{$invoice->contact_name}}</td>
                </tr>
                <tr>
                    <td>{{$state_client->bill_state}}</td>
                    <td>{{$invoice->state_client}}</td>
                </tr>
                <tr>
                    <td>{{$invoice->bill_city}}</td>
                    <td>{{$invoice->city}}</td>
                </tr>
                <tr>
                    <td>{{$invoice->bill_street}}</td>
                    <td>{{$invoice->street}}</td>
                </tr>
            </table>
        </div>

        <div class="panel-heading" style="font-size: 16px; padding-left: 25px"><strong><i class="fa fa-cubes"></i> List of Products </strong></div>

        <!-- Table row -->
        <div class="row" style="padding-left: 30px; padding-right: 30px;">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoices as $item)
                        <tr>
                            <td>{{$item->contact_name}}</td>
                            <td style="width: 50%"> {{$item->descripcion}}</td>
                            <td>{{$item->price}}</td>
                            <td>{{$item->cant}}</td>
                            <td>{{$item->cant * $item->price}}</td>
                        </tr>
                    @endforeach

                    <td></td>
                    <tr>
                        <td style="text-align: right; font-size: medium;" colspan="4"><strong> </strong></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6" style="padding-left: 30px; font-size: 25px">
                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px; ">
                    Note: This invoice is valid for the next 30 days
                </p>
            </div>
            <!-- /.col -->
            <div class="col-xs-6">
                <div class="table-responsive" style="font-size: 16px">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>${{ $totalFinal }}</td>
                        </tr>
                        <tr>
                            <th>Tax</th>
                            <td>${{ $invoice->tax }}</td>
                        </tr>
                        <tr>
                            <th>Discount:</th>
                            <td>${{ $invoice->discount }}</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>${{ $totalFinal + $invoice->tax - $invoice->discount }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>