@extends('crudbooster::admin_template_fases')
@section('content')

    <script src='http://ezcrm.us/p/jquery-ui.custom.min.js'></script>
    <script src="http://ezcrm.us/p/jquery.ui.touch-punch.min.js"></script>
    <script src="http://ezcrm.us/p/chosen.jquery.min.js"></script>
    <script src="http://ezcrm.us/p/spinbox.min.js"></script>
    <script src="http://ezcrm.us/p/bootstrap-datepicker.min.js"></script>
    <script src="http://ezcrm.us/p/moment.min.js"></script>
    <script src="http://ezcrm.us/p/daterangepicker.min.js"></script>
    <script src="http://ezcrm.us/p/bootstrap-datetimepicker.min.js"></script>
    <script src="http://ezcrm.us/p/bootstrap-colorpicker.min.js"></script>
    <script src="http://ezcrm.us/p/jquery.knob.min.js"></script>
    <script src="http://ezcrm.us/p/autosize.min.js"></script>
    <script src="http://ezcrm.us/p/jquery.inputlimiter.min.js"></script>
    <script src="http://ezcrm.us/p/bootstrap-tag.min.js"></script>

    <!-- page specific plugin styles -->
    <link rel="stylesheet" href="http://ezcrm.us/p/dropzone.min.css" />
    <script src="http://ezcrm.us/p/dropzone.min.js"></script>

    <!-- ace scripts -->
    <script src="http://ezcrm.us/p/ace-elements.min.js"></script>
    <script src="http://ezcrm.us/p/ace.min.js"></script>

    <script>
        $(document).ready(function()
        {
            //Ocultar el mensaje de alerta pasados 4 segundos
            setTimeout("$(\"div[class*='alert alert-warning']\").fadeOut(350);", 2000);
            setTimeout("$(\"div[class*='alert alert-success']\").fadeOut(350);", 2000);

            $(document).on('click','.add-files',function(){
                var stages_id = $(this).data('id');
                $('#fases_id').val(stages_id);
                $('#newStageModal').modal('show');
            });

            $(document).on('click','.step-check-actual',function(){

                var stages_id = $(this).data('id');
                var stages_id_position = $(this).data('type');
                var item = $(this);
                var quote_id = $('#quotes_id').val();

                swal({
                        title: "Do you want to finalize this stage?",
                        text: "Stage "+stages_id_position,
                        type: "info",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true,
                    },
                    function(){
                        $.ajax({
                            url: '../../fases/stageterminate',
                            data: "step_id="+stages_id,
                            type:  'get',
                            dataType: 'json',
                            success : function(data) {
                                if (stages_id_position != 6) {
                                    item.removeClass('bg-gray');
                                    item.addClass('bg-blue');
                                } else {
                                    item.removeClass('bg-gray');
                                    item.addClass('bg-red');
                                }
                                window.location.href = 'http://ezcrm.us/crm/orders/detail/'+quote_id;
                            }
                        });
                    });




            });

            $(".btn-success").click(function(){
                var html = $(".clone").html();
                $(".increment").after(html);
                //$('.extra-input').children('input').addClass('required');
                //$('.extra-input').children('input').attr('required','required');
            });

            $("body").on("click",".btn-danger",function(){
                $(this).parents(".control-group").remove();
            });

        });
    </script>

    <div class="modal fade" id="modal-loading" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-body">
                <img style="width: 64px;" src="<?php echo e(asset('assets/images/loading.gif')); ?>" alt="Loading">
            </div>
        </div>
    </div>

    <!-- Your html goes here -->
    <p><a href='{{CRUDBooster::adminpath("customers25/detail/$client->id")}}'><i class='fa fa-chevron-circle-{{ trans('crudbooster.left') }}'></i> {{trans('crudbooster.Return_Client')}}: "{{ $client->name.' '.$client->lastname }}"</a></p>

    <div class='panel panel-default'>
        <div class='panel panel-default'>
            <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-product-hunt"></i> {{trans('crudbooster.Business_Name')}}: {{ $row->truck_name }}</strong></div>

            <div class="panel-body" style="padding:20px">
                <div class="right_col" role="main">
                    <div class="">
                        <div class="clearfix"></div>

                        <div class="row">

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_content" style="padding-top: 0px;">
                                <ul class="timeline">

                                        @foreach($steps as $step)
                                            <!-- timeline time label -->
                                            <li class="time-label">
                                                @if($step->id <= $quote->fases_id)
                                                    <span class="bg-blue">Stage {{ $step->fases_type_id }}</span>
                                                @else
                                                    <span class="bg-gray">Stage {{ $step->fases_type_id }}</span>
                                                @endif
                                            </li>

                                            <li>
                                                @if($step->id <= $quote->fases_id)
                                                    <i id="{{ $step->id }}" data-id="{{ $step->id }}" data-type="{{ $step->fases_type_id }}" class="fa fa-check-circle bg-blue step-check-active"></i>
                                                @elseif($step->id == $quote->fases_id+1 && $step->fases_type_id == 6 && $step->updated_at != null)
                                                    <i id="{{ $step->id }}" data-id="{{ $step->id }}" data-type="{{ $step->fases_type_id }}" class="fa fa-check-circle bg-red step-check-active"></i>
                                                @elseif($step->id == $quote->fases_id+1)
                                                    <i id="{{ $step->id }}" data-id="{{ $step->id }}" data-type="{{ $step->fases_type_id }}" class="fa fa-check-circle bg-gray step-check-actual"></i>
                                                @else
                                                    <i id="{{ $step->id }}" data-id="{{ $step->id }}" data-type="{{ $step->fases_type_id }}" class="fa fa-check-circle bg-gray step-check-disabled"></i>
                                                @endif

                                                <div class="timeline-item">
                                                    <span class="time" style="font-size: 13px">End Date:  <i class="fa fa-clock-o"></i> {{ $step->datetime }}</span>

                                                    <h3 class="timeline-header">
                                                        <a href="#" class="view_details">{{ $step->name }}</a>
                                                    </h3>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="timeline-item">
                                                    <div class="row">
                                                        <div class="col-md-9">

                                                            <!-- end of user messages -->
                                                            <ul class="timeline">
                                                                <?php
                                                                    if (count($fases_activity) == 0) {
                                                                ?>
                                                                    <li class="time-label">
                                                                        <span style="font-size: 14px">No Recent Activity</span>
                                                                    </li>
                                                                <?php
                                                                    } else {
                                                                ?>
                                                                    <li class="time-label">
                                                                        <span style="font-size: 14px">Recent Activity</span>
                                                                    </li>
                                                                <?php
                                                                    }
                                                                    $dateTemp = null;
                                                                ?>

                                                                @foreach($fases_activity as $activity)
                                                                    @if($activity->fases_id == $step->id)
                                                                        <li>
                                                                            <span  class="btn btn-success btn-xs">{{ $activity->created_at }}</span>
                                                                            <div class="timeline-item">
                                                                                <p>-{{ $activity->description }}</p>
                                                                            </div>
                                                                        </li>
                                                                    @endif
                                                                @endforeach

                                                            </ul>
                                                            <!-- end of user messages -->


                                                        </div>

                                                        <div class="col-md-3">
                                                            <h4 style="text-align: right">{{trans('crudbooster.stages_files')}}</h4>
                                                            <ul class="list-unstyled project_files" style="text-align: right">
                                                                <?php
                                                                $files = explode(';', $step->files);

                                                                foreach ($files as $item)
                                                                {
                                                                $extension = explode('.', $item);

                                                                //pdf,xls,xlsx,doc,docx,txt,zip,rar,7z
                                                                if ($extension[1] == 'jpg' || $extension[1] == 'png'|| $extension[1] == 'jpeg'|| $extension[1] == 'gif'|| $extension[1] == 'bmp')
                                                                {
                                                                ?>
                                                                <li>
                                                                    <a title="{{trans('crudbooster.click_to_view')}}" data-lightbox="roadtrip" href="http://ezcrm.us/files/{{$item}}"><i class="fa fa-picture-o"></i><?php print_r($item); ?></a>
                                                                </li>
                                                                <?php
                                                                }
                                                                else if($item != '')
                                                                {
                                                                ?>
                                                                <li>
                                                                    <a title="{{trans('crudbooster.click_to_view')}}" href="http://ezcrm.us/files/{{$item}}" target="_blank"><i class="fa fa-file-pdf-o"></i><?php print_r($item); ?></a>
                                                                </li>
                                                                <?php
                                                                }
                                                                else
                                                                {
                                                                ?>
                                                                <li>
                                                                    <button type="button" class="btn btn-danger btn-xs">{{trans('crudbooster.no_files')}}</button>
                                                                </li>
                                                                <?php
                                                                }
                                                                }
                                                                ?>
                                                            </ul>
                                                            <br>

                                                            <div class="text-right mtop20">
                                                                @if($step->id <= $quote->fases_id)
                                                                    <a href="#" data-quote="{{ $step->orders_id }}" data-id="{{ $step->id }}" class="btn btn-sm btn-primary add-files">{{trans('crudbooster.add_files')}}</a>
                                                                @else
                                                                    <a href="#" data-quote="{{ $step->orders_id }}" data-id="{{ $step->id }}" class="disabled btn btn-sm btn-primary add-files">{{trans('crudbooster.add_files')}}</a>
                                                                @endif


                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="newStageModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337ab7; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('crudbooster.Stage\'s Information')}}</h4>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">

                        <div class="col-md-12">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <h3 class="jumbotron">Multiple File Upload</h3>
                            <form method="post" action="{{url('file')}}" enctype="multipart/form-data">
                                {{csrf_field()}}

                                <input type="hidden" id="fases_id" name="fases_id">
                                <input type="hidden" id="quotes_id" name="quotes_id" value="{{ $id }}">

                                <div class="input-group control-group increment" >
                                    <input type="file" name="filename[]" class="form-control">
                                    <div class="input-group-btn">
                                        <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus-sign"></i></button>
                                    </div>
                                </div>
                                <div class="clone hide">
                                    <div class="control-group input-group extra-input" style="margin-top:10px">
                                        <input type="file" name="filename[]" class="form-control">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                        </div>
                                    </div>
                                </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">{{trans('crudbooster.close')}}</button>
                    <button type="submit" class="btn btn-primary" id="">{{trans('crudbooster.save')}}</button>
                </div>
                </form>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>



@endsection