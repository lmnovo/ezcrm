<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->



        <div class='main-menu'>

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header">{{trans("crudbooster.menu_navigation")}}</li>
                <!-- Optionally, you can add icons to the links -->

                <li class=""><a href='{{CRUDBooster::adminpath("tour/general")}}'><i class='fa fa-get-pocket'></i> {{ trans("crudbooster.General_Tour") }}</a></li>
                <li class=""><a href='{{CRUDBooster::adminpath("tour/first_steps")}}'><i class='fa fa-edit'></i> {{ trans("crudbooster.text_tour_first_steps") }}</a></li>

                <li class='treeview'>
                    <a href='#'><i class='fa fa-user'></i> <span>{{ trans("crudbooster.leads") }}</span>  <i class="fa fa-angle-{{ trans("crudbooster.right") }} pull-{{ trans("crudbooster.right") }}"></i></a>
                    <ul class='treeview-menu'>
                        <li class=""><a href='{{CRUDBooster::adminpath("tour/add_lead")}}'><i class='fa fa-user'></i> {{ trans("crudbooster.Add_Leads") }}</a></li>
                        <li class=""><a href='{{CRUDBooster::adminpath("tour/edit_lead")}}'><i class='fa fa-user'></i> {{ trans("crudbooster.Edit_Leads") }}</a></li>
                    </ul>
                </li>

                <li class=""><a href='{{CRUDBooster::adminpath("tour/add_quote")}}'><i class='fa fa-edit'></i> {{ trans("crudbooster.Add_Quotes") }}</a></li>
                <li class=""><a href='{{CRUDBooster::adminpath("tour/add_client")}}'><i class='fa fa-users'></i> {{ trans("crudbooster.Create_Client") }}</a></li>
                <li class=""><a href='{{CRUDBooster::adminpath("tour/sending_campaings")}}'><i class='fa fa-envelope-o text-normal'></i> {{ trans("crudbooster.Sending_Campaigns") }}</a></li>
                <li class=""><a href='{{CRUDBooster::adminpath("tour/phases")}}'><i class='fa fa-clock-o text-normal'></i> {{ trans("crudbooster.Phases_(Steps)") }}</a></li>
                <li class=""><a href='{{CRUDBooster::adminpath("tour/product")}}'><i class='fa fa-clock-o text-normal'></i> {{ trans("crudbooster.Add_Product_to_Catalog") }}</a></li>
                <li class=""><a href='{{CRUDBooster::adminpath("tour/user")}}'><i class='fa fa-clock-o text-normal'></i> {{ trans("crudbooster.delete_tour_user") }}</a></li>
                <li class=""><a href='{{CRUDBooster::adminpath("tour/configuration")}}'><i class='fa fa-clock-o text-normal'></i> {{ trans("crudbooster.edit_tour_configuration") }}</a></li>
                <li class=""><a href='{{CRUDBooster::adminpath("tour/menu_management")}}'><i class='fa fa-bars text-normal'></i> {{ trans("crudbooster.Menu_Management") }}</a></li>
                <li class=""><a href='{{CRUDBooster::adminpath("tour/configuration_privileges")}}'><i class='fa fa-clock-o text-normal'></i> {{ trans("crudbooster.Privileges_Configuration") }}</a></li>
                <li class=""><a href='{{CRUDBooster::adminpath("tour/proyects_management")}}'><i class='fa fa-folder-open text-normal'></i> {{ trans("crudbooster.proyects_management") }}</a></li>



            </ul><!-- /.sidebar-menu -->

        </div>

    </section>
    <!-- /.sidebar -->
</aside>
