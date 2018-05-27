<?php namespace App\Http\Controllers;

	use Carbon\Carbon;
    use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminInvoices30Controller extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "business_name";
			$this->limit = "10";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
			$this->button_edit = false;
			$this->button_delete = true;
			$this->button_detail = false;
			$this->button_show = false;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "invoice";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
            //$this->col[] = ["label"=>"Name", "name"=>"customers_id", "urlClient"=>"customers25"];
            $this->col[] = ["label"=>trans('crudbooster.name'), "name"=>"contact_name"];
            //$this->col[] = ["label"=>"State","name"=>"state_client","join"=>"states,abbreviation"];
            $this->col[] = ["label"=>trans('crudbooster.state'),"name"=>"state_client"];
            $this->col[] = ["label"=>trans('crudbooster.city'),"name"=>"city"];
            $this->col[] = ["label"=>trans('crudbooster.date'),"name"=>"invoice_date"];
            $this->col[] = ["label"=>trans('crudbooster.assigned_to'),"name"=>"id_user","urlUser"=>"users"];
			//$this->col[] = ["label"=>"Total","name"=>"total","callback_php"=>'number_format($row->total)'];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Contact Name','name'=>'contact_name','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Contact Name','name'=>'contact_name','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
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
            $this->addaction[] = ['title'=>trans('crudbooster.print'),'url'=>CRUDBooster::mainpath("print-invoice/[id]"),'icon'=>'fa fa-print'];


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
	        //Your code here
            $id = (CRUDBooster::isSuperadmin());
            $user_id = (CRUDBooster::myId());

            if ($id != 1) {
                $query->where('id_user', $user_id);
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
	        //Your code here

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


        /*public function getPrintInvoice($id) {
            $data = [];

            $data['settings'] = DB::table('settings')->first();
            $data['invoice'] =  DB::table('invoice')->where('id',$id)->first();
            $data['state_client'] = DB::table('states')->where('id',$data['invoice']->state_client)->first();
            $data['invoices'] =  DB::table('invoice')
                ->join('invoice_items', 'invoice_items.id_invoice', '=', 'invoice.id')
                ->where('invoice.id', $id)->get();

            $totalFinal = 0;

            foreach ($data['invoices'] as $item) {
                $totalFinal += $item->price * $item->cant;
            }

            $data['totalFinal'] = $totalFinal;
            $data['dateActual'] = Carbon::now(config('app.timezone'));

            $this->cbView('clients.invoice-print',$data);
        }*/

        public function getPrintInvoice($id) {
            $data = [];

            \Illuminate\Support\Facades\DB::beginTransaction();
            $query = \Illuminate\Support\Facades\DB::select( DB::raw("
                        SELECT * FROM invoice WHERE invoice.id=$id;
                        ")
            );
            \Illuminate\Support\Facades\DB::commit();

            $html = '';

            foreach ($query as $row) {
                $fechaneed=$row->invoice_date;
                $fecha=date("m-d-Y",strtotime($fechaneed));

                $html =  '<div style="background-color:#E1E1E1">
                                 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="10">
                                        <tr>
                                           <td> <img src="http://www.chefunits.com/images/logocrm.png" width="100" height="100" style="display:block;" ></td>
                                           <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#000000;">
                                                   <b>CHEF UNITS</b>
                                                   <p style="color:#000000; text-decoration:underline; text-decoration:none;">2501 Karbach St c, Houston, TX 77092</p>
                                                   <p style="color:#000000; text-decoration:underline; text-decoration:none;">info@chefunits.com</p>
                                                   <p style="color:#000000; text-decoration:underline; text-decoration:none;">(713) 589-2613</p>
                                            </td>
                                           
                                            <td>
                                                <div style="font-size:14px;" valign="middle" align="right"><b>INVOICE</b></div>
                                                <div style="font-size:14px; padding-top: 10px" valign="middle" align="right"><b>Date: '.$fecha.'</b></div>
                                            </td>
                                        </tr>
                                      
                                        
                                        </tr>   
                                           
                                        </tr>
                              </table> ';
                $html = $html. '<table width="100%" border="1" align="center">
                               <tr>  <td width="40%">
                                            <div style="font-size:10px;" valign="middle" align="left">
                                                <b>BILL TO:</b>
                                                <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->bill_name.'</p>
                                                <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->bill_state.'</p>
                                                <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->bill_city.'</p>
                                                <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->bill_street.'</p>

                                             </div>
                                    </td width="40%">
                                     <td>
                                           <div style="font-size:10px;" valign="middle" align="left">
                                               <b>SHIP TO:</b>
                                               <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->contact_name.'</p>
                                               <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->state_client.'</p>
                                               <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->city.'</p>
                                               <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->street.'</p>

                                            </div>
                                    </td>
                            </tr>
                            </table>';
                //Agregando Financiamiento.user_trucks.financing,
                $html=$html. '<table width="100%" border="0" align="center" cellspacing="0" cellpadding="5" >
                                         <tr>
                                             <td align="left" colspan="5" valign="top" bgcolor="#dda51c" style="background-color:#026873; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF;"><b>List of Product</b></td>

                                         </tr>
                                         <tr style="color:#EDEDED;font-size:12px;">
                                             <td bgcolor="#026873" ><b>PRODUCT</b></td>
                                             <td bgcolor="#026873" ><b>DESCRIPCION</b></td>
                                             <td bgcolor="#026873"><b>UNIT PRICE</b></td>
                                             <td bgcolor="#026873"><b>QUANTITY</b></td>
                                             <td bgcolor="#026873"><b>TOTAL PRICE</b></td>
                                        </tr>';

                \Illuminate\Support\Facades\DB::beginTransaction();
                $qr1 = \Illuminate\Support\Facades\DB::select( DB::raw("
                        SELECT * FROM invoice_items WHERE id_invoice =$id;
                        ")
                );
                \Illuminate\Support\Facades\DB::commit();

                $result2 = $qr1;
                $total_impuesto = 0;
                $total_item=0;
                $total_apliance = 0;
                $total_general_apliance = 0;

                foreach ($result2 as $row1) {
                    $total_apliance =  ($row1->price * $row1->cant);
                    //$total_apliance= number_format($total_apliance, 2, ',', ' ');
                    $html = $html . "<tr style='font-size:10px;'>
                                        <td>".$row1->product."</td>
                                        <td>".$row1->descripcion."</td>
                                        <td>".$row1->price."</td>   
                                         <td>".$row1->cant."</td>
                                        <td>".$total_apliance."</td>
                                     </tr>";
                    $total_general_apliance = $total_general_apliance + $total_apliance   ;
                }
                $html = $html . '<tr style="color:#EDEDED;font-size:10px;">
                                <td></td> 
                                <td></td>
                                <td></td>
                                <td bgcolor="#026873"><b>Sub Total: </b></td>
                                <td bgcolor="#026873"><b>'.number_format($total_general_apliance, 2, '.', ' ').'</b></td>
                               </tr>';

                $html = $html . '<tr style="color:#EDEDED;font-size:10px;">
                                <td></td> 
                                <td></td>
                                <td></td>
                                <td bgcolor="#026873"><b>Taxes :</b></td>
                                <td bgcolor="#026873"><b>'.number_format($row->tax, 2, '.', ' ').'</b></td>
                               </tr>';
                $html = $html . '<tr style="color:#EDEDED;font-size:10px;">
                                <td></td> 
                                <td></td>
                                <td></td>
                                <td bgcolor="#026873"><b>Discount :</b></td>
                                <td bgcolor="#026873"><b>'.number_format($row->discount, 2, '.', ' ').'</b></td>
                               </tr>';
                $html = $html . '<tr style="color:#EDEDED;font-size:10px;">
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td bgcolor="#026873"><b>Grand Total: </b></td>
                                <td bgcolor="#026873"><b>'.number_format(($total_general_apliance + $row->tax - $row->discount) , 2, '.', ' ').'</b></td>
                               </tr>';
                $html = $html . " </table> "   ;
                //AGREGAR LA NOTA DE Q LA INVICE ES VALIDA SOLO POR 30 DIAS PROXIMOS
                $html = $html . '<table width="100%" border="0" align="center" cellspacing="0" cellpadding="5" >
                              <tr style="color:#00000">
                              <td >Note: This invoice is valid for the next 30 days</td>
                              </tr> </table>
                 ';
            }

            $data['html'] = $html;

            $this->cbView('clients.invoice-print',$data);
        }



	    //By the way, you can still create your own method in here... :) 


	}