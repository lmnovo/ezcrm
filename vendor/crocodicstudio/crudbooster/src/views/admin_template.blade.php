<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ ($page_title)?CRUDBooster::getSetting('appname').': '.strip_tags($page_title):"Admin Area" }}</title>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta name='generator' content='CRUDBooster 5.3'/>
    <meta name='robots' content='noindex,nofollow'/>
    <link rel="shortcut icon" href="{{ CRUDBooster::getSetting('favicon')?asset(CRUDBooster::getSetting('favicon')):asset('vendor/crudbooster/assets/logo_crudbooster.png') }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    @include('crudbooster::admin_template_plugins')

    <!-- Theme style -->
    <link href="{{ asset("vendor/crudbooster/assets/adminlte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("vendor/crudbooster/assets/adminlte/dist/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="http://ezcrm.us/vendor/crudbooster/assets/summernote/summernote.css">
    <script type="text/javascript" src="http://ezcrm.us/vendor/crudbooster/assets/summernote/summernote.js"></script>

    <link rel='stylesheet' href='http://ezcrm.us/vendor/crudbooster/assets/select2/dist/css/select2.min.css'/>
    <script src='http://ezcrm.us/vendor/crudbooster/assets/select2/dist/js/select2.full.min.js'></script>
    <script src='http://ezcrm.us/js/jquery.validate.min.js'></script>

    <style type="text/css">
        .select2-container--default .select2-selection--single {border-radius: 0px !important}
        .select2-container .select2-selection--single {height: 35px}
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3c8dbc !important;
            border-color: #367fa9 !important;
            color: #fff !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff !important;
        }

        .tags {
            display: inline-block;
            padding: 4px 6px;
            color: #777;
            vertical-align: middle;
            background-color: #FFF;
            border: 1px solid #D5D5D5;
            width: 80%;
        }

        .tags .tag {
            display: inline-block;
            position: relative;
            font-weight: 400;
            vertical-align: baseline;
            white-space: nowrap;
            background-color: #91B8D0;
            color: #FFF;
            text-shadow: 1px 1px 1px rgba(0,0,0,.15);
            padding: 4px 22px 5px 9px;
            margin-bottom: 3px;
            margin-right: 3px;
            -webkit-transition: all .2s;
            -o-transition: all .2s;
            transition: all .2s;
        }

        .tags .tag .close {
            font-size: 15px;
            line-height: 20px;
            opacity: 1;
            filter: alpha(opacity=100);
            color: #FFF;
            text-shadow: none;
            float: none;
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 18px;
            text-align: center;
        }
    </style>

    <script type="text/javascript">
        $(function() {
            $('#appliance').select2();
            $('#appliance_new').select2();
            $('#product').select2();
            $('#product_new').select2();
            $('#appliance_inside_category').select2();
            $('#appliance_subcategory').select2();

            //$('#buildout_name').select2();
            $('#sizes').select2();
            $('#state').select2();

            $('#date').datepicker();
        })
    </script>

    {{--<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>--}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('.wysiwyg').summernote();
            $('.summernote').summernote();
        })
    </script>

    <!-- support rtl-->
    @if (App::getLocale() == 'ar')
        <link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">
        <link href="{{ asset("vendor/crudbooster/assets/rtl.css")}}" rel="stylesheet" type="text/css" />
    @endif
    <!-- load css -->
    <style type="text/css">
        @if($style_css)
            {!! $style_css !!}
        @endif
    </style>
    @if($load_css)
        @foreach($load_css as $css)
            <link href="{{$css}}" rel="stylesheet" type="text/css" />
        @endforeach
    @endif

    <script type="text/javascript">
        $(document).ready(function() {
            //Oculta el botón de editar en el listado de Leads
            $("a[href*='account/edit'][class*='btn-edit']").hide();
            $("a[href*='customers25/edit'][class*='btn-edit']").hide();

            //Adicionar atributo title al botón de products stock
            $("a[href*='products_stock'][class*='btn-danger']").attr('title', 'Add Stock');

            $("a[href*='fases/detail'][class*='btn-detail']").hide();
            $("a[href*='products/detail'][class*='btn-detail']").hide();
            $("a[href*='settings31/detail'][class*='btn-detail']").hide();
            $("a[href*='account/edit'][class*='btn-edit']").hide();

            $("div[class*='note-editing-area']").attr('contenteditable', 'true');


            $("a[title=' ']").attr('title', 'Convert to Client');

            //Ocultar el mensaje de alerta pasados 4 segundos
            setTimeout("$(\"div[class*='alert alert-warning']\").fadeOut(350);", 2000);
            setTimeout("$(\"div[class*='alert alert-success']\").fadeOut(350);", 2000);


            var tag_input = $('#form-tag-to');
            try{
                tag_input.tag(
                    {
                        placeholder:tag_input.attr('placeholder'),
                        //enable typeahead by specifying the source array
                        //source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
                        /**
                         //or fetch data from database, fetch those that match "query"
                         source: function(query, process) {
						  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
						  .done(function(result_items){
							process(result_items);
						  });
						}
                         */
                    }
                )

                //programmatically add/remove a tag
                var $tag_obj = $('#form-tag-to').data('tag');
                //$tag_obj.add('Programmatically Added');

                var index = $tag_obj.inValues('some tag');
                $tag_obj.remove(index);
            }
            catch(e) {
                //display a textarea for old IE, because it doesn't support this plugin or another one I tried!
                tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
                //autosize($('#form-field-tags'));
            }

        });

        /*$(document).ready(function() {
            $('#buildout_description').summernote({
                height: ($(window).height() - 300),
                callbacks: {
                    onImageUpload: function(image) {
                        uploadImagenotes(image[0]);
                    }
                }
            });
            function uploadImagenotes(image) {
                var data = new FormData();
                data.append("userfile", image);
                $.ajax({
                    url: 'http://ezcrm.us/admin/fases/upload-summernote',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    type: "post",
                    success: function(url) {
                        var image = $('<img>').attr('src',url);
                        $('#textarea_notes').summernote("insertNode", image[0]);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        })*/
    </script>

    <!-- load js -->
    <script type="text/javascript">
      var site_url = "{{url('/')}}" ;
      @if($script_js)
        {!! $script_js !!}
      @endif
    </script>
    @if($load_js)
      @foreach($load_js as $js)
        <script src="{{$js}}"></script>
      @endforeach
    @endif
    <style type="text/css">
        .dropdown-menu-action {left:-130%;}
        .btn-group-action .btn-action {cursor: default}
        #box-header-module {box-shadow:10px 10px 10px #dddddd;}
        .sub-module-tab li {background: #F9F9F9;cursor:pointer;}
        .sub-module-tab li.active {background: #ffffff;box-shadow: 0px -5px 10px #cccccc}
        .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {border:none;}
        .nav-tabs>li>a {border:none;}
        .breadcrumb {
            margin:0 0 0 0;
            padding:0 0 0 0;
        }
        .form-group > label:first-child {display: block}

    </style>
</head>
<body class="@php echo (Session::get('theme_color'))?:'skin-blue'; echo config('crudbooster.ADMIN_LAYOUT') @endphp">
<div id='app' class="wrapper">

    <!-- Header -->
    @include('crudbooster::header')

    <!-- Sidebar -->
    @include('crudbooster::sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <section class="content-header">
          <?php
            $module = CRUDBooster::getCurrentModule();
          ?>
          @if($module)
          <h1>
            <i class='{{$module->icon}}'></i> {{trans('crudbooster.menu_'.$module->name)}} &nbsp;&nbsp;

            <!--START BUTTON -->

            @if(CRUDBooster::getCurrentMethod() == 'getIndex')
            @if($button_show)
            <a href="{{ CRUDBooster::mainpath().'?'.http_build_query(Request::all()) }}" id='btn_show_data' class="btn btn-sm btn-primary" title="{{trans('crudbooster.action_show_data')}}">
              <i class="fa fa-table"></i> {{trans('crudbooster.action_show_data')}}
            </a>
            @endif

            @if($button_add && CRUDBooster::isCreate())
            <a href="{{ CRUDBooster::mainpath('add').'?return_url='.urlencode(Request::fullUrl()).'&parent_id='.g('parent_id').'&parent_field='.$parent_field }}" id='btn_add_new_data' class="btn btn-sm btn-success" title="{{trans('crudbooster.action_add_data')}}">
              <i class="fa fa-plus-circle"></i> {{trans('crudbooster.action_add_data')}}
            </a>
            @endif
            @endif


            @if($button_export && CRUDBooster::getCurrentMethod() == 'getIndex')
            <a href="javascript:void(0)" id='btn_export_data' data-url-parameter='{{$build_query}}' title='Export Data' class="btn btn-sm btn-primary btn-export-data">
              <i class="fa fa-upload"></i> {{trans("crudbooster.button_export")}}
            </a>
            @endif

            @if($button_import && CRUDBooster::getCurrentMethod() == 'getIndex')
            <a href="{{ CRUDBooster::mainpath('import-data') }}" id='btn_import_data' data-url-parameter='{{$build_query}}' title='Import Data' class="btn btn-sm btn-primary btn-import-data">
              <i class="fa fa-download"></i> {{trans("crudbooster.button_import")}}
            </a>
            @endif

            <!--ADD ACTIon-->
             @if(count($index_button))
                    @foreach($index_button as $ib)
                     <a href='{{$ib["url"]}}' title='{{$ib["title"]}}' id='{{str_slug($ib["label"])}}' class='btn {{($ib['color'])?'btn-'.$ib['color']:'btn-primary'}} btn-sm'
                      @if($ib['onClick']) onClick='return {{$ib["onClick"]}}' @endif
                      @if($ib['onMouseOever']) onMouseOever='return {{$ib["onMouseOever"]}}' @endif
                      @if($ib['onMoueseOut']) onMoueseOut='return {{$ib["onMoueseOut"]}}' @endif
                      @if($ib['onKeyDown']) onKeyDown='return {{$ib["onKeyDown"]}}' @endif
                      @if($ib['onLoad']) onLoad='return {{$ib["onLoad"]}}' @endif
                      >
                        <i class='{{$ib["icon"]}}'></i> {{$ib["label"]}}
                      </a>
                    @endforeach
            @endif
            <!-- END BUTTON -->
          </h1>

          <ol class="breadcrumb">
            <li><a href="{{CRUDBooster::adminPath()}}"><i class="fa fa-dashboard"></i> {{ trans('crudbooster.home') }}</a></li>
            <li class="active">{{trans('crudbooster.menu_'.$module->name)}}</li>
          </ol>
          @else
          <h1>{{CRUDBooster::getSetting('appname')}} <small>{{ trans('crudbooster.text_information') }}</small></h1>
          @endif
        </section>


        <!-- Main content -->
        <section id='content_section' class="content">

        	@if(@$alerts)
        		@foreach(@$alerts as $alert)
        			<div class='callout callout-{{$alert[type]}}'>
        					{!! $alert['message'] !!}
        			</div>
        		@endforeach
        	@endif

			@if (Session::get('message')!='')
			<div class='alert alert-{{ Session::get("message_type") }}'>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h4><i class="icon fa fa-info"></i> {{ trans("crudbooster.alert_".Session::get("message_type")) }}</h4>
				{!!Session::get('message')!!}
			</div>
			@endif

            <!-- Your Page Content Here -->
            @yield('content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    @include('crudbooster::footer')

</div><!-- ./wrapper -->

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->
</body>
</html>
