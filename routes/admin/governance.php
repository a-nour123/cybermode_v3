<?php

use App\Http\Controllers\admin\governance\SeederController;
use App\Http\Controllers\admin\governance\DocumentationsDataController;
use App\Http\Controllers\admin\governance\ExceptionConfigController;
use App\Http\Controllers\admin\governance\FrameworkControlController;
use App\Http\Controllers\admin\governance\FrameworkController;
use App\Http\Controllers\admin\governance\FrameWorksDataController;
use App\Http\Controllers\admin\governance\GovernanceController;
use App\Http\Controllers\admin\governance\RegulatorController;
use App\Http\Controllers\admin\governance\ExceptionController;
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
        'prefix' => 'governance', // Prefix applied on all `governance` group routes
        'middleware' => [], // Middlewares applied on all `governance` group routes
        'as' => 'governance.'
    ],
    function () {
        //test route
        Route::get('test', function () {
            return view('admin.content.governance.testlive');
        });

        Route::get('/todo', [GovernanceController::class, 'todo'])->name('todo');
        Route::get('notifications-settings-framework', [GovernanceController::class, 'notificationsSettingsFramework'])
            ->name('notificationsSettingFramework');
        Route::get('notifications-settings-regulator', [GovernanceController::class, 'notificationsSettingsRegulator'])
            ->name('notificationsSettingsRegulator');
        Route::get('notifications-settings-Cateogry', [GovernanceController::class, 'notificationsSettingsCateogry'])
            ->name('notificationsSettingsCateogry');
        Route::get('notifications-settings-Documentation', [GovernanceController::class, 'notificationsSettingsDocumentation'])
            ->name('notificationsSettingsDocumentation');
        Route::get('notifications-settings-aduit-schedule', [GovernanceController::class, 'notificationsSettingsAduitSchedule'])
            ->name('notificationsSettingsAduitSchedule');

        Route::get('notifications-settings-policy-center', [DocumentationsDataController::class, 'notificationsSettingspolicyCenter'])
            ->name('notificationsSettingspolicyCenter');
        Route::get('notifications-settings-audit-policy', [DocumentationsDataController::class, 'notificationsSettingsAuditPolicy'])
            ->name('notificationsSettingsAuditPolicy');

        //        Route::get('/', [GovernanceController::class, 'index'])->name('index');
        //Frameworks
        Route::get('/', [FrameWorksDataController::class, 'index'])->name('index');
        //Pagination
        Route::get('/next-frame-work-page', [FrameWorksDataController::class, 'NexFramePage']);
        Route::get('/prev-frame-work-page', [FrameWorksDataController::class, 'PrevFramePage']);
        //Side Right Content
        Route::get('/frame-details', [FrameWorksDataController::class, 'frameDetails']);
        Route::get('/frame-delete', [FrameWorksDataController::class, 'deleteFrame']);
        //Datatables
        Route::get('/FrameFamiliesTable', [FrameWorksDataController::class, 'FrameFamiliesTable']);


        //        Route::get('/category', [GovernanceController::class, 'listCategory'])->name('category');

        Route::get('/category', [DocumentationsDataController::class, 'index'])->name('category');
        Route::get('/policy-center', [DocumentationsDataController::class, 'policyCenter'])
            ->name('policyCenter');
        Route::post('/policy-center/store', [DocumentationsDataController::class, 'storePolicy'])
            ->name('storePolicy');
        Route::Post('/import-data', [DocumentationsDataController::class, 'importData'])->name('policyClause.importData');
        Route::get('/import', [DocumentationsDataController::class, 'openImportForm'])->name('policyClause.import');
        Route::get('/admin/governance/policies', [DocumentationsDataController::class, 'GetDataPolicy'])->name('getDataPolicy');
        Route::get('/admin/governance/GetDataAduit', [DocumentationsDataController::class, 'GetDataAduit'])->name('GetDataAduit');
        Route::get('/admin/governance/GetDataAduitForAuditer', [DocumentationsDataController::class, 'GetDataAduitForAuditer'])->name('GetDataAduitForAuditer');
        Route::delete('/admin/governance/policies/{id}', [DocumentationsDataController::class, 'deletePolicy'])->name('deletePolicy');
        Route::get('admin/governance/getPolicy/{id}', [DocumentationsDataController::class, 'getPolicy'])->name('getPolicy');
        Route::put('/admin/governance/policies/{id}', [DocumentationsDataController::class, 'editPolicy'])->name('editPolicy');
        Route::get('/admin/documents', [DocumentationsDataController::class, 'getDocuments'])->name('documents');
        Route::get('admin/governance/policies/fetch', [DocumentationsDataController::class, 'fetchPolicies'])->name('policies.fetch');
        Route::post('/governance/control/storePolicyDocument', [DocumentationsDataController::class, 'storePolicyDocument'])->name('storePolicyDocument');
        Route::get('/document-policies/{documentId}', [DocumentationsDataController::class, 'fetchDocumentPolicies'])->name('document.policies');
        Route::delete('/document-policies/delete/{id}', [DocumentationsDataController::class, 'deletePolicyDocument'])->name('document.policy.delete');
        Route::get('/aduit-document-policies', [DocumentationsDataController::class, 'AduitPolicyDocument'])->name('Aduit.document.policy');
        Route::get('/aduit-document-policies-past', [DocumentationsDataController::class, 'AduitPolicyDocumentPast'])->name('Aduit.document.policy.past');
        Route::get('/releatedPolicy/{documentId}', [DocumentationsDataController::class, 'getRelatedPolicies'])->name('releatedPolicy');
        Route::post('/audits-store-document-policy', [DocumentationsDataController::class, 'storeAduitDocumentPolicy'])->name('storeAduitDocumentPolicy');
        Route::post('/getAuditDocumentPolicies', [DocumentationsDataController::class, 'getAuditDocumentPolicies'])->name('getAuditDocumentPolicies');
        Route::get('/audit-document-policy/{id}', [DocumentationsDataController::class, 'getAuditDocumentPolicyById'])->name('getAuditDocumentPolicyById');
        Route::get('/get-documents-by-type', [DocumentationsDataController::class, 'getDocumentsByType'])->name('getDocumentsByType');
        Route::post('admin/governance/export/audit/polices/document', [DocumentationsDataController::class, 'auditDocumentPoliciesexport'])->name('auditDocumentPoliciesexport');
        Route::post('/import-status-comments-audit-policy', [DocumentationsDataController::class, 'importStatusAndCommentToAudit'])->name('importStatusAndCommentToAudit');
        Route::get('/admin/governance/document/logs', [DocumentationsDataController::class, 'GetDataDocumentLogs'])->name('GetDataDocumentLogs');

        Route::get('/showdetailsAduit/audit-document-policy/{id}', [DocumentationsDataController::class, 'showdetailsAduit'])->name('showdetailsAduit');
        // Save comment route
        Route::post('/policies/{id}/comments', [DocumentationsDataController::class, 'storeComment'])->name('policies.comments.store');
        Route::post('/policies/{id}/comments/reply', [DocumentationsDataController::class, 'storeCommentForAuditer'])->name('policies.comments.storeCommentForAuditer');
        Route::get('/export-policy-clause', [DocumentationsDataController::class, 'ajaxExportPolicyClause'])->name('export.policy.clause');
        // Save file route
        Route::post('/policies/{id}/files', [DocumentationsDataController::class, 'storeFile'])->name('policies.files.store');
        Route::delete('/policies/{policyId}/files/{fileId}', [DocumentationsDataController::class, 'destroyFile'])->name('policies.files.destroy');

        // Update status route
        Route::patch('/policies/{id}/status', [DocumentationsDataController::class, 'updateStatus'])->name('policies.status.update');
        Route::patch('/policies/{id}/status/reject', [DocumentationsDataController::class, 'updateStatusReject'])->name('policies.status.reject');
        Route::patch('/policies/{id}/status/approved', [DocumentationsDataController::class, 'updateStatusApproved'])->name('policies.status.approve');
        Route::get('admin/governance/policies/comments/{id}', [DocumentationsDataController::class, 'GetComments'])
            ->name('policies.comments.get');
        Route::post('/governance/policies/calc-total-status', [DocumentationsDataController::class, 'calcTotalStatus'])->name('policies.CalcTotalStatus');

        Route::get('admin/governance/policies/comments/auditer/{id}', [DocumentationsDataController::class, 'GetCommentsForAduiter'])
            ->name('policies.comments.GetCommentsForAduiter');
        Route::post('admin/governance/policies/approveAll', [DocumentationsDataController::class, 'approveAll'])->name('policies.approveAll');
        Route::put('/governance/policies/{policyId}/files/{fileId}',  [DocumentationsDataController::class, 'updateFile'])
            ->name('policies.files.update');
         Route::get('admin/governance/policies/{id}/files', [DocumentationsDataController::class, 'indexFiles'])
            ->name('policies.files.index');

        Route::get('audit-statistics/{id}', [DocumentationsDataController::class, 'showAuditStatistics'])->name('showAuditStatistics');
        Route::get('/admin/governance/audit-details/{id}/{user_id}/{document_id}', [DocumentationsDataController::class, 'showdetailsAduitForAduiter'])->name('showdetailsAduitForAduiter');

        Route::get('/admin/governance/policies/chartData', [DocumentationsDataController::class, 'getChartData'])->name('policies.chartData');
        Route::get('/document-policies/files/download/{filePath}', [DocumentationsDataController::class, 'download'])
            ->name('policies.files.download');
        Route::post('/compliance/send-result-audit', [DocumentationsDataController::class, 'sendResultAudit'])->name('sendResultAudit');
        Route::post('/admin/governance/checkAuditDocumentPolicy', [DocumentationsDataController::class, 'checkAuditDocumentPolicy'])->name('checkAuditDocumentPolicy');
        Route::get('/document/change-content/{id}', [DocumentationsDataController::class, 'changeContent'])->name('changeContent');
        Route::get('/document/document-change-content', [DocumentationsDataController::class, 'changeContentDocument'])->name('changeContentDocument');
        Route::post('/document/document-change-content/update', [DocumentationsDataController::class, 'updateDocumentContent'])->name('updateDocumentContent');
        Route::post('/document/document-change-content/Create', [DocumentationsDataController::class, 'creatDocumentContent'])->name('creatDocumentContent');
        Route::post('/document/document-change-content/delete', [DocumentationsDataController::class, 'deleteDocumentContent'])->name('deleteDocumentContent');
        Route::post('/document/document-change-content/accept', [DocumentationsDataController::class, 'acceptDocumentContent'])->name('acceptDocumentContent');
        Route::get('/admin/document/download-document-file/{id}', [DocumentationsDataController::class, 'downloadFileDocumentcontent'])
            ->name('downloadFileDocumentcontent');
        //Pagination
        Route::get('/next-doc-page', [DocumentationsDataController::class, 'NexDocPage']);
        Route::get('/prev-doc-page', [DocumentationsDataController::class, 'PrevDocPage']);
        //Side Right Content
        Route::get('/doc-details', [DocumentationsDataController::class, 'docDetails']);
        Route::get('/doc-delete', [DocumentationsDataController::class, 'deleteDoc']);
        //Datatables
        Route::get('/DocTable', [DocumentationsDataController::class, 'ajaxGetList']);

        Route::POST('/framework/store', [GovernanceController::class, 'store'])->name('framework.store');
        Route::POST('/framework/store_regulator', [GovernanceController::class, 'store_regulator'])->name('framework.store_regulator');
        Route::POST('admin/governance/framework/update/{id}', [GovernanceController::class, 'update'])->name('framework.update');
        Route::POST('framework/copy/{id}', [GovernanceController::class, 'copy'])->name('framework.copy');
        Route::POST('framework/update/{id}', [GovernanceController::class, 'update'])->name('framework.update');
        Route::delete('framework/delete/{id}', [GovernanceController::class, 'destroy'])->name("framework.destroy");
        Route::get('/framework/show/{id}',  [GovernanceController::class, 'show'])->name('framework.show');
        Route::get('admin/governance/framework/details', [GovernanceController::class, 'frameDetails'])->name('framework.details');
        Route::get('admin/governance/fetchSubfamilies', [GovernanceController::class, 'getSubfamilies'])->name('framework.getSubFamilies');
        Route::POST('/framework/domain', [GovernanceController::class, 'getDomainInframework'])->name('framework.domain');

        Route::get('/fetch-controls-closed/{frameworkId}', [GovernanceController::class, 'fetchControlsClosed'])->name('fetch.controls.closed');
        Route::get('get-list-test/{id}', [GovernanceController::class, 'ajaxGetListTest'])->name('ajax.get-list-test');
        Route::get('get-list-map/{id}', [GovernanceController::class, 'ajaxGetListMap'])->name('ajax.get-list-map');

        Route::POST('framework-map', [GovernanceController::class, 'frameMap'])->name('framework.map');

        Route::get('unmapping/{id}', [GovernanceController::class, 'unMapControl'])->name('unmap.control');
        Route::get('edit_control/{id}', [GovernanceController::class, 'editControl'])->name('ajax.edit_control');
        Route::POST('control/update', [GovernanceController::class, 'updateControl'])->name('control.update');
        Route::POST('/control/store/{id}', [GovernanceController::class, 'storeControl'])->name('control.store');

        Route::get('/control/list', [GovernanceController::class, 'listControl'])->name("control.list");
        // Route::get('/get-families/{frameworkId}', [GovernanceController::class, 'getFamilies'])->name('get-families');
        Route::post('/auditer/data', [GovernanceController::class, 'getAuditerData'])->name('auditer.data');
        Route::get('/auditer/edit', [GovernanceController::class, 'getEditData'])->name('auditer.getEditData');
        Route::post('/frameDomainsSubdomains/viewDetails', [GovernanceController::class, 'summaryOfResultsForEvaluationAndCompliancedetailsToFramework'])->name('summaryOfResultsForEvaluationAndCompliancedetailsToFramework');
        Route::get('control/notifications-settings', [GovernanceController::class, 'notificationsSettingscontrol'])
            ->name('notificationsSettingscontrol');        // Route::get('get-list-control', [GovernanceController::class, 'ajaxGetListControl'])->name('ajax.get-list-control');

        Route::post('get-list-control/list', [GovernanceController::class, 'ajaxGetListControl'])->name('ajax.get-list-control');
        Route::POST('/control/store', [GovernanceController::class, 'storeControl2'])->name('control.store2');
        Route::get('control/delete/{id}', [GovernanceController::class, 'destroyControl'])->name("control.destroy");
        Route::post('/save-assignment', [GovernanceController::class, 'saveAssignment'])->name('save.assignment');
        Route::post('/submit-assignments', [GovernanceController::class, 'submitAssignments'])->name('submit.assignments');
        Route::get('/fetch-teams', [GovernanceController::class, 'fetchTeams'])->name('fetch.teams');

        Route::get('get-list-control-map/{id}', [GovernanceController::class, 'ajaxGetListControlMap'])->name('ajax.get-list_control-map');



        Route::get('/audit/store',  [GovernanceController::class, 'storeAudit'])->name('audit.store');
        Route::post('/audit/get-framework-tests',  [GovernanceController::class, 'getFrameworkTests'])->name('audit.getFrameworkTests');
        Route::get('/get-domain-details/req-evedience', [GovernanceController::class, 'getDomainReqAndEveDetails'])->name('getDomainReqAndEveDetails');
        Route::get('/get-filtered-domain-details/req-evedience', [GovernanceController::class, 'getFilteredDomainDetails'])->name('getFilteredDomainDetails');
        //documents
        Route::POST('/category/store', [GovernanceController::class, 'storeCategory'])->name('category.store');
        Route::POST('category/update', [GovernanceController::class, 'updateCategory'])->name('category.update');
        Route::delete('category/delete/{id}', [GovernanceController::class, 'destroyCategory'])->name("category.destroy");
        Route::POST('/document/store', [GovernanceController::class, 'storeDocument'])->name('document.store');
        Route::get('document/get-list/{id}', [GovernanceController::class, 'ajaxGetListDocument'])->name('ajax.get-list-document');
        Route::get('edit_document/{id}', [GovernanceController::class, 'editDocument'])->name('ajax.edit_document');
        Route::get('show_document/{id}', [GovernanceController::class, 'showDocument'])->name('ajax.show_document');
        Route::POST('document/update', [GovernanceController::class, 'updateDocument'])->name('document.update');
        Route::delete('document/delete/{id}', [GovernanceController::class, 'destroyDocument'])->name("document.destroy");
        Route::get('document/download/{id}',  [GovernanceController::class, 'download'])->name('document.download');
        Route::get('/get-all-status/{testNumber}/{frameworkId}', [GovernanceController::class, 'getAllStatusForAduitInAuditScreen'])->name('getAllStatusForAduitInAuditScreen');

        Route::get('get_control/list/{id}', [GovernanceController::class, 'ajaxGetListFrameControl'])->name('framecontrol.list');

        Route::get('next_review/{id}/{last?}', [GovernanceController::class, 'ajaxAddNextReviewToFrequency'])->name('nextreview');
        Route::POST('domain_controls_status', [GovernanceController::class, 'domainStatus'])->name('domain.status');
        Route::POST('framework_controls_status', [GovernanceController::class, 'frameworkControlStatus'])->name('frameworkControl.status');
        Route::get('requirement/details', [GovernanceController::class, 'showDetailsRequirement'])->name('requirement.details');
        Route::POST('framework-control/status-evidence', [FrameworkController::class, 'FrameWorkStatusReqAndEvedience'])->name('frameworkControl.FrameWorkStatusReqAndEvedience');

        Route::POST('/note', [GovernanceController::class, 'send_note'])->name('send-note');
        Route::POST('/note-file', [GovernanceController::class, 'send_note_file'])->name('send-note-file');
        Route::post('/download-note-file', [GovernanceController::class, 'downloadNoteFile'])->name('download_note_file');
        Route::group(
            [
                'prefix' => 'ajax', // Prefix applied on all `department` group routes
                'middleware' => [], // Middlewares applied on all `department` group routes
                'as' => 'ajax.'
            ],
            function () {
                Route::post('/download-file', [GovernanceController::class, 'downloadFile'])->name('download_file');
                Route::get('/download-document-comment-file/{id}', [GovernanceController::class, 'downloadDocumentCommentFile'])->name('downloadDocumentCommentFile');
            }
        );

        Route::group(
            [
                'prefix' => 'framework', // Prefix applied on all `department` group routes
                'middleware' => [], // Middlewares applied on all `department` group routes
                'as' => 'framework.'
            ],
            function () {
                Route::get('/import', [FrameworkController::class, 'openImportForm'])->name('import');

                Route::group(
                    [
                        'prefix' => 'ajax', // Prefix applied on all `department` group routes
                        'middleware' => [], // Middlewares applied on all `department` group routes
                        'as' => 'ajax.'
                    ],
                    function () {
                        Route::post('/export', [FrameworkController::class, 'ajaxExport'])->name('export');
                        Route::Post('/import-data', [FrameworkController::class, 'importData'])->name('importData');
                        Route::get('/graph-view-framework/{id}', [FrameworkController::class, 'graphViewFramework'])->name('graphViewFramework');
                        Route::post('/process', [FrameworkController::class, 'processData'])->name('process.data');
                        Route::get('/graph/closed-controls/{frameworkId}', [FrameworkController::class, 'fetchGraphClosedControls'])->name('fetch.graphClosedControls');
                    }
                );
            }
        );

        Route::group(
            [
                'prefix' => 'control', // Prefix applied on all `governance` group routes
                'middleware' => [], // Middlewares applied on all `governance` group routes
                'as' => 'control.'
            ],
            function () {
                Route::get('/import', [FrameworkControlController::class, 'openImportForm'])->name('import');
                Route::get('/configuretion', [FrameworkControlController::class, 'configure'])->name('configuretion');
                Route::get('/configuretion', [GovernanceController::class, 'configure'])->name('configuretion');

                Route::group(
                    [
                        'prefix' => 'ajax', // Prefix applied on all `governance` group routes
                        'middleware' => [], // Middlewares applied on all `governance` group routes
                        'as' => 'ajax.'
                    ],
                    function () {
                        Route::post('/export', [FrameworkControlController::class, 'ajaxExport'])->name('export');
                        Route::Post('/import-data', [FrameworkControlController::class, 'importData'])->name('importData');

                        Route::Group(
                            [
                                'prefix' => 'objective', // Prefix applied on all `objective` group routes
                                'middleware' => [], // Middlewares applied on all `objective` group routes
                                'as' => 'objective.'
                            ],

                            function () {
                                Route::get('/get/{id}', [GovernanceController::class, 'getControlObjectives'])->name('get');
                                Route::get('/get-all/{id}', [GovernanceController::class, 'getAllObjectives'])->name('getAll');
                                Route::post('/add-objective-to-control', [GovernanceController::class, 'addObjectiveToControl'])->name('addObjectiveToControl');
                                Route::post('/store-evidence', [GovernanceController::class, 'storeEvidence'])->name('storeEvidence');
                                Route::get('/get-evidences/{id}', [GovernanceController::class, 'getEvidences'])->name('getEvidences');
                                Route::get('/get-evidence/{id}', [GovernanceController::class, 'getEvidence'])->name('getEvidence');
                                Route::get('/download-evidence-file/{id}', [GovernanceController::class, 'downloadEvidenceFile'])->name('downloadEvidenceFile');
                                Route::post('/update-evidence', [GovernanceController::class, 'updateEvidence'])->name('updateEvidence');
                                Route::post('/get-responsibles', [GovernanceController::class, 'getResponsibles'])->name('getResponsibles');
                                Route::get('/edit-objective/{id}', [GovernanceController::class, 'editObjective'])->name('editObjective');
                                Route::post('/update-objective', [GovernanceController::class, 'updateObjective'])->name('updateObjective');
                                Route::delete('/delete-objective/{id}', [GovernanceController::class, 'deleteObjective'])->name('deleteObjective');
                                Route::delete('/delete-evidence/{id}', [GovernanceController::class, 'deleteEvidence'])->name('deleteEvidence');
                                Route::delete('/clear-cooments/{id}', [GovernanceController::class, 'clearComments'])->name('clearComments');
                                Route::get('/get-control-guide/{id}', [GovernanceController::class, 'getControlGuide'])->name('getControlGuide');
                                Route::get('/get-comments/{id}', [GovernanceController::class, 'showObjectiveComments'])->name('showComments');
                                Route::get('/get-comments-count/{id}', [GovernanceController::class, 'showObjectiveCommentsCount'])->name('showCommentsCounts');
                                Route::post('/comment', [GovernanceController::class, 'sendObjectiveComment'])->name('sendComment');
                                Route::get('/download-comment-file/{id}', [GovernanceController::class, 'downloadObjectiveCommentFile'])->name('downloadCommentFile');
                                Route::get('/governance/ajax/get-controls-by-framework', [GovernanceController::class, 'getControlsByFramework'])->name('get-controls-by-framework');
                                Route::post('/saving-mapping-controls', [GovernanceController::class, 'saveMappingControls'])->name('saveMappingControls');
                                Route::post('/deleteMappingControl', [GovernanceController::class, 'deleteMappingControl'])->name('deleteMappingControl');
                                Route::get('/ajax/tree-data/{id}', [GovernanceController::class, 'fetchTreeData'])->name('tree.data');
                                Route::get('/evidence/view-file/{id}', [GovernanceController::class, 'viewEvidenceFile'])->name('evidence.view-file');
                            }
                        );
                    }
                );
            }
        );

        // regulator
        Route::get('/regulator/list', [RegulatorController::class, 'index'])->name("regulator.index");
        Route::post('/regulator/store', [RegulatorController::class, 'store'])->name("regulator.store");
        Route::post('/regulator/update/{id}', [RegulatorController::class, 'update'])->name("regulator.update");
        Route::get('/domain/list', [GovernanceController::class, 'domainDetails'])->name("domain.list");

        // exception
        Route::prefix('exception')->name('exception.')->group(function () {
            Route::get('/list', [ExceptionController::class, 'index'])->name('index');
            Route::get('show/{id}', [ExceptionController::class, 'show'])->whereNumber('id')->name('show');
            Route::get('/exceptions/{id}/{type?}', [ExceptionController::class, 'getExceptionData'])->name('getExceptionData');
            Route::get('/exceptions-notification', [ExceptionController::class, 'notificationsSettingsExceptions'])->name('notificationsSettingsExceptions');
            route::post('/update-request-status', [ExceptionController::class, 'updateRequestStatus'])->name('updateRequestStatus');
            Route::post('/store', [ExceptionController::class, 'store'])->name("store");
            Route::post('config/store', [ExceptionConfigController::class, 'store'])->name('config.store');
            Route::get('/get-frameworks/{regulator_id}', [ExceptionController::class, 'getFrameworks'])->name('get-frameworks');
            Route::get('/get-controls-by-framework/{framework_id}', [ExceptionController::class, 'getControlsByFramework'])->name('get-controls-by-framework');
            Route::get('/graph-view-exceptions', [ExceptionController::class, 'graphViewException'])->name('graphViewException');
            Route::post('/update/{id}', [ExceptionController::class, 'update'])->name('update');
        });
        Route::get('/run-framework/view', [SeederController::class, 'index'])->name('run-seeder');
        Route::post('/run-frame/create', [SeederController::class, 'runSeeder'])->name('run-seeder.create');
    }
);
