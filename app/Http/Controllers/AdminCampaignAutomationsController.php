<?php namespace App\Http\Controllers;

	use Carbon\Carbon;
    use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminCampaignAutomationsController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "name";
			$this->limit = "10";
			$this->orderby = "id,desc";
			$this->global_privilege = true;
			$this->button_table_action = false;
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
			$this->table = "campaign_automations";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
            $this->col[] = ["label"=>"Type","name"=>"type"];
            $this->col[] = ["label"=>"Name","name"=>"name"];
            //$this->col[] = ["label"=>"Total Sent","name"=>"total_sent"];
            $this->col[] = ["label"=>"Template","name"=>"cms_email_templates_id", "join"=>"cms_email_templates,name"];
            $this->col[] = ["label"=>"Date to Send","name"=>"date_to_send"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
            $this->form[] = ['label'=>'To','name'=>'to','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
            $this->form[] = ['label'=>'Name','name'=>'name','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter'];
			$this->form[] = ['label'=>'Subject','name'=>'subject','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
            $this->form[] = ['label'=>'Date to Send','name'=>'date_to_send','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
            $this->form[] = ['label'=>trans('crudbooster.content'),'name'=>'content','type'=>'wysiwyg','width'=>'col-sm-10'];
            $this->form[] = ['label'=>trans('crudbooster.templates'),'name'=>'cms_email_templates_id','type'=>'select2','width'=>'col-sm-9','datatable'=>'cms_email_templates,name'];

            # END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Name","name"=>"name","type"=>"text","required"=>TRUE,"validation"=>"required|string|min:3|max:70","placeholder"=>"You can only enter the letter"];
			//$this->form[] = ["label"=>"Slug","name"=>"slug","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Subject","name"=>"subject","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Content","name"=>"content","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Description","name"=>"description","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"From Name","name"=>"from_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"From Email","name"=>"from_email","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Cc Email","name"=>"cc_email","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
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
	        	    $('#to').attr('readonly','true');	        	    
	        	    $('input[name=submit]').val('Send');
	        	    //$('section[class=content-header] h1').text('Campaigns');	    
	        	    //$('div[class=panel-heading] strong').text('Campaigns');
	        	    
	        	    var template = '<div style=\"margin-right: 15px; margin-left: 15px\"><a class=\"btn btn-warning pull-right\" title=\"New Template\" href=\"http://127.0.0.1:8000/crm/email_templates/add\"><i class=\"fa fa-envelope-o\"></i></a></div>';
	        	    	 
	        	    $('#form-group-cms_email_templates_id').append(template);	 
	        	    	        	    
	        	    $('#cms_email_templates_id').on('change',function(){
                          var id = $('#cms_email_templates_id').val();
                          $('.note-editing-area:nth-child(3) p').html('');
                          $.ajax
                            ({
                                url: '../templates/'+id,
                                data: '',
                                type: 'get',
                                success: function(data)
                                {
                                    $('#subject').val(data[0].subject);
                                    $('.note-editing-area:nth-child(3) p').append(data[0].content);
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
	        //Your code here
	            
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
            $toArray = [];
            $toTemp = explode("; ", $postdata['to']);

            $isMail = strpos($toTemp[0], "@");

            if ($isMail == false) {
                //Obtengo el/los Leads seleccionado
                $leadsSelected = DB::table('account')->whereIn('telephone', $toTemp)->get();

            } else {
                //Obtengo el/los Leads seleccionado
                $leadsSelected = DB::table('account')->whereIn('email', $toTemp)->get();
            }

            DB::table('campaign_automations')->where('id', $id)->update(['is_active' => 1]);
            $campaignsDelete = DB::table('campaign_automations')->where('is_active', 0)->delete();

            //Comprobar si la campaña es de envío de SMS o Email
            $campaignsType = DB::table('campaign_automations')->where('id', $id)->first();

            if($postdata['cms_email_templates_id'] != 0) {
                $template = CRUDBooster::first('cms_email_templates',['id'=>$postdata['cms_email_templates_id']]);
                $html = $template->content;
                $subject = $postdata['subject'];
            } else {
                $html = $postdata['content'];
                $subject = $postdata['subject'];
            }

            if ($isMail == false) {
                //Obtengo arreglo de phones asociados a los Leads seleccionados para enviar campaña
                foreach ($leadsSelected as $item) {
                    $to[] = $item->telephone;
                    $leads_send_id[] = $item->id;
                }
            } else {
                //Obtengo arreglo de emails asociados a los Leads seleccionados para enviar campaña
                foreach ($leadsSelected as $item) {
                    //validamos antes de incluir los emails
                    if ($this->validarEmail($item->email)) {
                        $to[] = $item->email;
                        $leads_send_id[] = $item->id;
                    }
                }
            }

            $template_id = null;
            $template_name = $subject;
            if ($template != null) {
                $template_id = $template->id;
                $template_name = $template->name;
            }

            //Guardar registro de campañas enviadas
            $sumarizedData = [
                'name' => $template_name,
                'content' => $html,
                'subject' => $subject,
                'date_to_send' => $postdata['date_to_send'],
                'cms_email_templates_id' => $template_id,
            ];

            DB::table('campaign_automations')->where('id', $id)->update($sumarizedData);

            //Insertar relación de Leads y Campañas enviadas
            foreach ($leads_send_id as $lead_send) {
                DB::table('campaigns_leads')->insert([
                    'campaigns_id' => $id,
                    'leads_id' => $lead_send,
                    'created_at' => Carbon::now(config('app.timezone')),
                ]);
            }

            CRUDBooster::redirect(CRUDBooster::adminPath('campaign_automations'),trans("crudbooster.text_send_campaign"));

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

        //Función para la validación de los correos electrónicos (emails)
        public function validarEmail($email) {
            if (preg_match(
                '/[\w-\.]{1,}@([\w-]{2,}\.)*([\w-]{1,}\.)[\w-]{2,4}/',
                $email)) {
                return true;
            }
            return false;
        }


        public function getTemplates($id) {
            $data = DB::table('cms_email_templates')
                ->where('id', $id)
                ->get();

            return $data;
        }



	    //By the way, you can still create your own method in here... :) 


	}