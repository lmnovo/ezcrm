<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template_tour')
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
        <div class='panel-heading' style="background-color: #337ab7; color: white;"><strong><i class="fa fa-user"></i> {{ trans('crudbooster.Create_Clients') }}</strong></div>

        <div class="panel-body" style="padding:20px 0px 0px 0px">
            <form class="form-horizontal" method="post" id="form" enctype="multipart/form-data" action="http://127.0.0.1:8000/crm/campaigns/edit-save/2">
                <input type="hidden" name="_token" value="04WEmigxCcCs05dhAXuQZvlOTccK4fKUG3OrTpQO">
                <input type="hidden" name="return_url" value="http://127.0.0.1:8000/crm/campaigns?m=61">
                <input type="hidden" name="ref_mainpath" value="http://127.0.0.1:8000/crm/campaigns">
                <input type="hidden" name="ref_parameter" value="return_url=http://127.0.0.1:8000/crm/campaigns?m=61">
                <div class="box-body" id="parent-form-area">

                    <style type="text/css">
                        #table-detail tr td:first-child {
                            font-weight: bold;
                            width: 25%;
                        }
                    </style>
                </div><!-- /.box-body -->

                <video width="100%" height="100%" controls
                       poster="{{asset('tour/preview.jpeg')}}" >
                    <source
                            src="{{asset('tour/add-clients.webm')}}"
                            type="video/webm">

                    Your browser doesn't support HTML5 video tag.
                </video>


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