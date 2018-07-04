<?php

use Carbon\Carbon;
use crocodicstudio\crudbooster\helpers\CRUDBooster;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    Route::get('ajaxImageUpload', ['uses'=>'AjaxImageUploadController@ajaxImageUpload']);
    Route::post('ajaxImageUpload', ['as'=>'ajaxImageUpload','uses'=>'ImageUploadController@imageUploadPost']);

    Route::get('file','FileController@create');
    Route::post('file','FileController@store');


    Route::get('/', function () {
        return view('welcome');
    });

    //Rutas de Traducciones
    Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('tour_default');
    });

    Route::get('/register_client', function () {
        $maxId = DB::table('cms_users')->select(\Illuminate\Support\Facades\DB::raw('MAX(id) as id'))->first();
        $maxId = $maxId->id + 1;

        $sumarizedData = [
            'id' => $maxId,
            'name' => request('name').' '.request('lastname'),
            'email' => request('email'),
            'fullname' => request('name').' '.request('lastname'),
            'id_cms_privileges' => 1,
            'status' => 'Active',
            'password' => bcrypt(request('password'))
        ];

        DB::table('cms_users')->insert($sumarizedData);

        return redirect()->route('getLogin');
    });

    Route::get('/query', function () {

        $leads = DB::table('account')->get();
        foreach ($leads as $lead) {

            $state = DB::table('states')->where('id', $lead->state)->first();
            if (!empty($state)) {
                DB::table('account')->where('id', $lead->id)->update(['state'=>$state->abbreviation]);
            }
        }

        $clients = DB::table('clients')->get();
        foreach ($clients as $client) {
            $state = DB::table('states')->where('id', $client->state)->first();
            if (!empty($state)) {
                DB::table('clients')->where('id', $client->id)->update(['state'=>$state->abbreviation]);
            }
        }

        $invoices = DB::table('invoice')->get();
        foreach ($invoices as $invoice) {
            $state = DB::table('states')->where('id', $invoice->state_client)->first();
            if (!empty($state)) {
                DB::table('invoice')->where('id', $invoice->id)->update(['state_client'=>$state->abbreviation]);
            }
        }

        $user_trucks = DB::table('user_trucks')->get();
        foreach ($user_trucks as $user_truck) {
            $state = DB::table('states')->where('id', $user_truck->state)->first();
            if (!empty($state)) {
                DB::table('user_trucks')->where('id', $user_truck->id)->update(['state'=>$state->abbreviation]);
            }
        }

    });

    Route::get('/taxes', function () {
        $user_trucks = DB::table('user_trucks')
            ->where('state','TX')
            ->get();

        $range =count($user_trucks)-1;

        for ($i=$range-100; $i>$range-250; $i--) {
            $query = DB::table('user_trucks')
                ->join('truck_items', 'truck_items.id_truck', '=', 'user_trucks.id')
                ->where('user_trucks.id',$user_trucks[$i]->id)
                ->get();

            $query_truck = DB::table('user_trucks')
                ->where('user_trucks.id',$user_trucks[$i]->id)
                ->first();

            //Si tiene Appliances y es de Texas
            if(count($query) != 0) {
                $tax_appliances = 0;
                $total_appliances = 0;
                $total = 0;
                foreach ($query as $q) {
                    $total_appliances += $q->price*$q->cant;
                }

                $price_buildout = 0;
                $tax_buildout = 0;
                $tax_item = 0;
                if ($query_truck->build_out_price == 0) {
                    $price_buildout = $query_truck->precio_builout;
                } else {
                    $price_buildout = $query_truck->build_out_price;
                }

                //Si chefunits vende camión *****************************************
                $price_item = 0;
                if ($query_truck->price_item == 0) {
                    $price_item = $query_truck->truck_price_range;
                } else {
                    $price_item = $query_truck->price_item;
                }

                if ($price_item == 0) {
                    //Si el camión es del cliente (Camión Propio)
                    $tax_appliances = $total_appliances*0.0825;
                    $tax_buildout = $price_buildout*0.33*0.0825;
                } else {
                    //Si chefunits vende camión
                    $tax_appliances = $total_appliances*0.0625;
                    $tax_item = $price_item * 0.0625;
                    $tax_buildout = $price_buildout*0.0625;
                }

                $discount = $query_truck->discount;
                $total = ($tax_item + $tax_appliances + $tax_buildout) + $price_item + $query_truck->registration + $price_buildout + $total_appliances - $discount;
                DB::table('user_trucks')->where('id',$user_trucks[$i]->id)->update(['truck_tax'=>$tax_appliances+$tax_buildout, 'truck_aprox_price'=>$total]);
            }
            //Si no tiene Appliances y es de Texas
            else {
                $tax_appliances = 0;
                $total_appliances = 0;
                $total = 0;

                $price_buildout = 0;
                $tax_buildout = 0;
                $tax_item = 0;
                if ($query_truck->build_out_price == 0) {
                    $price_buildout = $query_truck->precio_builout;
                } else {
                    $price_buildout = $query_truck->build_out_price;
                }

                //Si chefunits vende camión *****************************************
                $price_item = 0;
                if ($query_truck->price_item == 0) {
                    $price_item = $query_truck->truck_price_range;
                } else {
                    $price_item = $query_truck->price_item;
                }

                if ($price_item == 0) {
                    //Si el camión es del cliente (Camión Propio)
                    $tax_appliances = 0;
                    $tax_buildout = $price_buildout*0.33*0.0825;
                } else {
                    //Si chefunits vende camión
                    $tax_appliances = 0;
                    $tax_item = $price_item * 0.0625;
                    $tax_buildout = $price_buildout*0.0625;
                }

                $discount = $query_truck->discount;
                $total = ($tax_item + $tax_appliances + $tax_buildout) + $price_item + $query_truck->registration + $price_buildout + $total_appliances - $discount;
                DB::table('user_trucks')->where('id',$user_trucks[$i]->id)->update(['truck_tax'=>$tax_appliances+$tax_buildout,'tax_item'=>$tax_item, 'truck_aprox_price'=>$total]);
            }
        }

    });

    Route::get('/taxes_total', function () {

        $user_trucks = DB::table('user_trucks')
            ->where('state', '!=','TX')
            ->get();
        
        $range =count($user_trucks)-1;

        for ($i=$range; $i>$range-100; $i--) {
            $query = DB::table('user_trucks')
                ->join('truck_items', 'truck_items.id_truck', '=', 'user_trucks.id')
                ->where('user_trucks.id',$user_trucks[$i]->id)
                ->get();

            $query_truck = DB::table('user_trucks')
                ->where('user_trucks.id',$user_trucks[$i]->id)
                ->first();

            if(count($query) != 0) {
                $tax_appliances = 0;
                $total_appliances = 0;
                $total = 0;
                foreach ($query as $q) {
                    $total_appliances += $q->price*$q->cant;
                }

                $tax_appliances = 0;
                $price_item = 0;
                if ($query_truck->price_item == 0) {
                    $price_item = $query_truck->truck_price_range;
                } else {
                    $price_item = $query_truck->price_item;
                }

                $price_buildout = 0;
                if ($query_truck->build_out_price == 0) {
                    $price_buildout = $query_truck->precio_builout;
                } else {
                    $price_buildout = $query_truck->build_out_price;
                }

                $discount = $query_truck->discount;
                $total = $price_item + $query_truck->registration + $price_buildout + $total_appliances - $discount;
                DB::table('user_trucks')->where('id',$user_trucks[$i]->id)->update(['truck_tax'=>0, 'tax_item'=>0, 'truck_aprox_price'=>$total]);
            }
        }

    });

    Route::get('image-upload',['as'=>'image.upload','uses'=>'ImageUploadController@imageUpload']);
    Route::post('image-upload',['as'=>'image.upload.post','uses'=>'ImageUploadController@imageUploadPost']);

    Route::get('crm/tour/general', function () { return view('tour_general'); });
    Route::get('crm/tour/add_lead', function () { return view('tour_add_lead'); });
    Route::get('crm/tour/edit_lead', function () { return view('tour_edit_lead'); });
    Route::get('crm/tour/add_quote', function () { return view('tour_add_quote'); });
    Route::get('crm/tour/add_client', function () { return view('tour_add_client'); });
    Route::get('crm/tour/sending_campaings', function () { return view('tour_sending_campaigns'); });
    Route::get('crm/tour/phases', function () { return view('tour_phases'); });
    Route::get('crm/tour/lead', function () { return view('lead_create_tour'); });
    Route::get('crm/tour/product', function () { return view('tour_add_product'); });
    Route::get('crm/tour/user', function () { return view('tour_delete_user'); });
    Route::get('crm/tour/configuration', function () { return view('tour_configuration'); });
    Route::get('crm/tour/first_steps', function () { return view('tour_first_steps'); });
    Route::get('crm/tour/menu_management', function () { return view('tour_menu_management'); });
    Route::get('crm/tour/configuration_privileges', function () { return view('tour_privileges_configuration'); });
    Route::get('crm/tour/proyects_management', function () { return view('tour_proyects_management'); });

    /*Permite deshabilitar el envío de emails a los Leads*/
    Route::get('unsubscribed/account/{email}', function () {
        $email = request('email');

        //Poner el lead como "No Suscrito" y poner el tipo como "Lost"
        DB::table('account')->where('email','LIKE','%'.$email.'%')->update(['unsuscribed' => 1, 'estado' => 3]);

        //Mandar email al lead "No suscrito" como confirmación
        //Send Email with notification End Step
        $html = trans('crudbooster.email_unsuscribed');
        $subject = trans('crudbooster.email_unsuscribed');

        \Mail::send("crudbooster::emails.blank", ['content' => $html], function ($message) use ($email, $subject) {
            $message->priority(1);
            $message->to($email);
            $message->subject($subject);
        });

        return view('tour_default');
    });

    /*Permite confirmar la entrega a tiempo o no*/
    Route::get('deliveryontime/{quote}/{valor}/{step_id}', function () {
        $orders_id = request('quote');
        $valor = request('valor');
        $step_id = request('step_id');

        $quote = DB::table('user_trucks')->where('id', $orders_id)->first();

        if (count($quote) != 0) {
            if ($valor == 1) {
                DB::table('fases')->where('id',$step_id)->update(['name' => 'Delivery On Time', 'updated_at' => null]);

                $html = trans('crudbooster.text_steps_confirm_1')." <br><br> ".trans("crudbooster.Business_Name").": $quote->truck_name
            &nbsp; <a href='http://ezcrm.us/crm/orders/edit/$orders_id'>".trans("crudbooster.text_details_here")."</a>";
            } else {
                DB::table('fases')->where('id',$step_id)->update(['name' => 'Delivery Out Date', 'updated_at' => null, ]);

                $html = trans('crudbooster.text_steps_confirm_0')." <br><br> ".trans("crudbooster.Business_Name").": $quote->truck_name
            &nbsp; <a href='http://ezcrm.us/crm/orders/edit/$orders_id'>".trans("crudbooster.text_details_here")."</a>";
            }

            DB::table('user_trucks')->where('id',$orders_id)->update(['fases_id' => $step_id]);

            //Mandar email como confirmación de la acción seleccionada
            $subject = trans('crudbooster.text_steps_confirm_subject');
            $email = DB::table('project_accounts')->first();
            $email = $email->production_manager;

            \Mail::send("crudbooster::emails.blank", ['content' => $html], function ($message) use ($email, $subject) {
                $message->priority(1);
                $message->to($email);
                $message->subject($subject);
            });

            $description = '';
            if ($valor == 1) {
                $description = 'The account: '.$email.' has confirmed that the delivery will take effect on time.';
            } else {
                $description = 'The account: '.$email.' has confirmed that the delivery will take effect out of date.';
            }


            //Adicionar "Recent Activity" del envío de Email
            DB::table('fases_activity')->insert([
                'fases_id'=>$step_id,
                'description'=>$description,
                'orders_id'=>$orders_id,
                'created_at'=>Carbon::now(config('app.timezone'))->toDateTimeString(),
            ]);
        }

        return view('tour_default');
    });

    Route::get('lang/{lang}', function ($lang) {
        session(['lang' => $lang]);
        return \Redirect::back();
    })->where([
        'lang' => 'en|es'
    ]);

    Route::get('/crm/task_calendar', function () {
        $events = [];
        $data = \App\EazyTask::all();
        $color = '#000';

        $user_id = (CRUDBooster::myId());

        if($data->count()) {
            foreach ($data as $key => $value) {

                // Obtener el color del tipo de tarea a la q pertenece dicha tarea
                $color = \Illuminate\Support\Facades\DB::table('eazy_task_type')
                    ->select(DB::raw('colors.description'))
                    ->join('eazy_tasks', 'eazy_tasks.task_type_id', '=', 'eazy_task_type.id')
                    ->join('colors', 'colors.id', '=', 'eazy_task_type.colors_id')
                    ->where('eazy_tasks.id', '=', $value->task_type_id)
                    ->first();

                $events[] = \MaddHatter\LaravelFullcalendar\Facades\Calendar::event(
                    $value->name.' ('.$value->description.')',
                    true,
                    new \DateTime($value->date),
                    new \DateTime($value->created_at.' +1 day'),
                    false,
                    // Add color and link on event
                    [
                        'color' => $color->description,
                        'url' => 'http://ezcrm.us/crm/eazy_tasks/detail/'.$value->id,
                    ]
                );
            }
        }

        $calendar = \MaddHatter\LaravelFullcalendar\Facades\Calendar::addEvents($events)->setOptions([
            'header' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'month,agendaWeek,agendaDay,listMonth',
            ],
            'eventLimit' => true,
        ]);

        $taskTypes = \Illuminate\Support\Facades\DB::table('eazy_task_type')
            ->select(\Illuminate\Support\Facades\DB::raw('eazy_task_type.name'), 'colors.name as color')
            ->join('colors', 'colors.id', '=', 'eazy_task_type.colors_id')
            ->get();

        return view('calendar.calendar', compact('calendar', 'taskTypes'));
    });

    Route::get('/profits', function () {

        //UPDATE user_trucks SET profits = 0 where id >= 0;
        $quotes = DB::table('user_trucks')->get();
		
        for ($i=1100; $i>500; $i--) {
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

    });

    Route::get('/proyects', function () {

        for ($i=1870; $i>1700; $i--) {
            $proyect = DB::table('proyects')->where('orders_id', $i)->first();
            $quote = DB::table('user_trucks')->where('id', $i)->where('is_active', 0)->first();
            $lead = DB::table('account')->where('id', $quote->id_account)->first();

            if (count($quote) != 0) {
                //Si existe la quote busco las fases asociadas
                $fases= DB::table('fases')->where('orders_id', $quote->id)->orderby('id', 'asc')->get();

                if (count($fases) == 0) {
                    $sumarizedDataProyect = [
                        'name' => $quote->truck_name,
                        'customers_id' => $lead->id,
                        'interesting' => $quote->interesting,
                        'fases_type_id' => 0,
                        'fases_id' => 0,
                        'datetime' => Carbon::now(config('app.timezone')),
                        'cms_users_id' => $lead->id_usuario,
                        'orders_id' => $i,
                    ];
                    DB::table('proyects')->insert($sumarizedDataProyect);
                }
                else {
                    $stepActual = 0;
                    $faseIdActual = 0;
                    $fechaActual = Carbon::now(config('app.timezone'));
                    $stepActualName = '';
                    foreach ($fases as $item) {
                        if(empty($item->name) || empty($item->notes) || empty($item->email) || empty($item->datetime) || empty($item->cms_users_id)) {
                            $stepActual = $item->fases_type_id;
                            $faseIdActual = $item->id;
                            $stepActualName = $item->name;
                            break;
                        }
                        $fechaActual = $item->datetime;
                    }

                    $sumarizedDataProyect = [
                        'name' => $quote->truck_name,
                        'customers_id' => $lead->id,
                        'interesting' => $quote->interesting,
                        'fases_type_id' => $stepActual,
                        'fases_id' => $faseIdActual,
                        'cms_users_id' => $lead->id_usuario,
                        'datetime' => $fechaActual,
                        'orders_id' => $i,
                    ];
                    DB::table('proyects')->where('orders_id', $i)->insert($sumarizedDataProyect);
                }
            }
        }

    });

    Route::get('/quotes', function () {
        \Illuminate\Support\Facades\DB::beginTransaction();

            /*$query = \Illuminate\Support\Facades\DB::select( DB::raw("
                            UPDATE account SET quotes = 0 where id >= 0;                                            
                            ")
            );*/

            $result = \Illuminate\Support\Facades\DB::select( DB::raw("
                        SELECT count(id) as cant, id_account
                        FROM user_trucks 
                        WHERE is_active = 0
                        GROUP BY id_account                                            
                        ")
            );

            \Illuminate\Support\Facades\DB::commit();

        for ($i=count($result); $i>count($result)-51; $i--) {
            $q = DB::table('account')->where('id', $result[$i]->id_account)->first();

            if ($q != null) {
                DB::table('account')->where('id', $result[$i]->id_account)->update(['quotes' => $result[$i]->cant]);
            }
        }

    });

    Route::get('/notes', function () {

        for ($i=29; $i>1; $i--) {
            $q = DB::table('eazy_notes')->where('id', $i)->first();

            if ($q != null) {
                DB::table('account')->where('id', $q->customers_id)->update(['notes'=>'Yes']);
            }
        }

        for ($i=29; $i>1; $i--) {
            $q = DB::table('eazy_notes')->where('id', $i)->first();

            if ($q != null) {
                DB::table('clients')->where('id', $q->customers_id)->update(['notes'=>'Yes']);
            }
        }
    });

    //Route::get('/admin/wizard/statistics', function () {
    Route::get('/crm/wizard', function () {

        $leads = \Illuminate\Support\Facades\DB::table('account')
            ->select(\Illuminate\Support\Facades\DB::raw('count(*) as ammount'), 'account.estado as customer_types')
            ->groupBy('account.estado')
            ->get();

        $quoteTypes = \Illuminate\Support\Facades\DB::table('user_trucks')
            ->select(\Illuminate\Support\Facades\DB::raw('count(*) as ammount'), 'user_trucks.interesting as products_types')
            ->groupBy('user_trucks.interesting')
            ->get();

        /*$invoices = \Illuminate\Support\Facades\DB::table('invoice')
            ->select(\Illuminate\Support\Facades\DB::raw('count(*) as ammount'), 'invoice.invoice_date as invoice_date')
            ->groupBy('invoice.invoice_date')
            ->get();*/

        $invoices = \Illuminate\Support\Facades\DB::table('invoice')
            ->get();

        $quotes = \Illuminate\Support\Facades\DB::table('user_trucks')
            ->where('user_trucks.is_active', 0)
            ->get();

        /*$quoteSellers = \Illuminate\Support\Facades\DB::table('orders')
            ->select('cms_users.fullname', 'orders.created_at')
            ->join('cms_users', 'cms_users.id', '=', 'orders.cms_users_id')
            ->groupBy('cms_users.fullname', 'orders.created_at')
            ->get();

        $seller = [];
        foreach ($quoteSellers as $value) {
            if ($value->fullname != null) {
                if (!(key_exists($value->fullname, $seller))) {
                    $seller[$value->fullname][0] = 0;
                    $seller[$value->fullname][1] = 0;
                    $seller[$value->fullname][2] = 0;
                    $seller[$value->fullname][3] = 0;
                    $seller[$value->fullname][4] = 0;
                    $seller[$value->fullname][5] = 0;
                    $seller[$value->fullname][6] = 0;
                    $seller[$value->fullname][7] = 0;
                    $seller[$value->fullname][8] = 0;
                    $seller[$value->fullname][9] = 0;
                    $seller[$value->fullname][10] = 0;
                    $seller[$value->fullname][11] = 0;

                    if(!empty($value->created_at)) {
                        $date = \Carbon\Carbon::createFromFormat('Y-m-d', $value->created_at);
                        $seller[$value->fullname][$date->month-1] ++;
                    }
                } else {
                    if(!empty($value->created_at)) {
                        $date = \Carbon\Carbon::createFromFormat('Y-m-d', $value->created_at);
                        $seller[$value->fullname][$date->month-1] ++;
                    }
                }
            }
        }

        $sellers = array_keys($seller);

        foreach ($seller as $item) {
            foreach ($sellers as $value) {
                if (key_exists($value, $seller)) {
                    $sellersKey[$item] = '';
                }
            }
        }

        dd($sellersKey);

        foreach ($seller as $item) {
            dd(array_keys($item));

            //$data['sales_2017'] = $data['sales_2017'] .$month['2017']. ",";
        }*/


        $monthTexts =  ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        $months = [];
        $months['January']['2017'] = 0;
        $months['February']['2017'] = 0;
        $months['March']['2017'] = 0;
        $months['April']['2017'] = 0;
        $months['May']['2017'] = 0;
        $months['June']['2017'] = 0;
        $months['July']['2017'] = 0;
        $months['August']['2017'] = 0;
        $months['September']['2017'] = 0;
        $months['October']['2017'] = 0;
        $months['November']['2017'] = 0;
        $months['December']['2017'] = 0;

        $months['January']['2018'] = 0;
        $months['February']['2018'] = 0;
        $months['March']['2018'] = 0;
        $months['April']['2018'] = 0;
        $months['May']['2018'] = 0;
        $months['June']['2018'] = 0;
        $months['July']['2018'] = 0;
        $months['August']['2018'] = 0;
        $months['September']['2018'] = 0;
        $months['October']['2018'] = 0;
        $months['November']['2018'] = 0;
        $months['December']['2018'] = 0;

        $monthsQuotes = [];
        $monthsQuotes['January']['2017'] = 0;
        $monthsQuotes['February']['2017'] = 0;
        $monthsQuotes['March']['2017'] = 0;
        $monthsQuotes['April']['2017'] = 0;
        $monthsQuotes['May']['2017'] = 0;
        $monthsQuotes['June']['2017'] = 0;
        $monthsQuotes['July']['2017'] = 0;
        $monthsQuotes['August']['2017'] = 0;
        $monthsQuotes['September']['2017'] = 0;
        $monthsQuotes['October']['2017'] = 0;
        $monthsQuotes['November']['2017'] = 0;
        $monthsQuotes['December']['2017'] = 0;

        $monthsQuotes['January']['2018'] = 0;
        $monthsQuotes['February']['2018'] = 0;
        $monthsQuotes['March']['2018'] = 0;
        $monthsQuotes['April']['2018'] = 0;
        $monthsQuotes['May']['2018'] = 0;
        $monthsQuotes['June']['2018'] = 0;
        $monthsQuotes['July']['2018'] = 0;
        $monthsQuotes['August']['2018'] = 0;
        $monthsQuotes['September']['2018'] = 0;
        $monthsQuotes['October']['2018'] = 0;
        $monthsQuotes['November']['2018'] = 0;
        $monthsQuotes['December']['2018'] = 0;

        foreach ($invoices as $invoice) {
            $date = \Carbon\Carbon::createFromFormat('Y-m-d', $invoice->invoice_date);

            if (!empty($months[$monthTexts[$date->month-1]][$date->year])) {
                $months[$monthTexts[$date->month-1]][$date->year] ++;
            }
            else {
                $months[$monthTexts[$date->month-1]][$date->year] = 1;
            }
        }

        foreach ($quotes as $quote) {
            if(!empty($quote->truck_date_created)) {
                $date = \Carbon\Carbon::createFromFormat('Y-m-d', $quote->truck_date_created);

                if (!empty($monthsQuotes[$monthTexts[$date->month-1]][$date->year])) {
                    $monthsQuotes[$monthTexts[$date->month-1]][$date->year] ++;
                }
                else {
                    $monthsQuotes[$monthTexts[$date->month-1]][$date->year] = 1;
                }
            }
        }

        $data = [];

        $data['sales_2017'] = '';
        $data['sales_2018'] = '';
        foreach ($months as $month) {
            $data['sales_2017'] = $data['sales_2017'] .$month['2017']. ",";
            $data['sales_2018'] = $data['sales_2018'] .$month['2018']. ",";
        }

        $data['customer_type_data'] = '';
        foreach ($leads as $value) {
            $data['customer_type_data'] = $data['customer_type_data'] .$value->ammount. ",";
        }

        $data['quote_type_data'] = '';
        foreach ($quoteTypes as $value) {
            $data['quote_type_data'] = $data['quote_type_data'] .$value->ammount. ",";
        }

        $data['quote_type_data'] = explode(',',$data['quote_type_data']);
        $data['quote_type_data'] = $data['quote_type_data'][2].','.$data['quote_type_data'][3].','.$data['quote_type_data'][4].',';

        $data['quotes_2017'] = '';
        $data['quotes_2018'] = '';
        foreach ($monthsQuotes as $month) {
            $data['quotes_2017'] = $data['quotes_2017'] .$month['2017']. ",";
            $data['quotes_2018'] = $data['quotes_2018'] .$month['2018']. ",";
        }

        return view('statistics/index', compact('data'));
    });


});

