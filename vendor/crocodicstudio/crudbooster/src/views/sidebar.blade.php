<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-{{ trans('crudbooster.left') }} image">
                <img src="{{ CRUDBooster::myPhoto() }}" style="width:45px;height:45px;" class="img-circle" alt="{{ trans('crudbooster.user_image') }}" />
            </div>
            <div class="pull-{{ trans('crudbooster.left') }} info">
                <p>{{ CRUDBooster::myName() }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('crudbooster.online') }}</a>
            </div>
        </div>


        <div class='main-menu'>

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header">{{trans("crudbooster.menu_navigation")}}</li>
                <!-- Optionally, you can add icons to the links -->

                @foreach(CRUDBooster::sidebarMenu() as $menu)
                    <li data-id='{{$menu->id}}' class='{{(count($menu->children))?"treeview":""}} {{(CRUDBooster::getCurrentMenuId()==$menu->id && CRUDBooster::getCurrentDashboardId()!=$menu->id )?"active":""}}'><a href='{{ ($menu->is_broken)?"javascript:alert('".trans('crudbooster.controller_route_404')."')":$menu->url."?m=".$menu->id }}' class='{{($menu->color)?"text-".$menu->color:""}}'><i class='{{$menu->icon}} {{($menu->color)?"text-".$menu->color:""}}'></i> <span>{{ trans('crudbooster.menu_'.$menu->name) }}</span>
                            @if(count($menu->children))<i class="fa fa-angle-{{ trans("crudbooster.right") }} pull-{{ trans("crudbooster.right") }}"></i>@endif
                        </a>
                        @if(count($menu->children))
                            <ul class="treeview-menu">
                                @foreach($menu->children as $child)
                                    <li data-id='{{$child->id}}' class='{{(CRUDBooster::getCurrentMenuId()==$child->id && CRUDBooster::getCurrentDashboardId()!=$child->id)?"active":""}}'><a href='{{ ($child->is_broken)?"javascript:alert('".trans('crudbooster.controller_route_404')."')":$child->url."?m=".$child->id }}'><i class='{{$child->icon}}'></i> <span>{{ trans('crudbooster.menu_'.$child->name) }}</span></a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach

                @if(CRUDBooster::isSuperadmin())
                    <li class="header">{{ trans('crudbooster.SUPERADMIN') }}</li>

                    <li class="treeview">
                        <a href="#"><i class='fa fa-cogs'></i> <span>{{ trans('crudbooster.settings') }}</span> <i class="fa fa-angle-{{ trans("crudbooster.right") }} pull-{{ trans("crudbooster.right") }}"></i></a>
                        <ul class="treeview-menu">
                            <li class='treeview'>
                                <a href='#'><i class='fa fa-key'></i> <span>{{ trans('crudbooster.Privileges_Roles') }}</span>  <i class="fa fa-angle-{{ trans("crudbooster.right") }} pull-{{ trans("crudbooster.right") }}"></i></a>
                                <ul class='treeview-menu'>
                                    <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/privileges')) ? 'active' : '' }}"><a href='{{Route("PrivilegesControllerGetIndex")}}?m=0'><i class='fa fa-bars'></i> {{ trans('crudbooster.List_Privilege') }}</a></li>

                                    <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/users')) ? 'active' : '' }}"><a href='{{Route("AdminCmsUsersControllerGetIndex")}}?m=0'><i class='fa fa-bars'></i> {{ trans('crudbooster.List_users') }}</a></li>
                                </ul>
                            </li>

                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/customer_type')) ? 'active' : '' }}"><a href='{{Route("AdminCustomerType1ControllerGetIndex")}}?m=0'><i class='fa fa-user-secret'></i> {{ trans('crudbooster.menu_Lead_Type') }} </a></li>

                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/eazy_task_type')) ? 'active' : '' }}"><a href='{{Route("AdminEazyTaskType1ControllerGetIndex")}}?m=0'><i class='fa fa-folder-open'></i> {{ trans('crudbooster.menu_Task_Type') }} </a></li>

                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/settings31')) ? 'active' : '' }}"><a href='{{Route("AdminSettings31ControllerGetIndex")}}?m=0'><i class='fa fa-credit-card'></i> {{ trans('crudbooster.menu_Invoice_Information') }} </a></li>

                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/suppliers')) ? 'active' : '' }}"><a href='{{Route("AdminSuppliersControllerGetIndex")}}?m=0'><i class='fa fa-user-times'></i> {{ trans('crudbooster.menu_Supplies') }} </a></li>

                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/module_generator')) ? 'active' : '' }}"><a href='{{Route("ModulsControllerGetIndex")}}?m=0'><i class='fa fa-th'></i> {{ trans('crudbooster.Module_Generator') }}</a></li>

                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/statistic_builder*')) ? 'active' : '' }}"><a href='{{Route("StatisticBuilderControllerGetIndex")}}?m=0'><i class='fa fa-dashboard'></i> {{ trans('crudbooster.List_Statistic') }}</a></li>

                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/menu_management*')) ? 'active' : '' }}"><a href='{{Route("MenusControllerGetIndex")}}?m=0'><i class='fa fa-bars'></i> {{ trans('crudbooster.Menu_Management') }}</a></li>

                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/settings/add*')) ? 'active' : '' }}">
                                <a href='{{route("SettingsControllerGetAdd")}}?m=0'><i class='fa fa-plus'></i> {{ trans('crudbooster.Add_New_Setting') }}</a>

                            </li>
                            <?php
                            $groupSetting = DB::table('cms_settings')->groupby('group_setting')->pluck('group_setting');
                            foreach($groupSetting as $gs):
                            ?>
                            <li class="<?=($gs == Request::get('group'))?'active':''?>"><a href='{{route("SettingsControllerGetShow")}}?group={{urlencode($gs)}}&m=0'><i class='fa fa-wrench'></i> {{$gs}}</a></li>
                            <?php endforeach;?>

                        </ul>
                    </li>

                    <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/logs*')) ? 'active' : '' }}"><a href='{{Route("LogsControllerGetIndex")}}?m=0'><i class='fa fa-flag'></i> {{ trans('crudbooster.Log_User_Access') }}</a></li>
                @endif

            </ul><!-- /.sidebar-menu -->

        </div>

    </section>
    <!-- /.sidebar -->
</aside>
