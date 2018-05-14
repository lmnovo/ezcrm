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
        <div class='panel-heading'><strong><i class="fa fa-envelope-o"></i> {{ trans('crudbooster.detail_campaign') }} </strong></div>

        <div class="panel-body" style="padding:20px 0px 0px 0px">
            <form class="form-horizontal" method="post" id="form" enctype="multipart/form-data" action="http://127.0.0.1:8000/crm/campaigns/edit-save/2">

                <div class="box-body" id="parent-form-area">

                    <style type="text/css">
                        #table-detail tr td:first-child {
                            font-weight: bold;
                            width: 25%;
                        }
                    </style>
                    <div class="table-responsive">
                        <table id="table-detail" class="table table-striped">
                            <tbody>
                            <tr>
                                <td>{{ trans('crudbooster.Name_Campaign') }}</td><td>{{ $row->name }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('crudbooster.Content') }}</td><td>
                                    <textarea id='campaign_content' name='campaign_content' contenteditable="true" class='form-control wysiwyg'>
                                        {{ $row->content }}
                                    </textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ trans('crudbooster.Type_Campaign') }}</td><td>{{ $row->type }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('crudbooster.Total_Sent') }}</td><td>{{ $row->total_send }}</td>
                            </tr>


                        @foreach ($senders as $sender)
                            <tr>
                                @if ($loop->first)
                                        <td>{{ trans('crudbooster.Sent_To') }}</td><td>{{ $sender }}</td>
                                    @else
                                        <td></td><td>{{ $sender }}</td>
                                @endif
                            </tr>


                        @endforeach


                            </tbody>
                        </table>

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