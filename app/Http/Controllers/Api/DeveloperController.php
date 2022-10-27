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
}
