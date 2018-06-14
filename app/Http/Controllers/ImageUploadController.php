<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ImageUploadController extends Controller

{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function imageUpload()
    {
        return view('imageUpload');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function imageUploadPost()
    {
        $maxId = DB::table('appliance_inside_category')->select(\Illuminate\Support\Facades\DB::raw('MAX(id) as id'))->first();
        $maxId = $maxId->id + 1;

        $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('assets/images/appliances'), $imageName);

        $sumarizedData = [
            'id' => $maxId,
            'id_appliance_inside' => request('product_new'),
            'name' => request('appliance_inside_category_new'),
            'price' => request('price2_new'),
            'retail_price' => request('price2_retail_new'),
            'description' => request('description_new'),
            'imagen' => $imageName,
            'weight' => request('weight_new')
        ];

        DB::table('appliance_inside_category')->insert($sumarizedData);

        request()->validate([
            'image' => 'required|file|mimes:jpg,png,jpeg,gif,bmp,pdf,xls,xlsx,doc,docx,txt,zip,rar,7z',
        ]);

        return back()
            ->with('success', 'You have successfully upload file.')
            ->with('image', $imageName);
    }
}