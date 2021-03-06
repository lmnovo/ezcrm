<?php namespace App\Http\Controllers;

	use Carbon\Carbon;
    use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminOrdersController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "50";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = false;
			$this->button_show = false;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = true;
			$this->table = "user_trucks";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>trans('crudbooster.Business_Name'),"name"=>"truck_name","width"=>"15%"];
            $this->col[] = ["label"=>trans('crudbooster.interesed'),"name"=>"interesting","join"=>"type,type","width"=>"8%"];
            //$this->col[] = ["label"=>trans('crudbooster.lead_name'),"name"=>"id_account", "urlLeadQuote"=>"account","width"=>"10%"];
            $this->col[] = ["label"=>trans('crudbooster.lead_name'),"name"=>"id_account","join"=>"account,name"];
            $this->col[] = ["label"=>trans('crudbooster.creation_date'),"name"=>"truck_date_created","width"=>"10%"];
            $this->col[] = ["label"=>trans('crudbooster.budget'),"name"=>"truck_budget","callback_php"=>'number_format($row->truck_budget)',"width"=>"7%"];
            $this->col[] = ["label"=>trans('crudbooster.assigned_to'),"name"=>"id_account","urlUserQuote"=>"users","width"=>"10%"];
            $this->col[] = ["label"=>trans('crudbooster.source'),"name"=>"from_where","join"=>"sources,name","width"=>"7%"];
            $this->col[] = ["label"=>"Total","name"=>"truck_aprox_price"];
            $this->col[] = ["label"=>trans('crudbooster.profit'),"name"=>"profits","width"=>"8%"];
            $this->col[] = ["label"=>trans('crudbooster.financing'),"name"=>"financing"];
            //$this->col[] = ["label"=>trans('crudbooster.is_closed'),"name"=>"is_closed"];

			# END COLUMNS DO NOT REMOVE THIS LINE

			$order_number = DB::table('user_trucks')->max('id') + 1;
			$order_number = str_pad($order_number, 5, 0 , STR_PAD_LEFT);

            # START FORM DO NOT REMOVE THIS LINE
            $this->form = [];
            $this->form[] = ['label'=>'Lead','name'=>'customers_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'customers,name','datatable_format'=>"name,' - ',phone"];
            $this->form[] = ['label'=>'Business Name','name'=>'business_name','type'=>'text','validation'=>'required|string|min:3|max:170','width'=>'col-sm-10'];
            $this->form[] = ['label'=>'Quote Number','name'=>'order_number','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','value'=>$order_number,'readonly'=>false];

			# START FORM DO NOT REMOVE THIS LINE
            $columns = [];
            $columns[] = ['label'=>'Product','name'=>'products_id','type'=>'datamodal','datamodal_table'=>'products','datamodal_columns'=>'name,sell_price,stock','datamodal_select_to'=>'sell_price:products_price','required'=>true];
            $columns[] = ['label'=>'Product Price','name'=>'products_price','type'=>'number','readonly'=>true,'required'=>true];
            $columns[] = ['label'=>'Quantity','name'=>'quantity','type'=>'number','required'=>true];
            $columns[] = ['label'=>'Sub Total','name'=>'sub_total','type'=>'number','formula'=>'[products_price] * [quantity]','readonly'=>true,'required'=>true];
            $this->form[] = ['label'=>'Quote Detail','name'=>'order_detail','type'=>'child','columns'=>$columns,'table'=>'orders_detail','foreign_key'=>'orders_id'];

            $this->form[] = ['label'=>'Total','name'=>'total','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10','readonly'=>'true','value'=>0];
            $this->form[] = ['label'=>'Tax','name'=>'tax','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10','value'=>0];
            $this->form[] = ['label'=>'Discount','name'=>'discount','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10','value'=>0];
            $this->form[] = ['label'=>'Grand Total','name'=>'grand_total','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10','readonly'=>true,'value'=>0];

            $this->form[] = ['label'=>'What is your Budget?','name'=>'budget','type'=>'number','validation'=>'required|min:0','width'=>'col-sm-10', 'value'=>0];
            $this->form[] = ['label'=>'Downpayment','name'=>'downpayment','type'=>'number','validation'=>'required|min:0','width'=>'col-sm-10', 'value'=>0];
            $this->form[] = ['label'=>'How soon you need it?','name'=>'date_limit','type'=>'date','validation'=>'required','width'=>'col-sm-10', 'required'=>true];
            $this->form[] = ['label'=>'Need financing?','name'=>'need_financing','type'=>'select','dataenum'=>'Sí;No','width'=>'col-sm-10'];



            # END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Customer','name'=>'customers_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'customers,name','datatable_format'=>"name,' - ',phone"];
			//$this->form[] = ['label'=>'Order Number','name'=>'order_number','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','value'=>$order_number,'readonly'=>true];
			//
			//
			//$columns = [];
			//$columns[] = ['label'=>'Product','name'=>'products_id','type'=>'datamodal','datamodal_table'=>'products','datamodal_columns'=>'name,sku,sell_price,stock','datamodal_select_to'=>'sell_price:products_price,sku:products_sku','required'=>true];
			//$columns[] = ['label'=>'Product SKU','name'=>'products_sku','type'=>'text','readonly'=>true,'required'=>true];
			//$columns[] = ['label'=>'Product Price','name'=>'products_price','type'=>'number','readonly'=>true,'required'=>true];
			//$columns[] = ['label'=>'Quantity','name'=>'quantity','type'=>'number','required'=>true];
			//$columns[] = ['label'=>'Sub Total','name'=>'sub_total','type'=>'number','formula'=>'[products_price] * [quantity]','readonly'=>true,'required'=>true];
			//$this->form[] = ['label'=>'Order Detail','name'=>'order_detail','type'=>'child','columns'=>$columns,'table'=>'orders_detail','foreign_key'=>'orders_id'];
			//
			//$this->form[] = ['label'=>'Total','name'=>'total','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10','readonly'=>'true','value'=>0];
			//$this->form[] = ['label'=>'Tax','name'=>'tax','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10','value'=>0];
			//$this->form[] = ['label'=>'Discount','name'=>'discount','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10','value'=>0];
			//$this->form[] = ['label'=>'Grand Total','name'=>'grand_total','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10','readonly'=>true,'value'=>0];
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
            //$this->sub_module[] = ['label'=>'Appliances','path'=>'appliances','foreign_key'=>'orders_id','button_color'=>'primary','button_icon'=>'fa fa-bars','parent_columns'=>'name'];
            //$this->sub_module[] = ['label'=>'Notes','path'=>'notes_quotes','foreign_key'=>'orders_id','button_color'=>'primary','button_icon'=>'fa fa-bars','parent_columns'=>'name'];
            //$this->sub_module[] = ['label'=>'Tasks','path'=>'eazy_tasks_quotes','foreign_key'=>'orders_id','button_color'=>'success','button_icon'=>'fa fa-book','parent_columns'=>'name'];


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
            //$this->addaction[] = ['label'=>'Convert to Lead','url'=>CRUDBooster::mainpath('convert-client/[id]'),'icon'=>'fa fa-users','color'=>'danger',"showIf"=>"[contact_type] == 1",'confirmation'=>true];
            $this->addaction[] = ['label'=>' ','url'=>CRUDBooster::mainpath('convert-client/[id]'),'icon'=>'fa fa-share-square-o','color'=>'primary',"showIf"=>"[is_closed] != 1", 'confirmation'=>true];

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
            $this->index_button[] = ['label'=>'','url'=>CRUDBooster::adminPath($slug="account/add"),"icon"=>"fa fa-plus-circle", "title"=>"Add Quote", "color"=>"success"];



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
                       
	        	
	        	    $('#date_limit').datepicker();
	        	    var count = 0;	        	    
	        	   	        	    
	        	    /*cargando = $('<img src=\"/assets/images/loading.gif\" />');
                    $('div#loading').html(cargando);
                    $('div#loading').html(cargando);
                    $('div#loading').hide();*/
                    $('#modal-loading').modal('hide');
                    
                    var quotes_id = $('#note_quotes_id').val();
                    /*$.ajax({
                        url: '../buildoutdesc',
                        data: \"id=\"+quotes_id,
                        type:  'get',
                        dataType: 'json',
                        success : function(data) {
                            $('#description_text').html(data[0].desc_buildout);                                                      
                        }
                     });  */                  
                    
                    
                    $('#check_send_email').on('click',function(){
                        $('#send_email').val('true');                        
                    }); 
                    
                    //Agregar nueva nota
                    $('#add_note').on('click',function(){
                        var name = $('#note_value').val();
                        var quotes_id = $('#note_quotes_id').val();
        
                        $.ajax({
                            url: '../addnote',
                            data: \"name=\"+name+\"&quotes_id=\"+quotes_id,
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
                    
                    //Editar y Guardar el Precio del Appliance
                    $('#edit_precio').on('click',function(){
                        $('#price2').removeAttr('disabled');
                        $('#save_precio').css('display','inline');
                        $(this).css('display','none');
                    });                                  
                    
                    $('#save_precio').on('click',function(){
                         $('#price2').removeAttr('disabled');
                         $('#save_precio').css('display','inline');
                         $(this).css('display','none');
                         $.ajax({
                            url: '../updateprecio',
                            data: \"id=\"+$('#appliance_inside_category').val()+\"&precio=\"+$('#price2').val(),
                            type:  'get',
                            dataType: 'json',
                            success : function(data) {
                                if(data==true){
                                    $('#price2').attr('disabled','true');
                                    $('#save_precio').css('display','none');
                                    $('#edit_precio').css('display','inline');
                                    
                                    //actualizo el total
                                    var price = $('#price2').val(); 
                                    var cant=$('#quantity').val();
                                    var total=parseFloat(price)*parseFloat(cant);
                                    $('#total').val(total);
                                    
                                    updateTotales();
                                }
                            }
                         });
                     });                    
                     
                    
                    //Editar y Guardar el Precio de Costo del Appliance
                    $('#edit_precio_retail').on('click',function(){
                        $('#price2_retail').removeAttr('disabled');
                        $('#save_precio_retail').css('display','inline');
                        $(this).css('display','none');
                    });
                     
                     $('#save_precio_retail').on('click',function(){
                         $('#price2_retail').removeAttr('disabled');
                         $('#save_precio_retail').css('display','inline');
                         $(this).css('display','none');
                         $.ajax({
                            url: '../updateprecioretail',
                            data: \"id=\"+$('#appliance_inside_category').val()+\"&precio=\"+$('#price2_retail').val(),
                            type:  'get',
                            dataType: 'json',
                            success : function(data) {
                                if(data==true){
                                    $('#price2_retail').attr('disabled','true');
                                    $('#save_precio_retail').css('display','none');
                                    $('#edit_precio_retail').css('display','inline');
                                }
                            }
                         });
                     });
                    
                    //Editar y Guardar el Registration
                    $('#edit_registration').on('click',function(){
                        $('#registration').removeAttr('readonly');
                        $('#save_registration').css('display','inline');
                        $(this).css('display','none');
                    });
                    
                    $('#save_registration').on('click',function(){
                         $('#registration').removeAttr('readonly');
                         $('#save_registration').css('display','inline');
                         $(this).css('display','none');
                         $.ajax({
                            url: '../updateregistration',
                            data: \"registration=\"+$('#registration').val(),
                            type:  'get',
                            dataType: 'json',
                            success : function(data) {
                                if(data==true){
                                    $('#registration').attr('readonly','true');
                                    $('#save_registration').css('display','none');
                                    $('#edit_registration').css('display','inline');
                                    
                                    //Actualizo el Total Quote
                                    actualizar_total();
                                    
                                    updateTotales();
                                }
                            }
                         });
                     });
                     
                    var oTableaccesorios = $('#accesorios').DataTable({
                        \"order\": [[ 0, \"asc\" ]],
                         \"lengthMenu\": [ 25, 50, 75, 100 ],
                        \"footerCallback\": function ( row, data, start, end, display ) {
                            var api = this.api(), data;
                            // Total over all pages
                            total = api
                                .column( 6 )
                                .data()
                                .reduce( function (a, b) {
                                    return parseFloat(a) + parseFloat(b);
                                }, '0.00' );
                            total=new Number(total).toFixed(2);    
                            // Update footer
                            $( api.column( 6 ).footer() ).html(
                                total
                            );
                            
                            //siempre que agregue o elimine se actualiza el campo en el resumen
                            $('#resumen_appliance').val(total);
                            
                            //Si el estado seleccionado no es Texas el Impuesto es 0
                            /*if($('#state option:selected').text()==='TX')
                            {
                                $('#taxappliance').val(parseFloat(total * 0.0825));
                            }else{
                                $('#taxappliance').val('0.00');
                            }*/
                                     
                            actualizar_total();                            
                            updateTotales();
                        },
                        \"columnDefs\": [
                            { \"width\": \"15%\", \"targets\": 0 },
                            { \"width\": \"12.5%\", \"targets\": 1 },
                            { \"width\": \"12.5%\", \"targets\": 2 },
                            { \"width\": \"10%\", \"targets\": 3 },
                            { \"width\": \"10%\", \"targets\": 4 },
                            { \"width\": \"10%\", \"targets\": 5 },
                            { \"width\": \"5%\", \"targets\": 6 },
                            { \"width\": \"5%\", \"targets\": 7 },
                            { responsivePriority: 1, targets: 2 }, { responsivePriority: 1, targets: 6 }, { responsivePriority: 1, targets: 7}
                        ],
                        responsive: {
                                details: false
                            }
                    });
                    
                    //codigo para la edicion de la tabla
                    ETable_applaince={
                        \"existingValue\":\"\",
                        \"init\":function(){
                            $('#accesorios').on('click','.originals',function(){
                                ETable_applaince.openEditable(this);
                            });
        
                            $('#accesorios').on('blur','.editable',function(){
                                var original = $(this).parent().parent().find('.original');
                                ETable_applaince.saveNewData(this,original);
                            });
                        },
                        \"openEditable\":function(elem){
                            $(elem).siblings().removeClass('hide');
        
                            //verifico si es la categoria
                            if($(elem).attr('id')==='tbl_sel_category')
                            {
                                //lleno el combo de las categorias
                                $.ajax({
                                    url: \"../appliances\",
                                    type:  'get',
                                    dataType: 'json',
                                    success : function(data) {
                                        $(elem).siblings().find('.editable').html('');
                                        for(var i=0;i<data.length;i++)
                                        {
                                            $(elem).siblings().find('.editable').append('<option data-id=\"'+data[i].id+'\" value=\"'+data[i].id+'\">'+data[i].category+'</option>');
                                        }
                                        $(elem).siblings().find('option:contains(\"'+$(elem).html()+'\")').prop('selected', true);
                                    },
                                    complete:function(){}
                                });
                                
                                $(elem).hide();
                                $(elem).siblings().show();
                                $(elem).siblings().find('.editable').focus();
                            }
                            else if($(elem).attr('id')==='tbl_sel_appliance')
                            {
                               //var categoria = $(elem).parents('tr').find('td:eq(\"0\") .editors option:selected').val();
                               var categoria = $(elem).parents('tr').find('td:eq(\"0\") .originals').html();
                               var tipo = $('#interesting').val();
                              
                               $.ajax({
                                        url:  \"../applianceslistname\",
                                        data: \"&categoria=\"+categoria,
                                        type:  'get',
                                        dataType: 'json',
                                        success : function(data) {
                                          $(elem).siblings().find('.editable').html('');
                                            for(var i=0;i<data.length;i++)
                                            {
                                               $(elem).siblings().find('.editable').append('<option value=\"'+data[i].id+'\">'+data[i].name+'</option>');
                                            }
                                            $(elem).siblings().find(\"option\").filter(function(){
                                                return $(this).text() === $(elem).html();
                                            }).prop('selected', true);
                                        },
                                        complete:function(){
                                             $('#modal-loading').modal('hide');
                                        }
                                     });
                                     
                                $(elem).hide();
                                $(elem).siblings().show();
                                $(elem).siblings().find('.editable').focus();
                            }
                            else if($(elem).attr('id')==='tbl_sel_subcategory')
                            {
                                var id_categoria = $(elem).parents('tr').find('td:eq(\"1\") .combo').val();
                                
                                if(id_categoria != null) {
                                    $.ajax({
                                            url: '../listadosub',
                                            data: \"id=\"+id_categoria,
                                            type:  'get',
                                            dataType: 'json',
                                            success : function(data) {
                                                $(elem).siblings().find('.editable').html('');
                                                for(var i=0;i<data.length;i++)
                                                {
                                                   $(elem).siblings().find('.editable').append('<option value=\"'+data[i].id+'\">'+data[i].name+'</option>');
                                                }
                                                $(elem).siblings().find(\"option\").filter(function(){
                                                    return $(this).text() === $(elem).html();
                                                }).prop('selected', true);
                                           },
                                            complete:function(){                                               
                                               $('#modal-loading').modal('hide');
                                            }
                                    });
                                    
                                $(elem).hide();
                                $(elem).siblings().show();
                                $(elem).siblings().find('.editable').focus();
                                    
                                } else {
                                    $(elem).siblings().addClass('hide');
                                }
                            }else {
                                $(elem).hide();
                                $(elem).siblings().show();
                                $(elem).siblings().find('.editable').focus();
                            }                           
        
                            
                            oTableaccesorios.existingValue=$(elem).html();
                        },
                        \"saveNewData\":function(elem){
                            var newVal=$(elem).val();
                            var texto=\"\";
                            
                            //obtengo el index de la columna sobre la que estoy accionando
                            var columnIdx = oTableaccesorios.cell( $(elem).parents('td')).index().column;
                            $('#modal-loading').modal('show');
                            
                            if($(elem).hasClass('combo')){
                                texto=$(elem).find('option:selected').text();
        
                                if(texto!==$(elem).parent().siblings().html())
                                {
                                    $(elem).parent().siblings().html(texto);
        
                                    if(columnIdx ===0)
                                    {
                                        var cell = oTableaccesorios.cell( $(elem).parents('td').next() );
                                        cell.data('<span class=\"editors\"><select class=\"editable form-control combo\"></select></span><span class=\"originals\" id=\"tbl_sel_appliance\">Select an appliance</span>').draw();
                                        var cell = oTableaccesorios.cell( $(elem).parents('tr').find('td:eq(\"2\")') );
                                        cell.data('<span class=\"editors\"><select class=\"editable form-control combo\"></select></span><span class=\"originals\" id=\"tbl_sel_subcategory\">Select a detail</span>').draw();
                                        var cell = oTableaccesorios.cell( $(elem).parents('tr').find('td:eq(\"3\")') );
                                        cell.data('<span class=\"editors\"><input class=\"editable form-control\" value=\"Description\"/></span><span class=\"originals\">Description</span>');
                                        var cell = oTableaccesorios.cell( $(elem).parents('tr').find('td:eq(\"4\")') );
                                        cell.data('<span class=\"editors\"><input class=\"editable form-control number\" value=\"0.00\"/></span><span class=\"originals\">0.00</span>');
                                        var cell = oTableaccesorios.cell( $(elem).parents('tr').find('td:eq(\"5\")') );
                                        cell.data('<span class=\"editors\"><input class=\"editable form-control number\" value=\"1\"/></span><span class=\"originals\">1</span>');
                                        var cell = oTableaccesorios.cell( $(elem).parents('tr').find('td:eq(\"6\")') );
                                        cell.data('0.00');
                                        actualizar_total();
                                    }
                                    if(columnIdx ===1)
                                    {
                                        var cell = oTableaccesorios.cell( $(elem).parents('tr').find('td:eq(\"2\")') );
                                        cell.data('<span class=\"editors\"><select class=\"editable form-control combo\"></select></span><span class=\"originals\" id=\"tbl_sel_subcategory\">Select a detail</span>').draw();
                                        var cell = oTableaccesorios.cell( $(elem).parents('tr').find('td:eq(\"3\")') );
                                        cell.data('<span class=\"editors\"><input class=\"editable form-control\" value=\"Description\"/></span><span class=\"originals\">Description</span>');
                                        var cell = oTableaccesorios.cell( $(elem).parents('tr').find('td:eq(\"4\")') );
                                        cell.data('<span class=\"editors\"><input class=\"editable form-control number\" value=\"0.00\"/></span><span class=\"originals\">0.00</span>');
                                        var cell = oTableaccesorios.cell( $(elem).parents('tr').find('td:eq(\"5\")') );
                                        cell.data('<span class=\"editors\"><input class=\"editable form-control number\" value=\"1\"/></span><span class=\"originals\">1</span>');
                                        var cell = oTableaccesorios.cell( $(elem).parents('tr').find('td:eq(\"6\")') );
                                        cell.data('0.00');
                                        actualizar_total();
                                    }
                                    if(columnIdx ===2)
                                    {
                                        var id_subcategoria = $(elem).parents('tr').find('td:eq(\"2\") .combo').val();           
        
                                        $.ajax({
                                            url: '../applianceslistinside',
                                            data: \"id=\"+id_subcategoria,
                                            type:  'get',
                                            dataType: 'json',
                                            success : function(data) {        
                                                var cell = oTableaccesorios.cell( $(elem).parents('tr').find('td:eq(\"3\")') );
                                                cell.data('<span class=\"editors hide\"><input class=\"editable form-control\" value=\"'+data[0].description+'\"/></span><span class=\"originals\">'+data[0].description+'</span>');
                                                var cell = oTableaccesorios.cell( $(elem).parents('tr').find('td:eq(\"4\")') );
                                                cell.data('<span class=\"editors hide\"><input class=\"editable form-control number\" value=\"'+data[0].price+'\"/></span><span class=\"originals\">'+data[0].price+'</span>');
                                            },
                                            complete:function(){
                                               //Guardamos en BD
                                               //var id_appliance = $(elem).parent().parent().parent().children().val();
                                               var id_appliance = $(elem).parents('tr').find('td:eq(\"7\")').children().val();
                                               var item_category = $(elem).parents('tr').find('td:eq(\"0\") .originals').text();
                                               var item_name = $(elem).parents('tr').find('td:eq(\"1\") .originals').text();
                                               var item_subcategory = $(elem).parents('tr').find('td:eq(\"2\") .originals').text();
                                               var descripcion_details = $(elem).parents('tr').find('td:eq(\"3\") .originals').text();
                                               var price = $(elem).parents('tr').find('td:eq(\"4\") .originals').text();
                                               var cant = $(elem).parents('tr').find('td:eq(\"5\") .originals').text();
                                               
                                               $.ajax({
                                                    url: '../updateappliance',
                                                    data: \"id_appliance=\"+id_appliance+\"&item_category=\"+item_category+\"&item_name=\"+item_name+\"&item_subcategory=\"+item_subcategory+\"&descripcion_details=\"+descripcion_details+\"&price=\"+price+\"&cant=\"+cant,
                                                    type:  'get',
                                                    dataType: 'json',
                                                    success : function(data) {
                                                        var precio=$(elem).parents('tr').find('td:eq(\"4\") .originals').html();
                                                        var cantidad=$(elem).parents('tr').find('td:eq(\"5\") .originals').html();
                                                        var cell = oTableaccesorios.cell( $(elem).parents('tr').find('td:eq(\"6\")'));
                                                        cell.data(precio * cantidad ).draw();
                                                        $('#modal-loading').modal('hide');                         
                                                   }
                                                });
                                               
                                            }
                                        });
                                    }
                                    
                                }
                            }else{
                                $(elem).parent().siblings().html(newVal);
                            }
                            
                            if(columnIdx ===3 || columnIdx ===4 || columnIdx ===5)
                            {
                                //Guardamos en BD
                                //var id_appliance = $(elem).parent().parent().parent().children().val();
                                var id_appliance = $(elem).parents('tr').find('td:eq(\"7\")').children().val();
                                var item_category = $(elem).parents('tr').find('td:eq(\"0\") .originals').text();
                                var item_name = $(elem).parents('tr').find('td:eq(\"1\") .originals').text();
                                var item_subcategory = $(elem).parents('tr').find('td:eq(\"2\") .originals').text();
                                var descripcion_details = $(elem).parents('tr').find('td:eq(\"3\") .originals').text();
                                var price = $(elem).parents('tr').find('td:eq(\"4\") .originals').text();
                                var cant = $(elem).parents('tr').find('td:eq(\"5\") .originals').text();
                                        
                                $.ajax({
                                    url: '../updateappliance',
                                    data: \"id_appliance=\"+id_appliance+\"&item_category=\"+item_category+\"&item_name=\"+item_name+\"&item_subcategory=\"+item_subcategory+\"&descripcion_details=\"+descripcion_details+\"&price=\"+price+\"&cant=\"+cant,
                                    type:  'get',
                                    dataType: 'json',
                                    success : function(data) {                                                
                                        $('#modal-loading').modal('hide');                         
                                   }
                                });
                            }
                            
                            //actualizo la columna del precio total, solo hago la suma y multiplicacion cuando cambio la cantidad y no cuando cambio la descripcion
                            if(columnIdx ===4 || columnIdx ===5)
                            {
                                var precio=$(elem).parents('tr').find('td:eq(\"4\") .originals').html();
                                var cantidad=$(elem).parents('tr').find('td:eq(\"5\") .originals').html();
                                var cell = oTableaccesorios.cell( $(elem).parents('tr').find('td:eq(\"6\")'));
                                cell.data(precio * cantidad ).draw();
                            }
                            $('#modal-loading').modal('hide');
                            $('.editors').hide();
                            $('.originals').show();
                        }
                    };
                    ETable_applaince.init();                    
                    
                    
	        		 $('#interesting').on('change',function(){
                          Actualizar_Estado();
                          updateTotales();
                     });
                     
                     $('#buildout_price').on('change',function(){
                          actualizar_total();   
                          updateTotales();                       
                     });
                     
                     if($('#financing').val() === 'Yes'){
                          $('#alerta').css('display','block');
                     } else{
                          $('#alerta').css('display','none');
                     }
                     
                     //para el combo de financiamiento
                     $('#financing').on('change',function(){
                          if($(this).val() === 'Yes'){
                              $('#alerta').css('display','block');
                          }else{
                              $('#alerta').css('display','none');
                          }
                     });
                     
                     $('#starting').on('change',function(){
                          $('#resumen_truck').val($('#starting').val());
                          actualizar_total(); 
                     });
                     
                     function updateTotales() {
                        //console.log($('#taxbuildout').val()+'--'+$('#taxappliance').val()+'--'+$('#taxitem').val());
                     }
                     
                     function Actualizar_Estado() {
                           var type = $('#interesting').val();
                           $('#types').html('');
                           $('#sizes').html('');     
                           $('#sizes').removeAttr('title');   
                           $('#select2-sizes-container').html('**Select Data**'); 
                           $('#starting').val('0.00');  
                           $('#modal-loading').modal('show');            
                            $.ajax
                            ({
                                url: '../types/'+type,
                                data: '',
                                type: 'get',
                                success: function(data)
                                {            
                                    $('#types').append('<option value=\"\">**Select Data**</option>');
                                    for(var i=0;i<data.length;i++)
                                    {
                                        $('#types').append('<option value=\"'+data[i].id+'\">'+data[i].state+'</option>');
                                    }
                                    
                                    $('#modal-loading').modal('hide');
                                }
                            });
                     }
                     
                     $('#types').on('change',function(){
                        var type = $('#interesting').val();
                        $('#sizes').html('');
                        $('#select2-sizes-container').html('**Select Data**');
                        
                        $('#starting').val('0.00');
                        $('#modal-loading').modal('show');
                        $.ajax({
                           url: '../sizes/'+type,
                           data: '',
                           type:  'get',
                           dataType: 'json',
                           success : function(data) {
                                $('#sizes').append('<option value=\"\">**Select Data**</option>');
                                for(var i=0;i<data.length;i++)
                                {
                                    $('#sizes').append('<option value=\"'+data[i].id+'\">'+data[i].size+'</option>');
                                }
                                
                                $('#modal-loading').modal('hide');
                                
                                updateTotales();
                           }
                        });
                       
                    });
                                        
                    $('#sizes').on('change',function(){       
                        $('#price').val('0.00');                        
                        var type = $('#interesting').val();
                        var size = $('#sizes').val();                        
                        var state = $('#types').val();
                        $('#check_item').prop('checked',true);
                        $('#modal-loading').modal('show');
                        
                        $('#buildout_name').html('');
                        $('#buildout_price').val('0.00'); 
                        $('#buildout_description').html('');
                        $('.note-editing-area:nth-child(3)').html('');
                        
                         if($('#types').val() !=='' && $('#sizes').val() !== '') {
                                $.ajax({
                                    url: '../prices',
                                    data: \"type=\"+type+\"&size=\"+size+\"&state=\"+state,
                                    type:  'get',
                                    dataType: 'json',
                                    success : function(data) {
                                         var precio = new Number(data[0].price).toFixed(2);
                                         $('#starting').val(precio);
                                         $('#resumen_truck').val(precio);                                          
                                         $('#modal-loading').modal('hide');
                                         actualizar_total();                               
                                   }
                                });
                                
                                updateTotales();
                        }
                        
                        $.ajax({
                            url: '../buildout/',
                            data: \"type=\"+type+\"&size=\"+size,
                            type:  'get',
                            dataType: 'json',
                            success : function(data) {
                                $('#builout').append('<option value=\"\"></option>');
                                $('#buildout_name').append('<option value=\"\">***Select Build Out***</option>');
                                for(var i=0;i<data.length;i++)
                                {
                                    $('#buildout_name').append('<option value=\"'+data[i].id+'\">'+data[i].nombre+'</option>');                                    
                                }
                                
                                updateTotales();
                            }
                         });                    
                        
                    });
                    
                    
                    $('#buildout_name').on('change',function(){ 
                        var buildout_name = $(this).val();                        
                        $('#buildout_description').html('');   
                        $('.note-editing-area:nth-child(3)').html('');    
                        $('#modal-loading').modal('show');  
                        $.ajax({
                            url: '../buildoutbyid/'+buildout_name,
                            data: '',
                            type:  'get',
                            dataType: 'json',
                            success : function(data) {
                                $('#buildout_price').val(new Number(data[0].precio).toFixed(2));
                                                               
                                //$('#buildout_description').summernote({ height: ($(window).height() - 300) });                                
                                //$('#buildout_description:nth-child(3) p').append(data[0].description);                                
                                $('.note-editing-area:nth-child(3)').append(data[0].descripcion);
                                
                                
                                $('#buildout_description').summernote('code',data[0].descripcion);                                 
                                $('#buildout_description').val(data[0].descripcion);
                                
                                $('#resumen_buildout').val(new Number(data[0].precio).toFixed(2));   
                                $('#modal-loading').modal('hide');
                                
                                actualizar_total();    
                                
                                updateTotales();                  
                            }
                         });
                    });
                    
                    $('#send-email-personal').on('click',function(){                     
                        $('#modal-sendEmailPersonal').modal('show');                                               
                    });
                    
                    $('#discount').on('change',function(){
                        actualizar_total();     
                        
                        updateTotales();             
                    });
                    
                    $('#state').on('change',function(){
                        actualizar_total();   
                        
                        updateTotales();               
                    });
                    
                    function cleanApplianceModal() {
                         $('#appliance').html('');
                         $('#select2-appliance-container').html('');                         
                         $('#product').html('');                         
                         $('#select2-appliance-container').html('**Select Data**');
                         $('#select2-product-container').html('**Select Data**');
                         $('#select2-appliance_inside_category-container').html('**Select Data**');                         
                         $('#description').val('');                         
                         $('#price2').val('');
                         $('#quantity').val('');
                         $('#total').val('');
                    }
                   
                    $('#new').on('click',function(){ 
                         var interesting = $('#interesting').val(); 
                         cleanApplianceModal();
                         $('#modal-loading').modal('show');
    
                         $.ajax({
                                  url: '../appliancescategories/',
                                  data: '',
                                  type:  'get',
                                  dataType: 'json',
                                  success : function(data) {
                                    $('#appliance').append('<option value=\"\"></option>'); 
                                    for(var i=0;i<data.length;i++)
                                    {
                                       $('#appliance').append('<option value=\"'+data[i].id+'\">'+data[i].category+'</option>');
                                    }
                                    
                                    //Limpiar Modal de Appliances
                                    
                                    $('#modal-loading').modal('hide');
                                    
                                    updateTotales();
                                    
                                  }
                               });
                               
                        $('#applianceModal').modal('show');                        
                    });
                    
                    //Agregando Nueva Subcategoría de Appliance
                    $('#newSubCategoryApplianceModal').on('click','#addSubCategory',function(){
                        var categoria = $('#appliance_subcategory').val();                         
                        var subcategoria = $('#subcategory_name').val();                         
                    
                        $.ajax({
                                url:  '../addsubcategory',
                                data: \"&categoria=\"+categoria+\"&subcategoria=\"+subcategoria,
                                type:  'get',
                                dataType: 'json',
                                success : function(data) {
                                    if(data == 1) {
                                        $('#newSubCategoryApplianceModal').modal('hide');
                                        $('#appliance_subcategory').val('');
                                        $('#subcategory_name').val('');
                                        
                                        $.ajax({
                                          url: '../appliancescategories/',
                                          data: '',
                                          type:  'get',
                                          dataType: 'json',
                                          success : function(data) {
                                            $('#appliance_new').append('<option value=\"\"></option>'); 
                                            for(var i=0;i<data.length;i++)
                                            {
                                               $('#appliance_new').append('<option value=\"'+data[i].id+'\">'+data[i].category+'</option>');
                                            }                                  
                                            
                                          }
                                       });
                                        
                                        $('#applianceModal').modal('show');
                                                                                
                                    }                                                                                                  
                                }
                             });
                    });
                    
                    $('#newCategoryApplianceModal').on('click','#closeCategoryCategory',function(){
                        $('#category_category_name').val('');                         
                        $('#newCategoryApplianceModal').modal('hide');
                        newApplianceModal();
                    });
                    
                    $('#newSubCategoryApplianceModal').on('click','#closeSubCategory',function(){
                        $('#subcategory_name').val(''); 
                        $('#newSubCategoryApplianceModal').modal('hide'); 
                        $('#select2-appliance_subcategory-container').html('**Select Data**');   
                        newApplianceModal();
                    });
                    
                    
                    $('#applianceModal').on('change','#appliance',function(){
                       $('#product').html('');
                       $('#appliance_inside_category').html('');
                       $('#description').val('');
                       $('#price2').val('');
                       $('#quantity').val('');
                       $('#total').val('');
                       $('#imagen').attr('src','http://ezcrm.us/assets/images/appliances/image-not-found.png');
                       var categoria = $('#appliance').val();
                       $('#modal-loading').modal('show');                       
                       $('#select2-product-container').html('**Select Data**');                         
                       $('#select2-appliance_inside_category-container').html('**Select Data**');

                       $.ajax({
                                url:  '../applianceslist',
                                data: \"&categoria=\"+categoria,
                                type:  'get',
                                dataType: 'json',
                                success : function(data) {
                                  $('#product').append('<option value=\"\"></option>');
                                  for(var i=0;i<data.length;i++)
                                  {
                                     $('#product').append('<option value=\"'+data[i].id+'\">'+data[i].name+'</option>');
                                  }
                                  $('#modal-loading').modal('hide');
                                  
                                  updateTotales();
                                  
                                }
                             });
                    });
                    
                    
                    $('#applianceModal').on('change','#product',function(){
                           $('#appliance_inside_category').html('');
                           $('#description').val('');
                           $('#price2').val('');
                           $('#quantity').val('');
                           $('#total').val('');
                           $('#imagen').attr('src','http://ezcrm.us/assets/images/appliances/image-not-found.png');
                           var id = $(this).val(); 
                           $('#modal-loading').modal('show');
                           $('#select2-appliance_inside_category-container').html('**Select Data**');

                           $.ajax({
                                url: '../listadosub',
                                data: \"id=\"+id,
                                type:  'get',
                                dataType: 'json',
                                success : function(data) {
                                   $('#appliance_inside_category').append('<option value=\"\"></option>');
                                    for(var i=0;i<data.length;i++)
                                    {
                                       $('#appliance_inside_category').append('<option value=\"'+data[i].id+'\">'+data[i].name+'</option>');
                                    }
                                    $('#modal-loading').modal('hide');
                                    
                                    updateTotales();
                                }
                             });
                    });
                    
                    
                    $('#applianceModal').on('change','#appliance_inside_category',function(){
                       var id = $(this).val(); 
                       $('#modal-loading').modal('show');
                       $.ajax({
                            url: '../searchappliances',
                            data: \"id=\"+id,
                            type:  'get',
                            dataType: 'json',
                            success : function(data) {
                                 $('#description').val(data[0].description);
                                 $('#price2').val(data[0].price);
                                 $('#price2_retail').val(data[0].retail_price);
                                 $('#quantity').val(1);
                                 $('#total').val(data[0].price);                                 
                                
                                 if(data[0].imagen==null) 
                                   $('#imagen').attr('src','http://ezcrm.us/assets/images/appliances/no_photo.jpg');
                                 else
                                   $('#imagen').attr('src','http://ezcrm.us/assets/images/appliances/'+data[0].imagen);
                                   $('#modal-loading').modal('hide');
                                   
                                   updateTotales();
                            }
                         });
                    });
                    
                    
                    $('#modal-sendEmailPersonal').on('click','#sendMail',function(){
                        var to = $('#form-tag-to').val();
                        var id = $('#quote_id').val();
                        
                        //console.log('ID: '+id);
                        $.ajax({
                            url: '../sendemailpersonal',
                            data: \"id=\"+id+\"&to=\"+to,
                            type:  'get',
                            dataType: 'json',
                            success : function(data) {
                                $('#modal-sendEmailPersonal').modal('hide');
                                $('#success-sendEmailPersonal').modal('show');                                                               
                            }
                         });         
                    });
                    
                    //Botón para agregar nuevo BuildOut en modal
                    $('#newBuildout').on('click',function(){
                         $('#nombreba').val('');
                         $('#descriptionba').html('');
                         $('#descriptionba').val('');
                         $('#descriptionba').removeAttr('title');                         
                         //$('.note-editing-area').html('');                         
                         //$('.note-editable').html('');                         
                         $('#price2ba').val('');
                         $('#Build_OutGModal').modal('show');                         
                    });
                    
                    //Abrir el Modal para Agregar Nuevo Buildout
                    $('#Build_OutGModal').on('click','#savebuilout',function(){
                        //Cargando variables del modal             
                        var tipo = $('#interesting').val();

                        //Si es un TRUCK
                        if(tipo == 1) {
                            var name = 'Build Out - '+$('#nombreba').val();
                        }
                        else if(tipo == 2) { // Si es un TRAILER
                            var name = $('#sizes option:selected').html()+' '+$('#nombreba').val();
                        }                        
                               
                        var name = $('#sizes option:selected').html()+' '+$('#nombreba').val();
                        var description = $('#descriptionba').summernote('code');
                        var price = $('#price2ba').val();
                        $('#buildout_name').html('');
                        
                        var type = $('#interesting').val();
                        var size = $('#sizes').val();                        
                        $('#buildout_price').val('0.00'); 
                        $('#buildout_description').html('');
                        //$('.note-editing-area:nth-child(3)').html('');
                        
                        $.ajax({
                            url: '../addbuildout',
                            data: \"name=\"+name+\"&description=\"+description+\"&price=\"+price+\"&tipo=\"+tipo,
                            type:  'get',
                            dataType: 'json',
                            success : function(data) {      
                                //Cargando en campos del buildout de la Quote actual
                                $('#buildout_description').summernote('code',description);
                                $('#Build_OutGModal').modal('hide');           
                                
                                updateTotales();                                                                                  
                            }
                         });       
                        
                        $.ajax({
                            url: '../buildout/',
                            data: \"type=\"+type+\"&size=\"+size,
                            type:  'get',
                            dataType: 'json',
                            success : function(data) {                               
                                $('#builout').append('<option value=\"\"></option>');
                                $('#buildout_name').append('<option value=\"\">***Select Build Out***</option>');
                                for(var i=0;i<data.length;i++)
                                {
                                    $('#buildout_name').append('<option value=\"'+data[i].id+'\">'+data[i].nombre+'</option>');                                    
                                }
                                
                                updateTotales();
                            }
                         });                  
                    });
                    
                    
                    $('#applianceModal').on('click','#addSave',function(){
                    
                        var appliance = $('#appliance option:selected').text();             
                        var product = $('#product option:selected').text();
                        var subcategory = $('#appliance_inside_category option:selected').text();
                        var description = $('#description').val();
                        var price = $('#price2').val();
                        var quantity = $('#quantity').val();
                        var parcialtotal = $('#total').val();
                        
                        //Guardamos el appliance insertado
                        var id_truck = $('#quote_id').val();
                        var id_account = $('#account_id').val();
                        var item_category = appliance;
                        var item_name = product;
                        var item_subcategory = subcategory;
                        var descripcion_details = description;
                        var cant = quantity;
                        var from_where = 2; //Insertado desde el CRM
                       
                         $.ajax({
                            url: '../addappliance',
                            data: \"id_truck=\"+id_truck+\"&item_category=\"+item_category+\"&item_name=\"+item_name+\"&item_subcategory=\"+item_subcategory+\"&descripcion_details=\"+descripcion_details+\"&price=\"+price+\"&cant=\"+cant+\"&id_account=\"+id_account+\"&from_where=\"+from_where,
                            type:  'get',
                            dataType: 'json',
                            success : function(data) {                                
                                
                                oTableaccesorios.row.add( [
                                     '<span class=\"editors hide\"><select class=\"col-md-12 col-sm-12 editable form-control combo\" ></select></span><span class=\"originals\" id=\"tbl_sel_category\">'+appliance+'</span>',
                                     '<span class=\"editors hide\"><select class=\"col-md-12 col-sm-12 editable form-control combo\" ></select></span><span class=\"originals\" id=\"tbl_sel_appliance\">' + product + '</span>',
                                     '<span class=\"editors hide\"><select class=\"col-md-12 col-sm-12 editable form-control combo\" ></select></span><span class=\"originals\" id=\"tbl_sel_subcategory\">' + subcategory + '</span>',
                                     '<span class=\"editors hide\"><input class=\"col-md-12 col-sm-12 editable form-control\" value=\"' + description + '\"/></span><span class=\"originals\">' + description + '</span>',
                                     '<span class=\"editors hide\"><input class=\"col-md-12 col-sm-12 editable form-control number\" value=\"' + price + '\"/></span><span class=\"originals\">' + price + '</span>',
                                     '<span class=\"editors hide\"><input class=\"col-md-12 col-sm-12 editable form-control number\" value=\"' + quantity + '\"/></span><span class=\"originals\">' + quantity + '</span>',
                                     parcialtotal,
                                   '<button class=\"btn btn-danger\" value='+data+' name='+data+' type=\"button\" id=\"eliminar\"><span class=\"glyphicon glyphicon-trash\"></span></button>'
                               ]).draw( false );   
                               
                               $('#modal-loading').modal('hide');                    
                           }
                        }); 
                       
                       $('#description').val('');
                       $('#price2').val('');
                       $('#price2_retail').val('');
                       $('#quantity').val('');
                       $('#total').val(''); 
                       $('#appliance').val('');
                       $('#product').val('');
                       $('#appliance_inside_category').val(''); 
                       $('#imagen').attr('src','http://ezcrm.us/assets/images/appliances/no_photo.jpg');
                       
                       actualizar_total();
                       $('#applianceModal').modal('hide');    

                        updateTotales();                    

                    });
                    
                    $(\"#quantity\").keyup(function(e){         
                        var price = $('#price2').val(); 
                        var cant=$('#quantity').val();
                        var total=parseFloat(price)*parseFloat(cant);
                        $('#total').val(total);                        
                    });     
                    
                    //Agregar nuevo appliance
                    $('#applianceModal').on('click','#addNew',function(){
                        newApplianceModal();
                    });
                     
                    function newApplianceModal() {
                        $('#applianceModal').modal('hide');                                             
                        
                        $.ajax({
                          url: '../appliancescategories/',
                          data: '',
                          type:  'get',
                          dataType: 'json',
                          success : function(data) {
                            $('#appliance_new').append('<option value=\"\"></option>'); 
                            for(var i=0;i<data.length;i++)
                            {
                               $('#appliance_new').append('<option value=\"'+data[i].id+'\">'+data[i].category+'</option>');
                            }                                  
                            
                          }
                       });
                        
                        $('#newApplianceModal').modal('show');
                    }    
                    
                    function applianceModal() {
                        cleanApplianceModal();
                       
                        $.ajax({
                          url: '../appliancescategories/',
                          data: '',
                          type:  'get',
                          dataType: 'json',
                          success : function(data) {
                            $('#appliance').append('<option value=\"\"></option>'); 
                            for(var i=0;i<data.length;i++)
                            {
                               $('#appliance').append('<option value=\"'+data[i].id+'\">'+data[i].category+'</option>');
                            }                                  
                            
                          }
                       });
                        
                        $('#applianceModal').modal('show');
                    }           
                    
                    $('#newApplianceModal').on('change','#appliance_new',function(){
                       $('#product_new').html('');
                       $('#modal-loading').modal('show');                       
                       $('#appliance_inside_category_new').val('');
                       $('#description_new').val('');
                       $('#price2_new').val('');
                       $('#price2_retail_new').val('');
                       var categoria = $('#appliance_new').val();
                       $('#select2-product_new-container').html('**Select Data**');

                       $.ajax({
                                url:  '../applianceslist',
                                data: \"&categoria=\"+categoria,
                                type:  'get',
                                dataType: 'json',
                                success : function(data) {
                                  $('#product_new').append('<option value=\"\"></option>');
                                  for(var i=0;i<data.length;i++)
                                  {
                                     $('#product_new').append('<option value=\"'+data[i].id+'\">'+data[i].name+'</option>');
                                  }
                                  
                                  $('#modal-loading').modal('hide');
                                  
                                }
                             });
                    }); 
                    
                    $('#newApplianceModal').on('change','#product_new',function(){
                       $('#modal-loading').modal('show');        
                                      
                       $('#appliance_inside_category_new').val('');
                       $('#description_new').val('');
                       $('#price2_new').val('');
                       $('#price2_retail_new').val('');
                       
                       $('#modal-loading').modal('hide');
                    });   
                                       
                    
                    
                    //boton de eliminar las filas en la tabla de accesorios
                       $('#accesorios').on('click','#eliminar',function(){
                             var fila=$(this).parents('tr');
                            if($(\"#sourse\").val()==\"1\")
                            {   
                                showConfirm();
                            }
                            else
                            {
                                var fila = $(this).parents('tr');
                                var valor = $(this).attr('name');
                                
                                if($('#applianceitem_'+valor).val() != null) {
                                    $('#applianceitem_'+valor).val('');
                                }
                                else {
                                    $.ajax
                                        ({
                                            url: '../appliancedelete/'+valor,
                                            data: '',
                                            type: 'get',
                                            success: function(data)
                                            {                                    
                                                alert('Eliminado');
                                            }
                                        });
                                }
                                                                
                                oTableaccesorios.row(fila).remove().draw(false);
                                actualizar_total();
                                
                                
                                updateTotales();
                            }
                       });                     
                       
                       function actualizar_total()
                        {        
                              updateTax();
                              
                              if($('#buildout_price').val() != '') {
                                $('#resumen_buildout').val($('#buildout_price').val());
                              }                   
                              
                              var resumen_registration= $('#registration').val();
                              var resumen_truck= $('#resumen_truck').val();
                              var taxitem= $('#taxitem').val();
                              var taxbuildout= $('#taxbuildout').val();
                              var resumen_buildout= ($('#buildout_price').val() != '') ? $('#buildout_price').val() : \"0.00\";
                              var resumen_taxbuildout= $('#taxbuildout').val();
                              var resumen_appliance= $('#resumen_appliance').val();
                              var resumen_taxappliance= $('#taxappliance').val();                                                
                              var descuento =  $('#discount').val();                                                
                              var resumen_tax= $('#tax').val();
                              
                              /*taxes = parseFloat(resumen_taxbuildout) +
                                      parseFloat(resumen_taxappliance) +
                                      parseFloat(taxitem);*/   
                                      
                              taxes = parseFloat(resumen_taxappliance) +
                                      parseFloat(taxitem) +
                                      parseFloat(taxbuildout);                                  
                               
                              $('#tax').val(taxes);
                                                      
                              var subtotal = parseFloat(resumen_truck) +
                                             parseFloat(resumen_buildout) +
                                             parseFloat(resumen_appliance) -
                                             parseFloat(descuento);
                            
                              $('#subtotal_without_tax').val(subtotal);
                            
                              var total = subtotal + taxes + parseFloat(resumen_registration);
                              $('#gtotalquote').val(total.toFixed(2));
                            
                              var interesting = $('#interesting').val();
                        }
                        
                        function updateTax() {
                              var stateSelect = $('#state');
                                                            
                              if(stateSelect.val() === 'TX') {
                                                              
                                  var buildoutPrice = $('#buildout_price').val();
                                                              
                                  // Set premium package ids to identify amount of taxes.
                                  //var premiumPackageIds = [1, 3, 4, 5, 6, 7, 8, 9, 10, 26]; 
                                  var premiumPackageIds = [1];    
                            
                                  // Set trailer package ids to identify amount of taxes.
                                  var trailerPackageIds = [3, 4, 5, 6, 7, 8, 9, 10, 11, 
                                                            20, 21, 22, 26, 27, 28, 29,
                                                            31, 32, 33, 34, 35, 36]; 
                            
                                  // Buildout selected id 
                                  var buildoutValue = parseInt($('#builout').val());
                            
                                  // Amount of taxes
                                  var amount;                          
                                  amount = (buildoutPrice * .30).toFixed(2);
                                  
                                  // Truck tax
                                  var p=new Number($('#starting').val()).toFixed(2);
                                  
                                  /*$.ajax({
                                        url: '../taxitem/',
                                        data: '',
                                        type:  'get',
                                        dataType: 'json',
                                        success : function(data) {                                        
                                            $('#taxitem').val((p * (data/100)).toFixed(2));                                            
                                        }
                                  }); */                        
                                  
                                  $('#taxitem').val((p * (6.25/100)).toFixed(2));     
                                   
                                  // Verify if user is purchasing a truck and set buildout tax amount.
                                  var buildoutTax = 0;
                                  var taxAppliances = 0;
                            
                                  //tax de appliance
                                  var total=$('#total_app').html();  
                                  
                                  if($('#check_item').is( \":checked\" )) {                                    
                                    // Si Chef Units vende el camión, se calcula el 6.25 del precio del buildout 
                                    buildoutTax = (buildoutPrice * 0.0625).toFixed(2);
                                    
                                    //Calculamos el tax del total de appliances con el 6,25
                                    taxAppliances = (total * 0.0625).toFixed(2)
                                  } 
                                  else { 
                                     // Si Cliente tiene su propio camión
                                     //Obtengo el 30% del precio del buildout y luego aplico tax de 8.25
                                     buildoutTax = (buildoutPrice * 0.33 * 0.0825).toFixed(2);
                                     $('#taxitem').val('0.00');
                                     
                                     //Calculamos el tax del total de appliances con el 8,25
                                     taxAppliances = (total * 0.0825).toFixed(2)
                                  }
                                                        
                                  $('#taxbuildout').val(buildoutTax);                            
                                  $('#taxappliance').val(taxAppliances);
                                   
                              } else {
                                  $('#taxitem').val('0.00');
                                  $('#taxbuildout').val('0.00');
                                  $('#taxappliance').val('0.00');
                              }
                        }
                        
                        ////para el checkbox de registrar 
                        $('#check').on('click',function() {
                            var input = $( this );
                            if(input.is( \":checked\" ))
                            {
                                $('#registration').val('450.00');
                            }
                            else
                            {
                                $('#registration').val('0.00');
                            }
                            
                            actualizar_total();
                            updateTotales();
                        });
                        
                      ////para el checkbox de requeiro truck 
                      $('#check_item').on('click',function() {
                          var input = $( this );
                          if(input.is( \":checked\" )) {
                              $('#resumen_truck').val($('#starting').val());
                          } else {
                              $('#resumen_truck').val('0.00');
                              $('#taxitem').val('0.00');
                          }
                          actualizar_total();
                          updateTotales();
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

            $id = (CRUDBooster::isSuperadmin());
            $user_id = (CRUDBooster::myId());

            //Calculo el profits para los últimos 10 quotes,
            //previendo el cálculo de las quotes creadas en la app3d y webform
            $quotes = DB::table('user_trucks')->where('is_active', 0)->limit(10)->orderby('id','DESC')->get();

            for ($i=9; $i>=0; $i--) {
                $quote_updated = DB::table('user_trucks')->where('id', $quotes[$i]->id)->first();
                $ganancias = 0;

                if (!empty($quote_updated)) {
                    //Para el cálculo de las Ganancias debemos obtener la mitad del precio del TRUCK, TRAILER, CART, etc
                    if($quote_updated->price_item == 0 || $quote_updated->price_item == null) {
                        $ganancias += floatval($quote_updated->truck_price_range) * 30 / 100;
                    } else {
                        $ganancias += floatval($quote_updated->price_item) * 30 / 100;
                    }

                    //Para el cálculo de las Ganancias debemos obtener la mitad del precio del Buildout
                    if($quote_updated->precio_builout != 0) {
                        $ganancias += floatval($quote_updated->precio_builout) * 30 / 100;
                    }

                    $profits  = DB::table('truck_items')->where('id_truck', $quotes[$i]->id)->get();

                    foreach ($profits as $profit) {
                        $precio = DB::table('appliance_inside_category')->where('name', $profit->item_subcategory)->first();
                        $precio = ($profit->price) - ($precio->retail_price);
                        $ganancias += $precio;
                    }

                    if (empty($quote_updated->truck_aprox_price)) {
                        $ganancias = 0;
                    } else {
                        $ganancias = round(($ganancias * 100 / floatval($quote_updated->truck_aprox_price)), 2);
                    }

                    DB::table('user_trucks')->where('id', $quotes[$i]->id)->update(['profits' => floatval($ganancias)]);
                }
            }

            if ($id != 1) {
                $query->where('account.id_usuario', $user_id)
                ;
            } else {
                $query->where('user_trucks.is_active', 0)
                ;
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
	    	$order_detail = DB::table('truck_items')->where('id_truck',$id)->get();
            $orders = DB::table('user_trucks')->where('id',$id)->get();
            $products_type_id = null;
            $user_id = CRUDBooster::myId();
            $profit = 0;

            $leads = DB::table('user_trucks')
                ->join('account', 'account.id', '=', 'user_trucks.id_account')
                ->where('user_trucks.id', $id)->first();

            $quotes = DB::table('account')->where('id', $leads->id_account)->first();
            $quotes = $quotes->quotes;
            $quotes += 1;

            DB::table('account')->where('id', $leads->customers_id)->update(['quotes' => $quotes]);

            DB::table('orders')->where('id',$id)->update(['profit'=> abs($profit) ]);
            DB::table('orders')->where('id',$id)->update(['cms_users_id'=> $user_id ]);

	    	foreach($order_detail as $od) {
	    		$p = DB::table('products')->where('id',$od->products_id)->first();
	    		DB::table('products')->where('id',$od->products_id)->update(['stock'=> abs($p->stock - $od->quantity) ]);
                $products_type_id = $p->products_type_id;
	    	}

	    	/*foreach($orders as $order) {
	    		DB::table('user_trucks')->where('id',$id)->update(['products_type_id' => $products_type_id ]);
	    	}*/

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

            $leads = DB::table('user_trucks')
                ->join('account', 'account.id', '=', 'user_trucks.id_account')
                ->where('user_trucks.id', $id)->first();

            $quotes = DB::table('account')->where('id', $leads->id_account)->first();
            $quotes = $quotes->quotes;
            $quotes -= 1;

            if($quotes < 0) { $quotes = 0; }


            DB::table('user_trucks')->where('id', $id)->delete();
            DB::table('account')->where('id', $leads->id_account)->update(['quotes' => $quotes]);

	    }

	    //Agregar Buildout a la base de datos
        public function getAddbuildout(\Illuminate\Http\Request $request) {
            $sumarizedData = [
                'created_at' => Carbon::now(config('app.timezone')),
                'nombre' => $request->get('name'),
                'descripcion' => $request->get('description'),
                'precio' => $request->get('price'),
                'tipo' => $request->get('tipo'),
            ];

            DB::table('buildout')->insertGetId($sumarizedData);

            return 1;
        }

        //Agregar Product a la base de datos
        public function getAddproduct(\Illuminate\Http\Request $request) {
            $sumarizedData = [
                'type' => $request->get('type'),
            ];

            DB::table('type')->insertGetId($sumarizedData);

            return 1;
        }

        //Agregar Size a la base de datos
        public function getAddsize(\Illuminate\Http\Request $request) {
            $sumarizedData = [
                'size' => $request->get('size'),
            ];

            DB::table('size')->insertGetId($sumarizedData);

            return 1;
        }

        //Agregar Estado a la base de datos
        public function getAddestado(\Illuminate\Http\Request $request) {
            $sumarizedData = [
                'estado' => $request->get('estado'),
            ];

            DB::table('estado')->insertGetId($sumarizedData);

            return 1;
        }

        //Agregar Categoría de Appliance a la base de datos
        public function getAddcategory(\Illuminate\Http\Request $request) {
            $sumarizedData = [
                'category' => $request->get('valor'),
                'state' => 1,
            ];

            DB::table('appliance')->insertGetId($sumarizedData);

            return 1;
        }


        //Agregar Categoría de Appliance a la base de datos
        public function getAddsubcategory(\Illuminate\Http\Request $request)
        {
            $sumarizedData = [
                'id_appliance' => $request->get('categoria'),
                'name' => $request->get('subcategoria'),
                'id_type' => 4,
            ];

            DB::table('appliance_inside')->insertGetId($sumarizedData);

            return 1;
        }


        public function getAddnote(\Illuminate\Http\Request $request) {
            $name = $request->get('name');
            $quotes_id = $request->get('quotes_id');

            $sumarizedData = [
                'created_at' => Carbon::now(config('app.timezone')),
                'name' => $name,
                'quotes_id' => $quotes_id,
            ];

            DB::table('eazy_notes_quotes')->insertGetId($sumarizedData);

            return 1;
        }

        public function getSendemailpersonal(\Illuminate\Http\Request $request)
        {
            $id = $request->get('id');
            $to = $request->get('to');

            $toArray = explode(', ', $to);

            \Illuminate\Support\Facades\DB::beginTransaction();

            $result = \Illuminate\Support\Facades\DB::select(DB::raw("
                        SELECT truck_extras_price,
                            account.email,
                            account.`name`,
                             account.lastname,
                            account.state,
                            account.telephone,
                            user_trucks.truck_name,
                            user_trucks.truck_date_created,
                            user_trucks.downpayment,
                            user_trucks.truck_budget,
                            user_trucks.financing,
                            user_trucks.build_out,
                            user_trucks.time,
                            buildout.nombre,
                            CASE 
                                WHEN ISNULL(precio_builout) THEN buildout.precio
                                ELSE precio_builout
                                END
                                AS precio,
                            type.type as categoria,
                            id_account,
                            user_trucks.registration,
                            user_trucks.truck_aprox_price,
                            user_trucks.truck_tax,
                            user_trucks.id,
                            user_trucks.tax_item,
                            type.type AS categoria,
                            estado.estado,
                            size.size,
                            CASE 
                                WHEN user_trucks.price_item = 0 THEN user_trucks.truck_price_range
                                ELSE user_trucks.price_item
                                END
                                AS price_item,
                            user_trucks.discount,
                             CASE 
                                WHEN ISNULL(user_trucks.desc_buildout) THEN buildout.descripcion
                                ELSE user_trucks.desc_buildout
                                END
                                AS desc_buildout
                            FROM
                            account
                            INNER JOIN user_trucks ON user_trucks.id_account = account.id
                            LEFT JOIN buildout ON user_trucks.build_out = buildout.id
                            LEFT JOIN type ON type.id = user_trucks.interesting
                            LEFT JOIN estado ON user_trucks.id_type = estado.id
                            LEFT JOIN size ON user_trucks.id_size = size.id where user_trucks.id=$id
                        ;
                        ")
            );

            \Illuminate\Support\Facades\DB::commit();

            foreach ($result as $row) {
                //estructurando el hml de cada usuario
                $fechaneed=$row->truck_date_created;
                $fecha=date("m-d-Y",strtotime($fechaneed));
                $fechaneed1=$row->time;
                $fecha1=date("m-d-Y",strtotime($fechaneed1));

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
                                                   <div style="font-size:10px;" valign="middle" align="left">
                                                       <b>CLIENT</b>
                                                       <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->name." ".$row->lastname.'</p>
                                                       <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->state.'</p>
                                                       <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->telephone.'</p>
                                                       <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->email.'</p>
                                                     
                                                    </div>
                                            </td>
                                            <td>
                                                <div style="font-size:14px;" valign="middle" align="right"><b>Quote name: '.$row->truck_name.'</b></div>
                                                <div style="font-size:14px; padding-top: 10px" valign="middle" align="right"><b>Date: '.$fecha1.'</b></div>
                                            </td>
                                        </tr>
                                      
                                         <tr>
                                               
                                              
                                        </tr>
                              </table> ';

                //Agregando Financiamiento.user_trucks.financing,
                $html =  $html.  '<table width="100%" border="0" align="center" cellspacing="0" cellpadding="4">
                                     <tr>
                                       <td align="left" valign="top" bgcolor="#dda51c" style="background-color:#026873; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#ffffff;"><b>FINANCING</b></td>
                                     </tr>
                                     <tr>
                                         <td align="left"  style="font-size:10px;">
                                             <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr style="font-size:10px;">
                                                   <td align="left"><p><b>Need Financing: </b>'.$row->financing.' </p></td>
                                                   <td align="left"><p><b>How soon you need it?: </b> '.$fecha1.' </p></td>
                                                   <td align="left"><p><b>Budget: </b>'.$row->truck_budget.'</p></td>
                                                   <td align="left" ><p><b>Downpayment: </b> '.$row->downpayment.' </p></td>
                                                  
                                                </tr>
                                                
                                                                                                 
                                               </table>

                                         </td>
                                     </tr>
                                 </table>';
                //Agregando los bluid_out y del precio del camion
                $html = $html .  '        
                              <table width="100%" border="0" align="center" cellspacing="0" cellpadding="4" >
                                     <tr style="color:#FFF; font-size:12px;">
                                            <td width="10%" bgcolor="#026873"><b>CATEGORY</b></td>
                                            <td width="20%" bgcolor="#026873"><b>TYPE</b></td>
                                            <td width="20%" bgcolor="#026873"><b>SIZE</b></td>
                                            <td width="20%" bgcolor="#026873"><b>PRICE</b></td>
                                     </tr>
                                       <tr style="font-size:10px;">
                                          <td >'.$row->categoria.'</td>
                                          <td >'.$row->estado.'</td>
                                          <td >'.$row->size.'</td>
                                          <td >'.$row->price_item.'</td>
                                       </tr>
                              </table>';
                $html = $html .  '<table width="100%" border="0" align="center" cellspacing="0" cellpadding="4" >
                                      <tr>
                                        <td colspan="4" align="left" valign="top" bgcolor="#dda51c" style="background-color:#026873; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#ffffff;"><b>TRUCK SELECTION</b></td>

                                      </tr>
                                      <tr style="color:#FFF;font-size:12px;">
                                          <td width="10%" bgcolor="#026873"><b>CATEGORY</b></td>
                                          <td width="20%" bgcolor="#026873"><b>NAME</b></td>
                                          <td width="10%" bgcolor="#026873"><b>PRICE</b></td>
                                          <td width="60%" bgcolor="#026873"><b>DESCRIPTION</b></td>
                                      </tr>
                                       <tr style="font-size:10px;">
                                          <td >BUILD OUT</td>
                                          <td >'.$row->nombre.'</td>
                                          <td >'.$row->precio.'</td>
                                          <td >'.$row->desc_buildout.'</td>
                                       </tr>
                              </table>';
                //agregando accesorio al camion

                $html=$html. '<table width="100%" border="0" align="center" cellspacing="0" cellpadding="5" >
                                         <tr>
                                             <td align="left" colspan="7" valign="top" bgcolor="#dda51c" style="background-color:#026873; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#ffffff;"><b>ACCESORIES</b></td>

                                         </tr>
                                         <tr style="color:#FFF;font-size:12px;">
                                             <td bgcolor="#026873" ><b>CATEGORY</b></td>
                                             <td bgcolor="#026873" ><b>APPLIANCE</b></td>
                                             <td bgcolor="#026873" ><b>DETAIL</b></td>
                                              <td bgcolor="#026873" ><b>DESCRIPCION</b></td>
                                             <td bgcolor="#026873"><b>UNIT PRICE</b></td>
                                             <td bgcolor="#026873"><b>QUANTITY</b></td>
                                             <td bgcolor="#026873"><b>TOTAL PRICE</b></td>
                                        </tr>';

                \Illuminate\Support\Facades\DB::beginTransaction();

                $result2 = \Illuminate\Support\Facades\DB::select( DB::raw("
                        SELECT descripcion_details,item_category,item_subcategory,truck_items.item_name,truck_items.price,truck_items.item_category,truck_items.cant 
                        FROM truck_items where id_truck = $id;                        
                        ")
                );

                \Illuminate\Support\Facades\DB::commit();

                $total_impuesto = 0;
                $total_item=0;
                $total_apliance = 0;
                $total_general_apliance=0;
                foreach ($result2 as $row1) {
                    $total_apliance =  ($row1->price * $row1->cant);
                    //$total_apliance= number_format($total_apliance, 2, ',', ' ');
                    $html = $html . "<tr style='font-size:10px;'>
                                        <td>".$row1->item_category."</td>
                                        <td>".$row1->item_name."</td>
                                        <td>".$row1->item_subcategory."</td>   
                                        <td>".$row1->descripcion_details."</td>     
                                        <td>".$row1->price."</td>
                                        <td>".$row1->cant."</td>
                                        <td>".$total_apliance."</td>
                                     </tr>";

                    $total_general_apliance =  $total_apliance + $total_general_apliance;
                }

                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td bgcolor="#026873"><b>'.$row->categoria.':</b></td>
                                <td bgcolor="#026873"><b>'.$row->price_item.'</b></td>
                               </tr>';
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td bgcolor="#026873"><b>Build Out :</b></td>
                                <td bgcolor="#026873"><b>'.$row->precio.'</b></td>
                               </tr>';
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td bgcolor="#026873"><b>Appliances :</b></td>
                                <td bgcolor="#026873"><b>'.number_format($total_general_apliance, 2, '.', ' ').'</b></td>
                               </tr>';
                $subTotal= $row->price_item + $row->precio + $total_general_apliance;
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td bgcolor="#026873"><b>Subtotal quote :</b></td>
                                <td bgcolor="#026873"><b>'.number_format($subTotal, 2, '.', ' ').'</b></td>
                               </tr>';
                $totalTax= $row->truck_tax + $row->tax_item;
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td></td>
                                <td bgcolor="#026873"><b>Total Taxes :</b></td>
                                <td bgcolor="#026873"><b>'.number_format($totalTax, 2, '.', ' ').'</b></td>
                               </tr>';
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td bgcolor="#026873"><b>Discount:</b></td>
                                <td bgcolor="#026873"><b>'.number_format($row->discount, 2, '.', ' ').'</b></td>
                               </tr>';
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td bgcolor="#026873"><b>Registration:</b></td>
                                <td bgcolor="#026873"><b>'.$row->registration.'</b></td>
                               </tr>';
                //calcular el total
                $total= $row->registration + $row->price_item + $row->precio + $total_general_apliance + $row->truck_tax + $row->tax_item - $row->discount;
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td bgcolor="#026873"><b>Total quote:</b></td>
                                <td bgcolor="#026873"><b>'.number_format($total, 2, '.', ' ').'</b></td>
                               </tr>';
                $html = $html . " </table> "   ;
                //AGREGAR LA NOTA DE Q LA QUOTIZACION ES VALIDA SOLO POR 30 DIAS PROXIMOS
                $html = $html . '<table width="100%" border="0" align="center" cellspacing="0" cellpadding="5" >
                              <tr style="color:#00000">
                              <td >Note: This quote is valid for the next 30 days</td>
                              </tr> </table></div>' ;

                //return $html;
            }

            $subject = trans('crudbooster.quote_data');

            $toTemp = explode(", ", $to);
            $emails = [];
            $emailsFailed = [];
            foreach ($toTemp as $item) {
                //validamos antes de incluir los emails
                if ($this->validarEmail($item)) {
                    $emails[] = $item;
                } else {
                    $emailsFailed[] = $item;
                }
            }

            if(count($emails) != 0) {
                //Send Email with notification End Step
                \Mail::send("crudbooster::emails.blank", ['content' => $html], function ($message) use ($to, $subject, $emails) {
                    $message->priority(1);
                    $message->to($emails);

                    $message->subject($subject);
                });

                $emailTemp = '';
                foreach ($emails as $item) {
                    if ($emailTemp != '') {
                        $emailTemp = $emailTemp.', '.$item;
                    } else {
                        $emailTemp = $item;
                    }
                }

                $emailFailedTemp = '';
                foreach ($emailsFailed as $item) {
                    if ($emailFailedTemp != '') {
                        $emailFailedTemp = $emailFailedTemp.', '.$item;
                    } else {
                        $emailFailedTemp = $item;
                    }
                }

                $message_1 = trans('crudbooster.messageLog_1');
                $message_2 = trans('crudbooster.messageLog_2');
                $message_3 = trans('crudbooster.failed_emails');

                if (count($emailsFailed) != 0) {
                    CRUDBooster::insertLog($message_1.$row->truck_name.$message_2.$emailTemp.'. ('.$message_3.$emailFailedTemp.')');
                } else {
                    CRUDBooster::insertLog($message_1.$row->truck_name.$message_2.$emailTemp);
                }

                CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('crudbooster.email_send_text'), "success");

            } else {
                $emailTemp = '';
                foreach ($emails as $item) {
                    if ($emailTemp != '') {
                        $emailTemp = $emailTemp.', '.$item;
                    } else {
                        $emailTemp = $item;
                    }
                }

                $emailFailedTemp = '';
                foreach ($emailsFailed as $item) {
                    if ($emailFailedTemp != '') {
                        $emailFailedTemp = $emailFailedTemp.', '.$item;
                    } else {
                        $emailFailedTemp = $item;
                    }
                }

                $message_1 = trans('crudbooster.messageLog_1');
                $message_2 = trans('crudbooster.messageLog_2');
                $message_3 = trans('crudbooster.failed_emails');

                if (count($emailsFailed) != 0) {
                    CRUDBooster::insertLog($message_1.$row->truck_name.$message_2.$emailTemp.'. ('.$message_3.$emailFailedTemp.')');
                } else {
                    CRUDBooster::insertLog($message_1.$row->truck_name.$message_2.$emailTemp);
                }

                CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('crudbooster.email_send_text_error'), "warning");
            }


        }


        //Función para la validación de los correos electrónicos (emails)
        public function validarEmail($email) {
            if (preg_match(
                '/[\w-\.]{1,}@([\w-]{2,}\.)*([\w-]{1,}\.)[\w-]{1,}/',
                $email)) {
                return true;
            }
            return false;
        }


        public function getSendquote($id)
        {
            $to =  DB::table('user_trucks')
                ->join('account', 'account.id', '=', 'user_trucks.id_account')
                ->where('user_trucks.id', $id)->first();

            $to =strtolower($to->email);

            \Illuminate\Support\Facades\DB::beginTransaction();

            $result = \Illuminate\Support\Facades\DB::select(DB::raw("
                        SELECT truck_extras_price,
                            account.email,
                            account.`name`,
                             account.lastname,
                            account.state,
                            account.telephone,
                            user_trucks.truck_name,
                            user_trucks.truck_date_created,
                            user_trucks.downpayment,
                            user_trucks.truck_budget,
                            user_trucks.financing,
                            user_trucks.build_out,
                            user_trucks.time,
                            buildout.nombre,
                            CASE 
                                WHEN ISNULL(precio_builout) THEN buildout.precio
                                ELSE precio_builout
                                END
                                AS precio,
                            type.type as categoria,
                            id_account,
                            user_trucks.registration,
                            user_trucks.truck_aprox_price,
                            user_trucks.truck_tax,
                            user_trucks.id,
                            user_trucks.tax_item,
                            type.type AS categoria,
                            estado.estado,
                            size.size,
                            CASE 
                                WHEN user_trucks.price_item = 0 THEN user_trucks.truck_price_range
                                ELSE user_trucks.price_item
                                END
                                AS price_item,
                            user_trucks.discount,
                             CASE 
                                WHEN ISNULL(user_trucks.desc_buildout) THEN buildout.descripcion
                                ELSE user_trucks.desc_buildout
                                END
                                AS desc_buildout
                            FROM
                            account
                            INNER JOIN user_trucks ON user_trucks.id_account = account.id
                            LEFT JOIN buildout ON user_trucks.build_out = buildout.id
                            LEFT JOIN type ON type.id = user_trucks.interesting
                            LEFT JOIN estado ON user_trucks.id_type = estado.id
                            LEFT JOIN size ON user_trucks.id_size = size.id where user_trucks.id=$id
                        ;
                        ")
            );

            \Illuminate\Support\Facades\DB::commit();

            foreach ($result as $row) {
                //estructurando el hml de cada usuario
                $fechaneed=$row->truck_date_created;
                $fecha=date("m-d-Y",strtotime($fechaneed));
                $fechaneed1=$row->time;
                $fecha1=date("m-d-Y",strtotime($fechaneed1));

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
                                                   <div style="font-size:10px;" valign="middle" align="left">
                                                       <b>CLIENT</b>
                                                       <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->name." ".$row->lastname.'</p>
                                                       <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->state.'</p>
                                                       <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->telephone.'</p>
                                                       <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->email.'</p>
                                                     
                                                    </div>
                                            </td>
                                            <td>
                                                <div style="font-size:14px;" valign="middle" align="right"><b>Quote name: '.$row->truck_name.'</b></div>
                                                <div style="font-size:14px; padding-top: 10px" valign="middle" align="right"><b>Date: '.$fecha1.'</b></div>
                                            </td>
                                        </tr>
                                      
                                         <tr>
                                               
                                              
                                        </tr>
                              </table> ';

                //Agregando Financiamiento.user_trucks.financing,
                $html =  $html.  '<table width="100%" border="0" align="center" cellspacing="0" cellpadding="4">
                                     <tr>
                                       <td align="left" valign="top" bgcolor="#dda51c" style="background-color:#026873; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#ffffff;"><b>FINANCING</b></td>
                                     </tr>
                                     <tr>
                                         <td align="left"  style="font-size:10px;">
                                             <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr style="font-size:10px;">
                                                   <td align="left"><p><b>Need Financing: </b>'.$row->financing.' </p></td>
                                                   <td align="left"><p><b>How soon you need it?: </b> '.$fecha1.' </p></td>
                                                   <td align="left"><p><b>Budget: </b>'.$row->truck_budget.'</p></td>
                                                   <td align="left" ><p><b>Downpayment: </b> '.$row->downpayment.' </p></td>
                                                  
                                                </tr>
                                                
                                                                                                 
                                               </table>

                                         </td>
                                     </tr>
                                 </table>';
                //Agregando los bluid_out y del precio del camion
                $html = $html .  '        
                              <table width="100%" border="0" align="center" cellspacing="0" cellpadding="4" >
                                     <tr style="color:#FFF; font-size:12px;">
                                            <td width="10%" bgcolor="#026873"><b>CATEGORY</b></td>
                                            <td width="20%" bgcolor="#026873"><b>TYPE</b></td>
                                            <td width="20%" bgcolor="#026873"><b>SIZE</b></td>
                                            <td width="20%" bgcolor="#026873"><b>PRICE</b></td>
                                     </tr>
                                       <tr style="font-size:10px;">
                                          <td >'.$row->categoria.'</td>
                                          <td >'.$row->estado.'</td>
                                          <td >'.$row->size.'</td>
                                          <td >'.$row->price_item.'</td>
                                       </tr>
                              </table>';
                $html = $html .  '<table width="100%" border="0" align="center" cellspacing="0" cellpadding="4" >
                                      <tr>
                                        <td colspan="4" align="left" valign="top" bgcolor="#dda51c" style="background-color:#026873; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#ffffff;"><b>TRUCK SELECTION</b></td>

                                      </tr>
                                      <tr style="color:#FFF;font-size:12px;">
                                          <td width="10%" bgcolor="#026873"><b>CATEGORY</b></td>
                                          <td width="20%" bgcolor="#026873"><b>NAME</b></td>
                                          <td width="10%" bgcolor="#026873"><b>PRICE</b></td>
                                          <td width="60%" bgcolor="#026873"><b>DESCRIPTION</b></td>
                                      </tr>
                                       <tr style="font-size:10px;">
                                          <td >BUILD OUT</td>
                                          <td >'.$row->nombre.'</td>
                                          <td >'.$row->precio.'</td>
                                          <td >'.$row->desc_buildout.'</td>
                                       </tr>
                              </table>';
                //agregando accesorio al camion

                $html=$html. '<table width="100%" border="0" align="center" cellspacing="0" cellpadding="5" >
                                         <tr>
                                             <td align="left" colspan="7" valign="top" bgcolor="#dda51c" style="background-color:#026873; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#ffffff;"><b>ACCESORIES</b></td>

                                         </tr>
                                         <tr style="color:#FFF;font-size:12px;">
                                             <td bgcolor="#026873" ><b>CATEGORY</b></td>
                                             <td bgcolor="#026873" ><b>APPLIANCE</b></td>
                                             <td bgcolor="#026873" ><b>DETAIL</b></td>
                                              <td bgcolor="#026873" ><b>DESCRIPCION</b></td>
                                             <td bgcolor="#026873"><b>UNIT PRICE</b></td>
                                             <td bgcolor="#026873"><b>QUANTITY</b></td>
                                             <td bgcolor="#026873"><b>TOTAL PRICE</b></td>
                                        </tr>';

                \Illuminate\Support\Facades\DB::beginTransaction();

                $result2 = \Illuminate\Support\Facades\DB::select( DB::raw("
                        SELECT descripcion_details,item_category,item_subcategory,truck_items.item_name,truck_items.price,truck_items.item_category,truck_items.cant 
                        FROM truck_items where id_truck = $id;                        
                        ")
                );

                \Illuminate\Support\Facades\DB::commit();

                $total_impuesto = 0;
                $total_item=0;
                $total_apliance = 0;
                $total_general_apliance=0;
                foreach ($result2 as $row1) {
                    $total_apliance =  ($row1->price * $row1->cant);
                    //$total_apliance= number_format($total_apliance, 2, ',', ' ');
                    $html = $html . "<tr style='font-size:10px;'>
                                        <td>".$row1->item_category."</td>
                                        <td>".$row1->item_name."</td>
                                        <td>".$row1->item_subcategory."</td>   
                                        <td>".$row1->descripcion_details."</td>     
                                        <td>".$row1->price."</td>
                                        <td>".$row1->cant."</td>
                                        <td>".$total_apliance."</td>
                                     </tr>";

                    $total_general_apliance =  $total_apliance + $total_general_apliance;
                }

                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td bgcolor="#026873"><b>'.$row->categoria.':</b></td>
                                <td bgcolor="#026873"><b>'.$row->price_item.'</b></td>
                               </tr>';
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td bgcolor="#026873"><b>Build Out :</b></td>
                                <td bgcolor="#026873"><b>'.$row->precio.'</b></td>
                               </tr>';
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td bgcolor="#026873"><b>Appliances :</b></td>
                                <td bgcolor="#026873"><b>'.number_format($total_general_apliance, 2, '.', ' ').'</b></td>
                               </tr>';
                $subTotal= $row->price_item + $row->precio + $total_general_apliance;
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td bgcolor="#026873"><b>Subtotal quote :</b></td>
                                <td bgcolor="#026873"><b>'.number_format($subTotal, 2, '.', ' ').'</b></td>
                               </tr>';
                $totalTax= $row->truck_tax + $row->tax_item;
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td></td>
                                <td bgcolor="#026873"><b>Total Taxes :</b></td>
                                <td bgcolor="#026873"><b>'.number_format($totalTax, 2, '.', ' ').'</b></td>
                               </tr>';
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td bgcolor="#026873"><b>Discount:</b></td>
                                <td bgcolor="#026873"><b>'.number_format($row->discount, 2, '.', ' ').'</b></td>
                               </tr>';
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td bgcolor="#026873"><b>Registration:</b></td>
                                <td bgcolor="#026873"><b>'.$row->registration.'</b></td>
                               </tr>';
                //calcular el total
                $total= $row->registration + $row->price_item + $row->precio + $total_general_apliance + $row->truck_tax + $row->tax_item - $row->discount;
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td bgcolor="#026873"><b>Total quote:</b></td>
                                <td bgcolor="#026873"><b>'.number_format($total, 2, '.', ' ').'</b></td>
                               </tr>';
                $html = $html . " </table> "   ;
                //AGREGAR LA NOTA DE Q LA QUOTIZACION ES VALIDA SOLO POR 30 DIAS PROXIMOS
                $html = $html . '<table width="100%" border="0" align="center" cellspacing="0" cellpadding="5" >
                              <tr style="color:#00000">
                              <td >Note: This quote is valid for the next 30 days</td>
                              </tr> </table></div>' ;

                //return $html;
            }

            $subject = trans('crudbooster.quote_data');

            $toTemp = explode(", ", $to);
            $emails = [];
            $emailsFailed = [];
            foreach ($toTemp as $item) {
                //validamos antes de incluir los emails
                if ($this->validarEmail($item)) {
                    $emails[] = $item;
                } else {
                    $emailsFailed[] = $item;
                }
            }

            if(count($emails) != 0) {
                //Send Email with notification End Step
                \Mail::send("crudbooster::emails.blank", ['content' => $html], function ($message) use ($to, $subject, $emails) {
                    $message->priority(1);
                    $message->to($emails);

                    $message->subject($subject);
                });

                $emailTemp = '';
                foreach ($emails as $item) {
                    if ($emailTemp != '') {
                        $emailTemp = $emailTemp.', '.$item;
                    } else {
                        $emailTemp = $item;
                    }
                }

                $emailFailedTemp = '';
                foreach ($emailsFailed as $item) {
                    if ($emailFailedTemp != '') {
                        $emailFailedTemp = $emailFailedTemp.', '.$item;
                    } else {
                        $emailFailedTemp = $item;
                    }
                }

                $message_1 = trans('crudbooster.messageLog_1');
                $message_2 = trans('crudbooster.messageLog_2');
                $message_3 = trans('crudbooster.failed_emails');

                if (count($emailsFailed) != 0) {
                    CRUDBooster::insertLog($message_1.$row->truck_name.$message_2.$emailTemp.'. ('.$message_3.$emailFailedTemp.')');
                } else {
                    CRUDBooster::insertLog($message_1.$row->truck_name.$message_2.$emailTemp);
                }

                CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('crudbooster.email_send_text'), "success");

            } else {
                CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('crudbooster.email_send_text_error'), "warning");
            }

        }


        //Permite convertir el Lead asociado a una Quote en un Client
        public function getConvertClient($id) {
	        //Obtener el id del lead asociado al Quote
	        $lead_id  = DB::table('user_trucks')->where('id', $id)->first();
            $contact_type_orders  = DB::table('user_trucks')->where('id_account', $lead_id->id_account)->first();

            //Obtener información del Lead asociado al Quote
            $leads = DB::table('account')->where('id', $lead_id->id_account)->first();
            $is_client = $leads->is_client;

            $idClient =  DB::table('clients')
                ->select(\Illuminate\Support\Facades\DB::raw('clients.id as client_id'))
                ->join('account', 'account.email', '=', 'clients.email')
                ->where('account.id', $lead_id->id_account)->first();

            if ($is_client == 1) {
                //Create Client-Quote
                $maxId = DB::table('client_quotes')->select(\Illuminate\Support\Facades\DB::raw('MAX(id) as id'))->first();
                $maxId = $maxId->id + 1;

                //habilitar la client-quote del listado
                $client_quotes = DB::table('client_quotes')
                    ->where('id_client', $idClient->client_id)
                    ->where('id_quote', $id)
                    ->first();

                if($client_quotes == null) {
                    $sumarizedDataClientQuotes = [
                        'id' => $maxId,
                        'id_client' => $idClient->client_id,
                        'date_create' => Carbon::now(config('app.timezone')),
                        'id_quote' => $id,
                        'main' => 1
                    ];

                    DB::table('client_quotes')->insert($sumarizedDataClientQuotes);
                }
                else {
                    $sumarizedDataClientQuotes = [
                        'id' => $maxId,
                        'id_client' => $idClient->client_id,
                        'date_create' => Carbon::now(config('app.timezone')),
                        'id_quote' => $id,
                        'main' => 1
                    ];

                    DB::table('client_quotes')->where('id',$client_quotes->id)->update($sumarizedDataClientQuotes);
                }

                DB::table('user_trucks')->where('id', $id)->update(['is_closed' => 1]);

                //Gestionando las fases
                $phases = DB::table('fases')->where('customers_id', $lead_id->id_account)->where('orders_id', $id)->get();

                if (count($phases) == 0) {
                    $phasesTemplate = DB::table('fases')->where('customers_id', 0)->get();

                    foreach ($phasesTemplate as $phase) {
                        DB::table('fases')->insert([
                            'customers_id'=>$lead_id->id_account,
                            'email'=>$leads->email,
                            'name'=>$phase->name,
                            'fases_type_id'=>$phase->fases_type_id,
                            'orders_id'=>$id,
                            'cms_users_id'=>$leads->id_usuario,
                        ]);
                    }

                    //Enviamos correo al responsable de la fase creada
                    if ($leads->id_usuario != null) {
                       $usuario_email  = DB::table('cms_users')->where('id', $leads->id_usuario)->first();
                       $to[] = $usuario_email->email;

                        $subject = trans("crudbooster.text_steps_first");

                        $html = "<p>".trans("crudbooster.text_dear")." $usuario_email->fullname, ".trans("crudbooster.text_steps_first")."</p>
                                   <a href='http://ezcrm.us/crm/orders/detail/$id'>".trans("crudbooster.text_details_here")."</a>
                            <p>".trans("crudbooster.phase_sign")." Chef Units</p>";

                        //Send Email with notification End Step
                        \Mail::send("crudbooster::emails.blank",['content'=>$html],function($message) use ($to,$subject) {
                            $message->priority(1);
                            $message->to($to);

                            $message->subject($subject);
                        });
                    }

                }

                //Generar payload
                \Illuminate\Support\Facades\DB::beginTransaction();
                $paid_vendor = \Illuminate\Support\Facades\DB::select( DB::raw("
                        SELECT user_trucks.id,(select Sum(price*cant) from truck_items where id_truck =  user_trucks.id and appliance = 1) as appliance,
                        CASE 
                        WHEN user_trucks.price_item = 0 THEN user_trucks.truck_price_range
                        ELSE user_trucks.price_item
                        END
                        AS price_item,
                         user_trucks.tax_item,
                         user_trucks.truck_tax, 
                         user_trucks.registration,
                         user_trucks.discount,       
                         CASE 
                        WHEN ISNULL(precio_builout) THEN buildout.precio
                        ELSE precio_builout
                        END
                        AS precio,id_usuario from user_trucks   
                        left join buildout on user_trucks.build_out = buildout.id   
                        INNER JOIN account ON account.id = user_trucks.id_account
                        where user_trucks.id = $id
                        ;
                    ")
                );
                \Illuminate\Support\Facades\DB::commit();

                $total =number_format($paid_vendor[0]->registration + $paid_vendor[0]->price_item + $paid_vendor[0]->tax_item + $paid_vendor[0]->precio + $paid_vendor[0]->appliance + $paid_vendor[0]->truck_tax - $paid_vendor[0]->discount , 2, '.', ' ');

                //add the commision each quote the quote select
                $comision = 0;
                if($total > 0 && $total < 50000) { $comision = 3; }
                elseif($total > 51000 && $total < 100000){ $comision = 5; return ; }
                elseif($total > 101000){ $comision = 6; return; }
                //$total= Reple
                $calculo = ($comision/100) * $total;

                $sumarizedDataVendor = [
                    'id_user' => $paid_vendor[0]->id_usuario,
                    'total' => $total,
                    'comision' => $comision,
                    'pago' => $calculo,
                    'mes' => date("F"),
                ];
                DB::table('paid_vendor')->insert($sumarizedDataVendor);

                //Mensaje de confirmación de template activada
                CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"Changed Quote´s Status","success");

            } else { //Si no es cliente
                $exist = DB::table('clients')->where('email', $leads->email)->first();

                if(count($exist) == 0) {
                    $maxIdC = DB::table('clients')->select(\Illuminate\Support\Facades\DB::raw('MAX(id) as id'))->first();
                    $maxIdC = $maxIdC->id + 1;

                    //Si no es cliente lo inserto en la tabla de clientes
                    $sumarizedDataClients = [
                        'id' => $maxIdC,
                        'email' => $leads->email,
                        'state' => $leads->state,
                        'city' => $leads->city,
                        'date_created' => Carbon::now(config('app.timezone')),
                        'telephone' => $leads->telephone,
                        'interested_in' => $lead_id->interesting,
                        'need_financing' => $lead_id->financing,
                        'down_payment' => $lead_id->downpayment,
                        'name' => $leads->name,
                        'description' => $lead_id->description,
                        'from_where' => $lead_id->from_where,
                        'lastname' => $leads->lastname,
                        'zip_code' => $leads->zip_code,
                        'street' => $leads->street,
                        'estado' => $leads->estado,
                        'id_usuario' => $leads->id_usuario
                    ];
                    DB::table('clients')->insert($sumarizedDataClients);

                    $clientContent = DB::table('clients')->where('id', $maxIdC)->first();
                    $to[] = $clientContent->email;
                    $subject = trans("crudbooster.updated_information");

                    /*$html = "<p>".trans("crudbooster.text_dear")." $clientContent->name $clientContent->lastname, ".trans("crudbooster.text_client_1")."</p>
                            <p>".trans("crudbooster.phase_sign")." Chef Units</p>
                    ";

                    //Send Email with notification End Step
                    \Mail::send("crudbooster::emails.blank",['content'=>$html],function($message) use ($to,$subject) {
                        $message->priority(1);
                        $message->to($to);

                        $message->subject($subject);
                    });*/

                    //Convertir Lead asociado al Quote en Client
                    DB::table('account')->where('id', $lead_id->id_account)->update(['is_client' => 1]);
                    DB::table('user_trucks')->where('id', $id)->update(['is_closed' => 1]);

                    //Create Client-Quote
                    $maxId = DB::table('client_quotes')->select(\Illuminate\Support\Facades\DB::raw('MAX(id) as id'))->first();
                    $maxId = $maxId->id + 1;

                    $sumarizedDataClientQuotes = [
                        'id' => $maxId,
                        'id_client' => $maxIdC,
                        'date_create' => Carbon::now(config('app.timezone')),
                        'id_quote' => $id,
                        'main' => 1
                    ];
                    DB::table('client_quotes')->insert($sumarizedDataClientQuotes);

                    $idClient =  DB::table('clients')
                        ->select(\Illuminate\Support\Facades\DB::raw('clients.id as client_id'))
                        ->join('account', 'account.email', '=', 'clients.email')
                        ->where('account.id', $lead_id->id_account)->first();

                } else { // Si no esta en el listado de clients
                    //Create Client-Quote
                    $maxId = DB::table('client_quotes')->select(\Illuminate\Support\Facades\DB::raw('MAX(id) as id'))->first();
                    $maxId = $maxId->id + 1;
                    DB::table('user_trucks')->where('id', $id)->update(['is_closed' => 1]);

                    $sumarizedDataClientQuotes = [
                        'id' => $maxId,
                        'id_client' => $exist->id,
                        'date_create' => Carbon::now(config('app.timezone')),
                        'id_quote' => $id,
                        'main' => 1
                    ];

                    DB::table('client_quotes')->insert($sumarizedDataClientQuotes);
                }

                //Gestionando las fases
                $phases = DB::table('fases')->where('customers_id', $lead_id->id_account)->where('orders_id', $id)->get();

                if (count($phases) == 0) {
                    $phasesTemplate = DB::table('fases')->where('customers_id', 0)->get();


                    $user_email = DB::table('cms_users')->where('id',$leads->id_usuario)->first();

                    foreach ($phasesTemplate as $phase) {
                        //Establecemos la primera fase por defecto
                        if ($phase->fases_type_id == 1) {

                            $faseId = DB::table('fases')->insertGetId([
                                'customers_id'=>$lead_id->id_account,
                                'email'=>$user_email->email, //email del vendedor
                                'assigned_to'=>$phase->assigned_to,
                                'datetime'=>Carbon::now(config('app.timezone')),
                                'name'=>$phase->name,
                                'notes'=>'Quote Closed',
                                'fases_type_id'=>$phase->fases_type_id,
                                'orders_id'=>$id,
                                'cms_users_id'=>$leads->id_usuario,
                            ]);

                            //Por defecto asignamos la primera fase a la quote
                            DB::table('user_trucks')->where('id', $id)->update(['fases_id' => $faseId]);

                            //Actualizamos la tabla de proyectos
                            $proyect = DB::table('proyects')->where('orders_id', $id)->first();
                            if(count($proyect) == 0) {
                                $sumarizedDataProyect = [
                                    'name' => $lead_id->truck_name,
                                    'customers_id' => $lead_id->id_account,
                                    'interesting' => $lead_id->interesting,
                                    'fases_type_id' => $phase->fases_type_id,
                                    'fases_id' => $faseId,
                                    'datetime' => Carbon::now(config('app.timezone')),
                                    'cms_users_id' => $leads->id_usuario,
                                    'orders_id' => $id,
                                ];
                                DB::table('proyects')->insert($sumarizedDataProyect);
                            } else {
                                $sumarizedDataProyect = [
                                    'name' => $lead_id->truck_name,
                                    'customers_id' => $lead_id->id_account,
                                    'interesting' => $lead_id->interesting,
                                    'fases_type_id' => $phase->fases_type_id,
                                    'fases_id' => $faseId,
                                    'datetime' => Carbon::now(config('app.timezone')),
                                    'cms_users_id' => $lead_id->id_usuario,
                                ];
                                DB::table('proyects')->where('orders_id', $id)->update($sumarizedDataProyect);
                            }

                        } else {
                            //Obtener los emails a los que se enviaría por cada etapa
                            $assigned_to_email = DB::table('project_accounts')->where('id',1)->first();
                            $email_temp = $user_email->email; //email del vendedor

                            if($phase->assigned_to == 'economy') {
                                $email_temp = $assigned_to_email->economy;
                            }
                            elseif($phase->assigned_to == 'design') {
                                $email_temp = $assigned_to_email->design;
                            }
                            elseif($phase->assigned_to == 'sales') {
                                $email_temp = $assigned_to_email->sales;
                            }
                            elseif($phase->assigned_to == 'production_manager') {
                                $email_temp = $assigned_to_email->production_manager;
                            }

                            DB::table('fases')->insert([
                                'customers_id'=>$lead_id->id_account,
                                'email'=>$email_temp,
                                'assigned_to'=>$phase->assigned_to,
                                'name'=>$phase->name,
                                'fases_type_id'=>$phase->fases_type_id,
                                'orders_id'=>$id,
                                'cms_users_id'=>$leads->id_usuario,
                            ]);
                        }
                    }

                    //Enviamos correo al responsable de la fase creada
                    if ($leads->id_usuario != null) {
                        $quote = DB::table('user_trucks')->where('id',$id)->first();
                        $account = DB::table('account')->where('id',$quote->id_account)->first();
                        $usuario_email  = DB::table('cms_users')->where('id', $account->id_usuario)->first();

                        //$to[] = $usuario_email->email;
                        $to_seller[] = $usuario_email->email;

                        $subject = trans("crudbooster.text_steps_first");

                        $html = "<p>".trans("crudbooster.text_dear")." $usuario_email->fullname, ".trans("crudbooster.text_steps_first")."</p>
                                   <a href='http://ezcrm.us/crm/orders/detail/$id'>".trans("crudbooster.text_details_here")."</a>
                            <p>".trans("crudbooster.phase_sign")." Chef Units</p>";

                        //Send Email with notification End Step
                        \Mail::send("crudbooster::emails.blank",['content'=>$html],function($message) use ($to_seller,$subject) {
                            $message->priority(1);
                            $message->to($to_seller);

                            $message->subject($subject);
                        });

                        //Adicionar "Recent Activity" del envío de Email
                        DB::table('fases_activity')->insert([
                            'fases_id'=>$faseId,
                            'description'=>'A notification email was sent to: '.$to_seller[0],
                            'orders_id'=>$id,
                            'created_at'=>Carbon::now(config('app.timezone'))->toDateTimeString(),
                        ]);
                    }

                }

                //Mensaje de confirmación de template activada
                //CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"The Lead ".$leads->name." is convert in Client success!","success");
            }

            $this->getDetailClientAdvanced($idClient->client_id, $id);
        }

        public function getDetailClientAdvanced($id, $id_quote) {
            //Create an Auth
            if(!CRUDBooster::isRead() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {
                CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
            }

            $data = [];
            $data['page_title'] = 'Client Profile';
            $data['id'] = $id;

            $data['lead'] = DB::table('account')
                ->where('id',$id)->first();

            $data['assign_to'] = DB::table('cms_users')->where('id',$data['lead']->id_usuario)->first();
            $data['contact_type'] = DB::table('customer_type')->where('id',$data['lead']->estado)->first();
            $data['notes'] = DB::table('eazy_notes')->where('customers_id', $id)->where('deleted_at', null)->get();

            $data['tasks'] = DB::table('eazy_tasks')
                ->select(DB::raw('eazy_tasks.name'), 'eazy_task_type.name as task_type_name', 'eazy_tasks.description', 'eazy_tasks.created_at', 'eazy_tasks.date', 'eazy_tasks.id')
                ->join('eazy_task_type', 'eazy_task_type.id', '=', 'eazy_tasks.task_type_id')
                ->where('customers_id', $id)->get();

            $data['client'] =  DB::table('user_trucks')
                ->join('account', 'account.id', '=', 'user_trucks.id_account')
                ->where('user_trucks.id_account', $id)->first();

            $data['quotes_closed'] = DB::table('user_trucks')->where('id_account', $id)->where('is_closed', 1)->where('is_invoice', 0)->get()->toArray();
            $data['quotes_opened'] = DB::table('user_trucks')->where('id_account', $id)->where('is_closed', -1)->where('is_invoice', 0)->get()->toArray();

            //Please use cbView method instead view method from laravel
            CRUDBooster::redirect(CRUDBooster::adminPath("orders/detail/$id_quote"),trans("crudbooster.text_change_fases"));
            //CRUDBooster::redirect(CRUDBooster::adminPath("customers25/detail/$id"),trans("crudbooster.text_change_quotes"));

            //$this->cbView('clients.perfil',$data);
        }

        public function getDetailClient($id) {
            //Create an Auth
            if(!CRUDBooster::isRead() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {
                CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
            }

            $quote  = DB::table('user_trucks')->where('id', $id)->first();
            $phases = DB::table('fases')->where('customers_id', $quote->id_account)->where('orders_id', $id)->get();

            if (count($phases) == 0) {
                $phasesTemplate = DB::table('fases')->where('customers_id', 0)->get();

                foreach ($phasesTemplate as $phase) {
                    DB::table('fases')->insert([
                        'customers_id'=>$quote->id_account,
                        'email'=>$quote->email,
                        'name'=>$phase->name,
                        'fases_type_id'=>$phase->fases_type_id,
                        'orders_id'=>$id,
                    ]);
                }
            }


            $data = [];
            $data['page_title'] = 'Client Profile';
            $data['id'] = $id;
            $data['row'] = DB::table('campaigns')->where('id',$id)->first();

            $data['lead'] = DB::table('customers')
                ->where('id',$id)->first();

            $data['assign_to'] = DB::table('cms_users')->where('id',$data['lead']->cms_users_id)->first();
            $data['contact_type'] = DB::table('customer_type')->where('id',$data['lead']->customer_type_id)->first();
            $data['notes'] = DB::table('eazy_notes')->where('customers_id', $id)->where('deleted_at', null)->get();

            $data['tasks'] = DB::table('eazy_tasks')
                ->select(DB::raw('eazy_tasks.name'), 'eazy_task_type.name as task_type_name', 'eazy_tasks.description', 'eazy_tasks.created_at', 'eazy_tasks.date', 'eazy_tasks.id')
                ->join('eazy_task_type', 'eazy_task_type.id', '=', 'eazy_tasks.task_type_id')
                ->where('customers_id', $id)->get();

            $data['client'] =  DB::table('orders')
                ->join('customers', 'customers.id', '=', 'orders.customers_id')
                ->where('customers_id', $id)->first();

            $data['phases1'] = DB::table('fases')->where('customers_id', $id)->where('fases_type_id', 1)->first();
            $data['phases2'] = DB::table('fases')->where('customers_id', $id)->where('fases_type_id', 2)->first();
            $data['phases3'] = DB::table('fases')->where('customers_id', $id)->where('fases_type_id', 3)->first();
            $data['phases4'] = DB::table('fases')->where('customers_id', $id)->where('fases_type_id', 4)->first();
            $data['phases5'] = DB::table('fases')->where('customers_id', $id)->where('fases_type_id', 5)->first();

            $data['quotes_closed'] = DB::table('orders')->where('customers_id', $id)->where('is_closed', 1)->where('is_invoice', 0)->get()->toArray();
            $data['quotes_opened'] = DB::table('orders')->where('customers_id', $id)->where('is_closed', 0)->where('is_invoice', 0)->get()->toArray();

            //Please use cbView method instead view method from laravel
            $this->cbView('clients.perfil',$data);
        }

        public function getDetail($id) {
            //Create an Auth
            if(!CRUDBooster::isRead() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {
                CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
            }

            $data = [];
            $data['page_title'] = 'Quote Information';
            $data['row'] = DB::table('user_trucks')->where('id',$id)->first();
            $data['users'] = DB::table('cms_users')->get();
            $data['client'] = DB::table('account')->where('id',$data['row']->id_account)->first();
            $data['id'] = $id;

            $data['steps'] = DB::table('fases')->where('orders_id', $id)->orderby('id', 'asc')->get();

            $stepActual = 0;
            $stepActualName = '';
            foreach ($data['steps'] as $item) {
                if(empty($item->name) || empty($item->notes) || empty($item->email) || empty($item->datetime) || empty($item->cms_users_id)) {
                    $stepActual = $item->fases_type_id;
                    $stepActualName = $item->name;
                    break;
                }
            }

            $data['quote'] = DB::table('user_trucks')->where('id',$id)->first();
            $data['fases_activity'] = DB::table('fases_activity')->where('orders_id', $id)->orderby('created_at','desc')->get();

            $data['stepActual'] = $stepActual;
            $data['stepActualName'] = $stepActualName;

            //Please use cbView method instead view method from laravel
            $this->cbView('quotes.perfil',$data);


        }

        //public function getChangeQuotes($id, $close = false) {
        public function getChangeQuotes($id) {
            $quote = DB::table('user_trucks')->where('id', $id)->first();
            $contact_type_orders  = DB::table('user_trucks')->where('id_account', $quote->id_account)->first();

            //Obtener información del Lead asociado al Quote
            $leads = DB::table('account')->where('id', $quote->id_account)->first();
            $is_client = $leads->is_client;

            $idClient =  DB::table('clients')
                ->select(\Illuminate\Support\Facades\DB::raw('clients.id as client_id'))
                ->join('account', 'account.email', '=', 'clients.email')
                ->where('account.id', $quote->id_account)->first();

            //deshabilitar la client-quote del listado
            $client_quotes = DB::table('client_quotes')
                ->where('id_client', $idClient->client_id)
                ->where('id_quote', $id)
                ->first();

            DB::table('client_quotes')->where('id', $client_quotes->id)->update(['main' => 0]);

            CRUDBooster::redirect(CRUDBooster::adminPath("customers25/detail/$client_quotes->id_client"),trans("crudbooster.text_change_quotes"));
        }

        public function getAppliancedelete($valor) {
            DB::table('truck_items')->where('id', $valor)->delete();
	        return true;
        }

        public function getAddQuote($id) {
            $customer = DB::table('account')->where('id', $id)->first();

            $maxId = DB::table('user_trucks')->select(\Illuminate\Support\Facades\DB::raw('MAX(id) as id'))->first();
            $maxId = $maxId->id + 1;

            //Create Quote
            $sumarizedData = [
                'id' => $maxId,
                'truck_date_created' => Carbon::now(config('app.timezone')),
                'id_account' => $customer->id,
                'from_where' => 2,
                'interesting' => NULL,
                'is_active' => 1
            ];

            DB::table('user_trucks')->insert($sumarizedData);

            //Open Edit Quote
            CRUDBooster::redirect(CRUDBooster::adminPath('orders/edit/'.$maxId),trans("crudbooster.text_open_edit_quote"));

        }

        //Permite convertir el Lead asociado a una Quote en un Client
        public function getCreatedInvoice($id) {

            $orders = DB::table('orders')->where('id',$id)->first();
            $client = DB::table('customers')->where('id',$orders->customers_id)->first();
            $orders_detail = DB::table('orders_detail')->where('orders_id',$id)->get();

            /*$appliances =  DB::table('appliances')
                ->join('appliances_inside', 'appliances_inside.id', '=', 'appliances.appliances_inside_id')
                ->where('orders_id', 1393)->get();*/

            $dateActual = Carbon::now(config('app.timezone'));

            $data = [];
            $data['invoice'] = DB::table('orders')
                ->join('customers', 'customers.id', '=', 'orders.customers_id')
                ->where('orders.id', $id)->first();

            $data['settings'] = DB::table('settings')->first();
            $data['customer_information'] = $client;
            $data['order_id'] = $id;
            $data['dateActual'] = $dateActual;
            /*$data['appliances'] = $appliances;*/
            $totalFinal = 0;

            foreach ($orders_detail as $order_item) {
                $products = DB::table('products')->where('id',$order_item->products_id)->first();

                $product = [];
                $product['name'] = $products->name;
                $product['description'] = $products->description;
                $product['price'] = $products->sell_price;
                $product['quantity'] = $order_item->quantity;
                $product['total'] = $products->sell_price * $order_item->quantity;
                $data['orders_detail'][] = $product;
                $totalFinal += $products->sell_price * $order_item->quantity;
            }

            /*foreach ($appliances as $appliance_item) {
                $totalFinal += $appliance_item->price * $appliance_item->quantity;
            }*/

            $data['totalFinal'] = $totalFinal;

            //$this->cbView('clients.invoice-print',$data);

            $this->cbView('clients.invoice',$data);
        }

        public function getCreateInvoice($id) {

            $orders = DB::table('user_trucks')->where('id',$id)->first();
            $orders_detail = DB::table('truck_items')->where('id_truck',$id)->get();

            $customer =  DB::table('account')->where('id', $orders->id_account)->first();
            $setting  =  DB::table('settings')->where('id', 1)->first();
            $state    =  DB::table('states')->where('abbreviation', $customer->state)->first();

            $invoiceSumarizedData = [
                'contact_name' => $customer->name.' '.$customer->lastname,
                'invoice_date' => Carbon::now(config('app.timezone')),
                'owner' => $setting->name,
                'state_client' => $customer->state,
                'id_user' => $customer->id_usuario,
                'street' => $customer->address,
                'city' => $customer->city,
                'tax' => $orders->truck_tax + $orders->tax_item,
                'discount' => $orders->discount,
                'bill_street' => $customer->address,
                'bill_name' => $customer->name.' '.$customer->lastname,
                'bill_city' => $customer->city,
                'bill_state' => $customer->state,
                'mail' => $customer->email,
                'address_client' => $customer->address,
                'address_bill' => $customer->address
            ];

            $lastId = DB::table('invoice')->insertGetId($invoiceSumarizedData);
            DB::table('account')->where('id', $customer->id)->update(['is_client' => 1]);

            $product_type =  DB::table('products_type')->where('id', $orders->interesting)->first();
            $state =  DB::table('estado')->where('id', $orders->id_type)->first();
            $size =  DB::table('sizes')->where('id', $orders->id_size)->first();
            $product =  DB::table('products')->where('id', $orders->build_out)->first();

            if (!empty($orders->registration)) {
                $detailSumarizedDataRegistration = [
                    'id_invoice' => $lastId,
                    'product' => 'Registration',
                    'descripcion' => 'Vehicle Registration',
                    'price' => $orders->registration,
                    'cant' => 1
                ];
                DB::table('invoice_items')->insert($detailSumarizedDataRegistration);
            }

            $detailSumarizedData = [
                'id_invoice' => $lastId,
                'product' => $product_type->name,
                'descripcion' => 'TYPE: '.$state->estado.' SIZE: '.$size->name,
                'price' => $orders->price_item,
                'cant' => 1
            ];
            DB::table('invoice_items')->insert($detailSumarizedData);

            $detailBuildoutSumarizedData = [
                'id_invoice' => $lastId,
                'product' => $product->name,
                'descripcion' => $product->description,
                'price' => $product->sell_price,
                'cant' => 1
            ];
            DB::table('invoice_items')->insert($detailBuildoutSumarizedData);

            foreach ($orders_detail as $items) {
                $detailApplianceSumarizedData = [
                    'id_invoice' => $lastId,
                    'product' => $items->item_category.'-'.$items->item_name.'-'.$items->item_subcategory,
                    'descripcion' => $items->descripcion_details,
                    'price' => $items->price,
                    'cant' => $items->cant
                ];
                DB::table('invoice_items')->insert($detailApplianceSumarizedData);
            }

            CRUDBooster::redirect(CRUDBooster::adminPath("invoice"),trans("crudbooster.text_invoice_added"));
        }

        public function getEdit($id) {
            //Create an Auth
            if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {
                CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.text_open_edit_quote"));
            }

            $data = [];
            $data['page_title'] = 'Editing the Quote';
            $data['id'] = $id;
            $data['products_type'] = DB::table('type')->get();

            $data['customer'] = DB::table('user_trucks')
                ->join('account', 'account.id', '=', 'user_trucks.id_account')
                ->where('user_trucks.id',$id)
                ->get();

            $data['account'] = $data['customer'][0]->id_account;
            $data['orders'] = DB::table('user_trucks')->where('user_trucks.id',$id)->first();
            $data['date_limit'] = $data['orders']->time;
            $data['date_limit'] = explode("-", $data['date_limit']);
            $data['date_limit'] = $data['date_limit'][1].'/'.$data['date_limit'][2].'/'.$data['date_limit'][0];

            if($data['date_limit'] == '//') {
                $data['date_limit'] = '';
            }

            $data['state'] = DB::table('estado')->where('id', $data['orders']->id_type)->first();
            $data['state_list'] = DB::table('estado')->get();

            $data['states'] = '';
            if(!empty($data['customer'][0])) {
                $data['states'] = DB::table('states')->where('abbreviation', $data['customer'][0]->state)->first();
            }

            $data['states_list'] = DB::table('states')->get();
            $data['interested'] = DB::table('type')->where('id', $data['orders']->interesting)->first();
            $data['size'] = DB::table('size')->where('id', $data['orders']->id_size)->first();
            $data['size_list'] = DB::table('size')->get();

            $data['buildout'] = DB::table('user_trucks')
                ->select(\Illuminate\Support\Facades\DB::raw('buildout.nombre as buildout_name'), 'buildout.id', 'buildout.precio', 'buildout.descripcion')
                ->join('buildout', 'buildout.id', '=', 'user_trucks.build_out')
                ->where('user_trucks.id',$id)
                ->get();

            \Illuminate\Support\Facades\DB::beginTransaction();

            $data['quotes'] = \Illuminate\Support\Facades\DB::select( DB::raw("
                        SELECT truck_extras_price,
                            user_trucks.truck_type,
                            user_trucks.truck_name,
                            user_trucks.truck_aprox_price,
                            user_trucks.truck_budget,
                            user_trucks.state,
                            user_trucks.downpayment,
                            user_trucks.financing,
                            CASE WHEN ISNULL( user_trucks.time) THEN ''
                            ELSE  user_trucks.time
                            END
                            AS time,
                            user_trucks.build_out,
                            user_trucks.registration,
                            user_trucks.from_where,
                            user_trucks.id_size,
                           CASE 
                            WHEN user_trucks.price_item = 0 THEN user_trucks.truck_price_range
                            ELSE user_trucks.price_item
                            END
                            AS price_item,
                             user_trucks.tax_item,
                             user_trucks.truck_tax, 
                             user_trucks.id,
                            account.email,
                            account.id as idaccount,
                            account.state,
                            account.telephone,
                            account.`name`,
                            buildout.nombre,
                            CASE 
                            WHEN ISNULL(precio_builout) THEN buildout.precio
                            ELSE precio_builout
                            END
                            AS precio,
                            user_trucks.interesting,
                            user_trucks.registration,
                            CASE 
                            WHEN user_trucks.price_item = 0 THEN user_trucks.truck_price_range
                            ELSE user_trucks.price_item
                            END
                            AS price_item,
                            account.lastname,
                            user_trucks.discount,
                            user_trucks.description,
                            user_trucks.id_type,
                            CASE 
                            WHEN ISNULL(user_trucks.desc_buildout) THEN buildout.descripcion
                            ELSE user_trucks.desc_buildout
                            END
                            AS desc_buildout,
                            (SELECT sum(truck_items.price * truck_items.cant) * 0.0825   FROM truck_items  WHERE id_truck=user_trucks.id )as taxappliace
                            FROM
                            user_trucks
                            left JOIN account ON account.id = user_trucks.id_account 
                            left join buildout on user_trucks.build_out = buildout.id
                            where user_trucks.id=$id
                        ;
                        ")
            );

            \Illuminate\Support\Facades\DB::commit();

            $data['quotes'] = $data['quotes'][0];

            //Obtiene el listado dinámico de los sizes de la quote
            $data['sizes_list'] = $this->getSizes($data['quotes']->interesting);

            //Obtiene el listado dinámico de los buildout de la quote
            $data['buildout_list'] = $this->getBuildoutQuote($data['quotes']->interesting, $data['quotes']->id_size);

            $data['orders_detail'] = DB::table('truck_items')->where('id_truck',$id)->get();

            //$data['notes'] = DB::table('eazy_notes_quotes')->where('quotes_id', $id)->where('deleted_at', null)->get();

            $data['subcategories'] = DB::table('appliance_inside')
                ->select(\Illuminate\Support\Facades\DB::raw('appliance_inside.name as name'), 'appliance.category as category'
                    , 'appliance.id as id_appliance', 'appliance_inside.id as id_appliance_inside')
                ->join('appliance', 'appliance.id', '=', 'appliance_inside.id_appliance')
                ->where('appliance_inside.id_type',4)
                ->where('appliance_inside.deleted_at', null)
                ->get();

            $this->cbView('quotes.create',$data);
        }

        //Obtener el valor del Registration
        public function getRegistration() {
	        $data = DB::table('settings')->where('id', 1)->first();
	        $data = $data->registration;
            return $data;
        }

        //Obtener la descripción del buildout
        public function getBuildoutdesc(\Illuminate\Http\Request $request) {
	        $data = DB::table('user_trucks')->where('id', $request->get('id'))->get();
            return $data;
        }

        //Obtener el valor del Impuesto de Accesorioss
        public function getTaxaccesories() {
            $data = DB::table('settings')->where('id', 1)->first();
            $data = $data->tax_accesories;
            return $data;
        }

        //Obtener el valor del Impuesto de Buildout
        public function getTaxbuildout() {
            $data = DB::table('settings')->where('id', 1)->first();
            $data = $data->tax_buildout;
            return $data;
        }

        //Obtener el valor del Impuesto de Buildout
        public function getTaxitem() {
            $data = DB::table('settings')->where('id', 1)->first();
            $data = $data->tax_item;
            return $data;
        }

        public function getSteps(\Illuminate\Http\Request $request) {
            $idTemp = $request->get('fase_id');

            $email = $request->get('email');
            $notes = $request->get('notes');
            $assingto = $request->get('assignto');
            $date = Carbon::now(config('app.timezone'));
            $name = $request->get('name');
            $orders_id = $request->get('orders_id');
            $fase_id = $request->get('fase_id');
            $assignto = $request->get('assignto');

            $subject = 'Finished Phase';

            $user = DB::table('cms_users')->where('id', $assignto)->first();
            $quote = DB::table('user_trucks')->where('id', $orders_id)->first();
            $lead = DB::table('account')->where('id', $quote->id_account)->first();

            $to = [];
            $to[] = $email;
            $to[] = $user->email;

            $date_limit = $request->get('date_'.$idTemp);

            //$date_limit = $request->get('date_limit');
            $date_limit = explode("/", $date_limit);

            if(count($date_limit) == 1) {
                $date_limit = $request->get('date_'.$idTemp);
            } else {
                $date_limit = $date_limit[2].'-'.$date_limit[0].'-'.$date_limit[1];
            }

            $date_limit = Carbon::createFromFormat("Y-m-d", $date_limit);
            $fase = DB::table('fases')->where('orders_id', $orders_id)->where('fases_type_id', $fase_id)->first();

            if (!empty($fase)) {
                //Creamos el nuevo proyecto a partir de la Quote creada recientemente
                $proyect = DB::table('proyects')->where('orders_id', $orders_id)->first();
                if(count($proyect) == 0) {
                    $sumarizedDataProyect = [
                        'name' => $quote->truck_name,
                        'customers_id' => $lead->id,
                        'interesting' => $quote->interesting,
                        'fases_type_id' => $fase_id,
                        'fases_id' => $fase->id,
                        'datetime' => $date_limit,
                        'cms_users_id' => $assignto,
                        'orders_id' => $orders_id,
                    ];
                    DB::table('proyects')->insert($sumarizedDataProyect);
                } else {
                    $sumarizedDataProyect = [
                        'name' => $quote->truck_name,
                        'customers_id' => $lead->id,
                        'interesting' => $quote->interesting,
                        'fases_type_id' => $fase_id,
                        'fases_id' => $fase->id,
                        'datetime' => $date_limit,
                        'cms_users_id' => $assignto,
                    ];
                    DB::table('proyects')->where('orders_id', $orders_id)->update($sumarizedDataProyect);
                }

                DB::table('fases')->where('id', $fase->id)->update(['cms_users_id' => $assingto, 'email' => $email, 'name' => $name, 'datetime' => $date, 'notes' => $notes, 'updated_at' => Carbon::now(config('app.timezone'))]);

                $phaseContent = DB::table('fases')->where('id', $fase->id)->first();
                $html = "<p>".trans("crudbooster.text_steps").":</p>
                        <ul>
                            <li>".trans("crudbooster.text_phase_name").": $phaseContent->name</li>
                            <li>".trans("crudbooster.text_notes").": $phaseContent->notes</li>
                            <li>".trans("crudbooster.text_quote_number").":  $phaseContent->orders_id</li>
                        </ul>
                        <p>".trans("crudbooster.phase_sign").", Chef Units</p>
                ";

                //Send Email with notification End Step
                \Mail::send("crudbooster::emails.blank",['content'=>$html],function($message) use ($to,$subject) {
                    $message->priority(1);
                    $message->to($to);

                    $message->subject($subject);
                });
            }
            else {
                $lastId =  DB::table('fases')->insertGetId([
                    'name' => $name,
                    'email' => $email,
                    'datetime' => $date,
                    'fases_type_id' => $fase_id,
                    'orders_id' => $orders_id,
                    'cms_users_id' => $assingto,
                    'notes' => $notes,
                    'created_at' => Carbon::now(config('app.timezone')),
                    'updated_at' => Carbon::now(config('app.timezone'))
                ]);

                //Send Email with notification End Step
                \Mail::send("crudbooster::emails.blank",['content'=>$html],function($message) use ($to,$subject,$template) {
                    $message->priority(1);
                    $message->to($to);

                    if($template->from_email) {
                        $from_name = ($template->from_name)?:CRUDBooster::getSetting('appname');
                        $message->from($template->from_email,$from_name);
                    }

                    if($template->cc_email) {
                        $message->cc($template->cc_email);
                    }

                    $message->subject($subject);
                });
            }

            //Se crea una tarea al responsable de la Quote
            $SumarizedDataTasks = [
                'name' => trans("crudbooster.task_users_name"),
                'date' => Carbon::now(config('app.timezone')),
                'description' => trans("crudbooster.task_users_description"),
                'task_type_id' => 1,
                'cms_users_id' => $assingto,
            ];
            DB::table('eazy_tasks_users')->insert($SumarizedDataTasks);

            CRUDBooster::redirect(CRUDBooster::adminPath("orders/detail/$orders_id"),trans("crudbooster.text_phase_added"));

        }

        public function getEditsave(\Illuminate\Http\Request $request) {
            $date_limit = $request->get('date_limit');
            $date_limit_check = explode("-", $date_limit);

            if (count($date_limit_check) == 1) {
                $date_limit_check = explode("/", $date_limit);
                $date_limit_check = $date_limit_check[2].'-'.$date_limit_check[0].'-'.$date_limit_check[1];
            }
            else {
                $date_limit_check = $date_limit_check[0].'-'.$date_limit_check[1].'-'.$date_limit_check[2];
            }

            $date_limit = Carbon::createFromFormat("Y-m-d", $date_limit_check);
            $orders_id = $request->get('quote_id');

	        $cant = 0;
            $quote = DB::table('user_trucks')->where('id', $orders_id)->first();

            //Si se ha creado por primera vez la Quote entonces contamos una nueva quote en el Lead
            if($quote->is_active == 1) {
                $leads = DB::table('user_trucks')
                    ->join('account', 'account.id', '=', 'user_trucks.id_account')
                    ->where('user_trucks.id', $orders_id)->first();

                $quotes = DB::table('account')->where('id', $leads->id_account)->first();
                $quotes = $quotes->quotes;
                $quotes += 1;
                DB::table('account')->where('id', $leads->id_account)->update(['quotes' => $quotes]);
            }

            $customer = DB::table('account')->where('id', $quote->id_account)->first();

            if ($request->get('check_item') == 'on') {
                $starting_with = $request->get('starting');
            }
            else {
                $starting_with = 0;
            }

            $lead_name = $request->get('name');
            $lead_lastname = $request->get('lastname');
            $lead_email = $request->get('email');
            $lead_state = $request->get('state');
            $lead_telephone = $request->get('phone');
            $product_type_id = $request->get('interesting');
            $state_id = $request->get('types');
            $sizes_id = $request->get('sizes');
            $business_name = $request->get('business_name');
            $product_id = $request->get('buildout_name');
            $resumen_truck = $request->get('resumen_truck');
            $resumen_buildout = $request->get('resumen_buildout');
            $resumen_appliance = $request->get('resumen_appliance');
            $tax = $request->get('taxappliance');
            $taxitem = 0;
            $taxbuildout = $request->get('taxbuildout');
            $taxappliance = $request->get('tax');
            $description_quote = $request->get('descriptionquote');
            $discount = $request->get('discount');
            $total_without_tax = $request->get('subtotal_without_tax');
            $registration = $request->get('registration');
            $total_quote = $request->get('gtotalquote');
            $budget = $request->get('budget');
            $downpayment = $request->get('downpayment');
            $financing = $request->get('financing');
            $state = $request->get('state');
            $buildout_description = $request->get('hidden_description');
            //$buildout_description = $request->get('buildout_description');
            $precio_builout = $request->get('buildout_price');

            //$sources  =  DB::table('sources')->where('id', 2)->first();
            $sources  =  $quote->from_where;

            if($state == 'TX') {
                $taxitem = $request->get('taxitem');
                $precio = $total_quote;
                //$starting_with= $request->get('starting');
            }

            $sumarizedDataLead = [
                'name' => $lead_name,
                'lastname' => $lead_lastname,
                'email' => $lead_email,
                'state' => $lead_state,
                'telephone' => $lead_telephone,
            ];
            DB::table('account')->where('id', $customer->id)->update($sumarizedDataLead);

            //Se guarda la quote
            $sumarizedData = [
                'truck_name' => $business_name,
                'truck_aprox_price' => $total_quote,
                'id_type' => $state_id,
                'truck_budget' => $budget,
                'downpayment' => $downpayment,
                'financing' => $financing,
                'build_out' => $product_id,
                'time' => $date_limit,
                'registration' => $registration,
                'truck_tax' => $tax + $taxbuildout,
                'interesting' => $product_type_id,
                'id_size' => $sizes_id,
                'state' => $state,
                'price_item' => $starting_with,
                'discount' => $discount,
                'description' => $description_quote,
                'desc_buildout' => $buildout_description,
                'precio_builout' => $precio_builout,
                'tax_item' => $taxitem,
                'created_at' => Carbon::now(config('app.timezone')),
                'from_where' => $sources,
                'id_account' => $customer->id,
                'is_active' => 0,
                'truck_date_created' => Carbon::now(config('app.timezone'))
            ];
            DB::table('user_trucks')->where('id', $orders_id)->update($sumarizedData);

            $quote_updated = DB::table('user_trucks')->where('id', $orders_id)->first();
            $ganancias = 0;

            //Para el cálculo de las Ganancias debemos obtener el 30% del precio del TRUCK, TRAILER, CART, etc
            if($quote_updated->price_item == 0 || $quote_updated->price_item == null) {
                $ganancias += floatval($quote_updated->truck_price_range) * 30 / 100;

            } else {
                $ganancias += floatval($quote_updated->price_item) * 30 / 100;
            }

            //Para el cálculo de las Ganancias debemos obtener el 30% del precio del Buildout
            if($quote_updated->precio_builout != 0) {
                $ganancias += floatval($quote_updated->precio_builout) * 30 / 100;
            }

            $profits  = DB::table('truck_items')->where('id_truck', $orders_id)->get();
            foreach ($profits as $profit) {
                $precio = DB::table('appliance_inside_category')->where('name', $profit->item_subcategory)->first();
                $precio = ($profit->price) - ($precio->retail_price);
                $ganancias += $precio;
            }

            if (empty($quote_updated->truck_aprox_price)) {
                $ganancias = 0;
            } else {
                $ganancias = round(($ganancias * 100 / floatval($quote_updated->truck_aprox_price)), 2);
            }

            DB::table('user_trucks')->where('id', $orders_id)->update(['profits' => $ganancias]);

            if($request->get('send_email') == 'true') {
                $this->getSendquote($orders_id);
            }

            //Creamos el nuevo proyecto a partir de la Quote creada recientemente
            $proyect = DB::table('proyects')->where('orders_id', $orders_id)->first();
            if(count($proyect) == 0) {
                $sumarizedDataProyect = [
                    'name' => $business_name,
                    'customers_id' => $customer->id,
                    'interesting' => $product_type_id,
                    'fases_type_id' => 0,
                    'fases_id' => 0,
                    'datetime' => Carbon::now(config('app.timezone')),
                    'cms_users_id' => $customer->id_usuario,
                    'orders_id' => $orders_id,
                ];
                DB::table('proyects')->insert($sumarizedDataProyect);
            } else {
                $sumarizedDataProyect = [
                    'name' => $business_name,
                    'customers_id' => $customer->id,
                    'interesting' => $product_type_id,
                    'cms_users_id' => $customer->id_usuario,
                ];
                DB::table('proyects')->where('orders_id', $orders_id)->update($sumarizedDataProyect);
            }

            CRUDBooster::redirect(CRUDBooster::adminPath("orders"),trans("crudbooster.text_change_quotes"));

        }

        public function getTypes($type) {
            $data = DB::table('type_state')
                ->select(\Illuminate\Support\Facades\DB::raw('estado.estado as state'), 'estado.id', 'type.type')
                ->join('estado', 'estado.id', '=', 'type_state.id_estado')
                ->join('type', 'type.id', '=', 'type_state.id_type')
                ->where('type.id', $type)
                ->where('type.deleted_at', null)
                ->where('estado.deleted_at', null)
                ->where('type_state.deleted_at', null)
                ->get();

            return $data;
        }

        public function getEstadolist() {
            $data = DB::table('estado')
                ->select(\Illuminate\Support\Facades\DB::raw('estado.estado as state'), 'estado.id')
                ->where('estado.deleted_at', null)
                ->get();

            return $data;
        }

        public function getEditquote(\Illuminate\Http\Request $request) {
            DB::table('truck_items')->where('id', $request->get('id'))->update([$request->get('campo') => $request->get('valor')]);
            $data = DB::table('truck_items')->where('id', $request->get('id'))->first();
            $data = $data->id_truck;

            return $data;
	    }

	    //Funcion que permite guardar las "Category" de "Appliance"
        public function getEditcategory(\Illuminate\Http\Request $request) {
            DB::table('appliance')->where('id', $request->get('id'))->update(['category' => $request->get('valor')]);

            return $request->get('id');
        }

        //Funcion que permite guardar las "Subcategorías" de "Appliance Inside"
        public function getEditapplianceinside(\Illuminate\Http\Request $request) {
            DB::table('appliance_inside')->where('id', $request->get('id'))->update([$request->get('campo') => $request->get('valor')]);

            return $request->get('id');
        }

        //Función que permite guardar el "Precio" de la "Appliance"
        public function getUpdateprecio(\Illuminate\Http\Request $request) {
            $price= $request->get('precio');
            $id= $request->get('id');
            $data = DB::table('appliance_inside_category')->where('id', $id)->update(['price' => $price]);

            return $data;
        }

        //Función que permite modificar el "Appliance" de "Appliance Inside"
        public function getSaveappliance(\Illuminate\Http\Request $request) {

            $data = DB::table('appliance_inside')->where('id', $request->get('id_appliance_inside'))->update(['id_appliance' => $request->get('valor')]);
            $data = DB::table('appliance')->where('id', $request->get('valor'))->first();

            return $data->category;
        }

        //Obtiene el listado de los appliances existentes en bd
        public function getAppliances() {
            $data = DB::table('appliance')
                ->select('id','category')
                ->where('deleted_at', null)
                ->get();

            return $data;
        }

        //Actualiza en base de datos las modificaciones de los appliances en el listado de la cotización
        public function getUpdateappliance(\Illuminate\Http\Request $request) {
            $sumarizedData = [
                'item_category' => $request->get('item_category'),
                'item_name' => $request->get('item_name'),
                'item_subcategory' => $request->get('item_subcategory'),
                'descripcion_details' => $request->get('descripcion_details'),
                'price' => $request->get('price'),
                'cant' => $request->get('cant'),
            ];
            DB::table('truck_items')->where('id', $request->get('id_appliance'))->update($sumarizedData);

            return 1;
        }

        //Actualiza en base de datos las modificaciones de los appliance_inside en el listado (subcategorias)
        public function getUpdateapplianceinside(\Illuminate\Http\Request $request) {
            $sumarizedData = [
                'id_appliance' => $request->get('id_appliance'),
            ];
            DB::table('appliance_inside')->where('id', $request->get('id'))->update($sumarizedData);

            return 1;
        }

        //Actualiza en base de datos las modificaciones de los appliance_inside en el listado (subcategorias)
        public function getUpdateapplianceonlyname(\Illuminate\Http\Request $request) {
            $sumarizedData = [
                'name' => $request->get('name'),
            ];
            DB::table('appliance_inside')->where('id', $request->get('id'))->update($sumarizedData);

            return 1;
        }

        //Insertar en base de datos el appliance insertado dinámicamente
        public function getAddappliance(\Illuminate\Http\Request $request) {
            $sumarizedData = [
                'id_truck' => $request->get('id_truck'),
                'id_account' => $request->get('id_account'),
                'item_category' => $request->get('item_category'),
                'item_name' => $request->get('item_name'),
                'item_subcategory' => $request->get('item_subcategory'),
                'descripcion_details' => $request->get('descripcion_details'),
                'price' => $request->get('price'),
                'cant' => $request->get('cant'),
                'from_where' => $request->get('from_where'),
            ];
            $data = DB::table('truck_items')->where('id', $request->get('id_appliance'))->insertGetId($sumarizedData);

            return $data;
        }

        //Función que permite guardar el "Precio de Costo" de la "Appliance" (retail_price)
        public function getUpdateprecioretail(\Illuminate\Http\Request $request) {
            $price= $request->get('precio');
            $id= $request->get('id');
            $data = DB::table('appliance_inside_category')->where('id', $id)->update(['retail_price' => $price]);

            return $data;
        }

        //Función que permite guardar el "Registration" de la "Quote"
        public function getUpdateregistration(\Illuminate\Http\Request $request) {
            $registration= $request->get('registration');
            $data = DB::table('settings')->where('id', 1)->update(['registration' => $registration]);
            DB::table('configuration')->where('id', 1)->update(['value' => $registration]);

            return $data;
        }

        public function getStates() {

            \Illuminate\Support\Facades\DB::beginTransaction();

            $states = \Illuminate\Support\Facades\DB::select( DB::raw("
                        SELECT 
                          CASE WHEN count(user_trucks.id)<11 THEN '#00FFD4' 
                          WHEN count(user_trucks.id) >=11 and  count(user_trucks.id) < 21 THEN '#09DE5E' 
                          WHEN count(user_trucks.id) >=21 and count(user_trucks.id) < 101  THEN '#1C9C71' 
                          WHEN count(user_trucks.id) >=101 THEN '#257A25' END as color,states.abbreviation as state,count(user_trucks.id) as cant 
                              from user_trucks 
                              join account on account.id = user_trucks.id_account
                              join states on states.abbreviation = account.state
                          group by states.abbreviation
                          order by count(user_trucks.id) DESC
                        ;
                        ")
            );

            \Illuminate\Support\Facades\DB::commit();

            return $states;
        }

        public function getSellers() {
            $data['sellers_2018'] = [];
            /*$data['sellers_2017'][0]['label'] = 'Julio';
            $data['sellers_2017'][0]['months'] = array(0,0,0,0,8,0,0,0,4,0,0,0,);
            $data['sellers_2017'][0]['color'] = 'green';*/

            $usersResult = \Illuminate\Support\Facades\DB::table('cms_users')
                ->get();

            \Illuminate\Support\Facades\DB::beginTransaction();

            $result2017 = \Illuminate\Support\Facades\DB::select( DB::raw("
                        SELECT MONTH(user_trucks.truck_date_created) as month, cms_users.id, cms_users.name, cms_users.color, count(*) as ammount 
                        FROM user_trucks 
                        JOIN account ON account.id = user_trucks.id_account
                        JOIN cms_users ON cms_users.id = account.id_usuario
                        WHERE account.id_usuario != -1 AND YEAR(user_trucks.truck_date_created) = '2018'
                        GROUP BY MONTH(user_trucks.truck_date_created), account.id_usuario, cms_users.id, cms_users.name, cms_users.color
                        ORDER BY account.id_usuario,MONTH(user_trucks.truck_date_created)
                        ;
                        ")
            );

            \Illuminate\Support\Facades\DB::commit();

            $users = [];
            foreach ($usersResult as $user) {
                $users[] = $user->id;
            }

            $data['sellers_2018'] = [];
            foreach ($users as $user) {
                $monthsTemp = array(0,0,0,0,0,0,0,0,0,0,0,0,);
                foreach ($result2017 as $item) {
                    if ($item->id == $user) {
                        $data['sellers_2018'][array_search($user, $users)]['label'] = $item->name;
                        $data['sellers_2018'][array_search($user, $users)]['color'] = $item->color;
                        $monthsTemp[$item->month-1] = $item->ammount;
                    }
                }
                $data['sellers_2018'][array_search($user, $users)]['months'] = $monthsTemp;
            }

            $data['sellers2018'] = [];
            //Limpiar datos procesados
            foreach ($data['sellers_2018'] as $item) {
                if (isset($item['label'])) {
                    array_push($data['sellers2018'], $item);
                }
            }

            return ($data['sellers2018']);
        }

        public function getSizes($type) {
            $data = DB::table('size_type')
                ->select(\Illuminate\Support\Facades\DB::raw('size.size as size'), 'size.id')
                ->join('size', 'size.id', '=', 'size_type.id_size')
                ->where('size_type.id_type', $type)
                ->where('size.deleted_at', null)
                ->where('size_type.deleted_at', null)
                ->get();

            return $data;
        }

        public function getSizeslist() {
            $data = DB::table('size')
                ->where('size.deleted_at', null)
                ->get();

            return $data;
        }

        public function getBuildout(\Illuminate\Http\Request $request) {
            $type=$request->get('type');
            $size=$request->get('size');

            if ($type != 2) {
                $data = DB::table('buildout')
                    ->select(\Illuminate\Support\Facades\DB::raw('type.type as type'), 'buildout.id', 'buildout.nombre', 'buildout.descripcion', 'buildout.precio', 'buildout.tipo')
                    ->join('type', 'type.id', '=', 'buildout.tipo')
                    ->where('type.id', $type)
                    ->get();

            } elseif ($type == 2) {

                \Illuminate\Support\Facades\DB::beginTransaction();

                $data = \Illuminate\Support\Facades\DB::select( DB::raw("
                        SELECT buildout.id, buildout.nombre, buildout.descripcion, buildout.precio, size.size
                        FROM buildout
                        INNER JOIN type ON buildout.tipo = type.id 
                        INNER JOIN size_type ON size_type.id_type = type.id
                        INNER JOIN size on size_type.id_size = size.id
                        WHERE buildout.tipo=$type
                        AND size.id=$size AND buildout.nombre LIKE CONCAT('%',size.size,'%');
                        ")
                );

                \Illuminate\Support\Facades\DB::commit();
            }

            return $data;
        }

        public function getBuildoutQuote($type, $size) {

            if ($type != 2) {
                $data = DB::table('buildout')
                    ->select(\Illuminate\Support\Facades\DB::raw('type.type as type'), 'buildout.id', 'buildout.nombre', 'buildout.descripcion', 'buildout.precio', 'buildout.tipo')
                    ->join('type', 'type.id', '=', 'buildout.tipo')
                    ->where('type.id', $type)
                    ->get();

            } elseif ($type == 2) {

                \Illuminate\Support\Facades\DB::beginTransaction();

                $data = \Illuminate\Support\Facades\DB::select( DB::raw("
                        SELECT buildout.id, buildout.nombre, buildout.descripcion, buildout.precio, size.size
                        FROM buildout
                        INNER JOIN type ON buildout.tipo = type.id 
                        INNER JOIN size_type ON size_type.id_type = type.id
                        INNER JOIN size on size_type.id_size = size.id
                        WHERE buildout.tipo=$type
                        AND size.id=$size AND buildout.nombre LIKE CONCAT('%',size.size,'%');
                        ")
                );

                \Illuminate\Support\Facades\DB::commit();
            }

            return $data;
        }

        public function getBuildoutbyid($id) {
            $data = DB::table('buildout')->where('id', $id)->get();
            return $data;
        }

        public function getAppliancescategories() {
            $data = DB::table('appliance')
                ->where('deleted_at',null)
                ->get();
            return $data;
        }

        public function getListadosub(\Illuminate\Http\Request $request) {
            $id=$request->get('id');

            $data = DB::table('appliance_inside_category')
                ->where('id_appliance_inside', $id)
                ->get();

            return $data;
        }

        public function getSearchappliances(\Illuminate\Http\Request $request) {
            $id=$request->get('id');
            $data = DB::table('appliance_inside_category')
                ->where('id', $id)
                ->get();

            return $data;
        }

        public function getApplianceslist(\Illuminate\Http\Request $request) {
            $data = DB::table('appliance_inside')
                ->where('id_appliance', $request->get('categoria'))
                ->where('id_type', 4)
                ->get();

            return $data;
        }

        public function getApplianceslistname(\Illuminate\Http\Request $request) {
	        $categoria = $request->get('categoria');

            \Illuminate\Support\Facades\DB::beginTransaction();
            $result = \Illuminate\Support\Facades\DB::select( DB::raw("
                  SELECT appliance_inside.name,appliance_inside.id from appliance_inside 
                  INNER join appliance on appliance.id=appliance_inside.id_appliance 
                  WHERE id_type=4 AND appliance.category = '$categoria';
                ")
            );
            \Illuminate\Support\Facades\DB::commit();

            return $result;
        }

        //Obtener cada subcategorías con su categoria asociada
        public function getSubcategoriascategoria() {

            \Illuminate\Support\Facades\DB::beginTransaction();
            $result = \Illuminate\Support\Facades\DB::select( DB::raw("
                  SELECT appliance_inside.name,appliance.category,appliance_inside.id
                  FROM appliance_inside 
                  INNER JOIN appliance ON appliance.id=appliance_inside.id_appliance
                  WHERE ISNULL(appliance_inside.deleted_at);
                ")
            );
            \Illuminate\Support\Facades\DB::commit();

            return $result;
        }

        public function getApplianceslistinside(\Illuminate\Http\Request $request) {
	        $id = $request->get('id');

            \Illuminate\Support\Facades\DB::beginTransaction();
            $result = \Illuminate\Support\Facades\DB::select( DB::raw("
                SELECT
                appliance_inside_category.id,
                appliance_inside_category.`name`,
                appliance_inside_category.price,
                appliance_inside_category.retail_price,
                appliance_inside_category.description,
                appliance_inside_category.imagen,
                appliance_inside.`name` AS appliance_inside,
                appliance_inside.id AS id_appliance,
                appliance.id as appliance_id,
                appliance.category
                FROM appliance_inside_category
                INNER JOIN appliance_inside ON appliance_inside_category.id_appliance_inside = appliance_inside.id
                INNER JOIN appliance ON appliance.id = appliance_inside.id_appliance
                where appliance_inside_category.id=$id order by appliance_inside_category.id desc;
                ")
            );
            \Illuminate\Support\Facades\DB::commit();

            return $result;
        }

        public function getPrices(\Illuminate\Http\Request $request) {
	        $type=$request->get('type');
	        $state=$request->get('state');
	        $size=$request->get('size');

	        $datas = array();
            $data = DB::table('prices')
                ->select('price')
                ->where('id_type', $type)
                ->where('id_state', $state)
                ->where('id_size', $size)
                ->get();

            if (count($data) == 0) {
                $datas[0]['price'] = 0;
            } else {
                $datas = $data;
            }

            return $datas;
        }

        public function getPrintQuote($id) {
            $data = [];

            \Illuminate\Support\Facades\DB::beginTransaction();
            $result = \Illuminate\Support\Facades\DB::select( DB::raw("
                    SELECT truck_extras_price,
                    account.email,
                    account.`name`,
                    account.lastname,
                    account.state,
                    account.telephone,
                    user_trucks.truck_name,
                    user_trucks.truck_date_created,
                    user_trucks.downpayment,
                    user_trucks.truck_budget,
                    user_trucks.financing,
                    user_trucks.build_out,
                    user_trucks.time,
                    buildout.nombre,
                    CASE 
                        WHEN ISNULL(precio_builout) THEN buildout.precio
                        ELSE precio_builout
                        END
                        AS precio,
                    type.type as categoria,
                    id_account,
                    user_trucks.registration,
                    user_trucks.truck_aprox_price,
                    user_trucks.truck_tax,
                    user_trucks.id,
                    user_trucks.tax_item,
                    type.type AS categoria,
                    estado.estado,
                    size.size,
                    CASE 
                        WHEN user_trucks.price_item = 0 THEN user_trucks.truck_price_range
                        ELSE user_trucks.price_item
                        END
                        AS price_item,
                    user_trucks.discount,
                     CASE 
                        WHEN ISNULL(user_trucks.desc_buildout) THEN buildout.descripcion
                        ELSE user_trucks.desc_buildout
                        END
                        AS desc_buildout
                    FROM
                    account
                    INNER JOIN user_trucks ON user_trucks.id_account = account.id
                    LEFT JOIN buildout ON user_trucks.build_out = buildout.id
                    LEFT JOIN type ON type.id = user_trucks.interesting
                    LEFT JOIN estado ON user_trucks.id_type = estado.id
                    LEFT JOIN size ON user_trucks.id_size = size.id where user_trucks.id=$id;
                ")
            );
            \Illuminate\Support\Facades\DB::commit();

            $html = '';

            foreach ($result as $row) {
                //estructurtando el hml de cada usuario
                $fechaneed=$row->truck_date_created;
                $fecha=date("m-d-Y",strtotime($fechaneed));

                $fechaneed1=$row->time;
                $fecha1=date("m-d-Y",strtotime($fechaneed1));

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
                                                   <div style="font-size:10px;" valign="middle" align="left">
                                                       <b>CLIENT</b>
                                                       <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->name." ".$row->lastname.'</p>
                                                       <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->state.'</p>
                                                       <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->telephone.'</p>
                                                       <p style="color:#000000; text-decoration:underline; text-decoration:none;">'.$row->email.'</p>
                                                     
                                                    </div>
                                            </td>
                                            <td>
                                                <div style="font-size:14px;" valign="middle" align="right"><b>Quote name: '.$row->truck_name.'</b></div>
                                                <div style="font-size:14px; padding-top: 10px" valign="middle" align="right"><b>Date Quote: '.$fecha.'</b></div>
                                                <div style="font-size:14px; padding-top: 10px" valign="middle" align="right"><b>Date Limit: '.$fecha1.'</b></div>
                                            </td>
                                        </tr>
                                      
                                         <tr>
                                               
                                              
                                        </tr>
                              </table> ';
                //Agregando Financiamiento.user_trucks.financing,
                $html =  $html.  '<table width="100%" border="0" align="center" cellspacing="0" cellpadding="4">
                                     <tr>
                                       <td align="left" valign="top" bgcolor="#dda51c" style="background-color:#026873; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#ffffff;"><b>FINANCING</b></td>
                                     </tr>
                                     <tr>
                                         <td align="left"  style="font-size:10px;">
                                             <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr style="font-size:10px;">
                                                   <td align="left"><p><b>Need Financing: </b>'.$row->financing.' </p></td>
                                                   <td align="left"><p><b>How soon you need it?: </b> '.$fecha1.' </p></td>
                                                   <td align="left"><p><b>Budget: </b>'.$row->truck_budget.'</p></td>
                                                   <td align="left" ><p><b>Downpayment: </b> '.$row->downpayment.' </p></td>
                                                  
                                                </tr>
                                                
                                                                                                 
                                               </table>

                                         </td>
                                     </tr>
                                 </table>';
                //Agregando los bluid_out y del precio del camion
                $html = $html .  '        
                              <table width="100%" border="0" align="center" cellspacing="0" cellpadding="4" >
                                     <tr style="color:#FFF; font-size:12px;">
                                            <td width="10%" bgcolor="#026873"><b>CATEGORY</b></td>
                                            <td width="20%" bgcolor="#026873"><b>TYPE</b></td>
                                            <td width="20%" bgcolor="#026873"><b>SIZE</b></td>
                                            <td width="20%" bgcolor="#026873"><b>PRICE</b></td>
                                     </tr>
                                       <tr style="font-size:10px;">
                                          <td >'.$row->categoria.'</td>
                                          <td >'.$row->estado.'</td>
                                          <td >'.$row->size.'</td>
                                          <td >'.$row->price_item.'</td>
                                       </tr>
                              </table>';
                $html = $html .  '<table width="100%" border="0" align="center" cellspacing="0" cellpadding="4" >
                                      <tr>
                                        <td colspan="4" align="left" valign="top" bgcolor="#dda51c" style="background-color:#026873; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#ffffff;"><b>TRUCK SELECTION</b></td>

                                      </tr>
                                      <tr style="color:#FFF;font-size:12px;">
                                          <td width="10%" bgcolor="#026873"><b>CATEGORY</b></td>
                                          <td width="20%" bgcolor="#026873"><b>PRODUCT NAME</b></td>
                                          <td width="10%" bgcolor="#026873"><b>PRICE</b></td>
                                          <td width="60%" bgcolor="#026873"><b>DESCRIPTION</b></td>
                                      </tr>
                                       <tr style="font-size:10px;">
                                          <td >BUILD OUT</td>
                                          <td >'.$row->nombre.'</td>
                                          <td >'.$row->precio.'</td>
                                          <td >'.$row->desc_buildout.'</td>
                                       </tr>
                              </table>';
                //agregando accesorio al camion
                $html=$html. '<table width="100%" border="0" align="center" cellspacing="0" cellpadding="5" >
                                         <tr>
                                             <td align="left" colspan="7" valign="top" bgcolor="#dda51c" style="background-color:#026873; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#ffffff;"><b>ACCESORIES</b></td>

                                         </tr>
                                         <tr style="color:#FFF;font-size:12px;">
                                             <td bgcolor="#026873" ><b>CATEGORY</b></td>
                                             <td bgcolor="#026873" ><b>APPLIANCE</b></td>
                                             <td bgcolor="#026873" ><b>DETAIL</b></td>
                                              <td bgcolor="#026873" ><b>DESCRIPCION</b></td>
                                             <td bgcolor="#026873"><b>UNIT PRICE</b></td>
                                             <td bgcolor="#026873"><b>QUANTITY</b></td>
                                             <td bgcolor="#026873"><b>TOTAL PRICE</b></td>
                                        </tr>';

                \Illuminate\Support\Facades\DB::beginTransaction();
                $qr1 = \Illuminate\Support\Facades\DB::select( DB::raw("
                        SELECT descripcion_details,item_category,item_subcategory,truck_items.item_name,truck_items.price,truck_items.item_category,truck_items.cant 
                        FROM truck_items where id_truck =$id;
                        ")
                );
                \Illuminate\Support\Facades\DB::commit();

                $result2 = $qr1;
                $total_impuesto = 0;
                $total_item=0;
                $total_apliance = 0;
                $total_general_apliance=0;
                foreach ($result2 as $row1) {


                    $total_apliance =  ($row1->price * $row1->cant);
                    //$total_apliance= number_format($total_apliance, 2, ',', ' ');
                    $html = $html . "<tr style='font-size:10px;'>
                                        <td>".$row1->item_category."</td>
                                        <td>".$row1->item_name."</td>
                                        <td>".$row1->item_subcategory."</td>   
                                        <td>".$row1->descripcion_details."</td>     
                                        <td>".$row1->price."</td>
                                        <td>".$row1->cant."</td>
                                        <td>".$total_apliance."</td>
                                     </tr>";

                    $total_general_apliance =  $total_apliance + $total_general_apliance;


                }


                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td bgcolor="#026873"><b>'.$row->categoria.':</b></td>
                                <td bgcolor="#026873"><b>'.$row->price_item.'</b></td>
                               </tr>';
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td bgcolor="#026873"><b>Build Out :</b></td>
                                <td bgcolor="#026873"><b>'.$row->precio.'</b></td>
                               </tr>';
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td bgcolor="#026873"><b>Appliances :</b></td>
                                <td bgcolor="#026873"><b>'.number_format($total_general_apliance, 2, '.', ' ').'</b></td>
                               </tr>';
                $subTotal= $row->price_item + $row->precio + $total_general_apliance;
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td bgcolor="#026873"><b>Subtotal quote :</b></td>
                                <td bgcolor="#026873"><b>'.number_format($subTotal, 2, '.', ' ').'</b></td>
                               </tr>';
                $totalTax= $row->truck_tax + $row->tax_item;
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td></td>
                                <td bgcolor="#026873"><b>Total Taxes :</b></td>
                                <td bgcolor="#026873"><b>'.number_format($totalTax, 2, '.', ' ').'</b></td>
                               </tr>';
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td bgcolor="#026873"><b>Discount:</b></td>
                                <td bgcolor="#026873"><b>'.number_format($row->discount, 2, '.', ' ').'</b></td>
                               </tr>';
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td bgcolor="#026873"><b>Registration:</b></td>
                                <td bgcolor="#026873"><b>'.$row->registration.'</b></td>
                               </tr>';
                //calcular el total
                $total= $row->registration + $row->price_item + $row->precio + $total_general_apliance + $totalTax  - $row->discount;
                $html = $html . '<tr style="color:#FFF;font-size:10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td bgcolor="#026873"><b>Total quote:</b></td>
                                <td bgcolor="#026873"><b>'.number_format($total, 2, '.', ' ').'</b></td>
                               </tr>';
                $html = $html . " </table> "   ;
                //AGREGAR LA NOTA DE Q LA QUOTIZACION ES VALIDA SOLO POR 30 DIAS PROXIMOS
                $html = $html . '<table width="100%" border="0" align="center" cellspacing="0" cellpadding="5" >
                              <tr style="color:#00000">
                              <td >Note: This quote is valid for the next 30 days</td>
                              </tr> </table></div>' ;
            }

            $data['html'] = $html;

            $this->cbView('clients.invoice-print',$data);
        }

        //Enviar Email dado el id de Lead
        public function getSendEmail($id) {
            $emails = [];

            if(gettype($id) == 'array') {
                foreach ($id as $item) {
                    $leads = DB::table('account')
                        ->join('user_trucks', 'user_trucks.id_account', '=', 'account.id')
                        ->where('user_trucks.id', $item)->first();

                    if (!empty($leads->email)) {
                        $emails[] = strtolower($leads->email);
                    }
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

        //Enviar SMS dado el id de Lead
        public function getSendSms($id) {
            $to = null;

            if(gettype($id) == 'array') {
                foreach ($id as $item) {
                    $leads = DB::table('account')
                        ->join('user_trucks', 'user_trucks.id_account', '=', 'account.id')
                        ->where('user_trucks.id', $item)->first();

                    if (!empty($leads->telephone)) {
                        $to[] = $leads->telephone;
                    }
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

        //Enviar Schedule Email dado el id de Lead
        public function getSendEmailSchedule($id) {
            $emails = [];

            if(gettype($id) == 'array') {
                foreach ($id as $item) {
                    $leads = DB::table('account')
                        ->join('user_trucks', 'user_trucks.id_account', '=', 'account.id')
                        ->where('user_trucks.id', $item)->first();

                    if (!empty($leads->email)) {
                        $emails[] = strtolower($leads->email);
                    }
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

        //Eliminar una categoría de la base de datos
        public function getDeletecategoria(\Illuminate\Http\Request $request) {
            DB::table('appliance')->where('id', $request->get('id'))->update(['deleted_at'=>  Carbon::now(config('app.timezone'))]);

            return 1;
        }

        //Eliminar una subcategoría de la base de datos
        public function getDeletesubcategoria(\Illuminate\Http\Request $request) {
            DB::table('appliance_inside')->where('id', $request->get('id'))->update(['deleted_at'=>  Carbon::now(config('app.timezone'))]);

            return 1;
        }

	}