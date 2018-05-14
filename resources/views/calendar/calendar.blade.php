<!-- First, extends to the CRUDBooster Layout -->
@extends('admin_template')
@section('content')

    @if(CRUDBooster::getCurrentMethod() != 'getProfile' && $button_cancel)
        @if(g('return_url'))
            <p><a title='Return' href='{{g("return_url")}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
        @else
            <p><a title='Main Module' href='{{CRUDBooster::mainpath()}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
        @endif
    @endif

    <!-- Your html goes here -->
    <div class='panel panel-default'>
        <div class="panel-heading">
            <strong><i class='{{CRUDBooster::getCurrentModule()->icon}}'></i> Task Calendar Information </strong>
        </div>

        <div class="row">
            {{--<div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h4 class="box-title">Task Types</h4>
                    </div>
                    <div class="box-body">
                        <!-- the events -->
                        <div id="external-events">
                            @foreach ($taskTypes as $type)
                                <div class="external-event bg-{{ $type->color }}"> {{ $type->name }} </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>--}}

            <div class="col-md-12">
                <div class='panel-body' style="width: 100%">
                    {!! $calendar->calendar() !!}

                    {!! $calendar->script() !!}
                </div>
            </div>

        </div>

    </div>

@endsection