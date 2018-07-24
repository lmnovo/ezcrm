<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use Carbon\Carbon;

	class AdminFasesController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "name";
			$this->limit = "50";
			$this->orderby = "id,asc";
			$this->global_privilege = false;
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
			$this->button_export = false;
			$this->table = "fases";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>trans('crudbooster.phase_type'),"name"=>"fases_type_id","join"=>"fases_type,name"];
			$this->col[] = ["label"=>trans('crudbooster.name'),"name"=>"name"];
			$this->col[] = ["label"=>trans('crudbooster.creation_date'),"name"=>"created_at"];
			$this->col[] = ["label"=>trans('crudbooster.updated_date'),"name"=>"updated_at"];
			$this->col[] = ["label"=>trans('crudbooster.email'),"name"=>"email"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>trans('crudbooster.phase_type'),'name'=>'fases_type_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'fases_type,name'];
			$this->form[] = ['label'=>trans('crudbooster.name'),'name'=>'name','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'Please enter a valid email address'];
			$this->form[] = ['label'=>trans('crudbooster.email'),'name'=>'email','type'=>'email','validation'=>'min:1|max:255|email|unique:fases','width'=>'col-sm-10'];
			$this->form[] = ['label'=>trans('crudbooster.datetime'),'name'=>'datetime','type'=>'datetime','validation'=>'date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			$this->form[] = ['label'=>trans('crudbooster.notes'),'name'=>'notes','type'=>'wysiwyg','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Phase Type','name'=>'fases_type_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'fases_type,name'];
			//$this->form[] = ['label'=>'Name','name'=>'name','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'Please enter a valid email address'];
			//$this->form[] = ['label'=>'Email','name'=>'email','type'=>'email','validation'=>'min:1|max:255|email|unique:fases','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Datetime','name'=>'datetime','type'=>'datetime','validation'=>'date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Notes','name'=>'notes','type'=>'wysiwyg','width'=>'col-sm-10'];
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
            //$this->sub_module[] = ['label'=>'Notes','path'=>'notes_fases','foreign_key'=>'fases_id','button_color'=>'primary','button_icon'=>'fa fa-bars','parent_columns'=>'name'];


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
            $this->index_button[] = ['label'=>'','url'=>CRUDBooster::adminPath($slug="fases_type"),"icon"=>"fa fa-clock-o", "title"=>trans('crudbooster.types')];




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
	        $this->script_js = NULL;


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
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
            $user_id = (CRUDBooster::myId());
            if ($user_id == 1) {
                $query->where('customers_id', '=', '0');
            } else {
                $query->where('customers_id', '=', '-1');
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
	        //Your code here
            $postdata['datetime'] = null;

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

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
            if($postdata['datetime'] == '') {
                $postdata['datetime'] = null;
            }
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

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

        //Agregar notas a las fases o etapas del Quote actual
        public function getAddfasesnotes(\Illuminate\Http\Request $request) {
            $fases_id = $request->get('fases_id');

            DB::table('fases')->where('id', $fases_id)->update(['notes'=>$request->get('notes')]);
            $fases = DB::table('fases')->where('id', $fases_id)->first();

            //Adicionar "Recent Activity" del envío de Email
            DB::table('fases_activity')->insert([
                'fases_id'=>$fases_id,
                'description'=>'A note has been added by: '.CRUDBooster::myName(),
                'orders_id'=>$fases->orders_id,
                'created_at'=>Carbon::now(config('app.timezone'))->toDateTimeString(),
            ]);

            return 1;
        }

        //Enviar email de alerta de Paso finalizado
        public function getDeliveryontime() {

        }

        //Enviar email de alerta de Paso finalizado
        public function getStageterminate(\Illuminate\Http\Request $request) {
            $step_id = $request->get('step_id');
            $fase = DB::table('fases')->where('id',$step_id)->first();

            //Actualizar fecha de terminada la etapa actual
            DB::table('fases')->where('id',$step_id)->update(['datetime' => Carbon::now(config('app.timezone'))]);

            //Obtener información de la etapa para enviar notificaciones por email
            $to[] = $fase->email;
            $orders_id = $fase->orders_id;
            $step_name = $fase->name;

            $quote = DB::table('user_trucks')->where('id',$orders_id)->first();

            if ($fase->fases_type_id == 2) {
                $subject = trans("crudbooster.text_steps_second");
            } elseif ($fase->fases_type_id == 3) {
                $subject = trans("crudbooster.text_steps_third");
            } elseif ($fase->fases_type_id == 4) {
                $subject = trans("crudbooster.text_steps_fourth");
            } elseif ($fase->fases_type_id == 5) {
                $subject = trans("crudbooster.text_steps_fifth");
                $to = null;
                $to[] = "accounts@chefunits.com";
            } elseif ($fase->fases_type_id == 6) {
                $subject = trans("crudbooster.text_steps_sixth");
                DB::table('fases')->where('id',$step_id)->update(['updated_at' => Carbon::now(config('app.timezone'))]);
            } elseif ($fase->fases_type_id == 7) {
                $subject = trans("crudbooster.text_steps_seventh");
                $account = DB::table('account')->where('id', $quote->id_account)->first();

                if (count($account) != 0) {
                    $users = DB::table('cms_users')->where('id', $account->id_usuario)->first();
                    if (count($users) != 0) {
                        $to[] = $users->email;
                    }
                }

                $description = 'A notification email was sent to: '.$to[1];

                //Adicionar "Recent Activity" del envío de Email
                DB::table('fases_activity')->insert([
                    'fases_id'=>$step_id,
                    'description'=>$description,
                    'orders_id'=>$orders_id,
                    'created_at'=>Carbon::now(config('app.timezone'))->toDateTimeString(),
                ]);
            }

            if ($fase->fases_type_id == 6) {
                $html = "<p>".trans("crudbooster.text_dear_user").", ".trans("crudbooster.text_steps_confirm")."</p>
                            ".trans("crudbooster.Business_Name").": $quote->truck_name
                                   &nbsp; <a href='http://18.222.4.15/crm/orders/edit/$orders_id'>".trans("crudbooster.text_details_here")."</a>
                                   <br>
                                   <br><a href='http://18.222.4.15/deliveryontime/$orders_id/1/$step_id'>".trans("crudbooster.text_delivery_on_time")."</a>
                                   &nbsp; &nbsp;<a href='http://18.222.4.15/deliveryontime/$orders_id/0/$step_id'>".trans("crudbooster.text_delivery_out_date")."</a>
                            <p>".trans("crudbooster.phase_sign")." Chef Units</p>";
                //Send Email with notification End Step
                \Mail::send("crudbooster::emails.blank",['content'=>$html],function($message) use ($to,$subject) {
                    $message->priority(1);
                    $message->to($to);

                    $message->subject($subject);
                });
            } else {
                $html = "<p>".trans("crudbooster.text_dear_user").", ".trans("crudbooster.text_steps_ini")." '$step_name' ".trans("crudbooster.text_steps_end")."</p>
                            ".trans("crudbooster.Business_Name").": $quote->truck_name
                                   <br><a href='http://18.222.4.15/crm/orders/detail/$orders_id'>".trans("crudbooster.text_details_here")."</a>
                            <p>".trans("crudbooster.phase_sign")." Chef Units</p>";
                //Send Email with notification End Step
                \Mail::send("crudbooster::emails.blank",['content'=>$html],function($message) use ($to,$subject) {
                    $message->priority(1);
                    $message->to($to);

                    $message->subject($subject);
                });
            }


            if ($fase->fases_type_id == 6) {
                $description = 'A confirmation email was sent to: '.$to[0];
            } else {
                $description = 'A notification email was sent to: '.$to[0];

                //Actualizar la fase en la quote actual
                DB::table('user_trucks')->where('id',$fase->orders_id)->update(['fases_id' => $step_id]);
            }

            //Adicionar "Recent Activity" del envío de Email
            DB::table('fases_activity')->insert([
                'fases_id'=>$step_id,
                'description'=>$description,
                'orders_id'=>$orders_id,
                'created_at'=>Carbon::now(config('app.timezone'))->toDateTimeString(),
            ]);

            return $to;
        }


	}