<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


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

        foreach ($emails as $item) {
            $quote = DB::table('user_trucks')->where('id',$item->id_truck)->first();

            if(count($quote) != 0) {
                dd($quote);
            }
        }

    }
}
