<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use Illuminate\Pagination\Paginator;
	use Carbon\Carbon;

	class AdminProductsController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "name";
			$this->limit = "50";
			$this->orderby = "name,asc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = false;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = false;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "products";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
            //$this->col[] = ["label"=>"Photo","name"=>"imagen","image"=>true];
            $this->col[] = ["label"=>"Size","name"=>"name","join"=>"sizes,name"];
			$this->col[] = ["label"=>"Name","name"=>"name"];
			$this->col[] = ["label"=>"Type","name"=>"products_type_id","join"=>"products_type,name"];
			//$this->col[] = ["label"=>"Description","name"=>"description"];
			$this->col[] = ["label"=>"Sell Price","name"=>"sell_price","callback_php"=>'number_format($row->sell_price)'];
			$this->col[] = ["label"=>"Stock","name"=>"stock"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Name','name'=>'name','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Type','name'=>'products_type_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'products_type,name'];
			$this->form[] = ['label'=>'Size','name'=>'sizes_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'sizes,name'];
			$this->form[] = ['label'=>'Description','name'=>'description','type'=>'wysiwyg','validation'=>'required','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Sell Price','name'=>'sell_price','type'=>'money','validation'=>'required|min:0','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Name','name'=>'name','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Products Type','name'=>'products_type_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'products_type,name'];
			//$this->form[] = ['label'=>'Description','name'=>'description','type'=>'wysiwyg','validation'=>'required','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Sell Price','name'=>'sell_price','type'=>'money','validation'=>'required|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Supplier','name'=>'suppliers_id','type'=>'select2','validation'=>'integer|min:0','width'=>'col-sm-10','datatable'=>'products_type,name'];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();
	        $this->sub_module[] = ['label'=>'','path'=>'products_stock','button_color'=>'danger','button_icon'=>'fa fa-cart-plus','parent_columns'=>'id,sku,name,stock','foreign_key'=>'products_id'];


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
            /*$this->index_button[] = ['label'=>'',"icon"=>"fa fa-plus-circle", "title"=>"Add", "color"=>"success"];
            $this->index_button[] = ['label'=>'','url'=>CRUDBooster::adminPath($slug="sizes"),"icon"=>"fa fa-tags", "title"=>"Sizes", "color"=>"warning"];
            $this->index_button[] = ['label'=>'','url'=>CRUDBooster::adminPath($slug="appliances_categories"),"icon"=>"fa fa-cubes", "title"=>"Appliances Categories"];
            $this->index_button[] = ['label'=>'','url'=>CRUDBooster::adminPath($slug="appliances_inside"),"icon"=>"fa fa-cubes", "title"=>"Appliances", "color"=>"danger"];
            $this->index_button[] = ['label'=>'','url'=>CRUDBooster::adminPath($slug="appliances"),"icon"=>"fa fa-cubes", "title"=>"Appliances Details"];*/



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
            //$this->index_statistic[] = ['label'=>'Total Data','count'=>\Illuminate\Support\Facades\DB::table('products')->count(),'icon'=>'fa fa-check','color'=>'success'];



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
            DB::table('appliance_inside_category')->where('id', $id)->delete();

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

        public function getDeleteitem(\Illuminate\Http\Request $request) {
	        DB::table('appliance')->where('id', $request->get('id'))->delete();

	        return 1;
        }

        public function getDeletetype(\Illuminate\Http\Request $request) {
            //DB::table('type')->where('id', $request->get('id'))->delete();
            DB::table('type')->where('id', $request->get('id'))->update(['deleted_at'=>  Carbon::now(config('app.timezone'))]);

            return 1;
        }

        public function getIndex() {
            //First, Add an auth
            if(!CRUDBooster::isView()) CRUDBooster::redirect(CRUDBooster::adminPath(),trans('crudbooster.denied_access'));

            //Create your own query
            $data = [];
            $data['page_title'] = 'Products Data';
            //$data['result'] = DB::table('products')->orderby('id','desc')->paginate(10000);

            //Search Box
            $search = \Request::get('search');

            $result = DB::table('appliance')
                ->select(DB::raw('appliance_inside_category.id'), 'appliance.category', 'appliance_inside.name AS appliance',
                    'appliance_inside_category.name AS detail', 'appliance_inside_category.price', 'appliance_inside_category.description',
                    'appliance_inside_category.retail_price', 'appliance_inside.id_type', 'appliance_inside_category.imagen')
                ->join('appliance_inside', 'appliance_inside.id_appliance', '=', 'appliance.id')
                ->join('appliance_inside_category', 'appliance_inside_category.id_appliance_inside', '=', 'appliance_inside.id')
                ->where('appliance_inside_category.id','LIKE','%'.$search.'%')
                ->orwhere('appliance.category','LIKE','%'.$search.'%')
                ->orwhere('appliance_inside.name','LIKE','%'.$search.'%')
                ->orwhere('appliance_inside_category.name','LIKE','%'.$search.'%')
                ->orwhere('appliance_inside_category.description','LIKE','%'.$search.'%')
                ->orwhere('appliance_inside_category.retail_price','LIKE','%'.$search.'%')
                ->orwhere('appliance_inside_category.price','LIKE','%'.$search.'%')
                ->orderby('id','desc')
                ->paginate(10);

            return view('appliances.index',compact('result'));


            /*$data['appliances_list'] = DB::table('appliance')->where('state', 1)->get();


            return view('appliances.index',compact($result));*/

            //Create a view. Please use `cbView` method instead of view method from laravel.
            //$this->cbView('appliances.index',compact($data));
        }

        //Obtener todos los appliance_inside_category
        public function getApplianceinsidecategories(\Illuminate\Http\Request $request) {
            $data = DB::table('appliance_inside_category')
                ->where('id', $request->get('id'))
                ->get();
            return $data;
        }

        public function getAppliancesinsidefilter(\Illuminate\Http\Request $request) {
            $appliance_inside = DB::table('appliance_inside')
                ->where('id', $request->get('id_appliance_inside'))
                ->first();

            $data = DB::table('appliance_inside')
                ->where('id_appliance', $appliance_inside->id_appliance)
                ->where('id_type', 4)
                ->get();

            return $data;
        }

        public function getUpdateprice(\Illuminate\Http\Request $request) {
            $id_type = $request->get('type');
            $id_size = $request->get('size');
            $id_state = $request->get('state');
            $price = $request->get('price');

            DB::table('prices')->where('id_type', $id_type)->where('id_size', $id_size)->where('id_state', $id_state)->update(['price' => $price]);

            return 1;
        }

        public function getBuildout(\Illuminate\Http\Request $request) {
            $interesting = $request->get('interesting');
            $size = $request->get('size');

            if($interesting !== '2'){
                \Illuminate\Support\Facades\DB::beginTransaction();
                $query = \Illuminate\Support\Facades\DB::select( DB::raw("
                    SELECT buildout.id, buildout.nombre, buildout.descripcion, buildout.precio, buildout.tipo, type.type
                    FROM buildout
                    INNER JOIN type ON buildout.tipo = type.id
                    WHERE type.id=$interesting;
                ")
                );
                \Illuminate\Support\Facades\DB::commit();
            }
            else if($interesting == '2')//trailer
            {
                \Illuminate\Support\Facades\DB::beginTransaction();
                $query = \Illuminate\Support\Facades\DB::select( DB::raw("
                        SELECT buildout.id, buildout.nombre, buildout.descripcion, buildout.precio, size.size
                        FROM buildout
                        INNER JOIN type ON buildout.tipo = type.id 
                        INNER JOIN size_type ON size_type.id_type = type.id
                        INNER JOIN size ON size_type.id_size = size.id
                        WHERE buildout.tipo='".$interesting."'
                        AND size.id='".$size."' AND buildout.nombre LIKE CONCAT('%',size.size,'%')
                ")
                );
                \Illuminate\Support\Facades\DB::commit();
            }

            return $query;
        }

        public function getAddProduct() {
            $data['types'] = DB::table('type')->get();


            $this->cbView('products.create',$data);
        }

        //Muestra el listado de productos
        public function getTypes() {
            $data = DB::table('type')->where('deleted_at','=',null)->get();
            return $data;
        }

        //Agregar Nuevo Producto a la base de datos
        public function getAddproductname(\Illuminate\Http\Request $request) {
            $sumarizedData = [
                'type' => $request->get('product'),
            ];

            DB::table('type')->insertGetId($sumarizedData);

            return 1;
        }

        //Editar Buildout en la base de datos
        public function getEditbuildout(\Illuminate\Http\Request $request) {
            $name = $request->get('nombre');
            $precio = $request->get('precio');

	        if (isset($name) ) {
                DB::table('buildout')->where('id', $request->get('id'))->update(['nombre'=> $request->get('nombre') ]);
            }
            elseif (isset($precio)) {
                DB::table('buildout')->where('id', $request->get('id'))->update(['precio'=> $request->get('precio') ]);
            }



            return 1;
        }
	    //By the way, you can still create your own method in here... :) 


	}