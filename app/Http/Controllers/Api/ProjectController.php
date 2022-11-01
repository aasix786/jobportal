<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProjectFilesRequest;
use App\Http\Requests\Api\ProjectRequest;
use App\Http\Requests\Api\ProjectStacksRequest;
use App\Models\Project;
use App\Models\ProjectFile;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function createProject(ProjectRequest $request)
    {
        $project = Project::create($request->all());
        if ($project) {
            // saving project files
            if ($request['files'] != '') {

                foreach ($request['files'] as $file) {
                    $projectFiles = new ProjectFile();
                    $name = time() . rand(1, 100) . '.' . $file->extension();
                    $file->move(public_path('/project/files/'), $name);
                    $projectFiles->project_id = $project->id;
                    $projectFiles->file = '/public/project/files/' . $name;
                    $projectFiles->save();
                }
                if ($projectFiles) {
                    // return response()->json(['success' => true, 'message' => 'Project files created successfully']);
                } else {
                    return response()->json(['success' => true, 'message' => 'some thing went wrong...']);
                }

            } // ending project files
            // starting project stacks
            if ($request->stacks != '') {
                $projectStacks = $project->stacks()->sync(json_decode($request['stacks']));
                if ($projectStacks) {
                    //  return response()->json(['success' => true, 'message' => 'Project stacks created successfully'], 200);
                } else {
                    return response()->json(['success' => false, 'message' => 'Issue in creating project stacks'], 204);

                }

            }// ending stacks
            return response()->json(['success' => true, 'message' => $project->name . ' created successfully']);
        } else {
            return response()->json(['success' => true, 'message' => 'some thing went wrong...']);
        }
    }

    public function projectFiles(ProjectFilesRequest $request, $id)
    {
        if (Project::where('id', $id)->exists()) {
            $project = Project::where('id', $id)->firstOrFail();
            if ($request['files'] != '') {

                foreach ($request['files'] as $file) {
                    $projectFiles = new ProjectFile();
                    $name = time() . rand(1, 100) . '.' . $file->extension();
                    $file->move(public_path('/project/files/'), $name);
                    $projectFiles->project_id = $project->id;
                    $projectFiles->file = '/public/project/files/' . $name;
                    $projectFiles->save();
                }
                if ($projectFiles) {
                    return response()->json(['success' => true, 'message' => 'Project files created successfully']);
                } else {
                    return response()->json(['success' => true, 'message' => 'some thing went wrong...']);
                }

            }


        }
    }

    public function projectStacks(ProjectStacksRequest $request, $id)
    {
        if (Project::where('id', $id)->exists()) {
            $projectId = Project::where('id', $id)->firstOrFail();
            $projectStacks = $projectId->stacks()->sync(json_decode($request['stacks']));
            if ($projectStacks) {
                return response()->json(['success' => true, 'message' => 'Project stacks created successfully'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Issue in creating project stacks'], 204);

            }
        } else {
            return 'something went wrong...';
        }
    }

    public function project(Request $request,$id)
    {
        if(Project::where('id',$id)->exists())
        {
            $project = Project::where('id',$id)->firstOrFail();
            $project['stacks'] = $project->stacks()->get();
            $project['files'] = $project->projectFiles()->get();
           return response()->json(['success'=>true,'project'=>$project]);
        }else
        {
            return response()->json(['success'=>false,'project'=>"Project not found in our database"]);

        }

    }
    public function index()
    {
        $projects = Project::all();
        if($projects)
        {
            $projects = Project::all();
            $data=[];
            foreach ($projects as $project)
            {
                $project['stacks'] = $project->stacks()->get();
                $project['files'] = $project->projectFiles()->get();
                array_push($data,$project);
            }

            return response()->json(['success'=>true,'project'=>$projects]);
        }else
        {
            return response()->json(['success'=>false,'project'=>"Project not found in our database"]);

        }
    }

    public function deleteProject(Request $request,$id)
    {
        if(Project::where('id',$id)->exists())
        {
            $project = Project::where('id',$id)->firstOrFail();
            $project->status = 'deleted';
            $project->save();
            return response()->json(['success'=>true,'project'=>$project->name.' deleted successfully']);
        }else
        {
            return response()->json(['success'=>false,'project'=>"Project not found in our database"]);

        }
    }

    public function updateProject(Request $request, $id)
    {

    }
}
