<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;


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
        request()->validate([
            'image' => 'required|file|mimes:jpg,png,jpeg,gif,bmp,pdf,xls,xlsx,doc,docx,txt,zip,rar,7z',
        ]);

        $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $imageName);

        return back()
            ->with('success', 'You have successfully upload file.')
            ->with('image', $imageName);
    }
}