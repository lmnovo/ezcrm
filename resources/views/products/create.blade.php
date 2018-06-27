@extends('crudbooster::admin_template')
@section('content')

    <script src='http://ezcrm.us/p/jquery-ui.custom.min.js'></script>
    <script src="http://ezcrm.us/p/jquery.ui.touch-punch.min.js"></script>
    <script src="http://ezcrm.us/p/chosen.jquery.min.js"></script>
    <script src="http://ezcrm.us/p/spinbox.min.js"></script>
    <script src="http://ezcrm.us/p/bootstrap-datepicker.min.js"></script>
    {{--<script src="http://ezcrm.us/p/bootstrap-timepicker.min.js"></script>--}}
    <script src="http://ezcrm.us/p/moment.min.js"></script>
    <script src="http://ezcrm.us/p/daterangepicker.min.js"></script>
    <script src="http://ezcrm.us/p/bootstrap-datetimepicker.min.js"></script>
    <script src="http://ezcrm.us/p/bootstrap-colorpicker.min.js"></script>
    <script src="http://ezcrm.us/p/jquery.knob.min.js"></script>
    <script src="http://ezcrm.us/p/autosize.min.js"></script>
    <script src="http://ezcrm.us/p/jquery.inputlimiter.min.js"></script>
    <script src="http://ezcrm.us/p/bootstrap-tag.min.js"></script>

    <!-- ace scripts -->
    <script src="http://ezcrm.us/p/ace-elements.min.js"></script>
    <script src="http://ezcrm.us/p/ace.min.js"></script>

    <script>
        $(document).ready(function()
        {
            $('#interesting').select2();
            $('#type').select2();
            $('#size').select2();

            var oTable= $('#buildouts').DataTable({
                "order": [[ 0, "asc" ]],
                "lengthMenu": [ 25, 50, 75, 100 ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Update footer
                    $( api.column( 2 ).footer() ).html(
                    );
                },
                "columnDefs": [
                    { "width": "25%", "targets": 0 },
                    { "width": "45%", "targets": 1 },
                    { "width": "5%", "targets": 2 },
                    { "width": "5%", "targets": 3 },
                    { responsivePriority: 1, targets: 0 }, { responsivePriority: 1, targets: 2 }, { responsivePriority: 1, targets: 3}
                ],
                responsive: {
                    details: false
                }
            });

            $('#edit_interesting').on('click',function(){
                $('#newProductModal').modal('show');
            });

            //Agregando Nueva Categoría de Appliance
            $('#newProductModal').on('click','#addProduct',function(){
                var product = $('#product_name').val();
                $('#modal-loading').modal('show');

                $.ajax({
                    url:  'addproductname',
                    data: "&product="+product,
                    type:  'get',
                    dataType: 'json',
                    success : function(data) {
                        window.location.href = 'http://ezcrm.us/crm/products/add-product';
                        $('#modal-loading').modal('hide');
                        $('#newProductModal').modal('hide');
                    }
                });
            });


            //Botón para agregar nuevo BuildOut en modal
            $('#newBuildout').on('click',function(){
                $('#nombreba').val('');
                $('#descriptionba').html('');
                $('#descriptionba').val('');
                $('#descriptionba').removeAttr('title');
                //$('.note-editing-area').html('');
                //$('.note-editable').html('');
                $('#price2ba').val('');
                $('#Build_OutGModal').modal('show');
            });

            //Abrir el Modal para Agregar Nuevo Buildout
            $('#Build_OutGModal').on('click','#savebuilout',function(){
                //Cargando variables del modal

                var tipo = $('#interesting').val();

                //Si es un TRUCK
                if(tipo == 1) {
                    var name = 'Build Out - '+$('#nombreba').val();
                }
                else if(tipo == 2) { // Si es un TRAILER
                    var name = $('#size option:selected').html()+' '+$('#nombreba').val();
                }

                var description = $('#descriptionba').summernote('code');
                var price = $('#price2ba').val();
                $('#buildout_name').html('');

                var type = $('#interesting').val();
                var size = $('#size').val();
                $('#buildout_description').html('');
                //$('.note-editing-area:nth-child(3)').html('');

                $.ajax({
                    url: '../orders/addbuildout',
                    data: "name="+name+"&description="+description+"&price="+price+"&tipo="+tipo,
                    type:  'get',
                    dataType: 'json',
                    success : function(data) {
                        $('#Build_OutGModal').modal('hide');
                        oTable.clear().draw();

                        $.ajax
                        ({
                            url: 'buildout',
                            data: "interesting="+type+"&size="+size,
                            type: 'get',
                            success: function(datas)
                            {
                                for(var i=0;i<datas.length;i++)
                                {
                                    oTable.row.add([
                                        datas[i].nombre,
                                        datas[i].descripcion,
                                        datas[i].precio,
                                        '<div class="btn-group" role="group" aria-label="..." id="'+datas[0].id+'">'+
                                        '<button type="button" class="btn btn-success btn-sm id="btneditar">'+
                                        '<i class="fa fa-pencil"></i>'+
                                        '</button>'+
                                        '<button type="button" class="btn btn-sm btn-warning btn-delete" id="btneliminar">'+
                                        '<span class="fa fa-trash"></span>'+
                                        '</button>'+
                                        '</div>'
                                    ]).draw( false );

                                    $('#newBuildout').removeAttrs('disabled');
                                }

                            }
                        });
                    }
                });


            });


            $('#saveProduct').on('click',function(){
                $('#modal-loading').modal('show');
                var size = $('#size').val();
                var type = $('#interesting').val();
                var state = $('#type').val();
                var price = $('#starting').val();

                $.ajax
                ({
                    url: 'updateprice',
                    data: "type="+type+"&size="+size+"&state="+state+"&price="+price,
                    type: 'get',
                    success: function(data)
                    {
                        $('#modal-loading').modal('hide');
                    }
                });
            });

            $('#interesting').on('change',function(){
                var id_interesting = $('#interesting').val();
                $('#type').html('');
                $('#size').html('');
                $('#size').removeAttr('title');
                $('#select2-type-container').html('**Select Data**');
                $('#select2-size-container').html('**Select Data**');
                $('#starting').val('0.00');
                $('#saveProduct').attr('disabled', 'disabled');
                $('#modal-loading').modal('show');
                oTable.clear().draw();
                $('#newBuildout').attr('disabled', 'disabled');

                $.ajax
                ({
                    url: '../orders/types/'+id_interesting,
                    data: '',
                    type: 'get',
                    success: function(data)
                    {
                        $('#type').append('<option value="">**Select Data**</option>');
                        for(var i=0;i<data.length;i++)
                        {
                            $('#type').append('<option value="'+data[i].id+'">'+data[i].state+'</option>');
                        }

                        $('#modal-loading').modal('hide');
                    }
                });
            });

            $('#type').on('change',function(){
                var type = $('#interesting').val();
                $('#size').html('');
                $('#select2-size-container').html('**Select Data**');
                $('#starting').val('0.00');
                $('#saveProduct').attr('disabled', 'disabled');
                $('#modal-loading').modal('show');
                oTable.clear().draw();
                $('#newBuildout').attr('disabled', 'disabled');

                $.ajax({
                    url: '../orders/sizes/'+type,
                    data: '',
                    type:  'get',
                    dataType: 'json',
                    success : function(data) {
                        $('#size').append('<option value="">**Select Data**</option>');
                        for(var i=0;i<data.length;i++)
                        {
                            $('#size').append('<option value="'+data[i].id+'">'+data[i].size+'</option>');
                        }

                        $('#modal-loading').modal('hide');

                    }
                });
            });

            $('#size').on('change',function(){
                $('#price').val('0.00');
                var type = $('#interesting').val();
                var size = $('#size').val();
                var state = $('#type').val();
                $('#modal-loading').modal('show');
                $('#saveProduct').removeAttrs('disabled');
                oTable.clear().draw();

                if($('#type').val() !=='' && $('#size').val() !== '') {
                    $.ajax({
                        url: '../orders/prices',
                        data: "type="+type+"&size="+size+"&state="+state,
                        type:  'get',
                        dataType: 'json',
                        success : function(data) {
                            var precio = new Number(data[0].price).toFixed(2);
                            $('#starting').val(precio);
                            $('#modal-loading').modal('hide');

                            $.ajax
                            ({
                                url: 'buildout',
                                data: "interesting="+type+"&size="+size,
                                type: 'get',
                                success: function(datas)
                                {
                                    for(var i=0;i<datas.length;i++)
                                    {
                                        oTable.row.add([
                                            datas[i].nombre,
                                            datas[i].descripcion,
                                            datas[i].precio,
                                            '<div class="btn-group" role="group" aria-label="..." id="'+datas[0].id+'">'+
                                            '<button type="button" class="btn btn-success btn-sm id="btneditar">'+
                                            '<i class="fa fa-pencil"></i>'+
                                            '</button>'+
                                            '<button type="button" class="btn btn-sm btn-warning btn-delete" id="btneliminar">'+
                                            '<span class="fa fa-trash"></span>'+
                                            '</button>'+
                                            '</div>'
                                        ]).draw( false );

                                        $('#newBuildout').removeAttrs('disabled');
                                    }

                                }
                            });
                        }
                    });

                }

            });

        });
    </script>

    <!-- Your html goes here -->
    <div class='panel panel-default'>

            <div class='panel-heading' style="background-color: #337ab7; color: white;">
                <strong><i class="fa fa-cubes"></i> {{trans('crudbooster.product')}} </strong>
            </div>

        <div class='panel-body'>
            <?php
            $action = CRUDBooster::mainpath("editsave");
            $return_url = ($return_url)?:g('return_url');
            ?>

            <form class='form-horizontal' id="form_quote_principal" enctype="multipart/form-data" action='<?php echo e($action); ?>'>

                <div class="row">
                    <div class='col-sm-3'>
                        <label>{{trans('crudbooster.product')}}*</label>
                        <a href="#" style="float: right" id="edit_interesting"><span class="fa fa-edit" aria-hidden="true"></span></a>

                        <select required class="form-control required" id="interesting" name="interesting">
                            <option>**Select Data**</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" id="{{ $type->id }}">{{ $type->type }}</option>;
                            @endforeach
                        </select>
                    </div>

                    <div class='col-sm-3'>
                        <label>{{trans('crudbooster.type')}}*</label>
                        <a href="#" style="float: right" id="edit_type"><span class="fa fa-edit" aria-hidden="true"></span></a>
                        <select required class="form-control required" id="type" name="type">
                            <option>**Select Data**</option>
                        </select>
                    </div>

                    <div class='col-sm-3'>
                        <label>{{trans('crudbooster.size')}}*</label>
                        <a href="#" style="float: right" id="edit_size"><span class="fa fa-edit" aria-hidden="true"></span></a>

                        <select required class="form-control required" id="size" name="size">
                            <option>**Select Data**</option>
                        </select>
                    </div>

                    <div class='col-sm-2'>
                        <label>{{trans('crudbooster.starting_with')}}*</label>
                        <input type='text' name='starting' id='starting' required class='form-control' value="0.00" />
                    </div>

                    <div class='col-sm-1'>
                        <label>&nbsp;</label>
                        <button type="button" disabled="disabled" id="saveProduct" title="Save" class="form-control btn btn-primary"><i class="fa fa-save"></i></button>
                    </div>

                </div>
            </form>
        </div>

    </div>

    <div class='panel panel-default'>
        <div class='panel-heading' style="background-color: #337ab7; color: white;">
            <strong><i class="fa fa-product-hunt"></i> {{trans('crudbooster.List_Buildout')}} </strong>
        </div>
        <button id="newBuildout" disabled="disabled" style="margin-left: 20px; margin-top: 20px;" class="btn btn-success pull-left" type="button" ><i class="fa fa-bars"></i> {{trans('crudbooster.add_buildout')}} </button>

        <div id="table_buildouts" class="table-responsive hover" style="margin: 70px;">
            <table id="buildouts" class="table table-striped table-responsive table-bordered" cellspacing="0">
                <thead>
                <tr>
                    <th>{{trans('crudbooster.buildout')}}</th>
                    <th>{{trans('crudbooster.description')}}</th>
                    <th>{{trans('crudbooster.price')}}</th>
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
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="Build_OutGModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7; color: white;">
                    <button type="button" id="closeModal5" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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

    <div class="modal fade" id="modal-loading" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-body">
                <img style="width: 64px;" src="<?php echo e(asset('assets/images/loading.gif')); ?>" alt="Loading">
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="newProductModal">
        <div class="modal-dialog modal-lg" role="document"  style=" width: 90%">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7; color: white;">
                    <button type="button" id="closeModal3" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('crudbooster.product_creation_new')}}</h4>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="col-md-7">
                            <form id="form_product" data-parsley-validate  action="" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label for="product_name" class="col-md-3 col-xs-12 col-sm-3 control-label">{{trans('crudbooster.product')}}</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input class="form-control" id="product_name" name="product_name" placeholder="{{trans('crudbooster.product')}}" type="text"/>                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-dark" id="closeCategoryCategory">{{trans('crudbooster.close')}}</button>--}}
                    <button type="submit" class="btn btn-primary" id="addProduct">{{trans('crudbooster.save')}}</button>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

@endsection