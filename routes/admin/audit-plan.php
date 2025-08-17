<?php

use App\Http\Controllers\admin\audit_plan\AuditPlanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin governance routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => 'audit', // Prefix applied on all `governance` group routes
        'middleware' => [], // Middlewares applied on all `governance` group routes
        'as' => 'audit.'
    ],
    function () {
        Route::get('/index', [AuditPlanController::class, 'index'])->name('frame.index');
        Route::get('/get-frameworks/{regulatorId}', [AuditPlanController::class, 'getFrameworksByRegulator'])->name('getFrameworksByRegulator');
        Route::post('/auditsResponsible/store', [AuditPlanController::class, 'storeAduitResponsible'])->name('storeAduitResponsible.store');
        Route::post('/auditerDetails/edit', [AuditPlanController::class, 'updateAduitResponsible'])->name('updateAduitResponsible');
        Route::post('/auditer/dataAudit', [AuditPlanController::class, 'getAuditerDataAudit'])->name('auditer.ajaxTable');
        Route::post('/frameDomainsSubdomains', [AuditPlanController::class, 'summaryOfResultsForEvaluationAndCompliancedetailsToSedation'])->name('summaryOfResultsForEvaluationAndCompliancedetailsToSedation');
        Route::post('/save-assignment', [AuditPlanController::class, 'saveAssignment'])->name('save.assignment');
        Route::Post('/admin/audit/GetFrameworkAuditGraph', [AuditPlanController::class, 'GetAllFrameworksAuditGraph'])->name('compliance.GetAllFrameworksAuditGraph');
        Route::Post('/admin/audit/export/audit/result', [AuditPlanController::class, 'exportAuditResult'])->name('exportAuditResult');


    }
);
