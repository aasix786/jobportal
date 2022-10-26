<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function editCompany(Request $request)
    {
        $user = Auth::user();
        $company = $user->company()->firstOrFail();
        return response()->json(['success' => true, 'company' => $company]);
    }

    public function updateCompany(Request $request, $id)
    {
        $company = Company::find($id)->firstOrFail();
        if ($company) {
            $company->update($request->all());
            return response()->json(['success' => true, 'message' => 'Company updated successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Some thing went wrong!...']);
        }
    }
}
