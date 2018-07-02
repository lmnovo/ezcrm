@extends('crudbooster::admin_template')
@section('content')

    <script src="http://127.0.0.1:8000/js/categorias_productos.js"></script>
    <script src="http://127.0.0.1:8000/js/subcategorias_productos.js"></script>

    <script>
        $(document).ready(function() {
            /*$('#products_table').dataTable( {
                //"aaSorting": [[ 0, "desc" ]]
            } );*/

            $('#newApplianceModal').on('change','#appliance_new',function(){
                $('#product_new').html('');
                $('#modal-loading').modal('show');
                $('#appliance_inside_category_new').val('');
                $('#description_new').val('');
                $('#price2_new').val('');
                $('#price2_retail_new').val('');
                $('#weight_new').val('0');
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

            validarFormularioNew();
            validarFormularioEdit();

            function validarFormularioNew(){
                $("#newAppliance_form").validate({
                    rules: {
                        appliance_new: { required: true },
                        product_new: { required:true },
                        appliance_inside_category_new: { required:true },
                        description_new: { required:true },
                        price2_new: { required:true, mix: 0},
                        price2_retail_new: { required:true, mix: 0},
                        weight_new: { required:true, mix: 0}
                    },
                    messages: {
                        appliance_new: "This field is required",
                        product_new : "This field is required",
                        appliance_inside_category_new : "This field is required",
                        description_new : "This field is required",
                        price2_new : "This field is required and should contain a numerical value",
                        price2_retail_new : "This field is required and should contain a numerical value",
                        weight_new : "This field should contain a numerical value"
                    }
                });
            }

            function validarFormularioEdit(){
                $("#editAppliance_form").validate({
                    rules: {
                        appliance_edit: { required: true },
                        product_edit: { required:true },
                        appliance_inside_category_edit: { required:true },
                        description_edit: { required:true },
                        price2_edit: { required:true, mix: 0},
                        price2_retail_edit: { required:true, mix: 0},
                        weight_edit: { required:true, mix: 0}
                    },
                    messages: {
                        appliance_edit: "This field is required",
                        product_edit : "This field is required",
                        appliance_inside_category_edit : "This field is required",
                        description_edit : "This field is required",
                        price2_edit : "This field is required and should contain a numerical value",
                        price2_retail_edit : "This field is required and should contain a numerical value",
                        weight_edit : "This field should contain a numerical value"
                    }
                });
            }

            //Editar una appliance del listado de products
            var appliance_id;
            $('a#appliance_list_edit').on('click',function(e){
                e.preventDefault();
                //Clean form
                $('#appliance_edit').html('');
                $('#select2-appliance_edit-container').html('');
                $('#product_edit').html('');
                $('#select2-product_edit-container').html('');
                $('#description_edit').val('');
                $('#price2_edit').val('');
                $('#price2_retail_edit').val('');
                $('#weight_edit').val('');

                appliance_id = $(this).data('id');
                $('#edit_hidden').val(appliance_id);

                $.ajax({
                    url:  'products/applianceinsidecategories',
                    data: "id="+appliance_id,
                    type:  'get',
                    dataType: 'json',
                    success : function(data) {
                        var appliances_data = data;
                        var appliance_inside_data = '';

                        //Cargar en el editor de appliance las subcategorías (select)
                        $.ajax({
                            url:  'products/appliancesinsidefilter',
                            data: "id_appliance_inside="+appliances_data[0].id_appliance_inside,
                            type:  'get',
                            dataType: 'json',
                            success : function(result) {
                                for(var i=0;i<result.length;i++)
                                {
                                    if (appliances_data[0].id_appliance_inside == result[i].id) {
                                        $('#product_edit').append('<option selected="true" value="'+result[i].id+'">'+result[i].name+'</option>');
                                        appliance_inside_data = result[i].id_appliance;
                                    }
                                    else {
                                        $('#product_edit').append('<option value="'+result[i].id+'">'+result[i].name+'</option>');
                                    }
                                }

                                //Cargar en el editor de appliance las categorías (select)
                                $.ajax({
                                    url:  'orders/appliances',
                                    data: '',
                                    type:  'get',
                                    dataType: 'json',
                                    success : function(query) {
                                        for(var i=0;i<query.length;i++)
                                        {
                                            if (appliance_inside_data == query[i].id) {
                                                $('#appliance_edit').append('<option selected="true" value="'+query[i].id+'">'+query[i].category+'</option>');
                                            }
                                            else {
                                                $('#appliance_edit').append('<option value="'+query[i].id+'">'+query[i].category+'</option>');
                                            }
                                        }
                                    }
                                });
                            }
                        });

                        $('#appliance_inside_category_edit').val(data[0].name);
                        $('#description_edit').val(data[0].description);
                        $('#price2_edit').val(data[0].price);
                        $('#price2_retail_edit').val(data[0].retail_price);
                        $('#weight_edit').val(data[0].weight);
                        $('#appliance_imagen').attr('src','http://127.0.0.1:8000/assets/images/appliances/'+data[0].imagen);
                        $('#editApplianceModal').modal('show');
                    }
                });
            });

            //Al cambiar el valor del appliance (category) en el modal de Editar Appliance
            $('#editApplianceModal').on('change','#appliance_edit',function(){
                $('#product_edit').html('');
                $('#modal-loading').modal('show');
                $('#appliance_inside_category_edit').val('');
                $('#description_edit').val('');
                $('#price2_edit').val('');
                $('#price2_retail_edit').val('');
                $('#weight_edit').val('0');
                var categoria = $('#appliance_edit').val();
                $('#select2-product_edit-container').html('**Select Data**');
                $('#appliance_imagen').attr('src','');

                $.ajax({
                    url:  'orders/applianceslist',
                    data: "&categoria="+categoria,
                    type:  'get',
                    dataType: 'json',
                    success : function(data) {
                        $('#product_edit').append('<option value=""></option>');
                        for(var i=0;i<data.length;i++)
                        {
                            $('#product_edit').append('<option value="'+data[i].id+'">'+data[i].name+'</option>');
                        }

                        $('#modal-loading').modal('hide');

                    }
                });
            });

            //Al cambiar el valor del appliance (subcategory) en el modal de Editar Appliance
            $('#editApplianceModal').on('change','#product_edit',function(){
                $('#modal-loading').modal('show');
                $('#appliance_inside_category_edit').val('');
                $('#description_edit').val('');
                $('#price2_edit').val('');
                $('#price2_retail_edit').val('');
                $('#weight_edit').val('0');
                $('#appliance_imagen').attr('src','');

                $('#modal-loading').modal('hide');
            });

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
                                    <select class="form-control required" id="appliance_new" name="appliance_new" placeholder="Select" style="width: 100%" >
                                    </select>
                                </div>
                                <span class="input-group-btn">
                                    <button title="{{trans('crudbooster.add')}}" class="btn btn-success" type="button" id="edit_appliance_new"><span class="glyphicon glyphicon-plus-sign"></span></button>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="product" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.appliance')}}*</label>
                                <div class="col-md-8">
                                    <select required class="form-control required" id="product_new" name="product_new" placeholder="Select" style="width: 100%" >
                                    </select>
                                </div>
                                <span class="input-group-btn">
                                        <button title="{{trans('crudbooster.add')}}" class="btn btn-success" type="button" id="edit_product_new"><span class="glyphicon glyphicon-plus-sign"></span></button>
                                    </span>
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
                                    <input type="text" title="{{trans('crudbooster.cost_price')}}" required class="form-control number min:0" placeholder="0.00" name="price2_retail_new" id="price2_retail_new" value="">
                                    <div class="text-danger"></div>
                                    <p class="help-block"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.retail_price')}}*</label>
                                <div class="col-md-9">
                                    <input required class="form-control number min:0" id="price2_new" name="price2_new"  placeholder="0.00" type="text"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.weight')}}</label>
                                <div class="col-md-9">
                                    <input class="form-control number min:0" id="weight_new" name="weight_new" value="0.00" type="text"/>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-5">
                                <img style="width: 100%; height: 400px;" class="profile-user-img img-responsive img-bordered" src="<?php echo e(asset('assets/images/appliances/image-not-found.png')); ?>" alt="Image">

                                {!! Form::file('image', array('class' => 'image')) !!}
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

    <div class="modal fade" tabindex="-1" role="dialog" id="editApplianceModal" >
        <div class="modal-dialog modal-lg" role="document"  style=" width: 90%">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('crudbooster.edit_appliance')}}</h4>
                </div>

                {!! Form::open(array('id' => 'editAppliance_form', 'route' => 'ajaxImageUpload','enctype' => 'multipart/form-data', 'class' => 'form-horizontal')) !!}

                <input type="hidden" name="edit_hidden" id="edit_hidden" value="">

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="appliance" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.category')}}*</label>
                                <div class="col-md-8">
                                    <select required class="form-control required" id="appliance_edit" name="appliance_edit" placeholder="Select" style="width: 100%" >
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.appliance')}}*</label>
                                <div class="col-md-8">
                                    <select required class="form-control required" id="product_edit" name="product_edit" placeholder="Select" style="width: 100%" >
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="appliance_inside_category" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.detail')}}*</label>
                                <div class="col-md-9">
                                    <input required class="form-control required" id="appliance_inside_category_edit" name="appliance_inside_category_edit"  placeholder="{{trans('crudbooster.detail')}}" type="text"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.description')}}*</label>
                                <div class="col-md-9 col-xs-12 col-sm-9">
                                    <textarea required rows="6" class="form-control required" id="description_edit" name="description_edit" placeholder="{{trans('crudbooster.description')}}"></textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.cost')}}*</label>
                                <div class="col-md-9">
                                    <input required class="form-control required number min:0" id="price2_retail_edit" name="price2_retail_edit"  placeholder="0.00" type="text"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.retail_price')}}*</label>
                                <div class="col-md-9">
                                    <input type="text" required class="form-control required number min:0" placeholder="0.00" name="price2_edit" id="price2_edit" value="">
                                    <div class="text-danger"></div>
                                    <p class="help-block"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.weight')}}</label>
                                <div class="col-md-9">
                                    <input class="form-control number min:0" id="weight_edit" name="weight_edit"  value="0.00" type="text"/>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-5">
                                <img id="appliance_imagen" style="width: 100%; height: 400px;" class="profile-user-img img-responsive img-bordered" src="<?php echo e(asset('assets/images/appliances/image-not-found.png')); ?>" alt="Image">

                                {!! Form::file('image', array('class' => 'image')) !!}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">{{trans('crudbooster.close')}}</button>
                    <button type="submit" id="editFormSubmit" class="btn btn-primary" id="">{{trans('crudbooster.save')}}</button>
                </div>

                {!! Form::close() !!}

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    {{--<-Listado de Appliances (Productos)--}}
    <div class="box" style="padding: 20px; font-size: 12px" >
        {!! Form::open(['method'=>'GET','url'=>CRUDBooster::adminPath($slug="products"),'class'=>'','role'=>'search'])  !!}
        <div>
           <div class="input-group custom-search-form col-md-4 col-sm-8 col-xs-12 pull-right" style="padding-right: 0px; padding-bottom: 15px;">
                <div class="input-group-btn"  style="padding-right: 6px;" >
                    <a style="background-color: #f4f4f4;" href="{{ CRUDBooster::adminPath($slug="products") }}" id="btn_reset_filter" data-url-parameter="" title="{{trans('crudbooster.reset')}}" class="form-control input-sm pull-right">
                        <i class="fa fa-filter"></i> {{trans('crudbooster.reset')}}
                    </a>
                </div>
                <input type="text" class="form-control input-sm pull-right" name="search" placeholder="{{trans('crudbooster.search')}}">
                <div class="input-group-btn">
                    <button class="form-control input-sm pull-right" type="submit" style="background-color: #f4f4f4;">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

        <table id="products_table" class='table table-hover table-striped table-bordered table_class_products'>
            <thead>
            <tr style="color: #337ab7; text-decoration: none;">
                <th>Id</th>
                <th>{{trans('crudbooster.image')}}</th>
                <th>{{trans('crudbooster.category')}}</th>
                <th>{{trans('crudbooster.appliance')}}</th>
                <th>{{trans('crudbooster.detail')}}</th>
                <th>{{trans('crudbooster.description')}}</th>
                <th>{{trans('crudbooster.cost_price')}}</th>
                <th>{{trans('crudbooster.retail_price')}}</th>
                <th style="text-align: center">{{trans('crudbooster.action')}}</th>
            </tr>
            </thead>
            <tbody>

            @foreach($result as $row)
                <tr>
                    <td style="width: 2%">{{$row->id}}</td>
                    <td style="width: 6%">
                        <a data-lightbox="roadtrip" rel="group_{products}" title="{{$row->description}}" href="http://127.0.0.1:8000/assets/images/appliances/{{$row->imagen}}">
                            <img width="40px" height="40px" src="http://127.0.0.1:8000/assets/images/appliances/{{$row->imagen}}">
                        </a>
                    </td>
                    <td style="width: 12%">{{$row->category}}</td>
                    <td style="width: 13%">{{$row->appliance}}</td>
                    <td style="width: 18%">{{$row->detail}}</td>
                    <td style="width: 23%">{{$row->description}}</td>
                    <td style="width: 8%">{{$row->retail_price}}</td>
                    <td style="width: 8%">{{$row->price}}</td>
                    <td style="width: 7%; text-align: center;">
                        <a id="appliance_list_edit" data-id="{{ $row->id }}" class='btn btn-xs btn-success btn-edit' title='Edit Data'>
                            <i class='fa fa-pencil'></i>
                        </a>

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
                                location.href='http://127.0.0.1:8000/crm/products/delete/{{ $row->id }}'
                                });"><i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach

            <?php
            if (count($result == 0)) {
             echo "<tr><td colspan='9'> <div style='text-align: center; color: red; padding-bottom: 20px;'><i class='fa fa-search'></i>";?> {{ trans('crudbooster.table_data_not_found') }}  <?php echo "</div></td></tr>";
            }
            ?>

            </tbody>
        </table>

        <nav aria-label="Page navigation">
            <ul class="pagination">
                {{ $result->links() }}
            </ul>
        </nav>
    </div>
    {{--->Listado de Appliances (Productos)--}}

    <div class="modal fade" id="modal-loading" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-body">
                <img style="width: 64px;" src="<?php echo e(asset('assets/images/loading.gif')); ?>" alt="Loading">
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="newCategoryApplianceModal">
        <div class="modal-dialog modal-lg" role="document"  style=" width: 90%">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7; color: white;">
                    <button type="button" id="closeModal3" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('crudbooster.category_creation_new')}}</h4>
                </div>

                <div class="modal-body" >
                    <div class="container-fluid">
                        <div class="col-md-12">

                            <div class="col-md-7">
                                <form id="form_product" data-parsley-validate="" action="" method="post" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="category_category_name" class="col-md-2 col-xs-7 col-sm-2 control-label">{{trans('crudbooster.category')}}</label>
                                        <div class="col-md-7">
                                            <input class="form-control number" id="category_category_name" name="category_category_name" placeholder="{{trans('crudbooster.category')}}" type="text">
                                        </div>
                                        <span class="input-group-btn">
                                            <button title="Add" class="btn btn-success" type="button" id="newCategoria"><span class="glyphicon glyphicon-plus-sign"></span></button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="table_categorias" class="table-responsive hover" style="margin: 2%;">
                    <table id="categorias" class="table table-striped table-responsive table-bordered" cellspacing="0">
                        <thead>
                        <tr>
                            <th>{{trans('crudbooster.category')}}</th>
                            <th >{{trans('crudbooster.action')}}</th>
                        </tr>
                        </thead>
                        <tbody style="font-size: 12px">

                        </tbody>
                        <tfoot>
                        <tr>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="modal-footer">

                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="newSubCategoryApplianceModal">
        <div class="modal-dialog modal-lg" role="document"  style=" width: 90%">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7; color: white;">
                    <button type="button" id="closeModal4" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                                    <label for="category_category_name" class="col-md-3 col-xs-7 col-sm-3 control-label">{{trans('crudbooster.subcategory')}}</label>
                                    <div class="col-md-7">
                                        <input class="form-control number" id="subcategory_name" name="subcategory_name"  placeholder="{{trans('crudbooster.subcategory')}}" type="text"/>
                                    </div>
                                    <span class="input-group-btn">
                                        <button title="{{trans('crudbooster.add')}}" class="btn btn-success" type="button" id="newSubCategoria"><span class="glyphicon glyphicon-plus-sign"></span></button>
                                    </span>
                                </div>


                            </form>
                        </div>

                    </div>
                </div>

                <div id="table_subcategorias" class="table-responsive hover" style="margin: 2%;">
                    <table id="subcategorias" class="table table-striped table-responsive table-bordered" cellspacing="0">
                        <thead>
                        <tr>
                            <th>{{trans('crudbooster.subcategory')}}</th>
                            <th>{{trans('crudbooster.category')}}</th>
                            <th >{{trans('crudbooster.action')}}</th>
                        </tr>
                        </thead>
                        <tbody style="font-size: 12px">

                        </tbody>
                        <tfoot>
                        <tr>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-dark" id="closeSubCategory">{{trans('crudbooster.close')}}</button>--}}
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


@endsection


