@extends('crudbooster::admin_template')
@section('content')


    <script>
        $(document).ready(function() {
            $('#products_table').dataTable( {
                "aaSorting": [[ 0, "desc" ]]
            } );

            $('#newApplianceModal').on('change','#appliance_new',function(){
                $('#product_new').html('');
                $('#modal-loading').modal('show');
                $('#appliance_inside_category_new').val('');
                $('#description_new').val('');
                $('#price2_new').val('');
                $('#price2_retail_new').val('');
                var categoria = $('#appliance_new').val();
                $('#select2-product_new-container').html('**Select Data**');

                $.ajax({
                    url:  'orders/applianceslist',
                    data: "&categoria="+categoria,
                    type:  'get',
                    dataType: 'json',
                    success : function(data) {
                        $('#product_new').append('<option value=""></option>');
                        for(var i=0;i<data.length;i++)
                        {
                            $('#product_new').append('<option value="'+data[i].id+'">'+data[i].name+'</option>');
                        }

                        $('#modal-loading').modal('hide');

                    }
                });
            });

            validarFormulario();

            function validarFormulario(){
                $("#newAppliance_form").validate();
            }



            /*$("#modalAppliance_edit").on('click',function(){
                $('#editApplianceModal').modal('show');


                $('#price2_retail_edit').val('34234');
            });*/

        } );

        $("h1").hide();
        var h1 = "<h1 style='padding-bottom: 0px'>" +
            "<div><div style='float: left'><i class='fa fa-cubes'></i> Products &nbsp;&nbsp; </div><button style='margin-right: 20px' id=\"newAppliance\" class=\"btn btn-sm btn-success\" type=\"button\"><i class=\"fa fa-plus-circle\"></i> </button> </div>" +
            "" +
            "</h1>";
        $("section[class*='content-header']").append(h1);

        $("#newAppliance").on('click',function(){

            cleanApplianceModal();
            $('#modal-loading').modal('show');

            $.ajax({
                url: 'orders/appliancescategories/',
                data: '',
                type:  'get',
                dataType: 'json',
                success : function(data) {
                    $('#appliance_new').append('<option value=""></option>');
                    for(var i=0;i<data.length;i++)
                    {
                        $('#appliance_new').append('<option value="'+data[i].id+'">'+data[i].category+'</option>');
                    }

                    //Limpiar Modal de Appliances
                    $('#modal-loading').modal('hide');
                }
            });

            $('#newApplianceModal').modal('show');

            function cleanApplianceModal() {
                $('#appliance_new').html('');
                $('#select2-appliance_new-container').html('');
                $('#product_new').html('');
                $('#select2-appliance_new-container').html('**Select Data**');
                $('#select2-product_new-container').html('**Select Data**');
                $('#select2-appliance_inside_category_new-container').html('**Select Data**');
                $('#description_new').val('');
                $('#price2_new').val('');
                $('#price2_retail_new').val('');
                $('#weight_new').val('');
            }
        });



    </script>

    <div class="modal fade" tabindex="-1" role="dialog" id="newApplianceModal" style="position: relative">
        <div class="modal-dialog modal-lg" role="document"  style=" width: 90%">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('crudbooster.appliance_creation_new')}}</h4>
                </div>

                {!! Form::open(array('id' => 'newAppliance_form', 'route' => 'ajaxImageUpload','enctype' => 'multipart/form-data', 'class' => 'form-horizontal')) !!}

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="appliance" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.category')}}*</label>
                                <div class="col-md-8">
                                    <select required class="form-control" id="appliance_new" name="appliance" placeholder="Select" style="width: 100%" >
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <a title="" id="edit_category_new" class="btn btn-success btn-sm">
                                        <i class="glyphicon glyphicon-plus-sign"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.appliance')}}*</label>
                                <div class="col-md-8">
                                    <select required class="form-control required" id="product_new" name="product_new" placeholder="Select" style="width: 100%" >
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <a title="" id="edit_product_new" class="btn btn-success btn-sm">
                                        <i class="glyphicon glyphicon-plus-sign"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="appliance_inside_category" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.detail')}}*</label>
                                <div class="col-md-9">
                                    <input required class="form-control required" id="appliance_inside_category_new" name="appliance_inside_category_new"  placeholder="{{trans('crudbooster.detail')}}" type="text"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.description')}}*</label>
                                <div class="col-md-9 col-xs-12 col-sm-9">
                                    <textarea required rows="6" class="form-control required" id="description_new" name="description_new" placeholder="{{trans('crudbooster.description')}}"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.cost')}}*</label>
                                <div class="col-md-9">
                                    <input type="text" title="{{trans('crudbooster.cost_price')}}" required class="form-control number" placeholder="0.00" name="price2_new" id="price2_new" value="">
                                    <div class="text-danger"></div>
                                    <p class="help-block"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.retail_price')}}*</label>
                                <div class="col-md-9">
                                    <input required class="form-control number" id="price2_retail_new" name="price2_retail_new"  placeholder="0.00" type="text"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.weight')}}</label>
                                <div class="col-md-9">
                                    <input class="form-control number" id="weight_new" name="weight_new"  placeholder="0.00" value="0" type="text"/>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-5">
                                {!! Form::file('image', array('class' => 'image', 'required')) !!}
                            </div>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="editApplianceModal" style="position: relative">
        <div class="modal-dialog modal-lg" role="document"  style=" width: 90%">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('crudbooster.appliance_creation_new')}}</h4>
                </div>

                {!! Form::open(array('id' => 'newAppliance_form', 'route' => 'ajaxImageUpload','enctype' => 'multipart/form-data', 'class' => 'form-horizontal')) !!}

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="appliance" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.category')}}*</label>
                                <div class="col-md-8">
                                    <select required class="form-control" id="appliance_new" name="appliance" placeholder="Select" style="width: 100%" >
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <a title="" id="edit_category_new" class="btn btn-success btn-sm">
                                        <i class="glyphicon glyphicon-plus-sign"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.appliance')}}*</label>
                                <div class="col-md-8">
                                    <select required class="form-control required" id="product_new" name="product_new" placeholder="Select" style="width: 100%" >
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <a title="" id="edit_product_new" class="btn btn-success btn-sm">
                                        <i class="glyphicon glyphicon-plus-sign"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="appliance_inside_category" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.detail')}}*</label>
                                <div class="col-md-9">
                                    <input required class="form-control required" id="appliance_inside_category_new" name="appliance_inside_category_new"  placeholder="{{trans('crudbooster.detail')}}" type="text"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.description')}}*</label>
                                <div class="col-md-9 col-xs-12 col-sm-9">
                                    <textarea required rows="6" class="form-control required" id="description_new" name="description_new" placeholder="{{trans('crudbooster.description')}}"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.cost')}}*</label>
                                <div class="col-md-9">
                                    <input type="text" title="{{trans('crudbooster.cost_price')}}" required class="form-control number" placeholder="0.00" name="price2_new" id="price2_new" value="">
                                    <div class="text-danger"></div>
                                    <p class="help-block"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.retail_price')}}*</label>
                                <div class="col-md-9">
                                    <input required class="form-control number" id="price2_retail_edit" name="price2_retail_edit"  placeholder="0.00" type="text"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.weight')}}</label>
                                <div class="col-md-9">
                                    <input class="form-control number" id="weight_new" name="weight_new"  placeholder="0.00" value="0" type="text"/>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-5">
                                {!! Form::file('image', array('class' => 'image', 'required')) !!}
                            </div>
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

    <div class="box" style="padding: 20px; font-size: 12px" >
        <table id="products_table" class='table table-striped table-bordered'>
            <thead>
            <tr style="color: #337ab7; text-decoration: none;">
                <th>Id</th>
                <th>{{trans('crudbooster.category')}}</th>
                <th>{{trans('crudbooster.appliance')}}</th>
                <th>{{trans('crudbooster.detail')}}</th>
                <th>{{trans('crudbooster.description')}}</th>
                <th>{{trans('crudbooster.retail_price')}}</th>
                <th>{{trans('crudbooster.cost_price')}}</th>
                <th>{{trans('crudbooster.action')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($result as $row)
                <tr>
                    <td style="width: 2%">{{$row->id}}</td>
                    <td style="width: 10%">{{$row->category}}</td>
                    <td style="width: 15%">{{$row->appliance}}</td>
                    <td style="width: 20%">{{$row->detail}}</td>
                    <td style="width: 28%">{{$row->description}}</td>
                    <td style="width: 12%">{{$row->retail_price}}</td>
                    <td style="width: 10%">{{$row->price}}</td>
                    <td>
                        <!-- To make sure we have read access, wee need to validate the privilege -->
                        {{--@if(CRUDBooster::isUpdate() && $button_edit)
                            <button id="modalAppliance_edit" data-id="{{ $row->id }}" class="btn btn-xs btn-success btn-edit" title="Edit Data" href=""><i class="fa fa-pencil"></i></button>
                        @endif--}}

                        @if(CRUDBooster::isDelete() && $button_edit)
                            <a class="btn btn-xs btn-warning btn-delete" title="{{trans('crudbooster.delete')}}" href="javascript:;" onclick="swal({
                                    title: '{{trans('crudbooster.are_you_sure')}}',
                                    text: '{{trans('crudbooster.message_delete')}}',
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#ff0000',
                                    confirmButtonText: '{{trans('crudbooster.yes')}}',
                                    cancelButtonText: '{{trans('crudbooster.no')}}',
                                    closeOnConfirm: false },
                                    function(){
                                        location.href='http://ezcrm.us/crm/products/delete/{{ $row->id }}'
                                    });"><i class="fa fa-trash"></i>
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="modal-loading" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-body">
                <img style="width: 64px;" src="<?php echo e(asset('assets/images/loading.gif')); ?>" alt="Loading">
            </div>
        </div>
    </div>


@endsection


