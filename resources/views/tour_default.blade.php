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
    <div class='row' style="background-color: whitesmoke;">
        <div class="col-md-4 col-sm-4">
            <img style="margin: 10%;" width="90%" src="{{asset('assets/images/default.png')}}">
        </div>

        <div class="col-md-8 col-sm-8" style="text-align: center;">
            <div id="crm_register_button" style="display: block; text-align: center;">
                <h3 style="margin-top: 10%;margin-left: 10%;margin-right: 10%;margin-bottom: 5%; color: #204d74; text-align: center; font-family: 'Droid Arabic Naskh', serif;">{{trans("crudbooster.text_tour_promotion")}} </h3>
                <div style="text-align: center">
                    <input id="crm_gratis" style="padding: 15px; font-size: 18px;" type='button' class='btn btn-primary' value='{{ trans('crudbooster.crm_gratis') }}'/>
                </div>
            </div>

            <div id="crm_register_form" style="display: none;">


                <form class="form-horizontal" method="get" id="form" enctype="multipart/form-data" action="http://18.220.213.59/register_client">

                    <h2 style="text-align: center;"><img width="20%" src="{{asset('vendor/crudbooster/assets/logo_eazycrm.png')}}"></h2>


                    <div class="row">
                        <div class='col-sm-2'>
                        </div>
                        <div class='col-sm-4'>
                            <label style="color: black">{{trans('crudbooster.name')}}*</label>
                            <input type='text' name='name' id="name" required class='form-control'/>
                        </div>

                        <div class='col-sm-4'>
                            <label style="color: black">{{trans('crudbooster.lastname')}}*</label>
                            <input type='text' name='lastname' id="lastname" required class='form-control'/>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class='col-sm-2'>
                        </div>
                        <div class='col-sm-4'>
                            <label style="color: black">{{trans('crudbooster.email')}}*</label>
                            <input type="email" title="Email" required="" maxlength="255" class="form-control" name="email" id="email">
                        </div>

                        <div class='col-sm-4'>
                            <label style="color: black">{{trans('crudbooster.password')}}*</label>
                            <input autocomplete='off' type="password" class="form-control" name='password' id="password" required />
                        </div>
                    </div>

                    <div style="margin:10px" class='row'>
                        <div class='col-xs-4'> </div>

                        <div class='col-xs-3'>
                            <h2 style="text-align: center;">
                                <input id="access" style="font-size: 16px; margin-left: 30%" type='submit' class='btn btn-primary' value='{{ trans('crudbooster.access') }}'/>
                            </h2>

                        </div>
                    </div>

                    <div class='row'>
                        <div class='col-xs-12' align="center"><p style="padding:0px 0px 0px 0px; color: black;">{{trans("crudbooster.text_client")}} <a href='{{route("getLogin")}}'>{{trans("crudbooster.click_here")}}</a>   </p></div>
                    </div>
            </div>
        </div>

    </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {

            $('#crm_gratis').on('click',function(){
                $('#crm_register_form').css('display','block');
                $('#crm_register_button').css('display','none');
            });


        });
    </script>
@endsection