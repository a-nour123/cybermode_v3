<?php

use App\Http\Controllers\admin\compliance\TestComplianceController;
use App\Http\Controllers\admin\compliance\AuditComplianceController;
use App\Http\Controllers\admin\compliance\AuditComplianceObjectiveController;
use App\Http\Controllers\admin\compliance\AuditCompliancePolicyController;
use App\Http\Controllers\admin\compliance\CommentComplianceController;
use App\Http\Controllers\admin\compliance\FilesComplianceController;
use App\Http\Controllers\admin\remidation\RemidationController;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\admin\TestController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin compliance routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => 'compliance', // Prefix applied on all `compliance` group routes
        'middleware' => [], // Middlewares applied on all `compliance` group routes
        'as' => 'compliance.'
    ],
    function () {
        
        Route::get('notifications-settings', [AuditComplianceController::class, 'notificationsSettingsActiveAduit'])
        ->name('notificationsSettingsActiveAduit');
        //define test routes
        Route::resource('test', TestComplianceController::class);
        Route::get('get-list-test', [TestComplianceController::class, 'ajaxGetListTest'])->name('ajax.get-list-test');
        // Route::get('get-control-framework/{id}', [TestComplianceController::class, 'ajaxGetControlByFramework'])->name('ajax.get-compliance-framework');
        // ajax filter routes
        Route::get('get-control-framework/{id}', [TestComplianceController::class, 'ajaxGetControlByFramework'])->name('ajax.get-control-framework');
        Route::get('get-control-family/{id}', [TestComplianceController::class, 'ajaxGetControlByFamily'])->name('ajax.get-control-family');
        // active audit routes
        Route::post('/admin/compliance/reopen/control', [AuditComplianceController::class, 'ReopenAuditControl'])->name('ReopenAuditControl');
        Route::resource('audit', AuditComplianceController::class);
        Route::resource('audit-file', FilesComplianceController::class);
        Route::get('past-audits', [AuditComplianceController::class, 'PastAudits'])->name('past-audits');
        Route::post('get-past-audits/list', [AuditComplianceController::class, 'GetAudits'])->name('ajax.get-audits');
        Route::post('get-audits/list', [AuditComplianceController::class, 'GetPastAudits'])->name('ajax.get-past-audits');
        Route::POST('risk-to-result', [AuditComplianceController::class, 'RiskToResult'])->name('ajax.risk-to-result');
        Route::POST('add-risk-with-audit', [AuditComplianceController::class, 'storeRiskWithAudit'])->name('ajax.store-risk-with-audit');
        Route::get('remidation-request', [RemidationController::class, 'index'])->name('remidation-request');
        Route::get('/remediation-details', [RemidationController::class, 'getRemediationData'])->name('remediation.list');
        Route::get('/admin/compliance/remediation/details', [RemidationController::class, 'getDetails'])->name('remediation.details');
        Route::post('/admin/compliance/remediation/update', [RemidationController::class, 'update'])->name('remediation.update');
        Route::post('/fetch-test-results', [AuditComplianceController::class, 'fetchTestResults'])->name('fetch.test.results');

        // view and edit audit
        Route::get('get-logs-audit/{id}', [AuditComplianceController::class, 'GetLogsAudits'])->name('ajax.get-logs-audits');
        Route::post('add-comment', [CommentComplianceController::class, 'AddCommentAudit'])->name('ajax.add-comment');
        Route::get('/get-related-test-numbers', [AuditComplianceController::class, 'GetRelatedTestNumber'])->name('ajax.GetRelatedTestNumber');
        Route::get('/compliance/fetch-chart-data', [AuditComplianceController::class, 'fetchChartDataForAuditLive'])->name('fetch.chart.data');
        Route::group(
            [
                'prefix' => 'ajax', // Prefix applied on all `ajax` group routes
                'middleware' => [], // Middlewares applied on all `ajax` group routes
                'as' => 'ajax.'
            ],
            function () {
                Route::patch('take-audit-policy-action', [AuditCompliancePolicyController::class, 'takeAuditPolicyAction'])->name('take_audit_policy_action');
                Route::post('/download-file', [AuditCompliancePolicyController::class, 'downloadFile'])->name('download_file');
                Route::patch('take-audit-objective-action', [AuditComplianceObjectiveController::class, 'takeAuditObjectiveAction'])->name('take_audit_objective_action');
                Route::post('view-objective-evidences', [AuditComplianceObjectiveController::class, 'viewObjectiveEvidences'])->name('view_objective_evidences');
                Route::patch('take-audit-evidence-action', [AuditComplianceObjectiveController::class, 'takeAuditEvidenceAction'])->name('take_audit_evidence_action');
                Route::get('/download-evidence-file/{id}', [AuditComplianceObjectiveController::class, 'downloadEvidenceFile'])->name('download_evidence_file');
                Route::get('/get-framwork-controls/{name}', [AuditComplianceController::class, 'getFrameworkControls'])->name('getFrameworkControls');
                Route::post('/remediation-details/save', [AuditComplianceController::class, 'StoreRemidation'])->name('remediation-details.store');
                Route::post('/editAduit', [AuditComplianceController::class, 'updateCurrentAduit'])
                ->name('aduit-details.updateCurrentAduit');
                Route::post('/check-control-audit-status', [AuditComplianceController::class, 'checkForStatusTaken'])
                ->name('checkForStatusTaken');
                
            }
        );

        Route::group(
            [
                'prefix' => 'audit', // Prefix applied on all `audit` group routes
                'middleware' => [], // Middlewares applied on all `audit` group routes
                'as' => 'audit.'
            ],
            function () {
                Route::group(
                    [
                        'prefix' => 'ajax', // Prefix applied on all `ajax` group routes
                        'middleware' => [], // Middlewares applied on all `ajax` group routes
                        'as' => 'ajax.'
                    ],
                    function () {
                        Route::post('active/export', [AuditComplianceController::class, 'ajaxActiveExport'])->name('active.export');
                        Route::post('past/export', [AuditComplianceController::class, 'ajaxPastExport'])->name('past.export');
                    }
                );
            }
        );
    }
);
