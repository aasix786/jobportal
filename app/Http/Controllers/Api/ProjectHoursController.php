<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\ProjectHour;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectHoursController extends Controller
{

    public function developerCheckin(Request $request,$id)
    {
        $userId = Auth::user();
        $developer = $userId->developer;
        if($userId->role=='developer')
        {
          $startDateTime = Carbon::now();
          $request['start']= $startDateTime->toDateTimeString();
            $request['developer_id'] =$developer->id;
         $developerCheckIn = new ProjectHour();
            $developerCheckIn->time = $request['time'];
            $developerCheckIn->project_id = $id;
            $developerCheckIn->developer_id = $request['developer_id'];
           $developerCheckIn->save();
         if($developerCheckIn)
         {
             return response()->json(['success'=>true,'message'=>'developer started working on project']);
         }

        }
        else
        {
            return response()->json(['success'=>false,'message'=>'Please login as developer']);
        }
    }

    public function developerBreak(Request $request,$id)
    {
        $userId = Auth::user();
        $developer = $userId->developer;
        if($userId->role=='developer')
        {
            $startDateTime = Carbon::now();
            $breakStart= $startDateTime->toDateTimeString();
            $request['developer_id'] =$developer->id;
            $developerBreak = new ProjectHour();
            $developerBreak->break_start = $breakStart;
            $developerBreak->project_id = $id;
            $developerBreak->developer_id = $request['developer_id'];
            $developerBreak->save();
            if($developerBreak)
            {
                return response()->json(['success'=>true,'message'=>'developer is on break']);
            }
        }
        else
        {
            return response()->json(['success'=>false,'message'=>'Please login as developer']);
        }
    }

    public function developerCheckout(Request $request,$id)
    {
        $userId = Auth::user();
        $developer = $userId->developer;
        if($userId->role=='developer')
        {
            $startDateTime = Carbon::now();
            $request['time']= $startDateTime->toDateTimeString();
            $request['developer_id'] =$developer->id;
            $developerCeckout = new ProjectHour();
            $developerCeckout->time = $request['time'];
            $developerCeckout->type = "checkout";
            $developerCeckout->project_id = $id;
            $developerCeckout->developer_id = $request['developer_id'];
            $developerCeckout->save();
            if($developerCeckout)
            {
                return response()->json(['success'=>true,'message'=>'developer checkout']);
            }
        }
        else
        {
            return response()->json(['success'=>false,'message'=>'some issue in developer checkout']);
        }
    }
    public function developerDaliyHours(Request $request)
    {
       $developerId = $request['developer_id'];
       $projectId = $request['project_id'];

       if(ProjectHour::where(['developer_id'=>$request['developer_id'],'project_id'=>$request['project_id']])->exists())
       {
           $projectHours = ProjectHour::where(['developer_id'=>$request['developer_id'],'project_id'=>$request['project_id']])->get();

           $start =[];
           $break =[];
           foreach ($projectHours as $projectHour)
           {
                if($projectHour->start)
                {
                    $start +=$projectHour->start;
                    array_push($start,$start);
                }
           }
           dd($start);
       }

       else
       {
         return response()->json(['success'=>false,'message'=>"sorry record doesn't "]);
       }


       dd($developerData);
          // $projectId=
    }


}
