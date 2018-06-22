<?php namespace App\Http\Controllers;

use App\Brands;
use App\EazyTask;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Session;
use Request;
use DB;
use CRUDBooster;
use App\Mail\CampaignEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

use Twilio\Rest\Client;

class AdminCustomersController extends \crocodicstudio\crudbooster\controllers\CBController {

    public function cbInit() {

        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "name";
        $this->limit = "50";
        $this->orderby = "id,desc";
        $this->global_privilege = true;
        $this->button_table_action = true;
        $this->button_bulk_action = true;
        $this->button_action_style = "button_icon";
        $this->button_add = true;
        $this->button_edit = true;
        $this->button_delete = true;
        $this->button_detail = true;
        $this->button_show = false;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = true;
        $this->table = "account";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        //$this->col[] = ["label"=>"Photo","name"=>"photo","image"=>true];
        //$this->col[] = ["label"=>trans('crudbooster.name'), "name"=>"name", "urlLead"=>"account"];
        $this->col[] = ["label"=>trans('crudbooster.name'), "name"=>"name"];
        $this->col[] = ["label"=>trans('crudbooster.lastname'), "name"=>"lastname"];
        $this->col[] = ["label"=>trans('crudbooster.phone'),"name"=>"telephone", "urlPhone"=>"account"];
        $this->col[] = ["label"=>trans('crudbooster.state'),"name"=>"state"];
        $this->col[] = ["label"=>trans('crudbooster.menu_Lead_Type'),"name"=>"estado","join"=>"customer_type,name"];
        $this->col[] = ["label"=>trans('crudbooster.quotes'),"name"=>"quotes"];
        $this->col[] = ["label"=>trans('crudbooster.creation_date'),"name"=>"date_created"];
        $this->col[] = ["label"=>trans('crudbooster.email'),"name"=>"email", "email"=>"email"];
        $this->col[] = ["label"=>trans('crudbooster.assign_to'),"name"=>"id_usuario","join"=>"cms_users,name"];
        $this->col[] = ["label"=>trans('crudbooster.notes'),"name"=>"notes"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label'=>trans('crudbooster.name'),'name'=>'name','type'=>'text','validation'=>'required|string|min:1|max:70','width'=>'col-sm-10'];
        $this->form[] = ['label'=>trans('crudbooster.lastname'),'name'=>'lastname','type'=>'text','validation'=>'required|string|min:1|max:70','width'=>'col-sm-10'];
        $this->form[] = ['label'=>trans('crudbooster.email'),'name'=>'email','type'=>'email','validation'=>'required|min:1|max:255|email|unique:account','width'=>'col-sm-10'];
        $this->form[] = ['label'=>trans('crudbooster.phone'),'name'=>'telephone','type'=>'number','validation'=>'required','width'=>'col-sm-10'];
        $this->form[] = ['label'=>trans('crudbooster.zipcode'),'name'=>'zip_code','type'=>'number','width'=>'col-sm-10'];
        $this->form[] = ['label'=>trans('crudbooster.state'),'name'=>'state','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'states,name'];
        $this->form[] = ['label'=>trans('crudbooster.city'),'name'=>'city','type'=>'text','validation'=>'string|min:3|max:200','width'=>'col-sm-10'];
        $this->form[] = ['label'=>trans('crudbooster.address'),'name'=>'address','type'=>'googlemaps','validation'=>'min:1|max:255','width'=>'col-sm-10','latitude'=>'latitude','longitude'=>'longitude'];
        $this->form[] = ['label'=>trans('crudbooster.photo'),'name'=>'photo','type'=>'upload','validation'=>'image|max:3000','width'=>'col-sm-10'];
        $this->form[] = ['label'=>trans('crudbooster.type'),'name'=>'estado','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'customer_type,name'];
        $this->form[] = ['label'=>trans('crudbooster.assign_to'),'name'=>'id_usuario','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'cms_users,name'];
        $this->form[] = ['label'=>'Latitude','name'=>'latitude','type'=>'hidden','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Longitude','name'=>'longitude','type'=>'hidden','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        # END FORM DO NOT REMOVE THIS LINE

        # OLD START FORM
        //$this->form = [];
        //$this->form[] = ['label'=>trans('crudbooster.name'),'name'=>'name','type'=>'text','validation'=>'required|string|min:1|max:70','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>trans('crudbooster.lastname'),'name'=>'lastname','type'=>'text','validation'=>'required|string|min:1|max:70','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>trans('crudbooster.email'),'name'=>'email','type'=>'email','validation'=>'required|min:1|max:255|email|unique:account','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>trans('crudbooster.phone'),'name'=>'telephone','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>trans('crudbooster.zipcode'),'name'=>'zip_code','type'=>'text','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>trans('crudbooster.state'),'name'=>'state','type'=>'select2','width'=>'col-sm-10','datatable'=>'states,name'];
        //$this->form[] = ['label'=>trans('crudbooster.city'),'name'=>'city','type'=>'text','validation'=>'string|min:3|max:200','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>trans('crudbooster.address'),'name'=>'address','type'=>'googlemaps','validation'=>'min:1|max:255','width'=>'col-sm-10','latitude'=>'latitude','longitude'=>'longitude'];
        //$this->form[] = ['label'=>trans('crudbooster.photo'),'name'=>'photo','type'=>'upload','validation'=>'image|max:3000','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>trans('crudbooster.type'),'name'=>'estado','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'customer_type,name'];
        //$this->form[] = ['label'=>trans('crudbooster.assign_to'),'name'=>'id_usuario','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'cms_users,name'];
        //$this->form[] = ['label'=>'Latitude','name'=>'latitude','type'=>'hidden','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Longitude','name'=>'longitude','type'=>'hidden','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        # OLD END FORM

        /*
        | ----------------------------------------------------------------------
        | Sub Module
        | ----------------------------------------------------------------------
        | @label          = Label of action
        | @path           = Path of sub module
        | @foreign_key 	  = foreign key of sub table/module
        | @button_color   = Bootstrap Class (primary,success,warning,danger)
        | @button_icon    = Font Awesome Class
        | @parent_columns = Sparate with comma, e.g : name,created_at
        |
        */
        $this->sub_module = array();
        //$this->sub_module[] = ['label'=>'Phases','path'=>'fases','foreign_key'=>'customers_id','button_color'=>'primary','button_icon'=>'fa fa-book','parent_columns'=>'name'];

        /*
        | ----------------------------------------------------------------------
        | Add More Action Button / Menu
        | ----------------------------------------------------------------------
        | @label       = Label of action
        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
        | @icon        = Font awesome class icon. e.g : fa fa-bars
        | @color 	   = Default is primary. (primary, warning, succecss, info)
        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
        |
        */
        $this->addaction = array();



        /*
        | ----------------------------------------------------------------------
        | Add More Button Selected
        | ----------------------------------------------------------------------
        | @label       = Label of action
        | @icon 	   = Icon from fontawesome
        | @name 	   = Name of button
        | Then about the action, you should code at actionButtonSelected method
        |
        */
        $this->button_selected = array();
        $this->button_selected[] = ['label'=>'Send Email','icon'=>'fa fa-envelope-o','name'=>'send_email'];
        $this->button_selected[] = ['label'=>'Send SMS','icon'=>'fa fa-phone','name'=>'send_sms'];
        $this->button_selected[] = ['label'=>'Send Schedule Email','icon'=>'fa fa-calendar-plus-o','name'=>'send_email_schedule'];


        /*
        | ----------------------------------------------------------------------
        | Add alert message to this module at overheader
        | ----------------------------------------------------------------------
        | @message = Text of message
        | @type    = warning,success,danger,info
        |
        */
        $this->alert        = array();



        /*
        | ----------------------------------------------------------------------
        | Add more button to header button
        | ----------------------------------------------------------------------
        | @label = Name of button
        | @url   = URL Target
        | @icon  = Icon from Awesome.
        |
        */
        $this->index_button = array();


        /*
        | ----------------------------------------------------------------------
        | Customize Table Row Color
        | ----------------------------------------------------------------------
        | @condition = If condition. You may use field alias. E.g : [id] == 1
        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
        |
        */
        $this->table_row_color = array();


        /*
        | ----------------------------------------------------------------------
        | You may use this bellow array to add statistic at dashboard
        | ----------------------------------------------------------------------
        | @label, @count, @icon, @color
        |
        */
        $this->index_statistic = array();


        /*
        | ----------------------------------------------------------------------
        | Add javascript at body
        | ----------------------------------------------------------------------
        | javascript code in the variable
        | $this->script_js = "function() { ... }";
        |
        */
        $this->script_js = "
            
	        	$(function() {  
                    //Agregar nueva nota
                    $('#add_note').on('click',function(){
                        var name = $('#note_value').val();
                        var customers_id = $('#note_lead_id').val();
        
                        $.ajax({
                            url: '../addnote',
                            data: \"name=\"+name+\"&customers_id=\"+customers_id,
                            type:  'get',
                            dataType: 'json',
                            success : function(data) {
                                //Actualizo solo el listado de notas para no recargar la web completamente
                                //Limpio el campo de nueva nota
                                $('#div_add_note').load(' #div_add_note');
                                $('#note_value').val('');                                                                                                                        
                            }
                         });  
                    });
                    
                    $('#addTasks').on('click',function(){
                        $('#taskLeadModal').modal('show'); 
                    });
                    
                    $('#addSaveTask').on('click',function(){
                        var name = $('#name').val();
                        var date = $('#date').val();
                        var lead_id = $('#lead_id').val();
                        
                        $.ajax({
                            url: '../addsave',
                            data: \"name=\"+$('#name').val()+\"&date=\"+$('#date').val()+\"&lead_id=\"+$('#lead_id').val(),
                            type:  'get',
                            dataType: 'json',
                            success : function(data) {
                               window.location.href = 'http://ezcrm.us/crm/account/detail/'+lead_id; 
                               $('#taskLeadModal').modal('hide');
                            }
                         }); 
                        
                        
                    });
                    
	        	})
	        ";


        /*
        | ----------------------------------------------------------------------
        | Include HTML Code before index table
        | ----------------------------------------------------------------------
        | html code to display it before index table
        | $this->pre_index_html = "<p>test</p>";
        |
        */
        $this->pre_index_html = null;



        /*
        | ----------------------------------------------------------------------
        | Include HTML Code after index table
        | ----------------------------------------------------------------------
        | html code to display it after index table
        | $this->post_index_html = "<p>test</p>";
        |
        */
        $this->post_index_html = null;



        /*
        | ----------------------------------------------------------------------
        | Include Javascript File
        | ----------------------------------------------------------------------
        | URL of your javascript each array
        | $this->load_js[] = asset("myfile.js");
        |
        */
        $this->load_js = array();



        /*
        | ----------------------------------------------------------------------
        | Add css style at body
        | ----------------------------------------------------------------------
        | css code in the variable
        | $this->style_css = ".style{....}";
        |
        */
        $this->style_css = NULL;



        /*
        | ----------------------------------------------------------------------
        | Include css File
        | ----------------------------------------------------------------------
        | URL of your css each array
        | $this->load_css[] = asset("myfile.css");
        |
        */
        $this->load_css = array();


    }


    /*
    | ----------------------------------------------------------------------
    | Hook for button selected
    | ----------------------------------------------------------------------
    | @id_selected = the id selected
    | @button_name = the name of button
    |
    */
    public function actionButtonSelected($id_selected,$button_name) {

        if ($button_name == 'send_email')
        {
            $this->getSendEmail($id_selected);
        }
        elseif($button_name == 'send_sms') {
            $this->getSendSms($id_selected);
        }
        elseif($button_name == 'send_email_schedule') {
            $this->getSendEmailSchedule($id_selected);
        }
    }


    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate query of index result
    | ----------------------------------------------------------------------
    | @query = current sql query
    |
    */
    public function hook_query_index(&$query) {
        //Your code here
        $id = (CRUDBooster::isSuperadmin());
        $user_id = (CRUDBooster::myId());

        if ($id != 1) {
            $query->where(['is_client' => 0])
                ->where('id_usuario', $user_id)
                ->where('estado', '!=', 2)
                ->where('estado', '!=', 3);
        }
        else {
            $query->where(['is_client' => 0])
                ->where('estado', '!=', 2)
                ->where('estado', '!=', 3);
        }

        \Illuminate\Support\Facades\DB::beginTransaction()
        ;
        $result = \Illuminate\Support\Facades\DB::select( DB::raw("
                        SELECT count(id) as cant, id_account
                        FROM user_trucks 
                        WHERE is_active = 0
                        GROUP BY id_account
                        ORDER BY id_account DESC
                        LIMIT 10                        
                        ")
        );
        \Illuminate\Support\Facades\DB::commit();

        for ($i=count($result)-1; $i>count($result)-11; $i--) {
            $q = DB::table('account')->where('id', $result[$i]->id_account)->first();

            if ($q != null) {
                DB::table('account')->where('id', $result[$i]->id_account)->update(['quotes' => $result[$i]->cant]);
            }
        }

    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate row of index table html
    | ----------------------------------------------------------------------
    |
    */
    public function hook_row_index($column_index,&$column_value) {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate data input before add data is execute
    | ----------------------------------------------------------------------
    | @arr
    |
    */
    public function hook_before_add(&$postdata) {

    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after add public static function called
    | ----------------------------------------------------------------------
    | @id = last insert id
    |
    */
    public function hook_after_add($id) {
        DB::table('account')->where('id', $id)->update(['date_created' => Carbon::now(config('app.timezone'))]);

        $maxId = DB::table('account')->select(\Illuminate\Support\Facades\DB::raw('MAX(id) as id'))->first();
        $maxId = $maxId->id + 1;
        DB::table('account')->where('id',$id)->update(['id'=> $maxId ]);

        $query = DB::table('account')->where('id',$maxId)->first();
        $state = DB::table('states')->where('id', $query->state)->first();
        DB::table('account')->where('id', $query->id)->update(['state'=>$state->abbreviation]);

        if(Request::get('submit') == trans('crudbooster.button_save_more')) {
            CRUDBooster::redirect(CRUDBooster::mainpath('add'),trans("crudbooster.text_lead_added"),'success');
        }else{
            CRUDBooster::redirect(CRUDBooster::adminpath("account/detail/$maxId"),trans("crudbooster.text_lead_added"));
        }
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate data input before update data is execute
    | ----------------------------------------------------------------------
    | @postdata = input post data
    | @id       = current id
    |
    */
    public function hook_before_edit(&$postdata,$id) {

    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after edit public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
    */
    public function hook_after_edit($id) {
        $query = DB::table('account')->where('id',$id)->first();
        $state = DB::table('states')->where('id', $query->state)->first();
        DB::table('account')->where('id', $query->id)->update(['state'=>$state->abbreviation]);

        CRUDBooster::redirect(CRUDBooster::adminpath("account/detail/$id"),trans("crudbooster.text_lead_added"));
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command before delete public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
    */
    public function hook_before_delete($id) {
        //Your code here

    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after delete public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
    */
    public function hook_after_delete($id) {
        //Your code here
    }


    /*public function getIndex() {
        //First, Add an auth
        if(!CRUDBooster::isView()) CRUDBooster::redirect(CRUDBooster::adminPath(),trans('crudbooster.denied_access'));

        //Create your own query
        $data = [];
        $data['page_title'] = 'Leads Data';
        $data['result'] = DB::table('account')->where('is_client', 0)->paginate(100000);

        //Create a view. Please use `cbView` method instead of view method from laravel.
        $this->cbView('leads.index',$data);
    }*/

    //Editar un Lead dado su "id"
    public function getEdit($id) {
        //Create an Auth
        if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {
            CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.text_open_edit_quote"));
        }

        $data = [];
        $data['id'] = $id;
        $data['products_type'] = DB::table('type')->get();
        $data['lead'] = DB::table('account')->where('id',$id)->first();
        $data['states'] = DB::table('states')->get();
        $data['estados'] = DB::table('customer_type')->get();
        $data['users'] = DB::table('cms_users')->get();

        $this->cbView('leads.edit',$data);
    }

    //Salvar la información editada de un Lead
    public function getEditsave(\Illuminate\Http\Request $request) {
        $sumarizedData = [
            'name' => $request->get('name'),
            'lastname' => $request->get('lastname'),
            'email' => $request->get('email'),
            'telephone' => $request->get('telephone'),
            'zip_code' => $request->get('zip_code'),
            'state' => $request->get('state'),
            'city' => $request->get('city'),
            'address' => $request->get('address'),
            'latitude' => $request->get('input-latitude-address'),
            'longitude' => $request->get('input-longitude-address'),
            'photo' => $request->get('photo'),
            'estado' => $request->get('estado'),
            'id_usuario' => $request->get('id_usuario'),
        ];
        DB::table('account')->where('id', $request->get('lead_id'))->update($sumarizedData);

        CRUDBooster::redirect(CRUDBooster::adminPath('account/detail/'.$request->get('lead_id')),trans("crudbooster.text_lead_added"));
    }

    //Agregar nueva nota de tipo Lead
    public function getAddnote(\Illuminate\Http\Request $request) {
        $name = $request->get('name');
        $customers_id = $request->get('customers_id');

        $sumarizedData = [
            'created_at' => Carbon::now(config('app.timezone')),
            'name' => $name,
            'customers_id' => $customers_id,
            'is_client' => 0,
        ];

        DB::table('eazy_notes')->insertGetId($sumarizedData);
        DB::table('account')->where('id', $request->get('customers_id'))->update(['notes'=>1]);

        return 1;
    }

    //Obtiene el listado de usuarios existentes en bd
    public function getUsers() {
        $data = DB::table('cms_users')
            ->select('id','name')
            ->get();

        return $data;
    }

    //Obtiene el listado de estados existentes en bd
    public function getEstados() {
        $data = DB::table('customer_type')
            ->select('id','name')
            ->get();

        return $data;
    }

    //Permite editar la información del usuario en el lead (account)
    public function getEdituser(\Illuminate\Http\Request $request) {
        DB::table('account')->where('id', $request->get('id_account'))->update([$request->get('campo') => $request->get('valor')]);
        $data = DB::table('cms_users')->where('id', $request->get('valor'))->first();

        return $data->name;
    }

    //Permite editar la información del estado en el lead (account)
    public function getEditestado(\Illuminate\Http\Request $request) {
        DB::table('account')->where('id', $request->get('id_account'))->update([$request->get('campo') => $request->get('valor')]);
        $data = DB::table('customer_type')->where('id', $request->get('valor'))->first();

        return $data->name;
    }

    //Agregar Tarea de tipo Lead
    public function getAddsave(\Illuminate\Http\Request $request) {

        $date = $request->get('date');
        $date = explode("/", $date);
        $date = $date[2].'-'.$date[0].'-'.$date[1];
        $date = Carbon::createFromFormat("Y-m-d", $date);

        $sumarizedData = [
            'date' => $date,
            'created_at' => Carbon::now(config('app.timezone')),
            'name' => $request->get('name'),
            'customers_id' => $request->get('lead_id'),
        ];

        $lastId = DB::table('eazy_tasks')->insertGetId($sumarizedData);

        $lead = DB::table('account')->where('id', $request->get('lead_id'))->first();

        //Notificación de envío de tareas
        $config['content'] = trans("crudbooster.new_tasks_lead_en").$lead->name.' '.$lead->lastname;
        $config['content_spanish'] = trans("crudbooster.new_tasks_lead_es").$lead->name.' '.$lead->lastname;
        $config['to'] = CRUDBooster::adminPath('eazy_tasks/detail/'.$lastId);

        if (CRUDBooster::myId() != 1) {
            $config['id_cms_users'] = [1,CRUDBooster::myId()]; //This is an array of id users
        }
        else {
            $config['id_cms_users'] = [1]; //This is an array of id users
        }

        CRUDBooster::sendNotification($config);

        return 1;
    }

    //Mostrar el perfil de un Lead dado su id
    public function getDetail($id) {

        //Create an Auth
        if(!CRUDBooster::isRead() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {
            CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
        }

        $account_exists = DB::table('account')->where('id',$id)->first();
        if (!empty($account_exists)) {
            if ($account_exists->deleted_at != null) {
                CRUDBooster::redirect(CRUDBooster::adminPath('account'),trans("crudbooster.text_delete_account"));
            }
        }

        $data = [];
        $data['page_title'] = 'Lead Profile';
        $data['row'] = DB::table('campaigns')->where('id',$id)->first();
        $data['id'] = $id;

        $data['lead'] = DB::table('account')
            ->select('account.state', 'account.name', 'account.lastname',
                'account.telephone', 'account.id', 'account.email', 'account.id', 'account.address', 'account.date_created',
                'account.zip_code', 'account.estado', 'account.id_usuario', 'account.city', 'account.quotes', 'account.notes'
            )
            ->where('account.id',$id)->first();

        $data['state'] = DB::table('states')
            ->where('abbreviation',$data['lead']->state)
            ->first();

        $data['quotes'] = DB::table('user_trucks')
            ->select(DB::raw('user_trucks.truck_name'), 'user_trucks.id as id', 'type.type as type', 'user_trucks.truck_budget', 'user_trucks.truck_date_created', 'user_trucks.state', 'user_trucks.truck_aprox_price', 'sources.name as sources')
            ->leftJoin('type', 'type.id', '=', 'user_trucks.interesting')
            ->leftJoin('sources', 'sources.id', '=', 'user_trucks.from_where')
            ->where('user_trucks.id_account',$id)
            ->where('is_closed',-1)
            ->where('user_trucks.deleted_at',null)
            ->get();

        $data['assign_to'] = DB::table('cms_users')->where('id',$data['lead']->id_usuario)->first();
        $data['contact_type'] = DB::table('customer_type')->where('id',$data['lead']->estado)->first();
        //$data['notes'] = DB::table('eazy_notes')->where('customers_id', $id)->where('deleted_at', null)->get();
        $data['task_type'] = DB::table('eazy_task_type')->get();

        $data['tasks'] = DB::table('eazy_tasks')
            ->select(DB::raw('eazy_tasks.name'), 'eazy_tasks.description', 'eazy_tasks.created_at', 'eazy_tasks.date', 'eazy_tasks.id')
            ->where('eazy_tasks.deleted_at', null)
            ->where('customers_id', $id)->get();

        //Please use cbView method instead view method from laravel
        $this->cbView('leads.perfil',$data);
    }

    //Enviar SMS dado el id de Lead
    public function getSendSms($id) {
        $to = null;

        if(gettype($id) == 'array') {
            $leadsSelected = DB::table('account')->whereIn('id',$id)->get();

            foreach ($leadsSelected as $item) {
                if (!empty($item->telephone)) {
                    $to[] = $item->telephone;
                }
            }

        }
        else {
            $leadsSelected = DB::table('account')->where('id',$id)->first();

            if (!empty($leadsSelected->telephone)) {
                $to[] = $leadsSelected->telephone;
            }
        }

        $phonesArray = '';
        $cant = count($to);
        for ($i = 0; $i < count($to); $i++) {
            if ($i == 0) {
                $phonesArray	= $to[$i];
            } else {
                $phonesArray	= $phonesArray.'; '.$to[$i];
            }
        }

        $sumarizedData = [
            'created_at' => Carbon::now(config('app.timezone')),
            'to' => $phonesArray,
            'subject' => '',
            'content' => '',
            'type' => 'SMS',
            'cms_email_templates_id' => null,
            'cms_users_id' => CRUDBooster::myId()
        ];

        $lastId = DB::table('settings_campaigns')->insertGetId($sumarizedData);

        //Open Edit Quote
        CRUDBooster::redirect(CRUDBooster::adminPath('settings_campaigns/edit/'.$lastId),trans("crudbooster.text_open_edit_campaign"));

    }

    //Enviar Email dado el id de Lead
    public function getSendEmail($id) {
        $emails = [];

        if(gettype($id) == 'array') {
            $customers = DB::table('account')->whereIn('id', $id)->get();

            foreach ($customers as $item) {
                if (!empty($item->email)) {
                    $emails[] = $item->email;
                }
            }

        } else {
            $customers = DB::table('account')->where('id', $id)->first();

            if (!empty($customers->email)) {
                $emails[] = $customers->email;
            }
        }

        $emailArray = '';
        $cant = count($emails);
        for ($i = 0; $i < count($emails); $i++) {
            if ($i == 0) {
                $emailArray	= $emails[$i];
            } else {
                $emailArray	= $emailArray.'; '.$emails[$i];
            }
        }

        $sumarizedData = [
            'created_at' => Carbon::now(config('app.timezone')),
            'to' => $emailArray,
            'subject' => '',
            'content' => '',
            'type' => 'Email',
            'cms_email_templates_id' => null,
            'cms_users_id' => CRUDBooster::myId()
        ];

        $maxId = DB::table('settings_campaigns')->select(\Illuminate\Support\Facades\DB::raw('MAX(id) as id'))->first();
        $maxId = $maxId->id + 1;
        $lastId = DB::table('settings_campaigns')->insertGetId($sumarizedData);

        DB::table('account')->where('id',$lastId)->update(['id'=> $maxId ]);

        //Open Edit Campaign
        CRUDBooster::redirect(CRUDBooster::adminPath('settings_campaigns/edit/'.$lastId),trans("crudbooster.text_open_edit_campaign"));

    }


    //Enviar Schedule Email dado el id de Lead
    public function getSendEmailSchedule($id) {
        $emails = [];

        if(gettype($id) == 'array') {
            $customers = DB::table('account')->whereIn('id', $id)->get();

            foreach ($customers as $item) {
                if (!empty($item->email)) {
                    $emails[] = $item->email;
                }
            }

        } else {
            $customers = DB::table('account')->where('id', $id)->first();

            if (!empty($customers->email)) {
                $emails[] = $customers->email;
            }
        }

        $emailArray = '';
        $cant = count($emails);
        for ($i = 0; $i < count($emails); $i++) {
            if ($i == 0) {
                $emailArray	= $emails[$i];
            } else {
                $emailArray	= $emailArray.'; '.$emails[$i];
            }
        }

        $sumarizedData = [
            'created_at' => Carbon::now(config('app.timezone')),
            'to' => $emailArray,
            'subject' => '',
            'content' => '',
            'type' => 'Email',
            'cms_email_templates_id' => null,
            'cms_users_id' => CRUDBooster::myId()
        ];

        $maxId = DB::table('campaign_automations')->select(\Illuminate\Support\Facades\DB::raw('MAX(id) as id'))->first();
        $maxId = $maxId->id + 1;
        $lastId = DB::table('campaign_automations')->insertGetId($sumarizedData);

        DB::table('account')->where('id',$lastId)->update(['id'=> $maxId ]);

        //Open Edit Campaign
        CRUDBooster::redirect(CRUDBooster::adminPath('campaign_automations/edit/'.$lastId),trans("crudbooster.text_open_edit_campaign"));

    }

}