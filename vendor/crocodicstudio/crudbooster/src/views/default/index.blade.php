@extends('crudbooster::admin_template')

@section('content')

    <script type="text/javascript">
        $(document).ready(function() {

            $('#modalNotification').on('click',function(){
                $('#modal-default').modal('show');
            });

            var td_user,campo_user,valor_user,id_user,id_user_user,id_account_user,isclient,url_action;
            var datos_user = '';
            $(document).on("click","td",function(e)
            {
                //Conocer la posición de la oolumna y la fila seleccionada
                var $d = $(this);
                var id_row = $d.parent().children().html();
                var col = $d.parent().children().index($d);
                var row = $d.parent().parent().children().index($d.parent());


                //Editando el campo "Status" en el listado de "Proyects"
                var col_text = $('th:nth-child(5)').text();
                var patternEnglish = /.*Step/;
                var patternSpanish = /.*Paso/;
                if( (col == 4 || col == 5) && (patternEnglish.test(col_text) || patternSpanish.test(col_text))) {
                    e.preventDefault();
                    window.location.href = 'http://ezcrm.us/crm/orders/detail/'+id_row;
                }

                id_account_user = $(this).siblings('*')[0].children[0].value;
                url_action = "account/edituser";

                e.preventDefault();
                if($(this).html().length < 100) {
                    if($(this).next().next().html().length > 1000) {

                        //Reiniciamos el listado de users para el select
                        datos_user = '';
                        campo_user = 'id_usuario';
                        id_user = $(this).html();
                        valor_user = $(this).html();
                        td_user=$(this).closest("td");

                        //Obtener el listado de usuarios existentes en bd
                        $.ajax({
                            type: "GET",
                            url: "account/users",
                            data: { campo: campo_user, valor: nuevovalor_user, id: id_user }
                        })
                            .done(function(data) {
                                for(var i=0;i<data.length;i++)
                                {
                                    if (valor_user == data[i].name) {
                                        datos_user += '<option selected="true" value='+data[i].id+' >'+data[i].name+'</option>';
                                    } else {
                                        datos_user += '<option value='+data[i].id+' >'+data[i].name+'</option>';
                                    }
                                }
                                td_user.text("").html("" +
                                    "<select class='form-control' id='cms_users' name='"+campo_user+"' placeholder='Select' required>"
                                    + datos_user +
                                    "</select>" +
                                    " <a class='enlace guardar_user' href='#'><i class=\"fa fa-check-circle\"></i></a> " +
                                    "<a class='enlace cancelar_user' href='#'><i class=\"fa fa-times-circle\"></i></a>");
                            });
                    }
                }

            });

            $(document).on("click",".cancelar_user",function(e)
            {
                e.preventDefault();
                td_user.html(valor_user);
                window.location.href = 'http://ezcrm.us/crm/account';
            });

            var nuevovalor_user;
            $(document).on("click",".guardar_user",function(e)
            {
                e.preventDefault();
                nuevovalor_user=$('#cms_users').val();
                $.ajax({
                    type: "GET",
                    url: url_action,
                    data: { campo: campo_user, valor: nuevovalor_user, id_user: id_user_user, id_account: id_account_user }
                })
                    .done(function( data ) {
                        td_user.html(data);
                    });
            });


        });
    </script>

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

    @if($parent_table)
    <div class="box box-default">
      <div class="box-body table-responsive no-padding">
        <table class='table table-bordered'>
          <tbody>
            <tr class='active'>
              <td colspan="2"><strong><i class='fa fa-bars'></i> {{ ucwords(urldecode(g('label'))) }}</strong></td>
            </tr>
            @foreach(explode(',',urldecode(g('parent_columns'))) as $c)
            <tr>
              <td width="25%"><strong>{{ ucwords(str_replace('_',' ',$c)) }}</strong></td><td>: {{ $parent_table->$c }}</td>
            </tr>
            @endforeach            
          </tbody>
        </table>    
      </div>
    </div>
    @endif
 
    <div class="box">
      <div class="box-header">  
        @if($button_bulk_action && ( ($button_delete && CRUDBooster::isDelete()) || $button_selected) )
        <div class="pull-{{ trans('crudbooster.left') }}">          
          <div class="selected-action" style="display:inline-block;position:relative;" id="bulk_actions_button" >
              <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class='fa fa-check-square-o'></i> {{trans("crudbooster.button_selected_action")}}
                <span class="fa fa-caret-down"></span></button>                              
              <ul class="dropdown-menu">    
                @if($button_delete && CRUDBooster::isDelete())                                                                                                                                                         
                <li><a href="javascript:void(0)" data-name='delete' title='{{trans('crudbooster.action_delete_selected')}}'><i class="fa fa-trash"></i> {{trans('crudbooster.action_delete_selected')}}</a></li>
                @endif                

                @if($button_selected)
                  @foreach($button_selected as $button)
                    <li><a href="javascript:void(0)" data-name='{{$button["name"]}}' title='{{$button["label"]}}'><i class="fa fa-{{$button['icon']}}"></i> {{$button['label']}}</a></li>
                  @endforeach
                @endif

              </ul><!--end-dropdown-menu-->
          </div><!--end-selected-action-->        
        </div><!--end-pull-left-->
        @endif
        <div class="box-tools pull-{{ trans('crudbooster.right') }}" style="position: relative;margin-top: 0px;margin-right: -10px">
          
              @if($button_filter)
                  <a style="margin-top:-23px" href="javascript:void(0)" id='btn_advanced_filter' data-url-parameter='{{$build_query}}' title='{{trans('crudbooster.filter_dialog_title')}}' class="btn btn-sm btn-default {{(Request::get('filter_column'))?'active':''}}">
                    <i class="fa fa-filter"></i> {{trans("crudbooster.button_filter")}}
                  </a>
              @endif

            <form method='get' style="display:inline-block;width: 260px;" action='{{Request::url()}}'>
                <div class="input-group">
                  <input type="text" name="q" value="{{ Request::get('q') }}" class="form-control input-sm pull-{{ trans('crudbooster.right') }}" placeholder="{{trans('crudbooster.filter_search')}}"/>
                  {!! CRUDBooster::getUrlParameters(['q']) !!}
                  <div class="input-group-btn">
                    @if(Request::get('q'))
                    <?php 
                      $parameters = Request::all();
                      unset($parameters['q']);
                      $build_query = urldecode(http_build_query($parameters));
                      $build_query = ($build_query)?"?".$build_query:"";
                      $build_query = (Request::all())?$build_query:"";
                    ?>
                    <button type='button' onclick='location.href="{{ CRUDBooster::mainpath().$build_query}}"' title="{{trans('crudbooster.button_reset')}}" class='btn btn-sm btn-warning'><i class='fa fa-ban'></i></button>
                    @endif
                    <button type='submit' class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
            </form>


          <form method='get' id='form-limit-paging' style="display:inline-block" action='{{Request::url()}}'>                        
              {!! CRUDBooster::getUrlParameters(['limit']) !!}
              <div class="input-group">
                <select onchange="$('#form-limit-paging').submit()" name='limit' style="width: 65px;"  class='form-control input-sm'>
                    <option {{($limit==5)?'selected':''}} value='5'>5</option> 
                    <option {{($limit==10)?'selected':''}} value='10'>10</option>
                    <option {{($limit==20)?'selected':''}} value='20'>20</option>
                    <option {{($limit==25)?'selected':''}} value='25'>25</option>
                    <option {{($limit==50)?'selected':''}} value='50'>50</option>
                    <option {{($limit==100)?'selected':''}} value='100'>100</option>
                    {{--<option {{($limit==200)?'selected':''}} value='200'>200</option>--}}
                </select>                              
              </div>
            </form>

        </div> 

        <br style="clear:both"/>

      </div>
      <div class="box-body table-responsive no-padding">
        @include("crudbooster::default.table")
      </div>
    </div>



   @if(!is_null($post_index_html) && !empty($post_index_html))
       {!! $post_index_html !!}
   @endif



@endsection
