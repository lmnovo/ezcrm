<?php namespace crocodicstudio\crudbooster\controllers;

use crocodicstudio\crudbooster\controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use CRUDBooster;

class AdminController extends CBController {	

	function getIndex() {

		$dashboard = CRUDBooster::sidebarDashboard();		
		if($dashboard && $dashboard->url) {
			return redirect($dashboard->url);
		}

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
	}

	public function getLockscreen() {
		
		if(!CRUDBooster::myId()) {
			Session::flush();
			return redirect()->route('getLogin')->with('message',trans('crudbooster.alert_session_expired'));
		}
		
		Session::put('admin_lock',1);
		return view('crudbooster::lockscreen');
	}

	public function postUnlockScreen() {
		$id       = CRUDBooster::myId();
		$password = Request::input('password');		
		$users    = DB::table(config('crudbooster.USER_TABLE'))->where('id',$id)->first();		

		if(\Hash::check($password,$users->password)) {
			Session::put('admin_lock',0);	
			return redirect()->route('AdminControllerGetIndex'); 
		}else{
			echo "<script>alert('".trans('crudbooster.alert_password_wrong')."');history.go(-1);</script>";				
		}
	}	

	public function getLogin()
	{											
		return view('crudbooster::login');
	}
 
	public function postLogin() {		

		$validator = Validator::make(Request::all(),			
			[
			'email'=>'required|email|exists:'.config('crudbooster.USER_TABLE'),
			'password'=>'required'			
			]
		);
		
		if ($validator->fails()) 
		{
			$message = $validator->errors()->all();
			return redirect()->back()->with(['message'=>implode(', ',$message),'message_type'=>'danger']);
		}

		$email 		= Request::input("email");
		$password 	= Request::input("password");
		$users 		= DB::table(config('crudbooster.USER_TABLE'))->where("email",$email)->first(); 		

		if(\Hash::check($password,$users->password)) {
			$priv = DB::table("cms_privileges")->where("id",$users->id_cms_privileges)->first();

			$roles = DB::table('cms_privileges_roles')
			->where('id_cms_privileges',$users->id_cms_privileges)
			->join('cms_moduls','cms_moduls.id','=','id_cms_moduls')
			->select('cms_moduls.name','cms_moduls.path','is_visible','is_create','is_read','is_edit','is_delete')
			->get();
			
			$photo = ($users->photo)?asset($users->photo):'https://www.gravatar.com/avatar/'.md5($users->email).'?s=100';
			Session::put('admin_id',$users->id);			
			Session::put('admin_is_superadmin',$priv->is_superadmin);
			Session::put('admin_name',$users->name);	
			Session::put('admin_photo',$photo);
			Session::put('admin_privileges_roles',$roles);
			Session::put("admin_privileges",$users->id_cms_privileges);
			Session::put('admin_privileges_name',$priv->name);			
			Session::put('admin_lock',0);
			Session::put('theme_color',$priv->theme_color);
			Session::put("appname",CRUDBooster::getSetting('appname'));		

			CRUDBooster::insertLog(trans("crudbooster.log_login",['email'=>$users->email,'ip'=>Request::server('REMOTE_ADDR')]));		

			$cb_hook_session = new \App\Http\Controllers\CBHook;
			$cb_hook_session->afterLogin();

			return redirect()->route('AdminControllerGetIndex'); 
		}else{
			return redirect()->route('getLogin')->with('message', trans('crudbooster.alert_password_wrong'));			
		}		
	}

	public function getForgot() {		
		return view('crudbooster::forgot');
	}

	public function postForgot() {
		$validator = Validator::make(Request::all(),
			[
			'email'=>'required|email|exists:'.config('crudbooster.USER_TABLE')			
			]
		);
		
		if ($validator->fails()) 
		{
			$message = $validator->errors()->all();
			return redirect()->back()->with(['message'=>implode(', ',$message),'message_type'=>'danger']);
		}	

		$rand_string = str_random(5);
		$password = \Hash::make($rand_string);

		DB::table(config('crudbooster.USER_TABLE'))->where('email',Request::input('email'))->update(array('password'=>$password));
 	
		$appname = CRUDBooster::getSetting('appname');		
		$user = CRUDBooster::first(config('crudbooster.USER_TABLE'),['email'=>g('email')]);	
		$user->password = $rand_string;

		//CRUDBooster::sendEmail(['to'=>$user->email,'data'=>$user,'template'=>'forgot_password_backend']);

        $to = $user->email;
        $subject = '';
        $html = $user;

        $html = "<p>".trans("crudbooster.text_forgot")."</p>
                        <ul>
                            <li>".trans("crudbooster.name_lastname").": $html->fullname</li>
                            <li>".trans("crudbooster.email").": $html->email</li>
                            <li>".trans("crudbooster.password").":  ".$html->password."</li>
                        </ul>
                        <p>".trans("crudbooster.phase_sign")." Chef Units</p>
                ";

        //Send Email with notification End Step
        \Mail::send("crudbooster::emails.blank",['content'=>$html],function($message) use ($to,$subject) {
            $message->priority(1);
            $message->to($to);

            $message->subject($subject);
        });


		CRUDBooster::insertLog(trans("crudbooster.log_forgot",['email'=>g('email'),'ip'=>Request::server('REMOTE_ADDR')]));

		return redirect()->route('getLogin')->with('message', trans("crudbooster.message_forgot_password"));

	}	

	public function getLogout() {
		
		$me = CRUDBooster::me();
		CRUDBooster::insertLog(trans("crudbooster.log_logout",['email'=>$me->email]));

		Session::flush();
		return redirect()->route('getLogin')->with('message',trans("crudbooster.message_after_logout"));
	}

}
