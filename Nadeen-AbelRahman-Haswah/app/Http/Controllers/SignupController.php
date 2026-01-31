<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkspaceRequest;
use App\Services\CompanyCreationService;
use Illuminate\Support\Facades\Auth;

class SignupController extends Controller
{
    public function create()
    {

        return view('site.loging.signup');
        // return view('welcome');
    }

    public function store(StoreWorkspaceRequest $request, CompanyCreationService $service)
    {
        $company = $service->createCompanyWithOwner($request->validated());

        $owner = $company->users()->where('role', 'company_owner')->first();
        Auth::login($owner);

        return redirect()->route('login.create')->with('success', 'Workspace created successfully!');
    }
}
