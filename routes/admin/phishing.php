<?php

use App\Http\Controllers\admin\KPI\KPIController;
use App\Http\Controllers\admin\phishing\PhishingCampaignController;
use App\Http\Controllers\admin\phishing\PhishingCategoryController;
use App\Http\Controllers\admin\phishing\PhishingDashboardController;
use App\Http\Controllers\admin\phishing\PhishingDomainsController;
use App\Http\Controllers\admin\phishing\PhishingEmployeeListController;
use App\Http\Controllers\admin\phishing\PhishingGroupController;
use App\Http\Controllers\admin\phishing\PhishingLandingPageController;
use App\Http\Controllers\admin\phishing\PhishingSenderProfileController;
use App\Http\Controllers\admin\phishing\PhishingTemplateController;
use App\Http\Controllers\admin\phishing\PhishingWebsiteController;
use App\Http\Controllers\admin\phishing\PhishingWebsitePageController;
use App\Mail\SendTestMail;
use App\Models\PhishingTemplate;
use App\Models\PhishingWebsitePage;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin Phishing routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'phishing','as' => 'phishing.'],function () {

    // Phishing Domains => Author : Khaled
    Route::get('domains', [PhishingDomainsController::class, 'index'])->name("domains.index");
    Route::post('domains/store', [PhishingDomainsController::class, 'store'])->name("domains.store");
    Route::post('domains/update/{id}', [PhishingDomainsController::class, 'update'])->name("domains.update");
    Route::get('domain-profile/{id}', [PhishingDomainsController::class,'getProfiles'])->name('domain.profiles');
    Route::get('domain-profile-dataTable/{id}', [PhishingDomainsController::class,'getProfilesDataTable'])->name('domain.getProfilesDataTable');
    Route::get('archived-domains', [PhishingDomainsController::class,'getArchivedDomains'])->name('archivedDomains');
    Route::post('domain-trash/{id}', [PhishingDomainsController::class,'trash'])->name('domains.trash');
    Route::post('domain-restore/{id}', [PhishingDomainsController::class,'restore'])->name('domains.restore');
    Route::delete('domain-delete/{id}', [PhishingDomainsController::class,'delete'])->name('domains.delete');

    // Phishing Category => => Author : El Hadary
    Route::get('phishingcategory', [PhishingCategoryController::class, 'getAll'])->name('phishingcategory.getAll');
    Route::post('phishingcategory/store', [PhishingCategoryController::class, 'store'])->name('phishingcategory.store');
    Route::post('phishingcategory/update/{id}', [PhishingCategoryController::class, 'update'])->name('phishingcategory.update');
    Route::get('archived-categories', [PhishingCategoryController::class,'getArchivedCategories'])->name('archivedCategories');
    Route::post('category-trash/{id}', [PhishingCategoryController::class,'trash'])->name('categories.trash');
    Route::post('category-restore/{id}', [PhishingCategoryController::class,'restore'])->name('categories.restore');
    Route::delete('category-delete/{id}', [PhishingCategoryController::class,'delete'])->name('category.delete');
    Route::get('getCategoryWebsites/{id}', [PhishingCategoryController::class,'getCategoryWebsites'])->name('getCategoryWebsites');


    // Phishing Sender Profile => Author : Khaled
    Route::get('senderProfile', [PhishingSenderProfileController::class, 'index'])->name("senderProfile.index");
    Route::get('PhishingSenderProfileDatatable', [PhishingSenderProfileController::class, 'PhishingSenderProfileDatatable'])->name("senderProfile.PhishingSenderProfileDatatable");
    Route::post('senderProfile/store', [PhishingSenderProfileController::class, 'store'])->name("senderProfile.store");
    Route::post('senderProfile/update/{id}', [PhishingSenderProfileController::class, 'update'])->name("senderProfile.update");
    Route::get('archived-senderProfile', [PhishingSenderProfileController::class,'getArchivedSenderProfile'])->name('senderProfile.archivedsenderProfile');
    Route::get('archivedSenderProfileDatatable', [PhishingSenderProfileController::class, 'archivedSenderProfileDatatable'])->name("senderProfile.archivedSenderProfileDatatable");
    Route::post('senderProfile-trash/{id}', [PhishingSenderProfileController::class,'trash'])->name('senderProfile.trash');
    Route::post('senderProfile-restore/{id}', [PhishingSenderProfileController::class,'restore'])->name('senderProfile.restore');
    Route::delete('senderProfile-delete/{id}', [PhishingSenderProfileController::class,'delete'])->name('senderProfile.delete');


    // Phishing Website Pages => Author : El Hadary
    Route::get('websites', [PhishingWebsitePageController::class, 'getAll'])->name('website.getAll');
    Route::post('website/store', [PhishingWebsitePageController::class, 'store'])->name('website.store');
    Route::get('website/{id}/edit', [PhishingWebsitePageController::class, 'edit'])->name('website.edit');
    Route::put('website/update/{id}', [PhishingWebsitePageController::class, 'update'])->name('website.update');
    Route::get('archived-websites', [PhishingWebsitePageController::class,'getArchivedWebsites'])->name('archivedWebsites');
    Route::post('website-trash/{id}', [PhishingWebsitePageController::class,'trash'])->name('website.trash');
    Route::post('website-restore/{id}', [PhishingWebsitePageController::class,'restore'])->name('website.restore');
    Route::delete('website-delete/{id}', [PhishingWebsitePageController::class,'delete'])->name('website.delete');
    Route::get('/website/search', [PhishingWebsitePageController::class, 'search'])->name('website.search');
    Route::get('/website/searchTrash', [PhishingWebsitePageController::class, 'searchTrash'])->name('website.searchTrash');
    Route::get('edit/{id}', [PhishingWebsitePageController::class, 'edit'])->name('website.edit');
    Route::post('website/test-action', [PhishingWebsitePageController::class,'testAction'])->name('test-action');

    // Phishing Landing Pages => Author : El Hadary
    Route::get('landingpages', [PhishingLandingPageController::class, 'getAll'])->name('landingpages.getAll');
    Route::post('landingpage/store', [PhishingLandingPageController::class, 'store'])->name('landingpage.store');
    Route::post('landingpage/update/{id}', [PhishingLandingPageController::class, 'update'])->name('landingpage.update');
    Route::get('archived-landingpages', [PhishingLandingPageController::class,'getArchivedlandingpages'])->name('archivedlandingpages');
    Route::post('landingpage-trash/{id}', [PhishingLandingPageController::class,'trash'])->name('landingpage.trash');
    Route::post('landingpage-restore/{id}', [PhishingLandingPageController::class,'restore'])->name('landingpage.restore');
    Route::delete('landingpage-delete/{id}', [PhishingLandingPageController::class,'delete'])->name('landingpage.delete');
    Route::get('/landingpage/search', [PhishingLandingPageController::class, 'search'])->name('landingpage.search');
    Route::get('/landingpage/searchTrash', [PhishingLandingPageController::class, 'searchTrash'])->name('landingpage.searchTrash');
    Route::get('edit/{id}', [PhishingLandingPageController::class, 'edit'])->name('landingpage.edit');
    Route::get('landingpage/show/{id}', [PhishingLandingPageController::class,'show'])->name('landingpage.show');
    Route::post('/landingpage/duplicate/{id}', [PhishingLandingPageController::class, 'duplicate'])->name('landingpage.duplicate');

    // Phishing Email Template  => Author : Khaled
    Route::get('emailTemplate', [PhishingTemplateController::class, 'index'])->name("emailTemplate.index");
    Route::post('emailTemplate/store', [PhishingTemplateController::class, 'store'])->name("emailTemplate.store");
    Route::get('emailTemplate-show/{id}', [PhishingTemplateController::class, 'show'])->name("emailTemplate.show");
    Route::get('emailTemplate-edit/{id}', [PhishingTemplateController::class, 'edit'])->name("emailTemplate.edit");
    Route::put('emailTemplate/update/{id}', [PhishingTemplateController::class, 'update'])->name("emailTemplate.update");
    Route::post('emailTemplate-trash/{id}', [PhishingTemplateController::class,'trash'])->name('emailTemplate.trash');
    Route::get('archived-emailTemplate', [PhishingTemplateController::class,'getArchivedemailTemplate'])->name('emailTemplate.archivedemailTemplate');
    Route::post('emailTemplate-restore/{id}', [PhishingTemplateController::class,'restore'])->name('emailTemplate.restore');
    Route::delete('emailTemplate-delete/{id}', [PhishingTemplateController::class,'delete'])->name('emailTemplate.delete');

    Route::post('emailTemplate/upload-file', [PhishingTemplateController::class, 'uploadFile'])->name('emailTemplate.upload.file');
    Route::post('emailTemplate/upload-image', [PhishingTemplateController::class, 'uploadImage'])->name('emailTemplate.upload.image');

    // Phishing Campaign  => Author : Khaled
    Route::get('campaign', [PhishingCampaignController::class, 'index'])->name("campaign.index");
    // Route::get('PhishingCampaignDatatable', [PhishingCampaignController::class, 'PhishingCampaignDatatable'])->name("campaign.Datatable");
    Route::get('PhishingCampaignDatatable/{type}', [PhishingCampaignController::class, 'PhishingCampaignDatatable'])->name("campaign.Datatable");
    Route::post('validateFirstStep', [PhishingCampaignController::class, 'validateFirstStep'])->name("campaign.validateFirstStep");
    Route::post('validateEditFirstStep/{campaign}', [PhishingCampaignController::class, 'validateEditFirstStep'])->name("campaign.validateEditFirstStep");
    Route::post('campaign-trash/{id}', [PhishingCampaignController::class,'trash'])->name('campaign.trash');
    Route::post('campaign-approve/{id}', [PhishingCampaignController::class,'approve'])->name('campaign.approve');
    Route::post('campaign-sendLaterMail/{id}', [PhishingCampaignController::class,'sendLaterMail'])->name('campaign.sendLaterMail');
    Route::get('archived-campaign', [PhishingCampaignController::class,'getArchivedcampaign'])->name('campaign.archivedcampaign');
    Route::get('archivedCampaignDatatable', [PhishingCampaignController::class, 'archivedCampaignDatatable'])->name("campaign.archivedCampaignDatatable");
    Route::post('campaign-restore/{id}', [PhishingCampaignController::class,'restore'])->name('campaign.restore');
    Route::delete('campaign-delete/{id}', [PhishingCampaignController::class,'delete'])->name('campaign.delete');
    Route::get('campaign-edit/{id}', [PhishingCampaignController::class, 'edit'])->name("campaign.edit");
    Route::put('campaign/update/{id}', [PhishingCampaignController::class, 'update'])->name("campaign.update");
    Route::post('campaign-employees', [PhishingCampaignController::class, 'getCampaignEmployees'])->name("campaign.employees");
    Route::get('campaign-emailTemplate/{id}', [PhishingCampaignController::class, 'getEmailTemplateData'])->name("campaign.emailTemplateData");
    Route::get('campaign-getCampaignData/{id}', [PhishingCampaignController::class, 'getCampaignData'])->name("campaign.getCampaignData");
    Route::get('campaign-training-getCampaignData/{id}', [PhishingCampaignController::class, 'getEmployeeOfTrainingCampaign'])->name("campaign.getEmployeeOfTrainingCampaign");
    Route::get('campaign-getPhisedEmployee', [PhishingCampaignController::class, 'getPhisedEmployeeDataTable'])->name("campaign.getPhisedEmployee");
    Route::get('campaign-getTrainingEmployee', [PhishingCampaignController::class, 'getTrainingEmployeeDataTable'])->name("campaign.getTrainingEmployee");

    Route::get('phishingNotification', [PhishingCampaignController::class, 'phishingNotification'])->name("phishingNotification");


    // Training Data Table
    Route::get('campaign-getActiveTrainingCampaignData', [PhishingCampaignController::class, 'getActiveTrainingCampaignData'])->name("campaign.getActiveTrainingCampaignData");
    Route::get('campaign-getArchivedTrainingCampaignData', [PhishingCampaignController::class, 'getArchivedTrainingCampaignData'])->name("campaign.getArchivedTrainingCampaignData");

    // Phishing Data Table
    Route::get('campaign-getActivePhishingDataTable', [PhishingCampaignController::class, 'getActivePhishingDataTable'])->name("campaign.getActivePhishingDataTable");
    Route::get('campaign-getArchivedPhishingDataTable', [PhishingCampaignController::class, 'getArchivedPhishingDataTable'])->name("campaign.getArchivedPhishingDataTable");


    // Employee Phishing & Training Table
    Route::get('campaign-getEmployeePhishingDataTable/{id}', [PhishingCampaignController::class, 'getEmployeePhishingDataTable'])->name("campaign.getEmployeePhishingDataTable");
    Route::get('campaign-getEmployeeTrainingCampaignData/{id}', [PhishingCampaignController::class, 'getEmployeeTrainingCampaignData'])->name("campaign.getEmployeeTrainingCampaignData");

    // sendTestEmail
    Route::get('sendTestEmail/{campaingId}', [PhishingCampaignController::class, 'sendTestEmail'])->name("campaign.sendTestEmail");


    // ===========================  Certificates ======================
    Route::get('Certificates', [PhishingCampaignController::class, 'Certificates'])->name("campaign.Certificates");
    Route::get('listCertificatesAjax', [PhishingCampaignController::class, 'listCertificatesAjax'])->name("campaign.listCertificatesAjax");
    Route::get('{lMSTrainingModule}/users/{user}/certificate/view', [PhishingCampaignController::class, 'viewCertificate'])
        ->name('campaign.view-certificate');
    Route::get('{lMSTrainingModule}/users/{user}/certificate/download', [PhishingCampaignController::class, 'downloadCertificate'])
        ->name('campaign.download-certificate');
    Route::delete('{lMSTrainingModule}/certificates/{certificate}', [PhishingCampaignController::class, 'deleteCertificate'])
        ->name('campaign.delete-certificate');
    // =========================================================

    // Phishing Group => Author : Hadary
    Route::get('groups', [PhishingGroupController::class, 'getAll'])->name("groups.getAll");
    Route::get('groupsDatatable', [PhishingGroupController::class, 'PhishingGroupeDatatable'])->name("groups.PhishingGroupeDatatable");
    Route::post('groups/store', [PhishingGroupController::class, 'store'])->name("groups.store");
    Route::post('groups/update/{id}', [PhishingGroupController::class, 'update'])->name("group.update");
    Route::get('archived-groups', [PhishingGroupController::class,'getArchivedGroups'])->name('groups.getArchivedGroups');
    Route::get('archivedGroupsDatatable', [PhishingGroupController::class, 'archivedGroupsDatatable'])->name("groups.archivedGroupsDatatable");
    Route::post('groups-trash/{id}', [PhishingGroupController::class,'trash'])->name('group.trash');
    Route::post('groups-restore/{id}', [PhishingGroupController::class,'restore'])->name('group.restore');
    Route::delete('groups-delete/{id}', [PhishingGroupController::class,'delete'])->name('group.delete');
    Route::post('AddUsersTogroup', [PhishingGroupController::class,'AddUsersTogroup'])->name('group.AddUsersTogroup');
    Route::get('/group/users/{id}', [PhishingGroupController::class, 'getUsersForGroup'])->name('group.getUsersForGroup');


    // Author : Khaled
    Route::get('send-test-mail/{id}',function($id){
        $emailData = PhishingTemplate::find($id);
        $employee = User::find(1);
        return view('emails.phishing.email',compact('emailData','employee'));
        try {
           Mail::to('eldoon2141996@mail.com')->send(new SendTestMail($mailData));
           return "Email sent successfully To Elhadary !";
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    });


    // // Route for tracking email opens
    // Route::get('mail-opened', [PhishingCampaignController::class, 'mailOpened'])->name('mail.opened');
    // // Route for form submissions
    // Route::get('mailForm-submited', [PhishingCampaignController::class, 'mailFormSubmited'])->name('mailForm.submited');
    // // Route for attachment downloads
    // Route::get('mail-attachments', [PhishingCampaignController::class, 'mailAttachmentDownloaded'])->name('mailAttachments.download');


    // Phishing Statistics
    Route::get('phishing-dashbord', [PhishingDashboardController::class,'index'])->name('dashboard');
    Route::get('phishing-reporting', [PhishingDashboardController::class,'reporting'])->name('reporting');
    Route::get('training-reporting', [PhishingDashboardController::class,'trainingReporting'])->name('training-reporting');

    Route::get('Test-new-Domain/{id}', function ($id) {
        $website = PhishingWebsitePage::with('domain')->find($id);
        if($website->domain()->exists()){
            $subdomain = $website->from_address_name;
            $domain = ltrim($website->domain->name, '@');
            $dynamicUrl = "https://{$subdomain}.{$domain}/{$website->id}";
        }else{
            $domain = $website->from_address_name;
            $dynamicUrl = "https://{$domain}/{$website->id}";
        }
        return redirect()->away($dynamicUrl);
    })->name('website-page-as-new-domain');

    // Route::domain('{subdomain}.{domain}')->group(function () {
    //     Route::get('{id}', function ($id) {
    //         $website = PhishingWebsitePage::find($id);
    //         return view('admin.content.phishing.websites.website', get_defined_vars());
    //     });
    // });
    Route::get('test_hamam_mail',function(){
        dd("yes");
    })->name('mail.hamam');


});




