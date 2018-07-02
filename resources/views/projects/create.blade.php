@extends('crudbooster::admin_template')
@section('content')

    <script>
        $(document).ready(function() {
            $("#form_project").validate({
                rules: {
                    economy: { required: true, email: true},
                    design: { required: true, email: true},
                    sales: { required: true, email: true},
                    production_manager: { required: true, email: true}
                },
                messages: {
                    economy : "The email's format is incorrect.",
                    design : "The email's format is incorrect.",
                    sales : "The email's format is incorrect.",
                    production_manager : "The email's format is incorrect.",
                }
            });
        });

    </script>

    <!-- Your html goes here -->
    <div class='panel panel-default'>

        <div class='panel-heading' style="background-color: #337ab7; color: white;">
            <strong><i class="fa fa-cubes"></i> {{trans('crudbooster.information')}} </strong>
        </div>

        <div class='panel-body'>
            <?php
            $action = CRUDBooster::mainpath("editsave");
            $return_url = ($return_url)?:g('return_url');
            ?>

            <form class='form-horizontal' id="form_project" enctype="multipart/form-data" action='<?php echo e($action); ?>'>

                <div class="row">
                    <div class='col-sm-6'>
                        <label>{{trans('crudbooster.economy')}}*</label>
                        <input type='text' name='economy' id='economy' required email class='form-control email' value="{{ $result->economy }}" />
                    </div>

                    <div class='col-sm-6'>
                        <label>{{trans('crudbooster.design')}}*</label>
                        <input type='text' name='design' id='design' required class='form-control' value="{{ $result->design }}" />
                    </div>
                </div>

                </br>

                <div class="row">
                    <div class='col-sm-6'>
                        <label>{{trans('crudbooster.sales')}}*</label>
                        <input type='text' name='sales' id='sales' required class='form-control' value="{{ $result->sales }}" />
                    </div>

                    <div class='col-sm-6'>
                        <label>{{trans('crudbooster.production_manager')}}*</label>
                        <input type='text' name='production_manager' id='production_manager' required class='form-control' value="{{ $result->production_manager }}" />
                    </div>

                </div>

                <div class="row">
                    <div class='pull-right' style="padding-right: 15px">
                        <label>&nbsp;</label>
                        <input type="submit" id="saveProject" title="Save" class="form-control btn btn-primary" value="{{trans('crudbooster.save')}}" />
                    </div>
                </div>
            </form>
        </div>

    </div>

@endsection