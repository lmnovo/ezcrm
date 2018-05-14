@extends('crudbooster::admin_template_fases')
@section('content')
    <!-- Your html goes here -->
    <p><a href='{{CRUDBooster::adminpath("customers25/detail/$client->id")}}'><i class='fa fa-chevron-circle-{{ trans('crudbooster.left') }}'></i> {{trans('crudbooster.Return_Client')}}: "{{ $client->name.' '.$client->lastname }}"</a></p>

    <div class='panel panel-default'>
        <div class='panel panel-default'>
            <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-product-hunt"></i> {{trans('crudbooster.quote')}} ({{trans('crudbooster.Business_Name')}}: {{ $row->truck_name }}) </strong></div>

            <div class="panel-body" style="padding:20px 0px 0px 0px">
                <div class="right_col" role="main">
                    <div class="">
                        <div class="clearfix"></div>

                        <div class="row">

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>{{trans('crudbooster.title_phase')}} -
                                            <span style="color: green">{{trans('crudbooster.current_phase')}}: {{ $stepActual }} ({{ $stepActualName }})</span>
                                            <input type="hidden" name="currentPhase" id="currentPhase" value="{{ $stepActual }}" />
                                        </h2>


                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content" style="padding-top: 0px;">

                                        <!-- Smart Wizard -->
                                        <div id="wizard" class="form_wizard wizard_horizontal">
                                            <ul class="wizard_steps">

                                                @foreach($steps as $step)
                                                    <li>
                                                        <a id="prueba_{{ $step->fases_type_id }}" href="#step-{{ $step->fases_type_id }}">
                                                            <span class="step_no">{{ $step->fases_type_id }}</span>
                                                            <span class="step_descr">
                                                                @if( $step->name != null )
                                                                        {{ $step->name }}
                                                                    @else
                                                                        Step {{ $step->fases_type_id }}
                                                                @endif<br />

                                                                    {{--@if( $isCompletedPhase1 != null )
                                                                        <small style="color: #00a157;"><strong>Status: Completed</strong></small>
                                                                    @else
                                                                        <small style="color: red;"><strong>Status: Pending</strong></small>
                                                                    @endif--}}

                                                            </span>
                                                        </a>
                                                    </li>
                                                @endforeach


                                            </ul>

                                            @foreach($steps as $step)
                                                <div id="step-{{ $step->fases_type_id }}" style="padding-top: 0px;">
                                                    <h2 class="StepTitle">{{trans('crudbooster.content')}} {{trans('crudbooster.step')}} {{ $step->fases_type_id }} </h2>

                                                    <?php
                                                        $action = CRUDBooster::adminpath("orders/steps");
                                                        $return_url = ($return_url)?:g('return_url');
                                                    ?>

                                                    <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>

                                                        <input type="hidden" name="orders_id" value="<?php echo e($id); ?>" />
                                                        <input type="hidden" name="fase_id" value="<?php echo e($step->fases_type_id); ?>" />

                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{ trans('crudbooster.step_name') }} <span class="required">*</span>
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <input value="{{ $step->name }}" type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">{{ trans('crudbooster.email') }} <span class="required">*</span>
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <input value="{{ $step->email }}" type="text" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12">
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">{{ trans('crudbooster.date') }} <span class="required">*</span>
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <input value="{{ $step->datetime }}"  type="text" name="date_{{ $step->fases_type_id }}" id="date_{{ $step->fases_type_id }}" required="required" class="form-control col-md-7 col-xs-12">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">{{ trans('crudbooster.notes') }} <span class="required">*</span>
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <textarea name="notes" id="notes" class="form-control" required="required" rows="5">{{ $step->notes }}</textarea>
                                                            </div>
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
                                                            </div>
                                                        </div>


                                                        @if($stepActual >= $step->fases_type_id)
                                                                <input style="float: right" type='submit' class='btn btn-primary' id="saveStep" value='{{trans('crudbooster.save_step')}}'/>
                                                            @else
                                                                <input style="float: right" type='submit' class='btn btn-primary disabled' disabled id="saveStep" value='{{trans('crudbooster.save_step')}}'/>
                                                        @endif

                                                    </form>


                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="file"> <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-5 col-sm-5 col-xs-12">
                                                            @if ($message = Session::get('success'))
                                                                <div class="alert alert-success alert-block">
                                                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                                                    <strong>{{ $message }}</strong>
                                                                </div>
                                                            @endif

                                                            @if (count($errors) > 0)
                                                                <div class="alert alert-danger">
                                                                    <strong>Whoops!</strong> There were some problems with your input.
                                                                    <ul>
                                                                        @foreach ($errors->all() as $error)
                                                                            <li>{{ $error }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif

                                                            {!! Form::open(array('route' => 'image.upload.post', 'action'=>4, 'files'=>true)) !!}
                                                            {!! Form::file('image', array('class' => 'form-control')) !!}

                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="submit" class="btn btn-success">{{trans('crudbooster.upload')}}</button>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach




                                        </div>
                                        <!-- End SmartWizard Content -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



@endsection