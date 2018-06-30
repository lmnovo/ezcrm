<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use Request;
use CRUDBooster;

class mailsApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendEmail:MailsApp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa la tabla "mail" y los que no tengan el estado "Send" lo envía';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Obtener los email que no tengan el estado "Send"
        $emails = DB::table('mails')->where('estado','!=','Send')->get();
        //$emails = DB::table('mails')->where('id',177)->get();

        foreach ($emails as $item) {
            $quote = DB::table('user_trucks')->where('id',$item->id_truck)->first();
            if(count($quote) != 0) {
                $id = $quote->id;

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

                foreach ($toTemp as $itemTo) {
                    //validamos antes de incluir los emails
                    if ($this->validarEmail($itemTo)) {
                        $emails[] = $itemTo;
                    } else {
                        //Error de validación de email
                        DB::table('mails')->where('id', $item->id)->update(
                            [   'estado'=>'Error',
                                'date_send'=>Carbon::now(config('app.timezone')),
                                'message'=>'You must provide at least one recipient email address.'
                            ]
                        );
                        $emailsFailed[] = $itemTo;
                    }
                }

                if(count($emails) != 0) {
                    $account_query = DB::table('account')->where('account.email', $emails[0])->first();
                    $quote_query = DB::table('user_trucks')->where('id_account', $account_query->id)->get();

                    foreach ($quote_query as $quote_item) {
                        if ($quote_item->id == $item->id_truck) {
                            DB::table('mails')->where('id', $item->id)->update(
                                [   'estado'=>'Send',
                                    'date_send'=>Carbon::now(config('app.timezone')),
                                    'message'=>null
                                ]
                            );

                            //Send Email with notification End Step
                            \Mail::send("crudbooster::emails.blank", ['content' => $html], function ($message) use ($to, $subject, $emails) {
                                $message->priority(1);
                                $message->to($emails);

                                $message->subject($subject);
                            });

                            print_r('Sending Emails...');

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

                            //CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('crudbooster.email_send_text'), "success");
                        }
                    }

                } else {
                    //CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('crudbooster.email_send_text_error'), "warning");
                }

            } //Si no existe la Quote
            else {
                DB::table('mails')->where('id', $item->id)->update(
                    ['estado'=>'Error',
                        'date_send'=>Carbon::now(config('app.timezone')),
                        'message'=>'The Quote doesn\'t exist'
                    ]
                );
            }
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
}
