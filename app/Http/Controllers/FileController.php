<?php


namespace App\Http\Controllers;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use CRUDBooster;


class FileController extends Controller

{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'filename.*' => 'mimes:jpg,png,jpeg,gif,bmp,pdf,xls,xlsx,doc,docx,txt,zip,rar,7z'
        ]);

        if($request->hasfile('filename'))
        {
            $data = '';
            $cont = 0;
            foreach($request->file('filename') as $file)
            {
                //$name=$file->getClientOriginalName();
                $name = strtolower(time().$cont. '.' . $file->getClientOriginalExtension());
                $cont ++;
                $file->move(public_path().'/files/', $name);

                if ($data == '') {
                    $data = $name;
                }
                else {
                    $data = $data.';'.$name;
                }
            }
        }

        //Guardar información de Archivos en Base de Datos
        $sumarizedData = [
            'files' => $data,
            'updated_at' => Carbon::now(config('app.timezone')),
        ];

        DB::table('fases')->where('id',request('fases_id'))->update($sumarizedData);

        $fase = DB::table('fases')->where('id',request('fases_id'))->first();
        $userLogin = CRUDBooster::myName();

        if ($cont != 0) {
            //Crear "Recent Activity" del envío de Email
            DB::table('fases_activity')->insert([
                'fases_id'=>request('fases_id'),
                'description'=>$cont.' file(s) has been uploaded by: '.$userLogin,
                'orders_id'=>$fase->orders_id,
                'created_at'=>Carbon::now(config('app.timezone'))->toDateTimeString(),
            ]);
        }

        return back()->with('success', 'Your files has been successfully added');
    }



}