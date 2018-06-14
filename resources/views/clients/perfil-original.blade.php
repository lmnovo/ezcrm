<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template_fases')
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
        <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-users"></i> Client Profile</strong></div>

        <div class="panel-body" style="padding:20px 0px 0px 0px">

                <div class="box-body" id="parent-form-area">

                    <style type="text/css">
                        #table-detail tr td:first-child {
                            font-weight: bold;
                            width: 25%;
                        }
                    </style>
                    <div class="table-responsive">
                        <table id="table-detail" class="table table-striped">
                            <tbody>
                                <tr>
                                    <td colspan="4" style="text-align: center;"><a data-lightbox="roadtrip" href="http://127.0.0.1:8000/{{$lead->photo}}"><img style="max-width:150px" title="Image For Photo" src="http://127.0.0.1:8000/{{$lead->photo}}"></a>
                                        {{--<a class='btn btn-success pull-right' style="margin: 2px" href='http://127.0.0.1:8000/admin/fases?parent_table=customers&parent_columns=name&parent_id=3289&return_url=http%3A%2F%2F127.0.0.1%3A8000%2Fadmin%2Fcustomers25%3Fm%3D62&foreign_key=customers_id&label=Phases'><i class="fa fa-step-forward"></i> Process</a>--}}
                                        <a title="Add Note" class='btn btn-danger pull-right' style="margin: 2px" href='http://127.0.0.1:8000/admin/notes/add?return_url=http%3A%2F%2F127.0.0.1%3A8000%2Fadmin%2Fnotes%3Fforeign_key%3Dcustomers_id%26label%3DNotes%26parent_columns%3Dname%26parent_id%3D{{$id}}%26parent_table%3Dcustomers%26return_url%3Dhttp%253A%252F%252F127.0.0.1%253A8000%252Fadmin%252Fcustomers%253Fm%253D50&parent_id={{$id}}&parent_field=customers_id'><i class="fa fa-file-text-o"></i></a>
                                        <a title="Add Task" class='btn btn-primary pull-right' style="margin: 2px" href='http://127.0.0.1:8000/admin/eazy_tasks/add?return_url=http%3A%2F%2F127.0.0.1%3A8000%2Fadmin%2Feazy_tasks%3Fforeign_key%3Dcustomers_id%26label%3DTasks%26parent_columns%3Dname%26parent_id%3D{{$id}}%26parent_table%3Dcustomers%26return_url%3Dhttp%253A%252F%252F127.0.0.1%253A8000%252Fadmin%252Fcustomers%253Fm%253D50&parent_id={{$id}}&parent_field=customers_id'><i class="fa fa-book"></i></a>
                                        <a title="Send Email" class='btn btn-success pull-right' style="margin: 2px" href='{{CRUDBooster::mainpath("send-email/$id")}}'><i class="fa fa-envelope"></i></a>
                                        <a title="Send SMS" class='btn btn-warning pull-right' style="margin: 2px" href='{{CRUDBooster::mainpath("send-sms/$id")}}'><i class="fa fa-phone"></i></a>
                                        <a title="Add Quote" class='btn btn-primary pull-right' style="margin: 2px" href='{{CRUDBooster::adminpath("customers25/quotes/$id")}}'><i class="fa fa-edit"></i></a>

                                        <br>
                                        <a title="Show Calendar" class='btn btn-primary pull-right' style="margin: 2px" href='http://127.0.0.1:8000/admin/task_calendar'><i class="fa fa-calendar"></i> </a>
                                        <a title="Edit" class='btn btn-success pull-right' style="margin: 2px" href='http://127.0.0.1:8000/admin/customers/edit/{{$id}}?return_url=http%3A%2F%2F127.0.0.1%3A8000%2Fadmin%2Fcustomers%3Fm%3D50&parent_id=&parent_field='><i class="fa fa-pencil"></i></a>
                                </tr>
                                <tr>
                                    <td>Name</td><td>{{ $lead->name }}</td>
                                    <td>Address</td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="showModalMapaddress()" title="Click to view the map">
                                                <i class="fa fa-map-marker"></i> {{ $lead->address }}
                                            </a>

                                            <div id="googlemaps-modal-address" class="modal" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                        <h4 class="modal-title"><i class="fa fa-search"></i> View Map</h4>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="map" id="map-address"></div>

                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

                                            <script type="text/javascript">
                                            function showModalMapaddress() {
                                                $('#googlemaps-modal-address').modal('show');
                                            }
                                            var is_init_map_address = false;
                                            $('#googlemaps-modal-address').on('shown.bs.modal', function(){
                                                if(is_init_map_address == false) {
                                                    initMapaddress();
                                                    is_init_map_address = true;
                                                }
                                            });
                                            function initMapaddress() {

                                                $('#googlemaps-modal-address .modal-body').html("<div align='center'>Sorry the map is not found !</div>");

                                            }
                                        </script>
                                        </td>
                                </tr>

                                <tr>
                                    <td>Email</td><td><a href="mailto:{{ $lead->email }}" target="_blank">{{ $lead->email }}</a></td>
                                    <td>Type</td><td>{{ $contact_type->name }}</td>
                                </tr>

                                <tr>
                                    <td>Phone</td><td>{{ $lead->phone }}</td>
                                    <td>Other Phone</td><td>{{ $lead->phone_other }}</td>
                                </tr>

                                <tr>
                                    <td>Creation Date</td><td>{{ $lead->created_at }}</td>
                                    <td>Assign To</td><td>{{ $assign_to->fullname }}</td>
                                </tr>

                                <tr>
                                    <td>ZipCode</td><td>{{ $lead->zipcode }}</td>
                                    <td>Quotes</td><td>{{ $lead->quotes }}</td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div><!-- /.box-body -->

                <div class='panel panel-default'>
                    <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-pencil-square-o text-normal"></i> Closed Quotes </strong></div>


                    <div class="panel-body" style="padding:20px 0px 0px 0px">

                        <div class="box-body" id="parent-form-area">

                            <style type="text/css">
                                #table-detail tr td:first-child {
                                    font-weight: bold;
                                    width: 25%;
                                }
                            </style>

                            <div class="table-responsive">

                                    <?php
                                    if(count($quotes_closed) == 0) {
                                    echo "<div style='text-align: center; color: red; padding-bottom: 20px;'><i class='fa fa-search'></i>";?> {{ trans('crudbooster.table_data_not_found') }}  <?php echo "</div>";
                                    }
                                    else {
                                    ?>

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

                                        <?php    }
                                        ?>

                                    @foreach($quotes_closed as $quote)
                                        <tr>
                                            <td>{{$quote->id}}</td>
                                            <td>{{$quote->budget}}</td>
                                            <td>{{$quote->created_at}}</td>
                                            <td>{{$quote->need_financing}}</td>
                                            <td>{{$quote->total_quote}}</td>
                                            <td style="text-align: center;">
                                                <a title="Print" class='btn btn-primary btn-sm' href='{{CRUDBooster::mainpath("print-quotes/$quote->id")}}'><i class="fa fa-print"></i></a>
                                                <a title="Open Quote" class='btn btn-success btn-sm' href='{{CRUDBooster::adminPath("orders/change-quotes/$quote->id")}}'><i class="fa fa-arrow-left"></i></a>
                                                <a title="Invoice" class='btn btn-yahoo btn-sm' href='{{CRUDBooster::mainpath("create-invoice/$quote->id")}}'><i class="fa fa-hand-o-right"></i></a>
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
                    <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-pencil-square-o text-normal"></i> Open Quotes </strong></div>

                    <div class="panel-body" style="padding:20px 0px 0px 0px">

                        <div class="box-body" id="parent-form-area">

                            <style type="text/css">
                                #table-detail tr td:first-child {
                                    font-weight: bold;
                                    width: 25%;
                                }
                            </style>

                            <div class="table-responsive">

                                    <?php
                                    if(count($quotes_opened) == 0) {
                                    echo "<div style='text-align: center; color: red; padding-bottom: 20px;'><i class='fa fa-search'></i>";?> {{ trans('crudbooster.table_data_not_found') }}  <?php echo "</div>";
                                    }
                                    else {
                                    ?>

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

                                        <?php    }
                                        ?>

                                    @foreach($quotes_opened as $quote)
                                        <tr>
                                            <td>{{$quote->id}}</td>
                                            <td>{{$quote->budget}}</td>
                                            <td>{{$quote->created_at}}</td>
                                            <td>{{$quote->need_financing}}</td>
                                            <td>{{$quote->total_quote}}</td>
                                            <td style="text-align: center;">
                                                <a title="Edit" class='btn btn-success btn-sm' href='{{CRUDBooster::adminPath("orders/edit/$quote->id")}}'><i class="fa fa-pencil"></i></a>
                                                <a title="Print" class='btn btn-danger btn-sm' href='{{CRUDBooster::mainpath("print-quotes/$quote->id")}}'><i class="fa fa-print"></i></a>
                                                <a title="Convert to Client" class='btn btn-primary btn-sm' href='{{CRUDBooster::adminPath("orders/convert-client/$quote->id")}}'><i class="fa fa-share-square-o"></i></a>
                                                <a title="Invoice" class='btn btn-yahoo btn-sm' href='{{CRUDBooster::mainpath("create-invoice/$quote->id")}}'><i class="fa fa-hand-o-right"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>


                            </div>
                        </div><!-- /.box-body -->
                    </div>


                    <div class='panel panel-default'>
                        <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-product-hunt"></i> Actual Process </strong></div>

                        <div class="panel-body" style="padding:20px 0px 0px 0px">
                            <div class="right_col" role="main">
                                <div class="">
                                    <div class="clearfix"></div>

                                    <div class="row">

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="x_panel">
                                                <div class="x_title">
                                                    <h2>Project's Phases</h2>

                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="x_content">


                                                    <!-- Smart Wizard -->
                                                    <div id="wizard" class="form_wizard wizard_horizontal">
                                                        <ul class="wizard_steps">
                                                            <li>
                                                                <a href="#step-1">
                                                                    <span class="step_no">1</span>
                                                                    <span class="step_descr">
                                                                         @if( $phases1->name != null )
                                                                            {{ $phases1->name }}
                                                                        @else
                                                                            Step 1
                                                                        @endif<br />

                                                                          @if( $isCompletedPhase1 != null )
                                                                                <small style="color: #00a157;"><strong>Status: Completed</strong></small>
                                                                              @else
                                                                                <small style="color: red;"><strong>Status: Pending</strong></small>
                                                                          @endif

                                                                    </span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#step-2">
                                                                    <span class="step_no">2</span>
                                                                    <span class="step_descr">
                                                                         @if( $phases2->name != null )
                                                                            {{ $phases2->name }}
                                                                        @else
                                                                            Step 2
                                                                        @endif<br />

                                                                        @if( $isCompletedPhase2 != null )
                                                                            <small style="color: #00a157;"><strong>Status: Completed</strong></small>
                                                                        @else
                                                                            <small style="color: red;"><strong>Status: Pending</strong></small>
                                                                        @endif

                                                                    </span>

                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#step-3">
                                                                    <span class="step_no">3</span>
                                                                    <span class="step_descr">
                                                                         @if( $phases3->name != null )
                                                                            {{ $phases3->name }}
                                                                        @else
                                                                            Step 3
                                                                        @endif<br />

                                                                        @if( $isCompletedPhase3 != null )
                                                                            <small style="color: #00a157;"><strong>Status: Completed</strong></small>
                                                                        @else
                                                                            <small style="color: red;"><strong>Status: Pending</strong></small>
                                                                        @endif

                                                                    </span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#step-4">
                                                                    <span class="step_no">4</span>
                                                                    <span class="step_descr">
                                                                         @if( $phases4->name != null )
                                                                            {{ $phases4->name }}
                                                                        @else
                                                                            Step 4
                                                                        @endif<br />

                                                                        @if( $isCompletedPhase4 != null )
                                                                            <small style="color: #00a157;"><strong>Status: Completed</strong></small>
                                                                        @else
                                                                            <small style="color: red;"><strong>Status: Pending</strong></small>
                                                                        @endif

                                                                    </span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#step-5">
                                                                    <span class="step_no">5</span>
                                                                    <span class="step_descr">
                                                                         @if( $phases5->name != null )
                                                                                {{ $phases5->name }}
                                                                            @else
                                                                                Step 5
                                                                         @endif
                                                                            <br />

                                                                        @if( $isCompletedPhase5 != null )
                                                                            <small style="color: #00a157;"><strong>Status: Completed</strong></small>
                                                                        @else
                                                                            <small style="color: red;"><strong>Status: Pending</strong></small>
                                                                        @endif

                                                                    </span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <div id="step-1">
                                                            <h2 class="StepTitle">Step 1 Content</h2>

                                                            <?php
                                                            $action = CRUDBooster::adminpath("customers25/steps");
                                                            $return_url = ($return_url)?:g('return_url');
                                                            ?>

                                                            <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>
                                                                <input type="hidden" name="customer_id" value="<?php echo e($id); ?>" />
                                                                <input type="hidden" name="fase_id" value="<?php echo e(1); ?>" />

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Step Name <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <input value="{{ $phases1->name }}" type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <input value="{{ $phases1->email }}" type="text" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Date <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <input value="{{ $phases1->datetime }}" disabled="disabled" type="text" name="date" id="date" required="required" class="form-control col-md-7 col-xs-12">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <textarea name="notes" id="notes" class="form-control" rows="10">{{ $phases1->notes }}</textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-10"></div>
                                                                    <div class="col-md-2">
                                                                        <input type="submit" value="Step Save" class="btn btn-primary">
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>
                                                        <div id="step-2">
                                                            <h2 class="StepTitle">Step 2 Content</h2>
                                                            <?php
                                                            $action = CRUDBooster::adminpath("customers25/steps");
                                                            $return_url = ($return_url)?:g('return_url');
                                                            ?>

                                                            <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>
                                                                <input type="hidden" name="customer_id" value="<?php echo e($id); ?>" />
                                                                <input type="hidden" name="fase_id" value="2" />

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Step Name <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <input value="{{ $phases2->name }}" type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <input value="{{ $phases2->email }}" type="text" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Date <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <input value="{{ $phases2->datetime }}" disabled="disabled" type="text" name="date" id="date" required="required" class="form-control col-md-7 col-xs-12">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <textarea name="notes" id="notes" class="form-control" rows="10">{{ $phases2->notes }}</textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-10"></div>
                                                                    <div class="col-md-2">
                                                                        <input type="submit" value="Step Save" class="btn btn-primary">
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>
                                                        <div id="step-3">
                                                            <h2 class="StepTitle">Step 3 Content</h2>
                                                            <?php
                                                            $action = CRUDBooster::adminpath("customers25/steps");
                                                            $return_url = ($return_url)?:g('return_url');
                                                            ?>

                                                            <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>
                                                                <input type="hidden" name="customer_id" value="<?php echo e($id); ?>" />
                                                                <input type="hidden" name="fase_id" value="3" />

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Step Name <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <input value="{{ $phases3->name }}" type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <input value="{{ $phases3->email }}" type="text" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Date <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <input value="{{ $phases3->datetime }}" disabled="disabled" type="text" name="date" id="date" required="required" class="form-control col-md-7 col-xs-12">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <textarea name="notes" id="notes" class="form-control" rows="10">{{ $phases3->notes }}</textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-10"></div>
                                                                    <div class="col-md-2">
                                                                        <input type="submit" value="Step Save" class="btn btn-primary">
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>
                                                        <div id="step-4">
                                                            <h2 class="StepTitle">Step 4 Content</h2>
                                                            <?php
                                                            $action = CRUDBooster::adminpath("customers25/steps");
                                                            $return_url = ($return_url)?:g('return_url');
                                                            ?>

                                                            <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>
                                                                <input type="hidden" name="customer_id" value="<?php echo e($id); ?>" />
                                                                <input type="hidden" name="fase_id" value="4" />

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Step Name <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <input value="{{ $phases4->name }}" type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <input value="{{ $phases4->email }}" type="text" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Date <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <input value="{{ $phases4->datetime }}" disabled="disabled" type="text" name="date" id="date" required="required" class="form-control col-md-7 col-xs-12">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <textarea name="notes" id="notes" class="form-control" rows="10">{{ $phases4->notes }}</textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-10"></div>
                                                                    <div class="col-md-2">
                                                                        <input type="submit" value="Step Save" class="btn btn-primary">
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>
                                                        <div id="step-5">
                                                            <h2 class="StepTitle">Step 5 Content</h2>
                                                            <?php
                                                            $action = CRUDBooster::adminpath("customers25/steps");
                                                            $return_url = ($return_url)?:g('return_url');
                                                            ?>

                                                            <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>
                                                                <input type="hidden" name="customer_id" value="<?php echo e($id); ?>" />
                                                                <input type="hidden" name="fase_id" value="5" />

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Step Name <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <input value="{{ $phases5->name }}" type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <input value="{{ $phases5->email }}" type="text" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Date <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <input value="{{ $phases5->datetime }}" disabled="disabled" type="text" name="date" id="date" required="required" class="form-control col-md-7 col-xs-12">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes <span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <textarea name="notes" id="notes" class="form-control" rows="10">{{ $phases5->notes }}</textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-10"></div>
                                                                    <div class="col-md-2">
                                                                        <input type="submit" value="Step Save" class="btn btn-primary">
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>

                                                    </div>
                                                    <!-- End SmartWizard Content -->

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                <div class='panel panel-default'>
                    <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-book"></i> Tasks</strong></div>
                </div>

                <div class="table-responsive" style="padding-left: 20px; padding-right: 20px">

                        <?php
                        if(count($tasks) == 0) {
                        echo "<div style='text-align: center; color: red; padding-bottom: 20px;'><i class='fa fa-search'></i>";?> {{ trans('crudbooster.table_data_not_found') }}  <?php echo "</div>";
                        }
                        else {
                        ?>

                            <table class='table table-striped table-bordered'>
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Date Creation</th>
                                    <th>Task Type</th>
                                    <th style="text-align: center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                            <?php    }
                            ?>

                        @foreach($tasks as $task)
                            <tr>
                                <td>{{$task->name}}</td>
                                <td>{{$task->description}}</td>
                                <td>{{$task->date}}</td>
                                <td>{{$task->created_at}}</td>
                                <td>{{$task->task_type_name}}</td>
                                <td style="text-align: center">
                                    <a class="btn btn-xs btn-primary btn-detail" title="Detail Data" href="http://127.0.0.1:8000/admin/eazy_tasks/detail/{{$task->id}}?return_url=http%3A%2F%2F127.0.0.1%3A8000%2Fadmin%2Feazy_tasks%3Fforeign_key%3Dcustomers_id%26label%3DTasks%26parent_columns%3Dname%26parent_id%3D{{$id}}%26parent_table%3Dcustomers%26return_url%3Dhttp%253A%252F%252F127.0.0.1%253A8000%252Fadmin%252Fcustomers%253Fm%253D50"><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-xs btn-success btn-edit" title="Edit Data" href="http://127.0.0.1:8000/admin/eazy_tasks/edit/{{$task->id}}?return_url=http%3A%2F%2F127.0.0.1%3A8000%2Fadmin%2Feazy_tasks%3Fforeign_key%3Dcustomers_id%26label%3DTasks%26parent_columns%3Dname%26parent_id%3D{{$id}}%26parent_table%3Dcustomers%26return_url%3Dhttp%253A%252F%252F127.0.0.1%253A8000%252Fadmin%252Fcustomers%253Fm%253D50&parent_id=3288&parent_field="><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-xs btn-warning btn-delete" title="Delete" href="javascript:;" onclick="swal({
                                            title: 'Are you sure',
                                            text: 'You will not be able to recover this record data!',
                                            type: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#ff0000',
                                            confirmButtonText: 'Yes!',
                                            cancelButtonText: 'No',
                                            closeOnConfirm: false },
                                            function(){  location.href='{{CRUDBooster::adminpath("eazy_tasks/delete/$task->id")}}' });"><i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>


                </div>


                <div class='panel panel-default'>
                    <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-file-text-o"></i> Notes</strong></div>
                </div>

                    <?php
                    if(count($notes) == 0) {
                    echo "<div style='text-align: center; color: red; padding-bottom: 20px;'><i class='fa fa-search'></i>";?> {{ trans('crudbooster.table_data_not_found') }}  <?php echo "</div>";
                    }
                    ?>

                    @foreach($notes as $note)
                        <div class="row invoice-info">
                            <div class="col-sm-2 invoice-col" style="padding-left: 40px; padding-bottom: 20px; padding-top: 10px;">
                                <img style="width:80px" src="<?php echo e(asset('assets/images/logoa.png')); ?>" alt="ChefUnits">
                            </div>
                            <div class="col-sm-8 invoice-col">
                                <div>{{ $note->name }}</div>
                                <div class="row">
                                    <div  class="col-sm-3" style="padding-top: 5px;"><i class="fa fa-clock-o"></i> {{ $note->created_at }}</div>
                                    <div  class="col-sm-1" style="padding-top: 5px;">
                                        <a class="btn btn-xs btn-warning btn-delete" title="Delete" href="javascript:;" onclick="swal({
                                                title: 'Are you sure',
                                                text: 'You will not be able to recover this record data!',
                                                type: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#ff0000',
                                                confirmButtonText: 'Yes!',
                                                cancelButtonText: 'No',
                                                closeOnConfirm: false },
                                                function(){  location.href='http://127.0.0.1:8000/admin/notes/delete/{{ $note->id }}' });"><i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach



                    <div class="box-footer" style="background: #F5F5F5">

                    <div class="form-group">
                        <label class="control-label col-sm-2"></label>
                        <div class="col-sm-10">
                        </div>
                    </div>
                </div><!-- /.box-footer-->


        </div>


    </div>
@endsection