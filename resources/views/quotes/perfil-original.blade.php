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
        <a class='btn btn-primary pull-right' style="margin: 2px" href='http://127.0.0.1:8000/admin/task_calendar'><i class="fa fa-calendar"></i>  Calendar</a>
        <a class='btn btn-success pull-right' style="margin: 2px" href='http://127.0.0.1:8000/admin/appliances/add?return_url=http%3A%2F%2F127.0.0.1%3A8000%2Fadmin%2Fappliances%3Fforeign_key%3Dorders_id%26label%3DAppliances%26parent_columns%3Dname%26parent_id%3D{{$id}}%26parent_table%3Dorders%26return_url%3Dhttp%253A%252F%252F127.0.0.1%253A8000%252Fadmin%252Forders%253Fm%253D45&parent_id={{$id}}&parent_field=orders_id'><i class="fa fa-bars"></i> Appliances</a>
        <a class='btn btn-primary pull-right' style="margin: 2px" href='http://127.0.0.1:8000/admin/notes_quotes/add?return_url=http%3A%2F%2F127.0.0.1%3A8000%2Fadmin%2Fnotes_quotes%3Fforeign_key%3Dorders_id%26label%3DNotes%26parent_columns%3Dname%26parent_id%3D{{$id}}%26parent_table%3Dorders%26return_url%3Dhttp%253A%252F%252F127.0.0.1%253A8000%252Fadmin%252Forders%253Fm%253D45&parent_id={{$id}}&parent_field=orders_id'><i class="fa fa-file-text-o"></i> Notes</a>
        <a class='btn btn-warning pull-right' style="margin: 2px" href='http://127.0.0.1:8000/admin/eazy_tasks_quotes/add?return_url=http%3A%2F%2F127.0.0.1%3A8000%2Fadmin%2Feazy_tasks_quotes%3Fforeign_key%3Dorders_id%26label%3DTasks%26parent_columns%3Dname%26parent_id%3D{{$id}}%26parent_table%3Dorders%26return_url%3Dhttp%253A%252F%252F127.0.0.1%253A8000%252Fadmin%252Forders%253Fm%253D45&parent_id={{$id}}&parent_field=orders_id'><i class="fa fa-book"></i> Tasks</a>

        @if( $isClosed == 0 )
                <a class='btn btn-danger pull-right' style="margin: 2px" href='{{CRUDBooster::mainpath("change-quotes/$id")}}'><i class="fa fa-cubes"></i> Close Quote</a>
            @else
                <a class='btn btn-success pull-right' style="margin: 2px" href='{{CRUDBooster::mainpath("change-quotes/$id")}}'><i class="fa fa-cubes"></i> Open Quote</a>
        @endif

        <a class='btn btn-success pull-right' style="margin: 2px" href='{{CRUDBooster::adminpath("orders/edit/$id")}}'><i class="fa fa-pencil"></i> Edit</a>

        <div class='panel-heading'><strong><i class="fa fa-shopping-bag"></i> Quote Information </strong></div>

        <div class="panel-body" style="padding:5px 0px 0px 0px">
            <form class="form-horizontal" method="post" id="form" enctype="multipart/form-data" action="http://127.0.0.1:8000/admin/campaigns/edit-save/2">

                <div class="box-body" id="parent-form-area">

                    <style type="text/css">
                        #table-detail tr td:first-child {
                            font-weight: bold;
                            width: 25%;
                        }
                    </style>

                </div><!-- /.box-body -->


                <div class="table-responsive">
                    <table id="table-detail" class="table table-striped">
                        <tr>
                            <td colspan="2">
                            <div class="panel panel-default">

                                <div class='panel-heading' style="background-color: #337ab7; color: white;">
                                    {{--<a style="color: white;" href='{{CRUDBooster::adminpath("customers/detail/$lead->id")}}'><i class="fa fa-user"></i>--}}
                                        {{--Lead Information (Clic to View Detail)--}}
                                    {{--</a>--}}

                                    Lead Information
                                </div>

                                <div class="panel-body">

                                    <div class="box-body" id="parent-form-area">

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input class="form-control imput" disabled="disabled" style="width: 100%;" value="{{ $lead->name }}" />
                                                </div>
                                            </div>

                                            <div class="col-md-1"></div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Lastname</label>
                                                    <input class="form-control imput" disabled="disabled" style="width: 100%;" value="{{ $lead->lastname }}"/>
                                                </div>
                                            </div>

                                            <div class="col-md-1"></div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input class="form-control imput" disabled="disabled" style="width: 100%;" value="{{ $lead->email }}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Telephone</label>
                                                    <input class="form-control imput" disabled="disabled" style="width: 100%;" value="{{ $lead->phone }}"/>
                                                </div>
                                            </div>

                                            <div class="col-md-1"></div>

                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input class="form-control imput" disabled="disabled" style="width: 100%;" value="{{ $lead->address }}" />
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>


                        </td>
                        </tr>
                    </table>
                </div>

                <div class="table-responsive">
                    <table id="table-detail" class="table table-striped">
                        <tr>
                            <td colspan="2">
                            <div class="panel panel-default">
                                <div class='panel-heading' style="background-color: #337ab7; color: white;">
                                    <i class="fa fa-cubes"></i> Build Out Information
                                </div>
                                <div class="panel-body">

                                    <div class="table-responsive">

                                        <table class='table table-striped table-bordered'>
                                            <thead>
                                            <tr>
                                                <th>Build Out Name</th>
                                                <th>Price</th>
                                                <th>Description</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($buildouts as $buildout)
                                                    <tr>
                                                        <td>{{ $buildout->name }}</td>
                                                        <td>{{ $buildout->sell_price }}</td>
                                                        <td>{{ $buildout->description }}</td>
                                                    </tr>
                                                @endforeach

                                                <tr>
                                                    <td colspan="3" style="text-align: right; font-size: 16px; padding: 15px">Subtotal: ${{ $subtotalBuildouts }}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>


                        </td>
                        </tr>
                    </table>
                </div>

                <div class="table-responsive">
                    <table id="table-detail" class="table table-striped">
                        <tr>
                            <td colspan="2">
                                <div class="panel panel-default">
                                    <div class='panel-heading' style="background-color: #337ab7; color: white;">
                                        <i class="fa fa-cubes"></i> Appliances Information
                                    </div>
                                    <div class="panel-body">

                                        <div class="table-responsive">

                                            <table class='table table-striped table-bordered'>
                                                <thead>
                                                <tr>
                                                    <th>Category</th>
                                                    <th>Appliance</th>
                                                    <th>Description</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($appliances as $appliance)
                                                        <tr>
                                                            <td>{{ $appliance->appliances_categories_id }}</td>
                                                            <td>{{ $appliance->name }}</td>
                                                            <td>{{ $appliance->description }}</td>
                                                            <td>{{ $appliance->price }}</td>
                                                            <td>{{ $appliance->quantity }}</td>
                                                            <td>{{ $appliance->total }}</td>
                                                        </tr>
                                                    @endforeach

                                                    <tr>
                                                        <td colspan="6" style="text-align: right; font-size: 16px; padding: 15px">Subtotal: ${{ $subtotalAppliances }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>


                            </td>
                        </tr>
                    </table>
                </div>


                <div class="table-responsive">
                    <table id="table-detail" class="table table-striped">
                        <tr>
                            <td colspan="2">
                                <div class="panel panel-default">
                                    <div class='panel-heading' style="background-color: #337ab7; color: white;">
                                        <i class="fa fa-credit-card"></i> Total Summary
                                    </div>
                                    <div class="panel-body">

                                        <div class="box-body" id="parent-form-area">

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Build Out</label>
                                                        <input class="form-control imput" disabled="disabled" style="width: 100%;" value="${{ $subtotalBuildouts }}" />
                                                    </div>
                                                </div>

                                                <div class="col-md-1"></div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Build Out Tax</label>
                                                        <input class="form-control imput" disabled="disabled" style="width: 100%;" value="${{ $row->tax }}" />
                                                    </div>
                                                </div>

                                                <div class="col-md-1"></div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Appliances</label>
                                                        <input class="form-control imput" disabled="disabled" style="width: 100%;" value="${{ $subtotalAppliances }}" />
                                                    </div>
                                                </div>

                                                <div class="col-md-1"></div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Appliances Tax</label>
                                                        <input class="form-control imput" disabled="disabled" style="width: 100%;" value="${{ $row->tax }}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Discount</label>
                                                        <input class="form-control imput" disabled="disabled" style="width: 100%;" value="${{ $row->discount }}" />
                                                    </div>
                                                </div>

                                                <div class="col-md-1"></div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Profit</label>
                                                        <input class="form-control imput" disabled="disabled" style="width: 100%;" value="${{ $row->profit }}" />
                                                    </div>
                                                </div>

                                                <div class="col-md-1"></div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label style="color: #00a157;">Total Quote Value</label>
                                                        <input class="form-control imput" disabled="disabled" style="width: 100%; color: #00a157; font-size: 15px" value="${{ $subtotalBuildouts + $subtotalAppliances }}" />
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>


                            </td>
                        </tr>
                    </table>
                </div>


                <div class="table-responsive">
                    <table id="table-detail" class="table table-striped">
                        <tr>
                            <td colspan="2">
                                <div class="panel panel-default">
                                    <div class='panel-heading' style="background-color: #337ab7; color: white;">
                                        <i class="fa fa-credit-card"></i> More Info
                                    </div>
                                    <div class="panel-body">

                                        <div class="box-body" id="parent-form-area">

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>How son you need it?</label>
                                                        <input class="form-control imput" disabled="disabled" style="width: 100%;" value="{{ $row->date_limit }}" />
                                                    </div>
                                                </div>

                                                <div class="col-md-1"></div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Need Financing?</label>
                                                        <input class="form-control imput" disabled="disabled" style="width: 100%;" value="{{ $row->need_financing }}" />
                                                    </div>
                                                </div>

                                                <div class="col-md-1"></div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Budget</label>
                                                        <input class="form-control imput" disabled="disabled" style="width: 100%;" value="${{ $row->budget }}" />
                                                    </div>
                                                </div>

                                                <div class="col-md-1"></div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Downpayment</label>
                                                        <input class="form-control imput" disabled="disabled" style="width: 100%;" value="{{ $row->downpayment }}" />
                                                    </div>
                                                </div>


                                            </div>



                                        </div>

                                    </div>
                                </div>


                            </td>
                        </tr>
                    </table>
                </div>


                <div class='panel panel-default'>
                    <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-book"></i> Tasks</strong></div>
                </div>

                <div class="table-responsive" style="padding-left: 20px; padding-right: 20px">

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
                        @foreach($tasks as $task)
                            <tr>
                                <td>{{$task->name}}</td>
                                <td>{{$task->description}}</td>
                                <td>{{$task->date}}</td>
                                <td>{{$task->created_at}}</td>
                                <td>{{$task->task_type_name}}</td>
                                <td style="text-align: center">
                                    <a class="btn btn-xs btn-primary btn-detail" title="Detail Data" href="http://127.0.0.1:8000/admin/eazy_tasks_quotes/detail/{{$task->id}}?return_url=http%3A%2F%2F127.0.0.1%3A8000%2Fadmin%2Feazy_tasks_quotes%3Fforeign_key%3Dorders_id%26label%3DTasks%26parent_columns%3Dname%26parent_id%3D{{$id}}%26parent_table%3Dorders%26return_url%3Dhttp%253A%252F%252F127.0.0.1%253A8000%252Fadmin%252Forders%253Fm%253D45"><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-xs btn-success btn-edit" title="Edit Data" href="http://127.0.0.1:8000/admin/eazy_tasks_quotes/edit/{{$task->id}}?return_url=http%3A%2F%2F127.0.0.1%3A8000%2Fadmin%2Feazy_tasks_quotes%3Fforeign_key%3Dorders_id%26label%3DTasks%26parent_columns%3Dname%26parent_id%3D{{$id}}%26parent_table%3Dorders%26return_url%3Dhttp%253A%252F%252F127.0.0.1%253A8000%252Fadmin%252Forders%253Fm%253D45&parent_id={{$id}}&parent_field="><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>


                </div>


                <div class='panel panel-default'>
                    <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-file-text-o"></i> Notes</strong></div>
                </div>

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
                                            function(){  location.href='http://127.0.0.1:8000/admin/notes_quotes/delete/{{ $note->id }}' });"><i class="fa fa-trash"></i>
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

            </form>

        </div>


    </div>
@endsection