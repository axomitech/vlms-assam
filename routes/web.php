<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/register_user', [App\Http\Controllers\RegisterVlmsUser::class, 'registerUser'])->name('register_user');

//Auth::routes();
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
  ]);
Route::middleware(['auth'])->group(function () {
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/test', [App\Http\Controllers\HomeController::class, 'test'])->name('test');
    Route::get('/diarize/{receipt}/{legacy}', [App\Http\Controllers\LetterController::class, 'index'])->name('diarize');
    Route::get('/edit_diarize/{letter}', [App\Http\Controllers\LetterController::class, 'editDiarized'])->name('edit_diarize');
    Route::post('/edit_letter/{letter}', [App\Http\Controllers\LetterController::class, 'update'])->name('edit_letter');
    Route::get('/letters/{legacy}/{tab?}', [App\Http\Controllers\LetterController::class, 'showLetters'])->name('letters');
    //Route::get('/legacy_letters', [App\Http\Controllers\LetterController::class, 'showLegacyLetters'])->name('legacy_letters');
    Route::post('/store_letter', [App\Http\Controllers\LetterController::class, 'store'])->name('store_letter');
    Route::post('/change_stage', [App\Http\Controllers\LetterController::class, 'changeLetterStage'])->name('change_stage');
    Route::get('/action_letters', [App\Http\Controllers\LetterActionController::class, 'index'])->name('action_letters');
    Route::get('/letter_lists', [App\Http\Controllers\LetterActionController::class, 'letterIndex'])->name('letter_lists');
    Route::get('/actions/{id}', [App\Http\Controllers\LetterActionController::class, 'actions'])->name('actions');
    Route::get('/action_lists/{id}', [App\Http\Controllers\LetterActionController::class, 'letterActions'])->name('action_lists');
    Route::get('/action_notes', [App\Http\Controllers\LetterActionResponseController::class, 'actionNotes'])->name('action_notes');
    Route::post('/store_action', [App\Http\Controllers\LetterActionController::class, 'store'])->name('store_action');
    Route::post('/store_note', [App\Http\Controllers\LetterActionResponseController::class, 'store'])->name('store_note');
    Route::post('/store_response', [App\Http\Controllers\LetterActionResponseController::class, 'storeResponse'])->name('store_response');
    Route::post('/finalize_letter', [App\Http\Controllers\LetterActionController::class, 'finalizeActions'])->name('finalize_letter');
    Route::post('/send_action', [App\Http\Controllers\ActionSentController::class, 'store'])->name('send_action');
    Route::get('/session_user/{user}/{dept}/{role}', [App\Http\Controllers\SessionInitiationController::class, 'index'])->name('session_user');
    Route::get('/inbox/{id}', [App\Http\Controllers\ActionSentController::class, 'index'])->name('inbox');
    Route::get('/inbox_letters', [App\Http\Controllers\ActionSentController::class, 'inbox'])->name('inbox_letters');
    Route::get('/outbox', [App\Http\Controllers\ActionSentController::class, 'outbox'])->name('outbox');
    Route::get('/responds/{sent}/{act}/{letter}',[App\Http\Controllers\ActionSentController::class, 'response'])->name('responds');
    Route::get('/action_response',[App\Http\Controllers\ActionSentController::class, 'getActionResponses'])->name('action_response');
    Route::post('/assign_letter', [App\Http\Controllers\LetterAssignController::class, 'store'])->name('assign_letter');
    Route::get('/letter_sub_category',[App\Http\Controllers\LetterSubCategoryController::class, 'getLetterSubCategory'])->name('letter_sub_category');
    Route::get("/log", function(){
        Log::channel('i_love_this_logging_thing')->info("Action log debug test", ['log-string' => ['user'=>1], "run"]);
     
        return ["result" => true];
    });
    Route::get('/home1', [App\Http\Controllers\HomeController::class, 'box'])->name('home1');
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard-data', [App\Http\Controllers\DashboardController::class, 'dashboard_data'])->name('dashboard-data');
    Route::get('/receipt_box', [App\Http\Controllers\DashboardController::class, 'receipt_box'])->name('receipt_box');
    Route::get('/issue_box', [App\Http\Controllers\DashboardController::class, 'issue_box'])->name('issue_box');
    Route::get('/action_box', [App\Http\Controllers\DashboardController::class, 'action_box'])->name('action_box');
    Route::get('/action/{category_id}', [App\Http\Controllers\DashboardController::class, 'fetchActionByCategory'])->name('action_by_category');
    Route::get('/receipt/{category_id}', [App\Http\Controllers\DashboardController::class, 'fetchReceiptByCategory'])->name('receipt_by_category');
    Route::get('/receipt_box', [App\Http\Controllers\DashboardController::class, 'receipt_box'])->name('receipt_box');
    Route::get('/issue/{category_id}', [App\Http\Controllers\DashboardController::class, 'fetchIssueByCategory'])->name('issue_by_category');

    //Report Controller
    Route::get('/report', [App\Http\Controllers\ReportController::class, 'cat_wise_diarize_assign_forwarded'])->name('reports');
    Route::get('/getCategoryData', [App\Http\Controllers\ReportController::class, 'getCategoryData']);
    Route::get('/getCategoryReport', [App\Http\Controllers\ReportController::class, 'report_by_category'])->name('report_by_category');


    Route::get('/pdf_genarator/{id}', [App\Http\Controllers\PDFController::class, 'generatePDF'])->name('pdf_genarator');
    Route::get('/pdf_downloadAll/{id}', [App\Http\Controllers\PDFController::class, 'downloadAll'])->name('pdf_downloadAll');
    Route::get('/acknowledge_email/{id}', [App\Http\Controllers\AcknowledgeController::class, 'index'])->name('acknowledge_email');
    Route::get('/acknowledge_letter/{id}', [App\Http\Controllers\AcknowledgeController::class, 'ack_letter_generation'])->name('acknowledge_letter');
    Route::post('/acknowledge_letter', [App\Http\Controllers\AcknowledgeController::class, 'ack_letter_save'])->name('submit.ackLetter');
    Route::post('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('submit.search');
    Route::post('/store_correspondence', [App\Http\Controllers\AcknowledgeController::class, 'store_correspondence'])->name('store_correspondence');
    Route::get('/correspondences/{id}', [App\Http\Controllers\AcknowledgeController::class, 'show_correspondence'])->name('correspondences');
    Route::post('/remove_correspondences', [App\Http\Controllers\AcknowledgeController::class, 'remove_correspondence'])->name('remove_correspondences');
    Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');
    Route::get('/user', [App\Http\Controllers\AdminController::class, 'show_user'])->name('user');
    Route::post('/user/add', [App\Http\Controllers\AdminController::class, 'add_user'])->name('user.add');
    Route::post('/user/edit', [App\Http\Controllers\AdminController::class, 'edit_user'])->name('user.edit');
    Route::post('/user/default/access', [App\Http\Controllers\AdminController::class, 'default_access'])->name('user.default.access');

    Route::get('/department/view', [App\Http\Controllers\AdminController::class, 'show_department'])->name('department.index');
    Route::post('/department/add', [App\Http\Controllers\AdminController::class, 'add_department'])->name('department.add');   
    Route::post('/department/edit', [App\Http\Controllers\AdminController::class, 'edit_department'])->name('department.edit');   
    Route::get('/file_view', [App\Http\Controllers\FilePreviewController::class, 'index'])->name('file_view');
});



