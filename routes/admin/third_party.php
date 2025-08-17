<?php

use App\Http\Controllers\admin\third_party\ThirdPartyConfigrationController;
use App\Http\Controllers\admin\third_party\ThirdPartyRequestController as RequestsController;
use App\Http\Controllers\admin\third_party\ThirdPartyProfileController as ProfilesController;
use App\Http\Controllers\admin\third_party\ThirdPartyQuestionnaireController;
use App\Http\Controllers\admin\third_party\ThirdPartyQuestionnaireResultController;
use App\Http\Controllers\admin\third_party\ThirdPartyReportController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin third-party routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => 'third_party', // Prefix applied on all `third_party` group routes
        'middleware' => [], // Middlewares applied on all `third_party` group routes
        'as' => 'third_party.'
    ],
    function () {
        // requests
        Route::get('/requests', [RequestsController::class, 'index'])->name('requests');
        Route::post('/requests/create', [RequestsController::class, 'create'])->name('createRequest');
        Route::get('/requests/getRequest/{request_id}', [RequestsController::class, 'getRequest'])->name('getRequest');
        Route::get('/requests/getUserDetailsFromId/{user_id}', [RequestsController::class, 'getUserDetailsFromId'])->name('getUserDetailsFromId');
        Route::delete('/requests/delete/{request_id}', [RequestsController::class, 'delete'])->name('deleteRequest');
        Route::put('/requests/update/{request_id}', [RequestsController::class, 'update'])->name('updateRequest');
        Route::get('/requests/getForm/{type}/{request_id?}', [RequestsController::class, 'getForm'])->name('getRequestForm');
        Route::get('/requests/view/{request_id}', [RequestsController::class, 'view'])->name('viewRequest');
        // Route::get('/requests/configuretion', [ProfilesController::class, 'configure'])->name('requests.configuretion');
        Route::put('/requests/reject_request/{request_id}', [RequestsController::class, 'rejectRequest'])->name('rejectRequest');

        // profiles
        Route::get('/profiles', [ProfilesController::class, 'index'])->name('profiles');
        Route::get('/profiles/getForm/{type}/{profile_id?}', [ProfilesController::class, 'getForm'])->name('getProfileForm');
        Route::post('/profiles/create', [ProfilesController::class, 'create'])->name('saveProfile');
        Route::delete('/profiles/delete/{profile_id}', [ProfilesController::class, 'delete'])->name('deleteProfile');
        Route::get('/profiles/view/{profile_id}', [ProfilesController::class, 'view'])->name('viewProfile');
        Route::get('/profiles/configuretion', [ProfilesController::class, 'configure'])->name('profiles.configuretion');
        // Route::get('/profiles/getProfile/{profile_id}', [ProfilesController::class, 'getProfile'])->name('getProfile');
        Route::put('/profiles/update/{profile_id}', [ProfilesController::class, 'update'])->name('updateProfile');

        // questionnaires
        Route::get('/questionnaires', [ThirdPartyQuestionnaireController::class, 'index'])->name('questionnaires');
        Route::get('/questionnaires/getForm/{type}/{id}', [ThirdPartyQuestionnaireController::class, 'getForm'])->name('getQuestionnairesForm');
        Route::post('/questionnaires/send_questionnaire/{request_id}', [ThirdPartyQuestionnaireController::class, 'createQuestionnaire'])->name('createQuestionnaire');
        Route::get('/questionnaires/view/{questionnaire_id}', [ThirdPartyQuestionnaireController::class, 'viewQuestionnaire'])->name('viewQuestionnaire');
        Route::post('/questionnaires/send_mail/{questionnaire_id}', [ThirdPartyQuestionnaireController::class, 'sendEmail'])->name('sendEmail');
        Route::put('/questionnaires/updateQuestionnaire/{questionnaire_id}', [ThirdPartyQuestionnaireController::class, 'updateQuestionnaire'])->name('updateQuestionnaire');
        Route::delete('/questionnaires/deleteQuestionnaire/{questionnaire_id}', [ThirdPartyQuestionnaireController::class, 'deleteQuestionnaire'])->name('deleteQuestionnaire');

        // questionnaires results
        Route::get('/questionnaires/results', [ThirdPartyQuestionnaireResultController::class, 'index'])->name('questionnairesResults');
        Route::get('/questionnaires/results/view/{questionnaire_answer_id}', [ThirdPartyQuestionnaireResultController::class, 'view'])->name('viewQuestionnaireAnswer');
        Route::put('/questionnaires/results/update_status/{questionnaire_answer_id}', [ThirdPartyQuestionnaireResultController::class, 'updateStatus'])->name('updateQuestionnaireAnswerStatus');


        // configrations
        Route::get('/config', [ThirdPartyConfigrationController::class, 'index'])->name('config');
        Route::get('/config/fetchRecordsByTable', [ThirdPartyConfigrationController::class, 'fetchRecordsByTable'])->name('config.fetchRecordsByTable');
        Route::post('/config/saveRecordsByTable', [ThirdPartyConfigrationController::class, 'saveRecordsByTable'])->name('config.saveRecordsByTable');
        Route::put('/config/updateRecordsByTable', [ThirdPartyConfigrationController::class, 'updateRecordsByTable'])->name('config.updateRecordsByTable');
        Route::delete('/config/deleteRecordsByTable', [ThirdPartyConfigrationController::class, 'deleteRecordsByTable'])->name('config.deleteRecordsByTable');

        // reports
        Route::get('/reports', [ThirdPartyReportController::class, 'index'])->name('reports');
        Route::get('/reports/profiles/{profile_id}', [ThirdPartyReportController::class, 'getProfileCharts'])->name('getProfileCharts');
        Route::get('/reports/departments/{department_id}', [ThirdPartyReportController::class, 'getDepartmentsCharts'])->name('getDepartmentsCharts');

    }
);

// answers of questionnaires outside of grc
Route::get('/cyber_mode/third_party/questionnaires/{questionnaire_id}', [ThirdPartyQuestionnaireController::class, 'viewAnswer'])
    ->name('viewAnswer')->withoutMiddleware('auth');
Route::post('/cyber_mode/third_party/questionnaires/saveAnswers/{questionnaire_id}', [ThirdPartyQuestionnaireController::class, 'saveAnswers'])
    ->name('third_party.saveAnswers')->withoutMiddleware('auth');
