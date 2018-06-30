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

    <script src="http://127.0.0.1:8000/js/buildouts.js"></script>
    <script src="http://127.0.0.1:8000/js/products.js"></script>

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

                <div class="modal-body" >
                    <div class="container-fluid">
                        <div class="col-md-12">
                            <form id="form_product" data-parsley-validate  action="" method="post" class="form-horizontal">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>{{trans('crudbooster.product')}}</label>
                                        <input class="form-control required" required id="product_name" name="product_name" placeholder="{{trans('crudbooster.product')}}" type="text"/>
                                    </div>
                                    <div class="col-md-2">
                                        <label>&nbsp;</label>
                                        <button id="newProduct" class="form-control btn btn-success pull-left" type="button"> {{trans('crudbooster.add')}} </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

                <div id="table_products" class="table-responsive hover" style="margin: 2%;">
                    <table id="products" class="table table-striped table-responsive table-bordered" cellspacing="0">
                        <thead>
                        <tr>
                            <th>{{trans('crudbooster.product')}}</th>
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

                <div class="modal-footer"></div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

@endsection