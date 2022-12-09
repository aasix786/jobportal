<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use File;
class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('index');
    }

    public function file(Request $request)
    {
        $requestFile = $request->file('file');
        $file= $requestFile->getClientOriginalName();
        $fileExtension =$request->file('file')->extension();
        $fileName = pathinfo($file,PATHINFO_FILENAME);
        $array= str_split($fileName);
         $length = count($array);
         $path = $path = public_path();

//         if($length >1)
//         {
             $imagePath='';
             foreach ($array as $index=>$folder)
             {
                 $imagePath.= $folder.'/';
                 File::makeDirectory($imagePath, $mode = 0777, true, true);
                 if($index==$length-1)
                 {
                     $dest = $path.'/'.$imagePath;
                     $count = count(glob($dest . '/*' . $file));
                     if($count==1)
                     {
                         $time = Carbon::now();
                        $currentTime= $time->format('Y-m-d');
                      $requestFile->move($path.'/'.$imagePath,$fileName.'-'.$currentTime.'-'.time().'.'.$fileExtension);
                     }

                     $requestFile->move($path.'/'.$imagePath,$file);
                 }
             }
        // }


    }

    // calculator

    public function calculator()
    {
        return view('calculator');
    }

    public function  calculateResult(Request $request)
    {
        dd($request->all());
    }
}
