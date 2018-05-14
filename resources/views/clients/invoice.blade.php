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
        <div class='panel-heading'><strong><i class="fa fa-cc-mastercard"></i> {{ trans('crudbooster.bill_information') }} </strong>
    </div>

    <div class="panel-body" style="padding:20px 0px 0px 0px">

        <?php
        $action = CRUDBooster::adminPath("customers25/editsave/$order_id");
        $return_url = ($return_url)?:g('return_url');
        ?>

        <form id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>

        <div class="box-body" id="parent-form-area">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ trans('crudbooster.contact_name') }}</label>
                        <input class="form-control imput" id="bill_contact_name" name="bill_contact_name" style="width: 100%;" value="{{$customer_information->name.' '.$customer_information->lastname}}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ trans('crudbooster.state') }}</label>
                        <select class="form-control" id="bill_states" name="bill_states" placeholder="Select" name="states_bill" required>
                            <option></option>
                            @foreach($states as $state)
                                @if($state->abbreviation == $states_id)
                                    <option selected="true" value="{{ $state->abbreviation }}" id="{{ $state->id }}">{{ $state->name }}</option>;
                                @else
                                    <option value="{{ $state->abbreviation }}" id="{{ $state->id }}">{{ $state->name }}</option>;
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ trans('crudbooster.address') }}</label>
                        <input class="form-control imput" id="bill_address" name="bill_address" readonly style="width: 100%;" value="{{$customer_information->address}}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ trans('crudbooster.city') }}</label>
                        <input class="form-control imput" id="bill_city" name="bill_city" style="width: 100%;" value="{{$customer_information->city }}" />
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>


    <div class='panel panel-default'>
        <div class='panel-heading'"><strong><i class="fa fa-cc-mastercard"></i> {{ trans('crudbooster.ship_information') }} </strong>
    </div>

    <div class="panel-body" style="padding:20px 0px 0px 0px">

            <input type="hidden" name="quote_id" value="{{ $order_id }}">

            <div class="box-body" id="parent-form-area">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ trans('crudbooster.contact_name') }}</label>
                            <input class="form-control imput" id="ship_contact_name" name="ship_contact_name" style="width: 100%;" value="{{$customer_information->name.' '.$customer_information->lastname}}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ trans('crudbooster.state') }}</label>
                            <select class="form-control" id="ship_states" name="ship_states" placeholder="Select" name="states_bill" required>
                                <option></option>
                                @foreach($states as $state)
                                    @if($state->abbreviation == $states_id)
                                        <option selected="true" value="{{ $state->abbreviation }}" id="{{ $state->id }}">{{ $state->name }}</option>;
                                    @else
                                        <option value="{{ $state->abbreviation }}" id="{{ $state->id }}">{{ $state->name }}</option>;
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ trans('crudbooster.address') }}</label>
                            <input class="form-control imput" id="ship_address" name="ship_address" readonly style="width: 100%;" value="{{$customer_information->address}}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ trans('crudbooster.city') }}</label>
                            <input class="form-control imput" id="ship_city" name="ship_city" style="width: 100%;" value="{{$customer_information->city }}" />
                        </div>
                    </div>
                </div>

            </div>
    </div>

    <!-- Your html goes here -->
    <div class='panel panel-default'>

        <div class='panel-heading'"><strong><i class="fa fa-cubes"></i> {{ trans('crudbooster.List_Products') }} </strong></div>

        <div class="panel-body" style="padding:10px 0px 0px 0px">

            <div class="box-body" id="parent-form-area">
                <section class="invoice">


                    <div class="table-responsive hover">
                        <table id="accesorios" class="table table-striped table-responsive table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ trans('crudbooster.product') }}</th>
                                <th>{{ trans('crudbooster.description') }}</th>
                                <th>{{ trans('crudbooster.price') }}</th>
                                <th>{{ trans('crudbooster.quantity') }}</th>
                                <th >Total</th>
                                {{--<th >Action</th>--}}
                            </tr>
                            </thead>
                            <tbody >

                            @foreach($orders_detail as $items)
                                <tr role="row" class="odd">
                                    <td class="sorting_1">
                                        <span class="originals" id="tbl_sel_category">{{ $items->item_category }}-{{ $items->item_name }} {{ $items->item_subcategory }}</span>
                                    </td>
                                    <td>
                                        <span class="originals">{{ $items->descripcion_details }}</span>
                                    </td>
                                    <td>
                                        <span class="originals">{{ $items->price }}</span>
                                    </td>
                                    <td>
                                        <span class="originals">{{ $items->cant }}</span>
                                    </td>
                                    <td>
                                        {{ $items->price * $items->cant }}
                                    </td>
                                    {{--<td>
                                        <button class="btn btn-danger" name="{{ $items->id }}" type="button" id="eliminar">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                    </td>--}}
                                </tr>
                            @endforeach


                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="6" style="text-align:right">Total($): {{ $totalFinal }}</th>
                                <th id="total_app"></th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>


                    <!-- /.row -->

                    <!-- this row will not appear when printing -->
                    <div class="row no-print" style="padding-top: 20px;">
                        <div class="col-xs-12">
                        </div>
                    </div>
                    <input type='submit' class='btn btn-primary' value='{{ trans('crudbooster.save') }}'/>

                </section>
                <!-- /.content -->
                <div class="clearfix"></div>
            </div>

        </div>

        </div>

        </form>
    </div>




@endsection