<div class='panel panel-default'>
    <div class='panel-heading' style="background-color: #337ab7; color: white;">
        <strong><i class="fa fa-product-hunt"></i> {{trans('crudbooster.List_Buildout')}} </strong>
    </div>
    <button id="newBuildout" disabled="disabled" style="margin-left: 20px; margin-top: 20px;" class="btn btn-success pull-left" type="button" ><i class="fa fa-bars"></i> {{trans('crudbooster.add_buildout')}} </button>

    <div id="table_buildouts" class="table-responsive hover" style="margin: 70px;">
        <table id="buildouts" class="table table-striped table-responsive table-bordered" cellspacing="0">
            <thead>
            <tr>
                <th>{{trans('crudbooster.buildout')}}</th>
                <th>{{trans('crudbooster.description')}}</th>
                <th>{{trans('crudbooster.price')}}</th>
                <th >{{trans('crudbooster.action')}}</th>
            </tr>
            </thead>
            <tbody style="font-size: 12px">

            </tbody>
            <tfoot>
            <tr>
                <th></th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>