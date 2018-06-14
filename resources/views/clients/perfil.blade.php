<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')

    <script>
        $(document).ready(function()
        {
            var td,campo,valor,id,id_user;
            var datos = '';
            $(document).on("click","td.editable .edit_button",function(e)
            {
                e.preventDefault();
                $("input:not(#id)").removeClass("editable");
                td=$(this).closest("td");
                campo=$(this).closest("td").data("campo");
                id_user=$('#id_user').val();
                id_client=$('#id_lead').val();
                valor=$('td.editable a').text();
                id=$(this).closest("tr").find("#id").val();

                //Reiniciamos el listado de users para el select
                datos = '';

                //Obtener el listado de usuarios existentes en bd
                $.ajax({
                    type: "GET",
                    url: "../users",
                    data: { campo: campo, valor: nuevovalor, id: id }
                })
                    .done(function(data) {
                        for(var i=0;i<data.length;i++)
                        {
                            if (valor == data[i].name) {
                                datos += '<option selected="true" value='+data[i].id+' >'+data[i].name+'</option>';
                            } else {
                                datos += '<option value='+data[i].id+' >'+data[i].name+'</option>';
                            }
                        }
                        td.text("").html("" +
                            "<select class='form-control' id='cms_users' name='"+campo+"' placeholder='Select' required>"
                            + datos +
                            "</select>" +
                            " <a class='enlace guardar' href='#'><i class=\"fa fa-check-circle\"></i></a> " +
                            "<a class='enlace cancelar' href='#'><i class=\"fa fa-times-circle\"></i></a>");
                    });


            });

            $(document).on("click",".cancelar",function(e)
            {
                e.preventDefault();
                td.html("<a href=http://127.0.0.1:8000/crm/users/detail/"+id_user+">"+valor+"</a> <span title='{{trans('crudbooster.edit')}}' class=\"edit_button\"><i class=\"fa fa-edit\"></i></span>");
                $("input:not(#id)").addClass("editable");
            });

            var nuevovalor;
            $(document).on("click",".guardar",function(e)
            {
                e.preventDefault();
                nuevovalor=$('#cms_users').val();
                $.ajax({
                    type: "GET",
                    url: "../edituser",
                    data: { campo: campo, valor: nuevovalor, id_user: id_user, id_client: id_client }
                })
                    .done(function( data ) {
                        td.html("<a href=http://127.0.0.1:8000/crm/users/detail/"+nuevovalor+">"+data+"</a> <span title='{{trans('crudbooster.edit')}}' class=\"edit_button\"><i class=\"fa fa-edit\"></i></span>");
                    });
            });

        });
    </script>

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
        <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-users"></i> {{ trans('crudbooster.Client_Profile') }}</strong></div>

        <div class="panel-body" style="padding:20px 0px 0px 0px">

            <input type="hidden" id="id_user" value="{{ $lead->id_usuario }}" />
            <input type="hidden" id="id_lead" value="{{ $lead->id }}" />

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
                                        <td colspan="4" style="text-align: left;">
                                        @if( $lead->photo == null )
                                            <a data-lightbox="roadtrip" href="<?php echo e(asset('assets/images/image-not-found.png')); ?>"><img style="max-width:150px" title="Photo" src="<?php echo e(asset('assets/images/image-not-found.png')); ?>"></a>
                                        @else
                                            <a data-lightbox="roadtrip" href="{{CRUDBooster::mainpath("$lead->photo")}}"><img style="max-width:150px" title="Photo" src="{{CRUDBooster::mainpath("$lead->photo")}}"></a>
                                        @endif

                                        {{--<a class='btn btn-success pull-right' style="margin: 2px" href='http://127.0.0.1:8000/crm/fases?parent_table=customers&parent_columns=name&parent_id=3289&return_url=http%3A%2F%2F127.0.0.1%3A8000%2Fadmin%2Fcustomers25%3Fm%3D62&foreign_key=customers_id&label=Phases'><i class="fa fa-step-forward"></i> Process</a>--}}
                                        <a title="{{trans('crudbooster.send_email')}}" class='btn btn-success pull-right' style="margin: 2px" href='{{CRUDBooster::mainpath("send-email/$id")}}'><i class="fa fa-envelope"></i></a>
                                        <a title="{{trans('crudbooster.send_sms')}}" class='btn btn-primary pull-right' style="margin: 2px" href='{{CRUDBooster::mainpath("send-sms/$id")}}'><i class="glyphicon glyphicon-phone"></i></a>
                                        {{--<a title="Add Quote" class='btn btn-warning pull-right' style="margin: 2px" href='{{CRUDBooster::adminpath("customers25/quotes/$id")}}'><i class="fa fa-edit"></i></a>--}}
                                        <a title="{{trans('crudbooster.add_quote')}}" class='btn btn-warning pull-right' style="margin: 2px" href='{{CRUDBooster::adminpath("orders/add-quote/$id")}}'><span style="font-family: 'Droid Arabic Naskh', serif">Q</span></a>


                                            <br>
                                            <a style="margin-top: 2px" class="btn btn-warning pull-right" title="{{trans('crudbooster.delete')}}" href="javascript:;" onclick="swal({
                                                    title: '{{trans('crudbooster.are_you_sure')}}',
                                                    text: '{{trans('crudbooster.message_delete')}}',
                                                    type: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#ff0000',
                                                    confirmButtonText: '{{trans('crudbooster.yes')}}',
                                                    cancelButtonText: '{{trans('crudbooster.no')}}',
                                                    closeOnConfirm: false },
                                                    function(){  location.href='http://127.0.0.1:8000/crm/customers25/delete/{{ $id }}' });"><i class="fa fa-trash"></i>
                                            </a>
                                        <a title="{{trans('crudbooster.edit')}}" class='btn btn-success pull-right' style="margin: 2px" href='{{CRUDBooster::adminpath("customers25/edit/$id")}}'><i class="fa fa-pencil"></i></a>
                                </tr>
                                <tr>
                                    <td>{{trans('crudbooster.name_lastname')}}</td><td>{{ $lead->name }} {{ $lead->lastname }}</td>
                                    <td><strong>{{trans('crudbooster.address')}}</strong></td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="showModalMapaddress()" title="Click to view the map">
                                                <i class="fa fa-map-marker"></i> {{ $lead->address }}
                                            </a>

                                            <div id="googlemaps-modal-address" class="modal" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                        <h4 class="modal-title"><i class="fa fa-search"></i> {{trans('crudbooster.view_map')}}</h4>
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

                                                $('#googlemaps-modal-address .modal-body').html("<div align='center'>{{trans('crudbooster.map_not_found')}}</div>");

                                            }
                                        </script>
                                        </td>
                                </tr>

                                <tr>
                                    <td>{{trans('crudbooster.email')}}</td><td><a href='{{CRUDBooster::mainpath("send-email/$id")}}'>{{ $lead->email }}</a></td>
                                    <td><strong>{{trans('crudbooster.type')}}</strong></td><td>{{ $contact_type->name }}</td>
                                </tr>

                                <tr>
                                    <td>{{trans('crudbooster.phone')}}</td><td> <a href="tel:{{ $lead->telephone }}">{{ $lead->telephone }}</a></td>
                                    <td><strong>{{trans('crudbooster.state')}}</strong></td><td>{{ $lead->abbreviation }}</td>
                                </tr>

                                <tr>
                                    <td>{{trans('crudbooster.creation_date')}}</td><td>{{ $lead->date_created }}</td>
                                    <td><strong>{{trans('crudbooster.city')}}</strong></td><td>{{ $lead->city }}</td>
                                </tr>

                                <tr>
                                    <td>{{trans('crudbooster.zipcode')}}</td><td>{{ $lead->zip_code }}</td>
                                    <td><strong>{{trans('crudbooster.quotes')}}</strong></td><td>{{ $lead->quotes }}</td>

                                </tr>

                                <tr>
                                    <td><strong>{{trans('crudbooster.assign_to')}}</strong></td>
                                    <td class='editable' data-campo='id_usuario'>
                                        <a href='{{CRUDBooster::adminpath("users/detail/$lead->id_usuario")}}'>{{ $assign_to->fullname }}</a>
                                        <span title="{{trans('crudbooster.edit')}}" class="edit_button"><i class="fa fa-edit"></i></span>
                                    </td>
                                    <td><strong>{{trans('crudbooster.notes')}}</strong></td>
                                    <td>
                                        @if( $lead->notes == 1)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </td>


                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div><!-- /.box-body -->

                <div class='panel panel-default'>
                    <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-pencil-square-o text-normal"></i> {{trans('crudbooster.closed_quotes')}} </strong></div>


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

                                        <table id="table_closed_quotes_clients" class='table table-striped table-bordered'>
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>{{trans('crudbooster.Business_Name')}}</th>
                                                <th>{{trans('crudbooster.budget')}}</th>
                                                <th>{{trans('crudbooster.creation_date')}}</th>
                                                <th>{{trans('crudbooster.financing')}}</th>
                                                <th>Total</th>
                                                <th style="text-align: center;">{{trans('crudbooster.actions')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                        <?php    }
                                        ?>

                                    @foreach($quotes_closed as $quote)
                                        <tr>
                                            <td>{{$quote->id}}</td>
                                            <td>{{$quote->truck_name}}</td>
                                            <td>{{$quote->truck_budget}}</td>
                                            <td>{{$quote->truck_date_created}}</td>
                                            <td>{{$quote->financing}}</td>
                                            <td>{{$quote->truck_aprox_price}}</td>
                                            <td style="text-align: center;">
                                                <a title="Print" class='btn btn-danger btn-sm' href='{{CRUDBooster::adminPath("orders/print-quote/$quote->id")}}'><i class="fa fa-print"></i></a>
                                                {{--<a title="{{trans('crudbooster.print')}}" class='btn btn-danger btn-sm' href='#'><i class="fa fa-print"></i></a>--}}
                                                <a title="{{trans('crudbooster.back_to_history')}}" class='btn btn-success btn-sm' href='{{CRUDBooster::adminPath("orders/change-quotes/$quote->id")}}'><i class="fa fa-arrow-left"></i></a>
                                                <a title="{{trans('crudbooster.invoice')}}" class='btn btn-yahoo btn-sm' href='{{CRUDBooster::mainpath("create-invoice/$quote->id")}}'><i class="fa fa-hand-o-right"></i></a>
                                                <a title="{{trans('crudbooster.current_phases')}}" class='btn btn-twitter btn-sm' href='{{CRUDBooster::adminpath("orders/detail/$quote->id")}}'><i class="fa fa-clock-o"></i></a>
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
                    <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-pencil-square-o text-normal"></i> {{trans('crudbooster.list_quotes')}} </strong></div>

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

                                        <table id="table_opened_quotes_clients" class='table table-striped table-bordered'>
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>{{trans('crudbooster.Business_Name')}}</th>
                                                <th>{{trans('crudbooster.budget')}}</th>
                                                <th>{{trans('crudbooster.creation_date')}}</th>
                                                <th>{{trans('crudbooster.financing')}}</th>
                                                <th>Total</th>
                                                <th style="text-align: center;">{{trans('crudbooster.actions')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                        <?php    }
                                        ?>

                                    @foreach($quotes_opened as $quote)
                                        <tr>
                                            <td>{{$quote->id}}</td>
                                            <td>{{$quote->truck_name}}</td>
                                            <td>{{$quote->truck_budget}}</td>
                                            <td>{{$quote->truck_date_created}}</td>
                                            <td>{{$quote->financing}}</td>
                                            <td>{{$quote->truck_aprox_price}}</td>
                                            <td style="text-align: center;">
                                                <a title="{{trans('crudbooster.edit')}}" class='btn btn-success btn-sm' href='{{CRUDBooster::adminPath("orders/edit/$quote->id")}}'><i class="fa fa-pencil"></i></a>
                                                <a title="{{trans('crudbooster.close_quote')}}" class='btn btn-primary btn-sm' href='{{CRUDBooster::adminPath("orders/convert-client/$quote->id")}}'><i class="fa fa-share-square-o"></i></a>
                                                <a title="{{trans('crudbooster.invoice')}}" class='btn btn-yahoo btn-sm' href='{{CRUDBooster::mainpath("create-invoice/$quote->id")}}'><i class="fa fa-hand-o-right"></i></a>
                                                <a class="btn btn-sm btn-warning btn-delete" title="{{trans('crudbooster.delete')}}" href="javascript:;" onclick="swal({
                                                        title: '{{trans('crudbooster.are_you_sure')}}',
                                                        text: '{{trans('crudbooster.message_delete')}}',
                                                        type: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#ff0000',
                                                        confirmButtonText: '{{trans('crudbooster.yes')}}',
                                                        cancelButtonText: '{{trans('crudbooster.no')}}',
                                                        closeOnConfirm: false },
                                                        function(){  location.href='http://127.0.0.1:8000/crm/orders/delete/{{ $quote->id }}' });"><i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>


                            </div>
                        </div><!-- /.box-body -->
                    </div>





                <div class='panel panel-default'>
                    <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-book"></i> {{trans('crudbooster.List_Tasks')}}</strong></div>
                    <a title="{{trans('crudbooster.show_calendar')}}" class='btn btn-primary pull-right' style="margin-left: 2px" href='{{CRUDBooster::adminpath("task_calendar")}}'><i class="fa fa-calendar"></i> </a>
                    <a title="{{trans('crudbooster.add_task')}}" id="addTasks" class='btn btn-primary pull-right' style="margin: 2px" href='#'><i class="fa fa-book"></i></a>
                </div>

                <div class="table-responsive" style="padding-left: 20px; padding-right: 20px">

                        <?php
                        if(count($tasks) == 0) {
                        echo "<div style='text-align: center; color: red; padding-bottom: 20px;'><i class='fa fa-search'></i>";?> {{ trans('crudbooster.table_data_not_found') }}  <?php echo "</div>";
                        }
                        else {
                        ?>

                            <table id="table_tasks" class='table table-striped table-bordered'>
                                <thead>
                                <tr>
                                    <th>{{trans('crudbooster.name')}}</th>
                                    <th>{{trans('crudbooster.date')}}</th>
                                    <th>{{trans('crudbooster.creation_date')}}</th>
                                    <th style="text-align: center">{{trans('crudbooster.actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>

                            <?php    }
                            ?>

                        @foreach($tasks as $task)
                            <tr>
                                <td>{{$task->name}}</td>
                                <td>{{$task->date}}</td>
                                <td>{{$task->created_at}}</td>
                                <td style="text-align: center">
                                    <a class="btn btn-xs btn-primary btn-detail" title="{{trans('crudbooster.detail')}}" href="http://127.0.0.1:8000/crm/eazy_tasks_clients/detail/{{$task->id}}?return_url=http%3A%2F%2F127.0.0.1%3A8000%2Fcrm%2Feazy_tasks_clients%3Fforeign_key%3Dclients_id%26label%3DTasks%26parent_columns%3Dname%26parent_id%3D{{$id}}%26parent_table%3Dclients%26return_url%3Dhttp%253A%252F%252F127.0.0.1%253A8000%252Fcrm%252Fclients%253Fm%253D50"><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-xs btn-success btn-edit" title="{{trans('crudbooster.edit')}}" href="http://127.0.0.1:8000/crm/eazy_tasks_clients/edit/{{$task->id}}?return_url=http%3A%2F%2F127.0.0.1%3A8000%2Fcrm%2Feazy_tasks_clients%3Fforeign_key%3Dclients_id%26label%3DTasks%26parent_columns%3Dname%26parent_id%3D{{$id}}%26parent_table%3Dclients%26return_url%3Dhttp%253A%252F%252F127.0.0.1%253A8000%252Fcrm%252Fclients%253Fm%253D50&parent_id=3288&parent_field="><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-xs btn-warning btn-delete" title="{{trans('crudbooster.delete')}}" href="javascript:;" onclick="swal({
                                            title: '{{trans('crudbooster.are_you_sure')}}',
                                            text: '{{trans('crudbooster.message_delete')}}',
                                            type: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#ff0000',
                                            confirmButtonText: '{{trans('crudbooster.yes')}}',
                                            cancelButtonText: '{{trans('crudbooster.no')}}',
                                            closeOnConfirm: false },
                                            function(){  location.href='{{CRUDBooster::adminpath("eazy_tasks_clients/delete/$task->id")}}' });"><i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>


                </div>


                <div class='panel panel-default'>
                    <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-file-text-o"></i> {{trans('crudbooster.Notes')}}</strong></div>
                    {{--<a title="{{trans('crudbooster.add_note')}}" class='btn btn-danger pull-right' style="margin: 2px" href='http://127.0.0.1:8000/crm/eazy_notes/add?return_url=http%3A%2F%2F127.0.0.1%3A8000%2Fadmin%2Fnotes%3Fforeign_key%3Dcustomers_id%26label%3DNotes%26parent_columns%3Dname%26parent_id%3D{{$id}}%26parent_table%3Dcustomers%26return_url%3Dhttp%253A%252F%252F127.0.0.1%253A8000%252Fadmin%252Fcustomers%253Fm%253D50&parent_id={{$id}}&parent_field=customers_id'><i class="fa fa-file-text-o"></i></a>--}}
                </div>

                    <?php
                    if(count($notes) == 0) {
                    echo "<div style='text-align: center; color: red; padding-bottom: 20px;'><i class='fa fa-search'></i>";?> {{ trans('crudbooster.table_data_not_found') }}  <?php echo "</div>";
                    }
                    ?>

                    @foreach($notes as $note)
                        <div class="row invoice-info" style="padding-left: 20px; padding-bottom: 15px;">
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
                                                function(){  location.href='http://127.0.0.1:8000/crm/notes/delete/{{ $note->id }}' });"><i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="row" style="padding-left: 20px; padding-top: 20px; padding-bottom: 20px;">
                        <input type="hidden" id="note_lead_id" value="{{ $id }}">
                        <div class="col-md-6">
                            <textarea class="form-control" type="text" id="note_value" name="note_value" rows="3" value=""> </textarea>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="add_note" class="btn btn-xl btn-danger" >{{trans('crudbooster.add_note')}}</button>
                        </div>
                    </div>

                    <div class="box-footer" style="background: #F5F5F5">

                    <div class="form-group">
                        <label class="control-label col-sm-2"></label>
                        <div class="col-sm-10">
                        </div>
                    </div>
                </div><!-- /.box-footer-->


        </div>


    </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="taskLeadModal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #337ab7; color: white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">{{trans('crudbooster.task_creation')}}</h4>
                    </div>

                    <form id="form_product" data-parsley-validate  action="" method="post" class="form-horizontal">

                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="col-md-10">
                                    <input type="hidden" id="lead_id" value="{{ $id }}">

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.name')}}*</label>
                                        <div class="col-md-8">
                                            <input type="text" title="Name" required class="form-control" name="name" id="name" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.date')}}*</label>
                                        <div class="col-md-8">
                                            <input type="text" title="Date" required class="form-control" name="date" id="date" value="">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-dismiss="modal">{{trans('crudbooster.close')}}</button>
                            <button type="button" class="btn btn-primary " id="addSaveTask">{{trans('crudbooster.add')}}</button>
                        </div>

                    </form>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>



@endsection