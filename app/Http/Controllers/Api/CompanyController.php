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

    public function companies(Request $request)
    {
        $companies = Company::all();
        if ($companies) {
            return response()->json(['success' => true, 'companies' => $companies]);
        } else {
            return response()->json(['success' => false, 'message' => 'No Company data found']);
        }
    }

    public function companyDetails(Request $request, $id)

    {
        if (Company::where('id', $id)->exists()) {
            $company = Company::where('id', $id)->firstOrFail();
            return response()->json(['success' => true, 'company' => $company]);
        } else {
            return response()->json(['success' => true, 'message' => "someing thing went wrong"]);
        }
    }


}
