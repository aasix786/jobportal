<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeveloperController extends Controller
{

    public function editDeveloper(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $developer = $user->developer()->firstOrFail();
            return response()->json(['success' => true, 'developer' => $developer]);
        } else {
            return response()->json(['success' => false, 'message' => 'Unauthenticated Request']);
        }

    }

    public function updateDeveloper(Request $request, $id)
    {
        $developer = Developer::find($id)->firstOrFail();
        if ($developer) {

            if ($request['photo']) {
                $file = $request['photo'];
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('public/image'), $filename);
                $request['image'] = '/public/image/' . $filename;
            }
            $developer->update($request->all());
            return response()->json(['success' => true, 'message' => 'Developer updated successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Some thing went wrong!...']);
        }
    }

    public function createDeveloperSkills(Request $request, $id)
    {

        if (Developer::where('id', $id)->exists()) {
            $developerId = Developer::where('id', $id)->firstOrFail();
            $developerSkills = $developerId->skills()->sync(json_decode($request['skills']));
            if ($developerSkills) {
                return response()->json(['success' => true, 'message' => 'Developer skills created successfully'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Issue in creating developer skills'], 204);

            }
        } else {
            return 'something went wrong...';
        }
    }

    public function developerSkills(Request $request, $id)
    {
        if (Developer::where('id', $id)->exists()) {
            $developerId = Developer::where('id', $id)->firstOrFail();
            $developerSkills = $developerId->skills;
            if ($developerSkills) {

                $skills = [];
                return response()->json(['success' => true, 'skills' => $developerSkills], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Issue in fetching developer skills'], 204);

            }
        } else {
            return 'something went wrong...';
        }
    }

    public function createDeveloperStacks(Request $request, $id)
    {
        if (Developer::where('id', $id)->exists()) {
            $developerId = Developer::where('id', $id)->firstOrFail();
            $developerStacks = $developerId->stacks()->sync(json_decode($request['stacks']));
            if ($developerStacks) {
                return response()->json(['success' => true, 'message' => 'Developer stacks created successfully'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Issue in creating developer stacks'], 204);

            }
        } else {
            return 'something went wrong...';
        }
    }

    public function assignDeveloperProject(Request $request, $id)
    {
        if (Developer::where('id', $id)->exists()) {
            $developerId = Developer::where('id', $id)->firstOrFail();
            $developerProjects = $developerId->projects()->syncWithoutDetaching(json_decode($request['projects']));
            if ($developerProjects) {
                // dd($developerId->projects());
                foreach ($developerId->projects as $project) {
                    $project->status = "assigned";
                    $project->save();
                }
                return response()->json(['success' => true, 'message' => 'Project assigned successfully'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Issue in assigning project to developer stacks'], 204);

            }
        } else {
            return 'something went wrong...';
        }
    }
}
