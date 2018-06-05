<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class reminderLeads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendEmail:ReminderLeads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía email a prospectos que no han recibido campañas en al menos 1 mes';

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
        //fecha de hoy
        $today = Carbon::now(config('app.timezone'));

        $leads = DB::table('account')
            ->where('account.estado', '!=', 2)
            ->where('account.estado', '!=', 3)
            ->get();

        $cont = 0;
        $cont2 = 0;
        foreach ($leads as $lead) {
            //Gestiona el envío automático de emails a los prospectos que no han recibido emails en el último mes
            $query =  DB::table('account')
                ->select(\Illuminate\Support\Facades\DB::raw('account.email as email'), 'campaigns.created_at as date', 'account.id as id')
                ->join('campaigns_leads', 'campaigns_leads.leads_id', '=', 'account.id')
                ->join('campaigns', 'campaigns.id', '=', 'campaigns_leads.campaigns_id')
                ->groupBy('id', 'date', 'email')
                ->orderBy('date','desc')
                ->where('account.id', $lead->id)
                ->get();

            //Si se le ha enviado al menos un email
            if(count($query) != 0) {
                $query = $query[0];
                $date = Carbon::createFromFormat("Y-m-d", $query->date);

                //Comprobar cantidad de días desde la fecha actual
                if($today->diffInDays($date) >= 30) {
                    $cont++;
                }
            }
            //Si no se le ha enviado un email
            else {
                $cont2++;
            }

        }


    }
}