// ************************* Just For Test On Servers By ( Khaled ) *****************************
Route::group(['prefix' => 'khaled-setting'],function () {
    Route::get('empty-prefixes-tables/{prefix}',function($prefix){
        // Get all table names
        $tables = DB::select('SHOW TABLES');
        $dbName = DB::getDatabaseName();
        // dd($dbName);
        $key = "Tables_in_$dbName"; // The key to access table names
        foreach ($tables as $table) {
            $tableName = $table->$key;
            // Check if the table name starts with 'phishing_'
            if (strpos($tableName, $prefix) === 0) {
                // Truncate the table
                DB::table($tableName)->delete();
                echo "Emptied table: $tableName<br>";
            }
        }
    });

    Route::get('empty-specific-table/{tableName}', function ($tableName) {
        try {
            // Check if the table exists
            if (!Schema::hasTable($tableName)) {
                return response()->json(['error' => 'Table does not exist.'], 404);
            }
            // Truncate the table
            DB::table($tableName)->delete();
            return response()->json(['success' => "Data from table '$tableName' has been deleted."], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });

    Route::get('get-specific-table-data/{tableName}', function ($tableName) {
        try {
            // Check if the table exists
            if (!Schema::hasTable($tableName)) {
                return response()->json(['error' => 'Table does not exist.'], 404);
            }
            // Get the data from the table
            $data = DB::table($tableName)->get();
            return response()->json([
                'table' => $tableName,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });

    Route::get('/run-seeder/{seeder}', function ($seeder) {
        try {
            // Run the specific seeder
            Artisan::call('db:seed', [
                '--class' => $seeder,
            ]);

            return response()->json([
                'status' => true,
                'message' => "Seeder {$seeder} has been run successfully.",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Error running seeder: " . $e->getMessage(),
            ], 500);
        }
    });

    Route::get('/clear-cache', function () {
        try {
            Artisan::call('optimize:clear');
            return response()->json(['message' => 'Cache cleared successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to clear cache', 'details' => $e->getMessage()], 500);
        }
    });

});

