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

        $project_id = $request->input('project_id');
        $task_id = $request->input('task_id');
        $contract_id = $request->input('contract_id');

        $id = $project_id . '/' . $task_id;

 // Create a new directory for the contract if it doesn't exist
 $contractDir = public_path('storage/uploads/contracts/' . $id);
 if (!file_exists($contractDir)) {
     mkdir($contractDir, 0755, true);
 }

 if($request->hasFile('file')) {
        foreach ($request->file as $file) {
            $filename = time().'_'.$file->getClientOriginalName();
            $filesize = $file->getSize();
            $file->storeAs('public/',$filename);
            $file->move($contractDir, $filename);

            $fileModel = new File;
            $fileModel->name = $filename;
            $fileModel->project_id = $project_id;
            $fileModel->task_id = $task_id;
            $fileModel->contract_id = $contract_id;
            $fileModel->size = $filesize;
            $fileModel->location = 'storage/uploads/contracts/' . $id . '/' . $filename;

/*             $fileModel->location = 'storage/'.$filename; */


            $fileModel->save();
        }

       // dd($request);
        return redirect('/')->with('success', 'File/s Uploaded Successfully');
    }
    }


}
