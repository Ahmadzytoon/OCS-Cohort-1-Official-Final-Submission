<?php

use App\Http\Controllers\AccessRequestController as ControllersAccessRequestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\CompanyOwner\CompanyProfileController;
use App\Http\Controllers\CompanyOwner\DepartmentController as OwnerDepartmentController;
use App\Http\Controllers\Knowledge\KnowledgeApprovalController;
use App\Http\Controllers\Knowledge\KnowledgeBrowseController;
use App\Http\Controllers\Knowledge\KnowledgeController;
use App\Http\Controllers\Knowledge\MyContributionsController;
use App\Http\Controllers\Shared\UserController as SharedUserController;
use App\Http\Controllers\Shared\AccessRequestController;
use App\Http\Controllers\shared\CompanyNewsController;
use App\Http\Controllers\Shared\RequestsStatusController;




// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('site.index');
})->name('site.index');


Route::get('/solution', function () {
    return view('site.solution');
})->name('site.solution');

Route::get('/knowledgeModel', function () {
    return view('site.knowledgeModel');
})->name('site.knowledgeModel');

Route::get('/about', function () {
    return view('site.about');
})->name('site.about');

Route::get('/faq', function () {
    return view('site.faq');
})->name('site.faq');

Route::get('/choose', function () {
    return view('site.loging.choose');
})->name('site.loging.choose');



// Route::get('/access-request', function () {
//     return view('site.loging.access-request');
// })->name('site.loging.access-request');

Route::get('/Allplans', function () {
    return view('site.loging.plans.plans');
})->name('site.loging.plans.plans');



Route::get('/signup', [SignupController::class, 'create'])->name('signup.create');
Route::post('signup', [SignupController::class, 'store'])->name('signup.store');


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login.create');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

Route::get('/access-request', [AccessRequestController::class, 'create'])->name('accessRequest.create');
Route::post('/access-request', [AccessRequestController::class, 'store'])->name('accessRequest.store');


