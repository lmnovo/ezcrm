<script type="text/javascript">
    $(document).ready(function() {

        $('#table_dashboard_notifications').dataTable( {
            "aaSorting": [[ 0, "desc" ]],
        } );

        //Abrir el modal con las notificaciones existentes sin leer
        $('#modalNotification').on('click',function(){
            $('#modal-notifications').modal('show');
        });

        var id_read;
        $('a#get_read').on('click',function(e){
            e.preventDefault();

            id_read = $(this).data('id');
            //Actualizo el valor de la notificación
            //$("span[id*='is_read_']").text('READ');
            //$("span[id*='is_read_']").attr('class', 'label label-success');

            $(this).parent().parent("td").parent().hide();

            //Actualizar como leída la notificaciones seleccionada
            $.get("http://127.0.0.1:8000/crm/notifications/readone", { id: id_read}, function(data){
            });
        });

        $(document).on("click","#get_read_all",function(e) {
            e.preventDefault();
            //Actualizar como leída todas las notificaciones seleccionada
            $('#modal-notifications').modal('hide');

            $.get("http://127.0.0.1:8000/crm/notifications/readall", { id: id_read }, function(data){
                location.href="http://127.0.0.1:8000/crm";
            });
        });

    });
</script>

<div class="modal fade" id="modal-notifications">
    <div class="modal-dialog"  style="width: 90%">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #337ab7; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{trans('crudbooster.Management Notifications')}}</h4>
            </div>
            <div class="modal-body" >
                <table style="font-size: 12px" id='table_dashboard_notifications' class='table table-hover table-striped table-bordered table_class_notifications'>
                    <thead>
                    <tr class="active">
                        <th width='auto'>{{trans('crudbooster.content')}}</th>
                        <th width='auto' style="text-align:center">{{trans('crudbooster.status')}}</th>
                        <th width='auto' style="text-align:center">{{trans('crudbooster.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                        $query = DB::table('cms_notifications')->where('is_read',0)->get();
                    ?>

                    @foreach($query as $item)
                        <tr style="padding: 2px;">
                            <td style="padding: 2px;">
                                <a href="http://127.0.0.1:8000/crm/notifications/read/{{ $item->id }}">
                                    {{ $item->content }}
                                </a>
                            </td>
                            <td style="text-align: center;">
                                @if($item->is_read == 0)
                                        <span id="{{ $item->id }}" class="label label-danger">NEW</span>
                                    @else
                                        <span id="{{ $item->id }}" class="label label-success">READ</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <div class='button_action' style='text-align:center;'>
                                    <a id="get_read" data-id="{{ $item->id }}" class='btn btn-xs btn-primary btn-detail' title='Read'>
                                        <i class='fa fa-thumbs-o-up'></i>
                                    </a>

                                    <a class='btn btn-xs btn-warning btn-delete' title='Delete' href='javascript:;' onclick='swal({
                                    title: "Are you sure ?",
                                    text: "You will not be able to recover this record data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#ff0000",
                                    confirmButtonText: "Yes!",
                                    cancelButtonText: "No",
                                    closeOnConfirm: false },
                                    function(){  location.href="http://127.0.0.1:8000/crm/notifications/delete/{{ $item->id }}" });'><i class='fa fa-trash'></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach



                    </tbody>
                    <tfoot>
                    <tr>
                        <th>&nbsp;</th>
                        <th width='auto'></th>
                        <th width='auto' style="text-align: center;">
                            <a style="width: 50%" id="get_read_all" class='btn btn-xs btn-primary btn-detail' title='Read All'>
                                <i class='fa fa-thumbs-o-up'></i>
                            </a>
                        </th>
                    </tr>
                    </tfoot>
                </table>

            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{url(config('crudbooster.ADMIN_PATH'))}}" title='{{CRUDBooster::getSetting('appname')}}' class="logo">{{CRUDBooster::getSetting('appname')}}</a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <?php
                  if(CRUDBooster::myId() == null) {
                ?>
                    <li class="dropdown messages-menu"><a href="{{CRUDBooster::adminpath("login")}}"style="color: white;"><strong>{{ trans('crudbooster.text_login') }}</strong></a></li>
                <?php
                    }
                ?>

                <li class="dropdown messages-menu"><a href="{{CRUDBooster::adminpath("tour/general")}}"style="color: white;"><strong>{{ trans('crudbooster.text_quick_tour') }}</strong></a></li>

                <!--GESTION DE IDIOMA-->
                <li class="dropdown messages-menu"><a title="{{ trans('crudbooster.english') }}" href="<?php echo e(url('lang', ['en'])); ?>"><img style="width:25px" src="<?php echo e(asset('assets/images/us.png')); ?>" alt="EN"></a></li>
                <li class="dropdown messages-menu"><a title="{{ trans('crudbooster.spanish') }}" href="<?php echo e(url('lang', ['es'])); ?>"><img style="width:25px" src="<?php echo e(asset('assets/images/es.png')); ?>" alt="ES"></a></li>
                <!--END-->

            <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" title='Notifications' aria-expanded="false">
                  <i id='icon_notification' class="fa fa-bell-o"></i>
                  <span id='notification_count' class="label label-danger" style="display:none">0</span>
                </a>

                <ul id='list_notifications' class="dropdown-menu">
                  <li class="header">{{trans("crudbooster.text_no_notification")}}</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;">
                    <ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                      <li>
                        <a href="#">
                          <em>{{trans("crudbooster.text_no_notification")}}</em>
                        </a>
                      </li>

                    </ul>
                    <div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 195.122px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
                  </li>
                  {{--<li class="footer"><a href="{{route('NotificationsControllerGetIndex')}}?m=0">{{trans("crudbooster.text_view_all_notification")}}</a></li>--}}
                  <li class="footer">
                      <a id="modalNotification" href="#">{{trans("crudbooster.text_view_all_notification")}}</a>
                  </li>
                </ul>
            </li>

                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ CRUDBooster::myPhoto() }}" class="user-image" alt=""/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ CRUDBooster::myName() }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ CRUDBooster::myPhoto() }}" class="img-circle" alt="" />
                            <p>
                                {{ CRUDBooster::myName() }}
                                <small>{{ CRUDBooster::myPrivilegeName() }}</small>
                                <small><em><?php echo date('d F Y')?></em> </small>                                
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-{{ trans('crudbooster.left') }}">
                                <a href="{{ route('AdminCmsUsersControllerGetProfile') }}?m=0" class="btn btn-default btn-flat"><i class='fa fa-user'></i> {{trans("crudbooster.label_button_profile")}}</a>
                            </div>
                            <div class="pull-{{ trans('crudbooster.right') }}">
                                <a title='Lock Screen' href="{{ route('getLockScreen') }}" class='btn btn-default btn-flat'><i class='fa fa-key'></i></a> 
                                <a href="javascript:void(0)" onclick="swal({   
                                    title: '{{trans('crudbooster.alert_want_to_logout')}}',                                       
                                    type:'info',   
                                    showCancelButton:true, 
                                    allowOutsideClick:true,  
                                    confirmButtonColor: '#DD6B55',   
                                    confirmButtonText: '{{trans('crudbooster.button_logout')}}',   
                                    cancelButtonText: '{{trans('crudbooster.button_cancel')}}',
                                    closeOnConfirm: false 
                                    }, function(){                                                                                 
                                        location.href = '{{ route("getLogout") }}';

                                    });" title="{{trans('crudbooster.button_logout')}}" class="btn btn-danger btn-flat"><i class='fa fa-power-off'></i></a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
