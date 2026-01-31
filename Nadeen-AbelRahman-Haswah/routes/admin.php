<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\KnowledgeEntryController;




Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');



        Route::resource('companies', CompanyController::class)->only(['index', 'create', 'store']);
        Route::resource('companies', CompanyController::class);

        Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
        Route::get('companies/{company}/departments', [UserController::class, 'departmentsByCompany'])
            ->name('companies.departments');

        Route::resource('departments', DepartmentController::class);

        Route::post('departments/{department}/employees', [DepartmentController::class, 'addEmployees'])
            ->name('departments.employees.store');


        Route::resource('plans', PlanController::class);

        Route::get('subscriptions', [SubscriptionController::class, 'index'])
            ->name('subscriptions.index');


        Route::resource('knowledge-items', KnowledgeEntryController::class)
            ->only(['index', 'show'])
            ->names('knowledgeItems');




        // Route::get('companies', fn() => view('admin.companies'))->name('companies');
        // Route::get('showCompany', fn() => view('admin.showCompany'))->name('showCompany');
        Route::get('addComapny', fn() => view('admin.addCompany'))->name('addCompany');

        // Route::get('users', fn() => view('admin.users'))->name('users');
        // Route::get('addUsers', fn() => view('admin.addUser'))->name('addUser');

        Route::get('accessRequests', fn() => view('admin.accessRequests'))->name('accessRequests');

        // Route::get('departments', fn() => view('admin.departments'))->name('departments');
        // Route::get('addDepartment', fn() => view('admin.addDepartment'))->name('addDepartment');
        Route::get('showDepartment', fn() => view('admin.showDepartment'))->name('showDepartment');
        // Route::get('editDepartment', fn() => view('admin.editDepartment'))->name('editDepartment');

        // Route::get('knowledgeItems', fn() => view('admin.knowledgeItems'))->name('knowledgeItems');
        Route::get('showknowledgeItem', fn() => view('admin.showknowledgeItem'))->name('showknowledgeItem');
        Route::get('editknowledgeItem', fn() => view('admin.editknowledgeItem'))->name('editknowledgeItem');

        // Route::get('plans', fn() => view('admin.plans'))->name('plans');
        Route::get('addPlan', fn() => view('admin.addPlan'))->name('addPlan');
        Route::get('editPlan', fn() => view('admin.editPlan'))->name('editPlan');

        // Route::get('subscriptions', fn() => view('admin.subscriptions'))->name('subscriptions');
        Route::get('payments', fn() => view('admin.payments'))->name('payments');

        Route::get('setting', fn() => view('admin.setting'))->name('setting');
        Route::get('profile', fn() => view('admin.profile'))->name('profile');
    });
});
