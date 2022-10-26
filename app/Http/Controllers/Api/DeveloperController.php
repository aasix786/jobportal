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
        $user      = Auth::user();
        if($user)
        {
            $developer =  $user->developer()->firstOrFail();
            return response()->json(['success' => true, 'developer' => $developer]);
        }else
        {
            return response()->json(['success' => false, 'message' => 'Unauthenticated Request']);
        }

    }

    public function updateDeveloper(Request $request, $id)
    {
       /* if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/Image'), $filename);
            $data['image']= $filename;
        }*/
        $developer = Developer::find($id)->firstOrFail();
        if ($developer) {
            $developer->update($request->all());
            return response()->json(['success' => true, 'message' => 'Developer updated successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Some thing went wrong!...']);
        }
    }
}
