<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StackRequest;
use App\Models\Stack;
use Illuminate\Http\Request;

class StackController extends Controller
{
    public function index()
    {
        $stacks = Stack::all();
        if ($stacks)
        {
            return response()->json(['success'=>true,'message'=>$stacks]);
        }else
        {
            return response()->json(['success'=>false,'message'=>"Some thing went wrong..."],204);

        }

    }
    public function createStack(StackRequest $stackRequest)

    {
        $stack = Stack::create($stackRequest->all());
        if ($stack)
        {
            return response()->json(['success'=>true,'message'=>$stack->name." created successfully"]);
        }else
        {
            return response()->json(['success'=>false,'message'=>"Some thing went wrong..."],200);

        }

    }
    public function editStack(Request $request,$id)
    {
        $stack = Stack::find($id)->firstOrFail();
        if ($stack)
        {
            return response()->json(['success'=>true,'stack'=>$stack]);
        }else
        {
            return response()->json(['success'=>false,'message'=>"Some thing went wrong..."],200);

        }
    }
    public function updateStack(StackRequest $stackRequest,$id)
    {
        $stack = Stack::find($id)->firstOrFail();
        $stack->update($stackRequest->all());
        if ($stack)
        {
            return response()->json(['success'=>true,'stack'=>$stack->name." updated successfully"]);
        }else
        {
            return response()->json(['success'=>false,'message'=>"Some thing went wrong..."],200);

        }
    }
    public function deleteStack(Request $request , $id)
    {
        $stack = Stack::find($id)->firstOrFail();
        $stack->delete();
        if ($stack)
        {
            return response()->json(['success'=>true,'stack'=>$stack->name." Deleted successfully"]);
        }else
        {
            return response()->json(['success'=>false,'message'=>"Some thing went wrong..."],200);

        }
    }

}
