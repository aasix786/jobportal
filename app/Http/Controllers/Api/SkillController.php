<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SkillRequest;
use App\Models\Skill;

use Illuminate\Http\Request;

class SkillController extends Controller
{

    public function index()
    {
        $skills = Skill::all();
        if ($skills)
        {
            return response()->json(['success'=>true,'skills'=>$skills]);
        }else
        {
            return response()->json(['success'=>false,'message'=>"Some thing went wrong..."],200);

        }
    }

    public function createSkill(SkillRequest $skillRequest)
    {
        $skill = Skill::create($skillRequest->all());
        if ($skill)
        {
            return response()->json(['success'=>true,'skills'=>$skill->name .' created successfully']);
        }else
        {
            return response()->json(['success'=>false,'message'=>"Some thing went wrong..."],200);
        }
    }
    public function editSkill(Request $request,$id)
    {
        $skill = Skill::find($id)->firstOrFail();
        if ($skill)
        {
            return response()->json(['success'=>true,'skill'=>$skill]);
        }else
        {
            return response()->json(['success'=>false,'message'=>"Some thing went wrong..."],200);
        }

    }
    public function updateSkill(SkillRequest $skillRequest,$id)
    {
      $skill = Skill::find($id)->firstOrFail();

        if ($skill)
        {
            $skill->update($skillRequest->all());
            return response()->json(['success'=>true,'skill'=>$skill->name.' updated successfully']);
        }else
        {
            return response()->json(['success'=>false,'message'=>"Some thing went wrong..."],200);
        }
    }

    public function deleteSkill(Request $request , $id)
    {
        $skill = Skill::find($id)->firstOrFail();

        if ($skill)
        {
            $skill->delete();
            return response()->json(['success'=>true,'skill'=>$skill->name.' updated successfully']);
        }else
        {
            return response()->json(['success'=>false,'message'=>"Some thing went wrong..."],200);
        }

    }

}
