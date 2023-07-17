
                        $file = new File;
                        $origin = $request->input('origin');
                        $project = $request->input('project');
                        $task = $request->input('task');




                        // Get the ID of the newly created contract
                        $idproject =  $project;
                        $idtask =  $task;
                      $idup = $idproject . '/' . $idtask;
                        // Create a new directory for the contract if it doesn't exist
                        $contractDir = public_path('uploads/contracts/' . $idup);
                        if (!file_exists($contractDir)) {
                            mkdir($contractDir, 0755, true);
                        }


                        if($request->hasFile('upload_file')) {
                            foreach ($request->file('upload_file') as $file) {
                                $filename = time().'_'.$file->getClientOriginalName();
                                $filesize = $file->getSize();
                                $file->storeAs('public/',$filename);
                                $file->move($contractDir, $filename);

                                $fileModel = new File;
                                $fileModel->name = $filename;
                                $fileModel->project_id = $idproject;
                                $fileModel->task_id = $idtask;
                                $fileModel->size = $filesize;
                                $fileModel->location = 'uploads/contracts/' . $idup . '/' . $filename;
                                $fileModel->save();
                            }