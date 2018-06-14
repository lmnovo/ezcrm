@extends('crudbooster::admin_template')
@section('content')

    <script src='http://127.0.0.1:8000/p/jquery-ui.custom.min.js'></script>
    <script src="http://127.0.0.1:8000/p/jquery.ui.touch-punch.min.js"></script>
    <script src="http://127.0.0.1:8000/p/chosen.jquery.min.js"></script>
    <script src="http://127.0.0.1:8000/p/spinbox.min.js"></script>
    <script src="http://127.0.0.1:8000/p/bootstrap-datepicker.min.js"></script>
    {{--<script src="http://127.0.0.1:8000/p/bootstrap-timepicker.min.js"></script>--}}
    <script src="http://127.0.0.1:8000/p/moment.min.js"></script>
    <script src="http://127.0.0.1:8000/p/daterangepicker.min.js"></script>
    <script src="http://127.0.0.1:8000/p/bootstrap-datetimepicker.min.js"></script>
    <script src="http://127.0.0.1:8000/p/bootstrap-colorpicker.min.js"></script>
    <script src="http://127.0.0.1:8000/p/jquery.knob.min.js"></script>
    <script src="http://127.0.0.1:8000/p/autosize.min.js"></script>
    <script src="http://127.0.0.1:8000/p/jquery.inputlimiter.min.js"></script>
    <script src="http://127.0.0.1:8000/p/bootstrap-tag.min.js"></script>

    <!-- ace scripts -->
    <script src="http://127.0.0.1:8000/p/ace-elements.min.js"></script>
    <script src="http://127.0.0.1:8000/p/ace.min.js"></script>

    <script>
        $(document).ready(function()
        {

            $('#newApplianceModal').on('click','#edit_category_new',function(){
                $('#newCategoryApplianceModal').modal('show');
                $('#newApplianceModal').modal('hide');

            });


            $("body").on("click",".upload-image",function(e){
                $(this).parents("form").ajaxForm(options);
            });

            var options = {
                complete: function(response)
                {
                    if($.isEmptyObject(response.responseJSON.error)){
                        $("input[name='title']").val('');
                        alert('Image Upload Successfully.');
                    }else{
                        printErrorMsg(response.responseJSON.error);
                    }
                }
            };

            function printErrorMsg (msg) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display','block');
                $.each( msg, function( key, value ) {
                    $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                });
            }


            var td,campo,valor,id;
            $(document).on("click","td.editable span",function(e)
            {
                e.preventDefault();
                $("input:not(#id)").removeClass("editable");
                td=$(this).closest("td");
                campo=$(this).closest("td").data("campo");
                valor=$(this).text();
                id=$(this).closest("tr").find("#id").val();
                td.text("").html("<input type='text' name='"+campo+"' value='"+valor+"'>" +
                    "<a class='enlace guardar' href='#'><i class=\"fa fa-check-circle\"></i></a> " +
                    "<a class='enlace cancelar' href='#'><i class=\"fa fa-times-circle\"></i></a>")
                ;
            });

            $(document).on("click",".cancelar",function(e)
            {
                e.preventDefault();
                td.html("<span>"+valor+"</span>");
                $("input:not(#id)").addClass("editable");
            });

            $(document).on("click",".guardar",function(e)
            {
                e.preventDefault();
                nuevovalor=$(this).closest("td").find("input").val();
                $.ajax({
                    type: "GET",
                    url: "../editquote",
                    data: { campo: campo, valor: nuevovalor, id: id }
                })
                .done(function( msg ) {
                    $('#total_appliance').html(nuevovalor * $('#price_appliance').text());
                    td.html("<span>"+nuevovalor+"</span>");
                    $("td:not(#id)").addClass("editable");
                    window.location.href = 'http://127.0.0.1:8000/crm/orders/edit/'+msg;
                });
            });

        });
    </script>

    <!-- Your html goes here -->
        <div class='panel panel-default'>
        <div class='panel-heading' style="background-color: #337ab7; color: white;">
            <strong><i class="fa fa-shopping-bag"></i> {{trans('crudbooster.basic_information')}} </strong>
        </div>
        <div class='panel-body'>


            <?php
            $action = CRUDBooster::mainpath("editsave");
            $return_url = ($return_url)?:g('return_url');
            ?>

            <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>

                <input type="hidden" id="quote_id" name="quote_id" value="{{ $id }}">
                <input type="hidden" id="applianceitem_1" name="applianceitem_1" value="">
                <input type="hidden" id="applianceitem_2" name="applianceitem_2" value="">
                <input type="hidden" id="applianceitem_3" name="applianceitem_3" value="">
                <input type="hidden" id="applianceitem_4" name="applianceitem_4" value="">
                <input type="hidden" id="applianceitem_5" name="applianceitem_5" value="">
                <input type="hidden" id="applianceitem_6" name="applianceitem_6" value="">
                <input type="hidden" id="applianceitem_7" name="applianceitem_7" value="">
                <input type="hidden" id="applianceitem_8" name="applianceitem_8" value="">
                <input type="hidden" id="applianceitem_9" name="applianceitem_9" value="">
                <input type="hidden" id="applianceitem_10" name="applianceitem_10" value="">
                <input type="hidden" id="applianceitem_11" name="applianceitem_11" value="">
                <input type="hidden" id="applianceitem_12" name="applianceitem_12" value="">
                <input type="hidden" id="applianceitem_13" name="applianceitem_13" value="">
                <input type="hidden" id="applianceitem_14" name="applianceitem_14" value="">
                <input type="hidden" id="applianceitem_15" name="applianceitem_15" value="">
                <input type="hidden" id="applianceitem_16" name="applianceitem_16" value="">
                <input type="hidden" id="applianceitem_17" name="applianceitem_17" value="">
                <input type="hidden" id="applianceitem_18" name="applianceitem_18" value="">
                <input type="hidden" id="applianceitem_19" name="applianceitem_19" value="">
                <input type="hidden" id="applianceitem_20" name="applianceitem_20" value="">
                <input type="hidden" id="applianceitem_21" name="applianceitem_21" value="">
                <input type="hidden" id="applianceitem_22" name="applianceitem_22" value="">
                <input type="hidden" id="applianceitem_23" name="applianceitem_23" value="">
                <input type="hidden" id="applianceitem_24" name="applianceitem_24" value="">
                <input type="hidden" id="applianceitem_25" name="applianceitem_25" value="">
                <input type="hidden" id="applianceitem_26" name="applianceitem_26" value="">
                <input type="hidden" id="applianceitem_27" name="applianceitem_27" value="">
                <input type="hidden" id="applianceitem_28" name="applianceitem_28" value="">
                <input type="hidden" id="applianceitem_29" name="applianceitem_29" value="">
                <input type="hidden" id="applianceitem_30" name="applianceitem_30" value="">

                <input type="hidden" id="send_email" name="send_email" value="">

                <div class="row">
                    <div class='col-sm-4'>
                        <label>{{trans('crudbooster.Business_Name')}}*</label>
                        <input type='text' name='business_name' required class='form-control' value="{{ $quotes->truck_name }}"/>
                    </div>

                    <div class='col-sm-2'>
                        <label>
                            {{trans('crudbooster.interested_in')}}?*
                            <span class="fa fa-info-circle" style="cursor:pointer;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{trans('crudbooster.interested_in_tooltip')}}"></span>
                        </label>

                        <select class="form-control" id="interesting" placeholder="Select" name="interesting" required>
                            <option selected="true">**Select Data**</option>
                                @foreach($products_type as $type)
                                    @if($type->id == $interested->id)
                                            <option selected="true" value="{{ $type->id }}" id="{{ $type->id }}">{{ $type->type }}</option>;
                                        @else
                                            <option value="{{ $type->id }}" id="{{ $type->id }}">{{ $type->type }}</option>;
                                    @endif
                                @endforeach
                        </select>
                    </div>

                    <div class='col-sm-2'>
                        <label>{{trans('crudbooster.type')}}*</label>
                        <select class="form-control" id="types" placeholder="Select" required name="types">
                            {{--<option value="{{ $state->id }}" id="{{ $state->id }}">{{ $state->estado }}</option>--}}
                            <option selected="true">**Select Data**</option>
                            @if($state->id == 0)
                                @if($interested->id == 2)
                                    <option selected="true" value="3" id="3">NEW</option>;
                                @endif
                            @else
                                @if($interested->id == 2 || $interested->id == 3)
                                    <option selected="true" value="3" id="3">NEW</option>;
                                @else
                                    @foreach($state_list as $item)
                                        @if($item->id == $state->id)
                                            <option selected="true" value="{{ $item->id }}" id="{{ $item->id }}">{{ $item->estado }}</option>;
                                        @else
                                            <option value="{{ $item->id }}" id="{{ $item->id }}">{{ $item->estado }}</option>;
                                        @endif
                                    @endforeach
                                @endif
                            @endif

                        </select>
                    </div>

                    <div class='col-sm-2'>
                        <label>{{trans('crudbooster.size')}}*</label>
                        <select class="form-control" id="sizes" placeholder="Select" required name="sizes">
                            {{--<option value="{{ $size->id }}" id="{{ $size->id }}">{{ $size->size }}</option>--}}
                            <option selected="true">**Select Data**</option>
                            @foreach($sizes_list as $item)
                                @if($item->id == $size->id)
                                    <option selected="true" value="{{ $item->id }}" id="{{ $item->id }}">{{ $item->size }}</option>;
                                @else
                                    <option value="{{ $item->id }}" id="{{ $item->id }}">{{ $item->size }}</option>;
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class='col-sm-2'>
                        <label>{{trans('crudbooster.starting_with')}}*</label>
                        <input type='text' name='starting' id='starting' required class='form-control' value="<?php echo !$quotes->price_item == 0 ? $quotes->price_item : "0.00" ?>"/>
                    </div>

                </div>

        </div>

    </div>



    <div id="loading"></div>

        <div class='panel panel-default'>
        <div class='panel-heading' style="background-color: #337ab7; color: white;">
            <strong>

                <a class="btn btn-primary" style="color: white !important;" href='{{CRUDBooster::adminpath("account/detail/$account")}}'><i class="fa fa-user"></i> <strong>{{trans('crudbooster.lead_information')}}</strong></a>
            </strong>
        </div>
        <div class='panel-body'>

                <div class="row">
                    <div class='col-sm-4'>
                        <label>{{trans('crudbooster.name')}}*</label>
                        <input type='text' name='name' required class='form-control' value="{{ $customer[0]->name }}"/>
                    </div>

                    <div class='col-sm-4'>
                        <label>{{trans('crudbooster.lastname')}}*</label>
                        <input type='text' name='lastname' required class='form-control' value="{{ $customer[0]->lastname }}"/>
                    </div>

                    <div class='col-sm-4'>
                        <label>{{trans('crudbooster.email')}}*</label>
                        <input type='text' name='email' required class='form-control' value="{{ $customer[0]->email }}"/>
                    </div>
                </div>

                <div class="row" style="padding-top: 10px;">
                    <div class='col-sm-4'>
                        <label>{{trans('crudbooster.phone')}}*</label>
                        <input type='text' name='phone' required class='form-control' value="{{ $customer[0]->telephone }}"/>
                    </div>

                    <div class='col-sm-8'>
                        <label>{{trans('crudbooster.state')}}*</label>
                        <select class="form-control" id="state" placeholder="Select" name="state" required>
                            <option selected="true">**Select Data**</option>
                            @foreach($states_list as $state_item)
                                @if($states->abbreviation == $state_item->abbreviation)
                                    <option selected="true" value="{{ $state_item->abbreviation }}" id="{{ $state_item->id }}">{{ $state_item->name }}</option>;
                                @else
                                    <option value="{{ $state_item->abbreviation }}" id="{{ $state_item->id }}">{{ $state_item->name }}</option>;
                                @endif
                            @endforeach
                        </select>
                    </div>

                </div>

        </div>
    </div>

        <div class='panel panel-default'>
        <div class='panel-heading' style="background-color: #337ab7; color: white;">
            <strong><i class="fa fa-product-hunt"></i> {{trans('crudbooster.buildout')}}  </strong>
        </div>

            <div class="row">
                <div class='col-sm-4'>
                    <button id="newBuildout" style="margin-left: 20px; margin-top: 20px;" class="btn btn-success pull-left" type="button" ><i class="fa fa-bars"></i> {{trans('crudbooster.add_buildout')}} </button>
                </div>
            </div>
            <div class='panel-body'>


                <div class="row">
                    <div class='col-sm-4'>
                        <label>{{trans('crudbooster.buildout')}}*</label>
                        <select class="form-control" id="buildout_name" placeholder="Select" required name="buildout_name">
                            {{--<option value="{{ $buildout[0]->id }}" id="{{ $buildout[0]->id }}">{{ $buildout[0]->buildout_name }}</option>--}}
                            @foreach($buildout_list as $item)
                                @if($item->id == $buildout[0]->id)
                                    <option selected="true" value="{{ $item->id }}" id="{{ $item->id }}">{{ $item->nombre }}</option>;
                                @else
                                    <option value="{{ $item->id }}" id="{{ $item->id }}">{{ $item->nombre }}</option>;
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class='col-sm-2'>
                        <label>{{trans('crudbooster.price')}}</label>
                        <input type='text' id='buildout_price' name='buildout_price' required class='form-control' value="{{ $quotes->precio }}"/>
                    </div>

                    <div class='col-sm-6'>
                        <label>{{trans('crudbooster.description')}}</label>
                        <textarea id='buildout_description' name='buildout_description' contenteditable="true" class='form-control wysiwyg'>{{ $quotes->desc_buildout }}</textarea>
                    </div>
                </div>

                <div class="row">

                </div>

        </div>
    </div>

        <div class='panel panel-default'>
        <div class='panel-heading' style="background-color: #337ab7; color: white;">
            <strong><i class="fa fa-product-hunt"></i> {{trans('crudbooster.accessories_selection')}} </strong>
        </div>
        <button id="new" style="margin-left: 20px; margin-top: 20px;" class="btn btn-success pull-left" type="button" ><i class="fa fa-bars"></i> {{trans('crudbooster.add_appliance')}} </button>

        <div id="table_accessories" class="table-responsive hover" style="margin: 70px;">
            <table id="accesorios" class="table table-striped table-responsive table-bordered" cellspacing="0">
                <thead>
                <tr>
                    <th>{{trans('crudbooster.category')}}</th>
                    <th>{{trans('crudbooster.appliance')}}</th>
                    <th>{{trans('crudbooster.detail')}}</th>
                    <th>{{trans('crudbooster.description')}}</th>
                    <th>{{trans('crudbooster.price')}}</th>
                    <th>{{trans('crudbooster.quantity')}}</th>
                    <th >Total</th>
                    <th >{{trans('crudbooster.action')}}</th>
                </tr>
                </thead>
                <tbody >

                    @foreach($orders_detail as $items)
                        <tr role="row" class="odd">
                            <input id='id' type="hidden" value="{{ $items->id }}"/>
                            <td class="sorting_1">
                                <span class="originals" id="tbl_sel_category">{{ $items->item_category }}</span>
                            </td>
                            <td>
                                <span class="originals" id="tbl_sel_appliance">{{ $items->item_name }}</span>
                            </td>
                            <td>
                                <span class="originals" id="tbl_sel_subcategory">{{ $items->item_subcategory }}</span>
                            </td>
                            <td>
                            <span class="originals">{{ $items->descripcion_details }}</span>
                            </td>
                            <td>
                                <span id="price_appliance" class="originals">{{ $items->price }}</span>
                            </td>
                            <td class='editable' data-campo='cant'><span>{{ $items->cant }}</span></td>
                            <td id="total_appliance">
                                {{ $items->cant * $items->price }}
                            </td>
                            <td>
                                <button class="btn btn-danger" name="{{ $items->id }}" type="button" id="eliminar">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th colspan="6" style="text-align:right">Total($): </th>
                    <th id="total_app"></th>
                    <th></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

        <div class='panel panel-default'>
            <div class='panel-heading' style="background-color: #337ab7; color: white;">
                <strong><i class="fa fa-product-hunt"></i> {{trans('crudbooster.total_summary')}} </strong>
            </div>
            <div class="panel-body">

                <div class="row" style="padding-top: 15px;">
                    <div class="col-sm-5">
                        <label for="resumen_truck"  id="label_item">{{trans('crudbooster.mobile_unit')}}</label>

                        <input class="form-control" id="resumen_truck" name="resumen_truck"  readonly="" value="<?php echo !$quotes->price_item == 0 ? $quotes->price_item : "0.00" ?>"/>
                    </div>
                    <div class="col-sm-5">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="check_item" <?php if(isset($quotes->price_item)) echo ($quotes->price_item > 0) ? "checked=''" : ""?>    ><label style="color:#45b5b9;font-style: italic;">{{trans('crudbooster.message_select_truck')}}</label>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top: 15px;">
                    <div class="col-md-6">
                        <label for="taxitem" >{{trans('crudbooster.mobile_unit_tax')}}</label>

                        <input class="form-control" id="taxitem" name="taxitem"  readonly="" value="<?php echo !$quotes->tax_item ?  $quotes->tax_item : "0.00"?>"/>
                    </div>
                </div>

                <div class="row" style="padding-top: 15px;">
                    <div class="col-md-6">
                        <label for="resumen_buildout">{{trans('crudbooster.buildout')}}</label>
                        <input class="form-control" id="resumen_buildout" name="resumen_buildout" readonly="" value="<?php echo isset($quotes->precio) ? $quotes->precio : "0.00" ?>"/>
                    </div>

                    <div class="col-md-6">
                        <label for="resumen_buildout">{{trans('crudbooster.buildout_tax')}}</label>
                        <input class="form-control" id="taxbuildout" name="taxbuildout" readonly="" value="<?php echo (isset($quotes->taxappliace)) ? $quotes->truck_tax - $quotes->taxappliace : "0.00" ?>" />
                    </div>
                </div>

                <div class="row" style="padding-top: 15px;">
                    <div class="col-md-6">
                        <label for="resumen_appliance">{{trans('crudbooster.appliance')}}</label>
                        <input class="form-control" id="resumen_appliance" name="resumen_appliance" readonly="" value="0.00"/>
                    </div>
                    <div class="col-md-6">
                        <label for="resumen_appliance">{{trans('crudbooster.appliance_tax')}}</label>
                        <input class="form-control" id="taxappliance" name="taxappliance" readonly="" value="<?php echo (isset($quotes->taxappliace)) ? $quotes->taxappliace : "0.00" ?>" />
                    </div>
                </div>

                <div class="row" style="padding-top: 15px;">
                    <div class="col-md-12">
                        <label  for="">{{trans('crudbooster.description')}}</label>
                        <textarea type="text" class="form-control" id="descriptionquote" name="descriptionquote" placeholder="Description"  value="" ><?php if(isset($quotes->description)) echo $quotes->description?></textarea>
                    </div>
                </div>

                <div class="row" style="padding-top: 15px;">
                    <div class="col-md-6">
                        <label id="label_item" for="budget">{{trans('crudbooster.discount')}}</label>
                        <input type="text" class="form-control" id="discount" name="discount"  value="<?php echo (isset($quotes->discount)) ? $quotes->discount : "0.00"?>" placeholder="Discount" required >
                    </div>
                    <div class="col-md-6">
                        <label for="gtotalquote" >{{trans('crudbooster.subtotal_quote_value')}}</label>
                        <input class="form-control" id="subtotal_without_tax" name="subtotal_without_tax" readonly="" value="0.00"/>
                    </div>
                </div>

                <div class="row" style="padding-top: 15px;">
                    <div class="col-md-6">
                        <label for="registration" >{{trans('crudbooster.registration')}}</label>

                        <div class="input-group">
                            <input class="form-control" id="registration" value="<?php echo (isset($quotes->registration)) ? $quotes->registration : "0.00" ?>" name="registration" placeholder="Registration" readonly="" >
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="edit_registration"><span class="glyphicon glyphicon-edit"></span></button>
                                <button class="btn btn-default" type="button" id="save_registration" style="display: none;"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="check" <?php if(isset($quotes->registration))  echo ($quotes->registration > 0) ? "checked='checked'" : ""?>><label style="color:#45b5b9;font-style: italic;">Optional plates registration</label>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top: 15px;">

                    <div class="col-md-6">
                        <label for="tax"  id="label_item">{{trans('crudbooster.total_tax')}}</label>
                        <input class="form-control" id="tax" name="tax"  readonly="" value="<?php if(isset($quotes->truck_tax)) echo $quotes->truck_tax?>"/>
                    </div>
                    <div class="col-md-6">
                        <label for="gtotalquote" >{{trans('crudbooster.total_quote_value')}}</label>
                        <input class="form-control" id="gtotalquote" name="gtotalquote" readonly="" value="0.00"/>
                    </div>
                </div>
            </div>

        </div>

        <div class='panel panel-default'>
            <div class='panel-heading' style="background-color: #337ab7; color: white;">
                <strong><i class="fa fa-user"></i> {{trans('crudbooster.financing')}} </strong>
            </div>
            <div class='panel-body'>

                <div class="row">
                    <div class='col-sm-4'>
                        <label>{{trans('crudbooster.what_is_your_budget')}}?*</label>
                        <input type='text' name='budget' required class='form-control' value="<?php echo (!empty($quotes->truck_budget)) ? $quotes->truck_budget : "0.00"?>"/>
                    </div>

                    <div class='col-sm-4'>
                        <label>{{trans('crudbooster.downpayment')}}</label>
                        <input type='text' name='downpayment' required class='form-control' value="<?php echo (isset($quotes->downpayment)) ? $quotes->downpayment : "0.00" ?>"/>
                    </div>

                    <div class='col-sm-4'>
                        <label>{{trans('crudbooster.how_soon_you_need_it')}}?*</label>
                        <input type='text' name='date_limit' required id='date_limit' required class='form-control' value="<?php if(isset($date_limit)) echo $date_limit ?>"/>
                    </div>
                </div>

                <div class="row" style="padding-top: 10px;">
                    <div class='col-sm-4'>
                        <label>{{trans('crudbooster.need_financing')}}?*</label>

                        <select class="form-control" id="financing" placeholder="Select" name="financing" required>
                            @if($quotes->financing == null)
                                <option value="No" id="No">No</option>;
                                <option value="Yes" id="Yes">{{trans('crudbooster.yes')}}</option>;
                            @elseif($quotes->financing == "No")
                                <option selected="true" value="{{ $quotes->financing }}" id="{{ $quotes->financing }}">{{ $quotes->financing }}</option>;
                                <option value="Yes" id="Yes">{{trans('crudbooster.yes')}}</option>;
                            @elseif($quotes->financing == "Yes")
                                <option selected="true" value="{{ $quotes->financing }}" id="{{ $quotes->financing }}">{{ $quotes->financing }}</option>;
                                <option value="No" id="No">No</option>;
                            @endif
                        </select>
                    </div>

                    <div class="col-md-3" role="alert" id="alerta" style="display: none;">
                        <label>&nbsp;</label>
                        <a class="btn btn-success form-control" title="{{trans('crudbooster.apply_now')}}" href="https://providencecapitalfunding.com/chef-units/" target="_blank"><strong> APPLY NOW </strong></a>
                    </div>

                </div>

            </div>
        </div>


        <div class='panel panel-default'>
            <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-file-text-o"></i> {{trans('crudbooster.Notes')}}</strong></div>
            <div class='panel-body'>
                <?php
                if(count($notes) == 0) {
                echo "<div style='text-align: center; color: red; padding-bottom: 20px;'><i class='fa fa-search'></i>";?> {{ trans('crudbooster.table_data_not_found') }}  <?php echo "</div>";
                }
                ?>

                @foreach($notes as $note)
                    <div class="row invoice-info" style="padding-left: 20px; padding-top: 15px;">
                        <div class="col-sm-8 invoice-col">
                            {{--<div style="background-color: #f5f5f5;"><strong>Note {{ $note->id }}</strong></div>--}}
                            <div>{{ $note->name }}</div>
                            <div class="row">
                                <div  class="col-sm-3" style="padding-top: 5px;"><i class="fa fa-clock-o"></i> {{ $note->created_at }}</div>
                                <div  class="col-sm-1" style="padding-top: 5px;">
                                    <a class="btn btn-xs btn-warning btn-delete" title="{{trans('crudbooster.delete')}}" href="javascript:;" onclick="swal({
                                            title: '{{trans('crudbooster.are_you_sure')}}',
                                            text: '{{trans('crudbooster.message_delete')}}',
                                            type: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#ff0000',
                                            confirmButtonText: '{{trans('crudbooster.yes')}}',
                                            cancelButtonText: '{{trans('crudbooster.no')}}',
                                            closeOnConfirm: false },
                                            function(){  location.href='http://127.0.0.1:8000/crm/notes_quotes/delete/{{ $note->id }}' });"><i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="row" style="padding-left: 20px; padding-top: 20px; padding-bottom: 20px;">
                    <input type="hidden" id="note_quotes_id" value="{{ $id }}">
                    <div class="col-md-6">
                        <textarea class="form-control" type="text" id="note_value" name="note_value" rows="3" value=""> </textarea>
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="add_note" class="btn btn-xl btn-danger" >{{trans('crudbooster.add_note')}}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label for="gtotalquote"><span style="color: red;">* {{trans('crudbooster.message_save_quote')}}</span></label>
            </div>
        </div>

        <div class='panel-footer'>
            <button type="submit" title="{{trans('crudbooster.save')}}" class="btn btn-primary"><i class="fa fa-save"></i></button>
            <button type="submit" id="check_send_email" title="{{trans('crudbooster.save_and_submit')}}" class="btn btn-primary"><i class="fa fa-envelope"></i></button>
            <a class="btn btn-yahoo" title="{{trans('crudbooster.create_invoice')}}" style="margin: 2px" href="{{CRUDBooster::mainpath("create-invoice/$id")}}"><i class="fa fa-hand-o-right"></i> </a>
            <a title="{{trans('crudbooster.send_email')}}" id="send-email-personal" class="btn btn-success" style="margin: 2px" href="#"><i class="fa fa-envelope-o"></i></a>
            <a title="{{trans('crudbooster.print')}}" class='btn btn-danger' href='{{CRUDBooster::adminPath("orders/print-quote/$id")}}'><i class="fa fa-print"></i></a>
        </div>

        </form>

    </div>


    <div class="modal fade" id="modal-loading">
        <div class="modal-dialog">
            <div class="modal-body">
                <img style="width: 64px;" src="<?php echo e(asset('assets/images/loading.gif')); ?>" alt="Loading">
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="success-sendEmailPersonal">
        <div class="modal-dialog modal-lg" style="width: 35%"  role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('crudbooster.title_success_send_email_quote')}}</h4>
                </div>
                <form id="form_envioquote" action="" method="post" class="form-horizontal">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group">
                                {{trans('crudbooster.title_success_sent_email_quote')}}
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('crudbooster.close')}}</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="failed-sendEmailPersonal">
        <div class="modal-dialog modal-lg" style="width: 35%"  role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('crudbooster.title_success_send_email_quote')}}</h4>
                </div>
                <form id="form_envioquote" action="" method="post" class="form-horizontal">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group">
                                {{trans('crudbooster.email_send_text_error')}}
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('crudbooster.close')}}</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="modal-sendEmailPersonal">
        <div class="modal-dialog modal-lg" role="document" style="width: 70%">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('crudbooster.title_send_email_quote')}}</h4>
                </div>
                <form id="form_envioquote" action="" method="post" class="form-horizontal">
                    <div class="modal-body">
                        <div class="container-fluid">


                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">{{trans('crudbooster.email')}}</label>

                                <div class="col-sm-9">
                                    <div class="inline">
                                        <input type="text" id="form-tag-to" value="{{ $customer[0]->email }}" placeholder="{{trans('crudbooster.text_email')}}" />
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('crudbooster.close')}}</button>
                        <button type="button" class="btn btn-primary" id="sendMail">{{trans('crudbooster.send')}}</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="applianceModal" style="position: relative;" >
        <div class="modal-dialog modal-lg" role="document"  style=" width: 90%">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('crudbooster.appliance_creation')}}</h4>
                </div>

                <form id="form_product" data-parsley-validate  action="" method="post" class="form-horizontal">

                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="appliance" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.category')}}</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="appliance" name="appliance" placeholder="Select" style="width: 100%" required="required">
                                        </select>
                                    </div>
                                    {{--<div class="col-md-1">
                                        <a href="{{CRUDBooster::adminpath("appliances_categories/add")}}" target="_blank" title="Add Category" id="" class="btn btn-success btn-sm">
                                            <i class="fa fa-plus-circle"></i>
                                        </a>
                                    </div>--}}
                                </div>

                                <div class="form-group">
                                    <label for="product" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.appliance')}}</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="product" name="product" placeholder="Select" style="width: 100%" required>
                                        </select>
                                    </div>
                                    {{--<div class="col-md-1">
                                        <a href="{{CRUDBooster::adminpath("appliances_inside/add")}}" target="_blank" title="Add Appliance" id="" class="btn btn-success btn-sm">
                                            <i class="fa fa-plus-circle"></i>
                                        </a>
                                    </div>--}}
                                </div>

                                <div class="form-group">
                                    <label for="appliance_inside_category" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.detail')}}</label>
                                    <div class="col-md-9">
                                        <select required class="form-control" id="appliance_inside_category" name="appliance_inside_category" placeholder="Select" style="width: 100%" >

                                        </select>
                                    </div>
                                    {{--<div class="col-md-1">
                                        <a href="{{CRUDBooster::adminpath("appliances/add")}}" target="_blank" title="Add Details" id="" class="btn btn-success btn-sm">
                                            <i class="fa fa-plus-circle"></i>
                                        </a>
                                    </div>--}}
                                </div>

                                <div class="form-group">
                                    <label for="description" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.description')}}</label>
                                    <div class="col-md-9 col-xs-12 col-sm-9">
                                        <textarea rows="6" class="form-control" id="description" placeholder="{{trans('crudbooster.description')}}" readonly="true"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="price2" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.price')}}</label>
                                    <div class="col-md-9 col-xs-12 col-sm-9">
                                        <div class="input-group">
                                            <input class="form-control number" id="price2" name="price2"  placeholder="{{trans('crudbooster.price')}}" type="text" required disabled/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" id="edit_precio"><span class="glyphicon glyphicon-edit"></span></button>
                                                <button class="btn btn-default" type="button" id="save_precio" style="display: none;"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="price2" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.retail_price')}}</label>
                                    <div class="col-md-9 col-xs-12 col-sm-9">
                                        <div class="input-group">
                                            <input class="form-control number" id="price2_retail" name="price2_retail"  placeholder="{{trans('crudbooster.retail_price')}}" type="text" required disabled/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" id="edit_precio_retail"><span class="glyphicon glyphicon-edit"></span></button>
                                                <button class="btn btn-default" type="button" id="save_precio_retail" style="display: none;"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="quantity" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.quantity')}}</label>
                                    <div class="col-md-9 col-xs-12 col-sm-9">
                                        <input class="form-control int" id="quantity" name="quantity" placeholder="{{trans('crudbooster.quantity')}}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="total" class="col-md-3 col-xs-12 col-sm-3 control-label">Total</label>
                                    <div class="col-md-9 col-xs-12 col-sm-9">
                                        <input class="form-control" id="total" name="total" placeholder="Total" readonly="true" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <img id="imagen" src="" class="img-responsive"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">{{trans('crudbooster.close')}}</button>
                        <button type="button" class="btn btn-success " id="addNew">{{trans('crudbooster.new')}}</button>
                        <button type="button" class="btn btn-primary " id="addSave">{{trans('crudbooster.add')}}</button>
                    </div>

                </form>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="newApplianceModal" style="position: relative;">
        <div class="modal-dialog modal-lg" role="document"  style=" width: 90%">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('crudbooster.appliance_creation_new')}}</h4>
                </div>

                {!! Form::open(array('route' => 'ajaxImageUpload','enctype' => 'multipart/form-data', 'class' => 'form-horizontal')) !!}

                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="appliance" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.category')}}</label>
                                    <div class="col-md-8">
                                        <select required class="form-control" id="appliance_new" name="appliance" placeholder="Select" style="width: 100%" >
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <a title="" id="edit_category_new" class="btn btn-success btn-sm">
                                            <i class="glyphicon glyphicon-edit"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="product" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.appliance')}}</label>
                                    <div class="col-md-8">
                                        <select required class="form-control" id="product_new" name="product_new" placeholder="Select" style="width: 100%" >
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="#" title="" id="edit_appliance_new" class="btn btn-success btn-sm">
                                            <i class="glyphicon glyphicon-edit"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="appliance_inside_category" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.detail')}}</label>
                                    <div class="col-md-8">
                                        <input required class="form-control number" id="appliance_inside_category_new" name="appliance_inside_category_new"  placeholder="{{trans('crudbooster.detail')}}" type="text"/>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.description')}}</label>
                                    <div class="col-md-9 col-xs-12 col-sm-9">
                                        <textarea required rows="6" class="form-control" id="description_new" placeholder="{{trans('crudbooster.description')}}"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="price2" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.cost')}}</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input required class="form-control number" id="price2_new" name="price2_new"  placeholder="{{trans('crudbooster.cost_price')}}" type="text"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="price2" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.retail_price')}}</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input required class="form-control number" id="price2_retail_new" name="price2_retail_new"  placeholder="{{trans('crudbooster.retail_price')}}" type="text"/>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="weight_new" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.weight')}}</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input class="form-control number" id="weight_new" name="weight_new"  placeholder="{{trans('crudbooster.weight')}}" value="0" type="text"/>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-5">
                                    {!! Form::file('image', array('class' => 'image', 'required')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">{{trans('crudbooster.close')}}</button>
                        <button type="submit" class="btn btn-primary" id="">{{trans('crudbooster.save')}}</button>
                    </div>

                {!! Form::close() !!}

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="newCategoryApplianceModal">
        <div class="modal-dialog modal-lg" role="document"  style=" width: 90%">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('crudbooster.category_creation_new')}}</h4>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="col-md-7">
                            <form id="form_product" data-parsley-validate  action="" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label for="category_category_name" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.category')}}</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input class="form-control number" id="category_category_name" name="category_category_name"  placeholder="{{trans('crudbooster.category')}}" type="text"/>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" id="closeCategoryCategory">{{trans('crudbooster.close')}}</button>
                    <button type="submit" class="btn btn-primary" id="addCategoryCategory">{{trans('crudbooster.save')}}</button>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="newSubCategoryApplianceModal">
        <div class="modal-dialog modal-lg" role="document"  style=" width: 90%">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('crudbooster.subcategory_creation_new')}}</h4>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="col-md-7">
                            <form id="form_product" data-parsley-validate  action="" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label for="appliance" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.category')}}</label>
                                    <div class="col-md-8">
                                        <select class="form-control" id="appliance_subcategory" name="appliance_subcategory" placeholder="Select" style="width: 100%" required="required">
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="category_category_name" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.subcategory')}}</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input class="form-control number" id="subcategory_name" name="subcategory_name"  placeholder="{{trans('crudbooster.subcategory')}}" type="text"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" id="closeSubCategory">{{trans('crudbooster.close')}}</button>
                    <button type="submit" class="btn btn-primary" id="addSubCategory">{{trans('crudbooster.save')}}</button>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="Build_OutGModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('crudbooster.buildout_creation')}}</h4>
                </div>


                <form id="form_builout" action="" method="post" class="form-horizontal">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group">
                                <label for="price2" class="col-md-3 col-sm-3 col-xs-12 control-label">Name*</label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <input required class="form-control" id="nombreba" name="nombreba"  placeholder="Name" type="text" />
                                    <input class="form-control" id="id_buil_out" name="id_buil_out" type="hidden" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-md-3 col-sm-3 col-xs-12 control-label">Description</label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <div id="descriptionba" class="summernote"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price2" class="col-md-3 col-sm-3 col-xs-12 control-label">Price*</label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <input required class="form-control" id="price2ba" name="price2ba"  placeholder="Price"  type="text" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('crudbooster.close')}}</button>
                        <button type="button" class="btn btn-primary " id="savebuilout">{{trans('crudbooster.add')}}</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>



@endsection