Route::middleware(['auth', 'role:company_owner'])->prefix('company-owner')->name('companyOwner.')->group(function () {
    Route::get('/dashboard', fn() => view('site.innerPages.companyOwner.index'))->name('dashboard');
    Route::get('/myprofile', fn() => view('site.innerPages.companyOwner.profile'))->name('profile');

    // Route::get('/accessRequests', function () {
    //     return view('site.innerPages.companyOwner.accessRequests');
    // })->name('accessRequests');
    // Route::get('/profile', function () {
    //     return view('site.innerPages.companyOwner.companyProfile');
    // })->name('companyProfile');
    Route::get('/profile', [CompanyProfileController::class, 'show'])->name('companyProfile');
    Route::put('/profile', [CompanyProfileController::class, 'update'])->name('companyProfile.update');


    Route::get('/rolesAndPermissions', function () {
        return view('site.innerPages.companyOwner.rolesAndPermissions');
    })->name('rolesAndPermissions');

    // Route::get('/Departments', function () {
    //     return view('site.innerPages.companyOwner.departments');
    // })->name('departments');

    Route::get('/departments', [OwnerDepartmentController::class, 'index'])->name('departments.index');
    Route::post('/departments', [OwnerDepartmentController::class, 'store'])->name('departments.store');
    Route::put('/departments/{department}', [OwnerDepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{department}', [OwnerDepartmentController::class, 'destroy'])->name('departments.destroy');

    // تفاصيل القسم (لـ modal view details)
    Route::get('/departments/{department}', [OwnerDepartmentController::class, 'show'])->name('departments.show');

    Route::get('/departments/{department}/members', [OwnerDepartmentController::class, 'members'])
        ->name('departments.members');


    Route::get('/knowledgeOverview', function () {
        return view('site.innerPages.companyOwner.knowledgeOverview');
    })->name('knowledgeOverview');

    // Route::get('/onboardingKnowledge', function () {
    //     return view('site.innerPages.companyOwner.onboardingKnowledge');
    // })->name('onboardingKnowledge');


    // Route::get('/MistakesAndLessonsLearned', function () {
    //     return view('site.innerPages.companyOwner.MistakesAndLessonsLearned');
    // })->name('MistakesAndLessonsLearned');

    // Route::get('/OperationalKnowledge', function () {
    //     return view('site.innerPages.companyOwner.OperationalKnowledge');
    // })->name('OperationalKnowledge');

    // Route::get('/CriticalAndStrategicKnowledge', function () {
    //     return view('site.innerPages.companyOwner.CriticalAndStrategicKnowledge');
    // })->name('CriticalAndStrategicKnowledge');

    // Route::get('/approvals', function () {
    //     return view('site.innerPages.companyOwner.approvals');
    // })->name('approvals');

    Route::get('/companyCalendar', function () {
        return view('site.innerPages.companyOwner.companyCalendar');
    })->name('companyCalendar');

    Route::get('/departmentsCalendars', function () {
        return view('site.innerPages.companyOwner.departmentsCalendars');
    })->name('departmentsCalendars');

    // Route::get('/companyNews', function () {
    //     return view('site.innerPages.companyOwner.companyNews');
    // })->name('companyNews');

    Route::get('/settings', function () {
        return view('site.innerPages.companyOwner.settings');
    })->name('settings');

    Route::get('/myprofile', function () {
        return view('site.innerPages.companyOwner.profile');
    })->name('profile');

    // باقي صفحات owner...
});

// الصفحات المشتركة بين owner&department
Route::middleware(['auth', 'role:department_manager,company_owner,employee'])->prefix('shared')->name('shared.')->group(function () {


    Route::get('/employees', [SharedUserController::class, 'index'])->name('employee.index');
    Route::post('/employees', [SharedUserController::class, 'store'])->name('employee.store');

    Route::get('/access-requests', [RequestsStatusController::class, 'index'])->name('accessRequests.index');

    Route::post('/access-requests/{accessRequest}/approve', [RequestsStatusController::class, 'approve'])->name('accessRequests.approve');
    Route::post('/access-requests/{accessRequest}/reject', [RequestsStatusController::class, 'reject'])->name('accessRequests.reject');

    Route::get('/companyNews', [CompanyNewsController::class, 'index'])->name('companyNews.index');
    Route::post('/companyNews', [CompanyNewsController::class, 'store'])->name('companyNews.store');
    Route::put('/companyNews/{news}', [CompanyNewsController::class, 'update'])->name('companyNews.update');
    Route::delete('/companyNews/{news}', [CompanyNewsController::class, 'destroy'])->name('companyNews.destroy');

    Route::patch('/companyNews/{news}/publish-now', [CompanyNewsController::class, 'publishNow'])->name('companyNews.publishNow');
    Route::patch('/companyNews/{news}/unpublish', [CompanyNewsController::class, 'unpublish'])->name('companyNews.unpublish');


    Route::get('/approvals', [KnowledgeApprovalController::class, 'index'])
        ->name('approvals.index');

    Route::get('/approvals/{entry}/details', [KnowledgeApprovalController::class, 'details'])
        ->name('approvals.details');

    Route::post('/approvals/{entry}/approve', [KnowledgeApprovalController::class, 'approve'])
        ->name('approvals.approve');

    Route::post('/approvals/{entry}/reject', [KnowledgeApprovalController::class, 'reject'])
        ->name('approvals.reject');

    Route::post('/approvals/bulk-approve', [KnowledgeApprovalController::class, 'bulkApprove'])
        ->name('approvals.bulkApprove');



    Route::get('/onboarding', [KnowledgeBrowseController::class, 'onboarding'])->name('onboarding');
    Route::get('/mistakes', [KnowledgeBrowseController::class, 'mistakes'])->name('mistakes');
    Route::get('/operational', [KnowledgeBrowseController::class, 'operational'])->name('operational');
    Route::get('/critical', [KnowledgeBrowseController::class, 'critical'])->name('critical');
    Route::get('/critical/{entry}/details', [KnowledgeBrowseController::class, 'criticalDetails'])
        ->name('criticalDetails');

    Route::get('/mistakes', [KnowledgeBrowseController::class, 'mistakes'])->name('mistakes');
    Route::get('/mistakes/{entry}/details', [KnowledgeBrowseController::class, 'mistakesDetails'])
        ->name('mistakesDetails');
});


// الصفحات المشتركة بين employee & department manager
Route::middleware(['auth', 'role:department_manager,employee'])->prefix('knowledge')->name('knowledge.')->group(function () {
    Route::get('/companyNews', [CompanyNewsController::class, 'index'])->name('companyNews.index');


    // صفحة إضافة معرفة (الموظف + مدير القسم)
    Route::get('add-knowledge', [KnowledgeController::class, 'create'])
        ->name('knowledge.create');

    // حفظ (Draft أو Submit)
    Route::post('/add-knowledge', [KnowledgeController::class, 'store'])
        ->name('knowledge.store');

    // صفحة My Contributions
    Route::get('/my-contributions', [MyContributionsController::class, 'index'])
        ->name('knowledge.myContributions');


    // عرض Card (modal أو صفحة)
    Route::get('/knowledge/{entry}', [KnowledgeController::class, 'show'])
        ->name('knowledge.show');

    // تعديل (مسموح فقط draft/pending)
    Route::get('/knowledge/{entry}/edit', [KnowledgeController::class, 'edit'])
        ->name('knowledge.edit');
    Route::put('/knowledge/{entry}', [KnowledgeController::class, 'update'])
        ->name('knowledge.update');

    // حذف (soft delete)
    Route::delete('/knowledge/{entry}', [KnowledgeController::class, 'destroy'])
        ->name('knowledge.destroy');
});
Route::middleware(['auth', 'role:department_manager'])->prefix('department-manager')->name('departmentManager.')->group(function () {
    Route::get('/dashboard', fn() => view('site.innerPages.DepartmentManager.index'))->name('dashboard');
});


Route::middleware(['auth', 'role:employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', fn() => view('site.innerPages.employee.index'))->name('dashboard');
    Route::get('/add-knowledge', fn() => view('site.innerPages.employee.addknowledge'))->name('addknowledge');
});





Route::get('/companyOwnerprofilee', function () {
    return view('site.innerPages.companyOwner.companyProfile');
})->name('company.profile.update');




// require __DIR__ . '/auth.php';

Route::get('/employeeaddknowledge', function () {
    return view('site.innerPages.employee.addknowledge');
})->name('employee.addknowledge');

Route::get('/employeeadmyContributions', function () {
    return view('site.innerPages.employee.myContributions');
})->name('employee.myContributions');

Route::get('/employeeadashboard', function () {
    return view('site.innerPages.employee.index');
})->name('employee.index');
