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