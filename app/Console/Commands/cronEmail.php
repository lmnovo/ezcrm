<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class cronEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendEmail:HappyBirthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía emails todos los días';

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
        //Gestiona el envío automático de emails a los usuarios que cumplen años de edad
        $happyBirthday_users = DB::table('cms_users')->get();
        $to = [];

        foreach ($happyBirthday_users as $happy) {
            $birthday = $happy->date_birthday;
            $actual_date = Carbon::now(config('app.timezone'));

            if (!empty($birthday)) {
                $birthday = Carbon::createFromFormat("Y-m-d", $birthday);

                //Confirmar si hoy es el cumpleaños del usuario
                if ($birthday->isBirthday()) {
                    $to[] = $happy->email;
                }


                $edad = $actual_date->diffInYears($birthday);
            }
        }

        $template = DB::table('cms_email_templates')->where('slug', 'HappyBirthday')->first();

        $html = $template->content;
        $subject = $template->subject;

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

        echo('Enviado Email de Felicitación a los que cumplen años hoy');
    }
}
