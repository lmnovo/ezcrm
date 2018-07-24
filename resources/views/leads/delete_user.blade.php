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
        <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-user"></i> Asignar Prospectos/Clientes a Responsable</strong></div>

        <div class="panel-body" style="padding:20px 0px 0px 0px">
            <?php
            $action = CRUDBooster::adminpath("users/assignto");
            $return_url = ($return_url)?:g('return_url');
            ?>

            <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>
                <input type="hidden" name="_token" value="04WEmigxCcCs05dhAXuQZvlOTccK4fKUG3OrTpQO">
                <input type="hidden" name="return_url" value="http://18.222.4.15/crm/campaigns?m=61">
                <input type="hidden" name="ref_mainpath" value="http://18.222.4.15/crm/campaigns">
                <input type="hidden" name="ref_parameter" value="return_url=http://18.222.4.15/crm/campaigns?m=61">
                <input type="hidden" name="original_user" value="<?php echo e($id); ?>">
                <div class="box-body" id="parent-form-area">

                    <style type="text/css">
                        #table-detail tr td:first-child {
                            font-weight: bold;
                            width: 25%;
                        }
                    </style>

                    <div class="form-group">
                        <label style="color: green; font-size: 16px;" class="control-label col-md-9 col-sm-9 col-xs-12" for="title">Select the person in charge that will assume the leads and the user John's clients <span class="required">*</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">{{ trans('crudbooster.assign_to') }} <span class="required">*</span>
                        </label>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="assignto" placeholder="Select" name="assignto" required>
                                <option></option>

                                @foreach($users as $user)
                                    @if($step->cms_users_id == $user->id)
                                        <option selected="true" value="{{ $user->id }}" id="{{ $user->id }}">{{ $user->name }}</option>;
                                    @else
                                        <option value="{{ $user->id }}" id="{{ $user->id }}">{{ $user->name }}</option>;
                                    @endif
                                @endforeach
                            </select>
                            <input style="float: right; margin-top: 10px;" type='submit' class='btn btn-primary' id="saveStep" value='Save'/>
                        </div>

                    </div>



                </div><!-- /.box-body -->


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