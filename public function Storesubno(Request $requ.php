 public function Storesubno(Request $request)
    {
        // Create a new Project object
        $project = new Project;
        $project->project_name = $request->input('project_name');

        $project->reguiar_id = $request->input('reguiar_id');
        $project->project_fiscal_year = $request->input('project_fiscal_year');
        $project->project_type = $request->input('project_type');

        // Save the Project
        if (!$project->save()) {
            // If the Project failed to save, redirect back with an error message
            return redirect()->back()->withErrors('An error occurred while saving the project. Please try again.');
        }

        // Create a new Taskcon object
        $taskcon = new Taskcon;

        // Fill the Taskcon fields from the request
        $taskcon->fill($request->only(['field1', 'field2', 'field3'])); // replace 'field1', 'field2', 'field3' with the actual fields of Taskcon

        // Assign the project_id to the Taskcon
        $taskcon->project_id = $project->id;

        // Save the Taskcon
        if (!$taskcon->save()) {
            // If the Taskcon failed to save, redirect back with an error message
            return redirect()->back()->withErrors('An error occurred while saving the task. Please try again.');
        }

        // If both the Project and Taskcon saved successfully, redirect to project.index
        return redirect()->route('project.index');
    }
