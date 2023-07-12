<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File; //add File Model

class UploadController extends Controller
{
    public function index(){

        $files = File::all();
        return view('app.fileupload.upload')->with('files', $files);
    }

    public function store(Request $request){

        $messages = [
            'required' => 'Please select file to upload',
        ];

        $this->validate($request, [
            'file' => 'required',
        ], $messages);

        foreach ($request->file as $file) {
            $filename = time().'_'.$file->getClientOriginalName();
            $filesize = $file->getSize();
            $file->storeAs('public/',$filename);
            $fileModel = new File;
            $fileModel->name = $filename;
            $fileModel->size = $filesize;
            $fileModel->location = 'storage/'.$filename;
            $fileModel->save();
        }

        return redirect('/')->with('success', 'File/s Uploaded Successfully');
    }
}
