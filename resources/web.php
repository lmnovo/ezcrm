<?php

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

Route::get('/', function () {
    return view('welcome');
});

//Rutas de Traducciones
Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('tour_general');
    });

    Route::get('crm/tour/general', function () { return view('tour_general'); });
    Route::get('crm/tour/add_lead', function () { return view('tour_add_lead'); });
    Route::get('crm/tour/edit_lead', function () { return view('tour_edit_lead'); });
    Route::get('crm/tour/add_quote', function () { return view('tour_add_quote'); });
    Route::get('crm/tour/add_client', function () { return view('tour_add_client'); });
    Route::get('crm/tour/sending_campaings', function () { return view('tour_sending_campaigns'); });



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
                        'url' => 'http://18.220.213.59/crm/eazy_tasks/detail/'.$value->id,
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


    /*Route::get('/tour', function () {
        dd('asadasd');

    });*/

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
        $data['quote_type_data'] = $data['quote_type_data'][1].','.$data['quote_type_data'][2].','.$data['quote_type_data'][3].',';

        $data['quotes_2017'] = '';
        $data['quotes_2018'] = '';
        foreach ($monthsQuotes as $month) {
            $data['quotes_2017'] = $data['quotes_2017'] .$month['2017']. ",";
            $data['quotes_2018'] = $data['quotes_2018'] .$month['2018']. ",";
        }

        return view('statistics/index', compact('data'));
    });


});

