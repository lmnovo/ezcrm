@extends('crudbooster::admin_template')
@section('content')
   <script type="text/javascript">
        $(document).ready(function() {
            var asInitVals = new Array();

            $(document).ready(function() {
                $('#example').dataTable( {
                    "aaSorting": [[ 0, "desc" ]],
                } );
            } );

        } );
    </script>

    <!-- Your custom  HTML goes here -->
    <table id="example" class='table table-striped table-bordered'>
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Lastname</th>
            <th>Telephone</th>
            <th>State</th>
            <th>Quotes</th>
            <th>Type Leads</th>
            <th>Email</th>
            <th>Assign To</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($result as $row)
            <tr>
                <td>{{$row->id}}</td>
                <td>{{$row->name}}</td>
                <td>{{$row->lastname}}</td>
                <td>{{$row->telephone}}</td>
                <td>{{$row->state}}</td>
                <td>{{$row->quotes}}</td>
                <td>
                    <?php
                        $user = \DB::table('customer_type')->where('id',$row->estado)->first();
                        echo($user->name);
                    ?>
                </td>
                <td>
                    <?php
                        $email = strtolower($row->email);
                        echo($email);
                    ?>
                </td>
                <td>
                    <?php
                        $user = \DB::table('cms_users')->where('id',$row->id_usuario)->first();
                        echo($user->fullname);
                    ?>
                </td>
                <td>
                    <a style="margin-top: 2px" class="btn btn-xs btn-warning pull-right" title="{{trans('crudbooster.delete')}}" href="javascript:;" onclick="swal({
                            title: '{{trans('crudbooster.are_you_sure')}}',
                            text: '{{trans('crudbooster.message_delete')}}',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ff0000',
                            confirmButtonText: '{{trans('crudbooster.yes')}}',
                            cancelButtonText: '{{trans('crudbooster.no')}}',
                            closeOnConfirm: false },
                            function(){  location.href='http://18.222.4.15/crm/account/delete/{{ $id }}' });"><i class="fa fa-trash"></i>
                    </a>

                    <a class="btn btn-xs btn-primary btn-detail" title="Detail Data" href="http://18.222.4.15/crm/account/detail/{{$row->id}}?return_url=http%3A%2F%2F127.0.0.1%3A8000%2Fcrm%2Faccount%3Fm%3D62"><i class="fa fa-eye"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

   <!-- ADD A PAGINATION -->
   <p>{!! urldecode(str_replace("/?","?",$result->appends(Request::all())->render())) !!}</p>
@endsection