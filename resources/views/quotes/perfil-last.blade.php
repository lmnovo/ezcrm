@extends('crudbooster::admin_template_fases')
@section('content')
    <!-- Your html goes here -->
    <p><a href='{{CRUDBooster::adminpath("customers25/detail/$client->id")}}'><i class='fa fa-chevron-circle-{{ trans('crudbooster.left') }}'></i> Return to Client: "{{ $client->name.' '.$client->lastname }}"</a></p>

    <div class='panel panel-default'>
        <div class='panel panel-default'>
            <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-product-hunt"></i> Quote (Business Name: {{ $row->truck_name }}) </strong></div>

            <div class="panel-body" style="padding:20px 0px 0px 0px">
                <div class="right_col" role="main">
                    <div class="">
                        <div class="clearfix"></div>

                        <div class="row">

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Project's Phases</h2>

                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content" style="padding-top: 0px;">

                                        <!-- Smart Wizard -->
                                        <div id="wizard" class="form_wizard wizard_horizontal">
                                            <ul class="wizard_steps">
                                                <li>
                                                    <a href="#step-1">
                                                        <span class="step_no">1</span>
                                                        <span class="step_descr">
                                                                         @if( $phases1->name != null )
                                                                {{ $phases1->name }}
                                                            @else
                                                                Step 1
                                                            @endif<br />

                                                            @if( $isCompletedPhase1 != null )
                                                                <small style="color: #00a157;"><strong>Status: Completed</strong></small>
                                                            @else
                                                                <small style="color: red;"><strong>Status: Pending</strong></small>
                                                            @endif

                                                                    </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#step-2">
                                                        <span class="step_no">2</span>
                                                        <span class="step_descr">
                                                                         @if( $phases2->name != null )
                                                                {{ $phases2->name }}
                                                            @else
                                                                Step 2
                                                            @endif<br />

                                                            @if( $isCompletedPhase2 != null )
                                                                <small style="color: #00a157;"><strong>Status: Completed</strong></small>
                                                            @else
                                                                <small style="color: red;"><strong>Status: Pending</strong></small>
                                                            @endif

                                                                    </span>

                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#step-3">
                                                        <span class="step_no">3</span>
                                                        <span class="step_descr">
                                                                         @if( $phases3->name != null )
                                                                {{ $phases3->name }}
                                                            @else
                                                                Step 3
                                                            @endif<br />

                                                            @if( $isCompletedPhase3 != null )
                                                                <small style="color: #00a157;"><strong>Status: Completed</strong></small>
                                                            @else
                                                                <small style="color: red;"><strong>Status: Pending</strong></small>
                                                            @endif

                                                                    </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#step-4">
                                                        <span class="step_no">4</span>
                                                        <span class="step_descr">
                                                                         @if( $phases4->name != null )
                                                                {{ $phases4->name }}
                                                            @else
                                                                Step 4
                                                            @endif<br />

                                                            @if( $isCompletedPhase4 != null )
                                                                <small style="color: #00a157;"><strong>Status: Completed</strong></small>
                                                            @else
                                                                <small style="color: red;"><strong>Status: Pending</strong></small>
                                                            @endif

                                                                    </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#step-5">
                                                        <span class="step_no">5</span>
                                                        <span class="step_descr">
                                                                         @if( $phases5->name != null )
                                                                {{ $phases5->name }}
                                                            @else
                                                                Step 5
                                                            @endif
                                                            <br />

                                                            @if( $isCompletedPhase5 != null )
                                                                <small style="color: #00a157;"><strong>Status: Completed</strong></small>
                                                            @else
                                                                <small style="color: red;"><strong>Status: Pending</strong></small>
                                                            @endif

                                                                    </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#step-6">
                                                        <span class="step_no">6</span>
                                                        <span class="step_descr">
                                                                         @if( $phases6->name != null )
                                                                {{ $phases6->name }}
                                                            @else
                                                                Step 6
                                                            @endif
                                                            <br />

                                                            @if( $isCompletedPhase6 != null )
                                                                <small style="color: #00a157;"><strong>Status: Completed</strong></small>
                                                            @else
                                                                <small style="color: red;"><strong>Status: Pending</strong></small>
                                                            @endif

                                                                    </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#step-7">
                                                        <span class="step_no">7</span>
                                                        <span class="step_descr">
						                                        @if( $phases7->name != null )
                                                                {{ $phases7->name }}
                                                            @else
                                                                Step 7
                                                            @endif
                                                            <br />

                                                            @if( $isCompletedPhase7 != null )
                                                                <small style="color: #00a157;"><strong>Status: Completed</strong></small>
                                                            @else
                                                                <small style="color: red;"><strong>Status: Pending</strong></small>
                                                            @endif
					                                    </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#step-8">
                                                        <span class="step_no">8</span>
                                                        <span class="step_descr">
						                                        @if( $phases8->name != null )
                                                                {{ $phases8->name }}
                                                            @else
                                                                Step 8
                                                            @endif
                                                            <br />

                                                            @if( $isCompletedPhase8 != null )
                                                                <small style="color: #00a157;"><strong>Status: Completed</strong></small>
                                                            @else
                                                                <small style="color: red;"><strong>Status: Pending</strong></small>
                                                            @endif
					                                    </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#step-9">
                                                        <span class="step_no">9</span>
                                                        <span class="step_descr">
						                                        @if( $phases9->name != null )
                                                                {{ $phases9->name }}
                                                            @else
                                                                Step 9
                                                            @endif
                                                            <br />

                                                            @if( $isCompletedPhase9 != null )
                                                                <small style="color: #00a157;"><strong>Status: Completed</strong></small>
                                                            @else
                                                                <small style="color: red;"><strong>Status: Pending</strong></small>
                                                            @endif
					                                    </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#step-10">
                                                        <span class="step_no">10</span>
                                                        <span class="step_descr">
						                                        @if( $phases10->name != null )
                                                                {{ $phases10->name }}
                                                            @else
                                                                Step 10
                                                            @endif
                                                            <br />

                                                            @if( $isCompletedPhase10 != null )
                                                                <small style="color: #00a157;"><strong>Status: Completed</strong></small>
                                                            @else
                                                                <small style="color: red;"><strong>Status: Pending</strong></small>
                                                            @endif
					                                    </span>
                                                    </a>
                                                </li>

                                            </ul>
                                            <div id="step-1" style="padding-top: 0px;">
                                                <h2 class="StepTitle">Step 1 Content</h2>

                                                <?php
                                                $action = CRUDBooster::adminpath("orders/steps");
                                                $return_url = ($return_url)?:g('return_url');
                                                ?>

                                                <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>
                                                    <input type="hidden" name="customer_id" value="<?php echo e($id); ?>" />
                                                    <input type="hidden" name="fase_id" value="<?php echo e(1); ?>" />

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Step Name <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases1->name }}" type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases1->email }}" type="text" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Date <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases1->datetime }}"  type="text" name="date_1" id="date_1" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea name="notes" id="notes" class="form-control" rows="5">{{ $phases1->notes }}</textarea>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                            <div id="step-2" style="padding-top: 0px;">
                                                <h2 class="StepTitle">Step 2 Content</h2>
                                                <?php
                                                $action = CRUDBooster::adminpath("orders/steps");
                                                $return_url = ($return_url)?:g('return_url');
                                                ?>

                                                <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>
                                                    <input type="hidden" name="customer_id" value="<?php echo e($id); ?>" />
                                                    <input type="hidden" name="fase_id" value="2" />

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Step Name <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases2->name }}" type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases2->email }}" type="text" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Date <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases2->datetime }}"  type="text" name="date_2" id="date_2" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea name="notes" id="notes" class="form-control" rows="5">{{ $phases2->notes }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-10"></div>
                                                        <div class="col-md-2">
                                                            <input type="submit" value="Step Save" class="btn btn-primary">
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                            <div id="step-3" style="padding-top: 0px;">
                                                <h2 class="StepTitle">Step 3 Content</h2>
                                                <?php
                                                $action = CRUDBooster::adminpath("orders/steps");
                                                $return_url = ($return_url)?:g('return_url');
                                                ?>

                                                <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>
                                                    <input type="hidden" name="customer_id" value="<?php echo e($id); ?>" />
                                                    <input type="hidden" name="fase_id" value="3" />

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Step Name <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases3->name }}" type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases3->email }}" type="text" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Date <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases3->datetime }}"  type="text" name="date_3" id="date_3" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea name="notes" id="notes" class="form-control" rows="5">{{ $phases3->notes }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-10"></div>
                                                        <div class="col-md-2">
                                                            <input type="submit" value="Step Save" class="btn btn-primary">
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                            <div id="step-4" style="padding-top: 0px;">
                                                <h2 class="StepTitle">Step 4 Content</h2>
                                                <?php
                                                $action = CRUDBooster::adminpath("orders/steps");
                                                $return_url = ($return_url)?:g('return_url');
                                                ?>

                                                <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>
                                                    <input type="hidden" name="customer_id" value="<?php echo e($id); ?>" />
                                                    <input type="hidden" name="fase_id" value="4" />

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Step Name <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases4->name }}" type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases4->email }}" type="text" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Date <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases4->datetime }}"  type="text" name="date_4" id="date_4" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea name="notes" id="notes" class="form-control" rows="5">{{ $phases4->notes }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-10"></div>
                                                        <div class="col-md-2">
                                                            <input type="submit" value="Step Save" class="btn btn-primary">
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                            <div id="step-5" style="padding-top: 0px;">
                                                <h2 class="StepTitle">Step 5 Content</h2>
                                                <?php
                                                $action = CRUDBooster::adminpath("orders/steps");
                                                $return_url = ($return_url)?:g('return_url');
                                                ?>

                                                <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>
                                                    <input type="hidden" name="customer_id" value="<?php echo e($id); ?>" />
                                                    <input type="hidden" name="fase_id" value="5" />

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Step Name <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases5->name }}" type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases5->email }}" type="text" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Date <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases5->datetime }}"  type="text" name="date_5" id="date_5" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea name="notes" id="notes" class="form-control" rows="5">{{ $phases5->notes }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-10"></div>
                                                        <div class="col-md-2">
                                                            <input type="submit" value="Step Save" class="btn btn-primary">
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                            <div id="step-6" style="padding-top: 0px;">
                                                <h2 class="StepTitle">Step 6 Content</h2>
                                                <?php
                                                $action = CRUDBooster::adminpath("orders/steps");
                                                $return_url = ($return_url)?:g('return_url');
                                                ?>

                                                <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>
                                                    <input type="hidden" name="customer_id" value="<?php echo e($id); ?>" />
                                                    <input type="hidden" name="fase_id" value="6" />

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Step Name <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases6->name }}" type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases6->email }}" type="text" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Date <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases6->datetime }}"  type="text" name="date_6" id="date_6" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea name="notes" id="notes" class="form-control" rows="5">{{ $phases6->notes }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-10"></div>
                                                        <div class="col-md-2">
                                                            <input type="submit" value="Step Save" class="btn btn-primary">
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                            <div id="step-7" style="padding-top: 0px;">
                                                <h2 class="StepTitle">Step 7 Content</h2>
                                                <?php
                                                $action = CRUDBooster::adminpath("orders/steps");
                                                $return_url = ($return_url)?:g('return_url');
                                                ?>

                                                <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>
                                                    <input type="hidden" name="customer_id" value="<?php echo e($id); ?>" />
                                                    <input type="hidden" name="fase_id" value="7" />

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Step Name <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases7->name }}" type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases7->email }}" type="text" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Date <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases7->datetime }}"  type="text" name="date_7" id="date_7" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea name="notes" id="notes" class="form-control" rows="5">{{ $phases7->notes }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-10"></div>
                                                        <div class="col-md-2">
                                                            <input type="submit" value="Step Save" class="btn btn-primary">
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                            <div id="step-8" style="padding-top: 0px;">
                                                <h2 class="StepTitle">Step 8 Content</h2>
                                                <?php
                                                $action = CRUDBooster::adminpath("orders/steps");
                                                $return_url = ($return_url)?:g('return_url');
                                                ?>

                                                <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>
                                                    <input type="hidden" name="customer_id" value="<?php echo e($id); ?>" />
                                                    <input type="hidden" name="fase_id" value="8" />

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Step Name <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases8->name }}" type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases8->email }}" type="text" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Date <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases8->datetime }}"  type="text" name="date_8" id="date_8" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea name="notes" id="notes" class="form-control" rows="5">{{ $phases8->notes }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-10"></div>
                                                        <div class="col-md-2">
                                                            <input type="submit" value="Step Save" class="btn btn-primary">
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                            <div id="step-9" style="padding-top: 0px;">
                                                <h2 class="StepTitle">Step 9 Content</h2>
                                                <?php
                                                $action = CRUDBooster::adminpath("orders/steps");
                                                $return_url = ($return_url)?:g('return_url');
                                                ?>

                                                <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>
                                                    <input type="hidden" name="customer_id" value="<?php echo e($id); ?>" />
                                                    <input type="hidden" name="fase_id" value="9" />

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Step Name <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases9->name }}" type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases9->email }}" type="text" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Date <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases9->datetime }}"  type="text" name="date_9" id="date_9" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea name="notes" id="notes" class="form-control" rows="5">{{ $phases9->notes }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-10"></div>
                                                        <div class="col-md-2">
                                                            <input type="submit" value="Step Save" class="btn btn-primary">
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                            <div id="step-10" style="padding-top: 0px;">
                                                <h2 class="StepTitle">Step 10 Content</h2>
                                                <?php
                                                $action = CRUDBooster::adminpath("orders/steps");
                                                $return_url = ($return_url)?:g('return_url');
                                                ?>

                                                <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>
                                                    <input type="hidden" name="customer_id" value="<?php echo e($id); ?>" />
                                                    <input type="hidden" name="fase_id" value="10" />

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Step Name <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases10->name }}" type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases10->email }}" type="text" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Date <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input value="{{ $phases10->datetime }}"  type="text" name="date_10" id="date_10" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea name="notes" id="notes" class="form-control" rows="5">{{ $phases10->notes }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-10"></div>
                                                        <div class="col-md-2">
                                                            <input type="submit" value="Step Save" class="btn btn-primary">
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>

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