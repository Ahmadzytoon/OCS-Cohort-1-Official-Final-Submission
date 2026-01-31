<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use App\Models\KnowledgeEntry;

class DashboardController extends Controller
{
    public function index()
    {
        // Cards numbers
        $companiesCount = Company::count();
        $usersCount = User::count();
        $activeUsersCount = User::where('status', 'active')->count();
        $knowledgeCount = KnowledgeEntry::count();

        // Latest users (table)
        $latestUsers = User::with(['company'])
            ->latest()
            ->take(5)
            ->get();

        // Latest companies (list)
        $latestCompanies = Company::with(['owner']) // إذا عندك owner relation
            ->latest()
            ->take(6)
            ->get();

        // Latest departments (table)
        $latestDepartments = Department::with(['manager', 'users'])
            ->withCount('users')
            ->latest()
            ->take(6)
            ->get();

        return view('admin.index', compact(
            'companiesCount',
            'usersCount',
            'activeUsersCount',
            'knowledgeCount',
            'latestUsers',
            'latestCompanies',
            'latestDepartments'
        ));
    }
}
